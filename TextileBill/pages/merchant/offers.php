<?php
$menu = "8,11,11";
$thispageid = 22;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable='1';
include ('../../require/header.php');
print_r($_REQUEST);
$_SESSION['driver'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delprovider($chk);
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
            if (confirm("Please confirm you want to Delete this Provide(s)"))
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
    #normalexamples tbody tr td:nth-child(1)/*, tbody tr td:nth-child(4),tbody tr td:nth-child(5),tbody tr td:nth-child(6),tbody tr td:nth-child(7),tbody tr td:nth-child(8)*/ {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Offers
            <small>List of Offer(s)</small>
        </h1>
        <ol class="breadcrumb">
            
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Offers Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>master/addprovider.htm">Add New Provider</a></h3>
            </div> --><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                   <th style="width:10%">Offerid</th>
                                     <th style="width:10%">Offer Name</th>
                                      <th style="width:10%">Discount</th>
                                      <th style="width:10%">Valid From Date</th>
                                      <th style="width:10%">Valid To Date</th>
                                      <th style="width:10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                $b = '1';
                                
                                 $ord = $db->prepare("SELECT * FROM `offerdetails` where `merchantid`='".$_SESSION['merchant']."' ");
                                $ord->execute(array());
                                 $bcount = $ord->rowcount();
                                 if($bcount>0) {
                                while ($contributelist = $ord->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                   <tr>
                                    <td><?php echo $b; ?></td>
                                    <td><?php echo $contributelist['offerid']; ?></td>
                                    <td><?php echo $contributelist['offername']; ?></td>
                                    <td><?php echo $contributelist['discount']; ?> %</td>
                                     <td><?php echo date('d-m-Y',strtotime($contributelist['valid_fromdate'])); ?></td>
                                      <td><?php echo date('d-m-Y',strtotime($contributelist['valid_todate'])); ?></td>
                                      <td><?php if($contributelist['status']=='1') { echo "Active"; } else { echo "Inactive"; } ?></td>
                                </tr>
                                    <?php
                                    $b++;
                                } } else {
                                ?>
                                <tr>
                                <td colspan="6" align="center">No Records Found</td>    
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">&nbsp;</th>
                                   <!--  <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th> -->
                                </tr>
                            </tfoot>
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
        window.location.href = '<?php echo $sitename; ?>master/' + a + '/editprovider.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>  
<!-- <script type="text/javascript">

      $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
	    "ordering":false,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=offerstable"
    });
</script>  -->