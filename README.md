#PHP Laravel Framework Version 10
#Duplicate ra một source code mới trước khi upload source code lên hosting domain
#Export database từ local
#Xóa các file không cần thiết trong môi trường development bằng các câu lệnh sau:

```php
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan event:clear
php artisan route:clear
```

#Cấu hình lại file .env trước khi upload source code lên hosting domain

#Trong trường hợp không có chứng chỉ SSL cần cấu hình lại file .htaccess

```htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} on
    RewriteRule (.*) http://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#Trong trường hợp có chứng chỉ SSL cần cấu hình lại file .htaccess

```htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#Xóa các view, controller và model không dùng để bảo mật hệ thống trước khi upload source code lên hosting domain

#Dọn dẹp các module chỉ dùng cho môi trường development

```php
composer install --optimize-autoloader --no-dev
```

#Lưu ý 1: Phải kiểm tra xem hosting đã trỏ IP chưa và nó đã hoạt động chưa
#Lưu ý 2: Sau khi đã kiểm tra các lưu ý trên. Ta tiến hành nén source code thành file .zip để đảm bảo upload đầy đủ file lên hosting domain
