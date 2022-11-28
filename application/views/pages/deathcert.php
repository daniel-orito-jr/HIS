<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                     <li><a href="javascript:void(0);"> Death Certificates</a></li>
                    <li class="active">Death Certificate</li>
                </ol>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                 <i class="material-icons">airline_seat_flat</i> DEATH CERTIFICATE
                                
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
                                                <table id="death-cert-table" class="table table-bordered table-striped table-hover">
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
                                <form id="death-cert-form">
                                    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                        <div class="panel-group" id="accordion_2" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-success">
                                                <div class="panel-heading" role="tab" id="headingOne_2">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseOne_2" aria-expanded="true" aria-controls="collapseOne_2">
                                                            General Information
                                                        </a>
                                                    </h4>
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
                                                                        <input type="text" class="form-control" id="txtfirstname" name="txtfname" >
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label>Middle Name</label>
                                                                        <input type="text" class="form-control" id="txtmiddlename" name="txtmname">
                                                                    </div>
                                                                   
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label>Last Name</label>
                                                                        <input type="text" class="form-control" id="txtlastname" name="txtlname">
                                                                    </div>
                                                               
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label>Gender</label>
                                                                   <select class="form-control show-tick" name="cmbgender"  id="cmbgender">
                                                                       <option value="">-- Pick One --</option>
                                                                       <option id="optionMale"   value="Male" > MALE</option>
                                                                       <option id="optionFemale" value="Female">FEMALE</option>
                                                                   </select>
                                                                   
                                                                </div>
                                                            </div>
                                                          </div>

                                                            <div class="col-sm-12">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>4. Date of Death </label>
                                                                            <input type="text" class="datepicker form-control" placeholder="Please choose a date..." id="txtdeathdate"  name="txtdeathdate">
                                                                        </div>
                                                                    
                                                                    </div>
                                                                    
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>4. Date of Birth </label>
                                                                            <input type="text" class="datepicker form-control" placeholder="Please choose a date..." id="txtbirthdate" name="txtbirthdate">
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label>5. Age at the time of death </label><br>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Years" name="txtageyears" >
                                                                            </div>
                                                                      
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Months" name="txtmonths">
                                                                            </div>
                                                                         
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Days" name="txtdays" >
                                                                            </div>
                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Hours" name="txthours">
                                                                            </div>
                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Min/Sec" name="txtminsec">
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-8">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <label>Place of Death </label>
                                                                                <input type="text" class="form-control" placeholder="(Name of Hospital/Clinic/Institution/House No., St., Barangay, City/Municipality, Province)" id="txtdeathplace" name="txtdeathplace">
                                                                            </div>
                                                                         
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label>Civil Status </label>
                                                                            <select class="form-control show-tick" name="txtcivilstatus"  id="txtcivilstatus">
                                                                                <option value="">-- Pick One --</option>
                                                                                <option id="optionSingle" value="SINGLE" >SINGLE</option>
                                                                                <option id="optionMarried" value="MARRIED">MARRIED</option>
                                                                                <option id="optionWidow" value="WIDOW">WIDOW</option>
                                                                                <option id="optionWidower" value="WIDOWER">WIDOWER</option>
                                                                                <option id="optionAnnulled" value="ANNULLED">ANNULLED</option>
                                                                                <option id="optionDivorced" value="DIVORCED">DIVORCED</option>
                                                                            </select>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Religion/ Religious Sect </label>
                                                                            <input type="text" class="form-control" id="txtreligion" name="txtreligion">
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label> Citizenship </label>
                                                                            <input type="text" class="form-control" placeholder="" value="FILIPINO" id="txtcitizenship" name="txtcitizenship">
                                                                        </div>
                                                                         
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label> Residence </label>
                                                                            <input type="text" class="form-control" placeholder="(House No., St., Barangay, City/Municipality, Province, Country)" id="txtresidence" name="txtresidence">
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label> Occupation </label>
                                                                            <input type="text" class="form-control" id="txtoccupation" name="txtoccupation" >
                                                                        </div>
                                                                         
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <label>Father Information </label><br>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="First Name" id="txtfatfname" name="txtfatfname">
                                                                            </div>
                                                                             
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Middle Name" id="txtfatmname" name="txtfatmname">
                                                                            </div>
                                                                             
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Last Name" id="txtfatlname" name="txtfatlname">
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-5">
                                                                    <label>Mother Information </label><br>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="First Name" id="txtmotfname" name="txtmotfname">
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Middle Name" id="txtmotmname" name="txtmotmname">
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" placeholder="Last Name" id="txtmotlname" name="txtmotlname">
                                                                            </div>
                                                                            
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
                                                            Medical Certificate <span> (0 to 7 days) </span>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h3>MEDICAL CERTIFICATE</h3><small>(For ages 0 to 7 days, accomplish items 14-19a at the back)</small><hr></center>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <h5>19b. CAUSES OF DEATH (If the deceased is aged 8 days and over)</h5>
                                                        </div>

                                                        <div class="col-sm-12">
                                                           <div class="col-sm-2" >
                                                               <p style="text-align: left;">I. Immediate cause: a.</p>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathimmediatecause" name="txtdeathimmediatecause">
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-3">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathimmediatecauseinterval" name="txtdeathimmediatecauseinterval">
                                                                        <label class="form-label">Interval Between Onset and Death</label>
                                                                    </div>
                                                                     
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                           <div class="col-sm-2" >
                                                               <p style="text-align: left;">Antecedent cause : b.</p>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathantecedentcause" name="txtdeathantecedentcause">
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-3">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathantecedentcauseinterval" name="txtdeathantecedentcauseinterval">
                                                                        <label class="form-label">Interval Between Onset and Death</label>
                                                                    </div>
                                                                 
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="col-sm-2" >
                                                               <p style="text-align: left;">Underlying cause : c.</p>
                                                            </div> 
                                                            <div class="col-sm-6" >
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathunderlyingcause" name="txtdeathunderlyingcause">
                                                                    </div>
                                                               
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-3">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathunderlyingcauseinterval" name="txtdeathunderlyingcauseinterval">
                                                                        <label class="form-label">Interval Between Onset and Death</label>
                                                                    </div>
                                                         
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-5" >
                                                               <p style="text-align: left;">II. Other significant conditions contributing to death:</p>
                                                            </div> 
                                                            <div class="col-sm-7" >
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathsigcondition" name="txtdeathsigcondition">
                                                                    </div>
                                                                </div>

                                                            </div> 
                                                             <hr>
                                                        </div>

                                                       <div class="col-sm-12">
                                                           <div class="col-sm-7">
                                                                <h5>19c. Maternal Condition(If the deceased is female aged 15-49 years old)</h5>
                                                                <select class="form-control show-tick" name="maternal" id="maternal">
                                                                    <option name="maternal" value="">-- Pick One --</option>
                                                                    <option name="maternal" value="pregnant, not in labour" >pregnant, not in labour</option>
                                                                    <option name="maternal" value="pregnant, in labour">pregnant, in labour</option>
                                                                    <option name="maternal" value="less than 42 days after delivery">less than 42 days after delivery</option>
                                                                    <option name="maternal" value="42 days to 1 year after delivery">42 days to 1 year after delivery</option>
                                                                    <option name="maternal" value="None of the choices">None of the choices</option>
                                                                </select>
                                                            </div>

                                                           <div class="col-sm-5">
                                                                <h5>20. Autopsy</h5>
                                                                <select class="form-control show-tick" name="cmbautopsy"  id="cmbautopsy">
                                                                    <option value="">-- Pick One --</option>
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>

                                                                </select>
                                                            </div>
                                                           <hr>
                                                       </div>
                                                        <div class="col-sm-12">
                                                            <h5>19d. DEATH BY EXTERNAL CAUSES</h5>
                                                            <p>a. Manner of Death</p>

                                                            <div class="col-sm-3" >
                                                                <select class="form-control show-tick" name="cmbdeathmanner"  id="cmbdeathmanner" onchange="deathcert.get_death_manner()">
                                                                    <option value="HOMICIDE">HOMICIDE</option>
                                                                    <option value="SUICIDE">SUICIDE</option>
                                                                    <option value="ACCIDENT">ACCIDENT</option>
                                                                    <option value="LEGAL INTERVENTION">LEGAL INTERVENTION</option>
                                                                    <option value="Others">OTHERS</option>
                                                                </select>
                                                            </div> 
                                                            <div class="col-sm-9">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathmanner" name="txtdeathmanner" value="N/A"  disabled >

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p>b. Place of Occurrence of External Cause</p>
                                                            <div class="col-sm-3" >
                                                                <select class="form-control show-tick" name="cmbdeathplacex"  id="cmbdeathplacex" onchange="deathcert.get_death_place()">
                                                                    <option value="HOME">HOME</option>
                                                                    <option value="FARM">FARM</option>
                                                                    <option value="FACTORY">FACTORY</option>
                                                                    <option value="STREET">STREET</option>
                                                                    <option value="SEA">SEA</option>
                                                                    <option value="Others">OTHERS</option>
                                                                </select>
                                                            </div> 
                                                            <div class="col-sm-9">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtdeathplacex" name="txtdeathplacex" value="N/A" disabled>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                           <div class="col-sm-5">
                                                                <h5>21a. Attendant</h5>
                                                                <select class="form-control show-tick" id="attendant" name="attendant" onchange="deathcert.get_attendant()">
                                                                    <option value="">-- Pick One --</option>
                                                                    <option value="Private Physician">Private Physician</option>
                                                                    <option value="Public Health Officer">Public Health Officer</option>
                                                                    <option value="Hospital Authority">Hospital Authority</option>
                                                                    <option value="None">None</option>
                                                                    <option value="Others">OTHERS</option>
                                                                </select>
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" id="txtattendant" name="txtattendant" value="N/A" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <h5>21b. If attended, state duration</h5>
                                                                <div class="col-sm-6" >
                                                                    <div class="col-sm-3" >
                                                                        <div class="form-group">
                                                                            <br>
                                                                            <p>From:</p>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="col-sm-9" >
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="From" id="durationfrom" name="durationfrom">
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div> 
                                                                <div class="col-sm-6">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <br>
                                                                            <p>To:</p>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="col-sm-9" >
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="To" id="durationto" name="durationto">
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12" style="text-align:justify;">
                                                            <h5>22. Certification of Death</h5>
                                                            I hereby certify that the foregoing particulars are correct as near as same can be ascertained and I further certify that I
                                                                <input name="attended" type="radio" id="attended_1" checked value="attended" />
                                                                <label for="attended_1">have attended</label> /
                                                                <input name="attended" type="radio" id="attended_2" value="unattended"/>
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
                                                                        <select class="form-control show-tick" name="txtdeathcertname" id="txtdeathcertname" onchange="deathcert.reviewedby()">
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
                                                                                <input type="text" class="datepicker form-control" placeholder="Date" id="txtdeathcertdate" name="txtdeathcertdate" value='<?= $cur_date ?>'>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="txtdeathcerttitle" name="txtdeathcerttitle">
                                                                                <label class="form-label">Title or Position</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="txtdeathcertadrs" id="deathcertadrs">
                                                                                <label class="form-label">Address</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="txtdeathcertrevby" name="txtdeathcertrevby">
                                                                                <label class="form-label">Reviewed By:</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Reviewed Date" id="txtdeathcertrevdate" name="txtdeathcertrevdate">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <h5>23. Corpse Disposal</h5>
                                                                    <div class="col-sm-4">
                                                                        <select class="form-control show-tick" name="cmbcorpsedisposal"  id="cmbcorpsedisposal" onchange="deathcert.get_corpse_disposal()">
                                                                            <option value="Burial">Burial</option>
                                                                            <option value="Cremation">Cremation</option>
                                                                            <option value="Others">Others</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" value="Others" id="txtcorpsedisposal" name="txtcorpsedisposal" disabled>
                                                                                <label class="form-label">Others</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <h5>24a. Burial/Cremation Permit </h5>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="txtburialnum" name="txtburialnum">
                                                                                <label class="form-label">Number</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Date Issued" id="txtburialdate" name="txtburialdate">
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
                                                                            <input type="text" class="form-control" name="txtcemeteryname" id="txtcemeteryname" >
                                                                            <label class="form-label">25. Name and Address of Cemetery or Crematory </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h5>26. CERTIFICATION OF INFORMANT </h5>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="txtinformname" name="txtinformname">
                                                                            <label class="form-label">Name in Print </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="txtinformrel" name="txtinformrel">
                                                                            <label class="form-label">Relationship to the Deceased </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="txtinforadrs" name="txtinformadrs">
                                                                            <label class="form-label">Address</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="form-line" >
                                                                            <input type="text" class="datepicker form-control" placeholder="Date" id="txtinfordate" name="txtinformdate"">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h5>27. PREPARED BY </h5>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="txtprepname" name="txtprepname" value="<?= $prep ?>">
                                                                            <label class="form-label">Name in Print </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" id="txtpreptitle" name="txtpreptitle">
                                                                            <label class="form-label">Title or Position </label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <input type="text" class="datepicker form-control" placeholder="Date" id="txtprepdate" name="txtprepdate" value="<?= $cur_date ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-6">
                                                                        <h5>28. RECEIVED BY</h5>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="txtrecname" name="txtrecname" value="<?= strtoupper($profile['deathreceive']) ?>">
                                                                                <label class="form-label">Name in Print </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" id="txtrectitle" name="txtrectitle" value="<?= $profile['deathreceiveposition'] ?>">
                                                                                <label class="form-label">Title or Position </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <input type="text" class="datepicker form-control" placeholder="Date" id="txtrecdate" name="txtrecdate">
                                                                            </div>
                                                                        </div>
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
                                                            Children <span> (aged 0 to 7 days) </span>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseThree_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h4>CHILDREN</h4><small>(aged 0 to 7 days)</small><hr></center>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtmotherage" name="txtmotherage">
                                                                    <label class="form-label">14. AGE OF MOTHER  </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group form-float">
                                                                <div class="form-line" >
                                                                    <input type="text" class="form-control" id="txtmethodofdel" name="txtmethodofdel">
                                                                    <label class="form-label">15. METHOD OF DELIVERY </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtpregnantlength" name="txtpregnantlength">
                                                                    <label class="form-label">16. LENGTH OF PREGNANCY </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h5>17. TYPE OF BIRTH </h5>
                                                            <div class="col-sm-4">
                                                                <select class="form-control show-tick" name="cmbbirthtype"  id="cmbbirthtype" onchange="deathcert.get_birth_type()">
                                                                    <option value="Single">Single</option>
                                                                    <option value="Twin">Twin</option>
                                                                    <option value="Triplet">Triplet</option>
                                                                    <option value="Others">Others</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-8">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" value="Others" id="txtbirthtype" name="txtbirthtype" disabled>
                                                                    <label class="form-label">Others </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h5>18. IF MULTIPLE BIRTH,CHILD WAS </h5>
                                                            <div class="col-sm-4">
                                                                <select class="form-control show-tick" name="cmbmultiplebirth"  id="cmbmultiplebirth" onchange="deathcert.get_birth_order()">
                                                                    <option value="First">First</option>
                                                                    <option value="Second">Second</option>
                                                                    <option value="Third">Third</option>
                                                                    <option value="Others">Others</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-8">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" value="Others" id="txtmultiplebirth" name="txtmultiplebirth" disabled>
                                                                    <label class="form-label">Others </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                         <div class="col-sm-12">
                                                             <h5>19a. CAUSES OF DEATH</h5>
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtmaindisease" name="txtmaindisease">
                                                                    <label class="form-label">a. Main disease/condition of infant </label>
                                                                </div>
                                                            </div>
                                                             <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtotherdisease" name="txtotherdisease">
                                                                    <label class="form-label">b. Other disease/condition of infant</label>
                                                                </div>
                                                            </div>
                                                              <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtmainmaternal" name="txtmainmaternal">
                                                                    <label class="form-label">c. Main maternal disease/condition affecting infant</label>
                                                                </div>
                                                            </div>
                                                              <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtothermaternal" name="txtothermaternal">
                                                                    <label class="form-label">d. Other maternal disease/condition affecting infant</label>
                                                                </div>
                                                            </div>
                                                             <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="txtotherrelevant" name="txtotherrelevant">
                                                                    <label class="form-label">e. Other relevant circumstances</label>
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
                                                            Postmortem Death Certificate
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFour_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour_2">
                                                    <div class="panel-body">
                                                       <div class="col-sm-12">
                                                            <center><h4>POSTMORTEM DEATH CERTIFICATE</h4><hr></center>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <p style="text-align:center;">I HEREBY CERTIFY that I have performed an autopsy upon the body of the deceased and that the cause of death was</p>
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <textarea rows="1" class="form-control no-resize auto-growth" name="txtpostmortemcause" id="txtpostmortemcause"></textarea>
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
                                                <div class="panel-heading" role="tab" id="headingFive_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseFive_2" aria-expanded="false"
                                                           aria-controls="collapseFive_2">
                                                            Certification of Embalmer
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFive_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive_2">
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
                                                <div class="panel-heading" role="tab" id="headingSix_2">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseSix_2" aria-expanded="false"
                                                           aria-controls="collapseSix_2">
                                                            Affidavit of Delayed Registration of Death
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseSix_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix_2">
                                                    <div class="panel-body">
                                                        <div class="col-sm-12">
                                                            <center><h4>AFFIDAVIT OF DELAYED REGISTRATION OF DEATH</h4><hr></center>
                                                            <button type="button" class="btn btn-success waves-effect" onclick="deathcert.importdata()">
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
                                                                        <input type="text" class="form-control"  name="txtaffname">
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
                                                                        <input type="text" class="form-control"  name="txtaffadrs">
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
                                                                        <input type="text" class="form-control"  name="txtaffdieddate">
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
                                                                <label for="optionsattend">was attended by</label> 
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
                                            <button type="button" class="btn bg-red waves-effect btn-lg" onclick="deathcert.cancel();">
                                                <i class="material-icons">close</i>
                                                <span>CANCEL</span>
                                            </button>
                                            <button type="button" class="btn bg-green waves-effect pull-right btn-lg" onclick="deathcert.validate_form();">
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
</body>

<?php $this->load->view('pages/modals/fetchLoader'); ?>
<?php $this->load->view('pages/modals/admittedpatientday'); ?>
<?php $this->load->view('pages/modals/eachDayPatCensus'); ?>
<?php $this->load->view('pages/modals/philhealthpatients'); ?>
<?php $this->load->view('pages/modals/totalpatients'); ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    var sidemenu = $('#death-0-1');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    
//    load_script("http://192.168.1.100:3777/nurseV2/assets/vendors/js/responsive.js",3,0);
    
        deathcert.get_patientlist();
    
//    
//    chart.create_chart();
//    chart.monthly_census_chart();
$('#death-cert-form input[name=txtaffname]').keyup(function(){
//        alert($(this).val());
         $('#txtaffaffiant').val($(this).val().toUpperCase());
    })
    
       $('#death-cert-form input[name=txtdeathimmediatecause]').keyup(function(){
//        alert($(this).val());
         $('#txtpostmortemcause').val($(this).val());
    })
    
});
</script>















