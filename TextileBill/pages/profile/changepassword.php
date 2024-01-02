<?php
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($_SESSION['UID'] == '1') {
        if ($password == $cpassword) {
            $resa = $db->prepare("UPDATE `users` SET `val2`=? WHERE `id`=?");
            $resa->execute(array(md5(trim($password)),'1'));
            $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-exclamation-tick"></i>Successfully Updated</h4></div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-exclamation-triangle"></i>Password Does not Match</h4></div>';
        }
    } else {
        if ($password == $cpassword) {
            
            $resa = $db->prepare("UPDATE `users` SET `val2`=? WHERE `id`=?");
            $resa->execute(array(md5(trim($password)),$_SESSION['UID']));

            $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-exclamation-tick"></i>Successfully Updated</h4><!--<a href="settings/addtaxmasters.htm">Add another one</a>--></div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-exclamation-triangle"></i>Password Does not Match</h4><!--<a href="settings/addtaxmasters.htm">Add another one</a>--></div>';
        }
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Change Password
            <small>Change Password</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $sitename; ?>pages/profile/viewprofile.htm">Profile</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Password</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>  <br/>

                </div>
                <div class="box-body">
<?php echo $msg; ?>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">Change Password</div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>New Password</label>
                                <input type="password" required="required" class="form-control" placeholder="New Password" name="password" id="password" min="6" Max="255" value="" />
                            </div>
                            <div class="col-md-6">
                                <label>Confirm Password</label>
                                <input type="password" required="required" class="form-control" placeholder="Confirm Password" name="cpassword" id="cpassword" min="6" Max="255" value="" />
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?php echo $sitename; ?>pages/profile/viewprofile.htm">Back to Listings page</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="submit" id="submit" class="btn btn-success" onclick="validatePassword();" style="float:right;">Change Password</button>
                            </div></div></div>
                </div>
        </form>
    </section>
</div>
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">
    function validatePassword()
    {
        var password = document.getElementById("password"), conpassword = document.getElementById("cpassword");
        if (password.value != conpassword.value) {
            conpassword.setCustomValidity("Passwords Don't Match");
        } else {
            conpassword.setCustomValidity('');
        }
    }

    // password.onchange = validatePassword;
    //  conpassword.onkeyup = validatePassword;
</script>