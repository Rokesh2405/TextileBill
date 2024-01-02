<?php
$menu = '50,50,50';
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
$_SESSION['managetemplateid']='';

if ($_REQUEST['tid'] != '') {
    $ck = DB_QUERY("SELECT `tid` FROM `templates` WHERE `status`='1' AND `tid`='" . $_REQUEST['tid'] . "'");
    if ($ck['tid']== '') {
        echo '<meta http-equiv="refresh" content="0;url=' . $sitename . 'templates/managetemplates.htm' . '">';
        exit;
    }
}

if (isset($_REQUEST['submit']))
{
    @extract($_REQUEST);
    $_SESSION['managetemplateid']=$_REQUEST['tid'];
    $ip=$_SERVER['REMOTE_ADDR'];
    $msg = addtemplate($title, $type, $message, $status, $ip, $_SESSION['managetemplateid']);
}
?>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
	
$(document).ready(function(){
    var $remaining = $('#remaining'),
        $messages = $remaining.next();

    $('#message').keyup(function(){
        var chars = this.value.length,
            messages = Math.ceil(chars / 160),
            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

        $remaining.text(remaining + ' characters remaining');
        $messages.text(messages + ' message(s)');
    });
});
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            SMS Templates 
<!--            <small><?php
                if ($_REQUEST['aid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;Template</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="#" ><i class="fa fa-backward"></i> SMS Templates</a></li>
            <li class="active"><?php
                if ($_REQUEST['tid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;SMS Template</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="template" id="template" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                if ($_REQUEST['tid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;SMS Template</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Title <span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter the Title" name="title" id="title" required="required" pattern="[0-9 A-Za-z .,-':()[]]{3,60}" title="Allowed Attributes (0-9 A-Za-z .,-':)" value="<?php echo gettemplate('title',$_REQUEST['tid']); ?>" />
                        </div>
                        <div class="col-md-6">
                            <label>Type <span style="color:#FF0000;">*</span></label>
                            <select name="type" id="type" class="form-control">
<option value="">Select Type</option>
<?php
                            $depart = DB("SELECT * FROM `sms_type` WHERE `status` ='1'");  
                            while ($fdepart = mysqli_fetch_array($depart)) { ?>
                                <option value="<?php echo $fdepart['smid']?>" <?php if(gettemplate('type',$_REQUEST['tid'])==$fdepart['smid']) { echo 'selected="selected"'; } ?>><?php echo $fdepart['title'];?></option><?php } ?>
                            </select>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <label>Message <span style="color:#FF0000;">*</span></label>
                            <textarea name="message" id="message" class="form-control" maxlength="640"><?php echo stripslashes(gettemplate('message',$_REQUEST['tid'])); ?></textarea>
                            <br /><span id="remaining">160 characters </span>
    <span id="messages">1 message(s)</span><br/>
                            Maximum 640 Chars
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <label>Status </label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" <?php if(gettemplate('status',$_REQUEST['tid'])=='1') { echo 'selected="selected"'; } ?>>Active</option>
                                <option value="0" <?php if(gettemplate('status',$_REQUEST['tid'])=='0') { echo 'selected="selected"'; } ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <br />
                    
                    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>pages/template/managetemplates.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php if($_REQUEST['tid']!='') { echo 'UPDATE'; } else { echo 'SUBMIT'; } ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>