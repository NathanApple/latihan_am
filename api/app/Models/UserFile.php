<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'file_category_id',
        'file_url',
    ];

    public function users(){
        return $this->belongsTo(University::class, "user_id");
    }

    public function file_categories(){
        return $this->belongsTo(FileCategory::class, "file_category_id");
    }
    
}
