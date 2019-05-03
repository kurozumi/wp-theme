<?php

/*
 * 初期化処理
 */

/*
 * 不必要なヘッダーのタグを除去
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

/*
 * 絵文字用コード除去
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

/**
 * 親テーマ読み込み後のフック
 */
add_action('after_setup_theme', function() {
    /*
     *  タイトルタグ有効化（4.1以降用）
     */
    add_theme_support('title-tag');

    /*
     * アイキャッチ画像を有効化
     */
    add_theme_support('post-thumbnails');

    /*
     *  head内のフィードリンク有効化
     */
    add_theme_support('automatic-feed-links');
});

if (!function_exists("remove_admin_login_header")) {

    /**
     * 管理バーによる空白削除
     */
    function remove_admin_login_header()
    {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }

    add_action('get_header', 'remove_admin_login_header');
}