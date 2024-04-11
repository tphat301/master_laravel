<?php

return [
    /* DASHBOARD MODULE */
    'dashboard' => [
        'name' => 'Bảng điều khiển'
    ],

    /* PRODUCT MODULE */
    'san-pham' => [
        'active' => true,
        'name' => 'Quản lý sản phẩm',
        'type' => 'san-pham',
        'slug' => true,
        'code' => true,
        'copy' => true,
        'number_per_page' => 10,
        'sale_price' => true,
        'regular_price' => true,
        'discount' => true,
        'status' => [
            'banchay' => 'Bán chạy',
            'noibat' => 'Nổi bật',
            'hienthi' => 'Hiển thị'
        ],
        'desc' => true,
        'desc_tiny' => true,
        'content' => true,
        'content_tiny' => true,
        'photo1' => true,
        'width1' => 480,
        'height1' => 480,
        'thumb1' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
        'photo2' => false,
        'width2' => 300,
        'height2' => 300,
        'thumb2' => 'Width: 300px - Height: 300px (.jpg|.gif|.png|.jpeg|.webp)',
        'photo3' => false,
        'width3' => 300,
        'height3' => 300,
        'thumb3' => 'Width: 300px - Height: 300px (.jpg|.gif|.png|.jpeg|.webp)',
        'photo4' => false,
        'width4' => 300,
        'height4' => 300,
        'thumb4' => 'Width: 300px - Height: 300px (.jpg|.gif|.png|.jpeg|.webp)',
        'gallery' => [
            'active' => true,
            'width' => 480,
            'height' => 480,
            'thumb' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)'
        ],
        'size' => false,
        'color' => false,

        // Tag
        'tag' => [
            'active' => false,
            'name' => 'Tag sản phẩm',
            'type' => 'san-pham',
            'status' => [
                'noibat' => 'Nổi bật',
                'hienthi' => 'Hiển thị'
            ],
            'number_per_page' => 10,
            'photo' => true,
            'width' => 480,
            'height' => 480,
            'thumb' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
            'seo' => true,
            'seo_title' => true,
            'seo_keyword' => true,
            'seo_desc' => true
        ],

        // Category
        'category' => [
            'name' => 'Danh mục sản phẩm',
            'active' => true,

            'category1' => [
                'active' => true,
                'copy' => true,
                'name' => 'Danh mục cấp 1',
                'type' => 'san-pham',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 480,
                'height1' => 480,
                'thumb1' => 'Width: 480 px - Height: 480 px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 480,
                'height2' => 480,
                'thumb2' => 'Width: 480 px - Height: 480 px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo3' => false,
                'width3' => 480,
                'height3' => 480,
                'thumb3' => 'Width: 480 px - Height: 480 px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo4' => false,
                'width4' => 480,
                'height4' => 480,
                'thumb4' => 'Width: 480 px - Height: 480 px (.jpg|.gif|.png|.jpeg|.webp)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
            'category2' => [
                'active' => true,
                'copy' => true,
                'name' => 'Danh mục cấp 2',
                'type' => 'san-pham',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 480,
                'height1' => 480,
                'thumb1' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 480,
                'height2' => 480,
                'thumb2' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo3' => false,
                'width3' => 480,
                'height3' => 480,
                'thumb3' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo4' => false,
                'width4' => 480,
                'height4' => 480,
                'thumb4' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
            'category3' => [
                'active' => true,
                'copy' => true,
                'name' => 'Danh mục cấp 3',
                'type' => 'san-pham',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 480,
                'height1' => 480,
                'thumb1' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 480,
                'height2' => 480,
                'thumb2' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo3' => false,
                'width3' => 480,
                'height3' => 480,
                'thumb3' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo4' => false,
                'width4' => 480,
                'height4' => 480,
                'thumb4' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
            'category4' => [
                'active' => false,
                'copy' => true,
                'name' => 'Danh mục cấp 4',
                'type' => 'san-pham',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 480,
                'height1' => 480,
                'thumb1' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 480,
                'height2' => 480,
                'thumb2' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo3' => false,
                'width3' => 480,
                'height3' => 480,
                'thumb3' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo4' => false,
                'width4' => 480,
                'height4' => 480,
                'thumb4' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
        ],
        'seo' => true,
        'seo_title' => true,
        'seo_keyword' => true,
        'seo_desc' => true,
        'schema' => true
    ],

    /* NEWS MODULE */
    'tin-tuc' => [
        'active' => true,
        'name' => 'Quản lý tin tức',
        'type' => 'tin-tuc',
        'slug' => true,
        'copy' => true,
        'number_per_page' => 10,
        'status' => [
            'noibat' => 'Nổi bật',
            'hienthi' => 'Hiển thị'
        ],
        'desc' => true,
        'desc_tiny' => true,
        'content' => true,
        'content_tiny' => true,
        'photo1' => true,
        'width1' => 367,
        'height1' => 367,
        'thumb1' => 'Width: 367px - Height: 367px (.jpg|.gif|.png|.jpeg|.webp)',
        'photo2' => false,
        'width2' => 200,
        'height2' => 200,
        'thumb2' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
        'photo3' => false,
        'width3' => 300,
        'height3' => 300,
        'thumb3' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
        'photo4' => false,
        'width4' => 300,
        'height4' => 300,
        'thumb4' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
        'gallery' => [
            'active' => false,
            'width' => 200,
            'height' => 200,
            'thumb' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)'
        ],
        'category' => [
            'name' => 'Danh mục tin tức',
            'active' => true,
            'category1' => [
                'active' => true,
                'copy' => true,
                'name' => 'Danh mục cấp 1',
                'type' => 'tin-tuc',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 367,
                'height1' => 367,
                'thumb1' => 'Width: 367px - Height: 367px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 300,
                'height2' => 300,
                'thumb2' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.gif)',
                'photo3' => false,
                'width3' => 300,
                'height3' => 300,
                'thumb3' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.gif)',
                'photo4' => false,
                'width4' => 300,
                'height4' => 300,
                'thumb4' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.gif)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
            'category2' => [
                'active' => true,
                'copy' => true,
                'name' => 'Danh mục cấp 2',
                'type' => 'tin-tuc',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 367,
                'height1' => 367,
                'thumb1' => 'Width: 367px - Height: 367px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 300,
                'height2' => 300,
                'thumb2' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo3' => false,
                'width3' => 300,
                'height3' => 300,
                'thumb3' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo4' => false,
                'width4' => 300,
                'height4' => 300,
                'thumb4' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
            'category3' => [
                'active' => false,
                'copy' => true,
                'name' => 'Danh mục cấp 3',
                'type' => 'tin-tuc',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 367,
                'height1' => 367,
                'thumb1' => 'Width: 367px - Height: 367px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 300,
                'height2' => 300,
                'thumb2' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo3' => false,
                'width3' => 300,
                'height3' => 300,
                'thumb3' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo4' => false,
                'width4' => 300,
                'height4' => 300,
                'thumb4' => 'Width: 264px - Height: 264px (.jpg|.gif|.png|.jpeg|.webp)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
            'category4' => [
                'active' => false,
                'copy' => true,
                'name' => 'Danh mục cấp 4',
                'type' => 'tin-tuc',
                'number_per_page' => 10,
                'status' => [
                    'noibat' => 'Nổi bật',
                    'hienthi' => 'Hiển thị'
                ],
                'slug' => true,
                'desc' => true,
                'desc_tiny' => true,
                'content' => false,
                'content_tiny' => false,
                'photo1' => true,
                'width1' => 300,
                'height1' => 300,
                'thumb1' => 'Width: 264 px - Height: 264 px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo2' => false,
                'width2' => 300,
                'height2' => 300,
                'thumb2' => 'Width: 264 px - Height: 264 px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo3' => false,
                'width3' => 300,
                'height3' => 300,
                'thumb3' => 'Width: 264 px - Height: 264 px (.jpg|.gif|.png|.jpeg|.webp)',
                'photo4' => false,
                'width4' => 300,
                'height4' => 300,
                'thumb4' => 'Width: 264 px - Height: 264 px (.jpg|.gif|.png|.jpeg|.webp)',
                'seo' => true,
                'seo_title' => true,
                'seo_keyword' => true,
                'seo_desc' => true
            ],
        ],
        'seo' => true,
        'seo_title' => true,
        'seo_keyword' => true,
        'seo_desc' => true,
        'schema' => true
    ],

    /* POST MODULE */
    'post' => [
        'active' => true,
        'name' => 'Quản lý bài viết',

        // Criteria
        'tieu-chi' => [
            'active' => false,
            'name' => 'Tiêu chí',
            'type' => 'tieu-chi',
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'slug' => false,
            'copy' => true,
            'number_per_page' => 10,
            'desc' => true,
            'desc_tiny' => false,
            'content' => false,
            'content_tiny' => false,
            'photo1' => true,
            'width1' => 44,
            'height1' => 44,
            'thumb1' => 'Width: 44px - Height: 44px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo2' => false,
            'width2' => 300,
            'height2' => 300,
            'thumb2' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo3' => false,
            'width3' => 300,
            'height3' => 300,
            'thumb3' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo4' => false,
            'width4' => 300,
            'height4' => 300,
            'thumb4' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'seo' => false,
            'seo_title' => false,
            'seo_keyword' => false,
            'seo_desc' => false,
            'schema' => false
        ],

        // Policy
        'chinh-sach' => [
            'active' => true,
            'name' => 'Chính sách',
            'type' => 'chinh-sach',
            'slug' => true,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'copy' => true,
            'number_per_page' => 10,
            'desc' => true,
            'desc_tiny' => true,
            'content' => true,
            'content_tiny' => true,
            'photo1' => true,
            'width1' => 480,
            'height1' => 480,
            'thumb1' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo2' => false,
            'width2' => 300,
            'height2' => 300,
            'thumb2' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo3' => false,
            'width3' => 300,
            'height3' => 300,
            'thumb3' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo4' => false,
            'width4' => 300,
            'height4' => 300,
            'thumb4' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'seo' => true,
            'seo_title' => true,
            'seo_keyword' => true,
            'seo_desc' => true,
            'schema' => true
        ],
        // Hình thức thanh toán
        'hinh-thuc-thanh-toan' => [
            'active' => true,
            'name' => 'Hình thức thanh toán',
            'type' => 'hinh-thuc-thanh-toan',
            'slug' => false,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'copy' => false,
            'number_per_page' => 10,
            'desc' => true,
            'desc_tiny' => true,
            'content' => false,
            'content_tiny' => false,
            'photo1' => false,
            'width1' => 480,
            'height1' => 480,
            'thumb1' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo2' => false,
            'width2' => 300,
            'height2' => 300,
            'thumb2' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo3' => false,
            'width3' => 300,
            'height3' => 300,
            'thumb3' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'photo4' => false,
            'width4' => 300,
            'height4' => 300,
            'thumb4' => 'Width: 282px - Height: 370px (.jpg|.gif|.png|.jpeg|.webp)',
            'seo' => false,
            'seo_title' => false,
            'seo_keyword' => false,
            'seo_desc' => false,
            'schema' => false
        ]
    ],

    /* PHOTO MODULE */
    'photo' => [
        'active' => true,
        'name' => 'Quản lý hình ảnh',
        'tab_info' => true,
        // Slideshow
        'slideshow' => [
            'active' => true,
            'name' => 'Slideshow',
            'type' => 'slideshow',
            'link' => true,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => false,
            'content' => false,

            'number_per_page' => 10,
            'loop' => 4,
            'action' => 'multiple',
            'photo' => true,
            'with' => 1366,
            'height' => 600,
            'thumb' => 'Width: 1366px - Height: 600px (.jpg|.gif|.png|.jpeg|.webp)',
        ],

        // Partner
        'partner' => [
            'active' => false,
            'name' => 'Đối tác',
            'type' => 'partner',
            'link' => true,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => false,
            'content' => false,
            'number_per_page' => 10,
            'loop' => 4,
            'action' => 'multiple',
            'photo' => true,
            'with' => 175,
            'height' => 95,
            'thumb' => 'Width: 175px - Height: 95px (.jpg|.gif|.png|.jpeg|.webp)',
        ],

        // Social footer
        'social_footer' => [
            'active' => true,
            'name' => 'Social footer',
            'type' => 'social_footer',
            'link' => true,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => false,
            'content' => false,
            'number_per_page' => 10,
            'loop' => 4,
            'action' => 'multiple',
            'photo' => true,
            'with' => 35,
            'height' => 35,
            'thumb' => 'Width: 35px - Height: 35px (.jpg|.gif|.png|.jpeg|.webp)',
        ],

        // Logo
        'logo' => [
            'active' => true,
            'name' => 'Logo',
            'type' => 'logo',
            'link' => false,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => false,
            'content' => false,
            'action' => 'static',
            'photo' => true,
            'with' => 93,
            'height' => 45,
            'thumb' => 'Width: 93 px - Height: 45 px (.jpg|.gif|.png|.jpeg|.webp)',
        ],

        // Favicon
        'favicon' => [
            'active' => true,
            'name' => 'Favicon',
            'type' => 'favicon',
            'link' => false,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => false,
            'content' => false,
            'action' => 'static',
            'photo' => true,
            'with' => 30,
            'height' => 30,
            'thumb' => 'Width: 30px - Height: 30px (.jpg|.gif|.png|.jpeg|.webp)',
        ],

        // Watermark product
        'watermark_product' => [
            'active' => false,
            'layout' => false,
            'name' => 'Watermark product',
            'type' => 'watermark_product',
            'link' => false,
            'status' => [],
            'title' => false,
            'desc' => false,
            'content' => false,
            'action' => 'static',
            'photo' => true,
            'with' => 50,
            'height' => 50,
            'thumb' => 'Width: 50px - Height: 50px (.jpg|.gif|.png|.jpeg|.webp)'
        ],

        // Watermark news
        'watermark_news' => [
            'active' => false,
            'layout' => false,
            'name' => 'Watermark news',
            'type' => 'watermark_news',
            'link' => false,
            'status' => [],
            'title' => true,
            'desc' => false,
            'content' => false,
            'action' => 'static',
            'photo' => true,
            'with' => 50,
            'height' => 50,
            'thumb' => 'Width: 50px - Height: 50px (.jpg|.gif|.png|.jpeg|.webp)'
        ],
    ],

    /* PAGE MODULE */
    'page' => [
        'active' => true,
        'name' => 'Quản lý trang tĩnh',
        'schema_static' => ['gioi-thieu'],
        // About
        'gioi-thieu' => [
            'active' => true,
            'name' => 'Giới thiệu',
            'type' => 'gioi-thieu',
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'slogan' => true,
            'slug' => true,
            'title' => true,
            'desc' => true,
            'desc_tiny' => true,
            'content' => true,
            'content_tiny' => true,
            'seo' => true,
            'seo_title' => true,
            'seo_keyword' => true,
            'seo_desc' => true,
            'photo1' => true,
            'with1' => 300,
            'height1' => 200,
            'thumb1' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo2' => false,
            'with2' => 300,
            'height2' => 200,
            'thumb2' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo3' => false,
            'with3' => 300,
            'height3' => 200,
            'thumb3' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo4' => false,
            'with4' => 300,
            'height4' => 200,
            'thumb4' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)'
        ],

        // Footer
        'footer' => [
            'active' => true,
            'type' => 'footer',
            'name' => "Footer",
            'slug' => false,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => false,
            'desc_tiny' => false,
            'content' => true,
            'content_tiny' => true,
            'photo1' => false,
            'with1' => 300,
            'height1' => 200,
            'thumb1' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo2' => false,
            'with2' => 300,
            'height2' => 200,
            'thumb2' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo3' => false,
            'with3' => 300,
            'height3' => 200,
            'thumb3' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo4' => false,
            'with4' => 300,
            'height4' => 200,
            'thumb4' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'seo' => false,
            'seo_title' => false,
            'seo_keyword' => false,
            'seo_desc' => false
        ],

        // Contact
        'contact' => [
            'active' => true,
            'type' => 'contact',
            'name' => "Contact",
            'slug' => false,
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'title' => false,
            'desc' => false,
            'desc_tiny' => false,
            'content' => true,
            'content_tiny' => true,
            'photo1' => false,
            'with1' => 300,
            'height1' => 200,
            'thumb1' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo2' => false,
            'with2' => 300,
            'height2' => 200,
            'thumb2' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo3' => false,
            'with3' => 300,
            'height3' => 200,
            'thumb3' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo4' => false,
            'with4' => 300,
            'height4' => 200,
            'thumb4' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'seo' => false,
            'seo_title' => false,
            'seo_keyword' => false,
            'seo_desc' => false
        ],

        // Copyright
        'copyright' => [
            'active' => true,
            'type' => 'copyright',
            'name' => "Copyright",
            'slug' => false,
            'status' => ['hienthi' => "Hiển thị"],
            'title' => true,
            'desc' => false,
            'desc_tiny' => false,
            'content' => false,
            'content_tiny' => false,
            'photo1' => false,
            'with1' => 300,
            'height1' => 200,
            'thumb1' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo2' => false,
            'with2' => 300,
            'height2' => 200,
            'thumb2' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo3' => false,
            'with3' => 300,
            'height3' => 200,
            'thumb3' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo4' => false,
            'with4' => 300,
            'height4' => 200,
            'thumb4' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'seo' => false,
            'seo_title' => false,
            'seo_keyword' => false,
            'seo_desc' => false
        ],

        // Slogan
        'slogan' => [
            'active' => true,
            'type' => 'slogan',
            'name' => "Slogan",
            'slug' => false,
            'status' => ['hienthi' => "Hiển thị"],
            'title' => true,
            'desc' => false,
            'desc_tiny' => false,
            'content' => false,
            'content_tiny' => false,
            'photo1' => false,
            'with1' => 300,
            'height1' => 200,
            'thumb1' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo2' => false,
            'with2' => 300,
            'height2' => 200,
            'thumb2' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo3' => false,
            'with3' => 300,
            'height3' => 200,
            'thumb3' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'photo4' => false,
            'with4' => 300,
            'height4' => 200,
            'thumb4' => 'Width: 300px - Height: 200px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'seo' => false,
            'seo_title' => false,
            'seo_keyword' => false,
            'seo_desc' => false
        ],
    ],

    /* SEOPAGE MODULE */
    'seopage' => [
        'active' => true,
        'name' => 'Quản lý seopage',
        // Home
        'home' => [
            'active' => true,
            'name' => 'Trang chủ',
            'type' => 'home',
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'photo' => true,
            'with' => 480,
            'height' => 480,
            'thumb' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'title' => true,
            'keywords' => true,
            'description' => true
        ],

        // Product
        'san-pham' => [
            'active' => true,
            'name' => 'Sản phẩm',
            'type' => 'san-pham',
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'photo' => true,
            'with' => 480,
            'height' => 480,
            'thumb' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'title' => true,
            'keywords' => true,
            'description' => true
        ],

        // News
        'tin-tuc' => [
            'active' => true,
            'name' => 'Tin tức',
            'type' => 'tin-tuc',
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'photo' => true,
            'with' => 480,
            'height' => 480,
            'thumb' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'title' => true,
            'keywords' => true,
            'description' => true
        ],

        // Contact
        'lien-he' => [
            'active' => true,
            'name' => 'Liên hệ',
            'type' => 'lien-he',
            'status' => [
                'hienthi' => 'Hiển thị'
            ],
            'photo' => true,
            'with' => 480,
            'height' => 480,
            'thumb' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.gif|.webp)',
            'title' => true,
            'keywords' => true,
            'description' => true
        ]
    ],

    /* NEWSLETTER MODULE */
    'message' => [
        'active' => true,
        'name' => 'Quản lý nhận tin',
        'newsletter' => [
            'active' => true,
            'type' => 'newsletter',
            'name' => 'Đăng ký nhận tin',
            'fullname' => true,
            'file_attach' => true,
            'email' => true,
            'phone' => true,
            'address' => true,
            'file' => true,
            'content' => true,
            'content_tiny' => true,
            'subject' => true,
            'notes' => true,
            'confirm_status' => true,
            'number_per_page' => 10,
            'file_upload' => '.doc|.docx|.pdf|.rar|.zip|.ppt|.pptx|.xls|.xlsx'
        ],
    ],

    /* VIDEO MODULE */
    'video' => [
        'active' => true,
        'name' => 'Quản lý video',
        'tab_info' => true,
        // Videos
        'video_multiple' => [
            'active' => true,
            'name' => 'Video multiple',
            'action' => 'multiple',
            'type' => 'video_multiple',
            'link' => true,
            'status' => [
                'noibat' => 'Nổi bật',
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => false,
            'content' => false,
            'number_per_page' => 10,
            'action' => 'multiple',
            'photo' => false,
            'with' => 300,
            'height' => 300,
            'thumb' => 'Width: 282 px - Height: 370 px (.jpg|.gif|.png|.jpeg|.gif)',
        ],

        // Video static
        'video_static' => [
            'active' => true,
            'name' => 'Video static',
            'action' => 'static',
            'type' => 'video_static',
            'link' => true,
            'status' => [
                'noibat' => 'Nổi bật',
                'hienthi' => 'Hiển thị'
            ],
            'title' => true,
            'desc' => true,
            'content' => false,
            'action' => 'static',
            'photo' => true,
            'with' => 480,
            'height' => 480,
            'thumb' => 'Width: 480px - Height: 480px (.jpg|.gif|.png|.jpeg|.webp)',
        ]
    ],

    /* PLACE MODULE */
    'place' => [
        'active' => true,
        'name' => 'Quản lý địa điểm',

        //City
        'city' => [
            'active' => true,
            'name' => 'Tỉnh thành',
            'type' => 'city',
            'number_per_page' => 10,
        ],

        //District
        'district' => [
            'active' => true,
            'name' => 'Quận huyện',
            'type' => 'district',
            'number_per_page' => 10,
        ],

        // Ward
        'ward' => [
            'active' => true,
            'name' => 'Phường xã',
            'type' => 'ward',
            'number_per_page' => 10,
        ],
    ],

    /* Order */
    'order' => [
        'active' => true,
        'number_per_page' => 10,
        'name' => 'Đơn hàng'
    ],

    /* SETTING MODULE */
    'setting' => [
        'active' => true,
        'type' => 'setting',
        'name' => 'Thiết lập chung',
        'title' => true,
        'address' => true,
        'fanpage_facebook' => true,
        'email' => true,
        'zalo' => true,
        'oaidzalo' => false,
        'website' => true,
        'hotline' => true,
        'phone' => true,
        'mastertool' => true,
        'analytics' => true,
        'headjs' => true,
        'bodyjs' => true,
        'link_ggmap' => true,
        'iframe_ggmap' => true,
        'worktime' => false
    ]
];
