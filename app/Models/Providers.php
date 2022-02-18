<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class Providers extends Model
{
    use HasFactory;
    
    protected $table = 'providers';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'provider', 'type', 'index_rating', 'name', 'count'
    ];

}
