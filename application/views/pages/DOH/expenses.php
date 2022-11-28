<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>III. Hospital Operations</li>
                    <li class="active">Expenses</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                IV. EXPENSES
                                <small>Report all money spent by the facility on each category.</small>
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
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th>Expenses</th>
                                                    <th>Amount in Pesos</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td>Amount spent on personnel salaries and wages</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Amount spent on benefits for employees (benefits are in addition to wages/salaries. <br>
                                                    Benefits include for example: social security contributions, health insurance</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Allowances provided to employees at this facility (Allowances are in addition to wages/salaries. Allowances include for example: clothing allowance, PERA, vehicle maintenance allowance and hazard pay.)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>TOTAL amount spent on all personnel incuding wages, salaries, benefits and allowances for last year (PS)</b></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount spent on medicines funded by the Revolving Fund</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount spent on medicines funded by the Government of the Philippines (from any level of government, including the central, provincial and municipal governments.) </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount spent on medical supplies (i.e. syringe, gauze, etc.; exclude pharmaceuticals </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount spent on utilities</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total amount spent on non-medical service (For example: security, food service, laundry, waste management)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>TOTAL amount spent on maintenance and other opearting expenditures (MOOE)</b></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Amount spent on infrastructure (i.e., new hospital wing, installation of ramps)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Amount spent on equipments (i.e. x-ray machine, CT Scan)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>TOTAL amount spent on capital outlay (CO) </b></td>
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
        </div>
    </section>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   var sidemenu = $('#DOH-5');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');

});
</script>