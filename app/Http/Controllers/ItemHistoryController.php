<?php

namespace App\Http\Controllers;

use App\Models\LayerItem;
use Illuminate\Http\Request;
use Panoscape\History\History;

class ItemHistoryController extends Controller
{
    public function restoreItem($id)
    {
        $itemHistoryEdit = History::findOrFail($id);
        $item = LayerItem::findOrFail($itemHistoryEdit->model_id);
        $changes = $itemHistoryEdit->meta;

        foreach($changes as $change) {
            $editOn = $change['key'];
            switch ($editOn) {
                case 'title':
                    $item->title = $change['old'];
                case 'body':
                    $item->body = $change['old'];
            }
        }
        $item->save();
        return redirect()->route('show.item', $item->id);
    }


    public function destroyHistoryEditOfItem($id)
    {
        $itemHistoryEdit = History::findOrFail($id);
        $itemId = $itemHistoryEdit->model_id;
        $itemHistoryEdit->delete($id);
        return redirect()->route('show.item', $itemId);
    }
}
