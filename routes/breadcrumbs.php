<?php

use App\Http\Helpers\BDEncoder;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Expeditiekaart', route('home'));
});

// Home > [items]
Breadcrumbs::for('items', function ($trail, $breadcrumb) {
    $trail->parent('home');

    $items = BDEncoder::decode($breadcrumb);

    for($i = 0; $i < count($items); $i++){
        $trail->push(
            $items[$i]->title, 
            route('breadcrumb.update', [
                'id' => $items[$i]->id, 
                'breadcrumb' => $breadcrumb, 
                'returnNr' => $i
                ]));
    }
});

