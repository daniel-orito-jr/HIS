<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Hospital Records
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
                            <form id="search-record-form">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" placeholder="Ex: 2017-01-01">
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
                                            <input type="text" name="end_date" class="form-control" placeholder="Ex: 2017-01-01">
                                        </div>
                                        <small style="color: red"></small>
                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-4">
                                <button onclick="user.search_records()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- #END# Basic Table -->
            <!--phic table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Census 
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table id="phic-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Total PHIC</th>
                                        <th>Total Non-PHIC</th>
                                        <th>Grand Total</th>
                                    </tr>
                                </thead>
                            </table>
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
                                IPD Discharges/Admissions 
                            </h2>

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
                                    <tr style="font-size: 12px">
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

            <!--doctors table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Doctors 
                            </h2>
                            <!--                            <ul class="header-dropdown m-r--5">
                                                            <li class="dropdown">
                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="material-icons">more_vert</i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li><a href="javascript:void(0);">Action</a></li>
                                                                    <li><a href="javascript:void(0);">Another action</a></li>
                                                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>-->
                        </div>
                        <div class="body table-responsive">
                            <form id="doctor-form" action="<?= base_url("user/generate_doc_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_doc_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_doc_report()">Preview Pdf</button></a>-->
                            <table id="doctor-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Name</th>
                                        <th>PHIC</th>
                                        <th>Non-PHIC</th>
                                        <th>Total Patient</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--patient table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Patients 
                            </h2>
                            <!--                            <ul class="header-dropdown m-r--5">
                                                            <li class="dropdown">
                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="material-icons">more_vert</i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li><a href="javascript:void(0);">Action</a></li>
                                                                    <li><a href="javascript:void(0);">Another action</a></li>
                                                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>-->
                        </div>
                        <div class="body table-responsive">
                            <form id="px-form" action="<?= base_url("user/generate_px_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_px_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_px_report()">Preview Pdf</button></a>-->
                            <table id="px-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Name</th>
                                        <th>Member Type</th>
                                        <th>Admit Date/Time</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--patient classifiaction table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Patient Classification 
                            </h2>
                            <!--                            <ul class="header-dropdown m-r--5">
                                                            <li class="dropdown">
                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="material-icons">more_vert</i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li><a href="javascript:void(0);">Action</a></li>
                                                                    <li><a href="javascript:void(0);">Another action</a></li>
                                                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>-->
                        </div>
                        <div class="body table-responsive">
                            <form id="px-classification-form" action="<?= base_url("user/generate_class_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_class_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_class_report()">Preview Pdf</button></a>-->
                            <table id="px-classification-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Classification</th>
                                        <th>Counts</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!--admitted table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Admitted Patients 
                            </h2>
                            <!--                            <ul class="header-dropdown m-r--5">
                                                            <li class="dropdown">
                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="material-icons">more_vert</i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li><a href="javascript:void(0);">Action</a></li>
                                                                    <li><a href="javascript:void(0);">Another action</a></li>
                                                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>-->
                        </div>
                        <div class="body table-responsive">
                            <form id="admitted-form" action="<?= base_url("user/generate_pat_report/0") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_pat_report(0)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_pat_report(0)">Preview Pdf</button></a>-->
                            <table id="admitted-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Name</th>
                                        <th>Admitted Date/Time</th>
                                        <th>Discharged Date/Time</th>
                                        <th>Classification</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--DISCHARGED table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Discharged Patient 
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="discharged-form" action="<?= base_url("user/generate_pat_report/1") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_pat_report(1)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_pat_report(1)">Preview Pdf</button></a>-->
                            <table id="discharged-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Name</th>
                                        <th>Admitted Date/Time</th>
                                        <th>Discharged Date/Time</th>
                                        <th>Classification</th>
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
        $('#menu-census').removeClass().addClass('active');


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
