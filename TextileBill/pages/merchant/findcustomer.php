<?php
if (isset($_REQUEST['cid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,12,12";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');


if($_REQUEST['netamount']!='')
{
@extract($_REQUEST);

$msg = addsales($customerid,$mobileno,$offerid, $purchase_amount, $disc, $discount, $netamount);
}
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];

   $msg = addcustomer($customerid,$membership,$title, $cname, $area, $mobile, $emailid, $joineddate, $valid_fromdate, $valid_todate, $address, $description, $payment, $status,$ip, $getid);
}

if (isset($_REQUEST['cid']) && ($_REQUEST['cid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `customer` WHERE `cid`=?");
    $get1->execute(array($_REQUEST['cid']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Customer</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/customer.htm"><i class="fa fa-circle-o"></i> Customer</a></li>
            <li class="active">Find Customer</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Customer</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                     <div class="panel panel-info">
                      
                        <div class="panel-heading">Search </div>
                           
                        <div class="panel-body">
                           
<form class="form-horizontal" method="post" name="searchform" id="searchform" enctype="multipart/form-data">
                            <div class="row">

                            <div class="col-md-4"><label>Customer ID</label>
                            <input type="text" class="form-control" name="customerid" id="customerid">   
                                </div>
                               <div class="col-md-4"><label>Mobile Number</label>
                            <input type="text" class="form-control" name="mobileno" id="mobileno">   
                                </div>
                                  <div class="col-md-2" align="left">
                                    <br>
                             <button type="submit" name="srchsubmit" id="srchsubmit" class="btn btn-success" style="float:right;">SEARCH</button>
                                </div>

                </div><!-- /.box-body -->
                </form>
                <div id="disstatusMsg"></div>
                <!-- <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/customer.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['cid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div> -->
            </div><!-- /.box -->
        
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
       
        $('form').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'srchoffer.htm',
            data: $('form').serialize(),
            success: function (data) {

            $('#disstatusMsg').html(data);
             // alert('form was submitted');
            }
          });

        });


        $('#AddContact').click(function () {
            var newTR = $('<tr />').html('<td><input type="text" name="contact_name[]" class="form-control" required /></td><td><input type="text" name="contact_mobile[]" class="form-control" required /></td><td><input type="text" name="contact_email[]" class="form-control" required /></td><td><input type="text" name="contact_designation[]" class="form-control" required /></td><td onclick="removeTR($(this));"><i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i></td>');
            $('#contactsTable tbody').append(newTR);
        });
    });
    function removeTR(elem, id) {
        if (id === undefined) {
            id = '';
        }
        if (confirm("Are you sure want to delete this contact?")) {
            if (id != '') {
                $.post('<?php echo $sitename; ?>config/function_ajax.php', {del_contact_id: id}, function (res) {});
            }
            $(elem).parent().remove();
        }
    }
</script>