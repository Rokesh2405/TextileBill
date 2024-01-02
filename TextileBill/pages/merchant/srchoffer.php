<?php include ('../../config/config.inc.php');
//print_r($_REQUEST);
if($_REQUEST['customerid']!='' && $_REQUEST['mobileno']!='')
{
$customerdetails = FETCH_all("SELECT * FROM `customer` WHERE `customerid`=? OR (`cnumber`=? OR `scnumber`=? )" , $_REQUEST['customerid'],$_REQUEST['mobileno'], $_REQUEST['mobileno']); 
}
else if($_REQUEST['customerid']!='')
{
 $customerdetails = FETCH_all("SELECT * FROM `customer` WHERE `customerid`=?",$_REQUEST['customerid']); 
}
else if($_REQUEST['mobileno']!='')
{ 
$customerdetails = FETCH_all("SELECT * FROM `customer` WHERE (`cnumber`=? OR `scnumber`=? )",$_REQUEST['mobileno'],$_REQUEST['mobileno']); 
}
else
{

}

?>
<br><br>
<form name="cusform" id="cusform" method="post" action="<?php echo $sitename; ?>merchant/findcustomer.htm">
<input type="text" name="customerid" id="customerid" value="<?php echo $customerdetails['customerid']; ?>">
<?php if($customerdetails['cnumber']!='') { ?>
<input type="text" name="mobileno" id="mobileno" value="<?php echo $customerdetails['cnumber']; ?>">
<?php } else { ?>
<input type="text" name="mobileno" id="mobileno" value="<?php echo $customerdetails['scnumber']; ?>">
<?php } ?>

<div class="panel panel-info">

<div class="panel-heading">Customer Details </div>

<div class="panel-body">
<div class="row">
<div class="col-md-4">
<label>Customer ID</label>&nbsp;&nbsp;:&nbsp;&nbsp;      
<?php echo $customerdetails['customerid']; ?>                           
</div>
<div class="col-md-4">
<label>Customer Name</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo $customerdetails['cname']; ?>                           
</div>
<div class="col-md-4">
<label>Area</label>&nbsp;&nbsp;:&nbsp;&nbsp;
<?php echo getarea('areaname',$customerdetails['area']); ?>                           
</div>
</div>  
<br>
<div class="row">
<div class="col-md-4">
<label>Address</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo $customerdetails['address']; ?>                           
</div>
<div class="col-md-4">
<label>Payment</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo $customerdetails['payment']; ?>                           
</div>
<div class="col-md-4">
<label>Mobile</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo $customerdetails['mobile']; ?>                           
</div>
</div><br>
<div class="row">
  <div class="col-md-4">
<label>Emailid</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo $customerdetails['emailid']; ?>                           
</div>
<div class="col-md-4">
<label>Joined Date</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo $customerdetails['joineddate']; ?>                           
</div>
<div class="col-md-4">
<label>Valid From Date</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo date('d-m-Y',strtotime($customerdetails['valid_fromdate'])); ?>                           
</div>
</div>  <br>
<div class="row">
  <div class="col-md-4">
<label>Valid To Date</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo date('d-m-Y',strtotime($customerdetails['valid_todate'])); ?>                           
</div>
<div class="col-md-4">
<label>Description</label>&nbsp;&nbsp;:&nbsp;&nbsp;           
<?php echo $customerdetails['description']; ?>                           
</div>

</div><br>
</div>
</div>

<?php
$ord = $db->prepare("SELECT * FROM `offerdetails` where (`valid_fromdate` BETWEEN '".$customerdetails['valid_fromdate']."' AND '".$customerdetails['valid_todate']."') OR (`valid_fromdate`<='".$customerdetails['valid_fromdate']."' AND `valid_todate`>='".$customerdetails['valid_todate']."')  AND `merchantid`='".$_SESSION['merchant']."' AND `status`='1' ");


