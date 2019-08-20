<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function saleItems()
    {
        return $this->hasMany('App\SaleItem');
    }

    public function currentStock()
    {
        return $this->hasOne('App\CurrentStock'); // Total Stock items
    }

    public function stocks()
    {
        return $this->hasMany('App\Stock'); // Individual Stock items
    }
}
