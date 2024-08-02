<?php

namespace Drupal\moduleone\services;

class StringLength
{
  public function stringlen(string $bdy): int{
    $len = strlen($bdy);
    return $len;
  }
}