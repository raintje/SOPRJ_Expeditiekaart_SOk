<?php

namespace App\Http\Controllers;

use App\Http\Requests\LayerItemStoreRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayerItemController extends Controller
{

    public function index()
    {
        $items = LayerItem::all();
        return view('items.index', ['items' => $items]);
    }

    public function create()
    {
        $items = LayerItem::all();
        $categories = Category::all();
        return view('items.create', ['existingItems' => $items, 'categories' => $categories]);
    }

    public function store(LayerItemStoreRequest $request)
    {
            $body = $request->input('body');

            $layerItem = new LayerItem();
            $layerItem->title = $request->input('title');
            $layerItem->body = $body;
            $layerItem->save();

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

            if (isset($request->itemLinks)) {
                foreach ($request->itemLinks as $linkedItemId) {
                    $layerItem->referencesLayerItems()->attach($linkedItemId);
                }
            }

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

            return redirect()->route('items');
//        return redirect($this->show($layerItem->id)); -> kan gebruikt worden wanneer de show method werkt.
    }

    public function show($id)
    {
        $item = LayerItem::findOrFail($id);
        $categories = null;

        $firstLayerItem = FirstLayerItem::with('categories')->where('layer_item_id', $id)->first();
        if ($firstLayerItem != null) {
            $categories = $firstLayerItem->categories;
        }

        $files = File::where('layer_item_id', $id)->get();
        $linkedItems = $item->referencesLayerItems;

        return view('items.show', ['item' => $item, 'categories' => $categories, 'files' => $files, 'linkedItems' => $linkedItems]);
    }

    public function downloadFile($id){
        $databaseFile = File::findOrFail($id);
        $exists = Storage::disk('public')->exists(($databaseFile->path));

        if(!$exists){
            abort(404);
        }

        return Storage::disk('public')->download($databaseFile->path);

    }

    public function edit($id)
    {
        die("i can edit");
        $item = LayerItem::find($id);
        if($item != null)
        {
            return view('items.edit', ['item' => $item]);
        }
        abort(404);
    }

    public function editLocation()
    {
        return view('items.edit_location');
    }



    public function update(Request $request, $id)
    {
        $oldItem = LayerItem::find($id);
        if($oldItem != null)
        {
        }
        return redirect($this->show($id));

    }

    public function destroy($id)
    {
        $layerItem = LayerItem::findOrFail($id);
        $firstLayerItem = FirstLayerItem::where('layer_item_id', $id);

        if($firstLayerItem != null){
            $firstLayerItem->delete();
        }

        $layerItem->delete($id);

        if(LayerItem::find($id) == null){
            return view('items.confirmedDelete');
        }
        else{
            return redirect($this->show(id));
        }
    }
}

