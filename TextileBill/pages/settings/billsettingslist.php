<?php
//$menu = "2,1,1,16";
$thispageid = 16;
$datatable = 1;
include ('../../config/config.inc.php');
include ('../../require/header.php');

$_SESSION['uom_id'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = deluom($chk);
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
            if (confirm("Please confirm you want to Delete this Billing list(s)"))
            {
                return true;
            } else
            {
                return false;
            }
        } else if (validcheck(name) == false)
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
    #billtableex tbody tr td:nth-child(1),tbody tr td:nth-child(3), tbody tr td:nth-child(4),tbody tr td:nth-child(5),tbody tr td:nth-child(6) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bill Settings
            <small>List of Bill Settings</small>
        </h1>
        <ol class="breadcrumb">
           <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-cogs"></i> Settings</a></li>
            <li class="active">Bill Settings</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <div id="resetr">
                    
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="billtableex" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:55%">Type</th>                                   
                                    <th style="width:15%">Prefix</th>                                   
                                    <th style="width:10%">Current Value</th>                                   
                                    <th style="width:10%">Reset</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>                                  
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                   
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
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/editbill.htm';
    }
</script>
<script type="text/javascript">
  function reset(a)  {
     $.ajax({
         type: "POST",
         data:{reset_id:a},
         url: "<?php echo $sitename; ?>config/functions_ajax.php", 
         success: function(data){
            $("#resetr").html(data);
        }
    });
  }
</script>    
<?php
include ('../../require/footer.php');
?>
<script type="text/javascript">
    $('#billtableex').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=billtable"
    });
</script>
