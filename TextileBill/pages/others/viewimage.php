<?php
$menu = '49,49,50';
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');

if ($_REQUEST['delimag'] != '') {
    $sel1 =$db->prpare("SELECT * FROM `imageup` WHERE `aiid`=?");
    $sel1->execute(array($_REQUEST['delimag']));
    $sel=$sel1->fetch();
    unlink("../../../images/imageup/".$sel['image']);
    
    $get =$db->prepare("DELETE FROM  `imageup` WHERE `aiid` =? ");
        $get->execute(array(trim($_REQUEST['delimag'])));
    
    //DB("DELETE FROM `addimages` WHERE `aid`='".$sel['aid']."'");
    
    echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted, Image will be deleted in few seconds</h4></div>';
    
    echo '<meta http-equiv="refresh" content="3;url=' . $sitename . 'master/viewimage.htm/' . '">';
}
?>
<script>
    function checkdelete(name)
    {
        if (confirm("Please confirm you want to Delete this Image"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Images
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $sitename; ?>">
                    <i class="fa fa-dashboard">
                    </i>Dashboard
                </a>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Other(s)</a></li>
            <li>
                <a href="<?php echo $sitename; ?>others/addimage.htm">
                    Images Mgmt
                </a>
            </li>
            <li class="active">
                <a href="#">
                    View Images
                </a>
            </li>

        </ol>

    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data" autocomplete="off" >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">View Images</h3>

                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <span id="delmaster"></span>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">View Images</div>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <?php
                                $img =$db->prepare("SELECT * FROM `imageup`");
                                $img->execute(array());
                                while ($fetchimg =$img->fetch()) {
                                    ?>
                                    <div class="col-md-3">
                                        <input  type="hidden" id="id" name="id" value="<?php echo $fetchimg['aiid']; ?>">
                                        <span style="font-size: 25px;"><?php echo $fetchimg['image_alt']; ?></span><i class="fa fa-trash"  onclick="javascript:delimag('<?php echo $fetchimg['aiid']; ?>');" style="cursor:pointer;margin-left: 120px;"></i>  
    <!--                                    <button type="submit" id="del" name="del" ><i class="fa fa-trash-o" style="color:red;"  onclick="return checkdelete('<?php echo $fetchimg['aid']; ?>');"></i></button>-->


                                        <img src="<?php echo $fsitename; ?>images/imageup/<?php echo $fetchimg['image']; ?>" class="img-responsive"><br/>
                                        <b>Image URL </b>: 
                                        <textarea name="img" id="img" style="width:100%; border:none; background:none;" readonly="readonly"><?php echo $fsitename . '' . 'images/imageup/' . '' . $fetchimg['image']; ?></textarea>
                                    </div>
                                <?php } ?>
                            </div>

                            <br />


                        </div>

                    </div>

                </div><!-- /.box-body -->
                 <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>others/addimage.htm">Back to Image Upload page</a>
                        </div>
                      
                    </div>
                </div>
        </form> 
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>

<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>master/' + a + '/editimages.htm';
    }
</script>