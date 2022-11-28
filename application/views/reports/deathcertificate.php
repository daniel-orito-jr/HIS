<html>
<head>
    <meta charset="utf-8">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png')?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> CERTIFICATE OF DEATH</title>
    <style>
        
        html
        {
         
          font-family: sans-serif;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        }      

        table, td, th {    
            border: 1px solid #455ae0;
            text-align: left;
         
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border:  solid #455ae0;
            table-layout: fixed;

        }

    

        .White{
            color:white;
            margin-left: -50px;
            margin-top: -30px;
        }

        .MaterialAColorFont{
            color:#5f6468;
        }
        .Info-Margin{
            margin-left: 20px;
        }
        .MarginTop{
            margin-top: 5px;
        }
        /*---------- End of margin---------*/

        /*-----------Colors----------*/
        #455ae0{                                            
            background-color: #29b6f6;
            width:auto; 
            height:80px;
        }
        .dark#455ae0{
            background-color: #2090c3;
            width:auto; 
            height:40px;
        }
        /*-----------End of the colors----------*/

        /*------Nix Coop Image-------*/
        .imageSize{
            margin-top:10px ;
            margin-left: 10px;
            width:30px;
            height:30px;
        } 
       
        #age
        {
            font-size:9px;
            text-align: center;
            border-left:solid;
            border-right:solid;
            border-width: thin;
        }
        
        #years
        {
            font-size:9px;
            text-align: center;
            border:solid;
            border-width: thin;
        }
        
        #agetime
        {
            border-left:solid;
            border-right:solid;
            border-width: thin;
        }

        .blox
        {
          border-style: dotted;
          border-width: thin;
          border-color: black;
          width:19px;
          height: 19px;
          float:left;
          margin-left: -3px;
        }
        .container{

         /*padding-left: 25px*/
        }

        .borderleft
        {
          border-left: solid;
          border-color: #455ae0;
          border-width: thin;
  
        }

        .borderleftonly
        {
          border-left:solid;
          border-color: #455ae0;
          border-width: thin;
          border-bottom: none;
          border-top:none;
          border-right: none;
        }
        
        span
        {
          font-size:10px;
          color:#455ae0;
        }

        .colorblack
        {
          color:black;
        }

        .affidavitbox
        {
          border-style: solid;
          border-width: thin;
          border-color: black;
          width:19px;
          height: 19px;
          float:left;
          margin-left: 50px;
        }


        .affidavitnumb
        {
          margin-left: 50px;
          text-align: justify;
        }

        .outsideTable
        {
           width: 100%;
          margin: 0 auto; 
          font-size: 12px;
          margin-bottom: 10px;
        }


        .innerTable
        {
          width: 100%;
          margin: 0 auto; 
          font-size: 10px;
        }

        .innerTable2
        {
          width: 100%;
          margin: 0 auto; 
          font-size: 12px;
        }
    
        .reviewTable
        {
          border-top:none;
          border-bottom: none;
          border-width:thin;
        }
        
        #valuestyle
        {
            
            font-size:11px;  
            border: 0;outline: 0;
            background: transparent;
            border-bottom: solid #455ae0 thin;
        }
        
        #notes {
         background-attachment: local;
    background-image:
        linear-gradient(to right, white 10px, transparent 10px),
        linear-gradient(to left, white 10px, transparent 10px),
        repeating-linear-gradient(white, white 30px, #ccc 30px, #ccc 31px, white 31px);
    line-height: 31px;
    padding: 8px 10px;
        }
        
        .attendant
        {
            font-family: DejaVu Sans;
            font-size: 10px;
            text-decoration: none; 
            font-weight: bold; 
            border-bottom: solid; 
            border-bottom-width: 1px;
            border-color:blue;
        }


    </style>
</head>

