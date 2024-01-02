<?php
if (isset($_REQUEST['hid'])) {
    $thispageeditid = 12;
} else {
    $thispageaddid = 12;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';

include ('../../require/header.php');
$_SESSION['sid'] = '';
error_reporting(1);

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
   
    $getid = $_REQUEST['hbanid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $ext1='';
    $ext2='';
    $ext3='';
    $ext4='';

    if ($imagename1 != '') {
        $image1c = $imagename1;
    } else {
        $image1c = time();
    }
    if ($imagename2 != '') {
        $image2c = $imagename2;
    } else {
        $image2c = time();
    }
    if ($imagename3 != '') {
        $image3c = $imagename3;
    } else {
        $image3c = time();
    }
	if ($imagename4 != '') {
        $image4c = $imagename4;
    } else {
        $image4c = time();
    }
	
    if (($imagename1!= $imagename2) && ($imagename1 != $imagename3) && ($imagename2 != $imagename3) && ($imagename1 != $imagename4) && ($imagename2 != $imagename4) && ($imagename3 != $imagename4)) {

        $pimage1 = gethomebanner('image1', '1');
        $pimage2 = gethomebanner('image2', '1');
        $pimage3 = gethomebanner('image3', '1');
	$pimage4 = gethomebanner('image4', '1');

        $imag = strtolower($_FILES["image1"]["name"]);
        if ($imag) {
            if ($pimage1 != '') {
                unlink("../../../images/homebanners/" . $pimage1);
            }
            $main = $_FILES['image1']['name'];
            $tmp = $_FILES['image1']['tmp_name'];
            $size = $_FILES['image1']['size'];
            $width = 1920;
            $height = 150;
            $extension = getExtension($main);
            $extension = strtolower($extension);
            if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
                $m = $image1c;
                $imagev = $m . "." . $extension;
                $thumppath = "../../../images/homebanners/";
                move_uploaded_file($tmp, $thumppath . $imagev);
            } else {
                $ext1 = '1';
            }
            $image1 = $imagev;
        } else {
            $image1 = $pimage1;
        }
        
        $imag2 = strtolower($_FILES["image2"]["name"]);
        if ($imag2) {
            if ($pimage2 != '') {
                unlink("../../../images/homebanners/" . $pimage2);
            }
            $main = $_FILES['image2']['name'];
            $tmp = $_FILES['image2']['tmp_name'];
            $size = $_FILES['image2']['size'];
            $width = 270;
            $height = 207;
            $extension = getExtension($main);
            $extension = strtolower($extension);
            if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
                $m = $image2c;
                $imagev = $m . "." . $extension;
                $thumppath = "../../../images/homebanners/";
                move_uploaded_file($tmp, $thumppath . $imagev);
            } else {
                $ext2 = '1';
            }
            $image2 = $imagev;
        } else {
            $image2 = $pimage2;
        }
        
        $imag3 = strtolower($_FILES["image3"]["name"]);
        if ($imag3) {
            if ($pimage3 != '') {
                unlink("../../../images/homebanners/" . $pimage3);
            }
            $main = $_FILES['image3']['name'];
            $tmp = $_FILES['image3']['tmp_name'];
            $size = $_FILES['image3']['size'];
            $width = 570;
            $height = 207;
            $extension = getExtension($main);
            $extension = strtolower($extension);
            if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
                $m = $image3c;
                $imagev = $m . "." . $extension;
                $thumppath = "../../../images/homebanners/";
                move_uploaded_file($tmp, $thumppath . $imagev);
            } else {
                $ext3 = '1';
            }
            $image3 = $imagev;
        } else {
            $image3 = $pimage3;
        }
		
	
	  
	  
		  $imag4 = strtolower($_FILES["image4"]["name"]);
        if ($imag4) {
            if ($pimage4 != '') {
                unlink("../../../images/homebanners/" . $pimage4);
            }
            $main = $_FILES['image4']['name'];
            $tmp = $_FILES['image4']['tmp_name'];
            $size = $_FILES['image4']['size'];
            $width = 270;
            $height = 207;
            $extension = getExtension($main);
            $extension = strtolower($extension);
            if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
                $m = $image4c;
                $imagev = $m . "." . $extension;
                $thumppath = "../../../images/homebanners/";
                move_uploaded_file($tmp, $thumppath . $imagev);
            } else {
                $ext4 = '1';
            }
            $image4 = $imagev;
        } else {
            $image4 = $pimage4;
        }
       
        if (($ext1 == '1') || ($ext2 == '1') || ($ext3 == '1') || ($ext4 == '1')) {
            $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4><i class="icon fa fa-cross"></i> Wrong File Format...! Please Upload jpg|png|gif Formats Only</h4></div>';
        } else {
            $msg = addhomebanner($title1, $link1, $content1, $imagealt1, $imagename1, $image1, $title2, $link2, $content2, $imagealt2, $imagename2, $image2, $title3, $link3, $content3, $imagealt3, $imagename3, $image3, $title4, $link4, $content4, $imagealt4, $imagename4, $image4, $ip, $thispageid, $getid, $status1, $status2, $status3, $status4);
        }
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4><i class="icon fa fa-cross"></i>Imagename already Exist...!</h4></div>';
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Home Banner
            <small><?php
