<?php
$thispageid = 25;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable='1';
include ('../../require/header.php');

$_SESSION['currency_id'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delcurrency($chk);
}
if (isset($_POST['saves'])) {
    $res = update_currency_rates();
   
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
            if (confirm("Please confirm you want to Delete this Currency(s)"))
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
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(7), tbody tr td:nth-child(4),tbody tr td:nth-child(5),tbody tr td:nth-child(6) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Currency
            <small>List of Currencies</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-gears"></i>Setting(s)</a></li>           
            <li class="active"><i class="fa fa-money"></i>&nbsp;&nbsp;Currency </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>settings/addcurrency.htm">Add New Currency</a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:35%">Currency Name</th>
				    <th style="width:20%">Currency Code</th>
                                    <th style="width:10%">Order</th>
                                    <th style="width:10%">Status</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                                </thead>
                            
                                
                                                              <tfoot>

                                    <tr>
                                        <th colspan="6">&nbsp;</th>
                                        <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                    </tr>
                                </tfoot>
                           
                        </table>
                    </div>
                </form>
                
            </div><!-- /.box-body -->
            
        </div><!-- /.box -->
        <div class="panel panel-info">
                    
                <div class="col-md-12" >
                    <?php echo $res; ?>
                    <form name="rates_form" method="post" enctype="multipart/form-data"> 
                        <div class="box box-info" style="margin: 0;">
                            <div class="box-header with-border">
                                <?php
                                $cur_rate = $db->prepare("SELECT * FROM `currency_rates` WHERE `name` != ? ");
                                $cur_rate->bindParam(1, $usd);
                                $usd = "USD";
                                $cur_rate->execute();
                                $nds = $cur_rate->fetch();
                                ?>
                                <h3 class="box-title" style="width: 100%;">Rates Management (1 AUD Values) <span style="float:right">Last updated time : <?php echo date("d-M-Y - h:i a (e T P)", strtotime($nds['date'])); ?></span></h3>
                            </div>

                            <div class="box-body" id="thisbox1">                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordred table-striped table-hover">
                                                <?php
                                                $cur_rate = $db->prepare("SELECT * FROM `currency_rates` WHERE `name` != ? ");
                                                $cur_rate->bindParam(1, $usd);
                                                $usd = "AUD";
                                                $cur_rate->execute();
                                                while ($frate = $cur_rate->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-right" width='35%'>
                                                            <?php echo $frate['name']; ?>
                                                        </td> 
                                                        <td class="text-center" width='1%'> : </td>
                                                        <td class="text-left" width='44%'>
                                                            <?php echo Currency($frate['name']) . ' ' . $frate['value']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <!-- /input-group --> 
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" name="saves" id="submit" class="btn btn-success btn-social" style="float:right;background-color: #C2185B;border-color: #C2185B;"><i class="fa fa-save" style="font-size: 14px;"></i> Update Latest Currency Rate Now</button>
                                </div>
                            </div>
                        </div></form>
                </div>
            </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<script type="text/javascript">
    function editthis(a)
    {
        var cuid = a;
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/editcurrency.htm';
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
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=currencytable"
    });
</script>


