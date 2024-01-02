<script type="text/javascript">
    $(document).ready(function () {
        var id = 0;
        $("#addcharges").click(function () {
            id++;
            var row = $('#newcharges tr:last').clone(true);
            row.find("input:text,select").val("");
            row.attr({'id': id++,'required':'required'});
            row.appendTo('#newcharges');
            $(row).find('td:last').attr('align', 'center').html('<i class="fa fa-trash-o fa-2x removetdoc" style="color:red;cursor:pointer"></i>');
            row.show();
            $('.removetdoc').unbind('click');
            setval_amt_desc();
            return false;
        });


    });
    function setval_amt_desc() {
        $('select[name="others_name[]"]').change(function () {
            if ($(this).val() !== '') {
                var elem1 = $(this).parents('tr').find('td').find('input[name="others_amount[]"]');
                $(this).parents('tr').find('td').find('input[name="others_description[]"]').val(Other_Charges[$(this).val() || 0].desc);
                $(this).parents('tr').find('td').find('select[name="others_tax[]"]').val(Other_Charges[$(this).val() || 0].tax);
                getCurrency_value('<?php echo getcurrency_new('code', getprofile('currency')); ?>', Currencies[$('#icurrency').val() || <?php echo getprofile('currency'); ?>], Other_Charges[$(this).val() || 0].amount, elem1, 'val', cal_oc);
            } else {
                $(this).parents('tr').find('td').find('input[name="others_amount[]"]').val('');
                $(this).parents('tr').find('td').find('input[name="others_description[]"]').val('');
                $(this).parents('tr').find('td').find('select[name="others_tax[]"]').val('');
                $(this).parents('tr').find('td').find('input[name="others_taxable_amt[]"]').val('');
                $(this).parents('tr').find('td').find('input[name="others_tax_amt[]"]').val('');
                $(this).parents('tr').find('td').find('input[name="others_amount_total[]"]').val('');
                $('#oc').val('0.00');

                $('#ocdisplay').html('0.00');
            }
            //cal_oc();

        });



        $('select[name="others_tax[]"]').change(cal_oc);

        $('input[name="others_amount[]"]').keyup(cal_oc);
        cal_oc();

        $('.removetdoc').on("click", function () {
            if (confirm("Are you sure wanna delete?")) {
                if ($(this).data('del') == 'yes') {
                    window.location.href = "<?php echo $sitename; ?><?php echo $opage; ?>/<?php echo $opid; ?>/<?php echo $opageedit; ?>.htm?delo=" + $(this).data('id');
                }
                $(this).parents("tr").remove();
            }
            cal_oc();
        });
    }
    function cal_oc() {
        var vals = parseFloat(0);
        if ($('#taxtype').val() == '0') {
            $('select[name="others_tax[]"]').val('').prop('disabled', true);
        } else {
            $('select[name="others_tax[]"]').prop('disabled', false);
        }




        $('input[name="others_amount[]').each(function (e) {
            var cval = parseFloat($(this).val()) || parseFloat(0);
            $(this).parents('tr').find('td').find('input[name="others_amount_total[]"]').val(cval.toFixed(cd));
            var taxpercentage = $(this).parents('tr').find('td').find('select[name="others_tax[]"] option:selected').data('tax-value');            
            if ($('#taxtype').val() == '0') { 
                $(this).parents('tr').find('td').find('input[name="others_taxable_amt[]"]').val(cval.toFixed(cd));
                $(this).parents('tr').find('td').find('input[name="others_tax_amt[]"]').val('0.00');
            } else if ($('#taxtype').val() == '1') {
                var taxbamt = (cval / (100 + parseFloat(taxpercentage))) * 100;
                var taxamt = cval - taxbamt;
                $(this).parents('tr').find('td').find('input[name="others_taxable_amt[]"]').val(taxbamt.toFixed(cd));
                $(this).parents('tr').find('td').find('input[name="others_tax_amt[]"]').val(taxamt.toFixed(cd));
            } else {

                var taxbamt = cval;
                var taxamt = (cval * parseFloat(taxpercentage)) / 100;
                $(this).parents('tr').find('td').find('input[name="others_taxable_amt[]"]').val(taxbamt.toFixed(cd));
                $(this).parents('tr').find('td').find('input[name="others_tax_amt[]"]').val(taxamt.toFixed(cd));
                $(this).parents('tr').find('td').find('input[name="others_amount_total[]"]').val((taxamt + taxbamt).toFixed(cd));


            }
            vals += parseFloat($(this).parents('tr').find('td').find('input[name="others_taxable_amt[]"]').val()) || parseFloat(0);
            // $(this).val(cval.toFixed(2));
        });
        $('#oc').val(vals);
        $('#ocdisplay').html(vals.toFixed(cd));
        displaynettotal();
    }
    setval_amt_desc();
<?php
$ots = $db->prepare("SELECT * FROM `otherterms` WHERE `Status`=? AND `company_id`=?");
$ots->execute(array('1', $_SESSION['COMPANY_ID']));
if ($ots->rowCount() > 0) {
    ?>
        var Other_Charges = {
    <?php
    while ($fc = $ots->fetch()) {
        ?>

        <?php echo $fc['OTID']; ?>: {amount: '<?php echo number_format($fc['Amount'], getDigit('1','A'), '.', ''); ?>', desc: '<?php echo strip_tags(str_replace("\''", "\'\'", str_replace("\n", " ", stripslashes(trim($fc['Description']))))); ?>', tax: '<?php echo $fc['Tax'] ?>'},

    <?php } ?>
        }
<?php } ?>

</script>