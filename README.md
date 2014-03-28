Laravel Panels
==============

A Laravel 4 package for adding multiple types of widgets like carousels, accordions and tabsets to a website

## Features

* Supports concept of panels to be used in an accordion or a carousel or a set of tabs.
* Each panel can have title, description, link URL, link text and up to 2 images. E.g. a background and an icon image.
* You can define multiple types, or multiple instances of each type to be used on you site.
* Bundled FrozenNode/Administrator config files to manage the panel data, including custom actions for reordering. One
for an accordion and one for a carousel, but you could make your own
* Bundled views that you can include as a partial for example on your site's homepage, and a model method for getting
all the data to populate those views.
* Bundled faker seed that populates your table with fake data, useful for testing

## Installation

Add the following to you composer.json file

    "fbf/laravel-panels": "dev-master"

Run

    composer update

Add the following to app/config/app.php

    'Fbf\LaravelPanels\LaravelPanelsServiceProvider'

Publish the config

    php artisan config:publish fbf/laravel-panels

Before running the migration, ensure you set up the 'types' you need in your app, in the config file that's been published into your app's config folder.

Run the migration

    php artisan migrate --package="fbf/laravel-panels"

Create the relevant image upload directories that you specify in your config, e.g.

    public/uploads/packages/fbf/laravel-panels/homepage_carousel/image_1/original
    public/uploads/packages/fbf/laravel-panels/homepage_carousel/image_1/resized
    public/uploads/packages/fbf/laravel-panels/homepage_carousel/image_2/original
    public/uploads/packages/fbf/laravel-panels/homepage_carousel/image_2/resized
    public/uploads/packages/fbf/laravel-panels/homepage_accordion/image_1/original
    public/uploads/packages/fbf/laravel-panels/homepage_accordion/image_1/resized
    public/uploads/packages/fbf/laravel-panels/homepage_accordion/image_2/original
    public/uploads/packages/fbf/laravel-panels/homepage_accordion/image_2/resized

Optionally change the dimensions of the images you want to use in the config file.

Optionally run the faker seed

    php artisan db:seed --class=Fbf\LaravelPanels\PanelsTableFakeSeeder

## Usage

In your controller

```php
$carouselPanels = Fbf\LaravelPanels\Panel::getData('HOMEPAGE_CAROUSEL');
$accordionPanels = Fbf\LaravelPanels\Panel::getData('HOMEPAGE_ACCORDION');
return View::make('home')->with(compact('carouselPanels', 'accordionPanels'));
```

In your blade template:

```html
@include('laravel-panels::carousel', array('panels' => $carouselPanels))
...
@include('laravel-panels::accordion', array('panels' => $accordionPanels))
```

## Administrator

You can use the excellent Laravel Administrator package by frozennode to administer your carousels, accordions and tabsets.

http://administrator.frozennode.com/docs/installation

Two ready-to-use sample model config files for the Panel model (homepage_carousel.php and homepage_accordion.php) are provided in the src/config/administrator directory of the package, which you can copy into the app/config/administrator directory (or whatever you set as the model_config_path in the administrator config file).
