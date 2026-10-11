<?php
namespace App\Services\AssignDriver\Strategies;
use App\Models\User;
use Carbon\Carbon;

class LeastBusyDriverStrategy implements DriverSelectionInterface{
    public function getDriver():?User
    {
        $bestDriver = User::drivers()
            ->withTripsStats()
            ->orderBy('total_trips_today', 'asc') // الأقل رحلات أولاً
            ->first();
        return $bestDriver;
        
    }
}