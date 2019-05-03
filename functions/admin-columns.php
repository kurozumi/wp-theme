<?php

add_filter('manage_edit-post_columns', function($columns) {
    $columns['pickup'] = "Pickup";
    return $columns;
}, 999);

add_action('manage_posts_custom_column', function($column_name, $post_id) {
    if ($column_name == "pickup") {
        $pickup = get_post_meta($post_id, "pickup", true);

        if ($pickup) {
            echo '<i class="dashicons dashicons-yes"></i>';
        }
    }
}, 999, 2);

add_action('restrict_manage_posts', function($post_type) {
    if ($post_type == "post") {

        $pickup = filter_input(INPUT_GET, "pickup");
        $items = array("" => "すべての記事", 1 => "Pickup");
        echo '<select name="pickup">';
        foreach ($items as $value => $text) {
            $selected = selected($pickup, $value, false);
            echo '<option value="' . esc_attr($value) . '"' . $selected . '>' . esc_html($text) . '</option>';
        }
        echo '</select>';
    }
}, 10, 2);

add_action('pre_get_posts', function($wp_query) {
    if (!is_admin() || !$wp_query->is_main_query()) {
        return;
    }

    if ($wp_query->query["post_type"] == "post") {
        $value = filter_input(INPUT_GET, "pickup");
        if (strlen($value) > 0) {
            $meta_query = $wp_query->get('meta_query');
            if (!is_array($meta_query)) {
                $meta_query = array();
            }

            $meta_query[] = array(
                "key" => "pickup",
                "value" => $value
            );

            $wp_query->set('meta_query', $meta_query);
        }
    }
});
