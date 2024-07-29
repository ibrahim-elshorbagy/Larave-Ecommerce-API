<?php

namespace App\Models\Dashboard;


class Product extends \App\Models\Product
{

    public function getRouteKeyName()
    {
        return 'id';
    }

}
