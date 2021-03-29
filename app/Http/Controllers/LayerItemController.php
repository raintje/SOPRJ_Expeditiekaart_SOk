<?php

namespace App\Http\Controllers;

use App\Http\Requests\LayerItemStoreRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use Illuminate\Http\Request;

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
        $item = LayerItem::find($id);
        if($item != null)
        {
            return view('items.show', ['item' => $item]);
        }
        abort(404);
    }

    public function edit($id)
    {
        $item = LayerItem::findOrFail($id);
        $existingItems = LayerItem::all()->except($id);
        $categories = Category::all();
        $itemcategories = null;

        $firstLayerItem = FirstLayerItem::with('categories')->where('layer_item_id', $id)->first();
        if ($firstLayerItem != null) {
            $itemcategories = $firstLayerItem->categories;
        }

        $files = File::where('layer_item_id', $id)->get();
        $linkedItems = $item->referencesLayerItems;

        return view('items.edit', ['item' => $item, 'categories' => $categories, 'itemcategories' => $itemcategories, 'files' => $files, 'linkedItems' => $linkedItems, 'existingItems' => $existingItems]);
    }

    public function update(Request $request, $id)
    {
//        $oldItem = LayerItem::find($id);
        if(LayerItem::findOrFail($id) == null)
        {
            return redirect($this->show($id));
        }
        $oldItem = LayerItem::findOrFail($id);

        $body = $request->input('body'); // wat is dit?


        $oldItem->title = $request->input('title'); // wat is dit? zit dit niet gwn in de request variable?
        $oldItem->body = $body;
        $oldItem->save();

        if (isset($request->categories)) {
            $firstLayerItem = FirstLayerItem::findOrFail();
            $firstLayerItem->layer_item_id = $oldItem->id;
            $firstLayerItem->x_pos = rand(120, 750);
            $firstLayerItem->y_pos = rand(320, 620);

            $firstLayerItem->save();

            foreach ($request->categories as $categoryId) {
                $firstLayerItem->categories()->attach($categoryId);
            }
        }

        if (isset($request->itemLinks)) {
            foreach ($request->itemLinks as $linkedItemId) {
                $oldItem->referencesLayerItems()->attach($linkedItemId);
            }
        }

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

        return $this->show($id);

    }

    public function destroy($id)
    {
        $itemToDestroy = LayerItem::find($id);
        if($itemToDestroy != null)
        {
            LayerItem::destroy($itemToDestroy);
            return redirect($this->index());
        }
        return redirect($this->index());
    }
}

