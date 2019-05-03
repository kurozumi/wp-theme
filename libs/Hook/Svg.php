<?php

namespace Theme\Hook;

/**
 * SVGファイル有効化
 * 
 * add_action('wp', [Theme\Hook\Svg::getInstance, 'register']);
 */
class Svg extends \Theme\Singleton {

    public function __construct()
    {
        add_filter("ext2type", [$this, "ext2type"]);
        add_filter("upload_mimes", [$this, "uploadMimes"]);
        add_filter('getimagesize_mimes_to_exts', [$this, "getimagesizeMimesToExts"]);
    }

    /**
     * svg画像アップロード有効化
     * 
     * @param type $ext2types
     * @return type
     */
    public function ext2type($ext2types)
    {
        array_push($ext2types, ['image' => ['svg', 'svgz']]);
        return $ext2types;
    }

    /**
     * svg画像アップロード有効化
     * 
     * @param type $mimes
     * @return string
     */
    public function uploadMimes($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        return $mimes;
    }

    /**
     * svg画像アップロード有効化
     * 
     * @param array $mime_to_ext
     * @return array
     */
    public function getimagesizeMimesToExts($mime_to_ext)
    {
        $mime_to_ext['image/svg+xml'] = 'svg';
        return $mime_to_ext;
    }

}
