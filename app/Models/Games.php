<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Games extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = ['name',
        'description',
        'total_players',
        'user_id',
        'game_type_id'];


    // ✅ Relatie: een game behoort toe aan één user (maker)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
