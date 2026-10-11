<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\OrderStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // العلاقة مع الطلبات
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function scopeAvailable(Builder $query){
        return $query->whereDoesntHave('orders', function ($q) {
            // استبعاد السائق فوراً إذا كان يمتلك أي طلب فعال حالياً 
            $q->whereIn('status', [ OrderStatus::ASSIGNED->value , OrderStatus::PICKED_UP->value ])
            ->whereDate('created_at', Carbon::today());
        });
    }

    //  سكوب لتحديد السائقين فقط
    public function scopeDrivers(Builder $query)
    {
        return $query->select('users.id')->where('role', 'driver');
    }

    // سكوب لحساب إحصائيات رحلات اليوم
    public function scopeWithTripsStats(Builder $query)
    {
        $today = Carbon::today()->toDateTimeString();

        return $query->withCount(['orders as total_trips_today' => function ($q) {
                        $q->where('assigned_at', '>=', Carbon::today());
                    }]);
    }



    public function scopeWithLongestIdleTime(Builder $query)
    {
        $today = Carbon::today()->toDateTimeString();

        return $query->selectRaw(
                    // نجلب آخر توصيلة اليوم، وإذا لم يوصل أي شيء اليوم نعتبر بداية اليوم (00:00) كبداية انتظار وخمول له
                    "(SELECT COALESCE(MAX(delivered_at), ?) FROM orders WHERE orders.driver_id = users.id AND delivered_at >= ?) as today_last_delivery_time",
                    [$today, Carbon::today()]
        );
    }

}
