<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'item_name',
        'item_type',
        'item_justification',
        'item_price',
        'item_quantity',
        'item_unit_of_measurement',
        'item_total'
    ];


    
}
