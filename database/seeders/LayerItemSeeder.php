<?php

namespace Database\Seeders;

use App\Models\LayerItem;
use Database\Factories\LayerItemFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LayerItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/LayerItem.json");
        $data = json_decode($json);
        foreach($data as $obj){
            $body = $obj->body == '' ? "Nog te omschrijven..." : $obj->body;
            
            Layeritem::create(array(
                'title' => $obj->title,
                'body' => $body
            ));
        }
    }
}
