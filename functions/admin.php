<?php
/*
 * 管理画面
 */

/*
 * コアファイルの更新を停止
 */
add_filter('pre_site_transient_update_core', '__return_null');

/*
 * プラグイン更新通知を非表示
 */
remove_action('load-update-core.php', 'wp_update_plugins');
add_filter('pre_site_transient_update_plugins', '__return_null');

if (!function_exists("custom_login_logo_url")) {

  /**
   * ログイン画面カスタマイズ
   * 
   * @return type
   */
  function custom_login_logo_url() {
    return get_bloginfo('url');
  }

  //add_filter('login_headerurl', 'custom_login_logo_url');
}

if (!function_exists("admin_css")) {

  /**
   * 管理画面にオリジナルCSS追加
   */
  function admin_css() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/admin.css">';
  }

  //add_action('login_head', 'admin_css');
}

if (!function_exists("theme_add_editor_styles")) {

  /**
   * ビジュアルエディタにオリジナルCSS適用
   */
  function theme_add_editor_styles() {
    add_editor_style("css/editor-style.css");
  }

  //add_action("admin_init", "theme_add_editor_styles");
}

if (!function_exists("post_has_archive")) {

  /**
   * 投稿にアーカイブ（投稿一覧）を持たせるように変更
   * 
   * @param type $args
   * @param type $post_type
   * @return string
   */
  function post_has_archive($args, $post_type) {
    if ('post' == $post_type) {
      $args['rewrite'] = true;
      $args['label'] = 'NEWS';
      $args['has_archive'] = 'news'; //ページ名
    }
    return $args;
  }

  //add_filter('register_post_type_args', 'post_has_archive', 10, 2);
}

/*
 * 投稿アーカイブのURLを取得できるように変更
 */
if (!function_exists("custom_post_type_archive_link")) {

  function custom_post_type_archive_link($link, $post_type) {
    if ('post' === $post_type) {
      $link = home_url('/news/');
    }
    return $link;
  }

  //add_filter('post_type_archive_link', 'custom_post_type_archive_link', 10, 2);
}

if (!function_exists("add_rule_page_template_hierarchy")) {

  /**
   * 固定ページの下階層用テンプレート名ルールを追加する
   * page-親slugname__子slugname.php
   * 
   * @global WP_Query $wp_query
   * @param string $templates
   * @return string
   */
  function add_rule_page_template_hierarchy($templates) {
    global $wp_query;

    $template = get_page_template_slug();
    $pagename = $wp_query->query["pagename"];

    if ($pagename && !$template) {
      $pagename = str_replace("/", "__", $pagename);
      $decoded = urldecode($pagename);

      if ($decoded == $pagename) {
        array_unshift($templates, "page-{$pagename}.php");
      }
    }

    return $templates;
  }

  //add_filter('page_template_hierarchy', 'add_rule_page_template_hierarchy');
}

if (function_exists('acf_add_options_page')) {
  /**
   * ACFのオプションページ追加
   */
  $args = array(
      'page_title' => 'テーマオプション',
      'menu_title' => 'テーマオプション',
      'menu_slug' => 'theme-general-settings',
  );
  //$option_page = acf_add_options_page($args);

  /**
   * 
   */
  if (isset($option_page)) {
    $args = array(
        'page_title' => '共通パーツ',
        'menu_title' => '共通パーツ',
        'menu_slug' => 'theme-common-settings',
        'parent_slug' => $option_page['menu_slug'],
    );
    //acf_add_options_sub_page($args);
  }
}
