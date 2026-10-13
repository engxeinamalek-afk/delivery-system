<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id',
                            'store_id',
                            'status',
                            'driver_id',
                            'assigned_at',
                            'delivered_at'];     

    // لطلبات اليوم
    public function scopeCreatedToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeAssignedToday(Builder $query): Builder
    {
        return $query->whereDate('assigned_at', today());
    }


    // طلبات سائق
    public function scopeForDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    // الطلبات المتأخرة
    public function scopeDelayedAssignment(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::ASSIGNED->value)  
                    ->where('assigned_at', '<=', now()->subMinutes(30));
    }
    
    public function scopeStatusAssigned(Builder $query){
        return $query->where('status', OrderStatus::ASSIGNED->value);
    }

    // علاقة العميل
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class , 'customer_id' , 'id');
    }

    // علاقة السائق
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class , 'driver_id' , 'id');
    }

    // علاقة عناصر الطلب
    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // علاقة المتجر
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class); 
    }

    // سكوب جلب اسم العميل واسم السائق واسم المتجر وعدد العناصر
    public function scopeWithDetails(Builder $query): Builder{
        return $query->with([
            'customer:id,name', 
            'driver:id,name', 
            'store' => function ($storeQuery) {
                // تجاهل الـ Global Scope لجلب المتاجر حتى لو كانت مغلقة
                $storeQuery->withoutGlobalScopes()->select('id', 'name');
            }
        ])->withCount('orderItems');
    }
}
