<?php
$menu = "3,2,2,35";
$thispageid=35;
$ze=35;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');

//$_SESSION['additemid'] = $_REQUEST['ledgergroupid'];
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delledgergroup($chk);
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
            if (confirm("Please confirm you want to Delete this?"))
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
    #normalexamples tbody tr td:nth-child(1) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ledger Group
           <!-- <small>Manage all Item </small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-file-o"></i>Accounts</a></li>
            <li class="active">Ledger Group </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <!--<h3 class="box-title"><a href="<?php echo $sitename; ?>accounts/addledger.htm">Add Ledger</a></h3>-->
            </div><!-- /.box-header -->
            <div class="box-body">
         
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped"  style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="5%">S.id</th>  
                                    <th width="65%">Ledger Group Name</th> 
                                </tr>
                            </thead>
                            
                            <?php
                            $depart = pFETCH("SELECT * FROM `ledger_group` WHERE `ledgergroupid`!=? ORDER BY `displayorder` DESC",'');
                            $ndepart = $depart->rowCount();
                            if ($ndepart > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    /*$i = '1';
                                    while ($fdepart = $depart->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $i; ?></td>  
                                            <td><?php echo stripslashes($fdepart['ledgergroupname']); ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }*/
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">&nbsp;</th>
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
        window.location.href = '<?php echo $sitename; ?>accounts/' + a + '/editledger';
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
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.htm?types=ledgergrouptable"
    });
</script>
