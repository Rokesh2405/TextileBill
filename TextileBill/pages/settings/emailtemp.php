<?php
$thispageid = 11;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable='1';
include ('../../require/header.php'); 
//print_r($_REQUEST);
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST); 
    $id = $_REQUEST['tid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = updateEmailTemplate($name,$subject,$message,$id);
}
?>

<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(3), tbody tr td:nth-child(4),tbody tr td:nth-child(5),tbody tr td:nth-child(6) {
        text-align:center;
    }
</style> 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
            <section class="content-header">
            <h1> Templates </h1>
            <ol class="breadcrumb">
                <li><a href="."><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gear"></i> Settings</a></li>
                <li><a href="<?php echo $sitename; ?>settings/emailtemplist.htm"><i class="fa fa-envelope"></i> Email Templates</a></li>                
                <li class="active"><?php echo getTableValue('email_template', 'name', $_REQUEST['tid']); ?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h6 class="box-title"><?php echo getTableValue('email_template','name', $_REQUEST['tid']);?> Template</h6>
                        </div>
                         <form method="post" name="email_template_form">
                        <div class="box-body"> 
                            
                               <div class="row">
                                    <div class="col-md-6">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="name" required="true" readonly="readonly" value="<?php echo getTableValue('email_template','name', $_REQUEST['tid']);?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" required="true" value="<?php echo getTableValue('email_template','subject', $_REQUEST['tid']);?>" />
                                    </div>
                                    
                                </div>
                                <div class="clearfix"><br /></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Email Content</label>
                                        <textarea name="message" id='editor1' required="required"><?php echo getTableValue('email_template','message', $_REQUEST['tid']); ?></textarea>
                                    </div>
                                </div>
                                <div class="clearfix"><br /></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Instructions</div>
                                            <div class="panel-body">
                                                <?php echo getTableValue('email_template','instructions', $_REQUEST['tid']);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" name="submit" id="submit" class="btn btn-warning btn-social" style="float:right;background-color: #C2185B;border-color: #C2185B;"><i class="fa fa-save" style="font-size: 14px;"></i> Save</button> 
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- /input-group -->
                    <!-- /.box-body -->
                </div>
            

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper --></div><!-- /.content-wrapper -->
<?php
include ('../../require/footer.php');
?>  