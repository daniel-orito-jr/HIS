<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>II. Hospital Operations</li>
                    <li class="active">D. Healthcare Associated Infections (HAI)</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               D. HEALTHCARE ASSOCIATED INFECTIONS (HAI)
                               <small>HAI are infections that patients acquire as a result of healthcare interventions. For purposes of Licensing, the four (4) major HAI would suffice.</small>
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-daily-form"  method="POST" >
                               <input type="hidden" name="s_date" value=""/>
                               <div class="col-sm-4">
                                    <div class='input-group date'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon">date_range</i>
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
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p>For All Hospitals (General and Specialty)</p>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Percentage (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td><b>INFECTION RATE</b></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b>Device Related Infection</b></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;Ventilator Acquired Pneumonia (VAP)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;Blood Stream Infection (BSI)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;Urinary Tract Infection (UTI)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b>Non-Device Related Infection</b></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;Surgical Site Infection (SSI)</td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>INFECTION RATE</b></p>
                                    <div class="body table-responsive">
                                        <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>INFECTION RATE = </center></td>
                                                    <td colspan="3"><center>Number of Healthcare Associated Infections ()
                                                                    </center>
                                                    </td>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>x 100</center></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top: dotted black;"><center>Number of Discharges ()
                                                                                        </center></td>
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
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>a. Device Related Infections</b></p>
                                    <div class="body table-responsive">
                                        <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>1. Ventilator Acquired Pneumonia (VAP) = </center></td>
                                                    <td colspan="3"><center>Number of Patients with VAP ()
                                                                    </center>
                                                    </td>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>x 1000</center></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top: dotted black;"><center>Total Number of Ventilator Days ()
                                                                                        </center></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <small>(Not to be filled up by Level 1 with no ICU facilities)</small>
                                        <hr>
                                        <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>2. Blood Stream Infection (BSI) = </center></td>
                                                    <td colspan="3"><center>Number of Patients with BSI ()
                                                                    </center>
                                                    </td>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>x 1000</center></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top: dotted black;"><center>Total Number of Central Line (peripheral lines not included) ()
                                                                                        </center></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <hr>
                                        <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>3. Urinary Tract Infection (UTI) = </center></td>
                                                    <td colspan="3"><center>Number of Patients (with catheter) with UTI ()
                                                                    </center>
                                                    </td>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>x 1000</center></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top: dotted black;"><center>Total Number of Catheter Days ()
                                                                                        </center></td>
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
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>b. Non-Device Related Infections</b></p>
                                    <div class="body table-responsive">
                                        <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>Surgical Site Infections (SSI) = </center></td>
                                                    <td colspan="3"><center>Number of Surgical Site Infections (Clean Cases) ()
                                                                    </center>
                                                    </td>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;"><center>x 100</center></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top: dotted black;"><center>Total number of Clean Procedures done ()
                                                                                        </center></td>
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
    </section>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   var sidemenu = $('#DOH-3-4');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');

});
</script>