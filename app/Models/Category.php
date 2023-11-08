<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(Service::class, 'sub_category_id');
    }

    public function sub_category()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }
}
