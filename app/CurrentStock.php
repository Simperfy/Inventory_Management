<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CurrentStock extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo("App\Product");
    }
}
