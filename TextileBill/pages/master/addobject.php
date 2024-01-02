<?php

if (isset($_REQUEST['id'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,10";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];


$estyle=implode(',',$style);
$epattern=implode(',',$pattern);
$eprice=implode(',',$sprice);
$styleid=implode(',',$styleid);
$msg = addobject($styleid,$estyle,$epattern,$eprice,$pricetype,$barcodeText,$barcodeType,$barcodeDisplay,$barcodeSize,$printText,$barcode_type,$mrp_price,$unit_per_pack,$barcode,$in_stock,$hsn,$productcode,$gst,$objectname,$category,$subcategory,$unit,$price,$status, $getid);
}

// if (isset($_REQUEST['id']) && ($_REQUEST['id'] != '')) {
//     $get1 = $db->prepare("SELECT * FROM `object` WHERE `id`=?");
//     $get1->execute(array($_REQUEST['id']));
//     $showrecords = $get1->fetch(PDO::FETCH_ASSOC);
// }


if($_REQUEST['delid']!='')
{
 global $db;
 $c=$_REQUEST['delid'];
        $get = $db->prepare("DELETE FROM `objectprice` WHERE `id` = ? ");
        $get->execute(array($c));   
        $url=$sitename.'master/'.$_REQUEST['id'].'/editobject.htm';
      echo "<script>alert('Price Deleted Successfully');window.location.assign('".$url."')</script>";
            
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

<style type="text/css">
        img.barcode {
    border: 1px solid #ccc;
    padding: 20px 10px;
    border-radius: 5px;
}
    </style>
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sales Product
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Sales Product</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Sales</a></li>            
            <li><a href="<?php echo $sitename; ?>master/object.htm"><i class="fa fa-circle-o"></i> Sales Product</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Sales Product</li>
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
                        ?> Sales Product</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-4">
                              <label>Barcode Settings<span style="color:#FF0000;">*</span></label>
                              <select name="barcode_type" class="form-control" id="barcode_type">
                                  <option value="2" <?php if(getobject('barcode_type',$_REQUEST['id'])==2) { ?> selected="selected" <?php } ?>>Manual</option>
                                <option value="1" <?php if(getobject('barcode_type',$_REQUEST['id'])==1) { ?> selected="selected" <?php } ?>>Automatic</option>
                              
                              </select>
                             
                        </div>
                    
                        <div class="col-md-4" <?php if(getobject('barcode_type',$_REQUEST['id'])==1) { ?> style="display:none;" <?php } ?> id="bcode">
                             <label>Bar Code</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Enter the Barcode" value="<?php echo getobject('barcode',$_REQUEST['id']); ?>"/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        
                        <div class="col-md-4">
                             <label>Product Code<span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="productcode" id="productcode" class="form-control" placeholder="Enter the product code" value="<?php echo getobject('productcode',$_REQUEST['id']); ?>" required="required"/>
                        </div>
                          
                        <div class="col-md-4">
                             <label>Product Name<span style="color:#FF0000;">*</span></label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" name="objectname" id="objectname" class="form-control" placeholder="Enter the product name" value="<?php echo getobject('objectname',$_REQUEST['id']); ?>" required="required"/>
                        </div>
                       <div class="col-md-4">
                            <label>Category</label>
                            <select name="category" class="form-control" id="category" required="required" onchange="getsubcategoryp(this.value);">
<option value="">Select</option>                          
                          <?php                                                  $sel = pFETCH("SELECT * FROM `hotel_categories` WHERE `status`=? ", 1);
                                                 
                                                 
                                            while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
                                            
                                                    ?>
                                                    <option value="<?php echo $fdepart['category_id']; ?>"
                                                    <?php
                                                    if ($fdepart['category_id'] == getobject('category', $_REQUEST['id'])) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?php echo $fdepart['category_name']; ?></option>
                                                 <?php }
                                                 ?>

                        </select>

                        </div>              
</div>
<br>
<div class="row">		
 
						<div class="col-md-4">
                            <label>Subcategory</label>
                            <select name="subcategory" id="subcategory" class="form-control">
							<option value="">Select</option>
							<?php
												 if(getobject('category', $_REQUEST['id'])!='') {
												 $sel = pFETCH("SELECT * FROM `subcategory` WHERE `status`=? AND `category`=? ", 1,getobject('category', $_REQUEST['id']));
												 
												 
                                            while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
                                            
                                                    ?>
                                                    <option value="<?php echo $fdepart['id']; ?>"
                                                    <?php
                                                    if ($fdepart['id'] == getobject('subcategory', $_REQUEST['id'])) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?php echo $fdepart['subcategory']; ?></option>
												 <?php } } ?>
                            
							
                        </select>

                        </div>
      <div class="col-md-4">
                             <label>Unit Name<span style="color:#FF0000;">*</span></label>
							 
							 <select name="unit" class="form-control" required="required" >
<option value="">Select</option>                          
						  <?php 												 $sel = pFETCH("SELECT * FROM `units` WHERE `status`=? ", 1);
												 
												 
                                            while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
                                            
                                                    ?>
                                                    <option value="<?php echo $fdepart['id']; ?>"
                                                    <?php
                                                    if ($fdepart['id'] == getobject('unit', $_REQUEST['id'])) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?php echo $fdepart['unit']; ?></option>
												 <?php }
												 ?>

                        </select>
						
						
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
									
                        </div>  
                        <!--  <div class="col-md-4">
                             <label>Unit Per Pack</label>
                        
                                    <input type="text"  name="unit_per_pack" id="objectname" class="form-control" placeholder="Enter the Unit Per Pack" value="<?php echo getobject('unit_per_pack',$_REQUEST['id']); ?>" />
                        </div>   -->
                        <div class="col-md-4">
                             <label>HSN<span style="color:#FF0000;">*</span></label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" required="required" name="hsn" id="hst" class="form-control" placeholder="Enter the HSN Value" value="<?php echo getobject('hsn',$_REQUEST['id']); ?>" />
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                             <label>GST<span style="color:#FF0000;">*</span></label>
                             
                             <select name="gst" class="form-control" required="required" >
