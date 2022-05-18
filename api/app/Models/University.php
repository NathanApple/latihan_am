<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pt_code',
        'name',
        'address',
        'website',
    ];
}
