<?php 
include ('../../config/config.inc.php');

$customer = pFETCH("SELECT * FROM `online_order` WHERE `id`!=?", '0');
while ($row = $customer->fetch(PDO::FETCH_ASSOC)) 
{
$cordate=explode('-',$row['date']);	
$cdate=$cordate['2'].'-'.$cordate['1'].'-'.$cordate['0'].' '.'00:00:00';
 $resa = $db->prepare("UPDATE `online_order` SET `cudate`=? WHERE `id`=?");
            $resa->execute(array($cdate, $row['id']));
 
}

?>