<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                      Philhealth Accounts
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
                            <form id="search-check-posted-form">
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
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="end_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>
                            </form>
                            
                            <div class="col-sm-2">
                                <button onclick="chequestat.search_cheque_stat()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
<!--                            -->
                            </div>
                        </div>
                    </div>
                </div>
            
           
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                CHEQUE STATUS <small><span style="color:green;">GREEN - Cheques that have already been received.</span>
                                    <br><span style="color:gray;">GRAY - Receivable Cheques.</span></small>
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header bg-green">POSTED SUMMARY</div>
                                        <div class="body">
                                            <div class="row clearfix">
                                                <form id="total-posted-check-stat">
                                                    <div class="col-md-4">
                                                        <b>HOSPITAL</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                               PAID:
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="posthosppaid" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                               UNPAID:
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="posthospunpaid" readonly="readonly" style="color:red;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>PROFESSIONAL</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                               PAID:
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="postprofpaid" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                               UNPAID:
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="postprofunpaid" readonly="readonly" style="color:red;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>GRAND TOTAL</b>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                               PAID:
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="postgrandpaid" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                               UNPAID:
                                                            </span>
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="postgrandunpaid" readonly="readonly" style="color:red;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                         <div class="header bg-grey">UNPOSTED SUMMARY</div>
                                        <div class="body">
                                            <div class="row clearfix">
                                                <form id="total-unposted-check-stat">
                                                    <div class="col-md-4">
                                                        <b>HOSPITAL</b>
                                                        <div class="input-group">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="unposthosppaid" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>PROFESSIONAL</b>
                                                        <div class="input-group">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="unpostprofpaid" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>GRAND TOTAL</b>
                                                        <div class="input-group">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="unpostgrandpaid" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <form id="total-cheque-date-form" action="<?= base_url("user/get_cheque_status_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value="<?= $cur_date ?>"/>
                                <input type="hidden" name="e_date" value="<?= $cur_date ?>"/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="chequestat.generate_cheque_stat_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                            <table id="cheque-stat-table" class="table table-bordered table-striped table-hover">
                                <thead >
                                    <tr style="font-size: 12px">
                                        <th>Claim Series No </th>
                                        <th>Patient Name</th>
                                        <th>Account No.</th>
                                        <th>Hospital</th>
                                        <th>Hosp. Variance</th>
                                        <th>Professional</th>
                                        <th>Prof. Variance</th>
                                        <th>Total</th>
                                        <th>Total Variance</th>
                                        <th>Voucher No.</th>
                                        <th>Cheque Date</th>
                                        <th>Status</th>
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
<?php $this->load->view('pages/modals/phicinprocess_modal'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
//    load_transmittal_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js");
    var sidemenu = $('#ph-accounts-4');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    chequestat.get_cheque_stat();
 
});
</script>