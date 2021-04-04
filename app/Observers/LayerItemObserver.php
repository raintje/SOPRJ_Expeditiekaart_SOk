<?php

namespace App\Observers;

use App\Models\LayerItem;
use App\Traits\TracksHistoryTrait;

class LayerItemObserver
{
    use TracksHistoryTrait;

    public function updated(LayerItem $model)
    {
        $this->track($model);
    }
}
