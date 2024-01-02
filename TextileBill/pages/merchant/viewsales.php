<?php
$menu = "8,13,13";
if (isset($_REQUEST['coid'])) {
    $thispageeditid = 47;
} else {
    $thispageaddid = 47;
}
$franchisee = 'yes';
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');

$salesdetails = FETCH_all("SELECT * FROM `sales` WHERE `id`=?", $_REQUEST['coid']); 

$customerdetails = FETCH_all("SELECT * FROM `customer` WHERE `customerid`=?", $salesdetails['customerid']); 

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Sales
        </h1>




        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
             <li><a href="<?php echo $sitename; ?>merchant/saleslist.htm">Sales</a></li>
            <li class="active">&nbsp;View Sales</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data" autocomplete="off" >
            <div class="box box-info">
               
                <div class="box-body">
                    <?php echo $msg; ?>

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
$ord = $db->prepare("SELECT * FROM `offerdetails` where `id`='".$salesdetails['offerid']."' ");


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
                               <!--    <th style="width:5%;"><input type="checkbox" /></th> -->
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
                                    <!-- <td><input type="checkbox" name="forpay" id="forpay<?php echo $s; ?>" onclick="paycheck(this,<?php echo $contributelist['discount']; ?>,<?php echo $contributelist['id']; ?>)" value="<?php echo $contributelist['id']; ?>" /></td> -->
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
<label>Purchase Amount</label>      
<br>
Rs. <?php echo $salesdetails['purchase_amount']; ?>
</div>
<div class="col-md-4">
<label>Discount (<span id="discountval"><?php echo $salesdetails['dispercent']; ?></span>%)</label><br>
Rs. <?php echo $salesdetails['discount']; ?>
</div>
<div class="col-md-4">
<label>Net Amount</label>   
<br>
Rs. <?php echo $salesdetails['netamount']; ?>
</div>
</div>
<!-- <br><br>
<div class="row">
<div class="col-md-6">
&nbsp;
</div>
<div class="col-md-6">
<button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;">SUBMIT</button>
</div>
</div> -->
</div>
</div>

<?php } else { ?>


<?php } ?>
                </div><!-- /.box-body -->
        </form> 
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>

<script>
    function click1()
    {

        $('#demo').css("display", "block");

    }
</script>