<?php
    // save this as clean.php
    function clean($str) {
       $str = @trim($str);
       if(get_magic_quotes_gpc()) {
              $str = stripslashes($str);
       }
       return mysql_real_escape_string($str);
    }
?>
