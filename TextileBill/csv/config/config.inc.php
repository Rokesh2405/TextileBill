<?php
session_start();
ob_start();
error_reporting(0);
if(isset($_REQUEST['show'])){
//ini_set('display_errors','1');
error_reporting(E_ALL);
//print_r($_SESSION);
}

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $db = new PDO('mysql:host=localhost;dbname=leo_agri;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sitename = 'http://localhost/leo-agri/';
    $fsitename = 'http://localhost/leo-agri/';
    $actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    define('WEB_ROOT', $fsitename);
    $docroot = $_SERVER['DOCUMENT_ROOT'] . "/leo-agri/";
} elseif ($_SERVER['HTTP_HOST'] == '192.168.1.81') {
    $db = new PDO('mysql:host=localhost;dbname=leo_agri;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sitename = "http://192.168.1.81/leo-agri/";
    $fsitename = "http://192.168.1.81/leo-agri/";
    $actual_link = "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
    define('WEB_ROOT', $fsitename);
    $docroot = $_SERVER['DOCUMENT_ROOT'] . "/leo-agri/";
} else {
   $db = new PDO('mysql:host=localhost;dbname=wwwnbays_leoagri;charset=utf8mb4', 'wwwnbays_leo' , 'wwwnbays_leo');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sitename = 'http://www.nbays.com.au/leo-agrinew/';
    $fsitename = 'http://www.nbays.com.au/leo-agrinew/';
    define('WEB_ROOT', $fsitename);
    $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

ini_set('date.timezone', 'Asia/Kolkata');
date_default_timezone_set('Asia/Kolkata');

ini_set('session.gc-maxlifetime', 36000);

ini_set('upload_max_filesize', '100M');

ini_set('post_max_size', '500M');

ini_set('memory_limit', '250M');

ini_set('max_input_time', '4500');

ini_set('max_execution_time', '3000');

function pFETCH($sql, $a = '', $b = '', $c = '', $d = '', $e = '', $f = '', $g = '', $h = '', $i = '', $j = '') {

    global $db;

    $stmt3 = $db->prepare($sql);
    if (($j == '') && ($i == '') && ($h == '') && ($g == '') && ($f == '') && ($e == '') && ($d == '') && ($c == '') && ($b == '')) {
        $a = str_replace('null', '', $a);
        $stmt3->execute(array($a));
    } elseif (($j == '') && ($i == '') && ($h == '') && ($g == '') && ($f == '') && ($e == '') && ($d == '') && ($c == '')) {
        $a = str_replace('null', '', $a);
        $b = str_replace('null', '', $b);
        $stmt3->execute(array($a, $b));
    } elseif (($j == '') && ($i == '') && ($h == '') && ($g == '') && ($f == '') && ($e == '') && ($d == '')) {
        $a = str_replace('null', '', $a);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $stmt3->execute(array($a, $b, $c));
    } elseif (($j == '') && ($i == '') && ($h == '') && ($g == '') && ($f == '') && ($e == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $stmt3->execute(array($a, $b, $c, $d));
    } elseif (($j == '') && ($i == '') && ($h == '') && ($g == '') && ($f == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $stmt3->execute(array($a, $b, $c, $d, $e));
    } elseif (($j == '') && ($i == '') && ($h == '') && ($g == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $f = str_replace('null', '', $f);
        $stmt3->execute(array($a, $b, $c, $d, $e, $f));
    } elseif (($j == '') && ($i == '') && ($h == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $f = str_replace('null', '', $f);
        $g = str_replace('null', '', $g);
        $stmt3->execute(array($a, $b, $c, $d, $e, $f, $g));
    } elseif (($j == '') && ($i == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $f = str_replace('null', '', $f);
        $g = str_replace('null', '', $g);
        $h = str_replace('null', '', $h);
        $stmt3->execute(array($a, $b, $c, $d, $e, $f, $g, $h));
    } elseif (($j == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $f = str_replace('null', '', $f);
        $g = str_replace('null', '', $g);
        $h = str_replace('null', '', $h);
        $i = str_replace('null', '', $i);
        $stmt3->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $i));
    } else {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $f = str_replace('null', '', $f);
        $g = str_replace('null', '', $g);
        $h = str_replace('null', '', $h);
        $i = str_replace('null', '', $i);
        $j = str_replace('null', '', $j);
        $stmt3->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $i, $j));
    }
    return $stmt3;
}

function FETCH_all($sql, $a = '', $b = '', $c = '', $d = '', $e = '', $f = '', $g = '') {
    global $db;
    $stmt3 = $db->prepare($sql);
    if (($g == '') && ($f == '') && ($e == '') && ($d == '') && ($c == '') && ($b == '')) {
        $a = str_replace('null', '', $a);
        $stmt3->execute(array($a));
    } elseif (($g == '') && ($f == '') && ($e == '') && ($d == '') && ($c == '')) {
        $a = str_replace('null', '', $a);
        $b = str_replace('null', '', $b);
        $stmt3->execute(array($a, $b));
    } elseif (($g == '') && ($f == '') && ($e == '') && ($d == '')) {
        $a = str_replace('null', '', $a);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $stmt3->execute(array($a, $b, $c));
    } elseif (($g == '') && ($f == '') && ($e == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $stmt3->execute(array($a, $b, $c, $d));
    } elseif (($g == '') && ($f == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $stmt3->execute(array($a, $b, $c, $d, $e));
    } elseif (($g == '')) {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $f = str_replace('null', '', $f);
        $stmt3->execute(array($a, $b, $c, $d, $e, $f));
    } else {
        $a = str_replace('null', '', $a);
        $d = str_replace('null', '', $d);
        $b = str_replace('null', '', $b);
        $c = str_replace('null', '', $c);
        $e = str_replace('null', '', $e);
        $f = str_replace('null', '', $f);
        $g = str_replace('null', '', $g);
        $stmt3->execute(array($a, $b, $c, $d, $e, $f, $g));
    }

    $per = $stmt3->fetch(PDO::FETCH_ASSOC);
    return $per;
}

function strip_tags_attributes($string, $allowtags = NULL, $allowattributes = NULL) {
    $string = strip_tags($string, $allowtags);
    if (!is_null($allowattributes)) {
        if (!is_array($allowattributes))
            $allowattributes = explode(",", $allowattributes);
        if (is_array($allowattributes))
            $allowattributes = implode(")(?<!", $allowattributes);
        if (strlen($allowattributes) > 0)
            $allowattributes = "(?<!" . $allowattributes . ")";
        $string = preg_replace_callback("/<[^>]*>/i", create_function(
                        '$matches', 'return preg_replace("/ [^ =]*' . $allowattributes . '=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'
                ), $string);
    }
    return $string;
}

function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function getClientIP() {

    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
        return trim(end(explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"])));
    } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER["REMOTE_ADDR"];
    } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER["HTTP_CLIENT_IP"];
    } else {
        return '';
    }
}

//$array = json_decode(file_get_contents('https://freegeoip.net/json/' . getClientIP()), true);
if ($array['country_code'] != '') {
    $ipcountry = $array['country_code'];
} else {
    $ipcountry = 'India';
}
$ipregion = $array['region_name'];
$iplatitude = $array['latitude'];
$iplongitude = $array['longitude'];


include_once ('menuconfig.php');
#include_once ('mail/sendgrid-php-example.php');
include_once ('functions_com.php');
include_once ('functions_settings.php');
include_once ('functions_process.php');
include_once ('functions_stock.php');

function formatInIndianStyle($num) {

    return number_format((float) $num, 3, '.', '');
}

function postedago($time) {

    $time = time() - $time; // to get the time since that moment
    //echo $time;
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit)
            continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
    }
}

function alltax($idd)
{
    global $db;
    $val = '';
    $depart = $db->prepare("SELECT * FROM `tax` WHERE `status`!=? AND `company_id`=? ORDER BY `tid` DESC");
    $depart->execute(array(2, $_SESSION['COMPANY_ID']));
    while ($fit = $depart->fetch()) {
        $selct = '';
        if ($fit['tid'] == $idd) {
            $selct = 'selected="selected"';
        }
        $val.='<option value="' . $fit['tid'] . '" ' . $selct . '>' . $fit['taxname'] . ' - ' . $fit['taxpercentage'] . ' %</option>';
    }
    return $val;
}

function allitem($given)
{
    global $db;
    $val = '';
    $depart = $db->prepare("SELECT * FROM `item_master` WHERE `status`!=? AND `company_id`=?    ORDER BY `Item_Id` DESC");
    $depart->execute(array(2, $_SESSION['COMPANY_ID']));
    while ($fit = $depart->fetch()) {
        $selct = '';
        if ($fit['Item_Id'] == $given) {
            $selct = 'selected="selected"';
        }
        $val.='<option value="' . $fit['Item_Id'] . '" ' . $selct . '>' . $fit['Item_Code'] . ' - ' . $fit['Item_Name'] . ' </option>';
    }
    return $val;
}
$db->tax_disp = getprofile('tax') !='' ? getprofile('tax') : 'Tax';
define('D', getcurrency_new('digit',getprofile('currency')));
$n_step = ['1','0.1','0.01','0.001'];
define('SD',$n_step[D]);
if(!isset($_SESSION['currency_rates'])){
    $s = $db->prepare("SELECT concat(from_cur,'_',to_cur) as arr,value FROM `currency_rates_new` WHERE `company_id`=?");
    $s->execute(array($_SESSION['COMPANY_ID']));
    $alrts = [];
    while($s1 = $s->fetch()){
        $alrts[$s1['arr']] = $s1['value'];
    }
    $_SESSION['currency_rates'] = $alrts;
}

if(!isset($_SESSION['CD'])){
    $s = $db->prepare("SELECT `id`,`digit` FROM `currency_new`");
    $s->execute();
    $alcd = [];
    $alcd[0] = '2';
    while($s1 = $s->fetch()){
        $alcd[$s1['id']] = $s1['digit'];
    }
    
    $s = $db->prepare("SELECT `CusID`,`Currency` FROM `customer` WHERE `company_id`=?");
    $s->execute(array("'".$_SESSION['COMPANY_ID']."'"));
    $alcdc = [];
    $alcdc[0] = '2';
    while($s1 = $s->fetch()){
        $alcdc[$s1['CusID']] = $alcd[$s1['Currency']];
    }
    
    $s = $db->prepare("SELECT `SupID`,`Currency` FROM `suppliers` WHERE `company_id`=?");
    $s->execute(array("'".$_SESSION['COMPANY_ID']."'"));
    $alcds = [];
    $alcds[0] = '2';
    while($s1 = $s->fetch()){
        $alcds[$s1['SupID']] = $alcd[$s1['Currency']];
    }
    $_SESSION['CD']['C'] = $alcdc;
    $_SESSION['CD']['S'] = $alcds;
    $_SESSION['CD']['A'][1] = D;
}
function getDigit($id,$type){
    return ($_SESSION['CD'][$type][$id]!=='') ? $_SESSION['CD'][$type][$id] : '2';
}
?>