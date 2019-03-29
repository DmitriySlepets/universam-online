<?php

class Util
{
    //определение мобильного устройства
    public static function checkMobileDevice(){
        $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        // var_dump($agent);exit;
        foreach ($mobile_agent_array as $value) {
            if (strpos($agent, $value) !== false) return true;
        }
        return false;
    }
    //определить где директ яндекс размещать, а где тематическую рекламу
    public static function itsDirect(){
        $urlRight = $_SERVER['REQUEST_URI'];
        //$arrayDirect = array('usloviya-zakaza','kontakty','not_paid','politika-konfidentsialnosti','my_account');
        $arrayDirect = array('s=');
        $findInArray = false;
        foreach ($arrayDirect as $itemDirect){
            $keySearchPagesDirect = strpos($urlRight,$itemDirect);
            if($keySearchPagesDirect!=false){
                $findInArray = true;
                break;
            } //if($keySearchPagesDirect>0)
        } //foreach ($arrayDirect as $item)
        return $findInArray;
    }

}

?>