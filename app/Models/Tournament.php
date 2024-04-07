<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tournament extends Model
{
    use HasFactory, HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'tournament_name',
        'vendor_name',
        'description',
        'image',
        'current_stage',
    ];
}
