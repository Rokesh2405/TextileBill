<?php
if (isset($_REQUEST['taxid'] )) {
    $thispageeditid = 38;
} else {
    $thispageaddid = 38;
}

include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';
include ('../../require/header.php');
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['taxid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $strupload='1';
    $msg = addtax($tax_name,$tax_per, $order, $status, $ip, $thispageid,$getid);
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tax  
            <small><?php
                if ($_REQUEST['taxid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Tax</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="<?php echo $sitename; ?>settings/tax.htm"><i class="fa fa-circle-o"></i>Tax</a></li>
            <li class="active"><?php
                if ($_REQUEST['taxid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Tax</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['taxid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Tax</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tax Name <span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control" name="tax_name" required="required"  id="tax_name" placeholder="Enter the Tax Name" pattern="[0-9 A-Z a-z %.,-_+]{2,155}" title="Allowed Attributes are [0-9 A-Z a-z ().,-_+]" value="<?php echo gettax('taxname', $_REQUEST['taxid']); ?>" />
                        </div>
                                 <div class="col-md-6">
                            <label>Tax Percentage<span style="color:#FF0000;">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="tax_per" id="tax_per" required="required"  placeholder="Enter the Tax Percentage" pattern="[0-9 A-Z a-z .,-_+]{2,155}" title="Allowed Attributes are [0-9 A-Z a-z .,-_+]" value="<?php echo gettax('taxpercentage', $_REQUEST['taxid']); ?>" />
                        </div>
                        
                    </div>
                    <div class="clearfix"><br /></div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Order <span style="color:#FF0000;">*</span></label>
                            <input type="number" min="0" max="100" name="order" id="order" required="required" class="form-control" placeholder="Order" value="<?php echo gettax('Order', $_REQUEST['taxid']); ?>" />
                        </div>
                        <div class="col-md-6">
                            <label>Status  <span style="color:#FF0000;">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php
                                if (gettax('Status', $_REQUEST['taxid']) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                <option value="0" <?php
                                if (gettax('Status', $_REQUEST['taxid']) == '0') {
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
                            <a href="<?php echo $sitename; ?>settings/tax.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['taxid'] != '') {
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
