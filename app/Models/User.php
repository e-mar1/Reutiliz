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
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id');
        // الشرح:
        // Item::class: الموديل اللي كيتربط بيه الـ User (اللي هو Item).
        // 'favorites': هذا هو اسم الـ pivot table ديالك فالداتابيز.
        // 'user_id': الـ foreign key ديال هذا الموديل (User) في الـ pivot table.
        // 'item_id': الـ foreign key ديال الموديل الآخر (Item) في الـ pivot table.
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }
}
