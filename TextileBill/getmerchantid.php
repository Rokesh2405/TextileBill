<?php

include ('config/config.inc.php');
if ($_REQUEST['merchant'] != '') {
    $merchat = FETCH_all("SELECT * FROM `sales_merchant` WHERE `cid`=?", $_REQUEST['merchant']);
    $merchantid = $merchat['merchantid'];
    echo json_encode(array($merchantid));
}

?>      