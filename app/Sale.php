<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{
    protected $guarded = ['id'];

    public function saleItems()
    {
        return $this->hasMany('App\SaleItem');
    }
}
