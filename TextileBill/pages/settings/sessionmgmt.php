<?php
$thispageid=34;
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = 1;
include ('../../require/header.php');
?>
<style type="text/css">
    .btn-circle {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    font-size: 24px;
    line-height: 1.33;
    border-radius: 35px;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Site Location Selection
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i>&nbsp;Settings</a></li>
            <li class="active"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;Select Site Location</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
        $sel = DB("SELECT * FROM `sitelocations` WHERE `status`='1' ORDER BY `order` ASC");
        while ($fsel = mysql_fetch_array($sel)) {
            ?>
            <div class="col-md-4">
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-black" style="background: url('<?php echo $sitename; ?>pages/settings/locations/<?php echo $fsel['image']; ?>') no-repeat top center; background-size:100% auto;"></div>
                <div class="widget-user-image">
                    <br />
                    <button type="button" onclick="window.location.href='<?php echo $sitename; ?>location/<?php echo $fsel['lid']; ?>/update.htm'" class="btn  <?php if($_SESSION['locid']==$fsel['lid']){ echo 'btn-success'; } else { echo 'btn-info'; } ?> btn-circle"><i class="glyphicon glyphicon-ok"></i></button>
                    <!---->
                </div>
                <div class="box-footer">
                    <div class="row">
                        <h2 class="widget-user-username"style="font-size:20px;padding-left:20px;"><?php echo stripslashes($fsel['sitetitle']); ?></h2>
                        <h2 class="widget-user-desc"style="font-size:25px;padding-left:20px;"><?php echo stripslashes($fsel['location']); ?></h2>
                        <div class="col-sm-12 border-right">
                            <div class="description-block">
                                <span class="description-text"><?php echo stripslashes($fsel['description']); ?></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
		<div class="row">
		 <div class="col-md-4">
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-black" ></div>
                <div class="widget-user-image">
                    <br />
                    <button type="button" onclick="window.location.href='<?php echo $sitename; ?>location/all/update.htm'" class="btn <?php if($_SESSION['locid']==''){ echo 'btn-success'; } else { echo 'btn-info'; } ?> btn-circle"><i class="glyphicon glyphicon-ok"></i></button>
                    <!---->
                </div>
                <div class="box-footer">
                    <div class="row">
                        <h2 class="widget-user-username"style="font-size:20px;padding-left:20px;">All Locations</h2>
                        <h2 class="widget-user-desc"style="font-size:25px;padding-left:20px;">&nbsp;</h2>
                        <div class="col-sm-12 border-right">
                            <div class="description-block">
                                <span class="description-text"><?php echo stripslashes($fsel['description']); ?></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                </div>
            </div>
        </div></div>
		
		
		
       
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>