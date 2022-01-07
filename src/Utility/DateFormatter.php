<?php

namespace App\Utility;

abstract class DateFormatter
{
  static function strToUTCDateTime(string $strDateTime): string
  {
    return date('c', strtotime($strDateTime));
  }

  static function sortAsc($arr)
  {
    function cmp($a, $b)
    {
      if ($a == $b) {
        return 0;
      }
      return ($a < $b) ? -1 : 1;
    }
    return usort($arr, "cmp");
  }
}