$ord->execute(array());
$s=1;
$bcount = $ord->rowcount();
if($bcount>0) {
?>
<div class="panel panel-info">

<div class="panel-heading">Offer Details </div>

<div class="panel-body">

<div class="row">
<div class="col-md-12">
 <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                  <th style="width:5%;"><input type="checkbox" /></th>
                                    <th style="width:5%;">S.id</th>
                                   <th style="width:10%">Offerid</th>
                                     <th style="width:10%">Offer Name</th>
                                      <th style="width:10%">Discount</th>
                                      <th style="width:10%">Valid From Date</th>
                                      <th style="width:10%">Valid To Date
                                      <input type="hidden" name="offerid" id="offerid"> 
                                      </th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                $b = '1';$s='1';
                      // echo "SELECT * FROM `offerdetails` WHERE  (`valid_fromdate` BETWEEN '2018-06-20' AND '2018-09-17') OR (`valid_fromdate`<='2018-06-20' AND `valid_todate`>='2018-09-17')";

                                while ($contributelist = $ord->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                   <tr>
                                    <td><input type="checkbox" name="forpay" id="forpay<?php echo $s; ?>" onclick="paycheck(this,<?php echo $contributelist['discount']; ?>,<?php echo $contributelist['id']; ?>)" value="<?php echo $contributelist['id']; ?>" /></td>
                                    <td><?php echo $b; ?></td>
                                    <td><?php echo $contributelist['offerid']; ?></td>
                                    <td><?php echo $contributelist['offername']; ?></td>
                                    <td><?php echo $contributelist['discount']; ?></td>
                                     <td><?php echo $contributelist['valid_fromdate']; ?></td>
                                    <td><?php echo $contributelist['valid_todate']; ?></td>
                                   </tr>
                                    <?php
                                    $s++;
                                    $b++;
                                } 
                                ?>
                               
                            </tbody>
                            
                        </table>
</div>  
</div>  </div></div>
<div class="panel panel-info">

<div class="panel-heading">Payment Details </div>

<div class="panel-body">
<div class="row">
<div class="col-md-4">
<label>Purchase Amount</label><span style="color:#FF0000;">*</span>&nbsp;&nbsp;:&nbsp;&nbsp;      
Rs. <input type="text" name="purchase_amount" id="purchase_amount" class="form-control" required="required" onkeyup="netcal();">
</div>
<div class="col-md-4">
<label>Discount (<span id="discountval"></span>%)</label>&nbsp;&nbsp;:&nbsp;&nbsp; 
<input type="hidden" name="disc" id="disc">     
Rs. <input type="text" name="discount" id="discount" class="form-control" required="required" readonly="readonly">
</div>
<div class="col-md-4">
<label>Net Amount</label>&nbsp;&nbsp;:&nbsp;&nbsp;      
Rs. <input type="text" name="netamount" id="netamount" class="form-control" required="required" readonly="readonly">
</div>
</div>
<br><br>
<div class="row">
<div class="col-md-6">
&nbsp;
</div>
<div class="col-md-6">
<button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;">SUBMIT</button>
</div>
</div>
</div>
</div>

<?php } else { ?>


<?php } ?>
<br>
</form>

<script>
function paycheck(ckType,discount,offerid) {
   //var checkBox = document.getElementById("forpay");
   document.getElementById('offerid').value=offerid;
     var ckName = document.getElementsByName(ckType.name);
    var checked = document.getElementById(ckType.id);

    if (checked.checked) {
      for(var i=0; i < ckName.length; i++){

          if(!ckName[i].checked){
              ckName[i].disabled = true;
          }else{
              ckName[i].disabled = false;
          }
      } 
    }
    else {
      for(var i=0; i < ckName.length; i++){
        ckName[i].disabled = false;
      } 
    } 
    document.getElementById('discountval').innerHTML=discount;
     document.getElementById('disc').value=discount;
    if(document.getElementById('purchase_amount').value!='')
    {
    purchaseamt=document.getElementById('purchase_amount').value;
    totamt=purchaseamt*(discount/100);
    document.getElementById('discount').value=totamt;
    document.getElementById('netamount').value=purchaseamt-totamt;
    }
}
function netcal()
{
   discount=document.getElementById('disc').value;
    if(document.getElementById('purchase_amount').value!='')
    {
    purchaseamt=document.getElementById('purchase_amount').value;
    totamt=purchaseamt*(discount/100);
    document.getElementById('discount').value=parseFloat(totamt);
    document.getElementById('netamount').value=parseFloat(purchaseamt)-parseFloat(totamt);
    }
}
</script>

