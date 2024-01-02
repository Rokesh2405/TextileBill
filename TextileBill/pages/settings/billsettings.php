<?php
//$menu = "2,1,1,24";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['bid'])) {
    $id = $_REQUEST['bid'];
}
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $msg = addbillsettings($prefix,$format,$current_value,$id);
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Bill Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-cogs"></i> Settings</a></li>
            <li><a href="<?php echo $sitename; ?>settings/billsettingslist.htm">Bill Settings</a></li>
            <li class="active">Edit Bill Settings</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Bill Settings - <?php if(isset($_REQUEST['bid'])){ echo get_bill_settings('type', $id); }  ?></h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    
                    
                    <div class="row">                        
                        <div class="col-md-5">
                            <label>Prefix<span style="color:#FF0000;">*</span></label>
                            <input type="text" class="form-control outclass" placeholder="Enter the Prefix" name="prefix" id="prefix" required="required"  value="<?php if(isset($_REQUEST['bid'])){ echo get_bill_settings('prefix', $id); }  ?>" />
                        </div>
                        <div class="col-md-5">
                            <label>Format digits<span style="color:#FF0000;">*</span></label>
                            <input type="number" class="form-control outclass" placeholder="Enter the Format digits" name="format" id="format" required="required" pattern="[0-9]{1,10}" value="<?php if(isset($_REQUEST['bid'])){ echo get_bill_settings('format', $id); } ?>" />
                        </div>
                        <div class="col-md-2">
                            <label>Current value<span style="color:#FF0000;">*</span></label>
                            <input type="number" class="form-control outclass" placeholder="Enter the starting value" name="current_value" id="current_value" required="required" pattern="[0-9]{1,100}" value="<?php if(isset($_REQUEST['bid'])){ echo get_bill_settings('current_value', $id); } ?>" />
                        </div>
                        
                    </div>
                    <div class="clearfix"><br /></div>
                    <div class="row">
                        <div class="col-md-12">
                            Output : <b id="output"><?php echo get_bill_settings('prefix',$id) . str_pad(get_bill_settings('current_value', $id), get_bill_settings('format',$id), '0', STR_PAD_LEFT); ?></b>
                        </div>
                    </div>
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                         <div class="col-md-6">
                               <a href="<?php echo $sitename; ?>settings/billsettingslist.htm">Back to Listings page</a>
                         </div>    
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;">SAVE</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">
$('.outclass').keyup(function(e){
    var prefix = $('#prefix').val();
    var format = $('#format').val();
    var current_value = $('#current_value').val();
    var counts = '';
    for(var i=1;i<=format-(current_value.length);i++){
        counts += '0';
    }
    counts = counts + '' + current_value;
    $('#output').html(prefix+counts);
});
</script>
