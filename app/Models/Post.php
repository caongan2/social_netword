<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'content',
        'is_public',
        'image'];

    function user(){
        return $this->belongsTo(User::class,"userId");
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
