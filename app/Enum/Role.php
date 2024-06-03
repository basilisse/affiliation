<?php

namespace App\Enum;

enum Role : string
{
  case SUPER_ADMIN = 'super_admin';
  case ADMIN = 'admin';
  case USER = 'user';
  case GUEST = 'guest';
}
