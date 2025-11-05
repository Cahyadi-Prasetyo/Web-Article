<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Articles extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'articles';

    protected $fillable = [
        'title',
        'categories',
        'slug',
        'content',
        'excerpt',
        'status',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }    
}
