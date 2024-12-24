<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentResult extends Model
{
    use HasFactory, HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'tournament_id',
        'champ_1',
        'champ_2',
        'champ_3',
        'champ_4',
        'champ_5',
        'champ_6',
        'champ_7',
        'champ_8',
        'champ_9',
        'champ_10',
        'bto_a_1',
        'bto_a_2',
        'bto_a_3',
        'bto_b_1',
        'bto_b_2',
        'bto_b_3',
        'bto_c_1',
        'bto_c_2',
        'bto_c_3',
        'created_by',
        'updated_by',
    ];
}
