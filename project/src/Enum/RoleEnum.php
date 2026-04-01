<?php

namespace App\Enum;

enum RoleEnum: int
{
    case Regular = 0;
    case Moderator = 1;
    case Admin = 2;
}
