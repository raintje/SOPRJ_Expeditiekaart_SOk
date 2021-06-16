<?php

namespace App\Http\Controllers;

use App\Http\Helpers\BDEncoder;
use App\Http\Requests\LayerItemEditRequest;
use App\Http\Requests\LayerItemStoreRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use App\Models\LayerItemsLayerItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class LayerItemController extends Controller
{

    public function index()
    {
        $items = LayerItem::all();
        return view('items.index', ['items' => $items]);
    }

    public function create()
    {
        $this->AuthorizeRole();
        $items = LayerItem::all();
//        $categories = Category::all();
        return view('items.create', ['existingItems' => $items]);
    }

    public function store(LayerItemStoreRequest $request)
    {
        $this->AuthorizeRole();
        $body = $request->input('body');

        $layerItem = new LayerItem();
        $layerItem->title = $request->input('title');
        $layerItem->body = $body;
        $layerItem->save();

        $this->SaveCategories($request, $layerItem);

        $this->SaveLinks($request, $layerItem);

        $this->SaveFiles($request, $layerItem);

        return redirect()->route('items');
    }

    public function show($id, $breadcrumb = '')
    {
        $item = LayerItem::findOrFail($id);
        $histories = $item->histories()->orderBy('performed_at', 'desc')->get();
        $categories = null;

        $firstLayerItem = FirstLayerItem::with('categories')->where('layer_item_id', $id)->first();

        if ($firstLayerItem != null) {
            $categories = $firstLayerItem->categories;
        }

        $files = File::where('layer_item_id', $id)->get();
        $linkedItems = $item->referencesLayerItems;

        $BDitems = BDEncoder::decode($breadcrumb);
        array_push($BDitems, $item);
        $newBreadcrumb = BDEncoder::encode($BDitems);

        return view('items.show', [
            'item' => $item,
            'categories' => $categories,
            'files' => $files,
            'linkedItems' => $linkedItems,
            'histories' => $histories,
            'breadcrumb' => $newBreadcrumb,
            ]);
    }

    public function updateBreadcrumb($id, $breadcrumb, $bdItem){
        $items = BDEncoder::decode($breadcrumb);

        $reItems = [];

        for($i = 0; $i < $bdItem; $i++){
            array_push($reItems, $items[$i]);
        }

        $breadcrumb = BDEncoder::encode($reItems);

        if(strlen($breadcrumb) > 0){
            return redirect()->route('breadcrumb.add', ['id' => $id, 'breadcrumb' => $breadcrumb]);
        }

        return redirect()->route('show.item', ['id' => $id]);
    }


    public function downloadFile($id)
    {
        $databaseFile = File::findOrFail($id);
        $exists = Storage::disk('public')->exists(($databaseFile->path));

        if (!$exists) {
            abort(404);
        }

        return Storage::disk('public')->download($databaseFile->path);

    }

    public function edit($id)
    {
        $item = LayerItem::findOrFail($id);
        $this->AuthorizeRole($item->id);
        $existingItems = LayerItem::all()->except($id);
        $categories = Category::all();
//        $itemcategories = null;

        $firstLayerItem = FirstLayerItem::with('categories')->where('layer_item_id', $id)->first();
//        if ($firstLayerItem != null) {
//            $itemcategories = $firstLayerItem->categories;
//        }
        $files = File::where('layer_item_id', $id)->get();
        $linkedItems = $item->referencesLayerItems;


        return view('items.edit', ['item' => $item, 'files' => $files, 'linkedItems' => $linkedItems, 'existingItems' => $existingItems]);
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

    public function update(LayerItemEditRequest $request, $id)
    {
        $oldItem = LayerItem::findOrFail($id);
        $this->AuthorizeRole($oldItem->id);
        $body = $request->input('body');
        $oldItem->title = $request->input('title');
        $oldItem->body = $body;
        $oldItem->save();
        $firstLayerItem = FirstLayerItem::with('categories')->where('layer_item_id', $id)->first();

        $this->UpdateCategories($firstLayerItem, $request, $oldItem);

        if (isset($request->itemLinks)) {
            $oldItem->referencesLayerItems()->sync($request->itemLinks);

        }

        $this->UpdateFiles($request, $oldItem);

        return redirect()->route('show.item', $id);
    }

    public function destroy($id)
    {
        $layerItem = LayerItem::findOrFail($id);
        $firstLayerItem = FirstLayerItem::where('layer_item_id', $id);
        $this->AuthorizeRole($id);

        if ($firstLayerItem != null) {
            $firstLayerItem->delete();
        }

        $files = File::where('layer_item_id', $id);
        foreach ($files as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        $layerItem->delete($id);

        if (LayerItem::find($id) != null) {
            return redirect($this->show($id));
        }
        return view('items.confirmedDelete');
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
    public function SaveCategories(LayerItemStoreRequest $request, LayerItem $layerItem): void
    {
        if (isset($request->categories)) {
            $firstLayerItem = new FirstLayerItem();
            $firstLayerItem->layer_item_id = $layerItem->id;
            $firstLayerItem->x_pos = rand(120, 750);
            $firstLayerItem->y_pos = rand(320, 620);

            $firstLayerItem->save();

            foreach ($request->categories as $categoryId) {
                $firstLayerItem->categories()->attach($categoryId);
            }

        }
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
     * @param LayerItemStoreRequest $request
     * @param LayerItem $layerItem
     */
    public function SaveLinks(LayerItemStoreRequest $request, LayerItem $layerItem): void
    {
        if (isset($request->itemLinks)) {
            foreach ($request->itemLinks as $linkedItemId) {
                $layerItem->referencesLayerItems()->attach($linkedItemId);
            }
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|null $firstLayerItem
     * @param LayerItemEditRequest $request
     * @param $oldItem
     * @throws \Exception
     */
    public function UpdateCategories(?\Illuminate\Database\Eloquent\Model $firstLayerItem, LayerItemEditRequest $request, $oldItem): void
    {
        if ($firstLayerItem != null) {
            if (isset($request->categories)) {
                $firstLayerItem->categories()->sync($request->categories);
            } else {
                $firstLayerItem->delete($firstLayerItem->id);
            }
        } else {
            if (isset($request->categories)) {
                $firstLayerItem = new FirstLayerItem();
                $firstLayerItem->layer_item_id = $oldItem->id;
                $firstLayerItem->x_pos = rand(120, 750);
                $firstLayerItem->y_pos = rand(320, 620);

                $firstLayerItem->save();

                foreach ($request->categories as $categoryId) {
                    $firstLayerItem->categories()->attach($categoryId);
                }
            }
        }
    }

    /**
     * @param LayerItemEditRequest $request
     * @param $oldItem
     */
    public function UpdateFiles(LayerItemEditRequest $request, $oldItem): void
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $formFile) {
                $name = time() . '_' . $formFile->getClientOriginalName();
                $filePath = $formFile->storeAs('files', $name, 'public');

                $file = new File();
                $file->layer_item_id = $oldItem->id;
                $file->title = $name;
                $file->type = $formFile->getClientOriginalExtension();
                $file->path = $filePath;
                $file->save();
            }
        }
    }


    public function AuthorizeRole($item = null)
    {
        if($item!= null)
        {
            if(!Auth::user()->can('layerItem.edit.'.$item))
            {
                abort(403);
            }
        }
        else
        {
            if(!Auth::user()->can('layerItem.edit.*'))
            {
                abort(403);
            }
        }
    }

}

