<?php

namespace Theme\Hook\Enqueue;

/**
 * $Styles = Theme\Hook\Enqueue\Styles();
 * $Styles->enqueue("bootstrap", "assets/css/script/bootstrap.css");
 * add_action("wp_enqueue_scripts", [$Styles, 'register']);
 */
class Styles extends \Theme\Singleton {
    
    public function __construct()
    {
        wp_enqueue_style('style', get_stylesheet_uri());;
    }
    
    public function enqueue($handle, $src) {
        wp_enqueue_style($handle, get_template_directory_uri() . ltrim($src, "/"), ["style"]);
        
        return $this;
    }
}