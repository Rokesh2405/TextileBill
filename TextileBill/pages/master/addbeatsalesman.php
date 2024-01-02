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
  
   $msg = addbeatsalesman($beatid1,$beat,$salesman,$area,$beatcustomer,$status,$getid);
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
            Beat Salesman
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Beat Salesman</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/beat.htm"><i class="fa fa-circle-o"></i> Beat Salesman</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Beat Salesman</li>
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
                        } else {
                            echo 'Add New';
                        }
                        ?> Beat Salesman</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label>Salesman <span style="color:#FF0000;">*</span></label>
                            <select name="salesman" class="form-control" required>
                                <option value="">Select</option>
                                 <?php
$customer = pFETCH("SELECT * FROM `salesman` WHERE `status`=? ", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>" <?php if(getbeatsalesman("salesman", $_REQUEST['id'])==$customerfetch['id']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['name']; ?></option>
<?php } ?>                      
                            </select>
                            
                        </div>
                       <div class="col-md-6">
                            <label>Status</label>
                    <select name="status" class="form-control">
                         <option value="1" <?php if(getbeatsalesman('status', $_REQUEST['id'])=='1') { ?> selected="selected"<?php } ?>>Active</option>      
                         <option value="0" <?php if(getbeatsalesman('status', $_REQUEST['id'])=='0') { ?> selected="selected"<?php } ?>>Inactive</option>      
                          </select>
                      </div>  
                    </div>
                    <br>
                    <?php 
                        if($_REQUEST['id']!='') {
                   ?>
                     <div class="clearfix"><br /></div>
                    
                    <?php 
$headings = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
$i=0;
$getid= $_REQUEST['id'];

$exsrecd = pFETCH("SELECT * FROM `daywise_beat` WHERE `beatsalesman_id`=? ORDER BY `id` ASC ",$getid);
while ($exsrecdfetch = $exsrecd->fetch(PDO::FETCH_ASSOC)) 
{
                      ?>
                    <div class="row">
                        <div class="col-md-12">
                           <div class="panel panel-default">
  <div class="panel-heading"><?php echo $headings[$exsrecdfetch['day']]; ?></div>
  <div class="panel-body">
<div class="row">
    <div class="col-md-6">
                            <label>Beat Name <span style="color:#FF0000;">*</span></label>
                            <input type="hidden" name="beatid1[<?php echo $exsrecdfetch['day']; ?>]" value="<?php echo $exsrecdfetch['id']; ?>">
                            <select name="beat[<?php echo $exsrecdfetch['day']; ?>]" class="form-control" onchange="getarea(this.value,<?php echo $exsrecdfetch['day']; ?>);">
                                <option value="">Select</option>
<?php
$customer = pFETCH("SELECT * FROM `beat` WHERE `status`=? GROUP BY `beatname` ", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>-<?php echo $customerfetch['beatname']; ?>" <?php if($exsrecdfetch['beat']==$customerfetch['id'].'-'.$customerfetch['beatname']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['beatname']; ?></option>
<?php } ?>                      
                            </select>
                            
                        </div>
  <div class="col-md-6">
                            <label>Area Name <span style="color:#FF0000;">*</span></label>
                            <select name="area[<?php echo $exsrecdfetch['day']; ?>]" id="area<?php echo $exsrecdfetch['day']; ?>" class="form-control" onchange="show_contacts(this.value,<?php echo $exsrecdfetch['day']; ?>);">
                                <option value="">Select</option>
                                 <?php
                                 if($exsrecdfetch['area']!='') {
                                    $exdata=explode('-',$exsrecdfetch['beat']);
$customer = pFETCH("SELECT * FROM `beat` WHERE `beatname`=? GROUP BY `beatname` ", $exdata['1']);
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['beatname'].'-'.$customerfetch['area']; ?>" <?php if($exsrecdfetch['area']==$customerfetch['beatname'].'-'.$customerfetch['area']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['area']; ?></option>
<?php } } ?>                      
                            </select>
                            
                        </div>

</div>
<br>
<div class="row">
<div class="col-md-12" id="getcustomer<?php echo $exsrecdfetch['day']; ?>">
<?php

$expcus=explode('-',$exsrecdfetch['area']);
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
<input type="checkbox" name="beatcustomer[<?php echo $exsrecdfetch['day']; ?>][]" value="<?php echo $cusarry1; ?>" <?php if(in_array($cusarry1,explode(',',$exsrecdfetch['customer']))) { ?> checked="checked" <?php } ?>/>&nbsp;&nbsp; <?php echo getcustomer('name',$cusarry1); ?>  
</div>
<?php
}
?>
</div>

</div>
</div>
  </div>
</div>
                        </div>
                    </div>
                     <br>
                 
                    <?php $i++;} } else { ?>
                     <div class="clearfix"><br /></div>
                    
                    <?php 
$headings = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

                    for($i=0; $i<=5; $i++) {
                      ?>
                    <div class="row">
                        <div class="col-md-12">
                           <div class="panel panel-default">
  <div class="panel-heading"><?php echo $headings[$i]; ?></div>
  <div class="panel-body">
<div class="row">
    <div class="col-md-6">
                            <label>Beat Name <span style="color:#FF0000;">*</span></label>
                             <input type="hidden" name="beatid1[<?php echo $i; ?>]">

                            <select name="beat[<?php echo $i; ?>]" class="form-control" onchange="getarea(this.value,<?php echo $i; ?>);">
                                <option value="">Select</option>
                                 <?php
$customer = pFETCH("SELECT * FROM `beat` WHERE `status`=? GROUP BY `beatname` ", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>-<?php echo $customerfetch['beatname']; ?>" <?php if(getbeatsalesman("beat", $_REQUEST['id'])==$customerfetch['id'].'-'.$customerfetch['beatname']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['beatname']; ?></option>
<?php } ?>                      
                            </select>
                            
                        </div>
  <div class="col-md-6">
                            <label>Area Name <span style="color:#FF0000;">*</span></label>
                            <select name="area[<?php echo $i; ?>]" id="area<?php echo $i; ?>" class="form-control" onchange="show_contacts(this.value,<?php echo $i; ?>);">
                                <option value="">Select</option>
                                 <?php
                                 if(getbeatsalesman("area", $_REQUEST['id'])!='') {
$customer = pFETCH("SELECT * FROM `beat` WHERE `beatname`=? GROUP BY `beatname` ", getbeatsalesman("beat", $_REQUEST['id']));
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['beatname']; ?>" <?php if(getbeatsalesman("area", $_REQUEST['id'])==$customerfetch['id'].'-'.$customerfetch['area']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['area']; ?></option>
<?php } } ?>                      
                            </select>
                            
                        </div>

</div>
<br>
<div class="row">
    <div class="col-md-12" id="getcustomer<?php echo $i; ?>"></div>
</div>
  </div>
</div>
                        </div>
                    </div>
                     <br>
                    <?php } } ?>
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/beatsalesman.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">
      function getarea(id,pos) {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/getajax.php",
            data: {area: id,pos:pos}
        }).done(function (data) {
            $('#area'+pos).html(data);
        });
    }


     function show_contacts(id,pos) {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/getajax.php",
            data: {beatname: id,pos:pos}
        }).done(function (data) {
            $('#getcustomer'+pos).html(data);
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