<?php

namespace Theme\Api;

/**
 * Post API
 *
 * add_action('wp', [Theme\Service\Ajax\Post::getInstance, 'register']);
 */
class Post extends \Theme\Singleton {

    public $charset;

    public function __construct()
    {
        $this->charset = get_bloginfo('charset');

        if (isset($_REQUEST['action'])) {
            add_action('wp_ajax_' . $_REQUEST['action'], [$this, $_REQUEST['action']]);
            add_action('wp_ajax_nopriv_' . $_REQUEST['action'], [$this, $_REQUEST['action']]);
        }
    }

    public function posts()
    {
        nocache_headers();
        header("Content-Type: application/json; charset={$this->charset}");

        $url = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url['query'], $params);

        $result = Post::request(new \WP_Query(Post::query($params)));
        $response = json_encode(["posts" => $result]);

        die($response);
    }

    private function query($args = [])
    {
        $defualts = array(
            'ignore_sticky_posts' => 1,
            'posts_per_page' => -1,
            'post_type' => 'products',
            'post_status' => 'publish',
        );

        return wp_parse_args($args, $defualts);
    }

    private function request($query)
    {
        $posts = [];
        while ($query->have_posts()) {
            $query->the_post();
            $posts[] = [
                "ID" => get_the_ID(),
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
            ];
        }
        wp_reset_postdata();

        return $posts;
    }

}
