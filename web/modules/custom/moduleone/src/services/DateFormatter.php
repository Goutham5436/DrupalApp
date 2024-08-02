<?php

namespace Drupal\moduleone\services;

class DateFormatter
/**
 * Convert timetstamp to DD-MM-YY format
 */
{
    public function dateFormatter(int $timestamp): string{
      return date('j-M-Y', $timestamp);
    }  

}

