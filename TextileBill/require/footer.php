<footer class="main-footer">
<?php
$logouturl=$sitename.'logout.php';
?>
    
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a>Thanvi Technologies</a>.</strong> All rights reserved.<br>
	<input type="hidden" id="logurl" value="<?php echo $logouturl; ?>">
	<span id="SecondsUntilExpire"></span>
</footer>

 <script>
var IDLE_TIMEOUT = 600; //seconds
var _idleSecondsTimer = null;
var _idleSecondsCounter = 0;

document.onclick = function() {
    _idleSecondsCounter = 0;
};

document.onmousemove = function() {
    _idleSecondsCounter = 0;
};

document.onkeypress = function() {
    _idleSecondsCounter = 0;
};

_idleSecondsTimer = window.setInterval(CheckIdleTime, 1000);

function CheckIdleTime() {
     _idleSecondsCounter++;
     var oPanel = document.getElementById("SecondsUntilExpire");
     if (oPanel)
         oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
    if (_idleSecondsCounter >= IDLE_TIMEOUT) {
        window.clearInterval(_idleSecondsTimer);
       // alert("Time expired!");
        document.location.href = document.getElementById("logurl").value;
    }
}
</script>

<?php if ($_SESSION['UID'] == '1') { ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Settings</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="<?php echo $sitename; ?>settings/1/editgeneral.htm">
                            <i class="menu-icon fa fa-gear bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">General Settings</h4>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $sitename; ?>settings/billsettingslist.htm">
                            <i class="menu-icon fa fa-gear bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Bill Settings</h4>
                            </div>
                        </a>
                    </li>
					<!--  <li>
                        <a href="<?php echo $sitename; ?>settings/1/editsendgrid.htm">
                            <i class="menu-icon fa fa-envelope bg-orange"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">SendGrid Mgmt</h4>
                            </div>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?php echo $sitename; ?>settings/socialmedia.htm">
                            <i class="menu-icon fa fa-share-square bg-blue"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Social Media</h4>
                            </div>
                        </a>
                    </li>
                   
				  <!--  	 <li>
                        <a href="<?php //echo $sitename; ?>settings/usermaster.htm">
                            <i class="menu-icon fa fa-users bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Users Mgmt</h4>
                            </div>
                        </a>
                    </li>
                 <li>
                        <a href="<?php echo $sitename; ?>settings/permission.htm">
                            <i class="menu-icon fa fa-key bg-orange"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Permission Group</h4>
                            </div>
                        </a>
                    </li> -->
<!--                    <li>
                        <a href="<?php echo $sitename; ?>settings/usermaster.htm">
                            <i class="menu-icon fa fa-users bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Users Mgmt</h4>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $sitename; ?>settings/permission.htm">
                            <i class="menu-icon fa fa-key bg-green"></i> 
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Permission Group</h4>
                            </div>
                        </a>
                    </li>
                     <li>
                        <a href="<?php echo $sitename; ?>settings/currency.htm">
                            <i class="menu-icon fa fa-money bg-green"></i> 
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Currency Mgmt</h4>
                            </div>
                        </a>
                    </li>
                   <li>
                        <a href="<?php echo $sitename; ?>settings/tax.htm">
                            <i class="menu-icon fa fa-money bg-yellow"></i> 
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Tax Mgmt</h4>
                            </div>
                        </a>
                    </li>-->
<!--                     <li>
                        <a href="<?php echo $sitename; ?>settings/emailtemplist.htm">
                            <i class="menu-icon fa fa-envelope-o bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Email Template(s)</h4>
                            </div>
                        </a>
                    </li><li>
                        <a href="<?php echo $sitename; ?>settings/printtemplist.htm">
                            <i class="menu-icon fa fa-print bg-green"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading" style="line-height: 28px;">Print Template(s)</h4>
                            </div>
                        </a>
                    </li>-->
                    
                    
                </ul><!-- /.control-sidebar-menu -->     
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside><!-- /.control-sidebar -->
<?php } ?>
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<script type="text/javascript" src="//code.jquery.com/jquery-1.7.1.min.js"></script>
<?php
if (($datepicker == '1') || ($editor = '1') || ($datatable == '1')) {
    ?>
    <!-- jQuery 2.1.4 OVER  -->
    <script src="<?php echo $sitename; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo $sitename; ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $sitename; ?>dist/js/app.min.js"></script>
    <!-- Bootstrap 3.3.5 END -->

    <!-- Select2 -->
    <script src="<?php echo $sitename; ?>plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo $sitename; ?>plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo $sitename; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo $sitename; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

    <script src="<?php echo $sitename; ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?php echo $sitename; ?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="<?php echo $sitename; ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?php echo $sitename; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo $sitename; ?>plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $sitename; ?>plugins/fastclick/fastclick.js"></script>

    <script src="<?php echo $sitename; ?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Page script -->

    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
            //Datemask dd/mm/yyyy
            $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
            //Money Euro
            $("[data-mask]").inputmask();
            //Date range picker
            $('#reservation').daterangepicker();
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY h:mm A'});
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                    {
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate: moment()
                    },
                    function (start, end) {
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    }
            );

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();

            //Timepicker
            $(".timepicker").timepicker({
                showInputs: false
            });
            //Datepicker
            $('.usedatepicker').datepicker({
                autoclose: true
            });

        });
    </script>

    <script src="<?php echo $sitename; ?>plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            //  CKEDITOR.replace('editor1');
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });
    </script>
    <script type="text/javascript">
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            if ($('#editor1').length > 0) {
                CKEDITOR.replace('editor1');
            }
            if ($('#editor2').length > 0) {
                CKEDITOR.replace('editor2');
            }
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });
    </script>
    <script src="<?php echo $sitename; ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
    <?php
} elseif ($editor = '1') {
    ?>
    <!-- jQuery 2.1.4 over start  -->
    <script src="<?php echo $sitename; ?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>dist/js/app.min.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>dist/js/demo.js" type="text/javascript"></script>

    <script src="<?php echo $sitename; ?>plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            //  CKEDITOR.replace('editor1');
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });
    </script>
    <script type="text/javascript">
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            if ($('#editor1').length > 0) {
                CKEDITOR.replace('editor1');
            }
            if ($('#editor2').length > 0) {
                CKEDITOR.replace('editor2');
            }
			if ($('#editor3').length > 0) {
                CKEDITOR.replace('editor3');
            }
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });
    </script>
