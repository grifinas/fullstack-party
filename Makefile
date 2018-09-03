build: build-css
	composer install

serve:
	php artisan serve

build-css:
	sass resources/assets/sass:public/css
