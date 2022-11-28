<body class="theme-cyan">
     <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-cyan">
                    <li>Reports</li>
                    <li>DOH Annual Hospital Statistical Report</li>
                    <li>II. Hospital Operations</li>
                    <li class="active">B. Discharges</li>
                </ol>
            </div>
            <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               B. DISCHARGES
                            </h2>
                        </div>
                        <div class="body container-fluid">
                            <form id="search-discharges-form"  method="POST" >
                               <input type="hidden" name="s_date" value="<?= $cur_date ?>"/>
                               
                                <div class="col-sm-4">
                                    <div class='input-group datex'>
                                        <span class="input-group-addon">
                                            <i class="material-icons date-icon" >date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type='text' name="start_date" class="form-control" value="<?= $monthx ?>">
                                        </div>
                                        <small style="color: red"></small>
                                        
                                    </div>
                                </div>

                            </form>
                            
                            <div class="col-sm-4">
                                <button onclick="doh_discharges.search_discharges()" type="button" class="btn bg-purple waves-effect">
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
                                    <p>Kindly accomplish the "Type of Service and Total Discharges According to Specialty" in the table below.</p>
                                </div>
                                 <form id="print-operation-discharges-form" action="<?= base_url("user/operation_discharges_report") ?>" method="POST" target="_blank">
                                    <input type="hidden" name="s_datex" value=""/>
                                </form>
                            
                                <a class="payroll-button" href="javascript:void(0)" target="_blank">
                                    <button onclick="doh_discharges.print_operation_discharges_report()" style="height: 25px" type="button" class="btn bg-pink waves-effect btn-block">
                                        <i style="margin-top: -25px;" class="material-icons">picture_as_pdf</i> VIEW AND PRINT
                                    </button>
                                </a>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="body table-responsive">
                                    <table id="type-service-table" class="table table-bordered table-striped table-hover">
                                        <thead >
                                            <tr>
                                                <th rowspan="3" style="vertical-align : middle;text-align:center;">Type of Service</th>
                                                <th rowspan="3" style="vertical-align : middle;text-align:center;">No. of Patients</th>
                                                <th rowspan="3" style="vertical-align : middle;text-align:center;">Total Length of Stay/ Total No. of Days Stay</th>
                                                <th colspan="8" style="vertical-align : middle;text-align:center;">Type of Accommodation</th>
                                                <th colspan="9" style="vertical-align : middle;text-align:center;">Condition on Discharge</th>
                                                <th rowspan="3" style="vertical-align : middle;text-align:center;">Remarks</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3" style="vertical-align : middle;text-align:center;">Non-Philhealth</th>
                                                <th colspan="3" style="vertical-align : middle;text-align:center;">Philhealth</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">HMO</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">OWWA</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">R/I</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">T</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">H</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">A</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">U</th>
                                                <th colspan="3" style="vertical-align : middle;text-align:center;">Deaths</th>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Total Discharges</th>
                                            </tr>
                                            <tr>
                                                <th style="vertical-align : middle;text-align:center;">Pay</th>
                                                <th style="vertical-align : middle;text-align:center;">Service/Charity</th>
                                                <th style="vertical-align : middle;text-align:center;">Total</th>
                                                <th style="vertical-align : middle;text-align:center;">Pay</th>
                                                <th style="vertical-align : middle;text-align:center;">Service/Charity</th>
                                                <th style="vertical-align : middle;text-align:center;">Total</th>
                                                <th style="vertical-align : middle;text-align:center;">< 48 hrs</th>
                                                <th style="vertical-align : middle;text-align:center;">&#8805; 48 hrs</th>
                                                <th style="vertical-align : middle;text-align:center;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 12px">
                                            <tr>
                                                <td>Medicine</td>
                                                <td><?= number_format($medicine['nopx']) ?></td>
                                                <td><?= $lengthofstay_medicine ?></td>
                                                <td><?php if($medicine['non']=='0'){echo '0';}else{echo number_format($medicine['non']);} ?></td>
                                                <td>0</td>
                                                <td><?php if($medicine['non']==0){echo '0';}else{echo number_format($medicine['non']);} ?></td>
                                                <td><?php if($medicine['nhip']==0){echo '0';}else{echo number_format($medicine['nhip']);} ?></td>
                                                <td>0</td>
                                                <td><?php if($medicine['nhip']==0){echo '0';}else{echo number_format($medicine['nhip']);} ?></td>
                                               <td><?php if($medicine['hmo']==0){echo '0';}else{echo number_format($medicine['hmo']);} ?></td>
                                                <td>0</td>
                                                <td><?php if($medicine['ri']==0){echo '0';}else{echo number_format($medicine['ri']);} ?></td>
                                               <td><?php if($medicine['T']==0){echo '0';}else{echo number_format($medicine['T']);} ?></td>
                                                <td><?php if($medicine['H']==0){echo '0';}else{echo number_format($medicine['H']);} ?></td>
                                                <td><?php if($medicine['A']==0){echo '0';}else{echo number_format($medicine['A']);} ?></td>
                                                <td>0</td>
                                                <td><?php if($medicine['less48']==0){echo '0';}else{echo number_format($medicine['less48']);} ?></td>
                                                <td><?php if($medicine['more48']==0){echo '0';}else{echo number_format($medicine['more48']);} ?></td>
                                                <td><?php echo number_format($medicine['less48']+$medicine['more48']) ?>
                                                <td><?php echo number_format($medicine['ri']+$medicine['T']+ $medicine['H']+$medicine['A']+$medicine['less48']+$medicine['more48'])?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Obstetrics</td>
                                                <td><?= number_format($obstetrics['nopx']) ?></td>
                                                <td><?= $lengthofstay_obstetrics ?></td>
                                                <td><?= number_format($obstetrics['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($obstetrics['non']) ?></td>
                                                <td><?= number_format($obstetrics['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($obstetrics['nhip']) ?></td>
                                                <td><?= number_format($obstetrics['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($obstetrics['ri']) ?></td>
                                                <td><?= number_format($obstetrics['T']) ?></td>
                                                <td><?= number_format($obstetrics['H']) ?></td>
                                                <td><?= number_format($obstetrics['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($obstetrics['less48']) ?></td>
                                                <td><?= number_format($obstetrics['more48']) ?></td>
                                                <td><?php echo number_format($obstetrics['less48']+$obstetrics['more48']) ?>
                                                <td><?php echo number_format($obstetrics['ri']+$obstetrics['T']+ $obstetrics['H']+$obstetrics['A']+$obstetrics['less48']+$obstetrics['more48'])?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Gynecology</td>
                                                <td><?= number_format($gynecology['nopx']) ?></td>
                                                <td><?= $lengthofstay_gynecology ?></td>
                                                <td><?= number_format($gynecology['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($gynecology['non']) ?></td>
                                                <td><?= number_format($gynecology['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($gynecology['nhip']) ?></td>
                                                <td><?= number_format($gynecology['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($gynecology['ri']) ?></td>
                                                <td><?= number_format($gynecology['T']) ?></td>
                                                <td><?= number_format($gynecology['H']) ?></td>
                                                <td><?= number_format($gynecology['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($gynecology['less48']) ?></td>
                                                <td><?= number_format($gynecology['more48']) ?></td>
                                                <td><?php echo number_format($gynecology['less48']+$gynecology['more48']) ?>
                                                <td><?php echo number_format($gynecology['ri']+$gynecology['T']+ $gynecology['H']+$gynecology['A']+$gynecology['less48']+$gynecology['more48'])?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Pediatrics</td>
                                                <td><?= number_format($pedia['nopx']) ?></td>
                                                <td><?= $lengthofstay_pedia ?></td>
                                                <td><?= number_format($pedia['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pedia['non']) ?></td>
                                                <td><?= number_format($pedia['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pedia['nhip']) ?></td>
                                                <td><?= number_format($pedia['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pedia['ri']) ?></td>
                                                <td><?= number_format($pedia['T']) ?></td>
                                                <td><?= number_format($pedia['H']) ?></td>
                                                <td><?= number_format($pedia['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pedia['less48']) ?></td>
                                                <td><?= number_format($pedia['more48']) ?></td>
                                                <td><?php echo number_format($pedia['less48']+$pedia['more48']) ?>
                                                <td><?php echo number_format($pedia['ri']+$pedia['T']+ $pedia['H']+$pedia['A']+$pedia['less48']+$pedia['more48'])?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="21">Surgery</td>
                                            </tr>
                                            <tr>
                                                <td>Pedia</td>
                                                <td><?= number_format($surgery_pedia['nopx']) ?></td>
                                                <td><?= $lengthofstay_surgery_pedia ?></td>
                                                <td><?= number_format($surgery_pedia['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($surgery_pedia['non']) ?></td>
                                                <td><?= number_format($surgery_pedia['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($surgery_pedia['nhip']) ?></td>
                                                <td><?= number_format($surgery_pedia['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($surgery_pedia['ri']) ?></td>
                                                <td><?= number_format($surgery_pedia['T']) ?></td>
                                                <td><?= number_format($surgery_pedia['H']) ?></td>
                                                <td><?= number_format($surgery_pedia['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($surgery_pedia['less48']) ?></td>
                                                <td><?= number_format($surgery_pedia['more48']) ?></td>
                                                <td><?php echo number_format($surgery_pedia['less48']+$surgery_pedia['more48']) ?>
                                                <td><?php echo number_format($surgery_pedia['ri']+$surgery_pedia['T']+ $surgery_pedia['H']+$surgery_pedia['A']+$surgery_pedia['less48']+$surgery_pedia['more48'])?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Adult</td>
                                                <td><?= number_format($surgery_adult['nopx']) ?></td>
                                                <td><?= $lengthofstay_surgery_adult ?></td>
                                                <td><?= number_format($surgery_adult['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($surgery_adult['non']) ?></td>
                                                <td><?= number_format($surgery_adult['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($surgery_adult['nhip']) ?></td>
                                                <td><?= number_format($surgery_adult['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($surgery_adult['ri']) ?></td>
                                                <td><?= number_format($surgery_adult['T']) ?></td>
                                                <td><?= number_format($surgery_adult['H']) ?></td>
                                                <td><?= number_format($surgery_adult['A']) ?></td>
                                                <td>0</td>
                                                <td><?= $surgery_adult['less48'] ?></td>
                                                <td><?= $surgery_adult['more48'] ?></td>
                                                <td><?php echo $surgery_adult['less48']+$surgery_adult['more48'] ?>
                                                <td><?php echo $surgery_adult['ri']+$surgery_adult['T']+ $surgery_adult['H']+$surgery_adult['A']+$surgery_adult['less48']+$surgery_adult['more48']?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="21">Other(s)</td>
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <td>Total</td>
                                                <td><?= $total ?></td>
                                                <td><?= $lengthofstay_total ?></td>
                                                <td><?= $total_nonnhip ?></td>
                                                <td>0</td>
                                                <td><?= $total_nonnhip ?></td>
                                                <td><?= $total_nhip ?></td>
                                                <td>0</td>
                                                <td><?= $total_nhip ?></td>
                                                <td><?= $total_hmo ?></td>
                                                <td>0</td>
                                                <td><?= $total_ri ?></td>
                                                <td><?= $total_t ?></td>
                                                <td><?= $total_h ?></td>
                                                <td><?= $total_a ?></td>
                                                <td>0</td>
                                                <td><?= $total_less48 ?></td>
                                                <td><?= $total_more48 ?></td>
                                                <td><?php echo number_format($total_less48+$total_more48) ?>
                                                <td><?php echo number_format($total_ri+$total_t+ $total_h+$total_a+$total_less48+$total_more48) ?>
                                                <td></td>
                                                
                                            </tr>
                                            <tr style="font-weight: bold;">
                                                <td>Total Newborn</td>
                                                <td><?= number_format($newborn['nopx']) ?></td>
                                                <td><?= $lengthofstay_newborn ?></td>
                                                <td><?= number_format($newborn['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($newborn['non']) ?></td>
                                                <td><?= number_format($newborn['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($newborn['nhip']) ?></td>
                                                <td><?= number_format($newborn['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($newborn['ri']) ?></td>
                                                <td><?= number_format($newborn['T']) ?></td>
                                                <td><?= number_format($newborn['H']) ?></td>
                                                <td><?= number_format($newborn['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($newborn['less48']) ?></td>
                                                <td><?= number_format($newborn['more48']) ?></td>
                                                <td><?php echo number_format($newborn['less48']+$newborn['more48']) ?>
                                                <td><?php echo number_format($newborn['ri']+$newborn['T']+ $newborn['H']+$newborn['A']+$newborn['less48']+$newborn['more48']) ?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Pathologic</td>
                                                <td><?= $pathologic['nopx'] ?></td>
                                                <td><?= $lengthofstay_pathologic ?></td>
                                                <td><?= number_format($pathologic['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pathologic['non']) ?></td>
                                                <td><?= number_format($pathologic['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pathologic['nhip']) ?></td>
                                                <td><?= number_format($pathologic['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pathologic['ri']) ?></td>
                                                <td><?= number_format($pathologic['T']) ?></td>
                                                <td><?= number_format($pathologic['H']) ?></td>
                                                <td><?= number_format($pathologic['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($pathologic['less48']) ?></td>
                                                <td><?= number_format($pathologic['more48']) ?></td>
                                                <td><?php echo number_format($pathologic['less48']+$pathologic['more48']) ?>
                                                <td><?php echo number_format($pathologic['ri']+$pathologic['T']+ $pathologic['H']+$pathologic['A']+$pathologic['less48']+$nonpatho['more48']) ?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Non-Pathologic</td>
                                                <td><?= number_format($nonpatho['nopx']) ?></td>
                                                <td><?= $lengthofstay_nonpathologic ?></td>
                                                <td><?= number_format($nonpatho['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($nonpatho['non']) ?></td>
                                                <td><?= number_format($nonpatho['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($nonpatho['nhip']) ?></td>
                                                <td><?= number_format($nonpatho['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($nonpatho['ri']) ?></td>
                                                <td><?= number_format($nonpatho['T']) ?></td>
                                                <td><?= number_format($nonpatho['H']) ?></td>
                                                <td><?= number_format($nonpatho['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($nonpatho['less48']) ?></td>
                                                <td><?= number_format($nonpatho['more48']) ?></td>
                                                <td><?php echo number_format($nonpatho['less48']+$nonpatho['more48']) ?>
                                                <td><?php echo number_format($nonpatho['ri']+$nonpatho['T']+ $nonpatho['H']+$nonpatho['A']+$nonpatho['less48']+$nonpatho['more48']) ?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Well-Baby`</td>
                                                <td><?= number_format($wellbaby['nopx']) ?></td>
                                                <td><?= $lengthofstay_wellbaby ?></td>
                                                <td><?= number_format($wellbaby['non']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($wellbaby['non']) ?></td>
                                                <td><?= number_format($wellbaby['nhip']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($wellbaby['nhip']) ?></td>
                                                <td><?= number_format($wellbaby['hmo']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($wellbaby['ri']) ?></td>
                                                <td><?= number_format($wellbaby['T']) ?></td>
                                                <td><?= number_format($wellbaby['H']) ?></td>
                                                <td><?= number_format($wellbaby['A']) ?></td>
                                                <td>0</td>
                                                <td><?= number_format($wellbaby['less48']) ?></td>
                                                <td><?= number_format($wellbaby['more48']) ?></td>
                                                <td><?php echo number_format($wellbaby['less48']+$wellbaby['more48']) ?>
                                                <td><?php echo number_format($wellbaby['ri']+$wellbaby['T']+ $wellbaby['H']+$wellbaby['A']+$wellbaby['less48']+$wellbaby['more48']) ?>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <small>* R/I - Recovered/Improved</small>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <small>T - Transferred</small>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <small>U - Unimproved</small>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <small>H - Home Against Medical Advice</small>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <small>A - Absconded</small>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <small>D - Died (died upon admission)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix" >
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>1. Average Length of Stay (ALOS) of Admitted Patients = <u><span id="alos"><?= $alos ?></span> Days</u></b></p>
                                    <div class="body table-responsive">
                                        <table id="returnx-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>Total length of stay of discharged patients (including Deaths) in the period( <span id="totallengthofstay"><?= number_format($totallengthofstay['totallengthofstay']) ?></span> ) </td>
                                                    <td rowspan="2" style="vertical-align : middle;text-align:center;">= 100</td>
                                                </tr>
                                                <tr>
                                                    <td>Total discharges and deaths in the period( <span id="totaldischarges"><?= number_format($totaldischarges['totaldischarges'])?></span> ) </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <small>&#9632; Average Length of Stay: Average number of days each inpatient stays in the hospital for each episode of care.</small><br>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>2. Ten Leading causes of Morbidity based on final discharge diagnosis</b></p>
                                    <small>For each category listed below, please report the total number of cases for the top 10 illnesses/injury</small>
                                    <div class="body table-responsive">
                                        <table id="cause_10_morbidity_table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Cause of Morbidity/Illness/Injury</th>
                                                    <th>Number</th>
                                                    <th>ICD-10 Code (Individual)</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix" >
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>Kindly accomplish the "Ten Leading Causes of Morbidity/Diseased Disaggregated as to Age and Sex" in the table below.</b></p>
                                    <div class="body table-responsive">
                                        <table id="cause-morbidity-table" class="table table-bordered table-striped table-hover" >
                                            <thead >
                                                <tr style="vertical-align : middle;text-align:center;">
                                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Cause of Morbidity (Underlying)</th>
                                                    <th colspan="34" style="vertical-align : middle;text-align:center;">Age Distribution of Patients</th>
                                                    <th rowspan="3" style="vertical-align : middle;text-align:center;">Total</th>
                                                    <th rowspan="3" style="vertical-align : middle;text-align:center;">ICD-10 CODE/TABULAR LIST</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Under 1</th>
                                                    <th colspan="2">1-4</th>
                                                    <th colspan="2">5-9</th>
                                                    <th colspan="2">10-14</th>
                                                    <th colspan="2">15-19</th>
                                                    <th colspan="2">20-24</th>
                                                    <th colspan="2">25-29</th>
                                                    <th colspan="2">30-34</th>
                                                    <th colspan="2">35-39</th>
                                                    <th colspan="2">40-44</th>
                                                    <th colspan="2">45-49</th>
                                                    <th colspan="2">50-54</th>
                                                    <th colspan="2">55-59</th>
                                                    <th colspan="2">60-64</th>
                                                    <th colspan="2">65-69</th>
                                                    <th colspan="2">70 & over</th>
                                                    <th colspan="2">Subtotal</th>
                                                </tr>
                                                <tr >
                                                    <th>Spell out. Do not abbreviate.</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                    <th>F</th>
                                                    <th>M</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                               

                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>3. Total Number of Deliveries</b></p>
                                    <small>For each category of delivery listed below, please report the total number of deliveries.</small>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Deliveries</th>
                                                    <th>Number</th>
                                                    <th>ICD-10 Code</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td>Total number of in-facility deliveries</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of live-birth vaginal deliveries (normal)</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of live-birth C-section deliveries (Caesarians)</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of other deliveries</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>4. Outpatient Visits, including Emergency Care, Testing and Other Services</b></p>
                                    <small>For each category of visit of service listed below, please report the total number of patients receiving the care.</small>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Outpatient visits</th>
                                                    <th>Number</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td>Number of outpatient visits, new patient</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of outpatient visits, re-visit</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of outpatient visits, adult</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of outpatient visits, pediatric</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of adult general medicine outpatient visits</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of specialty (non-surgical) outpatient visits</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of surgical outpatient visits</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of antenatal care visits</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Number of postnatal care visits</td>
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
            <!--------Ten Leading Causes of OPD Consultation--->
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>Ten Leading Causes of OPD Consultation</b></p>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Ten Leading Causes of OPD Consultations</th>
                                                    <th>Number</th>
                                                    <th>ICD-10 Code</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <?php for($i=1;$i<=10;$i++)
                                                {
                                                    echo "<tr>
                                                           <td>".$i."</td>
                                                            <td></td>
                                                            <td></td>
                                                           </tr>";
                                                }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--------Ten Leading Causes of ER Consultation--->
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>Ten Leading Causes of OPD Consultation</b></p>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Ten Leading ER Consultations</th>
                                                    <th>Number</th>
                                                    <th>ICD-10 Code</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <?php for($i=1;$i<=10;$i++)
                                                {
                                                    echo "<tr>
                                                           <td>".$i."</td>
                                                            <td></td>
                                                            <td></td>
                                                           </tr>";
                                                }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-----TESTING----->
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>TESTING</b></p>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Total number of medical imaging tests (all types including x-rays, ultrasound, CT scans, etc.)</th>
                                                    <th>Number</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td>X-Ray</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Ultrasound</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>CT-Scan</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>MRI</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Mammography</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Angiography</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Linear Accelerator</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Dental X-Ray</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Other</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Total number of laboratory and diagnostic tests (all types, excluding medical imaging)</td>
                                                </tr>
                                                <tr>
                                                    <td>Urinalysis</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Fecalysis</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Hematology</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Clinical Chemistry</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Immunology/Serology/HIV</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Microbiology (Smears/Culture & Sensitivity)</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Surgical Pathology</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Autopsy</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Cytology</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Blood Service Facilities</td>
                                                </tr>
                                                <tr>
                                                    <td>Number of Blood units Transfused</td>
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
            <!-----EMERGENCY VISITS----->
            <div class="row clearfix" hidden>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p><b>EMERGENCY VISITS</b></p>
                                    <div class="body table-responsive">
                                        <table id="return-table" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Emergency Visits</th>
                                                    <th>Number</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td>Total number of emergency department visits</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of emergency department visits, adult</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total numbe of emergency department visits, pediatric</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total number of patients transported FROM THIS FACILITY'S EMERGENCY DEPARTMENT to another facility for inpatient care</td>
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
   var sidemenu = $('#DOH-3-2');
    sidemenu.removeClass().addClass('active');
    sidemenu.parents("li").removeClass().addClass('active');
    
doh_discharges.fetch_cause_morbidity();
doh_discharges.fetch_cause_morbidity_leading();
$('#type-service-table').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'scrollX'     : true,
    })
});
</script>