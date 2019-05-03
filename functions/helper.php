<?php

if (!function_exists("imgPathToTag")) {

  function imgPathToTag($path, $w, $h, $attributes ='', $retina = true) {
      return Theme\Helper\Thumbnail::path($path, $w, $h, $attributes, $retina);
  }

}

if (!function_exists("thumbIdToTag")) {

  function thumbIdToTag($thumbnail_id, $w, $h, $attributes ='') {
      return Theme\Helper\Thumbnail::id($thumbnail_id, $w, $h, $attributes);
  }

}