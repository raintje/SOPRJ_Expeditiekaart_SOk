<?php

namespace App\Http\Controllers;

use App\Http\Helpers\BDEncoder;
use App\Http\Requests\LayerItemEditRequest;
use App\Http\Requests\LayerItemStoreRequest;
use App\Models\File;
use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use App\Models\LayerItemsLayerItems;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class LayerItemController extends Controller
{

    public function index()
    {
        return view('items.index', [
            'items' => LayerItem::all()
        ]);
    }

    public function create()
    {
        $this->AuthorizeRole();

        return view('items.create', [
            'existingItems' => LayerItem::all(),
        ]);
    }

    public function store(LayerItemStoreRequest $request)
    {
        $this->AuthorizeRole();
        $request->validated();

        $layerItem = LayerItem::create([
            'title' => $request->input('title'),
            'body' => $request->input('title'),
            'level' => $request->input('level')
        ]);

        $this->StoreFirstLayer($layerItem);
        $this->syncLinkedItems($request, $layerItem);
        $this->SaveFiles($request, $layerItem);

        return redirect()->route('items');
    }

    public function show($id, $breadcrumb = '')
    {
        $item = LayerItem::findOrFail($id);

        $BDitems = BDEncoder::decode($breadcrumb);
        array_push($BDitems, $item);
        $newBreadcrumb = BDEncoder::encode($BDitems);

        return view('items.show', [
            'item' => $item,
            'files' => File::where('layer_item_id', $id)->get(),
            'linkedItems' => $item->referencesLayerItems,
            'histories' => $item->histories()->orderBy('performed_at', 'desc')->get(),
            'breadcrumb' => $newBreadcrumb,
        ]);
    }


    public function edit($id)
    {
        $item = LayerItem::findOrFail($id);
        $this->AuthorizeRole($item->id);

        return view('items.edit', [
            'item' => $item,
            'files' => File::where('layer_item_id', $id)->get(),
            'linkedItems' => $item->referencesLayerItems,
            'existingItems' => LayerItem::all()->except($id),
        ]);
    }

    public function update(LayerItemEditRequest $request, $id)
    {
        $layerItem = LayerItem::findOrFail($id);
        $this->AuthorizeRole($layerItem->id);

        $request->validated();

        $layerItem->title = $request->input('title');
        $layerItem->body = $request->input('body');
        $layerItem->level = $request->input('level');
        $layerItem->save();

        $this->UpdateFirstLayer($layerItem);
        $this->syncLinkedItems($request, $layerItem);
        $this->UpdateFiles($request, $layerItem);
        $this->layerLevelCascade($layerItem);

        return redirect()->route('show.item', $id);
    }



    public function destroy($id)
    {
        $this->AuthorizeRole($id);

        $layerItem = LayerItem::findOrFail($id);
        $firstLayerItem = FirstLayerItem::where('layer_item_id', $id);

        foreach (File::where('layer_item_id', $id) as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        if ($firstLayerItem != null) {
            $firstLayerItem->delete();
        }

        $layerItem->delete($id);

        if (LayerItem::find($id) != null) {
            return redirect()->route('show.item', $id);
        }

        return view('items.confirmedDelete');
    }

    public function updateBreadcrumb($id, $breadcrumb, $bdItem)
    {
        $items = BDEncoder::decode($breadcrumb);
        $reItems = [];

        for ($i = 0; $i < $bdItem; $i++) {
            array_push($reItems, $items[$i]);
        }

        $breadcrumb = BDEncoder::encode($reItems);

        if (strlen($breadcrumb) > 0) {
            return redirect()->route('breadcrumb.add', ['id' => $id, 'breadcrumb' => $breadcrumb]);
        }

        return redirect()->route('show.item', ['id' => $id]);
    }


    public function downloadFile($id)
    {
        $databaseFile = File::findOrFail($id);

        if (!Storage::disk('public')->exists(($databaseFile->path))) {
            abort(404);
        }

        return Storage::disk('public')->download($databaseFile->path);
    }

    public function deleteLayerItemAppendix($id, $fileId)
    {
        $this->AuthorizeRole($id);
        $file = File::findOrFail($fileId);
        Storage::disk('public')->delete($file->path);
        $file->delete();
        return redirect()->route('edit.item', ['id' => $id]);
    }

    public function deleteLinkedLayerItem($id, $linkedItemId)
    {
        $this->AuthorizeRole($id);
        $link = LayerItemsLayerItems::where(['layer_item_id' => $id, 'linked_layer_item_id' => $linkedItemId])->first();
        if ($link != null) {
            $link->delete();
        }

        return redirect()->route('edit.item', ['id' => $id]);
    }

    public function editLocation()
    {
        return view('items.edit_location');
    }

    public function getItems(Request $request)
    {
        if ($request->ajax()) {
            $data = LayerItem::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return " <div  class='d-flex'><a style='min-width:65px; margin-left:4px'  href='" . route('show.item', $row->id) . "' class=' btn btn-info btn-xs pl-2'>Bekijken</a></div>";
                })
                ->rawColumns(['action', 'body'])
                ->make(true);
        }
        return null;
    }

    /**
     * @param LayerItemStoreRequest $request
     * @param LayerItem $layerItem
     */
    public function SaveFiles(LayerItemStoreRequest $request, LayerItem $layerItem): void
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $formFile) {
                $name = time() . '_' . $formFile->getClientOriginalName();
                $filePath = $formFile->storeAs('files', $name, 'public');

                $file = new File();
                $file->layer_item_id = $layerItem->id;
                $file->title = $name;
                $file->type = $formFile->getClientOriginalExtension();
                $file->path = $filePath;
                $file->save();
            }
        }
    }

    /**
     * @param FormRequest $request
     * @param LayerItem $layerItem
     */
    public function syncLinkedItems(FormRequest $request, LayerItem $layerItem): void
    {
        if (isset($request->itemLinks)) {
            $layerItem->referencesLayerItems()->sync($request->itemLinks);
        }
    }

    /**
     * @param LayerItem $layerItem
     */
    public function StoreFirstLayer(LayerItem $layerItem): void
    {
        if ($layerItem->level != 1) return;

        FirstLayerItem::create([
            'layer_item_id' => $layerItem->id,
            'x_pos' => rand(120, 750),
            'y_pos' => rand(320, 620)
        ]);
    }


    /**
     * @param LayerItem $layerItem
     */
    public function UpdateFirstLayer(LayerItem $layerItem): void
    {
        $firstLayer = FirstLayerItem::where('layer_item_id', $layerItem->id)->first();

        if ($layerItem->level == 1) {
            if ($firstLayer) return;
            $this->StoreFirstLayer($layerItem);
        }

        if ($layerItem->level != 1) {
            if (!$firstLayer) return;
            $firstLayer->delete($firstLayer->id);
        }
    }

    /**
     * @param LayerItemEditRequest $request
     * @param $layerItem
     */
    public function UpdateFiles(LayerItemEditRequest $request, $layerItem): void
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $formFile) {
                $name = time() . '_' . $formFile->getClientOriginalName();
                $filePath = $formFile->storeAs('files', $name, 'public');

                $file = new File();
                $file->layer_item_id = $layerItem->id;
                $file->title = $name;
                $file->type = $formFile->getClientOriginalExtension();
                $file->path = $filePath;
                $file->save();
            }
        }
    }

    /**
     * @param LayerItemStoreRequest $request
     */
    public function AuthorizeRole($item = null)
    {
        if ($item != null) {
            if (!Auth::user()->can('layerItem.edit.' . $item)) {
                abort(403);
            }
        } else {
            if (!Auth::user()->can('layerItem.edit.*')) {
                abort(403);
            }
        }
    }

    /**
     * @param LayerItem $request
     */
    public function layerLevelCascade(LayerItem $layeritem)
    {
        $id = $layeritem->id;

        foreach (LayerItemsLayerItems::where('layer_item_id', $id)->get() as $LayerItemLinks) {
            if ($LayerItemLinks->linkedLayerItem->level != ($layeritem->level + 1)) {
                $LayerItemLinks->delete();
            }
        }

        foreach (LayerItemsLayerItems::where('linked_layer_item_id', $id)->get() as $LayerItemLinks) {
            if ($LayerItemLinks->layerItem->level != ($layeritem->level - 1)) {
                $LayerItemLinks->delete();
            }
        }
    }
}
