<?php
if ($_REQUEST['id'] != '') {
    $thispageeditid = 2;
} else {
    $thispageaddid = 2;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';

include ('../../require/header.php');
$_SESSION['sid'] = '';


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
   // $_SESSION['gid'] = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];

	$msg = addreward($purchase_point, $redeem_point,$min_point);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reward Point
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Settings</a></li>
            <li class="active">Reward Point</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Reward Point</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">Reward Point Details</div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <label>1 Point value at Purchase</label>
                                    <input type="number" class="form-control" name="purchase_point" id="purchase_point" required value="<?php echo stripslashes(getreward('purchase_point', $_REQUEST['id'])); ?>" />
                                    <br />
                                </div>
                                <div class="col-md-6">
                                    <label>1 Point value at Redeem</label>
                                     <input type="number" class="form-control"  name="redeem_point" required id="redeem_point" value="<?php echo stripslashes(getreward('redeem_point', $_REQUEST['id'])); ?>" />
                                    
                                </div>
								 
                            </div>
							<div class="row">
                            <div class="col-md-6">
                                    <label>Minimum points for Redeem </label>
                                     <input type="number" class="form-control"  name="min_point" required id="min_point" value="<?php echo stripslashes(getreward('min_point', $_REQUEST['id'])); ?>" />
                                    
                                </div>
</div>
                            <!--<div class="row">
                                <div class="col-md-12">
                                    <label>Footer Content</label>
                                    <textarea class="form-control"  name="address" id="address" /><?php //echo stripslashes(getgeneral('addressinfo', $_REQUEST['id']));  ?></textarea>
                                </div>
                            </div><br/>-->
                         
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>settings/general.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['id'] != '') {
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