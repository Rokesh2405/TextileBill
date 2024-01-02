<?php
$menu = "3,3,24";
if (isset($_REQUEST['tid'])) {
    $thispageeditid = 17;
} else {
    $thispageid = 17;
}

include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
include 'uploadimage.php';

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['tid'];
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($imagename != '') {
        $imagec = $imagename;
    } else {
        $imagec = time();
    }
    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getsupplier('image', $getid);

    if ($imag) {
        if ($pimage != '') {
            unlink("../../../images/supplier/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        /* $tmp = $_FILES['image']['tmp_name'];
          $size = $_FILES['image']['size'];
          $width = 1000;
          $height = 1000;
          $width1 = 200;
          $height1 = 200; */
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = $imagec;
            $imagev = $m . "." . $extension;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], '../../../images/supplier/' . $imagev)) {
                die('Error uploading file - check destination is writeable.');
            }

            /* $thumppath = "../../../images/testimonial/";
              $filepath = "../../../images/testimonial/thump/";
              $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
              $bbb = Imageupload($main, $size, $width1, $filepath, $filepath, '255', '255', '255', $height1, strtolower($m), $tmp); */
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['tid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    $so=explode(",",$supplierobject);
    $supplierobject1=$so[3];
    $msg = addsalesreturn($cname, $supplierobject1, $sales_date, $reasonofreturn, $quantity, $requantity, $remquantity,$returndate,$object_id);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            supplier Mgmt
            <small><?php
                if ($_REQUEST['tid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Sales';
                }
                ?> Return </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Home Block(s)</a></li>
            <li><a href="<?php echo $sitename; ?>pages/process/supplier.htm">supplier Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['tid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Sales';
                }
                ?> Return</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['tid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add Sales';
                        }
                        ?> Return</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            supplier Mgmt
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Select Customer Name<span style="color:#FF0000;">*</span></label>
                                    
                                    <select name="cname" id="cname" class="form-control" >
                                                                <!-- <option value="select">select</option> -->
                                                                <option>Select</option>
                                                                 <?php
                                                                    $stmt = $db->query("SELECT * FROM sales");
                                                                    while ($row = $stmt->fetch()) {
                                                                        
                                                  echo "<option value='".$row['id']."'>".$row['supplierid']."</option>";
                                                                    }
                                                                    ?>
                                                            </select> 
                                </div>

                                <div class="col-md-6">
                                    <label>Select Silver Object<span style="color:#FF0000;">*</span></label>  
                                    <!-- <select id="supplierobject" name="supplierobject">
                                      
            <option value="">Select</option>
                                    </select> -->
                                     <select name="supplierobject" id="supplierobject" class="form-control" >
                                                                <!-- <option value="select">select</option> -->
                                                                <option>Select</option>
                                                                 
                                                            </select> 

                                </div>
                            </div>
                            <div class="clearfix"><br /></div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Sales Date<span style="color:#FF0000;">*</span></label>
                                    <input type="text" readonly="" class="form-control" placeholder="purchase date" name="sales_date" id="sales_date" style="overflow: scroll;" />                     
                                </div>
                                <div class="col-md-3">
                                  <label>Quantity<span style="color:#FF0000;">*</span></label>
                                    <input type="text" readonly="" class="form-control" placeholder="Quantity" name="quantity" id="quantity" />     
                                </div>
                                <div class="col-md-3">
                                  <label>Return Quantity<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Return Quantity" name="requantity" id="requantity" />     
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" style="display: none;" class="form-control"  placeholder="Return Quantity" name="object_id" id="object_id" />      
                                </div>
                                <div class="col-md-3">
                                    <label>Remaining Quantity<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Return Quantity" name="remquantity" id="remquantity" />      
                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Reason of Return <span style="color:#FF0000;">*</span></label>                  
                                     <textarea  required="required" name="reasonofreturn" id="reasonofreturn" placeholder="Enter address" class="form-control" ></textarea>
                                </div>

                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Return Date<span style="color:#FF0000;">*</span></label>
                                    <input type="date" class="form-control" placeholder="Enter the Link" name="returndate" id="returndate" required="required" value="<?php echo 'Raja'; ?>" />                     
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                            </div>
 
                        </div>
 

                    </div><br/>
                </div> 

            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo $sitename; ?>pages/others/salesreturn.htm">Back to Listings page</a>
                    </div>
                    <div class="col-md-6"><!--validatePassword();-->
                        <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                            if ($_REQUEST['tid'] != '') {
                                echo 'UPDATE';
                            } else {
                                echo 'SAVE';
                            }
                            ?>
                        </button>
                    </div>
                </div>
            </div>
            </div>
        </form>
        <!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>


<link type="text/css" href="<?php echo $sitename; ?>dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" rel="stylesheet" />
<?php if (isset($_REQUEST['tid'])) { ?>
    <script src="<?php echo $sitename; ?>dhtmlgoodies_calendar/dhtmlgoodies_calendar1.js" type="text/javascript"></script>
<?php } else { ?>
    <script src="<?php echo $sitename; ?>dhtmlgoodies_calendar/dhtmlgoodies_calendar.js" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">
 $("#cname").change(function () {
    var selectedValue =$("#cname").val();
    a=selectedValue;  
    // alert(a);
        $.ajax({
            url: "<?php echo $sitename; ?>pages/others/ajax_page.php?sale1=cusid",
            data: {cusid: a},
            success: function (data) {
                $("#supplierobject").html(data);  

            }
        });
});
$('#requantity').keyup(function () {
    var quantity=$('#quantity').val();
    var requantity=$('#requantity').val();
    var quantity1=quantity-requantity;
       
    if(quantity>=requantity)
    {
        $('#remquantity').val(quantity1);     
    }
    else
    {
         $('#remquantity').val(' ');    
    }
     
});
$("#supplierobject").change(function () {
    var selectedValue1 =$("#supplierobject").val();
// alert(selectedValue1);
    a1=selectedValue1.split(",");   
    $('#quantity').val(a1[0]);
    $('#sales_date').val(a1[1]);
    $('#object_id').val(a1[2]);
});
</script>