<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Sitemap
{
  protected $url;
  public function __construct($url)
  {
    $this->url = $url;
    header("Content-Type: text/xml; charset=utf-8");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    echo '<?xml version="1.0" encoding="UTF-8"?>';
  }

  public function requick()
  {
    return [
      [
        "tbl" => 'category_products',
        "level" => "1",
        "type" => 'san-pham',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'category_products',
        "level" => "2",
        "type" => 'san-pham',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'category_products',
        "level" => "3",
        "type" => 'san-pham',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'category_products',
        "level" => "4",
        "type" => 'san-pham',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'products',
        "level" => "0",
        "type" => 'san-pham',
        "menu" => true,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'category_news',
        "level" => "1",
        "type" => 'tin-tuc',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'category_news',
        "level" => "2",
        "type" => 'tin-tuc',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'category_news',
        "level" => "3",
        "type" => 'tin-tuc',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'category_news',
        "level" => "4",
        "type" => 'tin-tuc',
        "menu" => false,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'news',
        "level" => "0",
        "type" => 'tin-tuc',
        "menu" => true,
        'priority' => '0.9'
      ],
      [
        "tbl" => 'page',
        "level" => "0",
        "type" => "gioi-thieu",
        "menu" => true,
        'priority' => '0.9'
      ],
      [
        'tbl' => "news",
        "level" => "0",
        "type" => "chinh-sach",
        "menu" => false,
        'priority' => '0.9'
      ],
    ];
  }

  public function createSitemap($baseUrl, $table, $priority, $type, $level, $menu = true)
  {
    $urlSm = '';
    $sitemap = null;
    if (!empty($type) && !in_array($table, ['photo', 'page'])) {
      if ($table != 'page' && $level == '0') {
        $sitemap = DB::table($table)->where('type', $type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
      } else {
        $sitemap = DB::table($table)->where('type', $type)->where('level', $level)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
      }
    }
    if ($menu == true && $level == '0') {
      $urlSm = $baseUrl . $type;
      echo '<url>';
      echo '<loc>' . $urlSm . '</loc>';
      echo '<lastmod>' . date('c', time()) . '</lastmod>';
      echo '<changefreq>daily</changefreq>';
      echo '<priority>' . $priority . '</priority>';
      echo '</url>';
    }
    if (!empty($sitemap)) {
      foreach ($sitemap as $value) {
        $timestamp = date('c', Carbon::parse($value->created_at)->timestamp);
        if (!empty($value->slug)) {
          $urlSm = $baseUrl . $type . '/' . $value->slug;
          echo '<url>';
          echo '<loc>' . $urlSm . '</loc>';
          echo '<lastmod>' . $timestamp . '</lastmod>';
          echo '<changefreq>daily</changefreq>';
          echo '<priority>' . $priority . '</priority>';
          echo '</url>';
        }
      }
    }
  }
}
