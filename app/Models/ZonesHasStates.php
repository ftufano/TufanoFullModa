<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonesHasStates extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'zones_has_states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zones_id',
        'states_id'
    ];

    public function zones()
    {
        return $this->belongsTo(Zones::class);
    }

    public function states()
    {
        return $this->belongsTo(States::class);
    }
}
