<?php

namespace App\Enums;

final class RoleType
{
    const ADMIN = "admin";
    const WAITER = "waiter";
    const CHIEF = "cheif";
    const CACHIR = "cachir";
    const CLIENT = "client";


    public static function getAll()
    {
        return [
            RoleType::ADMIN,
            RoleType::WAITER,
            RoleType::CHIEF,
            RoleType::CACHIR,
            RoleType::CLIENT
        ];
    }
}
