<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'layout_id',
        'parent_id',
        'ordering_id',
        'name',
        'region',
    ];

}