<body>
    
    <table cellspacing="" cellpadding="0" border="1" class="outsideTable">
        <tr >
            <td>
            <table cellspacing="" cellpadding="0" border="0" style=" width: 100%;margin: 0 auto; font-size: 9px;">
           <tr>
               <td >&nbsp;&nbsp;Municipal Form No. 103</td>
               <td></td>
               <td style="text-align: right;">(To be accomplished in quadruplicated using black ink.)</td>
           </tr>
            <tr>
               <td>&nbsp;&nbsp;&nbsp;&nbsp;(Revised January 2007</td>
               <td style="font-size:11px;"><center>Republic of the Philippines</center></td>
               <td></td>
           </tr>
             <tr>

               <td style="font-size:12px;" colspan="3"><center>OFFICE OF THE CIVIL REGISTRAR GENERAL</center></td>

           </tr>
             <tr>

                 <td style="font-size:24px;" colspan="3"><center><b>CERTIFICATE OF DEATH</b></center></td>

           </tr>
            </table>
            </td>
            
    </tr>
    <tr>
      <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
           <tr>
               <td colspan="2" ><label style="font-size:14px;margin-left:5px;">Province:</label> <input style="width: 400px;" id="valuestyle" value="<?php echo strtoupper($profile['compprovince']) ?>" type="text" /></td>
               <td rowspan="2" class="borderleft"  valign="top"><label style="font-size:14px;margin-left:5px;">Registry No.</label></td>
              
           </tr>
            <tr>
                <td colspan="2" ><label style="font-size:14px;margin-left:5px;">City/Municipality</label> <input style="width: 358px;" id="valuestyle" value="<?= strtoupper($profile['compcity']) ?>" type="text" /></td>
        
            </table>
            </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="" cellpadding="5" border="0" class="innerTable">
                <tr>
                    <td rowspan="2" valign="top">1. NAME </td>
                    <td>(First)</td>
                    <td>(Middle)</td>
                    <td>(Last)</td>
                    <td class="borderleftonly">2. SEX (Male/Female)</td>
                </tr>
                <tr>
                    <td style="font-size:12px;"><?php if($death['fetfname'] === "") { echo "N/A"; }else {echo strtoupper($death['fetfname']); }?></td>
                    <td style="font-size:12px;"><?php if($death['fetmname'] === "") { echo "N/A"; }else {echo strtoupper($death['fetmname']); }?></td>
                    <td style="font-size:12px;"><?php if($death['fetlname'] === "") { echo "N/A"; }else {echo strtoupper($death['fetlname']); }?></td>
                    <td class="borderleftonly" style="font-size:12px;"><center><?php if($death['fetgender'] === "") { echo "N/A"; }else {echo strtoupper($death['fetgender']); }?></center></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
                <tr >
                    <td colspan="3"><label style="margin-left:5px;">3. DATE OF DEATH</label> <span style="font-size:9px;">(Day, Month, Year)</span> </td>
                    <td colspan="3" class="borderleftonly"><label style="margin-left:5px;">4. DATE OF BIRTH</label> <span style="font-size:9px;">(Day) (Month) (Year)</span></td>
                    <td colspan="6" valign="top" class="borderleft" ><label style="margin-left:5px;">5. AGE AT THE TIME OF DEATH </label><span style="font-size:9px;">(Fill-in below accdg. to age category)</span></td>
                </tr>
                <tr>
                    <td colspan="3" valign="top" rowspan="3" style="font-size:12px;" class="borderleftonly"><center><?php if($deathdate === null) { echo "N/A"; }else {echo strtoupper($deathdate); }?></center></td>
                    <td colspan="3" valign="top" rowspan="3" style="font-size:12px;" class="borderleftonly"><center><?php if($dateofdel === null) { echo "N/A"; }else {echo strtoupper($dateofdel); }?></center></td>
                    <td colspan = "2"valign="top" class="borderleft" style="font-size:9px;" ><center>a. IF 1 YEAR OR ABOVE</center></td>
                    <td colspan = "2" valign="top" class="borderleft" style="font-size:9px;"><center>b. IF UNDER 1 YEAR</center></td>
                    <td  colspan = "2" valign="top" class="borderleft" style="font-size:9px;"><center>b. IF UNDER 24 HRS</center></td>
                </tr>
                <tr>
                    <td colspan = "2" class="borderleftonly"><center>[2] Completed years </center></td>
                    <td valign="top"  class="borderleftonly" style="font-size:9px;"><center>[1] Months</center></td>
                    <td valign="top" class="borderleftonly" style="font-size:9px;"><center>[0] Days</center></td>
                    <td valign="top" class="borderleftonly" style="font-size:9px;"><center>Hours</center></td>
                    <td valign="top" class="borderleftonly" style="font-size:9px;"><center>Min/Sec</center></td>
                </tr>
                <tr>
                    <td colspan = "2" style="font-size:12px;" class="borderleftonly"><center><?php if($death['deathage_years'] === null) { echo "N/A"; }else {echo strtoupper($death['deathage_years']); }?></center></td>
                    <td style="font-size:12px;" class="borderleftonly"><center><?php if($death['deathage_month'] === null) { echo "N/A"; }else {echo strtoupper($death['deathage_month']); }?></center></td>
                    <td style="font-size:12px;" class="borderleftonly"><center><?php if($death['deathage_days'] === null) { echo "N/A"; }else {echo strtoupper($death['deathage_days']); }?></center></td>
                    <td style="font-size:12px;" class="borderleftonly"><center><?php if($death['deathage_hours'] === null) { echo "N/A"; }else {echo strtoupper($death['deathage_hours']); }?></center></td>
                    <td style="font-size:12px;" class="borderleftonly"><center><?php if($death['deathage_min_sec'] === null) { echo "N/A"; }else {echo strtoupper($death['deathage_min_sec']); }?></center></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="" cellpadding="3" border="0" class="innerTable">
                <tr>
                    <td colspan="2" valign="top">6. PLACE OF DEATH <span style="font-size:9px;">(Name of Hospital/Clinic/Institution/House No., St., Barangay, City/Municipality, Province)</span> </td>
                    <td  valign="top" class="borderleftonly" >7. CIVIL STATUS <span style="font-size:9px;"> (Single/Married/Widow/Widower/Annulled/Divorced)</span></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:12px;"><center><?php if($death['placeofdeath'] === "") { echo "N/A"; }else {echo strtoupper($death['placeofdeath']); }?></center></td>
                    <td colspan="2" style="font-size:12px;" class="borderleftonly"><center><?php if($death['civilstatus'] === "") { echo "N/A"; }else {echo strtoupper($death['civilstatus']); }?></center></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="" cellpadding="5" border="0" class="innerTable">
                <tr>
                    <td>8. RELIGION/ RELIGIOUS SECT </td>
                    <td class="borderleftonly" >9. CITIZENSHIP</td>
                    <td colspan="2" class="borderleftonly" >10. RESIDENCE <span style="font-size:9px;"> (House No., St., Barangay, City/Municipality, Province, Country)</span></td>
                </tr>
                <tr>
                    <td style="font-size:12px;"><center><?php if($death['religion'] === "") { echo "N/A"; }else {echo strtoupper($death['religion']); }?></center></td>
                    <td style="font-size:12px;" class="borderleftonly"><center><?php if($death['citizenship'] === "") { echo "N/A"; }else {echo strtoupper($death['citizenship']); }?></center></td>
                    <td colspan="2" style="font-size:12px;" class="borderleftonly"><center><?php if($death['residence'] === "") { echo "N/A"; }else {echo strtoupper($death['residence']); }?></center></td>
                </tr>
            </table>
        </td>
    </tr>
     <tr>
        <td>
            <table cellspacing="" cellpadding="5" border="0" class="innerTable">
                <tr>
                    <td>11. OCCUPATION </td>
                    <td colspan="2" class="borderleftonly" >12. NAME OF FATHER <span style="font-size:9px;">(First, Middle, Last)</span> </td>
                    <td colspan="2" class="borderleftonly" >13. MAIDEN NAME OF MOTHER <span style="font-size:9px;">(First, Middle, Last)</span> </td>
                </tr>
                <tr>
                    <td style="font-size:12px;"><center><?= $death['occupation'] ?></center></td>
                    <td colspan="2" style="font-size:12px;" class="borderleftonly"><center><?php if($death['fatfname'] === null) { echo "N/A"; }else {echo strtoupper($death['fatfname']).','.strtoupper($death['fatmname']).','.strtoupper($death['fatlname']); }?></center></td>
                    <td colspan="2" style="font-size:12px;" class="borderleftonly"><center><?php if($death['fatfname'] === null) { echo "N/A"; }else {echo strtoupper($death['motfname']).','.strtoupper($death['motmname']).','.strtoupper($death['motlname']); }?></center></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="" cellpadding="5" border="0" class="innerTable">
                <tr>
                    <td><center><b style="font-size: 12px;">MEDICAL CERTIFICATE</b><BR>
                    For ages 0 to 7 days, accomplish items 14-19a at the back</center>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
     <tr>
        <td>
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
                <tr>
                    <td colspan="2">&nbsp; &nbsp;19b. CAUSES OF DEATH (If the deceased is aged 8 days and over)</td>
                    <td><center>Interval Betweeen Onset and Death</center></td>
                </tr>
                <tr>
                    <td colspan="2" >&nbsp; &nbsp;I. Immediate cause &nbsp; &nbsp; &nbsp; a. <input style="width: 350px;" id="valuestyle" value="<?php if($death['immediatecause'] === "") { echo "N/A"; }else {echo strtoupper($death['immediatecause']); }?>" type="text" /></td>
                    <td><center><input style="width: 215px;" id="valuestyle" value="<?php if($death['intervalimmediatecause'] === "") { echo "N/A"; }else {echo strtoupper($death['intervalimmediatecause']); }?>" type="text" /></center></td>
                </tr>
                <tr>
                    <td colspan="2" >&nbsp;&nbsp;&nbsp; &nbsp;Antecedent cause &nbsp; &nbsp;&nbsp;  b. <input style="width: 350px;" id="valuestyle" value="<?php if($death['antecedentcause'] === "") { echo "N/A"; }else {echo strtoupper($death['antecedentcause']); }?>" type="text" /></td>
                    <td><center><input style="width: 215px;" id="valuestyle" value="<?php if($death['intervalantecedentcause'] === "") { echo "N/A"; }else {echo strtoupper($death['intervalantecedentcause']); }?>"  type="text" /></center></td>
                </tr>
                <tr>
                    <td colspan="2" >&nbsp;&nbsp;&nbsp; &nbsp;Underlying cause &nbsp; &nbsp;&nbsp;&nbsp; c. <input style="width: 350px;" id="valuestyle" value="<?php if($death['underlyingcause'] === "") { echo "N/A"; }else {echo strtoupper($death['underlyingcause']); }?>" type="text" /></td>
                    <td><center><input style="width: 215px;" id="valuestyle" value="<?php if($death['intervalunderlyingcause'] === "") { echo "N/A"; }else {echo strtoupper($death['intervalunderlyingcause']); }?>"  type="text" /></center></td>
                </tr>
                <tr>
                    <td colspan="3" >&nbsp; &nbsp;II. Other significant conditions contributing to death: &nbsp; &nbsp; &nbsp;<input style="width: 448px;" id="valuestyle" value="<?php if($death['deathsignificantcondition'] === "") { echo "N/A"; }else {echo strtoupper($death['deathsignificantcondition']); }?>" type="text" /></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
                <tr>
                    <td colspan="10">&nbsp; &nbsp;19c. MATERNAL CONDITION (If the deceased is female aged 15-49 years old</td>
                </tr>
                <tr>
                    <td> <?php if($death['maternalcondition'] === "pregnant, not in labour") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> a. pregnant, not in labour</center></td>
                    <td> <?php if($death['maternalcondition'] === "pregnant, in labour") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> b. pregnant, in labour</center></td>
                    <td> <?php if($death['maternalcondition'] === "less than 42 days after delivery") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> c. less than 42 days after delivery</center></td>
                    <td> <?php if($death['maternalcondition'] === "42 days to 1 year after delivery") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> d. 42 days to 1 year after delivery</center></td>
                    <td> <?php if($death['maternalcondition'] === "None of the choices") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> e. None of the choices</center></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
                <tr>
                    <td colspan="5">&nbsp; &nbsp;19d. DEATH BY EXTERNAL CAUSES</td>
                    <td  class="borderleftonly" valign="top">&nbsp; &nbsp; 20. AUTOPSY <span>(Yes/No)</span> </td>
                </tr>
                <tr>
                    <td colspan="5"><label>&nbsp; &nbsp;a. Manner of death</label> <span>(Homicide, Suicide, Accident, Legal Intervention, etc.) </span><input style="width: 250px;" id="valuestyle" value="<?php if($death['mannerofdeath'] === "") { echo "N/A"; }else {echo strtoupper($death['mannerofdeath']); }?>" type="text" /></td>
                    <td rowspan="2" class="borderleftonly" valign="top"><center><?php if($death['autopsy'] === "") { echo "N/A"; }else {echo strtoupper($death['autopsy']); }?></center></td>
                </tr>
                <tr>
                    <td colspan="5"><label>&nbsp; &nbsp;b. Place of Occurrence of External Cause</label> <span>(e.g. home, farm, factory, street, sea, etc.) </span><input style="width: 200px;" id="valuestyle" value="<?php if($death['placeofexternalcause'] === null) { echo "N/A"; }else {echo strtoupper($death['placeofexternalcause']); }?>" type="text" /></td>
                   
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
                <tr>
                    <td colspan="11">&nbsp; &nbsp;21a. ATTENDANT</td>
                    <td  colspan="4" class="borderleftonly" valign="top">&nbsp; &nbsp; 21b. If attended, state duration <br><span><center> (mm/dd/yy) </center></span> </td>

                </tr>
                <tr>
                    <td> <?php if($death['attendant'] === "Private Physician") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> 1 Private Physician</center></td>
                    <td> <?php if($death['attendant'] === "Public Health Officer") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> 2 Public Health Officer</center></td>
                    <td> <?php if($death['attendant'] === "Hospital Authority") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> 3 Hospital Authority</center></td>
                    <td> <?php if($death['attendant'] === "None") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> 4 None</center></td>
                    <td> <?php if($attendant === "Others") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td><center> 5 Others (Specify)</center></td>  
                    <td> <?php if($attendantx ===null) { echo "<label class='attendant'><center>".strtoupper($attendantx)."</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    
                    <td class="borderleftonly"colspan="2"  >&nbsp; &nbsp;From  <input style="width: 60px;font-size:10px;" id="valuestyle" value="<?php echo $attendeddurationfrom ?>" type="text" /></td>
                    
                    <td colspan="2" >To <input style="width: 60px;font-size:10px;" id="valuestyle" value="<?php echo $attendeddurationto ?>" type="text" /></td>
                   </tr>
              
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="0" cellpadding="0" border="0" class="innerTable">
                <tr>
                    <td colspan="5" > 
                        <p style="margin-left:10px;">22. CERTIFICATION OF DEATH </p>
                        <p style="margin-left:10px;">&nbsp;&nbsp;&nbsp;&nbsp;I hereby certify that the foregoing particulars are correct as near as same can be ascertained and I further certify that I 
                            <?php if($death['attended'] === "attended"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?>have attended/ 
                            <?php if($death['attended'] === "unattended"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?>
                            have not attended the deceased and that death occurred at  <input style="width: 50px;" id="valuestyle" value="<?php echo strtoupper($deathtime) ?>" type="text" /> am/pm on the date of the date specified above.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" >
                        &nbsp;&nbsp;&nbsp;&nbsp; Signature &nbsp;  <span>_______________________________________________________________</span>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; Name in Print &nbsp;  <input style="width: 325px; " id="valuestyle" value="<?php if($death['attname'] === "") { echo "N/A"; }else {echo strtoupper($death['attname']); }?>" type="text" />
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; Title or Position &nbsp;  <input style="width: 318px;" id="valuestyle" value="<?php if($death['attposition'] === null) { echo "N/A"; }else {echo strtoupper($death['attposition']); }?>" type="text" />
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; Address &nbsp; <input style="width: 350px;" id="valuestyle" value="<?php if($death['attaddress'] === null) { echo "N/A"; }else {echo strtoupper($death['attaddress']); }?>" type="text" />
                        <br><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span>_______________________________________</span> Date  <span>_____________________________</span>
                    </td>
                    <td colspan="2" class="borderleft" >
                        &nbsp;&nbsp;<label style="font-size:12px;">REVIEWED BY:</label> 
                        <br>
                        <br>
                        <center><input style="width: 225px;margin-left:28px;" id="valuestyle" value="<?php if($death['reviewby'] === "") { echo "N/A"; }else {echo strtoupper($death['reviewby']); }?>" type="text" /> <br> Signature Over Printed Name of Health Officer</center>
                        <br>
                        <center>&nbsp;&nbsp;&nbsp;&nbsp;<input style="width: 200px;margin-left:28px;" id="valuestyle" value="<?php echo strtoupper($reviewdate) ?>" type="text" /> <br> Date</center>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td >
            <table cellspacing="" cellpadding="5" border="0" class="innerTable">
                <tr>
                    <td valign='top'>23. CORPSE DISPOSAL 
                        <br>
                            <small style="font-size: 9px;">(Burial, Cremation, if others, specify)</small>
                        <br>
                        <br>
                        <?php if($death['corpsedisposal'] === "") { echo "N/A"; }else {echo strtoupper($death['corpsedisposal']); }?>
                        
                    </td>
                    <td class='borderleftonly'  valign='top'>24a. BURIAL/CREMATION PERMIT <br>
                        <label> Number </label>  <input style="width: 180px;" id="valuestyle" value="<?php if($death['burialno'] === null) { echo "N/A"; }else {echo strtoupper($death['burialno']); }?>" type="text" /><br>
                      <label> Date Issued </label> <input style="width: 162px;" id="valuestyle" value="<?php echo strtoupper($burialdateissue) ?>" type="text" />
                    </td>
                    <td class='borderleftonly'>24b. TRANSFER PERMIT <br>
                      <label> Number </label>  <input style="width: 180px;" id="valuestyle" value="<?php if($death['transferpermitnumber'] === "") { echo "N/A"; }else {echo strtoupper($death['transferpermitnumber']); }?>" type="text" /><br>
                      <label> Date Issued </label> <input style="width: 162px;" id="valuestyle" value="<?php echo strtoupper($transferpermitdate) ?>" type="text" />
                    </td>
                </tr>
              </table>
        </td>
    </tr>
    <tr>
        <td >
            <table cellspacing="" cellpadding="5" border="0" class="innerTable">
                <tr>
                    <td>25. NAME AND ADDRESS OF CEMETERY OR CREMATORY</td>
                </tr>
                <tr>
                    <td><?php if($death['cemetery'] === "") { echo "N/A"; }else {echo strtoupper($death['cemetery']); }?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
                <tr>
                    <td><p style="margin-left:5px;">22. CERTIFICATION OF INFORMANT </p>
                        <p style="margin-left:5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I hereby certify that all information supplied are true and correct to my own knowledge and belief.</p>
                        <label style="margin-left:5px;"> Signature </label> &nbsp;  <input style="width: 280px;color:white; " id="valuestyle" value="<?php if($death['attname'] === null) { echo "N/A"; }else {echo strtoupper($death['attname']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Name in Print </label> &nbsp;  <input style="width: 263px; " id="valuestyle" value="<?php if($death['informantname'] === "") { echo "N/A"; }else {echo strtoupper($death['informantname']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Relationship to the Deceased </label> &nbsp;   <input style="width: 193px; " id="valuestyle" value="<?php if($death['informantrelation'] === null) { echo "N/A"; }else {echo strtoupper($death['informantrelation']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Address </label> &nbsp;  <input style="width: 285px;" id="valuestyle" value="<?php if($death['informantaddress'] === null) { echo "N/A"; }else {echo strtoupper($death['informantaddress']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Date </label> &nbsp;  <input style="width: 300px;" id="valuestyle" value="<?php echo strtoupper($informantdate) ?>" type="text" />
                    
                    </td>
                    <td class="borderleftonly"><label style="margin-left:5px;">27. PREPARED BY </label>
                        <p style="margin-left:5px;color:white;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I hereby certify that all information supplied are true and correct to my own knowledge and belief.</p>
                       <label style="margin-left:5px;"> Signature </label> &nbsp;  <input style="width: 280px;color:white; " id="valuestyle" value="<?php if($death['attname'] === null) { echo "N/A"; }else {echo strtoupper($death['attname']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Name in Print </label> &nbsp;  <input style="width: 263px; " id="valuestyle" value="<?php if($death['preparedby'] === null) { echo "N/A"; }else {echo strtoupper($death['preparedby']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Title or Position </label> &nbsp;   <input style="width: 255px; " id="valuestyle" value="<?php if($death['prepareposition'] === null) { echo "N/A"; }else {echo strtoupper($death['prepareposition']); }?>"  type="text" />
                       
                        <br>
                        <label style="margin-left:5px;"> Date </label> &nbsp;  <input style="width: 300px;" id="valuestyle" value="<?php echo strtoupper($preparedate) ?>" type="text" />
                        <br>
                        <br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
                <tr>
                    <td class="borderleftonly"><p style="margin-left:5px;">28. RECEIVED BY </p>
                     
                       <label style="margin-left:5px;"> Signature </label> &nbsp;  <input style="width: 280px;color:white; " id="valuestyle" value="<?php if($death['attname'] === null) { echo "N/A"; }else {echo strtoupper($death['attname']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Name in Print </label> &nbsp;  <input style="width: 263px;" id="valuestyle" value="<?php if($death['recieveby'] === "") { echo "N/A"; }else {echo strtoupper($death['recieveby']); }?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Title or Position </label> &nbsp;   <input style="width: 255px;  " id="valuestyle" value="<?php if($death['recieveposition'] === "") { echo "N/A"; }else {echo strtoupper($death['recieveposition']); }?>" type="text" />
                       
                        <br>
                        <label style="margin-left:5px;"> Date </label> &nbsp;  <input style="width: 300px; " id="valuestyle" value="<?php echo strtoupper($recievedate) ?>" type="text" />
                    </td>
                    <td class="borderleftonly"><p style="margin-left:5px;">29. REGISTERED BY THE CIVIL REGISTRAR </p>
                     
                       <label style="margin-left:5px;"> Signature </label> &nbsp;  <input style="width: 280px;color:white; " id="valuestyle" value="<?php echo strtoupper($death['attname']) ?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Name in Print </label> &nbsp;  <input style="width: 263px;color:white;  " id="valuestyle" value="<?php echo strtoupper($death['recieveby']) ?>" type="text" />
                        <br>
                        <label style="margin-left:5px;"> Title or Position </label> &nbsp;   <input style="width: 255px;color:white;  " id="valuestyle" value="<?php echo strtoupper($death['recieveby']) ?>" type="text" />
                       
                        <br>
                        <label style="margin-left:5px;"> Date </label> &nbsp;  <input style="width: 300px;color:white; " id="valuestyle" value="<?php echo strtoupper($death['recieveby']) ?>" type="text" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
     <tr>
        <td >
            <table cellspacing="" cellpadding="5" border="0" class="innerTable2">
                <tr>
                    <td rowspan="3" valign="top"><b>REMARKS/ANNOTATIONS (For LCRO/OCRG Use Only)</b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td >
            <table cellspacing="" cellpadding="5" border="0" style=" width: 100%;margin: 0 auto; font-size: 11px;">
                <tr>
                    <td colspan="8"><b>TO BE FILLED AT THE OFFICE OF THE CIVIL REGISTRAR</b></td>
                </tr>
                <tr>
                    <td   style="padding-left: 25px;">
                      <span class="colorblack">5</span>
                      <div class="container" >
                         <legend class="blox"></legend>
                       <legend class="blox"></legend>
                        <legend class="blox"></legend>
                    </div>
                    
                    </td>
                    <td  style="padding-left: 25px;">
                      <span class="colorblack">8</span>
                      <div class="container" >
                         <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       
                    </div>
                    
                    </td>
                   <td  style="padding-left: 25px;">
                      <span class="colorblack">9</span>
                      <div class="container" >
                         <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       
                    </div>
                    
                    </td>
                    <td colspan="2">
                      <span class="colorblack">10</span>
                      <div class="container" >
                         <legend class="blox"></legend>
                       <legend class="blox"></legend>
                        <legend class="blox"></legend>
                       <legend class="blox"></legend>
                        <legend class="blox"></legend>
                       <legend class="blox"></legend>
                        <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       
                    </div>
                    
                    </td>
                    <td >
                      <span class="colorblack">11</span>
                      <div class="container" >
                         <legend class="blox"></legend>
                       <legend class="blox"></legend>
                        <legend class="blox"></legend>
                    </div>
                    
                    </td>
                    <td >
                      <span class="colorblack">19a(a)/19b</span>
                      <div class="container" >
                         <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       
                    </div>
                    
                    </td>
                     <td >
                      <span class="colorblack">19a(c)</span>
                      <div class="container" >
                         <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       <legend class="blox"></legend>
                       
                    </div>
                    
                    </td>
                </tr>
            </table>
        </td>
    </tr>
  </table>
<!---->

    
    <table cellspacing="" cellpadding="0" border="1" class="outsideTable">
      <tr>
         <td><center><b>FOR CHILDREN AGED 0 TO 7 DAYS</b></center></td>
     
    </tr>
    <tr>
      <td >
            <table cellspacing="" cellpadding="3" border="0" class="innerTable2">
                <tr>
                    <td valign="top">14. AGE OF MOTHER
                        <br>
                        <label style="font-size:12px;font-weight: bold;"><center><?= $death['motherage'] ?></center></label>
                    </td>
                    <td class="borderleftonly" colspan="2" valign="top">15. METHOD OF DELIVERY <span>(Normal spontaneous vertex, if others, specify)</span> 
                        <br>
                        <label style="font-size:12px;font-weight: bold;"><center><?= $death['methodofdel'] ?></center></label>
                    </td>
                    <td class="borderleftonly" colspan="2" valign="top">16. LENGTH OF PREGNANCY <br><span>(in completed weeks)</span>
                      <br>
                        <label style="font-size:12px;font-weight: bold;"><center><?= $death['pregnancylength'] ?></center></label></td>
                </tr>
               
                
            </table>
        </td>
    </tr> 
    <tr>
      <td >
            <table cellspacing="" cellpadding="5" border="0" >
              <tr>
                <td  valign="top">17. TYPE OF BIRTH <span>(Single, Twin, Triplet, etc)</span>
                 <br>
                 <label style="font-size:12px;"><center><?php echo strtoupper($death['typeofdel']) ?></center></label>
                </td>
                <td class="borderleft"  valign="top">18. IF MULTIPLE  BIRTH, CHILD WAS <span>(First, Second, Third, etc)</span>
                 <br>
                        <label style="font-size:12px;"><center><?php echo strtoupper($death['birthorder']) ?></center></label></td>
              </tr>
            </table>
        </td>
    </tr> 
    <tr>
      <td >
            <table cellspacing="" cellpadding="5" border="0" style=" width: 100%;margin: 0 auto; font-size: 13px;">
           <tr>
               <td><center><b>MEDICAL CERTIFICATE</b></center></td>
            
            </tr>
            </table>
            </td>
    </tr>
    <tr>
      <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable">
           <tr >
               <td><label style="font-size: 12px;">19a. CAUSES OF DEATH</label>
                   <br>
                   &nbsp; &nbsp; &nbsp; &nbsp; a. Main disease/ condition of infant &nbsp;      <input style="width: 510px;" id="valuestyle" value="<?= strtoupper($death['acauseofdeath']) ?>" type="text" />
      
                <br>
                &nbsp; &nbsp; &nbsp; &nbsp; b. Other diseases/conditions of infant &nbsp; 
                 <input style="width: 500px;" id="valuestyle" value="<?= strtoupper($death['bcauseofdeath']) ?>" type="text" />
                 <br>
                &nbsp; &nbsp; &nbsp; &nbsp; c. Main maternal disease/condidtion affecting infant &nbsp; 
                <input style="width: 438px;" id="valuestyle" value="<?= strtoupper($death['ccauseofdeath']) ?>" type="text" />
               <br>
                &nbsp; &nbsp; &nbsp; &nbsp; d. Other maternal disease/condition affecting infant &nbsp; 
                <input style="width: 438px;" id="valuestyle" value="<?= strtoupper($death['dcauseofdeath']) ?>" type="text" />
               <br>
                &nbsp; &nbsp; &nbsp; &nbsp; e. Other relevant circumstances &nbsp; 
                 <input style="width: 520px;" id="valuestyle" value="<?= strtoupper($death['ecauseofdeath']) ?>" type="text" />
               <br>
                <center style="font-size: 12px;"><b>CONTINUE TO FILL UP ITEM 20</b></center>
              </td>
            
            </tr>
            </table>
            </td>
    </tr>


    </table>
 
    
    <!-- postmortem certificate of death -->

     <table cellspacing="" cellpadding="0" border="1" class="outsideTable">
      <tr>
        <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable2">
              <tr>
                <td colspan="2"><center><b style="font-size: 12px;">POSTMORTEM CERTIFICATE OF DEATH</b></center>
                  <p style="font-size: 12px;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; I HEREBY CERTIFY that I have performed an autopsy upon the body of the deceased and that the cause of death was </p>
                  
       
                <input style="width: 75px;" id="valuestyle" value="<?= strtoupper($death['postmortemcause']) ?>" type="text" />
                 
                </td>
              </tr>

               <tr>
                   <td><br> &nbsp;&nbsp;Signature &nbsp; <input style="width: 280px;color:white;" id="valuestyle" value="<?= strtoupper($death['postmortemcause']) ?>" type="text" /></td>
                   <td><br>&nbsp;&nbsp;Title/Designation &nbsp; <input style="width: 240px;" id="valuestyle" value="<?= strtoupper($death['postmortemposition']) ?>" type="text" />
                </td>
              </tr>
              <tr>
                <td> &nbsp;&nbsp;Name in Print &nbsp; <input style="width: 260px;" id="valuestyle" value="<?= strtoupper($death['postmortemname']) ?>" type="text" /></td>
                <td> &nbsp;&nbsp;Address &nbsp; <input style="width: 285px;" id="valuestyle" value="<?= strtoupper($death['postmortemaddress']) ?>" type="text" />
                </td>
              </tr>
              <tr>
                <td> &nbsp;&nbsp;Date &nbsp; <input style="width: 305px;" id="valuestyle" value="<?= strtoupper($postmortemdate) ?>" type="text" /></td>
                <td> <input style="width: 100%;" id="valuestyle" value="<?= strtoupper($death['postmortemaddress']) ?>" type="text" />
                </td>
              </tr>
              
            </table>
        </td>
    </tr>
  </table>
  <!-- certification of embalmer -->

     <table cellspacing="" cellpadding="0" border="1" class="outsideTable">
      <tr>
        <td >
            <table cellspacing="" cellpadding="0" border="0" class="innerTable2">
              <tr>
                <td colspan="2"><center><b style="font-size: 12px;">CERTIFICATION OF EMBALMER</b></center>
                  <p style="font-size: 12px;"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; I HEREBY CERTIFY that I have embalmed <input style="width: 280px;" id="valuestyle" value="<?php echo strtoupper($death['fetfname']).' '.strtoupper($death['fetmname']).' '.strtoupper($death['fetlname']) ?>" type="text" /> following all the regulations prescribed by the Department of Health. </p>
                
                </td>
              </tr>
               <tr>
                   <td><br> &nbsp;&nbsp;Signature &nbsp; <input style="width: 280px;color:white;" id="valuestyle" value="<?= strtoupper($death['embalmername']) ?>" type="text" /></td>
                   <td><br>&nbsp;&nbsp;Title/Designation &nbsp; <input style="width: 240px;" id="valuestyle" value="<?= strtoupper($death['embalmertitle']) ?>" type="text" />
                </td>
              </tr>
              <tr>
                <td> &nbsp;&nbsp;Name in Print &nbsp; <input style="width: 259px;" id="valuestyle" value="<?= strtoupper($death['embalmername']) ?>" type="text" /></td>
                <td> &nbsp;&nbsp;License No. &nbsp; <input style="width: 265px;" id="valuestyle" value="<?= strtoupper($death['embalmerlicenseno']) ?>" type="text" />
                </td>
              </tr>
              <tr>
                <td> &nbsp;&nbsp;Address &nbsp; <input style="width: 284px;" id="valuestyle" value="<?= strtoupper($death['embalmeraddress']) ?>" type="text" /></td>
                <td> &nbsp;&nbsp;Issued on &nbsp; <input style="width: 75px;" id="valuestyle" value="<?= strtoupper($embalmerissued) ?>" type="text" /> &nbsp; at &nbsp; <input style="width: 160px;" id="valuestyle" value="<?= strtoupper($death['embalmerat']) ?>" type="text" />
                </td>
              </tr>
              <tr>
                  <td> &nbsp;&nbsp;<input style="width: 350px;color:white;" id="valuestyle" value="<?= strtoupper($death['embalmeraddress']) ?>" type="text" /></td>
                <td> &nbsp;&nbsp;Issued on &nbsp; <input style="width: 280px;" id="valuestyle" value="<?= strtoupper($embalmerexpiry) ?>" type="text" /> </td>
              </tr>
            </table>
        </td>
    </tr>
  </table>


  <!-- AFFIDAVIT FOR DELAYED REGISTRATION OF DEATH -->

     <table cellspacing="" cellpadding="0" border="1" class="outsideTable">
      <tr>
        <td >
            <table cellspacing="" cellpadding="3" border="0" >
              <tr>
                <td colspan="2"><center><b style="font-size: 13px;">AFFIDAVIT FOR DELAYED REGISTRATION OF DEATH</b></center>
                  <p > &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; I, 
                      <?php if($death['affidavitname'] === "") { echo "<input  style='width:250px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 250px;' id='valuestyle' value='". strtoupper($death['affidavitname']) ."' type='text' />"; }?>
                      , of legal age, single/married/divorced/widow/widower, with residence and postal address 
                      <?php if($death['affidavitaddress'] === "") { echo "<input  style='width:400px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 400px;' id='valuestyle' value='". strtoupper($death['affidavitaddress']) ."' type='text' />"; }?>
                      , after being duly sworn in accordance with law, do hereby depose and say:</p>
                </td>
              </tr>
                <tr>
                <td colspan="2" >  
                    <p class="affidavitnumb" > 1. That &nbsp; &nbsp;&nbsp; &nbsp; <?php if($death['affdiedname'] === "" ) { echo "<input  style='width:250px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 250px;' id='valuestyle' value='". strtoupper($death['affdiedname']) ."' type='text' />"; }?>
                        , died on  
                       &nbsp; &nbsp;   <?php if($death['affdieddate'] === "0000-00-00" || $death['affdieddate'] === "1970-01-01" ) { echo "<input  style='width:100px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 100px;' id='valuestyle' value='". strtoupper($death['affdieddate']) ."' type='text' />"; }?>
                        in  
                       <br> <?php if($death['affdiedaddr'] === "") { echo "<input  style='width:500px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 500px;' id='valuestyle' value='". strtoupper($death['affdiedaddr']) ."' type='text' />"; }?>  
                       and was buried/cremated in
                        <!--<input  style="width: 400px;" id="valuestyle" value="<?= strtoupper($death['affburiedadd'])?>" type='text' />-->
                       <br>  <?php if($death['affburiedadd'] === "") { echo "<input  style='width:400px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 400px;' id=valuestyle value='". strtoupper($death['affburiedadd']) ."' type=text />"; }?>  on
                       <?php if($death['affburieddate'] === "0000-00-00" || $death['affburieddate'] === "1970-01-01" ) { echo "<input  style='width:100px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 100px;' id='valuestyle' value='". strtoupper($death['affburieddate']) ."' type='text' />"; }?>
                        .</p>
                </td>
              </tr>
              <tr>
                <td colspan="2" >  
                 <p class="affidavitnumb"> 2. That the deceased at the time of his/her death:
                     <br>&nbsp; &nbsp;&nbsp; &nbsp; <?php if($death['affattended'] === "attend"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?> was attended by <?php if($death['affattendedby'] === "") { echo "<input  style='width:250px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 250px;' id='valuestyle' value='". strtoupper($death['affattendedby']) ."' type='text' />"; }?>;
                  <br>&nbsp; &nbsp;&nbsp; &nbsp; <?php if($death['affattended'] === "unattend"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?> was not attended.
                 </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" >  
                 <p class="affidavitnumb"> 3. That the cause of death of the deceased was 
                <?php if($death['affcod'] === "") { echo "<input style='width: 400px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 400px;' id='valuestyle' value='". strtoupper($death['affcod'])."' type='text' />"; }?>
               
                 </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" >  
                 <p class="affidavitnumb"> 4. That the reason for the delay in registering this death was due to 
                <?php if($death['reasonfordelay'] === "") { echo "<input style='width: 300px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 300px;' id='valuestyle' value='". strtoupper($death['reasonfordelay'])."' type='text' />"; }?>.
                 </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" >  
                 <p class="affidavitnumb"> 5. That I am executing this affidavit to attest to the truthfulness of the foregoing statemts for all legal intents and purposes.
                 </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" >  
                 <p >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; In truth whereof, I have affixed my signature below this 
                     <?php if($death['affidavitday'] === "") { echo "<input style='width: 50px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 50px;' id='valuestyle' value='". strtoupper($death['affidavitday'])."' type='text' />"; }?>
                   day of   
                   <?php if($death['affidavitmonth'] === "") { echo "<input style='width: 100px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 100px;' id='valuestyle' value='". strtoupper($death['affidavitmonth'])."' type='text' />"; }?>
                  ,   
                   <?php if($death['affidavityear'] === null) { echo "<input style='width: 100px;color:white;' id='valuestyle' value='N/A' type='text' /> "; }else {echo "<input style='width: 100px;' id='valuestyle' value='". strtoupper($death['affidavityear'])."' type='text' /> "; }?> at   
                    <br><?php if($death['affidavitat'] === "") { echo "<input style='width: 250px;color:white;' id='valuestyle' value='N/A' type='text' /> "; }else {echo "<input style='width: 250px;' id='valuestyle' value='". strtoupper($death['affidavitat'])."' type='text' /> "; }?> , Philippines.
                 </p>
                </td>
              </tr>
              <tr>
                <td> </td>
                <td><br><center><?php if($death['affiantname'] === "") { echo "<input style='width: 250px;text-align:center;margin-left:50px;color:white;' id='valuestyle' value='N/A' type='text' /> "; }else {echo "<input style='width: 250px;text-align:center;margin-left:50px;' id='valuestyle' value='". strtoupper($death['affiantname'])."' type='text' /> "; }?> <br>
                (Signature Over Printed Name of Affiant)</center></td>
              </tr>
              <tr>
                <td colspan="2" >  
                 <p style="text-align: justify"><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>SUBSCRIBED AND SWORN </b> to before me this  
                    <span>_____________________</span> day of   <span>____________________________</span>,   <span>______________________</span> at   <span>________________________________________________</span>, Philippines, affiant who exhibited to me his Community Tax Cert. <span>_____________________</span> issued on <span>_____________________</span> at <span>________________________________________________</span>.
                 </p>
                </td>
              </tr>
                 <tr>
                <td><center> <span>________________________________________________</span><br>
                Signature of the Administering Officer</center></td>
                <td><center> <span>________________________________________________</span><br>
                Position/ Title/ Designation </center></td>
              </tr>
               </tr>
                 <tr>
                <td><center> <span>________________________________________________</span><br>
                Name in Print</center></td>
                <td><center> <span>________________________________________________</span><br>
                Address</center></td>
              </tr>
              
              
            </table>
        </td>
    </tr>
  </table>
    
   
</body>
</html>
