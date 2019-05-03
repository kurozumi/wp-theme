<?php

namespace Theme\Hook;

/**
 * カスタムタクソノミーのURLのタクソノミー名を変更
 * 
 * $CustomeTermLink = new Theme\CustomeTermLink();
 * $CustomeTermLink->news_taxonomy = "news";
 * $CustomeTermLink->register();
 * 
 */
class TermLink {
  
  private $taxonomy = array();
  
  public function register() {
    add_filter('term_link', array($this, "change"), 11, 3);
  }
  
  public function __set($name, $value) {
    $this->taxonomy[$name] = $value;
  }
  
  public function change($termlink, $term, $taxonomy) {
    foreach($this->taxonomy as $old_taxonomy => $new_taxonomy) {
      if($taxonomy == $old_taxonomy) {
        return str_replace('/' . $taxonomy . '/', '/' . $new_taxonomy . '/', $termlink);
      }
    }
    
    return $termlink;
  }
}