<?php
include 'config/config.inc.php';
$membership = $_REQUEST['membership'];
$cckuser = FETCH_all("SELECT * FROM `membership` WHERE `cid` = ?", $membership);
if($cckuser['valid_fromdate']!='' && $cckuser['valid_todate']!='')
{
echo $result=$cckuser['valid_fromdate'].'<***>'.$cckuser['valid_todate'];
}
else
{
 echo $result='failed';
}
?>