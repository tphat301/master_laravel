<?php

namespace App\Http\Controllers;

use App\Utils\Sitemap;

class SitemapController extends Controller
{
  protected $sitemap;
  protected $requick;
  public function __construct()
  {
    $this->sitemap = new Sitemap(config('app.url'));
    $this->requick = $this->sitemap->requick();
  }

  public function index()
  {
    echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
    echo '<url><loc>' . config('app.url') . '</loc><lastmod>' . date('c', time()) . '</lastmod><changefreq>daily</changefreq><priority>1</priority></url>';
    if (!empty($this->requick)) {
      foreach ($this->requick as $value) {
        $this->sitemap->createSitemap(config('app.url'), $value['tbl'], $value['priority'], $value['type'], $value['level'], $value['menu']);
      }
    }
    echo '</urlset>';
  }
}
