<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Add_Card extends Model
{
    use HasFactory;

    protected $table = "add_card";
    protected $fillable = ['user_id', 'card', 'card_id', 'defaul'];

    protected $hidden = [
        'card_id',
    ];


    // relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
