<?php
if (isset($_REQUEST['id'])) {
    $thispageeditid = 6;
} else {
    $thispageaddid = 6;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');


if (isset($_REQUEST['submit'])) {

    @extract($_REQUEST);

    $details = $db->prepare("SELECT * FROM `shipping_post`");
    $details->execute(array());
    if ($details->rowCount() > 0) {
     $shipping_up = $db->prepare("UPDATE `shipping_post` SET `aus_post_api_key`= ? ,`tnt_username`=?,`tnt_password`=?,`tnt_sender_account`=?,`more_thankg`=?,`less_thankg`=?,`less_than`=?,`more_than`=? ");
     $shipping_up->execute(array($aus_post_api_key,$tnt_username,$tnt_password,$tnt_sender_account,$more_thankg,$less_thankg,$less_than,$more_than));
     $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Saved</h4></div>';
    } else {
        $shipping_in = $db->prepare("INSERT INTO `shipping_post`  SET `aus_post_api_key`= ? ,`tnt_username`=?,`tnt_password`=?,`tnt_sender_account`=?,`more_thankg`=?,`less_thankg`=?,`less_than`=?,`more_than`=? ");
        $shipping_in->execute(array($aus_post_api_key,$tnt_username,$tnt_password,$tnt_sender_account,$more_thankg,$less_thankg,$less_than,$more_than));
        $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully updated</h4></div>';
    }

    
}
 $i = '';
$editresult = $db->prepare("SELECT * FROM `shipping_post`");
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
            Shipping Post Mgmt

        </h1>
        <ol class="breadcrumb">
            <li><a data-toggle="control-sidebar" href="#"><i class="fa fa-gears"></i> Settings</a></li>

            <li><a href="#"><i class="fa fa-gear"></i>Shipping Post Mgmt</a></li>



        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name="state" id="state"  method="post" onSubmit="return check();" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
if ($_REQUEST['banid'] != '') {
    echo 'Edit';
} else {
    echo 'Add New';
}
?>    Shipping Post Mgmt </h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;"> *</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
<?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            TNT Details
                        </div>
                        <div class="panel-body">     



                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Less than   <span style="color:#FF0000;"> *</span>     </label>          <input type="text" name="less_thankg"class="form-control" value="<?php echo $editresult['less_thankg']; ?>"  required />                         



                                            </div>

                                            <div class="form-group">

                                                <input  type="radio" name="less_than" value="tnt" id="adm" <?php if ($editresult['less_than'] == 'tnt') {
    echo 'checked';
} ?> />         <label for="adm" >Tnt </label> <br>
                                               <input  type="radio" name="less_than" value="aus" id="adsm"  <?php if ($editresult['less_than'] == 'aus') {
    echo 'checked';
} ?>  />         <label for="adsm" >Australia Post </label> 


                                            </div>

                                        </div>	


                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label>More than   <span style="color:#FF0000;"> *</span>     </label>          <input type="text" name="more_thankg"class="form-control" value="<?php echo $editresult['more_thankg']; ?>"  required />                            
                                            </div>

                                            <div class="form-group">

                                                <input  type="radio" name="more_than" value="tnt" id="ad"  <?php if ($editresult['more_than'] == 'tnt') {
    echo 'checked';
} ?>  />         <label for="ad" >Tnt </label> <br>
                                                <input  type="radio" name="more_than" value="aus" id="ads" <?php if ($editresult['more_than'] == 'aus') {
    echo 'checked';
} ?>  />         <label for="ads" >Australia Post </label> 

                                            </div>
                                        </div>


                                    </div>





                                </div>   


                            </div>  

                            <br />


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>  TNT Username<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="tnt_username"class="form-control" value="<?php echo $editresult['tnt_username']; ?>"  required />                     
                                    </div>




                                </div>   

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>  TNT Password<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="tnt_password"class="form-control" value="<?php echo $editresult['tnt_password']; ?>"  required />                     
                                    </div>




                                </div>   

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>  TNT Sender Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="tnt_sender_account"class="form-control" value="<?php echo $editresult['tnt_sender_account']; ?>"  required />                     
                                    </div>




                                </div>   

                            </div>

                            <br />




                        </div>
                    </div>



                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Australia Post Details
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>  Australia Post API Key<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="aus_post_api_key"class="form-control" value="<?php echo $editresult['aus_post_api_key']; ?>"  required />                     
                                    </div>




                                </div>   






                            </div>

                            <br />




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
            } else
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
        } else {
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