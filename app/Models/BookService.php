<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookService extends Model
{
    use HasFactory;

    public function service_creator () {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function service() {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function problem_images () {
        return $this->hasMany(Attachment::class,'record_id')->where('type','book_service');
    }
}
