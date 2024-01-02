<?php
if (isset($_REQUEST['cuid'] )) {
    $thispageeditid = 11;
} else {
    $thispageaddid = 11;
}
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cuid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addcurrency($currencyname,$currencycode,$currencyicon, $order, $status, $ip,  $getid);
}
?>
<style type="text/css">
    .select2-container .select2-selection--single {
        border-radius: 0;
        height: 34px;
    }
    
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Currency  
            <small><?php
                if ($_REQUEST['cuid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Currency</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-gears"></i> Setting (s)</a></li>
            <li><a href="<?php echo $sitename; ?>settings/currency.htm"><i class="fa fa-money"></i>&nbsp;&nbsp;Currency</a></li>
            <li class="active"><?php
                if ($_REQUEST['cuid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>  Currency</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cuid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Currency</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Currency Name  <span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter the Currency Name" name="currencyname" id="currencyname" required="required" pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?php echo getcurrency('Currency_Name', $_REQUEST['cuid']); ?>" />
                        </div>
			<div class="col-md-4">
                            <label>Currency Code<span style="color:#FF0000;">*</span></label>
<!--                            <select name="currencycode" id="currencycode" class="form-control select2" required style="height: 30px;border-radius: 0;">
                                <option value="">Please select</option>
                                <?php 
//                                    $sc = $db->prepare("SELECT * FROM `countries`");
//                                    $sc->execute();
//                                    while($f = $sc->fetch()){
                                ?>
                                <option value="<?php // echo $f['countries_iso_code_3']; ?>"><?php // echo $f['countries_name'].'('.$f['countries_iso_code_3'].')'.' - '.Currency($f['countries_iso_code_3']); ?></option>
                                    <?php // } ?>
                            </select>-->
                            <input type="text" class="form-control" placeholder="Enter the Currency Code" name="currencycode" id="currencycode" required="required" pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?php echo getcurrency('Currency_Code', $_REQUEST['cuid']); ?>" />
                        </div>
			
			<div class="col-md-4">
                            <label>Currency Symbol<span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter the Currency Symbol" name="currencyicon" id="currencyicon" required="required" pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?php echo getcurrency('Currency_Icon', $_REQUEST['cuid']); ?>" />
                        </div>
			</div>
			<div class="clearfix"><br /></div>
                    	<div class="row">
                        <div class="col-md-6">
                            <label>Order <span style="color:#FF0000;">*</span></label>
                            <input type="number" name="order" id="order" min="1" max="100" required="required" class="form-control" placeholder="Order" value="<?php echo getcurrency('Order', $_REQUEST['cuid']); ?>" />
                        </div>
                        <div class="col-md-6">
                            <label>Status  <span style="color:#FF0000;">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php
                                if (getcurrency('Status', $_REQUEST['cuid']) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if (getcurrency('Status', $_REQUEST['cuid']) == '0') {
                                    echo 'selected';
                                }
                                ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>settings/currency.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['cuid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'Save';
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
