<?php

namespace Theme\Hook\Enqueue;

/**
 * $Scripts = Theme\Hook\Enqueue\Styles();
 * $Scripts->enqueue("bootstrap", "assets/js/script/bootstrap.js");
 * add_action("wp_enqueue_scripts", [$Styles, 'register']);
 */
class Scripts extends \Theme\Singleton {

    public function __construct()
    {
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array(), '2.1.3');
    }
    
    public function enqueue($handle, $src, $in_footer = false) {
        wp_enqueue_script($handle, get_template_directory_uri() . ltrim($src, "/"), ['jquery'], false, $in_footer);
        
        return $this;
    }
    
    public function localize($handle, $name ,$data = []) {
        wp_localize_script($hanlde, $name, $data);
    }
}