<?php

namespace App\Enum;

enum UsersRoles: string
{
    case PATIENT = 'patient';
    case DOCTOR = 'doctor';
    case ADMIN = 'admin';
    case RECEPTIONIST = 'receptionist';
}
