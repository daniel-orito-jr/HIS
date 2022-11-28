<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    COLLECTION SUMMARY
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
                            <form id="search-proofsheet-form">
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
                                <button onclick="user.search_proofsheets()" type="button" class="btn bg-purple waves-effect">
                                    <span>Search <i class="material-icons">search</i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                 Proofsheet for the last 30 days
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
                    
            <!--date table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Proofsheet By Date
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="date-proofsheet-form" action="<?= base_url("user/generate_proofsheet_report/1") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_d_proofsheet_report(1)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <table id="date-proofsheet-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Date/Time</th>
                                        <th>Total Debit</th>
                                        <th>Total Credit</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--cashier table-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                Proofsheet By Cashier
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
                            <form id="proofsheet-form" action="<?= base_url("user/generate_proofsheet_report/0") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <input type="hidden" name="e_date" value=""/>
                                <input type="hidden" name="search" value=""/>
                            </form>
                            
                            <a class="report-btn" href="javascript:void(0)" target="_blank">
                                <button onclick="user.get_d_proofsheet_report(0)" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                    <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                </button>
                            </a>
                            <table id="proofsheet-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 12px">
                                        <th>Date/Time</th>
                                        <th>Cashier</th>
                                        <th>Total Debit</th>
                                        <th>Total Credit</th>
                                        <th>Details</th>
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

<?php 
    $this->load->view('pages/modals/fetchLoader'); 
    $this->load->view('pages/modals/proofsheetDetails'); 
?>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    $('#menu-cash').removeClass().addClass('active');
    
    user.get_proofsheets();
    chart.proofsheet_chart();
//    $('.datepicker').bootstrapMaterialDatePicker({
//        format: 'MMMM DD YYYY',
//        clearButton: true,
//        weekStart: 1,
//        time: false
//    });
});
</script>

