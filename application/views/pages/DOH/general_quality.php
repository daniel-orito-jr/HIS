<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>I. General Information</li>
                    <li class="active">B. Quality Management</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                B. QUALITY MANAGEMENT
                                <small>* Quality Management/ Quality Assurance Program: Organized set of activities designed to demonstrate on-going assessment of important aspects of patient care and services.</small>
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
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                  <input name="quality" type="radio" id="quality_1" class="with-gap"/>
                                  <label for="quality_1"><b>ISO Certified (Specify ISO Certifying Body and area(s) of the hospital with Certification)</b></label>
                                <input type="text" class="form-control" >
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <p><b>Validity Period:</b></p>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                  <input name="quality" type="radio" id="quality_2" class="with-gap"/>
                                  <label for="quality_2"><b>International Accreditation</b></label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <p><b>Validity Period:</b></p>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                  <input name="quality" type="radio" id="quality_3" class="with-gap"/>
                                  <label for="quality_3"><b>PhilHealth Accreditation</b></label><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input name="quality_ph" type="radio" id="quality_ph_1" class="with-gap radio-col-light-blue""/>
                                                            <label for="quality_ph_1">Basic Participation</label><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input name="quality_ph" type="radio" id="quality_ph_2" class="with-gap radio-col-light-blue""/>
                                                            <label for="quality_ph_2">Advanced Participation</label><br>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <p><b>Validity Period:</b></p>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                  <input name="quality" type="radio" id="quality_4" class="with-gap"/>
                                  <label for="quality_4"><b>PCAHO</b></label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <p><b>Validity Period:</b></p>
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
   var sidemenu = $('#DOH-2-2');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
});
</script>