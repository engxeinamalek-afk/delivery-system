<?php
namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case ASSIGNED = 'assigned';
    case PICKED_UP = 'picked_up';
    case DELIVERED = 'delivered';
}