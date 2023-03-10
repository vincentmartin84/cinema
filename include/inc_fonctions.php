<?php
function mhe($chaine) {
    return htmlentities($chaine,ENT_QUOTES,"UTF-8");
}

function mres($chaine) {
    global $link;
    return mysqli_real_escape_string($link,$chaine);
}
?>