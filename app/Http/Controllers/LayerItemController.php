<?php

namespace App\Http\Controllers;

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
        $categories = ['familie/sociaal','bedrijfskunde','persoonlijke ontwikkeling']; //TODO define in one place
        return view('items.create', ['existingItems' => $items, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $body = $request->input('body');

        $item = new LayerItem();
        $item->title = $request->input('title');
        $item->bodyPreview = implode(' ', array_slice(explode(' ', $body), 0, 5));
        $item->body = $body;
        $item->save();

        $id = LayerItem::latest()->get(1)->id;
        return redirect($this->show($id));

        //TODO improve strore method
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
