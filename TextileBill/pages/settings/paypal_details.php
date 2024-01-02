<?php
if (isset($_REQUEST['id'])) {
    $thispageeditid = 5;
} else {
    $thispageaddid = 5;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');


if (isset($_REQUEST['submit'])) {

    @extract($_REQUEST);
    
    $details=$db->prepare("SELECT * FROM `paypal`");
    $details->execute();
    if($details->rowCount() > 0)
    {
	$paypal_up = $db->prepare("UPDATE `paypal` SET `method`=?,`username`=?,`password`=?,`signature`=? ");
        $paypal_up->execute(array($method,$username,$password,$signature));
         $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated</h4></div>';
    }
    else
   {
        $paypal_in = $db->prepare("INSERT INTO `paypal` SET `method`=?,`username`=?,`password`=?,`signature`=? ");
        $paypal_in->execute(array($method,$username,$password,$signature));	
         $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Saved</h4></div>';
   }
 
}
 $i = '';
$editresult = $db->prepare("SELECT * FROM `paypal`");
$editresult->execute();
 if ($editresult->rowCount() > 0) {
     $i = '1';
 }
 $editresult = $editresult->fetch();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Paypal Mgmt
          
        </h1>
        <ol class="breadcrumb">
            <li><a data-toggle="control-sidebar" href="#"><i class="fa fa-gears"></i> Settings</a>
        
            <li><a href="#"><i class="fa fa-gear"></i> Paypal Mgmt</a></li>

         
            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name="state" id="state"  method="post" onSubmit="return check();" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                       /* if ($_REQUEST['banid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?>   Paypal Mgmt */ ?></h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;"> *</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                   



 <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Paypal Details
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PayPal Email<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="username"class="form-control" value="<?php echo $editresult['username']; ?>"  required />                     
                                    </div>
                                    
                                    
                                    
                                    
                                </div>   
                                
                                <!--    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>API Password<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="password"class="form-control" value="<?php echo $editresult['password']; ?>"  required />                     
                                    </div>
                                    
                                    
                                    
                                    
                                </div>   
                                
                                 
                                
                          
                                                            
                            </div>
                            
                            <br />
                           
                                    <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>  API Signature<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="signature"class="form-control" value="<?php echo $editresult['signature']; ?>"  required />                     
                                    </div>
                                    
                                    
                                    
                                    
                                </div>  --> 
                                
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Method<span style="color:#FF0000;"> *</span></label>                                  
                                       <select name="method" class="form-control">
                                       	<option value="sandbox" <?php if( $editresult['method'] == 'sandbox'){ ?> selected <?php } ?> >Sandbox</option>
                                       	 	<option value="live"   <?php if( $editresult['method'] == 'live'){ ?> selected <?php } ?> >live</option>
                                      
                                       </select>
                                       
                                        
                                    </div>
                                    
                                    
                                    
                                    
                                </div>   
                                
                                 
                                
                          
                                                            
                            </div>


 </div>
                        </div>
                        
                        
                        
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                               
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                    if ($i != '') {
                                        echo 'UPDATE';
                                    } else {
                                        echo 'SAVE';
                                    }
                                    ?></button>
                            </div>
                        </div>
                    </div></div>
        </form>
        <!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">
    function delrec(a, b) {
        if (confirm("Are you sure you want to remove this timing?")) {
            a.parent().parent().remove();
            var rtn = '';
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/delthistime.php",
                async: false,
                data: {id: b},
                success: function (data) {
                    rtn = '1';
                }
            });
            if (rtn == '1') {

            }
        }
    }

    function ccity(city, id)
    {

        $.post("<?php echo $sitename; ?>pages/master/checkcity.php", {city: city, editid: id}, function (data) {
            if (data == 1)
            {
                // $('#response').html(data);
                $('#response').html('<div style="color:red">District Already Exists</div>');
                //$('#response1').html('input type="hidden" id="val" name="val" value="'+1+'" ');
                var textcontrol = document.getElementById("onecity");
                textcontrol.value = 1;
            }
            else
            {
                // $('#response').html(data);
                $('#response').html('');
                var textcontrol = document.getElementById("onecity");
                textcontrol.value = 2;
            }

        });
    }
    function check()
    {
        var searchtext = document.getElementById("onecity").value;
        if (searchtext == 1)
        {
            alert('District Already Exists');
            return false;
        }
        else {
        }


    }
    function currency(a) {
        //  alert(a);
        var loader_image = "<span style='padding:750px 200px 0px 290px'><img src='<?php echo $fsitename; ?>images/ajax-loader.gif' /></span>";
        $("#load").html(loader_image);
        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/loadcurrency.php",
            //async: false,
            data: {id: a},
            success: function (data) {
                // rtn = '1';
                $('#load').html(data);
            }
        });
    }
    $('#countrychangeable').change(function () {
        currency($(this).val());
    });
</script>