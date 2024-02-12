<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Location extends Model
{
    use SoftDeletes,HasFactory;
    protected $fillable = [
        'user_id','name','latitude','longitude'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
