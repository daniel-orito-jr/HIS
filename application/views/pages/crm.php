<body class="theme-cyan">
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-transform: uppercase;">
                    Customer Relationship Management
                </h2>
            </div>
            <div class="row clearfix d-none">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="generate-crm-data-sheet-form" action="<?= base_url("Dashboard/CRMGeneratedData") ?>" method="POST" target="_blank" >
                        <input type="hidden" name="hiddenname_genderxparameter">
                        <input type="hidden" name="hiddenname_agexxxxparameter">
                        <input type="hidden" name="hiddenname_cityaddparameter">
                        <input type="hidden" name="hiddenname_provaddparameter">
                        <input type="hidden" name="hiddenname_insuranparameter">
                        <input type="hidden" name="hiddenname_roomoccparameter">
                        <input type="hidden" name="hiddenname_volreqxparameter">
                        <input type="hidden" name="hiddenname_selectedmonthxxx">
                        <input type="hidden" name="hiddenname_selectedpxtypexx">
                    </form>
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
                        <div class="row clearfix" style="padding-left:20px;padding-right:20px">
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="row clearfix" style="padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:15px;">
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class='input-group' style="padding-left:10px;padding-right:10px;padding-top:0px;">
                                            <div class="form-line">
                                                <input type="month" class="form-control form-control-sm"  id="monthid_coveredDate" name="monthname_coveredDate" value="<?= $lastmonth ?>" onchange="getInpatientOverAllStatistics()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <select class="form-control show-tick" id="selectid_patienttype"  onchange="getInpatientOverAllStatistics()">
                                            <option value="ALL">ALL</option>
                                            <option value="IPD">IPD</option>
                                            <option value="OPD">OPD</option>
                                        </select>
                                    </div>
                                </div>      
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <button onclick="generateAllCRMResultsIntoPDF()" type="button" class="btn bg-purple waves-effect" style="margin-top:30px;margin-right:20px;float:right">
                                    <span>Generate Results</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2>GENDER CATEGORY</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div style="padding-left:10px;">
                                        <label>&nbsp;&nbsp;Total: </label> <b><u onclick="showAllPatientUnderSexCateg('ALL')"> <span id="totalPatientViaGender"></span></u></b>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label style="color:rgba(0, 188, 212, 0.8);" onclick="showAllPatientUnderSexCateg('MALE')">&#9635; MALE: 
                                                <u><span id="MALETotal"></span></u>
                                            </label><br>
                                            <label style="color:rgba(233, 30, 99, 0.8);" onclick="showAllPatientUnderSexCateg('FEMALE')">&#9635; FEMALE: 
                                                <u><span id="FEMALETotal"></span></u>
                                            </label><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div id="inpatient_stat_sex_category_donut_chart" class="graph"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2>AGE CATEGORY</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div>
                                        <label>&nbsp;&nbsp;Total: </label> <b><u onclick="showAllPatientUnderAgeCateg('ALL')"> <span id="totalPatientViaAge"></span></u></b>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label style="color:rgba(0, 188, 212, 0.8);" onclick="showAllPatientUnderAgeCateg('INFANT')">&#9635; INFANT (0-3 Yrs.): 
                                                <u><span id="InfantTotal"></span></u>
                                            </label><br>
                                            <label style="color:rgba(233, 30, 99, 0.8);" onclick="showAllPatientUnderAgeCateg('CHILD')">&#9635; CHILD (3-11 Yrs.):
                                                <u><span id="ChildTotal"></span></u>
                                            </label><br>
                                            <label style="color:rgba(70, 150, 42, 0.8);" onclick="showAllPatientUnderAgeCateg('YOUTH')">&#9635; YOUTH (11-25 Yrs.):
                                                <u><span id="YouthTotal"></span></u>
                                            </label><br>
                                            <label style="color:rgba(62, 86, 205, 0.8);" onclick="showAllPatientUnderAgeCateg('ADULT')">&#9635; ADULT (25-60 Yrs.):
                                                <u><span id="AdultTotal"></span></u>
                                            </label><br>
                                            <label style="color:rgba(255, 117, 2, 0.8);" onclick="showAllPatientUnderAgeCateg('SENIOR')">&#9635; SENIOR (60 Yrs.Up): 
                                                <u><span id="SeniorTotal"></span></u>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <canvas id="inpatient_stat_age_category_pie_chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-cyan">
                            <h2>CITY/MUNICIPALITY CATEGORY&nbsp;&nbsp;&nbsp;<span class="badge bg-orange">TOP 10</span></h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:0px;padding-right:0px;">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <label onclick="showAllPatientUnderMunicipality(null,null,null,null,'ALL TYPE')">&nbsp;&nbsp;Total:  
                                            <b><u> <span id="totalPatientViaCityMun"></span></u></b>
                                        </label><br><br>
                                        <div class="col-md-12"  >
                                            <label style="color:rgba(0, 188, 212, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex0').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex0"></b><u><span id="CityAddValue0"></span></u>
                                            </label><br>
                                            <label style="color:rgba(233, 30, 99, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex1').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex1"></b><u><span id="CityAddValue1"></span></u>
                                            </label><br>
                                            <label style="color:rgba(70, 150, 42, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex2').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex2"></b><u><span id="CityAddValue2"></span></u>
                                            </label><br>
                                            <label style="color:rgba(62, 86, 205, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex3').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex3"></b><u><span id="CityAddValue3"></span></u>
                                            </label><br>
                                            <label style="color:rgba(221, 159, 5, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex4').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex4"></b><u><span id="CityAddValue4"></span></u>
                                            </label><br>
                                            <label style="color:rgba(174, 2, 255, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex5').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex5"></b><u><span id="CityAddValue5"></span></u>
                                            </label><br>
                                            <label style="color:rgba(129, 69, 47, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex6').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex6"></b><u><span id="CityAddValue6"></span></u>
                                            </label><br>
                                            <label style="color:rgba(252, 2, 222, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex7').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex7"></b><u><span id="CityAddValue7"></span></u>
                                            </label><br>
                                            <label style="color:rgba(5, 146, 221, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex8').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex8"></b><u><span id="CityAddValue8"></span></u>
                                            </label><br>
                                            <label style="color:rgba(254, 74, 11, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamex9').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamex9"></b><u><span id="CityAddValue9"></span></u>
                                            </label><br>
                                            <label style="color:rgba(120, 120, 1, 0.8);" onclick="showAllPatientUnderMunicipality($('#CityAddNamexO').text(),null,null,null,'TXT TYPE')">
                                                <b id="CityAddNamexO"></b><u><span id="CityAddValueO"></span></u>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <div id="inpatient_stat_citymun_category_bar_chart" class="graph shadow-effect" style="background:#D5ECCA;border-radius:5px;"></div>
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
                        <div class="header bg-cyan">
                            <h2>PROVINCE CATEGORY&nbsp;&nbsp;&nbsp;<span class="badge bg-orange">TOP 10</span></h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:0px;padding-right:0px;">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <label onclick="showAllPatientUnderProvince(null,null,null,null,'ALL TYPE')">&nbsp;&nbsp;Total:  
                                            <b><u> <span id="totalPatientViaProvince"></span></u></b>
                                        </label><br><br>
                                        <div class="col-md-12"  >
                                            <label style="color:rgba(0, 188, 212, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex0').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex0"></b><u><span id="ProvAddValue0"></span></u>
                                            </label><br>
                                            <label style="color:rgba(233, 30, 99, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex1').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex1"></b><u><span id="ProvAddValue1"></span></u>
                                            </label><br>
                                            <label style="color:rgba(70, 150, 42, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex2').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex2"></b><u><span id="ProvAddValue2"></span></u>
                                            </label><br>
                                            <label style="color:rgba(62, 86, 205, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex3').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex3"></b><u><span id="ProvAddValue3"></span></u>
                                            </label><br>
                                            <label style="color:rgba(221, 159, 5, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex4').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex4"></b><u><span id="ProvAddValue4"></span></u>
                                            </label><br>
                                            <label style="color:rgba(174, 2, 255, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex5').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex5"></b><u><span id="ProvAddValue5"></span></u>
                                            </label><br>
                                            <label style="color:rgba(129, 69, 47, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex6').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex6"></b><u><span id="ProvAddValue6"></span></u>
                                            </label><br>
                                            <label style="color:rgba(252, 2, 222, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex7').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex7"></b><u><span id="ProvAddValue7"></span></u>
                                            </label><br>
                                            <label style="color:rgba(5, 146, 221, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex8').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex8"></b><u><span id="ProvAddValue8"></span></u>
                                            </label><br>
                                            <label style="color:rgba(254, 74, 11, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamex9').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamex9"></b><u><span id="ProvAddValue9"></span></u>
                                            </label><br>
                                            <label style="color:rgba(120, 120, 1, 0.8);" onclick="showAllPatientUnderProvince($('#ProvAddNamexO').text(),null,null,null,'TXT TYPE')">
                                                <b id="ProvAddNamexO"></b><u><span id="ProvAddValueO"></span></u>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <div id="inpatient_stat_province_category_bar_chart" class="graph shadow-effect" style="background:#F4DEC7;border-radius:5px;"></div>
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
                        <div class="header bg-cyan">
                            <h2>HMO/INSURANCE CATEGORY&nbsp;&nbsp;&nbsp;<span class="badge bg-orange">TOP 10</span>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:0px;padding-right:0px;">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <label onclick="showAllPatientUnderInsurance(null,null,null,null,'ALL TYPE')">&nbsp;&nbsp;Total: 
                                            <b><u> <span id="totalPatientViaInsurance"></span></u></b>
                                        </label><br><br>
                                        <div class="col-md-12"  >
                                            <label style="color:rgba(0, 188, 212, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex0').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex0"></b><u><span id="InsuranceValue0"></span></u>
                                            </label><br>
                                            <label style="color:rgba(233, 30, 99, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex1').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex1"></b><u><span id="InsuranceValue1"></span></u>
                                            </label><br>
                                            <label style="color:rgba(70, 150, 42, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex2').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex2"></b><u><span id="InsuranceValue2"></span></u>
                                            </label><br>
                                            <label style="color:rgba(62, 86, 205, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex3').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex3"></b><u><span id="InsuranceValue3"></span></u>
                                            </label><br>
                                            <label style="color:rgba(221, 159, 5, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex4').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex4"></b><u><span id="InsuranceValue4"></span></u>
                                            </label><br>
                                            <label style="color:rgba(174, 2, 255, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex5').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex5"></b><u><span id="InsuranceValue5"></span></u>
                                            </label><br>
                                            <label style="color:rgba(129, 69, 47, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex6').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex6"></b><u><span id="InsuranceValue6"></span></u>
                                            </label><br>
                                            <label style="color:rgba(252, 2, 222, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex7').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex7"></b><u><span id="InsuranceValue7"></span></u>
                                            </label><br>
                                            <label style="color:rgba(5, 146, 221, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex8').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex8"></b><u><span id="InsuranceValue8"></span></u>
                                            </label><br>
                                            <label style="color:rgba(254, 74, 11, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamex9').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamex9"></b><u><span id="InsuranceValue9"></span></u>
                                            </label><br>
                                            <label style="color:rgba(120, 120, 1, 0.8);" onclick="showAllPatientUnderInsurance($('#InsuranceNamexO').text(),null,null,null,'TXT TYPE')">
                                                <b id="InsuranceNamexO"></b><u><span id="InsuranceValueO"></span></u>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <div id="inpatient_stat_insurance_category_bar_chart" class="graph shadow-effect" style="background:#B6F7F4;border-radius:5px;"></div>
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
                        <div class="header bg-cyan">
                            <h2>ROOM OCCUPANCY RATE&nbsp;&nbsp;&nbsp;<span class="badge bg-orange">TOP 10</span>&nbsp;&nbsp;&nbsp;<span id="spanid_onlyindication" class="badge bg-orange"></span></h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:0px;padding-right:0px;">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <label onclick="showAllPatientUnderRoomrate(null,null,null,null,'ALL TYPE')">&nbsp;&nbsp;Total: 
                                            <b><u> <span id="totalPatientViaRoomOccupancyRate"></span></u></b>
                                        </label><br><br>
                                        <div class="col-md-12"  >
                                            <label style="color:rgba(0, 188, 212, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex0').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex0"></b><u><span id="RoomOccRateValue0"></span></u>
                                            </label><br>
                                            <label style="color:rgba(233, 30, 99, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex1').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex1"></b><u><span id="RoomOccRateValue1"></span></u>
                                            </label><br>
                                            <label style="color:rgba(70, 150, 42, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex2').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex2"></b><u><span id="RoomOccRateValue2"></span></u>
                                            </label><br>
                                            <label style="color:rgba(62, 86, 205, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex3').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex3"></b><u><span id="RoomOccRateValue3"></span></u>
                                            </label><br>
                                            <label style="color:rgba(221, 159, 5, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex4').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex4"></b><u><span id="RoomOccRateValue4"></span></u>
                                            </label><br>
                                            <label style="color:rgba(174, 2, 255, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex5').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex5"></b><u><span id="RoomOccRateValue5"></span></u>
                                            </label><br>
                                            <label style="color:rgba(129, 69, 47, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex6').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex6"></b><u><span id="RoomOccRateValue6"></span></u>
                                            </label><br>
                                            <label style="color:rgba(252, 2, 222, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex7').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex7"></b><u><span id="RoomOccRateValue7"></span></u>
                                            </label><br>
                                            <label style="color:rgba(5, 146, 221, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex8').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex8"></b><u><span id="RoomOccRateValue8"></span></u>
                                            </label><br>
                                            <label style="color:rgba(254, 74, 11, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamex9').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamex9"></b><u><span id="RoomOccRateValue9"></span></u>
                                            </label><br>
                                            <label style="color:rgba(120, 120, 1, 0.8);" onclick="showAllPatientUnderRoomrate($('#RoomOccRateNamexO').text(),null,null,null,'TXT TYPE')">
                                                <b id="RoomOccRateNamexO"></b><u><span id="RoomOccRateValueO"></span></u>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <div id="inpatient_stat_room_occupancy_rate_category_bar_chart" class="graph shadow-effect" style="background:#E9CAEC;border-radius:5px;"></div>
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
                        <div class="header bg-cyan">
                            <h2>VOLUME OF REQUEST</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left:0px;padding-right:0px;">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <label>&nbsp;&nbsp;Total: </label> <b><u> <span id="totalPatientViaRequestVolume"></span></u></b><br><br>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label style="color:rgba(70, 150, 42, 0.8);">&#9635; LABORATORY: <u><span id="LabTotal"></span></u></label><br>
                                            <label style="color:rgba(62, 86, 205, 0.8);">&#9635; RADIOLOGY: <u><span id="RadTotal"></span></u></label><br>
                                            <label style="color:rgba(255, 117, 2, 0.8);">&#9635; PHARMACY: <u><span id="PhaTotal"></span></u></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div style="padding-left:10px;padding-right:10px;">
                                        <div id="inpatient_stat_request_volume_category_bar_chart" class="graph shadow-effect" style="background:#B5D6F0;border-radius:5px;"></div>
                                    </div>
                                </div>
                            </div>
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

<?php $this->load->view('pages/modals/crmpxviamunicipal'); ?>
<?php $this->load->view('pages/modals/crmpxviaprovince'); ?>
<?php $this->load->view('pages/modals/crmpxviaroomrate'); ?>
<?php $this->load->view('pages/modals/crmpxagecategory'); ?>
<?php $this->load->view('pages/modals/crmpxsexcategory'); ?>
<?php $this->load->view('pages/modals/crmpxviainsurance'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () 
    {
        $('#menu-crm').removeClass().addClass('active');
    });
</script>