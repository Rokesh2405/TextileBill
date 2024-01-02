<?php
if (isset($_REQUEST['sid'])) {
    $thispageeditid = 7;
} else {
    $thispageaddid = 7;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';

include ('../../require/header.php');
$_SESSION['sid'] = '';


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $_SESSION['sid'] = $_REQUEST['sid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addsocialmedia($social_media, $link, $order, $status, $ip, $_SESSION['sid']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Social Media 
            <small><?php
                if ($_REQUEST['sid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Social Media</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="<?php echo $sitename; ?>settings/socialmedia.htm"><i class="fa fa-map-marker"></i> Social Media </a></li>
            <li class="active"><?php
                if ($_REQUEST['sid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;Social Media</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['sid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Social Media</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">Social Media Details</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Social Media <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the Social Media" name="social_media" id="social_media" required="required" <?php if (getsocialmedia('sname', $_REQUEST['sid']) != '') { ?> readonly <?php } ?> value="<?php echo getsocialmedia('sname', $_REQUEST['sid']); ?>" />
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Link <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the Link" name="link" id="link" required="required"  value="<?php echo getsocialmedia('link', $_REQUEST['sid']); ?>" />
                                </div>


                                <div class="col-md-6">
                                    <label>
                                        Status
                                    </label>
                                    <select name="status" id="status" required="required" class="form-control">
                                        <option value="1" <?php
                                        if (getsocialmedia('status', $_REQUEST['sid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>
                                            Active
                                        </option>
                                        <option value="0" <?php
                                        if (getsocialmedia('status', $_REQUEST['sid']) == '0') {
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
                            <a href="<?php echo $sitename; ?>settings/socialmedia.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['sid'] != '') {
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