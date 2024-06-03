<?php

namespace App\Utils;

use DateTimeImmutable;

class Utils
{
  public static function generateRandomString($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
    }

    return $randomString;
  }
  public static function formatDate($date, $format): string
  {
    $date = new DateTimeImmutable($date);
    return $date->format($format);
  }
}
