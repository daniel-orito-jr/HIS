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
                            <form id="search-check-unposted-form">
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
                                <button onclick="unposted.search_unposted_cheque()" type="button" class="btn bg-purple waves-effect">
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
                                UNPOSTED
                                <small>Receivable Cheques</small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-md-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#with_cheque_2" data-toggle="tab">WITH CHEQUE</a></li>
                                        <li role="presentation"><a href="#without_cheque_2" data-toggle="tab">WITHOUT CHEQUE</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane animated fadeInRight active" id="with_cheque_2">
                                            <form id="total-unposted-check">
                                                <div style="margin-top: 10px" class="col-sm-12">

                                                    <div class="col-sm-4">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label>HOSPITAL</label>
                                                                <input type="text" name="hosp" class="form-control" readonly="readonly">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label>PROFESSIONAL</label>
                                                                <input type="text" name="prof" class="form-control" readonly="readonly">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label>GRAND TOTAL</label>
                                                                <input type="text" name="grand" class="form-control" readonly="readonly">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="total-unposted-check-form" action="<?= base_url("user/get_unposted_payment_report") ?>" method="POST" target="_blank">
                                                <input type="hidden" name="s_date" id="s_date" value="<?= $cur_date ?>"/>
                                                <input type="hidden" name="e_date" id="e_date" value="<?= $cur_date ?>"/>
                                                <input type='hidden' name='stat' value='check'/>
                                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                                    <button onclick="unposted.generate_unposted_check_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                                    </button>
                                                </a>   
                                            </form>
                                            <table id="unposted-cheque-table" class="table table-bordered table-striped table-hover ">
                                                <thead class="bg-cyan">
                                                    <tr style="font-size: 12px">
                                                        <th>Claim Series No</th>
                                                        <th>Patient Name</th>
                                                        <th>Account Name</th>
                                                        <th>Hospital</th>
                                                        <th>Professional</th>
                                                        <th>Total</th>
                                                        <th>Process Date</th>
                                                        <th>Cheque Date</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane animated fadeInRight" id="without_cheque_2">
                                            <form id="total-unposted-wcheck">
                                                <div style="margin-top: 10px" class="col-sm-12">

                                                    <div class="col-sm-4">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label>HOSPITAL</label>
                                                                <input type="text" name="whosp" class="form-control" readonly="readonly">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label>PROFESSIONAL</label>
                                                                <input type="text" name="wprof" class="form-control" readonly="readonly">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label>GRAND TOTAL</label>
                                                                <input type="text" name="wgrand" class="form-control" readonly="readonly">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="total-unposted-wcheck-form" action="<?= base_url("user/get_unposted_payment_report") ?>" method="POST" target="_blank">
                                                <input type="hidden" name="ws_date" id="ws_date" value="<?= $cur_date ?>"/>
                                                <input type="hidden" name="we_date" id="we_date" value="<?= $cur_date ?>"/>
                                                <input type='hidden' name='stat' value='wcheck'/>
                                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                                    <button onclick="unposted.generate_unposted_wcheck_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                                    </button>
                                                </a>   
                                            </form>
                                            <table id="unposted-wcheque-table" class="table table-bordered table-striped table-hover ">
                                                <thead class="bg-cyan">
                                                    <tr style="font-size: 12px">
                                                        <th>Claim Series No</th>
                                                        <th>Patient Name</th>
                                                        <th>Account Name</th>
                                                        <th>Hospital</th>
                                                        <th>Professional</th>
                                                        <th>Total</th>
                                                        <th>Process Date</th>
                                                        <th>Cheque Date</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>


                                    </div>
                                </div>
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

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {

        var sidemenu = $('#ph-accounts-2');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
        unposted.get_unposted_cheque();
        unposted.get_unposted_wcheque();

    });
</script>