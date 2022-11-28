<html>
<head>
    <title> MANDATORY MONTHLY HOSPITAL REPORT</title>
    <style>
    html
        {   font-size: 12px;font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;  }      
    table, td, th 
        {   border: 1px solid black;text-align: left;   }
    table 
        {   border-collapse: collapse;width: 100%;border: 2px solid black;  }
    .White
        {   color:white;margin-left: -50px;margin-top: -30px;   }
    .MaterialAColorFont
        {   color:#5f6468;  }
    .Info-Margin
        {   margin-left: 20px;  }
    .MarginTop
        {   margin-top: 5px;    }
    .blue
        {   background-color: #29b6f6;width:auto;height:80px;   }
    .darkblue
        {   background-color: #2090c3;width:auto;height:40px;   }
    .imageSize
        {   margin-top:10px;margin-left: 10px;width:30px;height:30px;   } 
    #monthbed
        {   width: 15%; text-align: center; border-top-color: transparent;  }
    #centered
        {   text-align: center; font-weight: bold;  }
    #mbor
        {   width: 50%; text-align: center; }
    </style>
</head>
<body>
    <?php//-------------HEADER------------ ?>
    <div class="white">
        <center>
            <div class="Black">
                <b>Republic of the Philippines</b><br>  
                <b>PHILIPPINE HEALTH INSURANCE CORPORATION</b><br> 
                12/F City State Centre, 709 Shaw Blvd., Brgy. Oranbo, Pasig City<br>
                <b>MANDATORY MONTHLY HOSPITAL REPORT</b><br> 
            </div>
            <br>
             <div class="Black">
                 <b style="font-size:11px;">For the Month of <u><?= $month ?></u>, <u><?= $year ?></u></b><br>  
                
            </div>
        </center>
        <br>
    </div>
    <div>
        <table cellspacing="" cellpadding="0" border="0" style=" width: 100%;margin: 0 auto;">
            <tr> 
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Accreditation No.: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?= $profile['PHICPAN']?></u></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region: &nbsp;&nbsp;&nbsp;<u><?= $profile['Region']?></u></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Name of Hospital: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?= $profile['PHICname']?></u></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category: &nbsp;&nbsp;&nbsp;<u><?= $profile['phiccategory']?></u></td>
            </tr>
            <tr>
                <td> Address No./ Street: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?= $profile['PHICadrs']?></u></td>
                <td>PHIC Accredited Beds: &nbsp;&nbsp;&nbsp;<u><?= (int)($profile['authorizedbed'])?> beds</u></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Municipality:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?= $profile['phicCITY']?></u></td>
                <td>DOH Authorized Beds: &nbsp;&nbsp;&nbsp;<u><?= (int)($profile['DOHauthorizedbed'])?> beds</u></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Province:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?= $profile['PHICPROV']?></u></td>
            </tr>
            <tr>
                 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zip Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?= $profile['PHICZIPCODE']?></u></td>
            </tr>
        </table>
        <table cellspacing="" cellpadding="5" border="0" style=" width: 100%;margin: 0 auto;">
            <tr>
                <td><p style="font-size:11px;" id="centered"><b><span style="color:red;">A.1.</span> DAILY CENSUS OF <i>NHIP</i> PATIENTS (EVERY 12:00 MN.)</b></p></td>
                <td><p style="font-size:9px;" id="centered">CENSUS FOR THE DAY = (CENSUS OF THE PREVIOUS DAY plus ADMISSIONS OF THE DAY minus DISCHARGES OF THE DAY</p></td>
            </tr>
            <tr>
                <td>  
                    <table style="font-size: 10px;" cellspacing="0" cellpadding="0" >
                        <thead>
                            <tr >
                                <td id="centered"><span style="color:red;">1</span></td>
                                <td colspan="3" id="centered"><span style="color:red;">2</span></td>
                            </tr>
                             <tr>
                                 <td rowspan="2" id="centered">DATE</td>
                                <td colspan="3" id="centered">CENSUS</td>
                            </tr>
                            <tr>
                                <td id="centered"><span style="color:red;">a.</span> NHIP</td>
                                <td id="centered"><span style="color:red;">b.</span> NON-NHIP</td>
                                <td id="centered"><span style="color:red;">c.</span> TOTAL</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($census_month) !== 0) {?>
                                <?php foreach ($census_month as $census_month){ ?>
                                <tr>
                                    <td>&nbsp; <?php echo date_format(new DateTime($census_month["datex"]),"j")?></td> 
                                    <td><center><?= $census_month["nhip"]?></center></td> 
                                    <td><center><?= $census_month["non"]?></center></td> 
                                    <td><center><?= $census_month["totalx"]?></center></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><b>TOTAL    </b>   </td>
                                   <td><center><b><?= $phic ?> </b></center></td>
                                   <td><center><b><?= $non ?> </b> </center></td>
                                    <td><center><b><?= $pat ?></b></center> </td>
                                </tr>
                                <?php }else{ ?>
                                <tr>
                                    <td colspan="4"><center>No records found</center></td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </td>
                <td> 
                    <!-- DISCHARGES --> 
                    <table style="font-size: 10px;" cellspacing="0" cellpadding="0" >
                        <thead>
                            <tr >
                                <td id="centered"><span style="color:red;">3</span></td>
                                <td colspan="3" id="centered"><span style="color:red;">4</span></td>
                            </tr>
                            <tr>
                                <td rowspan="2" id="centered">DATE</td>
                                <td colspan="3" id="centered">DISCHARGES</td>
                            </tr>
                            <tr>
                                <td id="centered"><span style="color:red;">a.</span> NHIP</td>
                                <td id="centered"><span style="color:red;">b.</span> NON-NHIP</td>
                                <td id="centered"><span style="color:red;">c.</span> TOTAL</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($discharge_month) !== 0) {?>
                                <?php foreach ($discharge_month as $discharge_month){ ?>
                                <tr>
                                    <td>&nbsp; <?php echo date_format(new DateTime($discharge_month["datex"]),"j")?></td> 
                                    <td><center><?= $discharge_month["nhip"]?></center></td> 
                                    <td><center><?= $discharge_month["non"]?></center></td> 
                                    <td><center><?= $discharge_month["totalx"]?></center></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><b>TOTAL    </b>   </td>
                                   <td><center><b><?= $disphic ?> </b></center></td>
                                   <td><center><b><?= $disnon ?> </b> </center></td>
                                    <td><center><b><?= $dispat ?></b></center> </td>
                              
                                </tr>
                            <?php }else{ ?>
                                <tr>
                                    <td colspan="4"><center>No records found</center></td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                    </td>
                </tr>
            <tr>
                    <!-- MONTHLY ASSURANCE INDICATOR -->
                    <td> 
                        <b> <span style="color:red;">B.</span> MONTHLY ASSURANCE INDICATOR <br>
                            <br> 1. Monthly Bed Occupancy Rate (MBOR) = <u style="color:red;"><?= $mbor?>%</u></b>
                            <hr style="clear: both;border-style: none;" >
                            <table style="font-size: 10px;" border="0" cellspacing="0" cellpadding="0" >
                                <tr >
                                    <td rowspan="3" id="monthbed">MBOR = </td>
                                    <td id="mbor" style="font-size: 8px;">Total of NHIP CENSUS plus Total of NON-NHIP CENSUS (<b><?= $pat ?></b>)</td>
                                    <td rowspan="3" id="monthbed">X 100</td>
                                </tr>
                                <tr>
                                    <td> -----------------------------------------------------------------</td>
                                </tr>
                                <tr>
                                    <td id="mbor" style="font-size: 8px;">Number of Days per Month Indicated multiplied by Number of DOH Authorized Beds ( <b><?= $dd ?> * <?= $DOHauthorizedbed ?></b>) </td>
                                </tr>
                            </table>
                    </td>
                    <td>
                        <!-- Average Length of Stay per NHIP Patient -->
                        <br><br><br><br><b> 3. Average Length of Stay per NHIP Patient (ALSP) = <u style="color:red;"><?= $alspp ?>%</u></b>
                        <hr style="clear: both;border-style: none;" >
                        <table style="font-size: 10px;" border="0" cellspacing="0" cellpadding="0" >
                            <tr>
                                <td rowspan="3" id="monthbed">ALSP = </td>
                                <td>Total of NHIP CENSUS (<b><?= $phic ?></b>)</td>
                            </tr>
                            <tr>
                                <td> ------------------------------------------------------------------------</td>
                            </tr>
                            <tr>
                                <td>Total NHIP DISCHARGES (<b><?= $disphic ?></b>)</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <tr>
                    <td>
                        <b> 2. Monthly NHIP Beneficiary Occupancy Rate <br>(MNHIBOR) = <u style="color:red;"><?= $MNHIBOR ?>%</u></b>
                            <hr style="clear: both;border-style: none;">
                            <table style="font-size: 10px;" border="0" cellspacing="0" cellpadding="0" >
                            <tr>
                               <td rowspan="3" id="monthbed">MNHIBOR = </td>
                               <td id="mbor" style="font-size: 8px;">Total of NHIP CENSUS  (<b><span id="phic" ><?= $phic ?></span></b>)</td>
                               <td rowspan="3" id="monthbed">X 100</td>
                            </tr>
                            <tr>
                                <td> -----------------------------------------------------------------</td>
                            </tr>
                            <tr>
                               <td id="mbor" style="font-size: 8px;">Number of Days per Month Indicated multiplied by Number of PHIC Authorized Beds ( <b><?= $dd ?> * <?= $DOHauthorizedbed ?></b>)</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <tr>
                <td>
                        <!-- NEWBORN CENSUS -->
                        <br><b><span style="color:red;">A.</span> NEWBORN CENSUS</b>
                        <hr style="clear: both;border-style: none;" >
                        <table style="font-size: 9px;" cellspacing="0" cellpadding="0" border="1">
                            <tr>
                                <td rowspan="2" id="centered" style="border-top: none;border-left: none;">(Well Babies Only)</td>
                                <th colspan="3" id="centered" >PARENT</th>
                            </tr>
                            <tr>
                                <th id="centered">NHIP</th>
                                <th id="centered">NON-NHIP</th>
                                <th id="centered">TOTAL</th>
                            </tr>
                            <tr>
                                <th id="centered">TOTAL # OF NEWBORN</th>
                                <td ><center><?= $newborn_census[0]['nhip'] ?></center></td>
                                <td ><center><?= $newborn_census[0]['non'] ?></center></td>
                                <td ><center><?= $newborn_census[0]['totalx'] ?></center></td>
                            </tr>
                        </table>
                    </td>
                </tr>
        </table>
        <br>
        <p style="font-size:11px;">DATE OF RECEIPT: PRO/SO __________________  
                        &nbsp; &nbsp;           RECORDS SECTION: __________________
                        &nbsp; &nbsp;            ACCREDITATION: __________________ 
        </p>
        <p  style="color:red;font-size:9px;">&nbsp;&nbsp;&nbsp;*Note: This is a mandatory hospital report to be submitted <u>within the first ten (10) days</u> of the following month.</p>
        <div style="page-break-after:always;"></div> 
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <p style="font-size:10px;"><b><span style="color:red;">A.</span> MOST COMMON CAUSES OF CONFINEMENT</b> </p>
                    <hr style="clear: both;border-style: none;" >
                    <table style="font-size: 10px;border-width:thin;" cellspacing="0" cellpadding="0" >
                        <thead>
                            <tr>
                                <td rowspan="2" id="centered">DIAGNOSIS</td>
                                <td colspan="2" id="centered">TOTAL</td>
                            </tr>
                            <tr>
                                <td id="centered" width="10%;"> NHIP</td>
                                <td id="centered" width="10%;">NON-NHIP</td>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 
                                 if(count($confinement_causes) !== 0) {
                                     $count = 0; ?>
                                 <?php 
                                     foreach ($confinement_causes as $confinement_causes){ 
                                         $count++;?>
                                         <tr>
                                             <td>&nbsp; <b> <?= $count ?>.</b> <?php echo strtoupper($confinement_causes["causeofconfinement"]); ?></td> 
                                             <td width="10%;"><center><?= $confinement_causes["nhip"]?></center></td> 
                                             <td width="10%;"><center><?= $confinement_causes["non"]?></center></td>
                                         </tr>
                                 <?php } ?>
                             <?php }else{ 
                                     for($i = 1; $i <= 10; $i++)
                                     {?>
                                         <tr>
                                             <td >&nbsp;  <?= $i ?>.</td>
                                             <td width="10%;"></td>
                                             <td width="10%;"></td>
                                         </tr>
                                 <?php } } ?>
                             </tbody>
                        </table>
                        <!--SURGICAL OUTPUT - Top 10 Procedures-->
                    <br>
                    <p style="font-size:10px;"><b><span style="color:red;">B.</span> SURGICAL OUTPUT - Top 10 Procedures</b> </p>
                    <hr style="clear: both;border-style: none;" >
                    <table style="font-size: 10px;border-width:thin;" cellspacing="0" cellpadding="0">
                            <tr>
                                <td rowspan="2" id="centered">SURGICAL PROCEDURES</td>
                                <td colspan="2" id="centered">TOTAL</td>
                            </tr>
                            <tr>
                                <td id="centered" width="10%;"> NHIP</td>
                                <td id="centered" width="10%;">NON-NHIP</td>
                            </tr>
                            <tbody>
                            <?php if(count($surgical_output) !== 0) {
                                     $count = 0;
                                     ?>
                                <?php foreach ($surgical_output as $surgical_output){ 
                                    $count++;?>
                                <tr>
                                 
                                    <td>&nbsp; <b> <?= $count ?>.</b> <?php echo strtoupper( $surgical_output["Diag_surg"]); ?></td> 
                                    <td width="10%;"><center><?= $surgical_output["nhip"]?></center></td> 
                                    <td width="10%;"><center><?= $surgical_output["non"]?></center></td>
                                </tr>
                                <?php } ?>
                                <?php }else{ 
                                    for($i = 1; $i <= 10; $i++)
                                        {?>
                                <tr>
                                    <td >&nbsp;  <?= $i ?>.</td>
                                    <td width="10%;"></td>
                                        <td width="10%;"></td>

                                </tr>
                            <?php } } ?>
                            </tbody>
                        </table>
                    <!--TOTAL SURGICAL STERILIZATION-->
                    <br>
                    <p style="font-size:10px;"><b><span style="color:red;">C.</span> TOTAL SURGICAL STERILIZATION</b> </p>
                    <hr style="clear: both;border-style: none;" >
                    <table style="font-size: 10px;border-width:thin;" cellspacing="0" cellpadding="0" >
                           <thead>
                                <tr>
                                    <th rowspan="2"><center>SURGICAL STERILIZATION PROCEDURE</center></th>
                                    <th colspan="2"><center>NO. OF PATIENTS</center></th>
                                </tr>
                                <tr>
                                    <th class="align-middle" width="10%;"><center>NHIP</center></th>
                                    <th width="10%;"><center>NON-NHIP</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>&nbsp; <b> 1.</b> BILATERAL TUBAL LIGATION</td>
                                    <td width="10%;"><center><?php if($bilateral["nhip"] > 0){ echo $bilateral["nhip"];} else { echo "0";} ?></center></td>
                                    <td width="10%;"><center><?php if($bilateral["non"] > 0){ echo $bilateral["non"];} else { echo "0";} ?></center></td>
                                </tr>
                                <tr>
                                    <td>&nbsp; <b> 2.</b> VASECTOMY</td>
                                    <td width="10%;"><center><?php if($vasectomy["nhip"] > 0){ echo $vasectomy["nhip"];} else { echo "0";} ?></center></td>
                                    <td width="10%;"><center><?php if($vasectomy["non"] > 0){ echo $vasectomy["non"];} else { echo "0";} ?></center></td>
                                </tr>
                                <tr>
                                    <td>&nbsp; <b> 3.</b> ALL</td>
                                    <td width="10%;"><center><?php if($allnhip > 0){ echo $allnhip;} else { echo "0";} ?></center></td>
                                    <td width="10%;"><center><?php if($allnon > 0){ echo $allnon;} else { echo "0";} ?></center></td>
                                </tr>
                            </tbody>
                        </table>
                    <!--OBSTETRICAL PROCEDURES-->
                    <br>
                    <p style="font-size:10px;"><b><span style="color:red;">D.</span> OBSTETRICAL PROCEDURES</b> </p>
                    <hr style="clear: both;border-style: none;">
                    <table style="font-size: 10px;border-width:thin;" cellspacing="0" cellpadding="0" border="1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <td rowspan="2" colspan="2"></td>
                                    <td colspan="2" id="centered">NO. OF PATIENTS</td>
                                </tr>
                                <tr>
                                    <td id="centered" width="10%;">NHIP</td>
                                    <td id="centered" width="10%;">NON-NHIP</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" ><span style="color:red;">&nbsp; F.1.</span>TOTAL NUMBER OF DELIVERIES (NSD plus CAESARIAN SECTION)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td width="10%;"><center><?php if($obprocedure['nhip'] > 0){ echo $obprocedure['nhip']; } else {echo "0";} ?></center></td>
                                    <td width="10%;"><center><?php if($obprocedure['non'] > 0){ echo $obprocedure['non']; } else {echo "0";} ?></center></td>
                                </tr>
                                <tr>
                                    <td colspan="2" ><span style="color:red;">&nbsp;  F.2.</span>TOTAL NUMBER OF CAESARIAN CASES</td>
                                    <td width="10%;"><center><?php if($cs['nhip'] > 0){ echo $cs['nhip']; } else {echo "0";} ?></center></td>
                                    <td width="10%;"><center><?php if($cs['non'] > 0){ echo $cs['non']; } else {echo "0";} ?></center></td>
                                </tr>
                                <tr>
                                    <td rowspan="6" width="5%;" ></td>
                                    <td ><center>INDICATION FOR CS:</center></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php if(count($indication) !== 0) { 
                                    $count = 0;
                                    foreach ($indication as $indication){
                                        $count++;
                                ?>
                                    <tr>
                                        <td>&nbsp; <b> <?= $count ?>.</b> <?php echo strtoupper(  $indication["categdiag"])?></td> 
                                        <td width="10%;"><center><?= $indication["nhip"]?></center></td> 
                                        <td width="10%;"><center><?= $indication["non"]?></center></td> 
                                    </tr>
                                <?php
                                    } 
                                     }else{ 
                                    for($i = 1; $i <= 5; $i++)
                                        {?>
                                <tr>
                                    <td >&nbsp;  <?= $i ?>.</td>
                                    <td width="10%;"></td>
                                        <td width="10%;"></td>

                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    <!--MORTALITY CENSUS-->
                    <br>
                    <p style="font-size:10px;"><b><span style="color:red;">E.</span> MONTHLY MORTALITY CENSUS (All Cases)</b> </p>
                    <hr style="clear: both;border-style: none;">
                    <table style="font-size: 10px;border-width:thin;" cellspacing="0" cellpadding="0" >
                            <thead>
                                <tr>
                                    <td rowspan="2" id="centered">DIAGNOSIS</td>
                                    <td colspan="2" id="centered">TOTAL</td>
                                </tr>
                                <tr>
                                    <td id="centered" width="10%;"> NHIP</td>
                                    <td id="centered" width="10%;">NON-NHIP</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($mortality) !== 0) { 
                                    $count = 0;
                                    foreach ($mortality as $mortality){
                                        $count++;
                                ?>
                                    <tr>
                                        <td>&nbsp; <b> <?= $count ?>.</b> <?php echo strtoupper($mortality["categdiag"]); ?></td> 
                                        <td width="10%;"><center><?= $mortality["nhip"]?></center></td> 
                                        <td width="10%;"><center><?= $mortality["non"]?></center></td> 
                                    </tr>
                                <?php
                                    }}else{ 
                                    for($i = 1; $i <= 5; $i++)
                                        {?>
                                    <tr>
                                        <td >&nbsp;  <?= $i ?>.</td>
                                        <td width="10%;"></td>
                                        <td width="10%;"></td>
                                    </tr>
                            <?php } } ?>
                            </tbody>
                        </table>
                    <i style="font-size: 9px;">* Attach sheet if more than 5</i>
                        <!--REFERRALS-->
                    <br>
                    <p style="font-size:11px;"><b><span style="color:red;margin-bottom: -10px;">F.</span> REFERRALS</b> </p>
                    <table style="font-size: 11px;border-width:thin;" cellspacing="0" cellpadding="0" >
                            <thead>
                                <tr>
                                    <td rowspan="2" id="centered">MOST COMMON REASONS FOR REFERRAL</td>
                                    <td colspan="2" id="centered">NO. OF PATIENT REFERRED</td>
                                </tr>
                                <tr>
                                    <td id="centered" width="10%;"> NHIP</td>
                                    <td id="centered" width="10%;">NON-NHIP</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($referrals) !== 0) { 
                                    $count = 0;
                                    foreach ($referrals as $referrals){
                                        $count++;
                                ?>
                                    <tr>
                                        <td>&nbsp;<b> <?= $count ?>.</b> <?php echo strtoupper($referrals["reasonforreferral"]); ?></td> 
                                        <td width="10%;"><center><?= $referrals["nhip"]?></center></td> 
                                        <td width="10%;"><center><?= $referrals["non"]?></center></td> 
                                    </tr>
                                 <?php
                                    } ?>
                                 <?php }else{ 
                                    for($i = 1; $i <= 5; $i++)
                                        {?>
                                    <tr>
                                        <td >&nbsp;  <?= $i ?>.</td>
                                        <td width="10%;"></td>
                                        <td width="10%;"></td>
                                    </tr>
                            <?php } } ?>
                            </tbody>
                        </table>
                    <!----- PREPARED BY ---->  <br> <br> 
                    <table style="font-size: 11px;" cellspacing="0" cellpadding="5" border="0" >
                            <tr>
                                <td >PREPARED BY:</td>
                                <td > CERTIFIED CORRECT:</td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                 <td id="mbor"> <u><b><?php echo strtoupper( $profile['HCIrepresentative']) ?></b></u> </td>
                                 <td id="mbor"> <u><b><?php echo strtoupper( $profile['Admin']) ?></b></u> </td>
                            </tr>
                            <tr>
                                <td id="mbor">Name and Position a Person filling up the form<br>
                                                (signature over printed name)
                                </td>
                                <td id="mbor">Chief of Hospital/Medical Director<br>
                                                (signature over printed name)
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
