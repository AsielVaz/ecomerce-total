<?php

namespace App;

enum OrderStatus: string
{
    case Placed = 'placed';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Placed => 'Recibida',
            self::Processing => 'En preparación',
            self::Shipped => 'Enviada',
            self::Completed => 'Completada',
            self::Cancelled => 'Cancelada',
        };
    }
}
