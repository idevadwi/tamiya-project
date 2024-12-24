<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory, HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'tournament_id',
        'stage',
        'track',
        'lane',
        'racer_id',
        'team_id',
        'created_by',
        'updated_by',
    ];
}
