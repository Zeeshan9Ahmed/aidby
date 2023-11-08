<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');    
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');    
    }

    public function user () {
        return $this->belongsTo(User::class,'user_id');
    }


    public function problem_images () {
        return $this->hasMany(Attachment::class,'record_id')->where('type','book_service');
    }
}
