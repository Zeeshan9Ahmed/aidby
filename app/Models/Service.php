<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','sub_category_id','user_id','fixed_price','per_hour_rate','description'];

    public function service_provider() 
    {
        return $this->belongsTo(User::class,'user_id','id')->select('id','first_name','last_name','email','profile_image');
    }

    public function service_category ()
    {
        return $this->belongsTo(Category::class,'category_id','id')->select('id','title');
    }

    public function service_sub_category () 
    {
        return $this->belongsTo(Category::class,'sub_category_id','id')->select('id','title');
    }
}
