<?php
$menu = "4,4,13";
if (isset($_REQUEST['id'])) {
    $thispageeditid = 9;
} else {
    $thispageid = 9;
}
include ('../../config/config.inc.php');

$dynamic = '1';
$editor = '1';
include ('../../require/header.php');
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);

    if ($oldback == '1') {
        /* csv file	 */
        $time = time();
        $date = date('M Y,d');
        $fileName = '../../../images/productcsv/' . 'myreport_' . $date . '-' . $time . '.csv';
        $data = '';
        $catlist = $db->prepare("SELECT * FROM `product` WHERE `status`= ?  ORDER BY `order` ASC");
        $catlist->execute(array('1'));
        $data .= "cid, sid, alid, brand, innerid, item_code, productname, assitor, tamilproductname, attribute_group, link, videolink, sku, availability, total_Availability,price, sprice, metatitle, metakeyword, tags, stock, sortdescription, furtureyn, showinhp, deal, new, recommend, offers, image, description, state, cod_charge, metadescription, paymentinfo, status, order, date, weight, visit_count, isbn\n";
        while ($rows = $catlist->fetch(PDO::FETCH_ASSOC)) {
            if ($rows['status'] == '1') {
                $sts = "Active";
            } else {
                $sts = "Deactive";
            }
            $data .= $rows['cid'] . "," . $rows['sid'] . "," . $rows['alid']. "," . $rows['brand']. "," . $rows['innerid']. "," . $rows['item_code']."," . $rows['productname']. "," . $rows['assitor']. "," . $rows['tamilproductname']. "," . $rows['attribute_group']. "," . $rows['link']. "," . $rows['videolink']. "," . $rows['sku']. "," . $rows['availability']. "," . $rows['total_Availability']. "," . $rows['price']. "," . $rows['sprice']. "," . $rows['metatitle']. "," . $rows['metakeyword']. "," . $rows['tags']. "," . $rows['stock']. "," . $rows['sortdescription']. "," . $rows['furtureyn']. "," . $rows['showinhp']. "," . $rows['deal']. "," . $rows['new']. "," . $rows['recommend']. "," . $rows['offers']. "," . $rows['image']. "," . $rows['description']. "," . $rows['state']. "," . $rows['cod_charge']. "," . $rows['metadescription']. "," . $rows['paymentinfo']. "," . $rows['status']. "," . $rows['order']. "," . $rows['date']. "," . $rows['weight']. "," . $rows['visit_count']. "," . $rows['isbn']. "\n";
        }

        chmod($fileName, 0777);
        file_put_contents($fileName, $data);
        /* csv file	 */
    }

    $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = changerate($cid, $sid, $nid, $brand, $changetype, $valuetype, $value, $oldback, $fileName);
}
?>
<style>
    .fa
    {
        cursor:pointer;
    }
    .new_m
    {

        margin-bottom:10px;
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
<script>
    function getsubcategoryp(a, b)
    {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/settings/ajax_page.php",
            data: {subs: a, idss: b},
            success: function (data) {
                $("#sid" + b).html(data);
            }
        });
    }
    function getinnercategoryp(a, b)
    {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/settings/ajax_page.php",
            data: {inns: a, idss: b},
            success: function (data) {
                $("#nid" + b).html(data);
            }
        });
    }

    function additem()
    {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/settings/ajax_page.php",
            async: false,
            data: {add: 1},
            success: function (data) {
                $("#adddetails").append(data);
            }
        });
    }


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product Mgmt
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Product Details </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Dynamic Pages</a></li>
            <li><a href="<?php echo $sitename; ?>products/product.htm"> Product Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Product Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Product Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php
                    echo $msg;
                    if (isset($_REQUEST['suc'])) {
                        echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
                    }
                    ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Product Mgmt 
                        </div>
                        <div class="panel-body">  
                            <div class="row">
                                <div class="col-md-12"  id="adddetails">
                                    <?php
                                    $subcaeteded = explode(',', getproduct('sid', $_REQUEST['id']));
                                    $innercaeteded = explode(',', getproduct('innerid', $_REQUEST['id']));
                                    $caeteded = explode(',', getproduct('cid', $_REQUEST['id']));
                                    if ($_REQUEST['id'] != '') {
                                        $ss = 0;
                                        foreach ($caeteded as $catedid) {
                                            $idss = rand(3, 6) . time();
                                            ?>
                                            <div class="row" id="<?php echo $idss ?>" style="margin-bottom: 10px">
                                                <div class="col-md-4">
                                                    <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
                                                    <select name="cid" class="form-control" required onchange="getsubcategoryp(this.value, '<?php echo $idss ?>')">
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        $getmanuf = $db->prepare("SELECT * FROM `category`");
                                                        $getmanuf->execute(array());
                                                        $getmanuf1 = $getmanuf->rowCount();
                                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?php echo $fdepart['cid']; ?>"
                                                            <?php
                                                            if ($fdepart['cid'] == $catedid) {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?>><?php echo $fdepart['category']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4"  id='sid<?php echo $idss ?>' >
                                                    <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
                                                    <select name="sid" class="form-control" onchange="getinnercategoryp(this.value, '<?php echo $idss ?>')"  >
                                                        <option value="">Select Subcategory</option>
                                                        <?php
                                                        $s = $db->prepare("SELECT * FROM `subcategory` WHERE FIND_IN_SET(?,`cid`) AND `status`= ? ");
                                                        $s->execute(array($catedid, '1'));
                                                        while ($cate = $s->fetch()) {
                                                            ?>
                                                            <option value="<?php echo $cate['sid']; ?>" <?php
                                                            if ($cate['sid'] == $subcaeteded[$ss]) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?php echo $cate['subcategory']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div> 
                                                <div class="col-md-4" id="nid<?php echo $idss ?>"  >
                                                    <label>Inner Category Name <span style="color:#FF0000;"></span></label>                                  
                                                    <select name="nid" class="form-control">
                                                        <option value="">Select Inner Category</option>
                                                        <?php
                                                        $s = $db->prepare("SELECT * FROM `innercategory` WHERE FIND_IN_SET(?,`subcategory`) AND `status`= ? ");
                                                        $s->execute(array($subcaeteded[$ss], '1'));
                                                        while ($cate = $s->fetch()) {
                                                            ?>
                                                            <option value="<?php echo $cate['innerid']; ?>" <?php
                                                            if ($cate['innerid'] == $innercaeteded[$ss]) {
                                                                echo 'selected';
                                                            }
                                                            ?>
                                                                    ><?php echo $cate['innername']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <?php
                                            $ss++;
                                        }
                                    } else {

                                        $idss = rand(3, 6) . time();
                                        ?>

                                        <div class="row" id="<?php echo $ids ?>" style="margin-bottom: 10px">
                                            <div class="col-md-4">
                                                <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
                                                <select name="cid" class="form-control" required onchange="getsubcategoryp(this.value,<?php echo $idss ?>)" >
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    $getmanuf = $db->prepare("SELECT * FROM `category`");
                                                    $getmanuf->execute();
                                                    while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?php echo $fdepart['cid']; ?>"
                                                        <?php
                                                        if ($fdepart['cid'] == getproduct('cid', $_REQUEST['pid'])) {
                                                            echo 'selected="selected"';
                                                        }
                                                        ?>><?php echo $fdepart['category']; ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4"   id='sid<?php echo $idss ?>' >
                                                <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
                                                <select name="sid"  class="form-control" onchange="getinnercategoryp(this.value,<?php echo $idss ?>)"  >
                                                    <option value="">Select Subcategory</option>

                                                </select>
                                            </div> 

                                            <div class="col-md-4" id="nid<?php echo $idss ?>">
                                                <label>Inner Category Name  <span style="color:#FF0000;"></span> </label>                                  
                                                <select name="nid"  class="form-control">
                                                    <option value="">Select Inner-Category</option>
                                                    <?php
                                                    $s = $db->prepare("SELECT * FROM `innercategory` WHERE `subcategory`= ?  AND `status`= ? ");
                                                    $s->execute(array($subcaeteded[$ss], '1'));

                                                    while ($cate = $s->fetch()) {
                                                        ?>
                                                        <option value="<?php echo $cate['innerid']; ?>" <?php
                                                        if ($cate['innerid'] == $innercaeteded[$ss]) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo $cate['innername']; ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>

                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>


                            <br/>
                            <div class="row">

                                <div class="col-md-4">
                                    <label>Brand </label>
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select Brand</option>
                                        <?php
                                        $getmanuf = $db->prepare("SELECT * FROM `brand` WHERE `status`=?");
                                        $getmanuf->execute(array('1'));
                                        $getmanuf1 = $getmanuf->rowCount();

                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $fdepart['brid']; ?>"
                                            <?php
                                            if ($fdepart['brid'] == getproduct('brand', $_REQUEST['id'])) {
                                                echo 'selected="selected"';
                                            }
                                            ?> > <?php echo $fdepart['bname']; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Change Type<span style="color:#FF0000;"> </span></label>
                                    <br/>
                                    <label><input type="radio"   name="changetype"  value='1'/> Increase</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label> <input type="radio"  name="changetype"  value='2'/> Decrease</label>
                                </div>

                                <div class="col-md-4">
                                    <label>Value Type</label>
                                    <br/>
                                    <label><input type="radio"   name="valuetype"  value='1'/> Percentage</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label> <input type="radio"  name="valuetype"  value='2'/> Amount</label>

                                </div>
                            </div>

                            <div class="clearfix"> <br/> </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Value</label>
                                    <input type="number" class="form-control" placeholder="Enter The Value" name="value" id="value" />
                                </div>

                                <div class="col-md-4">
                                    <label style="font-size: 20px;" ><input type="checkbox"  name="oldback" value='1'/>&nbsp;&nbsp;&nbsp;Get Old Back Up</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?php echo $sitename; ?>products/product.htm">Back to Listings page</a>
                            </div>
                            <div class="col-md-6"><!--validatePassword();-->
                                <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                    if ($_REQUEST['id'] != '') {
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
            </div>

        </form>
</div>
<!-- /.box -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>