<?php } else {
    ?>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $sitename; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script type="text/javascript">
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo $sitename; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo $sitename; ?>dhtmlgoodies_calendar/dhtmlgoodies_calendar.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo $sitename; ?>plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo $sitename; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo $sitename; ?>plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo $sitename; ?>plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo $sitename; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="<?php echo $sitename; ?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="<?php echo $sitename; ?>plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $sitename; ?>dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo $sitename; ?>dist/js/pages/dashboard.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $sitename; ?>dist/js/demo.js" type="text/javascript"></script>

<?php } ?>
<script type="text/javascript" src="<?php echo $sitename; ?>js/ajax.js"></script>
</body>
</html>

<?php
/*if ($_SESSION['permissionid'] != '') {

    $show_bars = pFETCH("SELECT * FROM `permission_details` WHERE `perm_id`=? AND `pview`=?", $_SESSION['permissionid'], 1);
    while ($showbarslist = $show_bars->fetch(PDO::FETCH_ASSOC)) {
        $pageid = $showbarslist['page_id'];
        ?>
        <script>
            document.getElementById("li_<?php echo $pageid; ?>").style.display = "block";
        </script>
        <style>
            .treeview-menu li
            {
                display:none;
            }
        </style>
        <?php
    }
}

if ($_SESSION['permissionid'] != '') {
    if ($thispageid != '') {
        $per = FETCH_all("SELECT * FROM `permission_details` WHERE `perm_id`=? AND `page_id`=?", $_SESSION['permissionid'], $thispageid);
        if ($per['pdelete'] == '1') { ?>
           
        <?php } else { ?>
            <script>
                setTimeout(function () {
                    $('input[name="chk[]"]').attr('disabled', 'disabled');
                    $('#delete').removeAttr('onclick');
                    $('#delete').attr('disabled', 'disabled');
                    $('#check_all').attr('disabled', 'disabled');
                    $('#delete').css('display', 'none');
                }, 200);
            </script>
            <?php
        }
        if ($per['paddnew'] == '1') { ?>
            
        <?php } else {
            ?>
            <script>
                setTimeout(function () {
                    $('.box-title').html('');
                    $('.fa-edit').prop('onclick', null).off('click');
                    $('#submit').css('display', 'none');
                }, 200);

            </script>
            <?php
        }
        if ($per['pedit'] == '1') { ?>
            <script>
                setTimeout(function () {
                    $('.fa-edit').prop('onclick', null).off('click');
                    
                }, 200);
            </script>
        <?php } else {
            ?>
            <script>
                setTimeout(function () {
                    $('.fa-edit').prop('onclick', null).off('click');
                    $('#update').css('display', 'none');
                }, 200);
            </script>
            <?php
        }
    }
} */
?>
<script>
    for (i = 1; i < 21; i++)
    {
        var ss = $("#ul_" + i + " >ul >li ").children().length;
        //     console.log(i);
        if (i === 16)
        {
            //console.log(ss);
        }
        var tt = 0;
        for (j = 1; j <= ss; j++)
        {
            if (($("#ul_" + i + " >ul li:nth-child(" + j + ")").css('display')) == 'none')
            {
                var tt = parseInt(1) + parseInt(tt);
            }
        }
        var tt = parseInt(ss) - parseInt(tt);
        $("#span_" + i).html(tt);
        if (parseInt(tt) == parseInt(0))
        {
            $("#ul_" + i).css("display", "none");
        }
    }
</script>