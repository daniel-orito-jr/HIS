<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Payroll Summary
                </h2>
            </div>

            <!--            <div class="row clearfix">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="header bg-cyan" style="text-transform:uppercase;">
                                        <h2>
                                            Covered Date
                                        </h2>
                                    </div>
                                    <div class="body container-fluid">
                                        <form id="payroll-summary-form">
                                            <input type="hidden" name="s_date_payroll" value=""/>
                                            <input type="hidden" name="e_date_payroll" value=""/>
                                            <div class="col-sm-4">
                                                <div class='input-group date'>
                                                    <span class="input-group-addon">
                                                        <i class="material-icons date-icon" >date_range</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type='text' name="start_date_payroll" class="form-control" value="<?= $cur_date ?>">
                                                    </div>
                                                    <small style="color: red"></small>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group date">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons date-icon">date_range</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" name="end_date_payroll" class="form-control" value="<?= $cur_date ?>">
                                                    </div>
                                                    <small style="color: red"></small>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-sm-4">
                                            <button onclick="payroll.get_payroll_summary()" type="button" class="btn bg-purple waves-effect">
                                                <span>Search <i class="material-icons">search</i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

            <!--admitted table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                PAYROLL SUMMARY 
<!--                                <br> <small>Payroll Period: <span  id="payperiod"></span></small>
                                <br> <small>Number of Days: <span  id="paydays"></span></small>-->
                            </h2>
                        </div>
                        <div class="body table-responsive">

<!--                                <form id="payroll-form" action="<?= base_url("user/generate_payroll_summary_report") ?>" method="POST" target="_blank">
        <input type="hidden" name="s_datex" value=""/>
        <input type="hidden" name="e_datex" value=""/>
    </form>

    <a class="payroll-button" href="javascript:void(0)" target="_blank">
        <button onclick="payroll.get_payroll_summary_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
            <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
        </button>
    </a>-->
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_pat_report(0)">Preview Pdf</button></a>-->
<!--                            <table id="payroll-summary-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th rowspan="2">Department</th>
                                        <th rowspan="2">Employee Number</th>
                                        <th rowspan="2">Employee Name</th>
                                        <th rowspan="2">Salary Grade</th>
                                        <th rowspan="2">Basic Pay</th>
                                        <th rowspan="2">Incentives</th>
                                        <th rowspan="2" style="background-color:#BBDEFB">GROSS</th>
                                        <th colspan="5"><center>LESS</center></th>
                                        <th rowspan="2" style="background-color:#C5CAE9">NET</th>
                                    </tr>
                                    <tr style="font-size: 12px">
                                        <th>SSS</th>
                                        <th>PhilHealth</th>
                                        <th>PAG-IBIG</th>
                                        <th>Tax</th>
                                        <th>Absent and Undertime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>-->
                            <div class="table-responsive">
                                <table id="payroll-summary-table" class="table table-striped table-bordered" style="width:100%;">
                                    <thead style="background-color:green;color:white;">
                                        <tr>
                                            <th>Batchcode</th>
                                            <th>Batchdate</th>
                                            <th>Gross</th>
                                            <th>Deductions</th>
                                            <th>Net</th>
                                            <th>Payroll Funded</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer style="margin-bottom: 10px;">
         <div>
             <center>Powered by <img src="<?= base_url('assets/img/logo.png'); ?>" width="15" height="15"/> <a href="https://www.mydrainwiz.com/">DRAiNWIZ</a>.</center>
         </div>
         <div class="clearfix"></div>
     </footer>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>
<?php $this->load->view('pages/modals/payrolldetails'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        $('#menu-payrollsummary').removeClass().addClass('active');
        payroll.get_payroll_summary();
//     load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",5,0);
//    user.get_dis_ad_summary();

//    function show_calendar(){
//        $('.datepicker').focus().focus();
//    }
//

//
//    
//    
//    $('.date-icon').click(function(){
//        $('.date').bootstrapMaterialDatePicker({
//            format: 'MMMM DD YYYY',
//            clearButton: true,
//            weekStart: 1,
//            time: false
//        });
//        $('.date').focus().focus();
//    });


//    $(".dtp-btn-ok").click(function(){
//        var s_date = $('#search-record-form input[name = start_date]');
//        var e_date = $('#search-record-form input[name = end_date]');
//
////        var id = $(this).parents('.dtp').attr('id');
////        alert(id);
////    //    alert($('#test').attr('id'));
//
//        (s_date.val() != "" && e_date.val() != "") ? user.get_records() : false;
//    });
    });
</script>
