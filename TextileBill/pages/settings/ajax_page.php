<?php
include ('../../config/config.inc.php');

if ($_REQUEST['pid']) {
    ?>
    <div class="col-md-6">
        <label>SubCategory Name <span style="color:#FF0000;"></span></label>    
        <select name="sid" class="form-control" >
            <option value="<?php ?>">Select Subcategory</option>
            <?php
            $cata = $_REQUEST['pid'];
            foreach ($cata as $c) {
                $s = $db->prepare("SELECT * FROM `subcategory` WHERE `status`= ? AND FIND_IN_SET(?,`cid`)");
                $s->execute(array('1', $c));

                while ($cate = $s->fetch()) {
                    ?>
                    <option value="<?php echo $cate['sid']; ?>"><?php echo $cate['subcategory']; ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <?php
}

//attribute
//products pages start here


if ($_REQUEST['add'] != '') {
    $ids = rand(3, 6) . time();
    ?>
    <div class="row" id="<?php echo $ids ?>" style="margin-bottom: 10px">
        <div class="col-md-4">
            <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
            <select name="cid[]" class="form-control"  onchange="getsubcategoryp(this.value,<?php echo $ids ?>)"  required>
                <option value="">Select Category</option>
                <?php
                $s = $db->prepare("SELECT * FROM `category` WHERE `status`= ? ");
                $s->execute(array('1'));
                while ($cate = $s->fetch()) {
                    ?>
                    <option value="<?php echo $cate['cid']; ?>" <?php
                    if ($cate['cid'] == $catedid) {
                        echo 'selected';
                    }
                    ?>
                            ><?php echo $cate['category']; ?></option>
                        <?php } ?>
            </select>
        </div>
        <div id="getsub">
            <div class="col-md-4" id='sid<?php echo $ids ?>'>
                <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
                <select name="sid[]"  class="form-control" onchange="getinnercategoryp(this.value, '<?php echo $ids ?>')" >
                    <option value="">Select Subcategory</option>
                    <?php
                    $s = $db->prepare("SELECT * FROM `subcategory` WHERE `status`= ? ");
                    $s->execute(array('1'));
                    while ($cate = $s->fetch()) {
                        ?>
                        <option value="<?php echo $cate['sid']; ?>" <?php
                        if ($cate['sid'] == $subcaeteded[$nn]) {
                            echo 'selected';
                        }
                        ?>><?php echo $cate['subcategory']; ?></option>
                            <?php } ?>
                </select>
            </div> 
        </div>
        <div id="getsub1">
            <div class="col-md-3" id="nid<?php echo $ids ?>">
                <label>Inner Category Name <span style="color:#FF0000;"></span></label>                                  
                <select name="nid[]"  class="form-control">
                    <option value="">Select Category</option>
                    <?php
                    $s = $db->prepare("SELECT * FROM `innercategory` WHERE `subcategory`= ?  AND `status`= ? ");
                    $s->execute(array($subcaeteded[$nn], '1'));

                    while ($cate = $s->fetch()) {
                        ?>
                        <option value="<?php echo $cate['innerid']; ?>" <?php
                        if ($cate['innerid'] == $innercaeteded[$nn]) {
                            echo 'selected';
                        }
                        ?>
                                ><?php echo $cate['innername']; ?></option>
                            <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-1">
            <br />
            <span> <i class="fa fa-trash fa-2x" style="margin-top: 6px;color:#ff0000" onclick="removethis(<?php echo $ids ?>, $(this))" ></i></span>
        </div>
    </div>
    <?php
}

if ($_REQUEST['subs'] != '') {
    ?>
    <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
    <select name="sid"  class="form-control" onchange="getinnercategoryp(this.value, '<?php echo $_REQUEST['idss'] ?>')"  >
        <option value="">Select </option>
        <?php
        $s = $db->prepare("SELECT * FROM `subcategory` WHERE `status`= ? AND FIND_IN_SET(?,`cid`)");
        $s->execute(array('1', $_REQUEST['subs']));
        while ($cate = $s->fetch()) {
            ?>
            <option value="<?php echo $cate['sid']; ?>" <?php
            if ($cate['sid'] == $subcaeteded[$nn]) {
                echo 'selected';
            }
            ?>><?php echo $cate['subcategory']; ?></option>
                <?php } ?>

    </select>
    <?php
}

if ($_REQUEST['inns'] != '') {
    ?>
    <label>Inner Category Name  <span style="color:#FF0000;"></span> </label>                                  
    <select name="nid"  class="form-control">
        <option value="">Select </option>
        <?php
        $s = $db->prepare("SELECT * FROM `innercategory` WHERE `subcategory`= ? AND `status`= ? ");
        $s->execute(array($_REQUEST['inns'], '1'));
        while ($cate = $s->fetch()) {
            ?>
            <option value="<?php echo $cate['innerid']; ?>" <?php
            if ($cate['innerid'] == $innercaeteded[$nn]) {
                echo 'selected';
            }
            ?>><?php echo $cate['innername']; ?></option>
                <?php } ?>
    </select>
    <?php
}
?>
 