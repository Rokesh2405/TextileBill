<?php
include 'config/config.inc.php';
$service = $_REQUEST['service'];

$servlist = $db->prepare("SELECT * FROM `rank` WHERE `service`=? AND `status`=? LIMIT 20");

$servlist->execute(array($service,'1'));
$pcount = $servlist->rowcount();
if($pcount>0)
{ ?>
<option value="">Select</option>
<?php while ($servlisting = $servlist->fetch(PDO::FETCH_ASSOC)) {
  ?>
   <option value="<?php echo $servlisting['id']; ?>"><?php echo $servlisting['name']; ?></option>
<?php } } else {
    echo "failed";  
}
?>