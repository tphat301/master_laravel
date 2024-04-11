<?php

namespace App\Utils;

class Seo
{
  private $data;
  public function set($key = '', $value = '')
  {
    if (!empty($key) && !empty($value)) {
      $this->data[$key] = $value;
    }
  }

  public function get($key)
  {
    return (!empty($this->data[$key])) ? $this->data[$key] : '';
  }
}
