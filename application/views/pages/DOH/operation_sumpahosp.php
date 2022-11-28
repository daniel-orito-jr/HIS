<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>II. Hospital Operations</li>
                    <li class="active">A. Summary of Patients in the Hospital</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                A. SUMMARY OF PATIENTS IN THE HOSPITAL
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
                                    <p>For each category listed below, please report the total volume of services or procedures performed.</p>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>&#9632; Inpatient: A patient who stays in a health facility while under treatment.</small><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>&#9632; Bed day: Bed used for a continuous 24 hours by an inpatient.</small>
                                    <hr>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="return-table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Inpatient Care</th>
                                                <th>Number</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 12px">
                                            <tr>
                                                <td>Total number of inpatients (admissions, including newborns)</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Total Discharges (Alive) </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Total patients admitted and discharged on the same day </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Total number of inpatient bed days (service days) </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Total number of inpatients transferred TO THIS FACILITY from another facility for inpatient care </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Total number of inpatients transferred FROM THIS FACILITY to another facility for inpatient care </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Total number of patients remaining in the hospital as of midnight last day of previous year </td>
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
    </section>
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
   var sidemenu = $('#DOH-3-1');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
});
</script>