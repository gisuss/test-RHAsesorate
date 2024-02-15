<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'quote_id'
    ];

    public function scopeFilterUser ($query, $user_id) {
        $query->where('user_id', $user_id)->orderBy('id', 'desc');
    }

    public function favs() {
        return $this->hasMany(User::class, 'user_id');
    }
}
