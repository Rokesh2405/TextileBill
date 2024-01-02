<?php

if (isset($_REQUEST['id'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,11";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
   
$msg = add_user($status,$user_name,$user_mobile,$user_usertype,$user_username,$user_password,$user_address,$user_profile_photo,$getid);
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
            User
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> User</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/hotelusers.htm"><i class="fa fa-circle-o"></i> User</a></li>
            <li class="active"><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> User</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        
                        
                        <div class="col-md-4">
                            <label>Name <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="user_name" id="user_name" placeholder="Enter Name" autocomplete="off" class="form-control" value="<?php echo stripslashes(get_users('user_name',$_REQUEST['id'])); ?>" />
                        </div>
                         <div class="col-md-4">
                            <label>Mobile Number <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="user_mobile" id="user_mobile" placeholder="Enter Mobile Number" class="form-control" value="<?php echo stripslashes(get_users('user_mobile',$_REQUEST['id'])); ?>" />
                        </div>
                         <div class="col-md-4">
                            <label>Type <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="user_usertype" id="user_usertype" placeholder="Enter Type" class="form-control" value="<?php echo stripslashes(get_users('user_usertype',$_REQUEST['id'])); ?>" />
                        </div>
                        
                    </div>
                    
                     <div class="clearfix"><br /></div>
                    <div class="row">
                         
                        <div class="col-md-4">
                            <label>User Name <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="user_username" id="user_username" placeholder="Enter User Name" class="form-control" value="<?php echo stripslashes(get_users('user_username',$_REQUEST['id'])); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label>Password<span style="color:#FF0000;">*</span></label>
                            <input type="password"  required="required" name="user_password" id="user_password" placeholder="Enter Password" class="form-control" value="<?php echo stripslashes(get_users('user_password',$_REQUEST['id'])); ?>" />
                        </div>
						  <div class="col-md-4">
                            <label>Address <span style="color:#FF0000;">*</span></label>
                            <textarea  required="required" name="user_address" id="user_address" placeholder="Enter address" class="form-control" ><?php echo get_users('user_address',$_REQUEST['id']); ?></textarea>
                        </div>
						</div><br>
    <div class="clearfix"><br /></div>  
	<div class="row">
	 <div class="col-md-4">
                            <label>Status <span style="color:#FF0000;">*</span></label>
                            <select name="status" class="form-control">
							<option value="1" <?php if(get_users('user_address',$_REQUEST['id'])=='1') { ?> selected <?php } ?>>Active</option>
							<option value="0" <?php if(get_users('user_address',$_REQUEST['id'])=='0') { ?> selected <?php } ?>>Inactive</option>
							</select>
                        </div>
	</div>
	<div class="clearfix"><br /></div>  
<div class="row">    
                      
                     <!--   <div class="col-md-4">
                                <div class="form-group">
                                    <label>Photo <span style="color:#FF0000;"> (Recommended Size 1920 * 450)</span></label>
                                    <input class="form-control spinner" <?php if (get_users('user_profile_photo', $_REQUEST['id']) == '') { ?>  <?php } ?> name="user_profile_photo" type="file"> 
                                </div>
                        </div>
                  --></div>

    <div class="clearfix"><br /></div>  
<!--<div class="row">
<div class="col-md-12">
<div class="panel panel-info">
  <div class="panel-heading" style="color:black;font-weight:bold;">Set Permission</div>
  <div class="panel-body">
<table class="table table-bordered table-striped">
                                  <thead>
                                <tr>
                                    <td width="8%"><strong>s.no</strong></td>
                                    <td><strong>Pages</strong></td>
                                     <td><strong>Select</strong></td>
                                </tr> 
                                 </thead>

                                <tbody><tr>
                                    <td><strong>1</strong></td>
                                    <td>Banner</td>
                                    <td><input type="checkbox" name="banner" id="banner" checked="checked"></td>
                                </tr> 
                                
                            </tbody></table>
  
  </div>
</div>
</div>
</div>	-->
			 <div class="clearfix"><br /></div>  
			 <div class="row">
                   
                        
                        
                            
                            <?php if (get_users('user_profile_photo', $_REQUEST['cid']) != '') { ?>
                                <div class="col-md-4" id="delimage">
                                    <label> </label>
                                    <img src="<?php echo $fsitename; ?>img/users/<?php echo get_users('user_profile_photo', $_REQUEST['id']); ?>" style="padding-bottom:10px;" height="100" />
                                    <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo get_users('user_profile_photo', $_REQUEST['cid']); ?>', '<?php echo $_REQUEST['id']; ?>', 'customer', '../../../img/users/', 'image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                </div>
                            <?php } ?>
                        
                        
                    </div>
                     <br>
                    
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/hotelusers.htm">Back to Listings page</a>
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