<option value="">Select</option>                          
                          <?php  $sel = pFETCH("SELECT * FROM `gst` WHERE `status`=? ", 1);
                                                 
                                                 
                                            while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
                                            
                                                    ?>
                                                    <option value="<?php echo $fdepart['id']; ?>"
                                                    <?php
                                                    if ($fdepart['id'] == getobject('gst', $_REQUEST['id'])) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?php echo $fdepart['gst']; ?>%</option>
                                                 <?php }
                                                 ?>

                        </select>
                        </div>     
                        <div class="col-md-1">
                             <label>In Stock</label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <br>
                                    <input type="checkbox" name="in_stock" id="in_stock" value="1" <?php if(getobject('in_stock',$_REQUEST['id'])=='1') { ?> checked="checked" <?php } ?>/>
                        </div> 
                        <div class="col-md-3">
                           <label>Price Type</label> 
                           <select name="pricetype" class="form-control" onchange="getprice(this.value);">
                            <option value="1" <?php if(getobject('pricetype',$_REQUEST['id'])=='1') { ?> selected="selected" <?php } ?>>Price Per Meter</option>
                              <option value="2" <?php if(getobject('pricetype',$_REQUEST['id'])=='2') { ?> selected="selected" <?php } ?>>Price Per Style & Pattern</option>
                           </select>
                        </div>
 <div class="col-md-4">
                             <label>Sale Price</label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                            <input type="text" name="price" id="objectname" class="form-control" placeholder="Enter the product price" value="<?php echo getobject('price',$_REQUEST['id']); ?>" />
                        </div>   
                          
                             
                    </div>
<br>
<div class="row">		
    
      
 	
<div class="col-md-4">
                             <label>MRP Price</label>
                             <input type="text" name="mrp_price" class="form-control" value="<?php echo getobject('mrp_price',$_REQUEST['id']); ?>">
                         </div>
                         <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-control">
                            <option value="1" <?php
                            if (stripslashes(getobject('status', $_REQUEST['id'])) == '1') {
                                echo 'selected';
                            }
                            ?>>Active</option>
                            <option value="0" <?php
                            if (stripslashes(getobject('status', $_REQUEST['id']) == '0')) {
                                echo 'selected';
                            }
                            ?>>Inactive</option>

                        </select>

                        </div>
                    </div>
                    <br>
                      <div class="row" <?php if(getobject('pricetype',$_REQUEST['id'])=='2') { ?> style="display: block;" <?php } else { ?>style="display: none;"<?php } ?> id="getpricestyle">
                        <div class="col-md-12">
                       
                       <div class="panel panel-info">
<div class="panel-heading">
<div class="panel-title">Style & Pattern Wise Price</div>
</div>
<div class="panel-body">
<div class="row">   
<div class="col-md-12">
<div class="table-responsive">
<table width="100%" class="table table-bordered" id="task_table1" cellpadding="0"  cellspacing="0">
<thead>
<tr>
<th>Style</th>
<th>Pattern</th>
<th>Price</th>
<th>Delete</th>
</tr>
</thead>

