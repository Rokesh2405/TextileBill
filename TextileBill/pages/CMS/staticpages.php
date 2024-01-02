<?php
$menu = "44,44,45";
$thispageid = 45;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';

include ('../../require/header.php');

$_SESSION['static_pages'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delstaticpages($chk);
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
            if (confirm("Please confirm you want to Delete this Static Page(s)"))
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
    #normalexamples tbody tr td:nth-child(2) {
        text-align:left;
    }

</style>
<!--<script>
$(#normalexamples).css("text-align", "left");
</script>-->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Static Pages
            <small>Manage All Static Pages</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-pencil-square-o"></i>CMS</a></li>
            <li class="active">Static Pages</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
<!--                <h3 class="box-title"><a href="<?php // echo $sitename;     ?>master/addstaticpages.htm">Add New Static Pages</a></h3>-->

            </div><!-- box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:70%;">Page Title</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 25%;">Edit</th>
<!--                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>-->
                                </tr>
                            </thead>
                            <?php
                            $depart = $db->prepare("SELECT * FROM `static_pages`");
                            $depart->execute(array());
                            
                            
                            
                            //$depart = DB("SELECT * FROM `banner`");
                            
                            $depart = $db->prepare("SELECT * FROM `static_pages` ");
                            $depart->execute();
                            $ndepart=$depart->rowCount();
                            if ($ndepart > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    $i = '1';
                                    while ($fdepart=$depart->fetch()) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $i; ?></td>
                                            <td><?php echo $fdepart['title']; ?></td>

                                            <td align="center"><i class="fa fa-edit" onclick="javascript:editthis('<?php echo $fdepart['stid']; ?>');" style="cursor:pointer;"> Edit</i></td>
                                            <!--<td align="center"><input type="checkbox" name="chk[]" id="chk[]" value="<?php echo $fdepart['stid']; ?>" /></td>-->
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                   <!-- <tr>
                                        <th colspan="3">&nbsp;</th>
                                        <th align="center"><button type="submit" class="btn btn-danger" name="delete" id="delete" style="width:100%;" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                    </tr>-->
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
        window.location.href = '<?php echo $sitename; ?>CMS/' + a + '/editstaticpages.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>
