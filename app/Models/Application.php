<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'justification',
        'faculty',
        'budget_type',
        'usage_type',
        'total',
        'approved_total',
        'general_ledger',
        'status',
        'remark'
    ];
}
