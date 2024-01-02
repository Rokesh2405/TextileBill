<?php
session_start();
ob_start();

//ini_set('display_errors','1');
//error_reporting(E_ALL);
//echo $_SERVER['HTTP_HOST'] ;

if (isset($_REQUEST['show_error']) && $_REQUEST['show_error'] == 'success') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    error_reporting(1);
}


if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $db = new PDO('mysql:host=localhost;dbname=textilebill;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sitename = 'http://localhost/ttbilling/textilebill/';
    $fsitename = 'http://localhost/ttbilling/textilebill/';
    $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    define('WEB_ROOT', $fsitename);
    $docroot = $_SERVER['DOCUMENT_ROOT'] . "/ttbilling/";
} elseif ($_SERVER['HTTP_HOST'] == '192.168.1.81') {
    $db = new PDO('mysql:host=localhost;dbname=5aab;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $connection_string = mysqli_connect("localhost", "root", "", "5aab");
    $sitename = "http://192.168.1.81/5aab/";
    $fsitename = "http://192.168.1.81/5aab/";
    $actual_link = "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
    define('WEB_ROOT', $fsitename);
    $docroot = $_SERVER['DOCUMENT_ROOT'] . "/5aab/";
} else {
    $db = new PDO('mysql:host=localhost;dbname=textilebill;charset=utf8mb4', 'textilebill', 'textilebill');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $connection_string = mysqli_connect("localhost", "textilebill", "textilebill", "textilebill");
    $sitename = "https://ttbilling.in/textilebill/";
    $site = 'https://ttbilling.in/textilebill/';
    $fsitename = 'https://ttbilling.in/textilebill/';
    $actual_link = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    define('WEB_ROOT', $fsitename);
    $docroot = $_SERVER['DOCUMENT_ROOT'] . '/';
}
//ini_set('date.timezone', 'Australia/Melbourne');
//date_default_timezone_set('Australia/Melbourne');
ini_set('session.gc-maxlifetime', 36000);
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '500M');
ini_set('memory_limit', '250M');
ini_set('max_input_time', '4500');
ini_set('max_execution_time', '3000');

function DB($sql) {
    global $connection_string;
    $result = mysqli_query($connection_string, $sql);
    return $result;
}

function DB_QUERY($sql) {
    global $connection_string;
    $result = mysqli_fetch_array(mysqli_query($connection_string, $sql));
    return $result;
}

function DB_NUM($sql) {
    global $connection_string;
    $result = mysqli_num_rows(mysqli_query($connection_string, $sql));
    return $result;
}

if (isset($_REQUEST['show_table']) && $_REQUEST['show_table'] == 'success') {
    $ns = DB("SHOW TABLES");
    while ($fs = mysql_fetch_array($ns)) {
        echo $fs;
    }
    exit;
}

if (!function_exists('mysql_query')) {
    function mysql_query($sql) {
        global $connection_string;
        $result = mysqli_query($connection_string, $sql);
        return $result;
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($sql) {
        global $connection_string;
        $result = mysqli_fetch_array($sql);
        return $result;
    }
}

if (!function_exists('mysql_fetch_row')) {
    function mysql_fetch_row($sql) {
        global $connection_string;
        $result = mysqli_fetch_row($sql);
        return $result;
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($sql) {
        global $connection_string;
        $result = mysqli_num_rows($sql);
        return $result;
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id() {
        global $connection_string;
        $result = mysqli_insert_id($connection_string);
        return $result;
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($val) {
        global $connection_string;
        $result = mysqli_real_escape_string($connection_string, $val);
        return $result;
    }
}

if (!function_exists('mysql_escape_string')) {
    function mysql_escape_string($val) {
        global $connection_string;
        $result = mysqli_real_escape_string($connection_string, $val);
        return $result;
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error() {
        global $connection_string;
        $result = mysqli_error($connection_string);
        return $result;
    }
}

if (!function_exists('mysql_num_fields')) {
    function mysql_num_fields($val) {
        global $connection_string;
        $result = mysqli_num_fields($val);
        return $result;
    }
}

if (!function_exists('mysql_field_name')) {
    function mysql_field_name($val, $i) {
        global $connection_string;
        $result = mysqli_fetch_field_direct($val, $i);
        return $result->name;
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($val) {
        global $connection_string;
        $result = mysqli_close($connection_string);
        return $result;
    }
}

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
        $string = preg_replace_callback("/<[^>]*>/i", create_function('$matches', 'return preg_replace("/ [^ =]*' . $allowattributes . '=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'), $string);
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
include_once ('mail/sendgrid-php-example.php');
include_once ('functions_master.php');
include_once ('functions_pricing.php');
include_once ('functions_jobs.php');
include_once ('functions_com.php');
include_once ('functions_settings.php');
include_once ('functions_accounts.php');

include 'uploadimage.php';

function formatInIndianStyle($num)
{
    return number_format((float) $num, 3, '.', '');
}

function postedago($time)
{
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
?>