<?php
include ('../../config/config.inc.php');
if (($_REQUEST['supplier'] != '') && ($_REQUEST['findkeyid'] != '')) {
    $itemid = $_REQUEST['selectitem'];
    $isid = $_REQUEST['findkeyid'];
    if ($_REQUEST['supplier'] != 'ALL') {
        $display_name = getsupplier('Supplier_name', $_REQUEST['supplier']);
    }
    foreach ($itemid as $setid) {
        $key = $isid . $setid;
        $suppliersql = "AND Item_Id ='" . $setid . "'";
        $getitemvalue = $db->prepare("SELECT * FROM `item_master` WHERE `status`='1' " . $suppliersql);
        $getitemvalue->execute();
        $getval = $getitemvalue->fetch(PDO::FETCH_ASSOC);
        $getnewsuppid = str_replace(",", "#@#", $getval['supplier_id']);       
        ?>
        <tr valign = "top" id="datarow<?php echo $key; ?>">
            <td><input type="hidden" name="purchase_detailid[]" id="purchase_detailid<?php echo $key; ?>" value="<?php echo $isid; ?>" />
                <input type="text" class="form-control" style="border: 1px solid #f9f9f9;"  name="Item_name1[]" id="Item_name<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" data-id="<?php echo $key; ?>" value="<?php echo $getval['Item_Name']; ?>" readonly="readonly" />
                <input type="hidden" class="form-control" style="border: 1px solid #f9f9f9;"  name="Item_name[]" id="Item_name<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" data-id="<?php echo $key; ?>" value="<?php echo $getval['Item_Id']; ?>" readonly="readonly" /></td>
            <td> 
                <input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="batchnumber[]" id="batchnumber<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" placeholder="Batch Number" value="" /></td>

            <td><input type="number" style="border: 1px solid #f9f9f9;" class="form-control"  onkeyup="caltolqty(this.value,'<?php echo $key; ?>')"  placeholder="Qty" name="Qty[]" id="Qty<?php echo $key; ?>"  pattern="[0-9  .,:'()]{1,60}" data-id="<?php echo $key; ?>"  title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="1" /></td>

            <td><input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Pack_UOM1[]" id="Pack_UOM<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo getuom('Name', $getval['Package_UOM']); ?>" readonly="readonly" />
                <input type="hidden" class="form-control"  name="Pack_UOM[]" id="Pack_UOM1" required="required" value="<?php echo $getval['Package_UOM']; ?>"  /></td>
             
            <td><input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Pack_qty[]" id="Pack_qty<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $getval['Qty_Per_Package']; ?>" readonly="readonly" />
            <input type="hidden" class="form-control"  name="Pack_qty[]" id="Pack_qty1" required="required" value="<?php echo $getval['Qty_Per_Package']; ?>" /></td>
            

            <td><input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Item_UOM1[]" id="Item_UOM<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo getuom('Name', $getval['Unit_UOM']); ?>" readonly="readonly" />
                <input type="hidden" class="form-control"  name="Item_UOM[]" id="Item_UOM" required="required" value="<?php echo $getval['Unit_UOM']; ?>" /></td>

            <td> <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001" onkeyup="calpackqty(this.value,'<?php echo $key; ?>')" placeholder="Total Qty" name="Total_Qty[]" id="Total_Qty<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="" />   </td>


            <td><input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001"  placeholder="Pack Rate" name="Pack_Rate[]" onkeyup="calitemrate(this.value,'<?php echo $key; ?>')" id="Pack_Rate<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $getval['Purchase_Pack_Price']; ?>" /> </td>

            <td><input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control" step="0.0001" placeholder="Item Rate" name="Item_Rate[]" onkeyup="calpackrate(this.value,'<?php echo $key; ?>')" id="Item_Rate<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $getval['Purchase_Unit_Price']; ?>" /> </td>   
            
            <td><input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001"  placeholder="Sales Pack Rate" name="sPack_Rate[]" onkeyup="calsitemrate(this.value,'<?php echo $key; ?>')" id="sPack_Rate<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $getval['Purchase_Pack_Price']; ?>" /> </td>

            <td><input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control" step="0.0001" placeholder="Sales Item Rate" name="sItem_Rate[]" onkeyup="calspackrate(this.value,'<?php echo $key; ?>')" id="sItem_Rate<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $getval['Purchase_Unit_Price']; ?>" /> </td>   

            <td>
                <select style="border: 1px solid #f9f9f9;" name = "tax[]" required id="tax<?php echo $key; ?>" onchange="taxpertage(<?php echo $key; ?>)" class="form-control">
                    <option value="">Select Item</option>
                    <?php
                    $getitemvalue = $db->prepare("SELECT * FROM `tax` WHERE `status`='1'");
                    $getitemvalue->execute();
                    while ($getval45 = $getitemvalue->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?php echo $getval45['tid']; ?>#@#<?php echo $getval45['taxpercentage']; ?>" <?php if ($getval45['tid'] == $getval['Tax']) { echo 'selected="selected"'; } ?>><?php echo stripslashes($getval45['taxname']); ?></option>
        <?php } ?>
                </select>
                 
            </td>

            <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"  class="form-control"  name="Taxable_Amt[]" id="Taxable_Amt<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="" readonly="readonly" /></td>

            <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"   class="form-control"  name="Tax_Amt[]" id="Tax_Amt<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="" readonly="readonly" /></td>

            <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"   class="form-control"  name="Net_Amt[]" id="Net_Amt<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="" data-id="<?php echo $key; ?>"  readonly="readonly" /></td>

            <td valign="middle"><i class="btn btn-danger fa fa-trash"  style="width: 20px;padding: 6px 4px;" name="remove[]" id="remove<?php echo $key; ?>" onclick="remove(<?php echo $key; ?>)"></i></td>
        </tr> 

        <?php
    }
}
?>


