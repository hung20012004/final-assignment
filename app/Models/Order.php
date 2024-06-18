<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'state',
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

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

     public function order_detail() {
        return $this->hasMany(OrderDetail::class);
    }
}
