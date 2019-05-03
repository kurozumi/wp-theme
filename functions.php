<?php

/**
 * Composerによる、パッケージのオートロード
 */
require __DIR__ . '/vendor/autoload.php';

//functinsディレクトリ内のPHPファイルを読み込み
foreach ( glob( TEMPLATEPATH . '/functions/*.php' ) as $file ) {
  require_once $file;
}

add_action('wp', [Theme\Api\Post::getInstance, 'register']);
add_action('wp', [Theme\Hook\Svg::getInstance, 'register']);

$Styles = Theme\Hook\Enqueue\Styles::getInstance;
$Styles->enqueue("bootstrap", "assets/css/bootstrap.css");
add_action("wp_enqueue_scripts", [$Styles, 'register']);

$Scripts = Theme\Hook\Enqueue\Scripts::getInstance;
$Scripts->enqueue("slick", "assets/js/bundle.js");
add_action("wp_enqueue_scripts", [$Scripts, "register"]);

$Thumbnails = Theme\Helper\Thumbnail::getInstance;
$Thumbnails->addImageSize([
    [100, 100, true]
]);