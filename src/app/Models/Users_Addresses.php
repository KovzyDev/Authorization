<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_Addresses extends Model
{
    use HasFactory;

    protected $table = "users_addresses";
    protected $fillable = ['user_id', 'address', 'latitude', 'longitude', 'defaul', 'comment'];


    // relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