<tbody>
<?php 
if($_REQUEST['id']!='') {
$sno =1;
$styleprice = $db->prepare("SELECT * FROM `objectprice` WHERE `object_id`= ? ORDER BY `id` ASC");
$styleprice->execute(array($_REQUEST['id']));
$scount = $styleprice->rowcount();
if ($scount != '0') {
while ($stylepricelist = $styleprice->fetch(PDO::FETCH_ASSOC)) {
?>   
<tr>

<td> 
<input type="hidden" name="styleid[]" value="<?php echo $stylepricelist['id']; ?>">

<select name="style[]" class="form-control" >
<option value="">Select Style</option>
<?php
$sel = pFETCH("SELECT * FROM `style` WHERE `status`=?", 1);

while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {

?>
<option value="<?php echo $fdepart['id']; ?>"
<?php
if ($fdepart['id'] == $stylepricelist['style']) {
echo 'selected="selected"';
}
?>><?php echo $fdepart['style']; ?></option>
<?php } ?>
</select>

</td>

<td> 
<select name="pattern[]" class="form-control" >
<option value="">Select Pattern</option>
<?php
$sel = pFETCH("SELECT * FROM `pattern` WHERE `status`=?", 1);

while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {

?>
<option value="<?php echo $fdepart['id']; ?>"
<?php
if ($fdepart['id'] == $stylepricelist['pattern']) {
echo 'selected="selected"';
}
?>><?php echo $fdepart['pattern']; ?></option>
<?php } ?>
</select>
</td>
<td><input type="text" name="sprice[]" class="form-control" value="<?php echo $stylepricelist['price']; ?>"></td>
<td onclick="delrec($(this), '<?php echo $stylepricelist['id']; ?>')">
<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>
</td>
</tr>

<?php } } } ?>
<tr id="firsttasktr1">

<td> 
<input type="hidden" name="styleid[]" value="">

<select name="style[]" class="form-control" >
<option value="">Select Style</option>
<?php
$sel = pFETCH("SELECT * FROM `style` WHERE `status`=?", 1);

while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {

?>
<option value="<?php echo $fdepart['id']; ?>"><?php echo $fdepart['style']; ?></option>
<?php } ?>
</select>

</td>

<td> 
<select name="pattern[]" class="form-control" >
<option value="">Select Pattern</option>
<?php
$sel = pFETCH("SELECT * FROM `pattern` WHERE `status`=?", 1);

while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {

?>
<option value="<?php echo $fdepart['id']; ?>"><?php echo $fdepart['pattern']; ?></option>
<?php } ?>
</select>
</td>
<td><input type="text" name="sprice[]" class="form-control"></td>

</tr>


</tbody>
<tfoot>

<tr><td colspan="4"></td></tr>
<tr>
<td style="border:0;"  colspan="4"><button type="button" class="btn btn-info" id="add_task1">Add Another</button></td>

</tr>
</tfoot>
</table>

</div>                                   
</div>
</div>

</div></div>

                        </div>
                    </div>
                    <br>
                    <?php if($_REQUEST['id']!='') { ?>
                    <div class="row">
                        

                        <div class="col-md-4">
                             <label>Barcode</label>
                             <br> <br>
                            <?php

                             echo '<img class="barcode" alt="'.getobject('barcodeText', $_REQUEST['id']).'" src="'.$sitename.'pages/master/barcode.php?text='.getobject('barcodeText', $_REQUEST['id']).'&codetype='.getobject('barcodeType', $_REQUEST['id']).'&orientation='.getobject('barcodeDisplay', $_REQUEST['id']).'&size='.getobject('barcodeSize', $_REQUEST['id']).'&print='.getobject('printText', $_REQUEST['id']).'"/>';
                             ?> 
                        </div> 
                         </div> 
                         <br>
                        <?php } ?>
                    </div>
                     <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/object.htm">Back to Listings page</a>
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
    function getprice(a){
        if(a=='1'){
$("#getpricestyle").css("display", "none");
}
else
{
  $("#getpricestyle").css("display", "block");  
    }
}
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
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getobject('id',$_REQUEST['id']); ?>/editobject.htm?delid=" + id;
        }
    }


    $(document).ready(function (e) {

   
     $('#add_task1').click(function () {


            var data = $('#firsttasktr1').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Details?")) {
                    $(this).parent().remove();
                    re_assing_serial1();

                }
            });
            $(data).attr('id', '').show().append(rem_td);
            $(data).find('td').each(function (e) {
                $(this).find('select[name="style[]"]').val('');
                $(this).find('select[name="pattern[]"]').val('');
                 $(this).find('input[name="sprice[]"]').val('');
            });
            data = $(data);
            $('#task_table1 tbody').append(data);
             var tbl = $('#task_table1 tbody');
              tbl.find('tr').each(function () {
        $(this).find('input[type=text]').bind("keyup", function () {
            calculateSum();
        });
            
 });
            re_assing_serial1();

        });



    });


 function del_addi1(elem) {
        if (confirm("Are you sure want to remove this?")) {
            elem.parent().parent().remove();
            additionalprice();
        }
    }

  

 function re_assing_serial1() {
        $("#task_table1 tbody tr").not('#firsttasktr1').each(function (i, e) {
            //$(this).find('td').eq(0).html(i + 1+1);
        });
        $("#worker_table1 tbody tr").not('#firstworkertr1').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }
    
   
   $('#barcode_type').on('change', function() {
  //  alert( this.value ); // or $(this).val()
  if(this.value == "2") {
    $('#bcode').show();
  } else {
    $('#bcode').hide();
  }
});

    
    function re_assing_serial() {
        $("#task_table tbody tr").not('#firsttasktr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1+1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1+1);
        });
    }

</script>