<?php

namespace App\Enums;

class UserRoleEnum
{
    const USER = 0;
    const EMPLOYEE = 1;
    const ADMIN = 2;
    public static function getUserRole($role)
    {
        switch ($role) {
            case self::USER:
                return 'user';
            case self::EMPLOYEE:
                return 'employee';
            case self::ADMIN:
                return 'admin';
            default:
                return 'unknown';
        }
    }
    public static function getStats()
    {
        return [
            self::USER => 'User',
            self::EMPLOYEE => 'Employee',
            self::ADMIN => 'Admin',
        ];
    }
}
