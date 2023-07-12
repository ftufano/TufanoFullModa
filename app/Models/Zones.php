<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zones extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'zones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'users_id',
        'seller_users_id'
    ];

    public function zonesCreatedBy()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function zonesAssignedToSeller()
    {
        return $this->BelongsTo(User::class, 'seller_users_id');
    }

    public function customers()
    {
        return $this->hasOne(Customer::class);
    }

    public function zones_has_states()
    {
        return $this->hasMany(ZonesHasStates::class);
    }
}
