<?php

function magic_modifier_imgurl_format($string, $type = ''){
  
   return "/plugins/index.action?q=imgurl&url=".Key2Url($string,"@imgurl@");

}
?>
