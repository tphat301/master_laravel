<?php

namespace App\Utils;

use App\Models\Admin\News;
use App\Models\Admin\Photo;
use App\Models\Admin\Product;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Watermark
{
  /* Create watermark */
  protected function createWatermark($data, $path, $pathInsert, $position, $x, $y, $option)
  {
    if ($data) {
      $manager = new ImageManager(new Driver());
      foreach ($data as $v) {
        if ($v->photo1) {
          $image = $manager->read($path . $v->photo1);
          $watermark = $manager->read($pathInsert);
          $image->place($watermark, $position, $x, $y);
          $publicPath = public_path('upload/wk_' . $option);
          $image->save($publicPath . "/" . $v->photo1);
        }
        if ($v->photo2) {
          $image = $manager->read($path . $v->photo2);
          $watermark = $manager->read($pathInsert);
          $image->place($watermark, $position, $x, $y);
          $publicPath = public_path('upload/wk_' . $option);
          $image->save($publicPath . "/" . $v->photo2);
        }
        if ($v->photo3) {
          $image = $manager->read($path . $v->photo3);
          $watermark = $manager->read($pathInsert);
          $image->place($watermark, $position, $x, $y);
          $publicPath = public_path('upload/wk_' . $option);
          $image->save($publicPath . "/" . $v->photo3);
        }
        if ($v->photo4) {
          $image = $manager->read($path . $v->photo4);
          $watermark = $manager->read($pathInsert);
          $image->place($watermark, $position, $x, $y);
          $publicPath = public_path('upload/wk_' . $option);
          $image->save($publicPath . "/" . $v->photo4);
        }
      }
      return;
    }
  }

  public function watermarkProduct()
  {
    // Watermark product constructor
    $productDefault = Product::where('type', config('admin.product.type'))->whereRaw('find_in_set("hienthi", status)')->get();
    $watermarkProduct = Photo::where('type', config('admin.photo.watermark_product.type'))->whereRaw('find_in_set("hienthi", status)')->first();
    if ($watermarkProduct && $productDefault) {
      if ($watermarkProduct->photo) {
        $this->createWatermark($productDefault, "public/upload/product/", "public/upload/watermark_product/" . $watermarkProduct->photo, $watermarkProduct->position, 10, 10, "product");
      }
    }
  }

  public function watermarkArticle()
  {
    // Watermark article constructor
    $newsDefault = News::where('type', config('admin.news.type'))->whereRaw('find_in_set("hienthi", status)')->get();
    $watermarkNews = Photo::where('type', config('admin.photo.watermark_news.type'))->whereRaw('find_in_set("hienthi", status)')->first();
    if ($watermarkNews && $newsDefault) {
      $this->createWatermark($newsDefault, "public/upload/news/", "public/upload/watermark_news/" . $watermarkNews->photo, $watermarkNews->position, 10, 10, "news");
    }
  }
}
