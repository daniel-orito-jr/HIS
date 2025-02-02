<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title>B. Discharges</title>
    <style>
        html
        {
            font-size: 12px;
          font-family: sans-serif;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        }      

        table {    
            border: 2px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
             padding: 6px;
             border: 2px solid #ddd;
        }
        
        td
        {
            border: 2px solid #ddd;
        }
        
        #rightalign
        {
             text-align:right;
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
            margin-left: 50px;
            width:60px;
            height:60px;
        }     
    </style>
</head>

<body>
    <?php//-------------HEADER------------ ?>
    <table border="0">
        <tr>
            <td>
                <img class="imageSize" src="<?= base_url('assets/img/doh.jpg'); ?>" alt="Logo"/>
            </td>
            <td colspan="4">
                <span  style="font-size: 13px;"><center><b>Republic of the Philippines <br> 
                            Department of Health<br>  
                            HEALTH FACILITIES AND SERVICES REGULATORY BUREAU
                </b></center></span>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right;">
                <span >ANNEX – E	<br> A.O. No. 2012-0012</span>
            </td>
        </tr>
    </table>
    <h4>B. Discharges (<?= $year ?>)</h4>
    
    <table>
        <thead style="font-size: 11px;">
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
                <th style="vertical-align : middle;text-align:center;">&lt;48 hrs</th>
                <th style="vertical-align : middle;text-align:center;">&gt;=48 hrs</th>
                <th style="vertical-align : middle;text-align:center;">Total</th>
            </tr>
        </thead>
        <tbody style="font-size: 11px;">
            <tr>
                <td style="text-align:left;">Medicine</td>
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
                <td style="text-align:left;">Obstetrics</td>
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
                <td style="text-align:left;">Gynecology</td>
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
                <td style="text-align:left;">Pediatrics</td>
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
                <td colspan="21" style="text-align:left;">Surgery</td>
            </tr>
            <tr>
                <td style="text-align:left;">Pedia</td>
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
                <td style="text-align:left;">Adult</td>
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
                <td colspan="21" style="text-align:left;">Other(s)</td>
            </tr>
               <tr style="font-weight: bold;">
                <td style="text-align:left;">Total</td>
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
                <td style="text-align:left;">Total Newborn</td>
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
                <td style="text-align:left;">Pathologic</td>
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
                <td style="text-align:left;">Non-Pathologic</td>
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
                <td style="text-align:left;">Well-Baby`</td>
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
    <table border="0">
        <tr>
            <td  style="text-align:left;"><small>* R/I - Recovered/Improved</small></td>
            <td  style="text-align:left;"><small>T - Transferred</small></td>
             <td  style="text-align:left;"><small>U - Unimproved</small></td>
            
        </tr>
        <tr>
            <td style="text-align:left;"><small>H - Home Against Medical Advice</small></td>
            <td style="text-align:left;"><small>A - Absconded</small></td>
            <td style="text-align:left;"><small>D - Died (died upon admission)</small></td>
        </tr>
    </table>
    <div style="page-break-after:always;"></div> 
    <table border="0">
        <tr>
            <td><b>1. Average Length of Stay (ALOS) of Admitted Patients</b></td>
        </tr>
         <tr>
             <td>
                <table border="0">
                    <tr>
                        <td style="text-align:center;">
                            <u>Total length of stay of discharged patients (including Deaths) in the period</u>
                        </td>
                        <td rowspan="2">= <u><?= $alos ?> Days</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">Total discharges and deaths in the period</td>
                    </tr>
                </table>
             </td>
             <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="3"><small>&bull; 	Average length of stay:  Average number of days each inpatient stays in the hospital for each episode of care.</small></td>
        </tr>
    </table>
    
    <p><b>2. Ten Leading causes of Morbidity based on final discharge diagnosis</b><br>
    <small>For each category listed below, please report the total number of cases for the top 10 illness injury.</small>
    </p><br>
    <small>(Do not include deliveries)</small>
    <table>
        <thead>
            <tr>
                <th>Cause of Morbidity/Illness/Injury</th>
                <th>Number</th>
                <th>ICD-10 Code</th>
            </tr>
        </thead>
        <tbody >
           <?php if(count($ten_leading_morbidity_cause) !== 0) { $number = 1;?>
            
            <?php foreach ($ten_leading_morbidity_cause as $data){ ?>
            <tr>
                <td><?= $number.'. '. $data['Diag_discharge'] ?></td>
                <td style="text-align:right;"><?= number_format($data['totalcsno']) ?></td>
                <td style="text-align:center;"><?= $data['ICD10'] ?></td>
            </tr>
            <?php $number++;} ?>
        <?php }else{ ?>
            <tr>
                <td colspan="3"><center>No records found</center></td>
            </tr>
        <?php  } ?>
        </tbody>
    </table>
    <div style="page-break-after:always;"></div> 
    <p><center><b>Kindly accomplish the "Ten Leading Causes of Morbidity/Diseases Disaggregated as to Age and Sex" in the table below.</b></center></p><br>
<table style="font-size:10px;">
        <thead >
            <tr style="vertical-align : middle;text-align:center;">
                <th rowspan="2" style="vertical-align : middle;text-align:center;">Cause of Morbidity (Underlying)</th>
                <th colspan="34" style="vertical-align : middle;text-align:center;">Age Distribution of Patients</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">Total</th>
                <th rowspan="3" style="vertical-align : middle;text-align:center;">ICD-10 CODE / TABULAR LIST</th>
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
        <tbody>
        <?php if(count($morbidity_cause) !== 0) { $number = 1;?>

                    <?php foreach ($morbidity_cause as $data){ ?>
                    <tr>
                        <td><?= $number.'. '. $data['Diag_discharge'] ?></td>
                        <td style="text-align:right;"><?= number_format($data['under1M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['under1F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age1_4M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age1_4F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age5_9M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age5_9F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age10_14M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age10_14F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age15_19M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age15_19F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age20_24M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age20_24F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age25_29M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age25_29F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age30_34M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age30_34F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age35_39M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age35_39F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age40_44M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age40_44F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age45_49M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age45_49F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age50_54M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age50_54F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age55_59M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age55_59F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age60_64M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age60_64F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age65_69M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age65_69F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age70M']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['age70F']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['subtotalM']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['subtotalF']) ?></td>
                        <td style="text-align:right;"><?= number_format($data['totalcsno']) ?></td>
                        <td style="text-align:center;"><?= $data['ICD10'] ?></td>
                    </tr>
                    <?php $number++;} ?>
                <?php }else{ ?>
                    <tr>
                        <td colspan="3"><center>No records found</center></td>
                    </tr>
                <?php  } ?>

        </tbody>
    </table>
</body>
</html>
