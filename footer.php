<?php
if(Util::checkMobileDevice()) {
    locate_template('/mobile/footer.php', true);
}else{
    locate_template('/desctope/footer.php', true);
}
?>