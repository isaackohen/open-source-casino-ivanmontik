<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class GamelistPublic extends Model
{
    use HasFactory;
    
    protected $table = 'gamelist';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'game_slug', 'game_name', 'game_provider', 'rtp', 'game_desc', 'index_rating', 'disabled', 'type', 'demo', 'hidden'
    ];
}
