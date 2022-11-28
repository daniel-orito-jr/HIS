<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Monthly Transaction
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Covered Date
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-monthly-form">
                                <input type="hidden" name="s_date" value=""/>

                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="monthdate" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-2">
                                <button onclick="monthly.monthpick()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>





            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>


                                <select class="form-control show-tick" id="lastmonthpicker" onchange="monthly.monthpick()" >
                                    <option value="12" selected="selected">Income for the last 12 months</option>
                                    <option value="9">Income for the last 9 months</option>
                                    <option value="6">Income for the last 6 months</option>
                                    <option value="3">Income for the last 3 months</option>

                                </select>



                            </h2>
                        </div>
                        <div class="body">
                            <div class="chart-container" style="position: relative;margin: auto;width: 70vw;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Income for the last <span id ="lastmonth" ></span> months

                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="monthly-transaction-form" action="<?= base_url("user/generate_monthly_transaction_report") ?>" method="POST" target="_blank" id="ph">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="rangemonth" id="monthrange" value="12"/>
                            </form>
                            <a class="report-daily-transaction" href="javascript:void(0)" target="_blank" >
                                <button onclick="monthly.get_monthly_transaction_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <table id="monthly-transaction-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th style="background-color:#BBDEFB;">Total Income</th>
                                        <th>Drugs/Meds</th>
                                        <th>Medical Supply</th>
                                        <th>Pharmacy Miscellaneous</th>
                                        <th style="background-color:#C5CAE9;">Pharmacy Income</th>
                                        <th>Laboratory</th>
                                        <th>Radiology</th>
                                        <th>Hospital</th>
                                        <th>IPD Payment</th>
                                        <th>HMO</th>
                                        <th>PCSO</th>
                                        <th>PHIC</th>
                                        <th>OPD Laboratory</th>
                                        <th>OPD Radiology</th>
                                        <th>ODP Payment</th>
                                        <th>PN Account</th>
                                        <th>Delivery Pharmacy</th>
                                        <th>Delivery Laboratory</th>
                                        <th>Delivery Radiology</th>
                                        <th>Delivery Hospital</th>

                                    </tr>
                                </thead>

                            </table>
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

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var sidemenu = $('#income-2');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

        load_scriptmonth("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");

        //daily.get_daily_transaction();

//    chart.create_chart();
//    chart.monthly_census_chart();


    });
</script>
