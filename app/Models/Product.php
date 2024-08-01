<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'user_id', 'publication_date', 'images', 'status'
    ];

    // Relación con la categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los comentarios
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relación con las transacciones
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Alcance para obtener solo productos disponibles
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
