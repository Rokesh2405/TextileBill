<?php

if (isset($_REQUEST['id'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "5,5,2";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
   
   
$msg = addobject1($subcategory,$objectname,$category,$unit,$price,$status, $getid);
}


?>

<script>
    // function randomString()
    // {
    //     var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    //     var string_length = 6;
    //     var randomstring = '';
    //     for (var i = 0; i < string_length; i++) {
    //         var rnum = Math.floor(Math.random() * chars.length);
    //         randomstring += chars.substring(rnum, rnum + 1);
    //     }
    //     document.getElementById('password').value = randomstring;
    //     document.getElementById('changepwd').value = randomstring;
    // }
    
    // $(function () {
    //     $(".form_control").blur(function () {
    //         var PasswordVal = $('.password').val();
    //         var ConfirmPasswordVal = $('.confirmpassword').val();
    //         if (PasswordVal != ConfirmPasswordVal && ConfirmPasswordVal.length > 0 && PasswordVal.length > 0)
    //             $('reg-textbox').show();
    //         else
    //             $('reg-textbox').hide();

    //     });
    // });

 </script>   
    
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Stock Product
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Stock Product</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Inventory</a></li>            
            <li><a href="<?php echo $sitename; ?>master/object1.htm"><i class="fa fa-circle-o"></i> Stock Products</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Stock Product</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Stock Product</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
					<div class="row">
					                    <div class="col-md-6">
                            <label>Category</label>
                            <select name="category" class="form-control" id="category" required="required" onchange="getsubcategoryp(this.value);">
<option value="">Select</option>                          
						  <?php 												 $sel = pFETCH("SELECT * FROM `hotel_categories` WHERE `status`=? ", 1);
												 
												 
                                            while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
                                            
                                                    ?>
                                                    <option value="<?php echo $fdepart['category_id']; ?>"
                                                    <?php
                                                    if ($fdepart['category_id'] == getobject1('category', $_REQUEST['id'])) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?php echo $fdepart['category_name']; ?></option>
												 <?php }
												 ?>

                        </select>

                        </div>
						 <div class="col-md-6">
                            <label>Subcategory</label>
                            <select name="subcategory" id="subcategory" class="form-control">
							<option value="">Select</option>
							<?php
												 if(getobject1('category', $_REQUEST['id'])!='') {
												 $sel = pFETCH("SELECT * FROM `subcategory` WHERE `status`=? AND `category`=? ", 1,getobject1('category', $_REQUEST['id']));
												 
												 
                                            while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
                                            
                                                    ?>
                                                    <option value="<?php echo $fdepart['id']; ?>"
                                                    <?php
                                                    if ($fdepart['id'] == getobject1('subcategory', $_REQUEST['id'])) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?php echo $fdepart['subcategory']; ?></option>
												 <?php } } ?>
                            
							
                        </select>

                        </div>
</div>
<br>
                    <div class="row">
                        
                        <div class="col-md-6">
                             <label>Product name<span style="color:#FF0000;">*</span></label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" name="objectname" id="objectname" class="form-control" placeholder="Enter the product name" value="<?php echo getobject1('objectname',$_REQUEST['id']); ?>" required="required"/>
                        </div>
                         <div class="col-md-6">
                             <label>Unit<span style="color:#FF0000;">*</span></label>
                        
						
						 <select  name="unit" class="form-control" required="required">
                                                <option value="">Select Unit</option>
                                                <?php
												 $sel = pFETCH("SELECT * FROM `units` WHERE `status`=?", 1);

                                            while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
                                            
                                                    ?>
                                                    <option value="<?php echo $fdepart['id']; ?>"
                                                    <?php
                                                    if ($fdepart['id'] == getobject1('unit', $_REQUEST['id'])) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?php echo $fdepart['unit']; ?></option>
                                                        <?php } ?>
                                            </select>
									
									
                        </div>  
						</div>
						<br>
						<div class="row">
                        <div class="col-md-6">
                             <label>Price<span style="color:#FF0000;">*</span></label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" name="price" id="objectname" class="form-control" required="required" placeholder="Enter the product price" value="<?php echo getobject1('price',$_REQUEST['id']); ?>" />
                        </div>    
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                            <option value="1" <?php
                            if (stripslashes(getobject1('status', $_REQUEST['id'])) == '1') {
                                echo 'selected';
                            }
                            ?>>Active</option>
                            <option value="0" <?php
                            if (stripslashes(getobject1('status', $_REQUEST['id']) == '0')) {
                                echo 'selected';
                            }
                            ?>>Inactive</option>

                        </select>

                        </div>             
                    </div>
                    </div>
                     <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/object1.htm">Back to Listings page</a>
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
function getsubcategoryp(a) {
         $.post("<?php echo $sitename; ?>config/functions_ajax.php", {category: a},
                function (data) {
					//alert(data);
                    $('#subcategory').html(data);
                });
    }
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
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getobject1('id',$_REQUEST['id']); ?>/editprovider.htm?delid=" + id;
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
            $(this).find('td').eq(0).html(i + 1+1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1+1);
        });
    }

</script>