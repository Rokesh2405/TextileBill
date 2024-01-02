<?php
$menu = "3,5,,39";
$thispageid = 39;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable='1';
include ('../../require/header.php');

$_SESSION['supplier_id'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delbank($chk);
}
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        for (var i = 0; i < chObj.length; i++) {
            if (chObj[i].checked) {
                result = true;
                break;
            }
        }
        if (!result) {
            return false;
        } else {
            return true;
        }
    }

    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Please confirm you want to Delete this Bank Detail(s)"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }

</script>
<script type="text/javascript">
    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
</script>
<style type="text/css">
    .row { margin:0;}
</style>
<style type="text/css">
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(5),tbody tr td:nth-child(6),tbody tr td:nth-child(7),tbody tr td:nth-child(8){
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Bank
            <small>List of Bank</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><i class="fa fa-money"></i> Accounts</li> 
            <li class="active"> Bank </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>accounts/addbank.htm">Add New Bank</a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%">Bank Name</th>
                                    <th style="width:25%">Branch Name</th>
                                    <th style="width:15%">IBAN Number</th>
                                    <th style="width:10%">Order</th>
                                    <th style="width:10%">Status</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>
                            <?php
                            $depart = pFETCH("SELECT * FROM `bank` WHERE `status`!=? ORDER BY `BankID` DESC",2);
                            $ndepart = $depart->rowCount();
                            if ($ndepart > 0) {
                                ?>
                                <tbody>
                                    <?php
                                  /*  $i = '1';
                                    while ($fdepart = $depart->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $i; ?></td>
                                            <td><?php echo $fdepart['Bank_Name']; ?></td>
                                            <td><?php echo $fdepart['Branch_Name']; ?></td>
                                            <td><?php echo  $fdepart['IFSC_Code']; ?></td>
                                            <td><?php echo  $fdepart['Order']; ?></td>
                                            <td align="center"><?php
                                                if ($fdepart['Status'] == '1') {
                                                    echo 'Active';
                                                } else {
                                                    echo 'Inactive';
                                                }
                                                ?></td>
                                            <td align="center"><i class="fa fa-edit" onclick="javascript:editthis('<?php echo $fdepart['BankID']; ?>');" style="cursor:pointer;"></i></td>
                                            <td align="center"><input type="checkbox" name="chk[]" id="chk[]" value="<?php echo $fdepart['BankID']; ?>" /></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    */
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7">&nbsp;</th>
                                        <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>bank/' + a + '/editbank.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>
<script type="text/javascript">
      $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.htm?types=banktable"
    });
</script>
