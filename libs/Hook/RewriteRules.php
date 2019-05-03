<?php

namespace Theme\Hook;

/**
 * カスタムタクソノミーのURLからタクソノミー名を削除する方法
 * 
 * @変更例
 * news_taxonomuy/term => news/term
 * 
 * $RewriteRules = new Theme\Hook\RewriteRules();
 * $RewriteRules->setRule(array(
 *    "news/([^/]+)/?$" => "index.php?post_type=news&news_taxonomy=$matches[1]",
 *    "news/([^/]+)/page/([0-9]+)/?$" => "index.php?post_type=news&news_taxonomy=$matches[1]&paged=$matches[2]"
 *  ));
 * $RewriteRules->flush();
 * 
 */
class RewriteRules {

  private $rules = array();

  public function flush() {
    add_filter('rewrite_rules_array', array($this, "rewriteRulesArray"));
    add_filter('init', array($this, "flushRules"));
  }

  /**
   * 新しいルール設定
   * 
   * @param type $rule
   */
  public function setRule($rule) {
    $this->rules = array_merge($this->rules, $rule);
  }

  /**
   * 新しいルール取得
   * 
   * @return type
   */
  public function getRule() {
    return $this->rules;
  }

  /**
   * ルール追加
   * 
   * @param type $rules
   * @return type
   */
  public function rewriteRulesArray($rules) {
    return $this->getRule() + $rules;
  }

  /**
   * ルールを追加後にflush_rules()
   * 
   * @global type $wp_rewrite
   */
  public function flushRules() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
  }

}
