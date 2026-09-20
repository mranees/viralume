<?php

namespace App\Enum;

enum UsersRoles: String
{
    case PATIENT = 'patient';
    case DOCTOR = 'doctor';
    case ADMIN = 'admin';
    case RECEPTIONIST = 'receptionist';
}
