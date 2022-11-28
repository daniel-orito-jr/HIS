<html>
<head>
    <meta charset="utf-8">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png')?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> CERTIFICATE OF FETAL DEATH</title>
    <style>
        
        html
        {
         
          font-family: sans-serif;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        }      

        table, td, th {    
            border: 1px solid black;
            text-align: left;
         
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid black;
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
        .blue{                                            
            background-color: #29b6f6;
            width:auto; 
            height:80px;
        }
        .darkblue{
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
        
        #monthbed
        {
             width: 15%;
               text-align: center;
               border-top-color: transparent;
        }
        #centered
        {
             text-align: center;
             font-weight: bold;
        }
        #mbor
        {
             width: 50%;
              text-align: center;
        }
        
        .vericaltext{
            width:1px;
            word-wrap: break-word;
            font-family: monospace; /* this is just for good looks */
        }
        
        .tae {
            border-width: thin;
            border-style: solid;
            border-color: black;
            width: 17px;
            height: 17px;
            margin-left: 5px;
        }
        
         #valuestyle
        {
            
            font-size:11px;  
            border: 0;outline: 0;
            background: transparent;
            border-bottom: solid #455ae0 thin;
            font-weight: bold;
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
    <?php//-------------HEADER------------ ?>
    
    <table cellspacing="" cellpadding="0" border="1" style=" width: 100%;margin: 0 auto; font-size: 10px;">
        <tr >
            <td colspan="2">
            <table cellspacing="" cellpadding="0" border="0" style=" width: 100%;margin: 0 auto; font-size: 10px;">
           <tr>
               <td >Municipal Form No. 103A</td>
               <td></td>
               <td style="text-align: right;">(To be accomplished in 6578345564 using black ink.)</td>
           </tr>
            <tr>
               <td>(Revised January 2007</td>
               <td style="font-size:11px;"><center>Republic of the Philippines</center></td>
               <td></td>
           </tr>
             <tr>

               <td style="font-size:12px;" colspan="3"><center>OFFICE OF THE CIVIL REGISTRAR GENERAL</center></td>

           </tr>
             <tr>

                 <td style="font-size:24px;" colspan="3"><center><b>CERTIFICATE OF FETAL DEATH</b></center></td>

           </tr>
            </table>
            </td>
            
    </tr>
    <tr>
        <td colspan="2">
            <table cellspacing="" cellpadding="5" border="0" style=" width: 100%;margin: 0 auto; font-size: 10px;">
           <tr>
               <td colspan="2" >Province <input style="width: 400px;" id="valuestyle" value="<?php echo strtoupper($profile['compprovince']) ?>" type="text" /></td>
               <td rowspan="2" style="border-left: solid ;"  valign="top">Registry No.</td>
              
           </tr>
            <tr>
              <td colspan="2" >City/Municipality <input style="width: 365px;" id="valuestyle" value="<?= strtoupper($profile['compcity']) ?>" type="text" /></td>
        
            </table>
        </td>
    </tr>
     <tr>
        <td style="padding: 5px; font-size: 11px; font-weight: bold" width="3%">
            F<br>E<br>T<br>U<br>S
        </td>
        <td>
            <table cellspacing="" cellpadding="2" style="border: none; width: 100%;margin: 0 auto; font-size: 10px; text-align: top">
                <tr>
                    <td colspan="6" >
                        1. NAME &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(First)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Middle)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Last)</span><br>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <span style="font-size: 11px"><b><?php if($death['fetfname'] === "") { echo "N/A"; }else {echo strtoupper($death['fetfname']); }?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death['fetmname'] === "") { echo "N/A"; }else {echo strtoupper($death['fetmname']); }?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death['fetlname'] === "") { echo "N/A"; }else {echo strtoupper($death['fetlname']); }?></b></span>
                    </td>
                    
                </tr>
                
                <tr>
                    <td colspan="2">
                        2. SEX&nbsp;&nbsp;<span style="font-size: 8px;">(Male/Female/Undetermined)</span><br>
                <center><b><?php if($death['fetgender'] === "") { echo "N/A"; }else {echo strtoupper($death['fetgender']); }?></b></center>
                    </td>
                    <td colspan="4" >
                        3. DATE OF
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Day)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <span style="font-size: 8px">(Month)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <span style="font-size: 8px">(Year)</span>
                        <br>DELIVERY
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($dateofdelday === "") { echo "N/A"; }else {echo strtoupper($dateofdelday); }?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($dateofdelday === "") { echo "N/A"; }else {echo strtoupper($dateofdelmonth); }?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($dateofdelday === "") { echo "N/A"; }else {echo strtoupper($dateofdelyear); }?></b></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" >
                        4. PLACE OF 
                        &nbsp;&nbsp;
                        <span style="font-size: 10px">(Name of Hospital/Clinic/Institution/House No.,St., Barangay)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 10px">(City/Municipality)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 10px">(Province)</span>
                        <br>DELIVERY 
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death["placeofdel"] === "") { echo "N/A"; }else {echo strtoupper($death["placeofdel"]); }?></b></span>
                    </td>
                </tr>
                <tr>
                    
                    <td colspan="3">
                        5a. TYPE OF DELIVERY <span style="font-size: 8px">(Single, Twin, Triplet, etc.)</span>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death["typeofdel"] === "") { echo "N/A"; }else {echo strtoupper($death["typeofdel"]); }?></b></span>
                    </td>
                    <td colspan="3" >
                        5b. IF MULTIPLE DELIVERY, FETUS WAS <span style="font-size: 8px">(First, Second, Third, etc.)</span>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death["deliveryorder"] === "") { echo "N/A"; }else {echo strtoupper($death["deliveryorder"]); }?></b></span>
                    
                    </td>
                </tr>
                <tr>
                    <td colspan="2" >
                        5c. METHOD OF DELIVERY <span style="font-size: 8px">(Normal spontaneous vertex, if others, specify)</span>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death["methodofdel"] === "") { echo "N/A"; }else {echo strtoupper($death["methodofdel"]); }?></b></span>
                    
                    </td>
                    <td colspan="2">
                        5d. BIRTH ODER <span style="font-size: 8px">(live births and fetal deaths including this delivery) (First,Second,Third, etc.)</span>
                    <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death["birthorder"] === "") { echo "N/A"; }else {echo strtoupper($death["birthorder"]); }?></b></span>
                    
                    </td>
                    <td colspan="2" width="30%" >
                        5e. WEIGHT OF FETUS
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php if($death["fetusweight"] === "") { echo "N/A"; }else {echo strtoupper($death["fetusweight"]); }?> grams</b></span>
                    
                    </td>
                </tr>
            </table>
        </td>
    </tr>
     <tr>
        <td style="padding: 5px; font-size: 11px; font-weight: bold" width="3%">
            M<br>O<br>T<br>H<br>E<br>R
        </td>
        <td>
            <table cellspacing="" cellpadding="2" style="border: none; width: 100%;margin: 0 auto; font-size: 10px; text-align: top">
                <tr>
                    <td colspan="12" >
                        6. MAIDEN NAME &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(First)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Middle)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Last)</span>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["motfname"]); ?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["motmname"]); ?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["motlname"]); ?></b></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        7. CITIZENSHIP
                        <br>
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["motcitizenship"]); ?></b></span>
                    </td>
                    <td colspan="3">
                        8. RELIGION/RELIGIOUS SECT
                        <br>
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["motreligion"]); ?></b></span>
                    </td>
                    <td colspan="3">
                        9. OCCUPATION
                        <br>
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["motoccupation"]); ?></b></span>
                    </td>
                    <td colspan="3">
                        10. AGE at the time of this delivery &nbsp;&nbsp;<span style="font-size: 8px;">(completed years)</span>
                     
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["motage"]); ?></b></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" >
                        11a. Total number of children born alive 
                        <br>
                        <span style="font-size: 11px"><b><center><b><?php  echo strtoupper($death["childbornalive"]); ?></b></center></b></span>
                    </td>
                    <td colspan="4" >
                        11b. No. of children still living
                         <br>
                        <span style="font-size: 11px"><b><center><b><?php  echo strtoupper($death["childliving"]); ?></b></center></b></span>
                    </td>
                    <td colspan="4" >
                        11c. No. of children born alive but are now dead
                        <br>
                        <span style="font-size: 11px"><b><center><b><?php  echo strtoupper($death["childdead"]); ?></b></center></b></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="12" >
                        5a. RESIDENCE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(House No., St., Barangay)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(City/Municipality)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Province)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Country)</span>
                        <br>
                        <span style="font-size: 11px"><b><center><b><?php  echo strtoupper($death["motresidence"]); ?></b></center></b></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 5px; font-size: 11px; font-weight: bold" width="3%">
            F<br>A<br>T<br>H<br>E<br>R
        </td>
        <td>
            <table cellspacing="" cellpadding="2" style="border: none; width: 100%;margin: 0 auto; font-size: 10px; text-align: top;">
                <tr>
                    <td colspan="12" style="padding-bottom:10px;">
                        13. NAME &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(First)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Middle)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Last)</span>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["fatfname"]); ?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["fatmname"]); ?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["fatlname"]); ?></b></span>
                    </td>
                </tr>
                <tr >
                    <td colspan="3" style="border-bottom:none;">
                        14. CITIZENSHIP
                        <br>
                        <span style="font-size: 11px"><center><b><?php  echo strtoupper($death["fatcitizenship"]); ?></b></center></span>
                    </td>
                    <td colspan="3" style="border-bottom:none;">
                        15. RELIGION/RELIGIOUS SECT
                        <br>
                        <span style="font-size: 11px"><center><b><?php  echo strtoupper($death["fatreligion"]); ?></b></center></span>
                    </td>
                    <td colspan="3" style="border-bottom:none;">
                        16. OCCUPATION
                        <br>
                        <span style="font-size: 11px"><center><b><?php  echo strtoupper($death["fatoccupation"]); ?></b></center></span>
                    </td>
                    <td colspan="3" style="border-bottom:none;">
                        17. AGE at the time of this delivery &nbsp;&nbsp;<span style="font-size: 8px;">(completed years)</span>
                        <br>
                        <span style="font-size: 11px"><center><b><?php  echo strtoupper($death["fatage"]); ?></b></center></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table cellspacing="" cellpadding="2" style="border: none; width: 100%;margin: 0 auto; font-size: 10px; text-align: top">
                <tr>
                    <td colspan="12">
                        <span>MARRIAGE OF PARENTS</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        18a. DATE &nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Month)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Day)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Year)</span>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($mdatemonth); ?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <span style="font-size: 11px"><b><?php  echo strtoupper($mdateday); ?></b></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($mdateyear); ?></b></span>
                    </td>
                    <td colspan="6" >
                        18b. PLACE &nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(City/Municipality)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Province)</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="font-size: 8px">(Country)</span>
                        <br>
                       
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["marriagecity"]); ?></b></span>&nbsp;&nbsp;
                       <span style="font-size: 11px"><b><?php  echo strtoupper($death["marriageprovince"]); ?></b></span>&nbsp;&nbsp;
                        <span style="font-size: 11px"><b><?php  echo strtoupper($death["marriagecountry"]); ?></b></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="12">
                        <center><b>MEDICAL CERTIFICATE</b></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="12">
                        19. CAUSES OF FETAL DEATH <br>
                            &nbsp;&nbsp;&nbsp;a. Main disease/condition of fetus <input style="width: 545px;" id="valuestyle" value="<?= strtoupper($death['acauseofdeath']) ?>" type="text" /><br>
                            &nbsp;&nbsp;&nbsp;b. Other disease/conditions of the fetus <input style="width: 520px;" id="valuestyle" value="<?= strtoupper($death['bcauseofdeath']) ?>" type="text" /><br>
                            &nbsp;&nbsp;&nbsp;c. Main maternal disease/condition affecting fetus <input style="width: 475px;" id="valuestyle" value="<?= strtoupper($death['ccauseofdeath']) ?>" type="text" /><br>
                            &nbsp;&nbsp;&nbsp;d. Other disease/condition of fetus <input style="width: 543px;" id="valuestyle" value="<?= strtoupper($death['dcauseofdeath']) ?>" type="text" /><br>
                            &nbsp;&nbsp;&nbsp;e. Other relevant circumstances <input style="width: 551px;" id="valuestyle" value="<?= strtoupper($death['ecauseofdeath']) ?>" type="text" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border:0;">
                        20. FETUS DIED:  
