<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>I. General Information</li>
                    <li class="active">A. Classification</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2> A. CLASSIFICATION </h2>
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
                                    <span>IMPORT <i class="material-icons">file_download</i></span>
                                </button>
                            </div>
                            
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <form id="general-class-form">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            
                                <div class="demo-switch">
                                    <p>EDIT NOW?
                                <div class="switch">
                                    <label>NO<input type="checkbox" name="cb_edit" id="cb_edit" onchange="general_class.check_cb()"><span class="lever"></span>YES</label>
                                </div>
                            </div>
                            <hr>
                            <h2>
                                1. Service Capability
                                <small>* Capability of a hospital/other health facility to render administrative, clinical, ancillary and other services.</small>
                            </h2>
                        </div>
                        <div class="body">
                            <h2 class="card-inside-title">General:</h2>
                            <div class="demo-radio-button">
                                <input name="general_service" type="radio" id="level_1" class="with-gap" value="Level 1 Hospital"/>
                                <label for="level_1">Level 1 Hospital</label>
                                <input name="general_service" type="radio" id="level_2" class="with-gap" value="Level 2 Hospital"/>
                                <label for="level_2">Level 2 Hospital</label>
                                <input name="general_service" type="radio" id="level_3" class="with-gap" value="Level 3 Hospital (Teaching/Training)"/>
                                <label for="level_3">Level 3 Hospital (Teaching/Training)</label>
                                <input name="general_service" type="radio" id="level_4" class="with-gap" value="Infirmary"/>
                                <label for="level_4">Infirmary</label>
                            </div>

                            <h2 class="card-inside-title">Trauma Capability:</h2>
                            <div class="demo-radio-button">
                                <input name="trauma_service" type="radio" id="trauma_1" class="with-gap" value="1"/>
                                <label for="trauma_1">Trauma Capable</label>
                                <input name="trauma_service" type="radio" id="trauma_2" class="with-gap" value="2"/>
                                <label for="trauma_2">Trauma Receiving</label>
                            </div>
                            <h2 class="card-inside-title">Specialty: (Specify)</h2>
                            <div class="demo-checkbox">
                                <div class="row clearfix">
                                    <div class="col-md-3">
                                        <input type="checkbox" class="filled-in" id="specialty_1" name="specialty_service_1" onclick="general_class.check_specialty_1()">
                                        <label for="specialty_1">Treats a particular disease</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="txt_specialty_service_1" name="txt_specialty_service_1" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="filled-in" id="specialty_2" name="specialty_service_2" onclick="general_class.check_specialty_2()">
                                        <label for="specialty_2">Treats a particular organ</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="txt_specialty_service_2" name="txt_specialty_service_2" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="filled-in" id="specialty_3" name="specialty_service_3" onclick="general_class.check_specialty_3()">
                                        <label for="specialty_3">Treats a particular organ</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="txt_specialty_service_3" name="txt_specialty_service_3" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" class="filled-in" id="specialty_4" name="specialty_service_4" onclick="general_class.check_specialty_4()">
                                        <label for="specialty_4">Others</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="txt_specialty_service_4" name="txt_specialty_service_4" readonly="readonly">
                                        </div>
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
                        <div class="header">
                            <h2>
                                2. Nature of Ownership
                                <small>* Capability of a hospital/other health facility to render administrative, clinical, ancillary and other services.</small>
                            </h2>
                        </div>
                        
                            <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                   <h2 class="card-inside-title">Government:</h2>
                                <div class="demo-radio-button">
                                    <input name="nature_own" type="radio" id="nature_gov_1" class="with-gap" value="National - DOH Retained/ Renationalized" onclick="general_class.check_nature()"/>
                                    <label for="nature_gov_1">National - DOH Retained/ Renationalized</label><br>
                                    <input name="nature_own" type="radio" id="nature_gov_2" class="with-gap" value="Local" onclick="general_class.check_nature()"/>
                                    <label for="nature_gov_2">Local (Specify):</label><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input name="nature_gov_1" type="radio" id="nature_gov_2_1" class="with-gap radio-col-light-blue" value="Province" disabled/>
                                                            <label for="nature_gov_2_1">Province</label><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input name="nature_gov_1" type="radio" id="nature_gov_2_2" class="with-gap radio-col-light-blue" value="City" disabled/>
                                                            <label for="nature_gov_2_2">City</label><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input name="nature_gov_1" type="radio" id="nature_gov_2_3" class="with-gap radio-col-light-blue" value="Municipality" disabled/>
                                                            <label for="nature_gov_2_3">Municipality</label><br>
                                    <input name="nature_own" type="radio" id="nature_gov_3" class="with-gap" value="DILG - PNP" onclick="general_class.check_nature()"/>
                                    <label for="nature_gov_3">DILG - PNP</label><br>
                                    <input name="nature_own" type="radio" id="nature_gov_4" class="with-gap" value="DND - AFP" onclick="general_class.check_nature()"/>
                                    <label for="nature_gov_4">DND - AFP</label><br>
                                    <input name="nature_own" type="radio" id="nature_gov_5" class="with-gap" value="DOJ" onclick="general_class.check_nature()"/>
                                    <label for="nature_gov_5">DOJ</label><br>
                                    <input name="nature_own" type="radio" id="nature_gov_6" class="with-gap" value="State Universities and Colleges (SUCs)" onclick="general_class.check_nature()"/>
                                    <label for="nature_gov_6">State Universities and Colleges (SUCs)</label><br>
                                    <input name="nature_own" type="radio" id="nature_gov_7" class="with-gap" onclick="general_class.check_nature()"/>
                                    <label for="nature_gov_7">Others (Specify):</label>
                                    <input type="text" class="form-control hidden" id="txt_nature_gov" name="txt_nature_gov"  >
                                </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <h2 class="card-inside-title">Private:</h2>
                                    <div class="demo-radio-button">
                                        <input name="nature_own" type="radio" id="nature_private_1" class="with-gap" value="Single Proprietorship/Partnership/Corporation" onclick="general_class.check_nature()"/>
                                        <label for="nature_private_1">Single Proprietorship/Partnership/Corporation</label><br>
                                        <input name="nature_own" type="radio" id="nature_private_2" class="with-gap" value="Religious" onclick="general_class.check_nature()"/>
                                        <label for="nature_private_2">Religious</label><br>
                                        <input name="nature_own" type="radio" id="nature_private_3" class="with-gap" value="Civic Organization" onclick="general_class.check_nature()"/>
                                        <label for="nature_private_3">Civic Organization</label><br>
                                        <input name="nature_own" type="radio" id="nature_private_4" class="with-gap" value="Foundation" onclick="general_class.check_nature()"/>
                                        <label for="nature_private_4">Foundation</label><br>
                                        <input name="nature_own" type="radio" id="nature_private_5" class="with-gap" onclick="general_class.check_nature()"/>
                                        <label for="nature_private_5">Others (Specify):</label>
                                        <input type="text" class="form-control hidden" id="txt_nature_pri" name="txt_nature_pri" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="row clearfix" id="btns" hidden>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="card">
                         <div class="header">
                            <button type="button" class="btn btn-danger waves-effect btn-block" onclick="general_class.cancel_general_class()">
                                <i class="material-icons">close</i>
                                <span>CLEAR</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="card">
                         <div class="header">
                             <button type="button" class="btn bg-orange waves-effect btn-block" onclick="general_class.save_general_class()">
                                    <i class="material-icons">save</i>
                                    <span>SAVE</span>
                            </button>
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
   var sidemenu = $('#DOH-2-1');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
});
</script>