<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Patient Type
                </h2>
            </div>
            <!--                <div class="row">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" />
                                            <span class="input-group-addon">
                                                <i class="material-icons date-icon" >date_range</i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Covered Date
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-patType-form">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $cur_date ?>">
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
                                            <input type="text" name="end_date" class="form-control" value="<?= $cur_date ?>">
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-4">
                                <button onclick="user.search_ipd_census()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--dis/adm table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                IPD Discharges/Admissions                             </h2>

                        </div>

                        <div class="body table-responsive">
                            <form id="ipd-form" action="<?= base_url("user/generate_ipd_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>

                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_ipd_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>

<!--                            <span>Admissions : </span>
<span>Discharges: </span>-->

                            <table id="dis-adm-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 11px">
                                        <th>Px Classification</th>
                                        <th>Admissions</th>
                                        <th>Discharges</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--opd patients table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                OPD Admissions/Discharges 
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="opd-form" action="<?= base_url("user/generate_opd_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>

                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_opd_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_opd_report()">Preview Pdf</button></a>-->
                            <table id="opd-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 11px">
                                        <th>Case Type</th>
                                        <th>Admissions</th>
                                        <th>Discharges</th>
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
        var sidemenu = $('#menu-0-1');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');


        $(".dtp-btn-ok").click(function () {
            var s_date = $('#search-record-form input[name = start_date]');
            var e_date = $('#search-record-form input[name = end_date]');

//        var id = $(this).parents('.dtp').attr('id');
//        alert(id);
//    //    alert($('#test').attr('id'));

            (s_date.val() != "" && e_date.val() != "") ? user.get_records() : false;
        });
    });
</script>