<!--                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php if($death['fetdied']==="Before Labor"){echo '<span style="font-family: DejaVu Sans;font-size: 12px;text-decoration: none; border-bottom:thin;border-color:blue;">____✓____</span>';}else{echo '<span style="font-family: DejaVu Sans;font-size: 12px;text-decoration: none; border-bottom:thin;border-color:blue;">_________</span>';}?> 1 Before Labor 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php if($death['fetdied']==="During Labor/Delivery"){echo '<span style="font-family: DejaVu Sans;font-size: 12px; border-bottom: 5px solid red;" >✓</span>';}else{echo '<span style="font-family: DejaVu Sans;font-size: 12px;text-decoration: none; border-bottom:thin;border-color:blue;">_________</span>';}?>2 During Labor/Delivery 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3 Unknown-->
                    </td>
                    <td colspan="1" style="border:0;"> <?php if($death['fetdied'] === "Before Labor") { echo "<label class='attendant' ><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td colspan="2" style="border:0;"> 1. Before Labor</td>
                    <td colspan="1" style="border:0;"> <?php if($death['fetdied'] === "During Labor/Delivery") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td colspan="2" style="border:0;"> 2. During Labor/Delivery</td>
                    <td colspan="1" style="border:0;"> <?php if($death['fetdied'] === "Unknown") { echo "<label class='attendant'><center>✓</center></label> "; }else {echo "<label class='attendant' style='color:white;'><center>N/A</center></label>  "; }?></td>
                    <td colspan="2" style="border:0;">3. Unknown</td>
                  
                    
                  
                
                </tr>
                <tr>
                    <td colspan="4" >
                        21. LENGTH OF PREGNANCY <span style="font-size: 8px">(in completed weeks)</span>
                <br><center> <span style="font-size: 11px"><b><?php  echo strtoupper($death["pregnancylength"]); ?></b></span></center>
                    </td>
                    <td colspan="8" >
                        22a. ATTENDANT <span style="font-size: 8px">(Physician, Nurse, Midwife, Hilot or Traditional Birth, none, others(specify))</span>
                    <br> <center><span style="font-size: 11px"><b><?php  echo strtoupper($death["attendant"]); ?></b></span></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="12">
                        22b. CERTIFICATE OF FETAL DEATH <br>
                        <!--<span class="tae"></span>-->
                        <div style="font-size: 9px;">I hereby certify that the foregoing particulars are correct as near as same can be ascertained and further certify that I &nbsp;<?php if($death['attended'] === "attended"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?> have attended/ &nbsp;<?php if($death['attended'] === "unattended"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?> have not attended the death of the fetus at <span id="valuestyle" style="font-size: 11px"><b><?php  echo strtoupper($death["deathtime"]); ?></b></span> am/pm on the date of delivery specified above.</div>
                        
                        <table border="0">
                            <tr>
                                <td>
                                     <div style="margin-top: 5px; float: left; width: 100%">
                                        Signature &nbsp;&nbsp;______________________________________________________<br>
                                        Name in Print &nbsp;&nbsp;<input style="width: 275px;" id="valuestyle" value="<?= strtoupper($death['attname']) ?>" type="text" /><br>
                                        Title or Position &nbsp;<input style="width: 270px;" id="valuestyle" value="<?= strtoupper($death['attposition']) ?>" type="text" /><br>
                                        Address &nbsp;<input style="width: 300px;" id="valuestyle" value="<?= strtoupper($death['attaddress']) ?>" type="text" /><br>
                                        _________________________________________ Date &nbsp;<input style="width: 90px;" id="valuestyle" value="<?= strtoupper($attdate) ?>" type="text" />
                                    </div>
                                </td>
                                <td>
                                    <div style="border-style: solid; border-width: thin; margin-top: 5px; float: left; width: 100%; height: 60px;padding-bottom: 30px;">
                                        <b>REVIEWED BY: </b><br><br>
                                        <center>
                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input style="width: 270px;" id="valuestyle" value="<?= strtoupper($death['reviewby']) ?>" type="text" /><br>
                                            Signature Over Printed Name of Health Officer<br>
                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input style="width: 200px;" id="valuestyle" value="<?= strtoupper($reviewdate) ?>" type="text" /><br>
                                            Date
                                        </center>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top">
                        23. CORPSE DISPOSAL<br>
                        <span style="font-size: 9px">(Burial,Cremation,if others, specify)</span>
                        <br><center> <span style="font-size: 11px"><b><?php  echo strtoupper($death["corpsedisposal"]); ?></b></span></center>
                    </td>
                    <td colspan="5" >
                        24. BURIAL/CREMATION PERMIT<br>
                        Number &nbsp; <input style="width: 245px;" id="valuestyle" value="<?= strtoupper($death['burialno']) ?>" type="text" /><br>
                        Date Issued &nbsp; <input style="width: 230px;" id="valuestyle" value="<?= strtoupper($burialdateissue) ?>" type="text" />
                    </td>
                    <td colspan="2" valign="top">
                        25. AUTOPSY<br>
                        <span style="font-size: 9px">(Yes/No)</span> <br> <center><span style="font-size: 11px"><b><?php  echo strtoupper($death["autopsy"]); ?></b></span></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="12" >
                        26. NAME AND ADDRESS OF CEMETERY OF CREMATORY<br>
                        <center><span style="font-size: 11px"><b><?php  echo strtoupper($death["cemetery"]); ?></b></span></center>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="6">
                        27. CERTIFICATION OF INFORMANT
                        <p style="text-indent: 30px; margin-top: -2px;">I hereby certify that all information supplied are true and correct to my own knowledge and belief.</p>
                        <div>
                            Signature  _______________________________________________________<br>
                            Name in print &nbsp;&nbsp;<input style="width: 275px;" id="valuestyle" value="<?= strtoupper($death['informantname']) ?>" type="text" /><br>
                            Relationship to the Deceased &nbsp;&nbsp;<input style="width: 205px;" id="valuestyle" value="<?= strtoupper($death['informantrelation']) ?>" type="text" /><br>
                            Address &nbsp;&nbsp;<input style="width: 298px;" id="valuestyle" value="<?= strtoupper($death['informantaddress']) ?>" type="text" /><br>
                            Date <input style="width: 320px;" id="valuestyle" value="<?= strtoupper($informantdate) ?>" type="text" />
                        </div>
                        
                    </td>
                    <td valign="top" colspan="6">
                        28. PREPARED BY
                        <div style="margin-top: 30px">
                            Signature  _______________________________________________________<br>
                            Name in print &nbsp;&nbsp;<input style="width: 275px;" id="valuestyle" value="<?= strtoupper($death['preparedby']) ?>" type="text" /><br>
                            Title or Position &nbsp;<input style="width: 270px;" id="valuestyle" value="<?= strtoupper($death['prepareposition']) ?>" type="text" /><br>
                            Date <input style="width: 320px;" id="valuestyle" value="<?= strtoupper($preparedate) ?>" type="text" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        29. RECEIVED BY
                        <div>
                            Signature  _______________________________________________________<br>
                            Name in print &nbsp;&nbsp;<input style="width: 275px;" id="valuestyle" value="<?= strtoupper($death['recieveby']) ?>" type="text" /><br>
                            Title or Position &nbsp;<input style="width: 270px;" id="valuestyle" value="<?= strtoupper($death['recieveposition']) ?>" type="text" /><br>
                            Date <input style="width: 320px;" id="valuestyle" value="<?= strtoupper($receivedate) ?>" type="text" />
                        </div>
                        
                    </td>
                    <td valign="top" colspan="6">
                        30. REGISTERED BY THE CIVIL REGISTRAR
                        <div>
                            Signature  _______________________________________________________<br>
                            Name in print &nbsp;&nbsp;<input style="width: 275px;color:white;" id="valuestyle" value="<?= strtoupper($death['recieveby']) ?>" type="text" /><br>
                            Title or Position &nbsp;<input style="width: 270px;color:white;" id="valuestyle" value="<?= strtoupper($death['recieveposition']) ?>" type="text" /><br>
                            Date <input style="width: 320px;color:white;" id="valuestyle" value="<?= strtoupper($receivedate) ?>" type="text" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border-color: black; border-width: 2px; font-weight: bold;font-size: 12px; padding-bottom: 20px;" colspan="12">
                        REMARKS/ANNOTATIONS (For LCRO/OCRG Use Only)
                    </td>
                </tr>
                <tr>
                    <td style="border-color: black; border-width: 2px; padding-bottom: 20px;" colspan="12">
                        <b>TO BE FILLED-UP AT THE OFFICE OF THE CIVIL REGISTRAR</b><br>
                        <div style="height: 50px">
                            <table border="0">
                                <tr>
                                    <td>
                                        7
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td>
                                        8
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td>
                                        9
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td colspan="3">
                                        12
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -3px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -3px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td>
                                        14
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td>
                                        15
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        16
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        19a
                                        <div>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        
                                        <div style="margin-left: -50px;">
                                            19c
                                            <div>
                                                <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;"></legend>
                                                <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                                <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                                <legend style="border-style: dashed; border-width: thin; width: 17px; height: 17px;margin-left: -2px;"></legend>
                                            </div>
                                            
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
    
    <table cellspacing="" cellpadding="5" border="1" style=" width: 100%;margin: 0 auto; font-size: 10px;">
        <tr>
            <td colspan="2" style="border-bottom: none;">
                <center>
                    <h2>POSTMORTEM CERTIFICATE OF FETAL DEATH</h2> 
                </center>
        <p style="font-size: 12px; text-indent: 50px; padding: 5px; text-align: justify;">
            I HEREBY CERTIFY that I have performed an autopsy upon the body of the deceased this &nbsp;&nbsp; <input style="width: 75px;" id="valuestyle" value="<?= strtoupper($death['postmortemday']) ?>" type="text" /> day of <BR>
                    <input style="width: 75px;" id="valuestyle" value="<?= strtoupper($death['postmortemmonth']) ?>" type="text" /> and that the cause of death was as follows 
                    <input style="width: 350px;color:white;" id="valuestyle" value="<?= strtoupper($death['postmortemcause']) ?>" type="text" /><br>
                    <input style="width:100%;text-align:left;" id="valuestyle" value="<?= strtoupper($death['postmortemcause']) ?>" type="text" />
              
        </p>
            </td>
        </tr>
        <tr>
            <td style="border-top: none; border-right: none;font-size: 11px">
                <div>
                    Signature  _______________________________________________<br>
                    Name in print &nbsp;&nbsp;<input style="width: 250px;" id="valuestyle" value="<?= strtoupper($death['postmortemname']) ?>" type="text" /><br>
                    Date <input style="width: 300px;" id="valuestyle" value="<?= strtoupper($postmortemdate) ?>" type="text" />
                    
                            
                            
            </td>
            <td style="border-top: none; border-left: none; font-size: 11px">
                <div>
                    Title or Position &nbsp;<input style="width: 250px;" id="valuestyle" value="<?= strtoupper($death['postmortemposition']) ?>" type="text" /><br>
                    Address <input style="width: 290px;" id="valuestyle" value="<?= strtoupper($death['postmortemaddress']) ?>" type="text" />
                </div>
            </td>
        </tr>
    </table>
    <table cellspacing="" cellpadding="5" border="1" style=" width: 100%;margin: 0 auto; font-size: 10px; margin-top: 3px;">
        <tr>
            <td colspan="2" style="border-bottom: none;">
                <center>
                    <h3>CERTIFICATION OF EMBALMER</h3> 
                </center>
        <p style="font-size: 12px; text-indent: 50px; padding: 5px; text-align: justify;">
                    I HEREBY CERTIFY that I have embalmed <input style="width: 250px;" id="valuestyle" value="<?= strtoupper($death['embalmedpatient']) ?>" type="text" /> following
                    all the regulations <br>prescribed by the Department of Health.
        </p>
            </td>
        </tr>
        <tr>
            <td style="border-top: none; border-right: none;font-size: 11px">
                <div>
                    Signature  __________________________________________<br>
                    Name in print &nbsp;&nbsp;<input style="width: 250px;" id="valuestyle" value="<?= strtoupper($death['embalmername']) ?>" type="text" /><br>
                    Address <input style="width: 290px;" id="valuestyle" value="<?= strtoupper($death['embalmeraddress']) ?>" type="text" />
            </td>
            <td style="border-top: none; border-left: none; font-size: 11px">
                <div>
                    Title or Position &nbsp;<input style="width: 250px;" id="valuestyle" value="<?= strtoupper($death['embalmertitle']) ?>" type="text" /><br>
                    License No.&nbsp;<input style="width: 270px;" id="valuestyle" value="<?= strtoupper($death['embalmerlicenseno']) ?>" type="text" /><br>
                    Issued on <input style="width: 100px;" id="valuestyle" value="<?= strtoupper($embalmerissued) ?>" type="text" /> at <input style="width: 158px;" id="valuestyle" value="<?= strtoupper($death['embalmerat']) ?>" type="text" /><br>
                    Expiry Date <input style="width: 270px;" id="valuestyle" value="<?= strtoupper($embalmerexpiry) ?>" type="text" />
                </div>
            </td>
        </tr>
    </table>
    
    <table cellspacing="" cellpadding="5" border="1" style=" width: 100%;margin: 0 auto; font-size: 10px;margin-top: 3px;">
        <tr>
            <td style="border-bottom: none;">
                <center>
                    <h3>AFFIDAVIT FOR DELAYED REGISTRATION OF FETAL DEATH</h3> 
                </center>
                <p style="font-size: 12px; text-indent: 50px; padding: 5px; text-align: justify;">
                            I,<?php if($death['affidavitname'] === "") { echo "<input  style='width:250px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 250px;' id='valuestyle' value='". strtoupper($death['affidavitname']) ."' type='text' />"; }?>, of legal age, single/married/divorced/widower, with
                            residence and postal address 
                            <?php if($death['affidavitaddress'] === "") { echo "<input  style='width:400px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 400px;' id='valuestyle' value='". strtoupper($death['affidavitaddress']) ."' type='text' />"; }?>,
                            after being duly sworn in accordance with law,do hereby depose and say: 
                </p>
                <div style="margin-left: 50px;">
                    <p style="font-size: 12px; text-align: justify;">
                        1. That &nbsp; &nbsp;&nbsp; &nbsp; <?php if($death['affdiedname'] === "" ) { echo "<input  style='width:250px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 250px;' id='valuestyle' value='". strtoupper($death['affdiedname']) ."' type='text' />"; }?>
                        , died on  
                       &nbsp; &nbsp;   <?php if($death['affdieddate'] === "0000-00-00" || $death['affdieddate'] === "1970-01-01" ) { echo "<input  style='width:100px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 100px;' id='valuestyle' value='". strtoupper($affdieddate) ."' type='text' />"; }?>
                        in  
                       <br> <?php if($death['affdiedaddr'] === "") { echo "<input  style='width:500px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 500px;' id='valuestyle' value='". strtoupper($death['affdiedaddr']) ."' type='text' />"; }?>  
                       and was buried/cremated in
                        <!--<input  style="width: 400px;" id="valuestyle" value="<?= strtoupper($death['affburiedadd'])?>" type='text' />-->
                       <br>  <?php if($death['affburiedadd'] === "") { echo "<input  style='width:400px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 400px;' id=valuestyle value='". strtoupper($death['affburiedadd']) ."' type=text />"; }?>  on
                       <?php if($death['affburieddate'] === "0000-00-00" || $death['affburieddate'] === "1970-01-01" ) { echo "<input  style='width:100px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 100px;' id='valuestyle' value='". strtoupper($affburieddate) ."' type='text' />"; }?>
                    </p>
                    <p style="font-size: 12px; text-align: justify;">
                        2. That the fetus at the time of his/her death:<br>
                        <br>&nbsp; &nbsp;&nbsp; &nbsp; <?php if($death['affattended'] === "attend"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?> was attended by <?php if($death['affattendedby'] === "") { echo "<input  style='width:250px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input  style='width: 250px;' id='valuestyle' value='". strtoupper($death['affattendedby']) ."' type='text' />"; }?>;
                        <br>&nbsp; &nbsp;&nbsp; &nbsp; <?php if($death['affattended'] === "unattend"  ) { echo "<input type='checkbox' style='display:inline;' checked>"; }else {echo "<input type='checkbox' style='display:inline;'>"; }?> was not attended.
                    </p>
                    <p style="font-size: 12px; text-align: justify;">
                        3. That the cause of death of the fetus was 
                <?php if($death['affcod'] === "") { echo "<input style='width: 400px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 400px;' id='valuestyle' value='". strtoupper($death['affcod'])."' type='text' />"; }?>
                    </p>
                    <p style="font-size: 12px; text-align: justify;">
                        4. That the reason for the delay in registering this fetal death was due to 
                <?php if($death['reasonfordelay'] === "") { echo "<input style='width: 250px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 250px;' id='valuestyle' value='". strtoupper($death['reasonfordelay'])."' type='text' />"; }?>.
                    </p>
                    <p style="font-size: 12px; text-align: justify;">
                        5. That I am executing this affidavit to attest to the truthfulness of the foregoing statements for all legal intents and purposes.
                        
                    </p>
                    <p style="font-size: 12px; ">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; In truth whereof, I have affixed my signature below this 
                     <?php if($death['affidavitday'] === "") { echo "<input style='width: 50px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 50px;' id='valuestyle' value='". strtoupper($death['affidavitday'])."' type='text' />"; }?>
                   day of   
                   <?php if($death['affidavitmonth'] === "") { echo "<input style='width: 75px;color:white;' id='valuestyle' value='N/A' type='text' />"; }else {echo "<input style='width: 75px;' id='valuestyle' value='". strtoupper($death['affidavitmonth'])."' type='text' />"; }?>
                  ,   
                   <?php if($death['affidavityear'] === null) { echo "<input style='width: 75px;color:white;' id='valuestyle' value='N/A' type='text' /> "; }else {echo "<input style='width: 75px;' id='valuestyle' value='". strtoupper($death['affidavityear'])."' type='text' /> "; }?> at   <br>
                    <?php if($death['affidavitat'] === "") { echo "<input style='width: 350px;color:white;' id='valuestyle' value='N/A' type='text' /> "; }else {echo "<input style='width: 350px;' id='valuestyle' value='". strtoupper($death['affidavitat'])."' type='text' /> "; }?> , Philippines.
                 </p>
                    
                    <p style="font-size: 12px; text-align: center; margin-left: 400px;margin-top: 30px;">
                        <?php if($death['affiantname'] === "") { echo "<input style='width: 250px;text-align:center;color:white;' id='valuestyle' value='N/A' type='text' /> "; }else {echo "<input style='width: 250px;text-align:center;' id='valuestyle' value='". strtoupper($death['affiantname'])."' type='text' /> "; }?> <br>
                (Signature Over Printed Name of Affiant)
                    </p>
                </div>
                
                <di>
                    <p style="font-size: 12px; text-align: justify; text-indent: 50px;">
                        <b>SUBSCRIBED AND SWORN </b>to before me this _______ day of ________________________________,_____ at
                        ___________________________________________, Philippines, affiant who exhibited to me his Community Tax Cert.
                        __________________________ issued on ________________________________ at ___________________________________.
                    </p>
                </di>
                
                <div>
                    <table cellpadding="20" border="0" style="font-size: 12px; margin-top: 20px;">
                        <tr>
                            <td style="text-align: center">
                                _________________________________________<br>
                                Signature of the Administering Officer
                            </td>
                            <td style="text-align: center">
                                ______________________________________________<br>
                                Position/Title/Designation
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">
                                _________________________________________<br>
                                Name in Print
                            </td>
                            <td style="text-align: center">
                                ______________________________________________<br>
                                Address
                            </td>
                        </tr>
                    </table>
                </div>
                
            </td>
        </tr>
    </table>
</body>
</html>
