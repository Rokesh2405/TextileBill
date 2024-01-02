<?php
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';
include ('../../require/header.php');

if ($_REQUEST['del'] != '') {
    $msg = dellocationimage(getprofile('image', $_SESSION['UID']), $_SESSION['UID']);
    header("location:" . $sitename . "pages/profile/viewprofile.htm");
}

if (isset($_REQUEST['submit'])) {    
    $pimage = getprofile('image', $_SESSION['UID']);
    //  $image = '';
    $imag = strtolower($_FILES["image"]["name"]);
    if ($imag) {
        if ($pimage != '') {
            unlink("image/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 1000;
        $height = 1000;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        $m = time() . $i;
        $imagev = $m . "." . $extension;
        $thumppath = "image/";
        move_uploaded_file($tmp, $thumppath . $imagev);
        $image = $imagev;
    } else {
        $image = $pimage;
    }
        
    
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($password == $cpassword) {
        $msg = addprofile($footer_content,$terms,$tax,$title, $firstname, $lastname, $image, $cmpnyname, $recoveryemail, $phonenumber,$mail_option,  $caddress, $abn, $ip,$bank_name,$branch_name,$account_name,$account_no,$ifsc_code,$swift_code,$branch_address, $_SESSION['UID']);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-exclamation-triangle"></i>Password Does not Match</h4></div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Profile
            <small>Manage Profile</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Profile</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Profile Update</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <!-- <div class="col-md-2">

                                    <label>Title <span style="color:#FF0000;">*</span></label>
                                    <select name="title" id="status" class="form-control">
                                        <option value="Mr" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Mr') {
                                            echo 'selected';
                                        }
                                        ?>>Mr</option>
                                        <option value="Miss" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Miss') {
                                            echo 'selected';
                                        }
                                        ?>>Miss</option>
                                        <option value="Mrs" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Mrs') {
                                            echo 'selected';
                                        }
                                        ?>>Mrs</option>
                                        <option value="Er" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Er') {
                                            echo 'selected';
                                        }
                                        ?>>Er</option>
                                        <option value="Dr" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Dr') {
                                            echo 'selected';
                                        }
                                        ?>>Dr</option>
                                        <option value="Others" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Others') {
                                            echo 'selected';
                                        }
                                        ?>>Others</option>
                                    </select>
                                </div> -->
                                <div class="col-md-5">
                                    <label>First Name <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the first name" name="firstname" id="firstname" required="required" pattern="[0-9 A-Za-z .,-':()[]]{3,60}" title="Allowed Attributes (0-9 A-Za-z .,-':)" value="<?php
                                    if ($_SESSION['UID'] == '1') {

                                        echo getprofile('firstname', $_SESSION['UID']);
                                    } elseif ($_SESSION['UID'] != "") {

                                        //echo getemployees('empname', $_SESSION['UID']);
                                    }
                                    ?>" />
                                </div>
                                <div class="col-md-5">
                                    <label>Last Name </label>
                                    <input type="text" class="form-control" placeholder="Enter the last name" name="lastname" id="lastname" pattern="[0-9 A-Za-z .,-':()[]]{3,60}" title="Allowed Attributes (0-9 A-Za-z .,-':)" value="<?php echo getprofile('lastname', $_SESSION['UID']); ?>" />
                                </div>
                            </div>

                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image </label>
                                    <input type="file" class="form-control" name="image" id="image" />
                                </div>
                                <div class="col-md-6" id="delimage">
                                    <label> </label>
                                    <?php if (getprofile('image', $_SESSION['UID']) != '') { ?>
                                        <img src="<?php echo $sitename . 'pages/profile/image/' . getprofile('image', $_SESSION['UID']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getprofile('image', $_SESSION['UID']); ?>', '<?php echo $_SESSION['UID']; ?>', 'manageprofile', '../pages/profile/image/', 'image', 'pid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Mail Configuration</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Mail Options <span style="color:#FF0000;">*</span></label>
                                    <select class="form-control" name="mail_option" required>
                                        <option value="1" <?php  if (getprofile('mail', $_SESSION['UID']) == '1') {
                                            echo 'selected';
                                        } ?>>PHP Mail</option>
                                        <option value="2" <?php  if (getprofile('mail', $_SESSION['UID']) == '2') {
                                            echo 'selected';
                                        } ?>>Send Grid Mail</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Contact Configuration</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Company name</label>
                                    <input type="text" class="form-control" placeholder="Enter the Company Name" name="cmpnyname" id="cmpnyname"  value="<?php echo getprofile('Company_name', $_SESSION['UID']); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" placeholder="Enter the email address" name="recoveryemail" id="recoveryemail" value="<?php echo getprofile('recoveryemail', $_SESSION['UID']); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" placeholder="Enter the Phone Number" name="phonenumber" id="phonenumber"  value="<?php echo getprofile('phonenumber', $_SESSION['UID']); ?>" />
                                </div> 			
                            </div>
                            <div class="clearfix"><br/></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Contact Address</label>
                                    <textarea class="form-control" placeholder="Enter the Address" name="caddress" id="caddress"><?php echo getprofile('caddress', $_SESSION['UID']); ?></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label>ABN Number</label>
                                    <input type="text" class="form-control" placeholder="Enter the ABN Number" name="abn" id="abn" value="<?php echo getprofile('abn', $_SESSION['UID']); ?>" />
                                </div>
                             <div class="col-md-4">
                                    <label>GST (%)</label>
                                    <input type="number" class="form-control" placeholder="Enter the GST Percentage" name="tax" id="tax" value="<?php echo getprofile('tax', $_SESSION['UID']); ?>" />
                                </div>							
                            </div>
                        </div>
                    </div>
                   <!--  <div class="panel panel-info">
                        <div class="panel-heading">Bank Informations</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Bank Name<span style="color:#FF0000;"></span></label>
                                    <input type="text" class="form-control" placeholder="Enter the Name of Bank" name="bank_name" id="bank_name"  pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?=getprofile('bank_name',$_SESSION['UID'])?>" />
                                </div>
                                <div class="col-md-3">
                                    <label>Branch Name<span style="color:#FF0000;"></span></label>                                    
                                    <input type="text" class="form-control" placeholder="Enter the Branch Name" name="branch_name" id="branch_name"  value="<?=getprofile('branch_name',$_SESSION['UID'])?>" >                                    
                                </div>
                                <div class="col-md-3">
                                    <label>Account Holder Name<span style="color:#FF0000;"></span></label>                                    
                                    <input type="text" class="form-control" placeholder="Enter the Account Holder Name" name="account_name" id="account_name"  value="<?=getprofile('account_name',$_SESSION['UID'])?>" >                                    
                                </div>
                                <div class="col-md-3">
                                    <label>Account Number<span style="color:#FF0000;"></span></label>
                                    <input type="number" class="form-control" placeholder="Enter the Account Number" name="account_no" id="account_no" pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?=getprofile('account_no',$_SESSION['UID'])?>" />
                                </div>                                

                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>IFSC Number </label>
                                    <input type="text" class="form-control" placeholder="Enter the IFSC Number" name="ifsc_code" id="ifsc_code"  value="<?=getprofile('ifsc_code',$_SESSION['UID'])?>" > 
                                </div>
                                <div class="col-md-3">
                                    <label>Swift Code </label>
                                    <input type="text" class="form-control" placeholder="Enter the Swift Code" name="swift_code" id="swift_code"  value="<?=getprofile('swift_code',$_SESSION['UID'])?>" > 
                                </div>
                                <div class="col-md-3">
                                    <label>Branch Address </label>
                                    <textarea class="form-control" placeholder="Enter the branch address" name="branch_address" id="branch_address"><?=getprofile('branch_address',$_SESSION['UID'])?></textarea>
                                </div>

                            </div>

                        </div>
                    </div> -->

                     <div class="panel panel-info">
                        <div class="panel-heading">Invoice Content</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Terms & Conditions<span style="color:#FF0000;"></span></label>
                                    <textarea name="terms" class="form-control" rows="10"><?php echo getprofile('terms',$_SESSION['UID']); ?></textarea>
                                    
                                </div>
                           
                                <div class="col-md-6">
                                    <label>Footer Content<span style="color:#FF0000;"></span></label>                                    
                                    <input type="text" class="form-control" placeholder="Enter the Footer  Content" name="footer_content" id="branch_name"  value="<?=getprofile('footer_content',$_SESSION['UID'])?>" >                                    
                                </div>
                               

                            </div>
                            <div class="clearfix"><br /></div>
                          


                        </div>
                    </div>

                </div><!-- /.box -->
                
                        <div class="box-footer">
                            <div class="col-md-12">
                                <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;">UPDATE</button>
                            </div>
                        </div>
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">

    function dellocationimage()
    {
        if (confirm("Please confirm you want to Delete this Image"))
        {
            window.location.href = '<?php echo $sitename . 'settings/' . $_SESSION['UID'] . '/delimagelocation.html'; ?>';
            return true;
        } else
        {
            return false;
        }
    }
</script>
<?php include ('../../require/footer.php'); ?>