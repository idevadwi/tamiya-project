<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CouponHistory extends Model
{
    use HasFactory, HasUuids;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'card_id',
        'tournament_id',
        'values',
        'before_changes',
        'after_changes',
        'type',
    ];
}
