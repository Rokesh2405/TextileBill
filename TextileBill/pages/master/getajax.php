<?php 
include ('../../config/config.inc.php');


if($_REQUEST['areaid']!='') {
$area=$_REQUEST['areaid'];

$beats = pFETCH("SELECT * FROM `customer` WHERE `area`=? ", $area);
?>
<div class="row">

<?php
while($rowbeats = $beats->fetch(PDO::FETCH_ASSOC)){
    ?>
<div class="col-md-3">
<input type="checkbox" name="customer[]" value="<?php echo $rowbeats['id']; ?>" />&nbsp;&nbsp; <?php echo $rowbeats['name']; ?>  

</div>
<?php
}
?>
</div>
<?php } 


if($_REQUEST['beatname']!='') {
$expcus=explode('-',$_REQUEST['beatname']);
$beatname=$expcus[0];
$areaname=$expcus[1];
$beats = pFETCH("SELECT * FROM `beat` WHERE beatname =? AND `area`=? ", $beatname,$areaname);
$rowbeats = $beats->fetch(PDO::FETCH_ASSOC);
$cusarry=explode(',',$rowbeats['customer']);
?>
<div class="row">
<?php
foreach($cusarry as $cusarry1) 
{
    ?>
<div class="col-md-3">
<input type="checkbox" name="beatcustomer[<?php echo $_REQUEST['pos']; ?>][]" value="<?php echo $cusarry1; ?>" />&nbsp;&nbsp; <?php echo getcustomer('name',$cusarry1); ?>  

</div>
<?php
}
?>
</div>
<?php } ?>



<?php
if($_REQUEST['area']!='') {
$service = explode('-',$_REQUEST['area']);
$beatname=$service['1'];

$servlist = $db->prepare("SELECT * FROM `beat` WHERE `beatname`=? GROUP BY `area` ");

$servlist->execute(array($beatname));
$pcount = $servlist->rowcount();
if($pcount>0)
{ ?>
<option value="">Select</option>
<?php while ($servlisting = $servlist->fetch(PDO::FETCH_ASSOC)) {
  ?>
   <option value="<?php echo $servlisting['beatname'].'-'.$servlisting['area']; ?>"><?php echo $servlisting['area']; ?></option>
<?php } } else { ?>
    <option value="">Select</option>
<?php }
}
?>