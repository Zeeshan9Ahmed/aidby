<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','category_id','sub_category_id', 'blog_image','description'];

    public function user () {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function category () {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function sub_category () {
        return $this->belongsTo(Category::class,'sub_category_id','id');
    }

    public function getTruncatedAttribute()
    {
        $maxLength = 100; // Maximum length before adding ellipsis
        $value = $this->attributes['description']; // Replace 'your_attribute' with the actual attribute name

        if (strlen($value) > $maxLength) {
            $truncatedValue = substr($value, 0, $maxLength) . ' ...  ';
        } else {
            $truncatedValue = $value;
        }

        return $truncatedValue .'  ';
    }
}
