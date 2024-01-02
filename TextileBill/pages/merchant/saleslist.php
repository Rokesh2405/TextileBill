<?php
$menu = "8,13,13";
$thispageid= 47;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
$franchisee='yes';
include ('../../require/header.php');

//$_SESSION['staticpages_id'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delcontactform($chk);
}
if (isset($_REQUEST['submit'])) {
    //print_r($_REQUEST);
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    $msgg = contactform($email);
    
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
            if (confirm("Please confirm you want to Delete this contactlist(s)"))
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
    #normalexamples tbody tr td:nth-child(6) ,tbody tr td:nth-child(7) {
       text-align:center;    
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sales Report
            <small>Manage All Sales Report</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Sales Report</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>"></a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%;">Date</th>
                                    <th style="width:20%;">Customer ID</th>
                                    
                                    <th data-sortable="false" style="padding-right:0; padding-left: 0; width: 10%;">&nbsp;&nbsp;View</th>
                                  
                                </tr>
                            </thead>
                            
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">&nbsp;</th>
                                       <!--  <th align="center"><button type="submit" class="btn btn-danger" name="delete" id="delete" style="width:100%;" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th> -->
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
        window.location.href = '<?php echo $sitename; ?>merchant/' + a + '/viewsales.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>
<script type="text/javascript">
  
$('#normalexamples').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "paging": true,                
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=salestable"
            });
        
</script>