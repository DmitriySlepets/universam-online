<?php
if(Util::checkMobileDevice()) {
    locate_template('/mobile/header.php', true);
}else{
    locate_template('/desctope/header.php', true);
}
?>