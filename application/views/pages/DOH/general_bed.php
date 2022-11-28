<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>I. General Information</li>
                    <li class="active">C. Bed Capacity/ Occupancy</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                C. BED CAPACITY/OCCUPANCY
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
                                    <p><b>1. Authorized Bed Capacity: <span><u>35</u></span> beds</b></p>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>* Authorized Bed: Approved number of beds issued by HFSRB/RO, the licensing offices of DOH</small>
                                    <hr>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>2. Implementing Beds: <span><u>35</u></span> beds</b></p>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>* Implementing beds: Actual beds used (based on hospital management decision)</small>
                                    <hr>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>3. Bed Occupancy Rate (BOR) Based on Authorized Beds: <u><span>35</span>%</u> beds</b></p>
                                    <div class="body table-responsive">
                                        <table id="daily-census-table" class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <td colspan="3"><center>[Total Inpatient service days for the period]  (<b><span id="phic" ></span></b>)</center></td>
                                                <td rowspan="2" style="vertical-align : middle;text-align:center;">x 100</td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: dotted black;"><center>[Total number of Authorized beds] ( <span id="dae" ></span>) * [Total days in the period (365 or 366 for leap year)] (<span id="authorizedbed" ></span>)</center></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <small>&#9632; Bed Occupancy Rate: The percentage of inpatient beds occupied over a given period of time. It is a measure of intensity of hospital resources utilized by in-patients. (given period of time is January 1 to December 31 each year for the annual statistics)</small><br>
                                    <small>&#9632; Inpatient Service days (Inpatient bed days): Unit of measure denoting the services received by one in-patient in one 24 hour period.</small><br>
                                    <small>&#9632; Total Inpatient Service days or Inpatient Bed days = [(Inpatients remaining at midnight + Total admissions) - Total discharges/deaths) + (number of admissions and discharges on the same day)].</small>
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
   var sidemenu = $('#DOH-2-3');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
});
</script>