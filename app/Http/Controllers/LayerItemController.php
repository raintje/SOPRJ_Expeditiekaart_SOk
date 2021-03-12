<?php

namespace App\Http\Controllers;

use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

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
        $categories = ['familie/sociaal','bedrijfskunde','persoonlijke ontwikkeling']; //TODO define in one place
        return view('items.create', ['existingItems' => $items, 'categories' => $categories]);
    }

    public function store(Request $request)
    {

        $body = $request->input('body');

        $layerItem = new LayerItem();
        $layerItem->title = $request->input('title');
        //TODO remove body preview from database
        $layerItem->body_preview = implode(' ', array_slice(explode(' ', $body), 0, 15));
        $layerItem->body = $body;
        $layerItem->save();

        $array = null;
        if(isset($request->categories)){
           $firstLayerItem = new FirstLayerItem();
           $firstLayerItem->layer_item_id = $layerItem->id;
           $firstLayerItem->categorie = $request->categories;
           $firstLayerItem->save();
           $array = [$layerItem, $firstLayerItem];
        }
        if($array != null){
            dump($array);
        }
        else{
            dump($layerItem->attributesToArray());
        }

//        return redirect($this->show($item->id));

        //TODO add files and linked items to store method
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
        die("i can edit");
        $item = LayerItem::find($id);
        if($item != null)
        {
            return view('items.edit', ['item' => $item]);
        }
        abort(404);
    }

    public function update(Request $request, $id)
    {
        $oldItem = LayerItem::find($id);
        if($oldItem != null)
        {
            //TODO write update method
        }
        return redirect($this->show($id));

    }

    public function destroy($id)
    {
        $itemToDestroy = LayerItem::find($id);
        if($itemToDestroy != null)
        {
            LayerItem::destroy($itemToDestroy);
            return redirect($this->index());
            //TODO notify user of item destroyed
        }
        return redirect($this->index());
        //TODO notify user item could not be destroyed


    }
}
