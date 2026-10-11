<?php 
namespace App\Services\AssignDriver\Strategies;

use App\Models\User;

class LongestIdleDriverStrategy implements DriverSelectionInterface{
    public function getDriver():?User
    {       
        $driver = User::drivers()
            ->available()
            ->withLongestIdleTime()
            ->orderBy('today_last_delivery_time', 'asc') // ترتيب تصاعدي: الأقدم تاريخاً (الأكثر خمولاً) يفوز فوراً
            ->orderBy('users.id', 'asc')                     // عند التساوي الكامل: نأخذ الأقدم في النظام
            ->first();
        return $driver;       
    }
}