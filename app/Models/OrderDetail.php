<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
     use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'laptop_id',
        'quantity',
        'price'
    ];
    
    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        // 'created' => CustomerCreated::class,
        // 'updated' => CustomerUpdated::class,
        // 'deleted' => CustomerDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

        ];
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function laptop() {
        return $this->belongsTo(Laptop::class);
    }
}
