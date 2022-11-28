<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Payment
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Covered Month
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-payment-form">
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
                                <button onclick="paymentphic.search_phic_payment()" type="button" class="btn bg-purple waves-effect">
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
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Payment for the Month
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="header bg-cyan" style="text-transform:uppercase;">
                                <h5>
                                    AR Aging to Transmittal
                                </h5>
                            </div>
                            <table id="paymentaging-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Aging </th>
                                        <th>Patients</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <hr>
                        <div class="body table-responsive">
                            <div class="header bg-cyan" style="text-transform:uppercase;">
                                <h5>
                                    AR Aging to Date Discharge
                                </h5>
                            </div>
                            <table id="paymentdischarge-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Aging </th>
                                        <th>Patients</th>
                                        <th>Amount</th>
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
<?php $this->load->view('pages/modals/payment_transmittal'); ?>
<?php $this->load->view('pages/modals/payment_discharge'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        load_payment_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
        var sidemenu = $('#menu-4-3');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
    });
</script>





















