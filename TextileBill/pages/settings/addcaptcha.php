<?php
if (isset($_REQUEST['cid'])) {
    $thispageeditid = 26;
} else {
    $thispageaddid = 26;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';

include ('../../require/header.php');
$_SESSION['cid'] = '';


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $_SESSION['cid'] = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addcaptcha($sitekey,$secret,$status,$ip,$_SESSION['cid']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Captcha Mgmt
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Captcha Mgmt</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="<?php echo $sitename; ?>settings/captcha.htm"><i class="fa fa-refresh"></i>Captcha Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;Captcha Mgmt</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Captcha Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">Captcha Mgmt Details</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Sitekey <span style="color:#FF0000;">*</span></label>
                                    <textarea id="sitekey" name="sitekey" class="form-control" rows="3" cols="20" required="required"><?php echo stripslashes(getcaptcha('sitekey', $_REQUEST['cid'])); ?></textarea>
                                    
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Secret Key<span style="color:#FF0000;">*</span></label>
                                     <textarea id="secret" name="secret" class="form-control" rows="3" cols="20" required="required"><?php echo stripslashes(getcaptcha('secret', $_REQUEST['cid'])); ?></textarea>
                                   
                                </div>
                                
                            </div>
                            <br />
                            <div class="row">

                        <div class="col-md-6">
                            <label>
                                Status
                                <span style="color:#FF0000;">
                                    *
                                </span>
                            </label>
                            <select name="status" id="status" required="required" class="form-control">
                                <option value="1" <?php
                                if (getcaptcha('status', $_REQUEST['cid']) == '1') {
                                    echo 'selected';
                                }
                                ?>>
                                    Active
                                </option>
                                <option value="0" <?php
                                if (getcaptcha('status', $_REQUEST['cid']) == '0') {
                                    echo 'selected';
                                }
                                ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                            <br />
                        </div>
                    </div>
                   
                    
                   
          
                </div>
           
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo $sitename; ?>settings/captcha.htm">Back to Listings page</a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                            if ($_REQUEST['cid'] != '') {
                                echo 'UPDATE';
                            } else {
                                echo 'SAVE';
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
<script src="<?php echo $sitename; ?>plugins/select2/select2.full.min.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
</script>