if ($_REQUEST['hbanid'] != '') {
    echo 'Edit';
} else {
    echo 'Add New';
}
?> Home Banner</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Settings</a></li>
            <li><a href="<?php echo $sitename; ?>settings/homebanners.htm">Home Banner </a></li>
            <li class="active"><?php
                if ($_REQUEST['hbanid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?>&nbsp;Home Banner</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                if ($_REQUEST['hbanid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Home Banner</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">Image 1</div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Title </label>
                                    <input class="form-control" placeholder="Enter the Title" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z ./-*()]{0,60}" name="title1" id="title1"  value="<?php echo stripslashes(gethomebanner('title1', $_REQUEST['hbanid'])); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Link </label>
                                    <input class="form-control" placeholder="Enter the Link" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z-.()_%/:]{0,255}" name="link1" id="link1"  value="<?php echo stripslashes(gethomebanner('link1', $_REQUEST['hbanid'])); ?>" />
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Content </label>
                                    <textarea name="content1" id="content1" class="form-control" placeholder="Enter the Content here"><?php echo stripslashes(gethomebanner('content1', $_REQUEST['hbanid'])); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt1" class="form-control" value="<?php echo stripslashes(gethomebanner('image_alt1', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagename1" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" value="<?php echo stripslashes(gethomebanner('image_name1', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 1920 * 150)</span></label>
                                        <input class="form-control spinner" <?php if (stripslashes(gethomebanner('image1', $_REQUEST['hbanid'])) == '') { ?> required="required" <?php } ?> name="image1" type="file"> 
                                    </div>
                                </div>
                                <?php if (stripslashes(gethomebanner('image1', $_REQUEST['hbanid'])) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage1">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/homebanners/<?php echo stripslashes(gethomebanner('image1', $_REQUEST['hbanid'])); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deletemultiimage('<?php echo gethomebanner('image1', '1'); ?>', '1', 'homebanners', '../../images/homebanners/', 'image1', 'hbid', 'delimage1');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status </label>
                                        <select name="status1" id="status1" class="form-control">
                                            <option value="0" <?php if(gethomebanner('status1',$_REQUEST['hbanid'])=='0'){ echo 'selected'; } ?>>Inactive</option>
                                            <option value="1" <?php if(gethomebanner('status1',$_REQUEST['hbanid'])=='1'){ echo 'selected'; } ?>>Active</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">Image 2</div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Title </label>
                                    <input class="form-control" placeholder="Enter the Title" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z ./-*()]{0,60}" name="title2" id="title2"  value="<?php echo stripslashes(gethomebanner('title2', $_REQUEST['hbanid'])); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Link </label>
                                    <input class="form-control" placeholder="Enter the Link" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z-.()_%/:]{0,255}" name="link2" id="link2"  value="<?php echo stripslashes(gethomebanner('link2', $_REQUEST['hbanid'])); ?>" />
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <label>Content </label>
                                    <textarea name="content2" id="content1" class="form-control" placeholder="Enter the Content here"><?php echo stripslashes(gethomebanner('content2', $_REQUEST['hbanid'])); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt2" class="form-control" value="<?php echo stripslashes(gethomebanner('image_alt2', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagename2" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" value="<?php echo stripslashes(gethomebanner('image_name2', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                            </div>
                            
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 270 * 207)</span></label>
                                        <input class="form-control spinner" <?php if (stripslashes(gethomebanner('image2', $_REQUEST['hbanid'])) == '') { ?> required="required" <?php } ?> name="image2" type="file"> 
                                    </div>
                                </div>
                                <?php if (stripslashes(gethomebanner('image2', $_REQUEST['hbanid'])) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage2">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/homebanners/<?php echo stripslashes(gethomebanner('image2', $_REQUEST['hbanid'])); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del2" onclick="javascript:deletemultiimage('<?php echo gethomebanner('image2', '1'); ?>', '1', 'homebanners', '../../images/homebanners/', 'image2', 'hbid', 'delimage2');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status </label>
                                        <select name="status2" id="status2" class="form-control">
                                            <option value="0" <?php if(gethomebanner('status2',$_REQUEST['hbanid'])=='0'){ echo 'selected'; } ?>>Inactive</option>
                                            <option value="1" <?php if(gethomebanner('status2',$_REQUEST['hbanid'])=='1'){ echo 'selected'; } ?>>Active</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">Image 3</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title </label>
                                    <input class="form-control" placeholder="Enter the Title" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z ./-*()]{0,60}" name="title3" id="title3"  value="<?php echo stripslashes(gethomebanner('title3', $_REQUEST['hbanid'])); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Link </label>
                                    <input class="form-control" placeholder="Enter the Link" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z-.()_%/:]{0,255}" name="link3" id="link3"  value="<?php echo stripslashes(gethomebanner('link3', $_REQUEST['hbanid'])); ?>" />
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Content </label>
                                    <textarea name="content3" id="content3" class="form-control" placeholder="Enter the Content here"><?php echo stripslashes(gethomebanner('content3', $_REQUEST['hbanid'])); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt3" class="form-control" value="<?php echo stripslashes(gethomebanner('image_alt3', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagename3" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" value="<?php echo stripslashes(gethomebanner('image_name3', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 570 * 207)</span></label>
                                        <input class="form-control spinner" <?php if (stripslashes(gethomebanner('image3', $_REQUEST['hbanid'])) == '') { ?> required="required" <?php } ?> name="image3" type="file"> 
                                    </div>
                                </div>
                                <?php if (stripslashes(gethomebanner('image3', $_REQUEST['hbanid'])) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage3">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/homebanners/<?php echo stripslashes(gethomebanner('image3', $_REQUEST['hbanid'])); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del3" onclick="javascript:deletemultiimage('<?php echo gethomebanner('image3', '1'); ?>', '1', 'homebanners', '../../images/homebanners/', 'image3', 'hbid', 'delimage3');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status3" id="status3" class="form-control">
                                            <option value="0" <?php if(gethomebanner('status3',$_REQUEST['hbanid'])=='0'){ echo 'selected'; } ?>>Inactive</option>
                                            <option value="1" <?php if(gethomebanner('status3',$_REQUEST['hbanid'])=='1'){ echo 'selected'; } ?>>Active</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
					<div class="panel panel-info">
                        <div class="panel-heading">Image 4</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title </label>
                                    <input class="form-control" placeholder="Enter the Title" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z ./-*()]{0,60}" name="title4" id="title4"  value="<?php echo stripslashes(gethomebanner('title4', $_REQUEST['hbanid'])); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Link </label>
                                    <input class="form-control" placeholder="Enter the Link" title="Special Characters are not allowed" type="text" pattern="[0-9 A-Z a-z-.()_%/:]{0,255}" name="link4" id="link4"  value="<?php echo stripslashes(gethomebanner('link4', $_REQUEST['hbanid'])); ?>" />
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Content </label>
                                    <textarea name="content4" id="content4" class="form-control" placeholder="Enter the Content here"><?php echo stripslashes(gethomebanner('content4', $_REQUEST['hbanid'])); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt4" class="form-control" value="<?php echo stripslashes(gethomebanner('image_alt4', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagename4" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" value="<?php echo stripslashes(gethomebanner('image_name4', $_REQUEST['hbanid'])); ?>" required />                     
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 270 * 207)</span></label>
                                        <input class="form-control spinner" <?php if (stripslashes(gethomebanner('image4', $_REQUEST['hbanid'])) == '') { ?> required="required" <?php } ?> name="image4" type="file"> 
                                    </div>
                                </div>
                                <?php if (stripslashes(gethomebanner('image4', $_REQUEST['hbanid'])) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage4">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/homebanners/<?php echo stripslashes(gethomebanner('image4', $_REQUEST['hbanid'])); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del4" onclick="javascript:deletemultiimage('<?php echo gethomebanner('image4', '1'); ?>', '1', 'homebanners', '../../images/homebanners/', 'image4', 'hbid', 'delimage4');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status4" id="status4" class="form-control">
                                            <option value="0" <?php if(gethomebanner('status4',$_REQUEST['hbanid'])=='0'){ echo 'selected'; } ?>>Inactive</option>
                                            <option value="1" <?php if(gethomebanner('status4',$_REQUEST['hbanid'])=='1'){ echo 'selected'; } ?>>Active</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>settings/general.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['hbanid'] != '') {
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