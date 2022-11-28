<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                     <li><a href="javascript:void(0);"> Death Certificates</a></li>
                    <li class="active">Fetal Death Certificate</li>
                </ol>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                 <i class="material-icons">airline_seat_flat</i> FETAL DEATH CERTIFICATE
                                
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <label style="font-size: 15px;">List of Expired Patients </label>
                                        </div>
                                        <div class="body container-fluid">
                                            <div class="body table-responsive">
                                                <table id="fetal-cert-table" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr style="font-size: 12px;" >
                                                            <th>Account No.</th>
                                                            <th>Patient Name</th>
                                                            <th>Admission</th>
                                                            <th>Room</th>
                                                            <th>Disposition</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <form id="fetal-cert-form">
                                    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                        <div class="panel-group" id="accordion_2" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingOne_2">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseOne_2" aria-expanded="true" aria-controls="collapseOne_2">
                                                            Fetus Information 
                                                        </a>
                                                    </h4>
                                                    <!--<button type="button" onclick="fetaldeath.report()" value="PDF">PDF</button>-->
                                                </div>
                                                <div id="collapseOne_2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_2">
                                                    <div class="panel-body">
                                                        <input type="hidden" class="form-control" id="txtcaseno" name="txtcaseno" hidden />
                                                        <div class="row clearfix">
                                                          <div class="col-sm-12">
                                                            <div class="col-sm-3">
                                                                <label>First Name</label>
                                                                <div class="form-group">
                                                                    <div class="form-line ">
                                                                        <input type="text" class="form-control" name="ffnInput" value="" placeholder="Enter first name" required >
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label>Middle Name</label>
                                                                        <input type="text" class="form-control" name="fmnInput" placeholder="Enter middle name" required>
                                                                    </div>
                                                                   
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label>Last Name</label>
                                                                        <input type="text" class="form-control" name="flnInput" placeholder="Enter last name" required>
                                                                    </div>
                                                               
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label>Gender</label>
                                                                   <select class="form-control show-tick" name="fgender"  id="fgender">
                                                                       <option value="">-- Pick One --</option>
                                                                       <option id="optionMale"   value="Male" > MALE</option>
                                                                       <option id="optionFemale" value="Female">FEMALE</option>
                                                                       <option id="optionUnder" value="Undetermined">UNDETERMINED</option>
                                                                   </select>
                                                                   
                                                                </div>
                                                            </div>
                                                          </div>

                                                            <div class="col-sm-12">
                                                                <div class="col-sm-2">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Date of Delivery </label>
                                                                            <input type="text" name="dldate" class="datepicker form-control" id="dldate" placeholder="Choose date" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <label>Type of Delivery</label>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control show-tick" name="dltype"  id="dltype" onchange="fetaldeath.get_birth_type()">
                                                                                <option value="Single">Single</option>
                                                                                <option value="Twin">Twin</option>
                                                                                <option value="Triplet">Triplet</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group form-float">
                                                                                <div class="form-line">
                                                                                    <input type="text" class="form-control" value="Others" id="txtbirthtype" name="txtbirthtype" disabled>
                                                                                    <label class="form-label">Others </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <label>If multiple birth,fetus was</label>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control show-tick" name="dlorder"  id="dlorder" onchange="fetaldeath.get_multiple_order()">
                                                                                <option value="First">First</option>
                                                                                <option value="Second">Second</option>
                                                                                <option value="Third">Third</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group form-float">
                                                                                <div class="form-line">
                                                                                    <input type="text" class="form-control" value="Others" id="txtmultiplebirth" name="txtmultiplebirth" disabled>
                                                                                    <label class="form-label">Others </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line" >
                                                                            <label>Method of Delivery</label>
                                                                            <input type="text" class="form-control" id="dlmethod" name="dlmethod">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <label>Birth Order </label><small>(live births and fetal deaths including this delivery)</small>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            <select class="form-control show-tick" name="birthorder"  id="birthorder" onchange="fetaldeath.get_birth_order()">
                                                                                <option value="First">First</option>
                                                                                <option value="Second">Second</option>
                                                                                <option value="Third">Third</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group form-float">
                                                                                <div class="form-line">
                                                                                    <input type="text" class="form-control" value="Others" id="txtbirthorder" name="txtbirthorder" disabled>
                                                                                    <label class="form-label">Others </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <label>Weight of Fetus </label><small> (grams)</small>
                                                                            <input type="number" class="form-control" id="fweight" name="fweight">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Place of Delivery </label>
                                                                            <input type="text" class="form-control" placeholder="(Name of Hospital/Clinic/Institution/House No., St., Barangay, City/Municipality, Province)" id="dlPLace" name="dlPLace">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingTwo_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseTwo_2" aria-expanded="false"
                                                           aria-controls="collapseTwo_2">
                                                            Mother Information
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h4>MOTHER INFORMATION  </h4><hr></center>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <label>Maiden Name </label><br>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" placeholder="First Name" id="mfnInput" name="mfnInput">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" placeholder="Middle Name" id="mmnInput" name="mmnInput">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" placeholder="Last Name" id="mlnInput" name="mlnInput">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label> Citizenship </label>
                                                                        <input type="text" class="form-control"  value="FILIPINO" id="mcitizenship" name="mcitizenship">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label>Religion/ Religious Sect </label>
                                                                        <input type="text" class="form-control" id="mreligion" name="mreligion">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label> Occupation </label>
                                                                        <input type="text" class="form-control" id="moccupation" name="moccupation" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label> Age</label><small> at the time of this delivery(completed years)</small>
                                                                        <input type="number" class="form-control" id="mage" name="mage" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <small> Total number of children born alive.</small>
                                                                        <input type="number" class="form-control" id="cba" name="cba" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <small> No. of children still living.</small>
                                                                        <input type="number" class="form-control" id="csl" name="csl" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <small> No. of children born alive but are now dead.</small>
                                                                        <input type="number" class="form-control" id="cbabd" name="cbabd" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <label> Residence </label>
                                                                    <input type="text" class="form-control" placeholder="(House No., St., Barangay, City/Municipality, Province, Country)" id="mresidence" name="mresidence">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingThree_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseThree_2" aria-expanded="false"
                                                           aria-controls="collapseThree_2">
                                                            Father Information
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseThree_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h4>FATHER INFORMATION<hr></center>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <label>Name </label><br>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" placeholder="First Name" id="fafnInput" name="fafnInput">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" placeholder="Middle Name" id="famnInput" name="famnInput">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" placeholder="Last Name" id="falnInput" name="falnInput">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label> Citizenship </label>
                                                                        <input type="text" class="form-control" placeholder="" value="FILIPINO" id="facitizenship" name="facitizenship">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label>Religion/ Religious Sect </label>
                                                                        <input type="text" class="form-control" id="fareligion" name="fareligion">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label> Occupation </label>
                                                                        <input type="text" class="form-control" id="faoccupation" name="faoccupation" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label> Age</label><small> at the time of this delivery(completed years)</small>
                                                                        <input type="text" class="form-control" id="faage" name="faage" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingFour_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseFour_2" aria-expanded="false"
                                                           aria-controls="collapseFour_2">
                                                            Marriage of Parents
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFour_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h4>MARRIAGE OF PARENTS<hr></center>
                                                        </div>
                                                        
                                                            
                                                            <div class="col-sm-4">
                                                                <label>Date </label><br>
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="datepicker form-control"  id="txtmdate" name="txtmdate">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        <div class="col-sm-8">
                                                            <label>Place </label><br>
                                                            <div class="col-sm-4">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                         
                                                                        <input type="text" class="form-control"  id="txtmcity" name="txtmcity">
                                                                       <label class="form-label">City/ Municipality</label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  id="txtmprovince" name="txtmprovince">
                                                                        <label class="form-label">Province</label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  id="txtmcountry" name="txtmcountry">
                                                                        <label class="form-label">Country</label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingFive_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseFive_2" aria-expanded="false"
                                                           aria-controls="collapseFive_2">
                                                            Medical Certificate
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFive_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive_2">
                                                    <div class="panel-body">
                                                       <div class="col-sm-12">
                                                            <center><h4>MEDICAL CERTIFICATE</h4><hr></center>
                                                        </div>
                                                        <div class="col-sm-12">
                                                             <h5>Causes of Fetal Death</h5>
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="acause" name="acause">
                                                                    <label class="form-label">a. Main disease/condition of fetus </label>
                                                                </div>
                                                            </div>
                                                             <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="bcause" name="bcause">
                                                                    <label class="form-label">b. Other disease/condition of fetus</label>
                                                                </div>
                                                            </div>
                                                              <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="ccause" name="ccause">
                                                                    <label class="form-label">c. Main maternal disease/condition affecting fetus</label>
                                                                </div>
                                                            </div>
                                                              <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="dcause" name="dcause">
                                                                    <label class="form-label">d. Other maternal disease/condition affecting fetus</label>
                                                                </div>
                                                            </div>
                                                             <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="ecause" name="ecause">
                                                                    <label class="form-label">e. Other relevant circumstances</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-3">
                                                                <label>Fetus Died:</label>
                                                                <select class="form-control show-tick" id="fdied" name="fdied" >
                                                                    <option value="">-- Pick One --</option>
                                                                    <option value="Before Labor">Before Labor</option>
                                                                    <option value="During Labor/Delivery">During Labor/Delivery</option>
                                                                    <option value="Unknown">Unknown</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label>Length of Pregnancy </label><small> (in completed weeks)</small>
                                                                        <input type="text" class="form-control" id="lpreg" name="lpreg">
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label>21a. Attendant</label>
                                                                <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <select class="form-control show-tick" id="attendant" name="attendant" onchange="fetaldeath.get_attendant()">
                                                                        <option value="">-- Pick One --</option>
                                                                        <option value="Private Physician">Private Physician</option>
                                                                        <option value="Public Health Officer">Public Health Officer</option>
                                                                        <option value="Hospital Authority">Hospital Authority</option>
                                                                        <option value="None">None</option>
                                                                        <option value="Others">OTHERS</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="txtattendant" name="txtattendant" value="N/A" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12" style="text-align:justify;">
                                                            <h5>22. Certification of Death</h5>
                                                            I hereby certify that the foregoing particulars are correct as near as same can be ascertained and I further certify that I
                                                                <input name="cofdattended" type="radio" id="attended_1" checked value="attended" />
                                                                <label for="attended_1">have attended</label> /
                                                                <input name="cofdattended" type="radio" id="attended_2" value="unattended"/>
                                                                <label for="attended_2">have not</label>
                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-5">
                                                                        <br>
                                                                        attended the deceased and that death occurred at
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control"  id="txtdeathtime" name="txtdeathtime">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <br>
                                                                        am/pm on the date of death specified above.
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-6">
                                                                        <select class="form-control show-tick" name="cofdname" id="cofdname" onchange="fetaldeath.reviewedby()">
                                                                            <option value="">-- Name in Print --</option>
                                                                            <?php
                                                                                for($i=0;$i<count($doctors);$i++)
                                                                                    {
                                                                                        echo "<option value='".$doctors[$i]["docname"]."'>".$doctors[$i]["docname"]."</option>";
                                                                                    }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Date" id="cofddate" name="cofddate" value='<?= $cur_date ?>'>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="cofdposition" name="cofdposition">
                                                                                <label class="form-label">Title or Position</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="cofdaddress" id="cofdaddress">
                                                                                <label class="form-label">Address</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="cofdreviewedby" name="cofdreviewedby">
                                                                                <label class="form-label">Reviewed By:</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Reviewed Date" id="cofdrevieweddate" name="cofdrevieweddate">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-8">
                                                                        <h5>23. Corpse Disposal</h5>
                                                                        <div class="col-sm-5">

                                                                            <select class="form-control show-tick" name="disposal"  id="disposal" onchange="fetaldeath.get_corpse_disposal()">
                                                                                <option value="Burial">Burial</option>
                                                                                <option value="Cremation">Cremation</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-7">
                                                                            <div class="form-group form-float">
                                                                                <div class="form-line">
                                                                                    <input type="text" class="form-control" value="Others" id="txtcorpsedisposal" name="txtcorpsedisposal" disabled>
                                                                                    <label class="form-label">Others</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                         <h5>Autopsy</h5>
                                                                        <select class="form-control show-tick" name="autopsy"  id="autopsy" >
                                                                            <option value="YES">YES</option>
                                                                            <option value="NO">NO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <h5>24a. Burial/Cremation Permit </h5>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="burialno" name="burialno">
                                                                                <label class="form-label">Number</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Date Issued" id="burialdateissue" name="burialdateissue">
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h5>24b. Transfer Permit  </h5>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="txttransfernum" name="txttransfernum">
                                                                                <label class="form-label">Number</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Date Issued" id="txttransferdate" name="txttransferdate">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" name="cemeteryaddr" id="cemeteryaddr" >
                                                                            <label class="form-label">25. Name and Address of Cemetery or Crematory </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h5>26. CERTIFICATION OF INFORMANT </h5>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="coiname" name="coiname">
                                                                            <label class="form-label">Name in Print </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="coirelation" name="coirelation">
                                                                            <label class="form-label">Relationship to the Deceased </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="coiaddr" name="coiaddr">
                                                                            <label class="form-label">Address</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="form-line" >
                                                                            <input type="text" class="datepicker form-control" placeholder="Date" id="coidate" name="coidate">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h5>27. PREPARED BY </h5>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="prepname" name="prepname" value="<?= $prep ?>">
                                                                            <label class="form-label">Name in Print </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="prepposition" name="prepposition">
                                                                            <label class="form-label">Title or Position </label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <input type="text" class="datepicker form-control" placeholder="Date" id="prepdate" name="prepdate" value="<?= $cur_date ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-6">
                                                                        <h5>28. RECEIVED BY</h5>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="recname" name="recname" value="<?= strtoupper($profile['deathreceive']) ?>">
                                                                                <label class="form-label">Name in Print </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="rectitle" name="rectitle" value="<?= $profile['deathreceiveposition'] ?>">
                                                                                <label class="form-label">Title or Position </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Date" id="recdate" name="recdate">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingSix_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseSix_2" aria-expanded="false"
                                                           aria-controls="collapseSix_2">
                                                            Postmortem Death Certificate
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseSix_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix_2">
                                                    <div class="panel-body">
                                                       <div class="col-sm-12">
                                                            <center><h4>POSTMORTEM DEATH CERTIFICATE</h4><hr></center>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-sm-1"></div>
                                                            <div class=" col-sm-8 " style="text-align:right;" >
                                                                <p>I HEREBY CERTIFY CERTIFY that I have performed an autopsy upon the body of the deceased this </p>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  name="txtpostmortemday">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 ">
                                                                <p> day of </p>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                         <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  name="txtpostmortemmonth">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-4 " style="text-align:right;" >
                                                                <p>and that the cause of death was as follows </p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="1" class="form-control no-resize auto-growth" name="txtpostmortemcause" id="txtpostmortemcause"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtpostmortemname" name="txtpostmortemname">
                                                                    <label class="form-label">Name in Print </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="datepicker form-control" placeholder="Date" id="txtpostmortemdate" name="txtpostmortemdate">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtpostmortemtitle" name="txtpostmortemtitle">
                                                                    <label class="form-label">Title/ Designation</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" name="txtpostmortemadrs" id="txtpostmortemadrs" >
                                                                    <label class="form-label">Address</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingSeven_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseSeven_2" aria-expanded="false"
                                                           aria-controls="collapseSeven_2">
                                                            Certification of Embalmer
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseSeven_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h4>CERTIFICATION OF EMBALMER</h4><hr></center>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-4">
                                                               I HEREBY CERTIFY that I have embalmed
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" placeholder="Name" name="txtemabalmedpatient">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                following all the regulations prescribed by the Department of Health.
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtembalmername" name="txtembalmername">
                                                                    <label class="form-label">Name in Print </label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtembalmeradrs" name="txtembalmeradrs">
                                                                    <label class="form-label">Address </label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtembalmertitle" name="txtembalmertitle">
                                                                    <label class="form-label">Title/Designation </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="col-sm-12">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtembalmerlicenseno" name="txtembalmerlicenseno" >
                                                                        <label class="form-label">License No. </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="datepicker form-control" placeholder="Issued on" id="txtembalmerissued" name="txtembalmerissued">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtembalmerat" name="txtembalmerat">
                                                                        <label class="form-label">Issued at </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <div class="form-line" >
                                                                        <input type="text" class="datepicker form-control" placeholder="Expiry Date" id="txtembalmerexpiry" name="txtembalmerexpiry">
                                                                    </div>
                                                                </div>
                                                              </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingEight_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseEight_2" aria-expanded="false"
                                                           aria-controls="collapseEight_2">
                                                            Affidavit of Delayed Registration of Death
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseEight_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h4>AFFIDAVIT OF DELAYED REGISTRATION OF DEATH</h4><hr></center>
                                                            <button type="button" class="btn btn-success waves-effect" onclick="fetaldeath.importdata()">
                                                                <i class="material-icons">file_download</i>
                                                                <span>IMPORT DATA</span>
                                                            </button>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-1" style="text-align:right;">
                                                                <label>I,</label>
                                                            </div>
                                                            <div class="col-sm-4 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  name="txtaffname" placeholder="Affiant Name">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-7 ">
                                                                <label>of legal age, single/married/divorced/widow/widower, with residence and postal address</label>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-sm-6 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  name="txtaffadrs" placeholder="Affiant Address">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-6 ">
                                                                <label>after being duly sworn in accordance with law, do hereby depose and say:</label>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-2 " style="text-align:right;">
                                                                <label>1. That </label>
                                                            </div>
                                                            <div class="col-sm-4 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  name="txtaffdiedname">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 ">
                                                                <label>died on </label>
                                                            </div>
                                                            <div class="col-sm-4 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="datepicker form-control"  name="txtaffdieddate">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 ">
                                                                <label>in </label>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-sm-9 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  name="txtaffdiedaddr">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-3 ">
                                                                <label>and was buried/cremated in</label>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-sm-8 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control"  name="affburiedadd">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 ">
                                                                <br>
                                                                <label>on</label>
                                                            </div>
                                                            <div class=" col-sm-3 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="datepicker form-control"  name="txtaffburieddate">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-1 " style="text-align:right;">

                                                            </div>
                                                            <div class="col-sm-10 ">
                                                                <label>&nbsp;&nbsp;&nbsp;2. That the deceased at the time of his/her death:</label>
                                                            </div>

                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-1 " style="text-align:right;"></div>
                                                            <div class="col-sm-2 ">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                               <input type="radio" name="txtaffattended" id="optionsattend" value="attend"  />
                                                               <label for="optionsattend">was attended by</label> <br>
                                                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                               <input type="radio" name="txtaffattended" id="optionsunattend" value="unattend" />
                                                                <label for="optionsunattend">was not attended.</label>
                                                            </div>
                                                            <div class="col-sm-5 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text"  class="form-control"  name="affattendedby">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 ">
                                                                 <label>;</label>
                                                            </div>
                                                        </div>
                                                         <div class="row clearfix">
                                                            <div class=" col-sm-1 " style="text-align:right;"></div>
                                                            <div class="col-sm-4 ">
                                                               3. That the cause of death of the deceased was
                                                            </div>
                                                            <div class="col-sm-6 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text"  class="form-control" name="txtaffcod">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 " >.</div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-1 " style="text-align:right;"></div>
                                                            <div class="col-sm-6 ">
                                                               4. That the reason for the delay in registering this fetal death was due to
                                                            </div>
                                                            <div class="col-sm-4 ">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" name="txtaffdelaycause">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 " >.</div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-1 " style="text-align:right;"></div>
                                                            <div class="col-sm-11 ">
                                                               5. That I am executing this affidavit to attest to the truthfulness of the foregoing statements for all legal intents and purposes.
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-5 " style="text-align:right;">
                                                                <br>In the truth whereof, I have affixed my signature below this
                                                            </div>
                                                            <div class=" col-sm-1 " >
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text"  class="form-control" name="txtaffday" id="txtaffday">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 " >
                                                                <br><p>day of</p>
                                                            </div>
                                                            <div class=" col-sm-2 " >
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" name="txtaffmonth">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-1 " >
                                                                <br>
                                                                <p>,</p>
                                                            </div>
                                                            <div class=" col-sm-2 " >
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" name="txtaffyear">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class=" col-sm-1 " style="text-align:right;">
                                                                <br><p>at</p>
                                                            </div>
                                                            <div class=" col-sm-9 " >
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" name="txtaffadd">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-2 " >
                                                                <br><p>, Philippines.</p>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">

                                                            <div class=" col-sm-12 " >
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text"  class="form-control" name="txtaffaffiant" id="txtaffaffiant" style="text-align:center;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" col-sm-12 " >
                                                                <p><center>(Printed Name of Affiant)</center></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <button type="button" class="btn bg-red waves-effect btn-lg" onclick="fetaldeath.cancel();">
                                                <i class="material-icons">close</i>
                                                <span>CANCEL</span>
                                            </button>
                                            <button type="button" class="btn bg-green waves-effect pull-right btn-lg" onclick="fetaldeath.validate_form();">
                                                <i class="material-icons">save</i>
                                                <span>SAVE</span>
                                            </button>
                                        </div>
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

<?php $this->load->view('pages/modals/fetchLoader'); ?>
<?php $this->load->view('pages/modals/admittedpatientday'); ?>
<?php $this->load->view('pages/modals/eachDayPatCensus'); ?>
<?php $this->load->view('pages/modals/philhealthpatients'); ?>
<?php $this->load->view('pages/modals/totalpatients'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    var sidemenu = $('#death-0-2');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    
//    load_script("http://192.168.1.100:3777/nurseV2/assets/vendors/js/responsive.js",3,0);
    
        fetaldeath.get_patientlist();
    
//    
//    chart.create_chart();
//    chart.monthly_census_chart();
        $('#fetal-cert-form input[name=txtaffname]').keyup(function(){
//        alert($(this).val());
         $('#txtaffaffiant').val($(this).val().toUpperCase());
    })
    
       $('#fetal-cert-form input[name=acause]').keyup(function(){
//        alert($(this).val());
         $('#txtpostmortemcause').val($(this).val());
    })
    
});
</script>















