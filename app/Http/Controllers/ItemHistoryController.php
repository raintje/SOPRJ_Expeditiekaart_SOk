<?php

namespace App\Http\Controllers;

use App\Models\LayerItem;
use Illuminate\Http\Request;
use Panoscape\History\History;

class ItemHistoryController extends Controller
{
    public function revertItem($id)
    {
        $itemHistoryEdit = History::findOrFail($id);
        $item = LayerItem::findOrFail($itemHistoryEdit->model_id);

    }


    public function destroyHistoryEditOfItem($id)
    {
        $itemHistoryEdit = History::findOrFail($id);
        $itemId = $itemHistoryEdit->model_id;
        $itemHistoryEdit->delete($id);
        return redirect()->route('show.item', $itemId);
    }
}
