<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Admitted/Discharged Patients
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" >
                            <h2>
                                SUMMARY
                            </h2>
                        </div>
                        <div class="body table-responsive">
<!--                            <form id="admitted-form" action="<?= base_url("user/generate_pat_report/0") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_pat_report(0)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_pat_report(0)">Preview Pdf</button></a>-->
                            <table id="summary-disadd-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th rowspan="2"><center>Month</center></th>
                                        <th rowspan="2"><center>Month</center></th>
                                        <th colspan="2" ><center>Number of Admission</center></th>
                                        <th colspan="2" ><center>Number of Discharges</center></th>
                                    </tr>
                                    <tr>
                                        <th><center>PHIC</center></th>
                                        <th><center>NON-PHIC</center></th>
                                        <th><center>PHIC</center></th>
                                        <th><center>NON-PHIC</center></th>
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
                        <div class="header bg-cyan">
                            <h2>
                                Covered Date
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-adpat-form">
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
                            </form>
                            
                            <div class="col-sm-4">
                                <button onclick="user.search_adpat_census()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--admitted table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase">
                            <h2>
                                Admitted Patients &nbsp; <small id="admit"></small>
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div id="add">
                                <form id="admitted-form" action="<?= base_url("user/generate_pat_report/0") ?>" method="POST" target="_blank">
                                    <input type="hidden" name="s_date" value=""/>

                                </form>
                                <a class="report-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_pat_report(0)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>
                            </div>
                            <div id="add2" class="hidden">
                                <form id="admitted-form2" action="<?= base_url("user/generate_pat_report/3") ?>" method="POST" target="_blank">
                                    <input type="hidden" name="s_date" value=""/>

                                </form>
                                <a class="report-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_pat_report(3)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>
                            </div>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_pat_report(0)">Preview Pdf</button></a>-->
                            <table id="admitted-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                         <th>Account Number</th>
                                        <th>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Admitted Date/Time</th>
                                        <th>Discharged Date/Time</th>
                                        <th>Classification</th>
                                        <th>Membership</th>
                                        <th>Room</th>
                                        <th>Doctor</th>
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
                        <div class="header bg-cyan" style="text-transform:uppercase">
                            <h2>
                                Discharged Patient &nbsp; <small id="discharge"></small>
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <div id="diss">
                                <form id="discharged-form" action="<?= base_url("user/generate_pat_report/1") ?>" method="POST" target="_blank">
                                    <input type="hidden" name="s_date" value=""/>
                                </form>
                                <a class="report-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_pat_report(1)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>
                            </div>
                            <div id="diss2" class="hidden">
                                <form id="discharged-form2" action="<?= base_url("user/generate_pat_report/4") ?>" method="POST" target="_blank">
                                    <input type="hidden" name="s_date" value=""/>
                                </form>
                                <a class="report-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="user.get_pat_report(4)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>
                            </div>
                            <!--<a class="report-btn" href="javascript:void(0)" target="_blank"><button onclick="user.get_pat_report(1)">Preview Pdf</button></a>-->
                            <table id="discharged-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                         <th>Account Number</th>
                                        <th>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Admitted Date/Time</th>
                                        <th>Discharged Date/Time</th>
                                        <th>Classification</th>
                                        <th>Membership</th>
                                        <th>Room</th>
                                        <th>Doctor</th>
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
    var sidemenu = $('#census-1');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
     load_script("http://192.168.2.111:3777/drainwizv2/assets/vendors/js/responsive.js",5,0);
    user.get_dis_ad_summary();
    
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
    
    
    $(".dtp-btn-ok").click(function(){
        var s_date = $('#search-record-form input[name = start_date]');
        var e_date = $('#search-record-form input[name = end_date]');

//        var id = $(this).parents('.dtp').attr('id');
//        alert(id);
//    //    alert($('#test').attr('id'));

        (s_date.val() != "" && e_date.val() != "") ? user.get_records() : false;
    });
});
</script>
