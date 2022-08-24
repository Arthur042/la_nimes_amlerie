<?php

namespace App\Service;

use App\Entity\User;

class IsAdmin
{
    public function isAdmin(User $value): bool {
        return in_array('ROLE_ADMIN', $value->getRoles());
    }
}