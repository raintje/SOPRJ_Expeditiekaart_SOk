<?php

namespace Database\Seeders;

use App\Models\LayerItem;
use Illuminate\Database\Seeder;

class LayerItemLayerItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layerItems = LayerItem::all();

        LayerItem::all()->each(function ($item) use ($layerItems)
        {
            $links = $layerItems->where('id', '!=', $item->id)->random(rand(1, 5));

            $item->referencesLayerItems()->saveMany($links);
        });
    }
}
