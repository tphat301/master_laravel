<?php

namespace App\Utils;

class BreadCrumbs
{
  private $data = array();
  private $json = array();

  public function set($slug = '', $title = '')
  {
    if ($title != '') {
      $this->data[] = array('slug' => $slug, 'title' => $title);
    }
  }

  public function get()
  {
    $breadcumb = '';
    if ($this->data) {
      $breadcumb .= '<ol class="breadcrumb">';
      $breadcumb .= '<li class="breadcrumb-item"><a class="text-decoration-none" href="' . config('app.url') . '"><span>Trang chủ</span></a></li>';
      $k = 1;
      foreach ($this->data as $key => $value) {
        if ($value['title'] != '') {
          $slug = ($value['slug']) ? config('app.url') . $value['slug'] : '';
          $name = $value['title'];
          $active = ($key == count($this->data) - 1) ? "active" : "";
          $breadcumb .= '<li class="breadcrumb-item ' . $active . '"><a class="text-decoration-none" href="' . $slug . '"><span>' . $name . '</span></a></li>';
          $this->json[] = array("@type" => "ListItem", "position" => $k, "name" => $name, "item" => $slug);
          $k++;
        }
      }
      $breadcumb .= '</ol>';
      $breadcumb .= '<script type="application/ld+json">{"@context": "https://schema.org","@type": "BreadcrumbList","itemListElement": ' . ((json_encode($this->json))) . '}</script>';
    }
    return $breadcumb;
  }
}
