<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'states_id',
        'zones_id',
        'categories_id',
        'status_id',
        'identification',
        'name',
        'address',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function states()
    {
        return $this->belongsTo(States::class);
    }

    public function zones()
    {
        return $this->belongsTo(Zones::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
