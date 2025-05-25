<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'created_at'
    ];

    public $timestamps = false;

    // Relations
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
