<?php

namespace App\Enums;

class RecipeStatusEnum
{
    const PENDING = 0;
    const ACCEPTED = 1;
    const REJECTED = 2;
    public static function getStatuses()
    {
        return [
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        ];
    }
}
