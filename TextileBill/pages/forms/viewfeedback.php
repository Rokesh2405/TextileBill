<?php
$menu = '46,46,48';
if (isset($_REQUEST['coid'])) {
    $thispageeditid = 48;
} else {
    $thispageaddid = 48;
}
$franchisee = 'yes';
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {

    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];



    $general = FETCH_all("SELECT * FROM `generalsettings` WHERE `generalid` = ?", '1');
    $from = $general['support_mail'];
    $to = trim($_REQUEST['email']);

    $name = getfeedbackform('name', $_REQUEST['coid']);

    $general = FETCH_all("SELECT * FROM `generalsettings` WHERE `generalid` = ?", '1');

    $from = $general['support_mail'];

    $to =  $_REQUEST['email'];

    $subject = $_REQUEST['subject'];

    $MESSAGE = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo1.jpg' .'" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">Feedback Response </span>
                    </th>
                    </thead>
                    
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td height="15" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding: 0 10px; color:#000;">Dear ' .  $name  . ' ,</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                   <tr>
<td height="15" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding: 0 10px; color:#000; font-weight:normal;">' . $_REQUEST['subject'] . '</td>
        </tr>
        <tr>
<td height="15" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding: 0 10px; color:#000; font-weight:normal;">' . $_REQUEST['comment'] . '</td>
        </tr>
                    
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Click2buy All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

//echo $MESSAGE; die;

sendgridmail($to, $MESSAGE, $subject, $from, '', '');


   // $general = FETCH_all("UPDATE `feedback` SET `view` = ?, `replay`= ?  WHERE `fdid` = ?", '1', '1', $_REQUEST['coid']);






    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Send</h4></div>';
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Feedback
            <small><?php
                if ($_REQUEST['coid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> View Feedback</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"> <i class="fa fa-envelope-o"></i>Forms</a></li>
            <li><a href="<?php echo $sitename; ?>forms/feedlist.htm">Feedback Forms</a></li>
            <li class="active"><?php
                if ($_REQUEST['coid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;View Feedback</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data" autocomplete="off" >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['coid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?>&nbsp;View Feedback</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Feedback Form</div>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-3">
                                    Name:
                                </div>
                                <div class="col-md-3">
                                    <?php echo getfeedbackform('name', $_REQUEST['coid']); ?>
                                </div>
                            </div>
                            <br />


                            <div class="row">
                                <div class="col-md-3">
                                    Email:
                                </div>
                                <div class="col-md-3">
                                    <?php echo getfeedbackform('email', $_REQUEST['coid']); ?>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-3">
                                    Contact Number:
                                </div>
                                <div class="col-md-3">
                                    <?php echo getfeedbackform('contactno', $_REQUEST['coid']); ?>
                                </div>
                            </div><br>


                            <br />

                            <div class="row">
                                <div class="col-md-3">
                                    Message:
                                </div>
                                <div class="col-md-3">
                                    <?php echo getfeedbackform('message', $_REQUEST['coid']); ?>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-3">
                                    Date Time:
                                </div>
                                <div class="col-md-3">
                                    <?php echo date('d-M-Y h:i:m a', strtotime(getfeedbackform('datetime', $_REQUEST['coid']))); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <button type="button"  id="submit" class="btn btn-success" style="float:right;" onclick="click1();"> Reply</button>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="panel panel-info" id="demo" style="display: none;">
                        <div class="panel-heading">
                            <div class="panel-title">Reply</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>To <span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="email" required="required" id="email" class="form-control" value="<?php echo getfeedbackform('email', $_REQUEST['coid']); ?>" />
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12">
                                    <br>
                                    <label>Subject <span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="subject" id="subject"  required="required"  class="form-control" placeholder="Enter the Subject"> </div></div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <label>Comment <span style="color:#FF0000;">*</span></label>
                                    <textarea rows="3" cols="30" name="comment"  required="required"  id="comment" class="form-control"> </textarea>
                                </div> </div>
                            <br/>

                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;" >Send</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div><!-- /.box-body -->
        </form> 
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>

<script>
    function click1()
    {

        $('#demo').css("display", "block");

    }
</script>