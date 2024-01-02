<?php
$menu = '49,49,50';
if (isset($_REQUEST['aiid'])) {
    $thispageeditid = 50;
} else {
    $thispageid = 50;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');


if (isset($_REQUEST['submit'])) {
    $i = 1;
    @extract($_REQUEST);
    $getid = $_REQUEST['aiid'];
    $ip = $_SERVER['REMOTE_ADDR'];
   
       if ($imagename != '') {
        $imagec = $imagename;
    } else {
        $imagec = time();
    }
    $imag = strtolower($_FILES["image"]["name"]);
    if ($getid != '') {
        $linkimge = $db->prepare("SELECT * FROM `imageup` WHERE `aiid` = ? ");
        $linkimge->execute(array($getid));
        $linkimge1 = $linkimge->fetch();
        $pimage = $linkimge1['image'];
    }
    if ($imag) {
        if ($pimage != '') {
            unlink("../../../images/iamgeup/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 1000;
        $height = 1000;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = $imagec;
            $imagev = $m . "." . $extension;
            $thumppath = "../../../images/imageup/";
            move_uploaded_file($tmp, $thumppath . $imagev);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['aiid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext == '1') {
        $msg = '<h4 class="icon fa fa-close" style="color:#e73d4a;"> <i class="icon fa fa-close" ></i> Select Image Only...!</h4>';
    } else {
            $msg = addimage( $image, $imagename, $imagealt,  $status,  $ip, $thispageid,$getid);
        }
    
}else {
       
    }

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Image Mgmt
            <small><?php
if ($_REQUEST['aiid'] != '') {
    echo 'Edit';
} else {
    echo 'Add New';
}
?> Image Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Other(s)</a></li>
            <li><a href="#">Image Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['aiid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Image Mgmt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                if ($_REQUEST['aiid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Image Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Image Mgmt
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                
                               
                               
                            </div>
                            <br/>
                            <div class="row">
                                 <div class="col-md-6">
                                    <label>Image Alt <span style="color:#FF0000;">*</span></span></label>                                  
                                    <input type="text" name="imagealt"   pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed." id="imagealtid"  class="form-control" value="<?php echo getimage('imagealt', $_REQUEST['aiid']); ?>"  required/> 
                                </div>
                                <div class="col-md-6">
                                    <label>Image Name <span style="color:#FF0000;">*</span></label>                                  
                                    <input type="text" name="imagename" id="imagenameid"  pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed." class="form-control" value="<?php echo getimage('imagename', $_REQUEST['aiid']); ?>" required />
                                </div> 
                               
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image </label>
                                    <input type="file" name="image" id="image" onchange="imgchktore(this.value)" />
                                </div>
                                <?php if (getimage('image', $_REQUEST['aiid']) != '') { ?>
                                    <div class="col-md-6" id="delimage">
                                        <img src="<?php echo $fsitename; ?>images/imageup/<?php echo getimage('image', $_REQUEST['aiid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getimage('image', $_REQUEST['aiid']); ?>', '<?php echo $_REQUEST['aiid']; ?>', 'imageup', '../../../images/imageup/', 'image', 'aiid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <br />

                           
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (getimage('status', $_REQUEST['aiid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getimage('status', $_REQUEST['aiid']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>

                                    </select>
                                </div>
                                <div id="txtHint1"><b></b></div>
                            </div> 
                        </div>
                    </div>
                    
                </div>
                <div class="box-footer">
                    <div class="row">
                         <a href="<?php echo $sitename;?>others/viewimage.htm"  class="btn btn-success" style="font-weight:bold; text-decoration:none; ">View Image</a> 
                        <div class="col-md-6"><!--validatePassword();-->
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                        if ($_REQUEST['aiid'] != '') {
                                            echo 'UPDATE';
                                        } else {
                                            echo 'SAVE';
                                        }
                                        ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>