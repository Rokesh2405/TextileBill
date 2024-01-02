<?php
if (isset($_REQUEST['bankidnum'])) {
    $thispageeditid = 39;
} else {
    $thispageaddid = 39;
}
$menu = "3,5,,39";
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';

if (isset($_REQUEST['delete'])) {
    $pimage = getbank('Image', $_REQUEST['bankidnum']);
    if ($pimage != '') {
        unlink("../../images/bank/" . $pimage);
    }
}

include ('../../require/header.php');
include_once "uploadimage.php";

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
   // print_r($_REQUEST);
    $_SESSION['bank_id'] = $_REQUEST['bankidnum'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $strupload = '1';
    $pimage = getbank('Image', $_REQUEST['bankidnum']);
    
    $imag = strtolower($_FILES["image"]["name"]);
    if ($imag) {
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif') || ($extension == 'jpeg')) {
            if ($pimage != '') {
                unlink("../../images/bank/" . $pimage);
            }
            $width = 100;
            $height = 100;
            $m = trim(str_replace(" ", "-", $bankname)) . '-' . time() . $i;
            $image = strtolower($m) . "." . $extension;
            $thumppath = "../../images/bank/";
            $aaa = Imageuploadd($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
        } else {
            $strupload = '2';
            $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Invalid File Format! Try jpg/png/gif/jpeg files only </div>';
        }
    }else
    {
        $image='';
         if(isset( $_REQUEST['bankidnum'])){
            $image=$pimage;  
        }
    }
    if ($strupload == '1') {
       $msg = addbank($bankname, $bankcode, $branchname,$Acc_no, $ifsccode, $swift, $address, $country, $state, $city, $area, $postal, $image, $order, $status, $ip, $_SESSION['bank_id']);
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bank  
            <small><?php
if ($_REQUEST['bankidnum'] != '') {
    echo 'Edit';
} else {
    echo 'Add New';
}
?> Bank</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><i class="fa fa-money"></i> Accounts</li> 
            <li><a href="<?php echo $sitename; ?>bank/bank.htm"><i class="fa fa-circle-o"></i> Bank</a></li>
            <li class="active"><?php
                if ($_REQUEST['bankidnum'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Bank</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                if ($_REQUEST['bankidnum'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Bank</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Our Bank Name  <span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control" name="bankname" id="bankname" placeholder="Enter the Bank Name" required="required" pattern="[0-9 A-Z a-z .,-_+]{2,155}" title="Allowed Attributes are [0-9 A-Z a-z .,-_+]" value="<?php echo getbank('Bank_Name', $_REQUEST['bankidnum']); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label>Bank Code <span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control" name="bankcode" id="bankcode" placeholder="Enter the Bank Code" required="required" pattern="[0-9 A-Z a-z .,-_+]{2,155}" title="Allowed Attributes are [0-9 A-Z a-z .,-_+]" value="<?php echo getbank('Bank_Code', $_REQUEST['bankidnum']); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label>Branch Name <span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control" name="branchname" id="bankname" placeholder="Enter the Branch Name" required="required" pattern="[0-9 A-Z a-z .,-_+]{2,155}" title="Allowed Attributes are [0-9 A-Z a-z .,-_+]" value="<?php echo getbank('Branch_Name', $_REQUEST['bankidnum']); ?>" />
                        </div>
                    </div>
                    <div class="clearfix"><br /></div>
                    <div class="row">

                        <div class="col-md-4">
                            <label>Account No<span style="color:#FF0000;"></span></label>
                            <input type="text" class="form-control" name="Acc_no" id="Acc_no" placeholder="Enter the Account No" pattern="[0-9A-Za-z]{2,155}" title="Allowed Attributes are [0-9A-Za-z]" value="<?php echo getbank('Acc_no', $_REQUEST['bankidnum']); ?>" />
                        </div>
                        <div class="col-md-4">
                            <label>IBAN Number<span style="color:#FF0000;"></span></label>
                            <input type="text" class="form-control" name="ifsccode" id="ifsccode" placeholder="Enter the IBAN Number" pattern="[0-9 A-Z a-z .,-_+]{2,155}" title="Allowed Attributes are [0-9 A-Z a-z .,-_+]" value="<?php echo getbank('IFSC_Code', $_REQUEST['bankidnum']); ?>" />
                        </div>
                       <div class="col-md-4">
                            <label>SWIFT Code<span style="color:#FF0000;"></span></label>
                            <input type="text" name="swift" id="swift" class="form-control" placeholder="Enter the Swift Code" value="<?php echo getbank('swift_code', $_REQUEST['bankidnum']); ?>" /> </div>

                    </div>
                    <div class="clearfix"><br /></div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Country<span style="color:#FF0000;"></span></label>
                            <?php echo country_list(getbank('Country', $_REQUEST['bankidnum'])); ?>
                        </div>
                        <div class="col-md-4">
                            <label>State <span style="color:#FF0000;"></span></label>
                            <?php echo state_list(getbank('State', $_REQUEST['bankidnum']), getbank('Country', $_REQUEST['bankidnum'])); ?> </div>
                        <div class="col-md-4">
                            <label>City <span style="color:#FF0000;"></span></label>
                            <?php echo city_list(getbank('City', $_REQUEST['bankidnum']), getbank('State', $_REQUEST['bankidnum'])); ?> </div>
                    </div>
                    <div class="clearfix"><br /></div>
                    <div class="row">

                         <div class="col-md-4">
                            <label>Address<span style="color:#FF0000;"></span></label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Enter the Address" value="<?php echo getbank('Address', $_REQUEST['bankidnum']); ?>" /> </div>
                        <div class="col-md-4">
                            <label>Postal Code <span style="color:#FF0000;"></span></label>
                            <input type="text" name="postal" id="postal" class="form-control"  placeholder="Enter the Postal Code"  value="<?php echo getbank('Postal_Code', $_REQUEST['bankidnum']); ?>" />  </div>
                    </div>
                    <div class="clearfix"><br /></div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Bank  Logo </label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*" />
                        </div>
                        <div class="col-md-6" id="delimage">
                            <label> </label>
                            <?php if (getbank('Image', $_REQUEST['bankidnum']) != '') { ?>
                                <img src="<?php echo $fsitename .'images/bank/'. getbank('Image', $_REQUEST['bankidnum']); ?>" style="padding-bottom:10px;" height="100" />
                                <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getbank('Image', $_REQUEST['bankidnum']); ?>', '<?php echo $_REQUEST['bankidnum']; ?>', 'bank', '../images/bank/', 'Image', 'BankID');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                            <?php }  ?>
                            
                        </div>
                    </div>
                    <div class="clearfix"><br /></div>


                    <div class="row">
                        <div class="col-md-6">
                            <label>Order <span style="color:#FF0000;">*</span></label>
                            <input type="number" min="0" max="100" name="order" id="order" required="required" class="form-control" placeholder="Order" value="<?php echo getbank('Order', $_REQUEST['bankidnum']); ?>" />
                        </div>
                        <div class="col-md-6">
                            <label>Status  <span style="color:#FF0000;">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php
                            if (getbank('Status', $_REQUEST['bankidnum']) == '1') {
                                echo 'selected';
                            }
                            ?>>Active</option>
                                <option value="0" <?php
                                if (getbank('Status', $_REQUEST['bankidnum']) == '0') {
                                    echo 'selected';
                                }
                            ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"><br /></div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>bank/bank.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['bankidnum'] != '') {
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
<script>
function getstate(a)
    {
        if (window.XMLHttpRequest)
        {
            oRequestsubcat = new XMLHttpRequest();
        } else if (window.ActiveXObject)
        {
            oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if (a != '')
        {
            document.getElementById("state").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
            oRequestsubcat.open("POST", "<?php echo $sitename; ?>config/functions_ajax.php", true);
            oRequestsubcat.onreadystatechange = showstate;
            oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oRequestsubcat.send("country=" + a);
        }
    }

    function showstate()
    {
        if (oRequestsubcat.readyState == 4)
        {
            if (oRequestsubcat.status == 200)
            {
                document.getElementById("state").innerHTML = oRequestsubcat.responseText;
            } else
            {
                document.getElementById("state").innerHTML = oRequestsubcat.responseText;
            }
        }
    }
    function getcity(a, b)
    {
        b = document.getElementById(b).value;
        if (window.XMLHttpRequest)
        {
            oRequestsubcat = new XMLHttpRequest();
        } else if (window.ActiveXObject)
        {
            oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if (a != '')
        {
            document.getElementById("city").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
            oRequestsubcat.open("POST", "<?php echo $sitename; ?>config/functions_ajax.php", true);
            oRequestsubcat.onreadystatechange = showcity;
            oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oRequestsubcat.send("state=" + a + "&country=" + b);
        }
    }

    function showcity()
    {
        if (oRequestsubcat.readyState == 4)
        {
            if (oRequestsubcat.status == 200)
            {
                document.getElementById("city").innerHTML = oRequestsubcat.responseText;
            } else
            {
                document.getElementById("city").innerHTML = oRequestsubcat.responseText;
            }
        }
    }
    function getstate1(a)
    {
        if (window.XMLHttpRequest)
        {
            oRequestsubcat = new XMLHttpRequest();
        } else if (window.ActiveXObject)
        {
            oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if (a != '')
        {
            document.getElementById("state1").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
            oRequestsubcat.open("POST", "<?php echo $sitename; ?>config/functions_ajax.php", true);
            oRequestsubcat.onreadystatechange = showstate1;
            oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oRequestsubcat.send("country=" + a);
        }
    }
    function showstate1()
    {
        if (oRequestsubcat.readyState == 4)
        {
            if (oRequestsubcat.status == 200)
            {
                document.getElementById("state1").innerHTML = oRequestsubcat.responseText;
            } else
            {
                document.getElementById("state1").innerHTML = oRequestsubcat.responseText;
            }
        }
    }
    function getcity1(a, b)
    {
        b = document.getElementById(b + "1").value;
        if (window.XMLHttpRequest)
        {
            oRequestsubcat = new XMLHttpRequest();
        } else if (window.ActiveXObject)
        {
            oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if (a != '')
        {
            document.getElementById("city1").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
            oRequestsubcat.open("POST", "<?php echo $sitename; ?>config/functions_ajax.php", true);
            oRequestsubcat.onreadystatechange = showcity1;
            oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oRequestsubcat.send("state=" + a + "&country=" + b);
        }
    }

    function showcity1()
    {
        if (oRequestsubcat.readyState == 4)
        {
            if (oRequestsubcat.status == 200)
            {
                document.getElementById("city1").innerHTML = oRequestsubcat.responseText;
            } else
            {
                document.getElementById("city1").innerHTML = oRequestsubcat.responseText;
            }
        }
    }

</script>