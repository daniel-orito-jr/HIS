<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    <?= $page_title ?>
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
                            <form id="search-eclaimsummaryreport-form">
                                <input type="hidden" name="s_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="month" name="start_date" class="form-control" value="<?= $todays_month ?>" onchange="eclaimsummaryreport()">
                                        </div>
                                        <small style="color: red"></small>

                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-2">
                                <button onclick="eclaimsummaryreport()" type="button" class="btn bg-purple waves-effect">
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
                                E-Claims Summary Report
                            </h2>
                        </div>
                        <div class="body table-responsive">
<!--                            <form id="eclaims-summaryreport-form" action="<?= base_url("user/get_phic_inprocess_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" />
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="inprocessphic.generate_phicinprocess_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>-->
                            <table id="eclaims-summary-report-table" class="table table-bordered table-striped table-hover nowrap">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Status</th>
                                        <th>Sent</th>
                                        <th>Percentage</th>
                                        <th>Discharged</th>
                                        <th>Percentage</th>
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
        var sidemenu = $('#ph-accounts-0');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');


    });
</script>