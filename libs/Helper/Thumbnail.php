<?php

namespace Theme\Helper;

/**
 * レティーナ対応imgタグ出力
 * 
 * echo Theme\Helper\Thumbnail::path(path, widht, height)
 * echo Theme\Helper\Thumbnail::id(thumbnail_id, widht, height)
 * 
 * $Thumbnails = Theme\Helper\Thumbnail::getInstance;
 * $Thumbnails->addImageSize([
 *     [100, 100, true]
 * ]);
 */
class Thumbnail extends \Theme\Singleton {

    /**
     * 画像パスからレティーナ対応のimgタグを出力
     * 
     * @param string $path
     * @param int $w
     * @param int $h
     * @param string $attributes
     * @param bool $retina
     * @return string
     */
    public static function path($path, $w, $h, $attributes = '', $retina = true)
    {
        $path1 = ltrim($path, "/");
        $path2 = preg_replace("/(.*)(\.[png|gif|jpe?g])/", "$1@2x$2", $path1);

        if (is_null($path2))
            return null;

        if ($retina) {
            return '<img src="' . sprintf("%s/%s", get_template_directory_uri(), $path1) . '"'
                    . ' srcset="' . sprintf('%1$s/%2$s 1x,%1$s/%3$s 2x', get_template_directory_uri(), $path1, $path2) . '"'
                    . ' width="' . $w . '" height="' . $h . '" ' . $attributes . ' />';
        }

        return '<img src="' . sprintf("%s/%s", get_template_directory_uri(), $path1) . '"'
                . ' width="' . $w . '" height="' . $h . '" ' . $attributes . ' />';
    }

    /**
     * 画像パスからレティーナ対応のimgタグを出力
     * 
     * @param string $path
     * @param int $w
     * @param int $h
     * @param string $attributes
     * @param bool $retina
     * @return string
     */
    public static function id($thumbnail_id, $w, $h, $attributes = '')
    {
        $normal = wp_get_attachment_image_src($thumbnail_id, $w . 'x' . $h);
        $retina = wp_get_attachment_image_src($thumbnail_id, $w . 'x' . $h . '@2x');

        if ($retina[1] == $w * 2 && $retina[2] == $h * 2) {
            return '<img src="' . $normal[0] . '"'
                    . ' srcset="' . sprintf('%s 1x, %s 2x', $normal[0], $retina[0]) . '"'
                    . ' width="' . $normal[1] . '" height="' . $normal[2] . '" ' . $attributes . ' />';
        } else {
            return '<img src="' . $normal[0] . '"'
                    . ' width="' . $normal[1] . '" height="' . $normal[2] . '" ' . $attributes . ' />';
        }
    }

    /*
     * 画像サイズ登録
     * [width, height, [true|false|array]]
     * 
     * 3番目の値について
     * ・trueはセンターでトリミング
     * ・falseはトリミングしない
     * ・配列の場合、[x, y]で指定可能。xは[left|right]、yは[top|bottom]
     */

    public function addImageSize(array $sizes = [])
    {
        $e = new \WP_Error();
        
        foreach ($sizes as $i => $size) {
            if(count($size) != 3) {
                $e->add('addImageSize Error', sprintf('%s番目の配列が正しくありません', $i));
                continue;
            }
            
            add_image_size(sprintf("%dx%d", $size[0], $size[1]), $size[0], $size[1], $size[2]);
            add_image_size(sprintf("%dx%d@2x", $size[0], $size[1]), $size[0] * 2, $size[1] * 2, $size[2]);
        }
        
        if($e->get_error_code()) {
            return $e;
        }
        
        return true;
    }

}
