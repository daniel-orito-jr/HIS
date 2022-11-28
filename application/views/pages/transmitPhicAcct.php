<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Transmitted
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Covered Date
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-transmittal-day-form">
                                <input type="hidden" name="s_datex" value=""/>
                                <div class="col-sm-3">
                                    <div class='input-group '>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="date" name="start_datex" class="form-control" value="<?= $yesss ?>">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class='input-group '>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="date" name="end_datex" class="form-control" value="<?= $yesss ?>">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-3">
                                <button onclick="transmit_day.search_phic_transmit_day()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                            <!--<div class="col-sm-3">-->
                            <form id="totalx">
                                <div style="margin-top: 10px" class="col-sm-6">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <label>Total Good Claims: </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="totalpxx" class="form-control" readonly="readonly">
                                                <label class="form-label">Patients</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="tatolamtx" class="form-control" readonly="readonly">
                                                <label class="form-label">Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Transmitted Claims
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="phic-transmittal-day-form" action="<?= base_url("user/generate_phic_transmittal_daily_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date"/>
                                <input type="hidden" name="e_date"/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="transmitphic.generate_phic_transmittal_daily_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="transmittal-day-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Account Number</th>
                                        <th>Patient Name</th>
                                        <th>Discharge Date</th>
                                        <th>Transmit Date</th>
                                        <th>Hospital Fee</th>
                                        <th>Professional Fee</th>
                                        <th>Total Amount</th>
                                        <th>Transmitted By</th>
                                        <th>Aging</th>

                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Covered Month
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-transmittal-form">
                                <input type="hidden" name="s_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="start_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-2">
                                <button onclick="transmitphic.search_phic_transmit()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                            <form id="total-data">
                                <div style="margin-top: 10px" class="col-sm-6">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <label>Total Good Claims: </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="totalpx" class="form-control" readonly="readonly">
                                                <label class="form-label">Patients</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="tatolamt" class="form-control" readonly="readonly">
                                                <label class="form-label">Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Transmitted Claims for the Month
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="phic-transmittal-form" action="<?= base_url("user/generate_phic_transmittal_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date"/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="transmitphic.generate_phic_transmittal_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="transmittal-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Aging (from Date of Discharge)</th>
                                        <th>Patients</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Transmitted Claims for the Last 6 Months

                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table id="transmittal-months-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Month </th>
                                        <th>Discharges</th>
                                        <th>Discharges (PHIC)</th>
                                        <th>Transmitted</th>
                                        <th>Transmitted Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($transmit_month); $i++) { ?>
                                        <tr>
                                            <td><?= $transmit_month[$i]["datex"] ?></td> 
                                            <td><?= $transmit_month[$i]["discharges"] ?></td> 
                                            <td><?= $transmit_month[$i]["phicmemb"] ?></td> 
                                            <td><?= $transmit_month[$i]["transmitted"] ?></td>
                                            <td><?= '₱ ' . number_format($transmit_month[$i]["totalamount"], 2) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
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
<?php $this->load->view('pages/modals/transmitinfo'); ?>
<?php $this->load->view('pages/modals/transmitmonthly'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        load_transmittal_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        var sidemenu = $('#menu-4-2');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');

        $('#transmittal-months-table').dataTable({
            dom: 'frtip',
            order: [[0, "desc"]],
            responsive: true,
            processing: true,
        });


        transmit_day.get_transmitted_patients_day();
    });
</script>




















