<?php

if (isset($_REQUEST['id'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "18,18,118";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
   
global $db;
$sql = $db->prepare("UPDATE `settings` SET `setting_name`='Barcodetype',`setting_value`='" . $_REQUEST['barcode_type'] . "' WHERE `id`=?");
$sql->execute(array('2'));

$msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
}

if (isset($_REQUEST['cid']) && ($_REQUEST['cid'] != '')) {
    $get1 = $db->prepare("SELECT * FROM `return` WHERE `id`=?");
    $get1->execute(array($_REQUEST['id']));
    $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
}
if (isset($_REQUEST['delid1']) && $_REQUEST['delid1'] != '') {
    $up = $db->prepare("DELETE FROM `object_detail` WHERE `id`=?");
    $up->execute(array($_REQUEST['delid1']));
    $a = $_REQUEST['cid'];
    echo '<script>window.location.href="' . $sitename . 'master/' + $_REQUEST['cid'] + 'editcustomer.htm"</script>';
}
?>

<style>
       .form-control{
           font-size:19px;
       }
       label{
           font-size:19px;
       }
   </style>
    
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Barcode Settings
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
              <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } ?> Barcode Settings</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } 
                        ?> Barcode Settings</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        
                        
                        <div class="col-md-2">
                            <label>Barcode Type<span style="color:#FF0000;">*</span></label>
                        </div>
                         <div class="col-md-2">
							 <input type="radio" name="barcode_type" value="1" <?php if(getsettings('setting_value',2)=='1') { ?> checked="checked" <?php } ?>>&nbsp;&nbsp;6 Codabar
                             </div>
                             <div class="col-md-2">
                             <input type="radio" name="barcode_type" value="2" <?php if(getsettings('setting_value',2)=='2') { ?> checked="checked" <?php } ?>>
                             &nbsp;&nbsp;Code128</div>
                             <div class="col-md-2">
                              <input type="radio" name="barcode_type" value="3" <?php if(getsettings('setting_value',3)=='3') { ?> checked="checked" <?php } ?>>
                             &nbsp;&nbsp;Code39
                        </div>
                     

            </div>
                 
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                       
                        <div class="col-md-6" align="left">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:left;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                         <div class="col-md-6">
                         &nbsp;  </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">

     function show_contacts(id) {
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            data: {get_contacts_of_customer: id}
        }).done(function (data) {
            $('#choose_contacts_grid_table tbody').html(data);
        });
    }


      function delrec(elem, id) {
        if (confirm("Are you sure want to delete this Object?")) {
            $(elem).parent().remove();
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getcustomer('id',$_REQUEST['cid']); ?>/editprovider.htm?delid=" + id;
        }
    }


    $(document).ready(function (e) {
        
        $('#add_task').click(function () {

           
            var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Offer?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                   
                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#task_table tbody').append(data);
             $('.usedatepicker').datepicker({
                autoclose: true
            });

           
            re_assing_serial();

        });
       
         $('#add_proof').click(function () {

           
            var data = $('#firstprooftr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Proof?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                   
                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#proof_table tbody').append(data);
             $('.usedatepicker').datepicker({
                autoclose: true
            });

           
            re_assing_serial();

        });

        

      });

    function del_addi(elem) {
        if (confirm("Are you sure want to remove this?")) {
            elem.parent().parent().remove();
            additionalprice();
        }
    }


   
   
    
    function re_assing_serial() {
        $("#task_table tbody tr").not('#firsttasktr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }

    function delrec1(elem, id) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();

            window.location.href = "<?php echo $sitename; ?>master/<?php echo getcustomer('id',$_REQUEST['cid']); ?>/editcustomer.htm?delid1=" + id;
        }
    }

    function interest_calculation(){
        var interest_amount = $('#amount').val();
        var interest_percent = $('#interestpercent').val();
        var a = (interest_percent / 100);
        // alert(a);
        var interest_total = interest_amount - (interest_amount *  a);
        // alert(interest_total);
        document.getElementById('interest').value = interest_total;
        // $('#interest').html(interest_total);
    }
    

</script>