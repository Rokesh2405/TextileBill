<?php
if ($_REQUEST['hcid'] != '') {
    $thispageeditid = 12;
} else {
    $thispageaddid = 12;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';

include ('../../require/header.php');
$_SESSION['sid'] = '';


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $_SESSION['hcid'] = $_REQUEST['hcid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addhomecontent($title1, $content1, $status1, $title2, $content2, $status2, $title3, $content3, $status3, $ip, $_SESSION['hcid']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Home Contents
            <small><?php
                if ($_REQUEST['hcid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Home Contents</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="<?php echo $sitename; ?>settings/homecontent.htm">Home Contents </a></li>
            <li class="active"><?php
                if ($_REQUEST['hcid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;Home Contents</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['hcid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Home Contents</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">Our Fleet Section</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title </label>
                                    <input class="form-control" placeholder="Enter the Title" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z ./-*()]{0,60}" name="title1" id="title1"  value="<?php echo stripslashes(gethomecontent('title1', $_REQUEST['hcid'])); ?>" />
                                </div>                         
                                <div class="col-md-6">
                                    <label>Content </label>
                                    <textarea name="content1" id="content1" class="form-control" placeholder="Enter the Content here"><?php echo stripslashes(gethomecontent('content1', $_REQUEST['hcid'])); ?></textarea>
                                </div>
                            </div><br/>
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status1" class="form-control">
                                        <option value="1" <?php
                                        if (gethomecontent('status1', $_REQUEST['hcid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (gethomecontent('status1', $_REQUEST['hcid']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>

                                    </select>
                                </div>
                                <div id="txtHint1"><b></b></div>
                            </div> 
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">Online Booking Section</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title </label>
                                    <input class="form-control" placeholder="Enter the Title" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z ./-*()]{0,60}" name="title2" id="title2"  value="<?php echo stripslashes(gethomecontent('title2', $_REQUEST['hcid'])); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Content </label>
                                    <textarea name="content2" id="content2" class="form-control" placeholder="Enter the Content here"><?php echo stripslashes(gethomecontent('content2', $_REQUEST['hcid'])); ?></textarea>
                                </div>
                            </div><br/>
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                  
                                    <select name="status2" class="form-control">
                                        <option value="1" <?php
                                        if (gethomecontent('status2', $_REQUEST['hcid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (gethomecontent('status2', $_REQUEST['hcid']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>
                                    </select>
                                </div>
                                <div id="txtHint1"><b></b></div>
                            </div> 
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">Section 3</div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title </label>
                                    <input class="form-control" placeholder="Enter the Title" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z ./-*()]{0,60}" name="title3" id="title3"  value="<?php echo stripslashes(gethomecontent('title3', $_REQUEST['hcid'])); ?>" />
                                </div>

                                <div class="col-md-6">
                                    <label>Content </label>
                                    <textarea name="content3" id="content3" class="form-control" placeholder="Enter the Content here"><?php echo stripslashes(gethomecontent('content3', $_REQUEST['hcid'])); ?></textarea>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                  
                                    <select name="status3" id="status3" class="form-control">
                                        <option value="1" <?php
                                        echo (gethomecontent('status3', $_REQUEST['hcid']) == '1') ? 'selected' : '';
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        echo (gethomecontent('status3', $_REQUEST['hcid']) != '1') ? 'selected' : '';
                                        ?>>Inactive</option>
                                    </select>
                                </div>
                                <div id="txtHint1"><b></b></div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>settings/homecontent.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['hcid'] != '') {
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