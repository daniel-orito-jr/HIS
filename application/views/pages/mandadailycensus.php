<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Daily Census
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
                            <form id="search-daily-form"  method="POST" >
                                <input type="hidden" name="s_date" value=""/>

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
                                <button onclick="mandadaily.search_daily_census()" type="button" class="btn bg-purple waves-effect">
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
                                A.1. Daily Census of <i>NHIP</i> Patients (Every 12:00 MN.)
                                <small>CENSUS OF THE DAY = (CENSUS OF THE PREVIOUS DAY plus ADMISSIONS OF THE DAY minus DISCHARGES OF THE DAY)</small>
                            </h2>
                        </div>

                        <div class="body table-responsive">

                            <form id="daily-census-form" action="<?= base_url("user/generate_daily_census_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="mandadaily.get_mandatory_daily_census_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   

                            </form>
                            <br>
                            <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr >
                                        <th><center>1</center></th>
                                <th colspan="3"><center>2</center></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="align-middle"><center>DATE</center></th>
                                <th colspan="3"><center>CENSUS</center></th>
                                </tr>
                                <tr>
                                    <th><center>a. NHIP</center></th>
                                <th><center>b. NON-NHIP</center></th>
                                <th><center>c. TOTAL</center></th>
                                </tr>

                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($census_month); $i++) { ?>
                                        <tr>
                                            <td><?= $census_month[$i]["datex"] ?></td> 
                                            <td><?= $census_month[$i]["nhip"] ?></td> 
                                            <td><?= $census_month[$i]["non"] ?></td> 
                                            <td><?= $census_month[$i]["totalx"] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>TOTAL       </td>
                                        <td><?= $phic ?> </td>
                                        <td><?= $non ?>  </td>
                                        <td><?= $pat ?> </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>




            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan" style="text-transform:uppercase;">
                            <h2>
                                DISCHARGES OF THE DAY 

                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="daily-discharges-form" action="<?= base_url("user/generate_daily_discharge_report") ?>" method="POST" target="_blank">
                                <input type="hidden" name="s_date" value=""/>
                                <a class="reports-btn" href="javascript:void(0)" target="_blank">
                                    <button onclick="mandadaily.get_mandatory_daily_discharges_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i>
                                    </button>
                                </a>   
                            </form>
                            <br>

                            <table id="discharges-month-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr >
                                        <th><center>3</center></th>
                                <th colspan="3"><center>4</center></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="align-middle"><center>DATE</center></th>
                                <th colspan="3"><center>DISCHARGES</center></th>
                                </tr>
                                <tr>
                                    <th><center>a. NHIP</center></th>
                                <th><center>b. NON-NHIP</center></th>
                                <th><center>c. TOTAL</center></th>
                                </tr>

                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($discharge_month); $i++) { ?>
                                        <tr>
                                            <td><?= $discharge_month[$i]["datex"] ?></td> 
                                            <td><?= $discharge_month[$i]["nhip"] ?></td> 
                                            <td><?= $discharge_month[$i]["non"] ?></td> 
                                            <td><?= $discharge_month[$i]["totalx"] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>TOTAL       </td>
                                        <td><?= $disphic ?> </td>
                                        <td><?= $disnon ?>  </td>
                                        <td><?= $dispat ?> </td>
                                    </tr>
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
<?php $this->load->view('pages/modals/admittedpatientday'); ?>
<?php $this->load->view('pages/modals/eachDayPatCensus'); ?>
<?php $this->load->view('pages/modals/philhealthpatients'); ?>
<?php $this->load->view('pages/modals/totalpatients'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var sidemenu = $('#mandatory-2');
        sidemenu.removeClass().addClass('active');
        sidemenu.parents("li").removeClass().addClass('active');
    });
</script>