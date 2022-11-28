<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title> <?= $title ?> </title>
    <style>
        html
        {
            font-size: 12px;
            font-family: 'sans-serif';
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }      

        table, td, th 
        {    
             border: 1px solid black;
        }

        table 
        {
            border-collapse: collapse;
            width: 100%;
        }

        th, td 
        {
             padding: 6px;
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

        .leftright{
            text-align: right;
        }
    </style>

</head>

<body >
    <?php//-------------HEADER------------ ?>
   
    <table border="0" >
        <tr>
            <td>
                <b style="font-size: 25px;"><?= $profile['compname'] ?></b><br>  
                <?= $profile['compadrs'] ?>  
            </td>
            <td>
                Printed Date: <?php $da = new DateTime($datenow); echo date_format($da,'F j, Y'); ?> <br>  
                Printed Time: <?php $da = new DateTime($datenow); echo date_format($da,'H:i:s A'); ?>
            </td>
        </tr>
    </table>
    <hr>
        <center>
             <div>
                <b style="font-size: 20px;"><?= $title ?></b><br>  
                Batch No: &nbsp;<b><u> <?= $batchno ?> </u></b><br>
                Payroll Period: &nbsp;<b><u> <?= $s_date ?> &nbsp; - &nbsp;<?= $e_date ?></u></b><br>
                <b>Total Records:</b> <?= count($paysum) ?>
            </div>
        </center><br>
    <table>
        <thead>
            <tr style="font-size: 12px">
                <!--<th rowspan="2">Department</th>-->
                <th rowspan="2">Employee Number</th>
                <th rowspan="2">Employee Name</th>
                <th rowspan="2">Salary Grade</th>
                <th rowspan="2">Basic Pay</th>
                <th rowspan="2">Incentives</th>
                <th rowspan="2" style="background-color:#BBDEFB">GROSS</th>
                <th colspan="5"><center>LESS</center></th>
                <th rowspan="2" style="background-color:#C5CAE9">NET</th>
            </tr>
            <tr style="font-size: 12px">
                <th>SSS</th>
                <th>PhilHealth</th>
                <th>PAG-IBIG</th>
                <th>Tax</th>
                <th>Absent and Undertime</th>
            </tr>
        </thead>
        <tbody>
            <?php $ss = 0;
            if(count($paysum) !== 0) {?>
             <?php foreach ($paydept as $paydeptx){ 
                echo "<tr style='background-color:green;color:white;text-transform: uppercase'>
                   <td colspan='11'> <b>".$paydeptx['dept']."</b></td>";
                   foreach ($paynet as $paynetx){
                       if($paydeptx['dept'] == $paynetx['dept'])
                       {
                           echo "<td class='leftright'> <b>
                                   <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                   number_format ($paynetx['sumnet'],2) .                                         
                               "</b></td>";
                       }
                   }
               echo "</tr>";

                foreach ($paysum as $data){
                    if($paydeptx['dept'] == $data['dept'])
                    { 
                        echo "<tr>";
                            echo "<td>". $data['profileno']."</td>";
                            echo "<td>". $data['Empname']."</td>";
                            echo "<td>". $data['salarygrade']."</td>";
                            echo "<td class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['basic'],2) .                                         
                                "</td>";
                            echo "<td class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['totalincentives'],2) .                                         
                                "</td>";
                            echo "<td style='background-color:#BBDEFB'class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['GRS'],2) .                                         
                                "</td>";
                            echo "<td class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['SSSded'],2) .                                         
                                "</td>";
                            echo "<td class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['PHICded'],2) .                                         
                                "</td>";
                            echo "<td class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['HDMFded'],2) .                                         
                                "</td>";
                            echo "<td class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['TAXded'],2) .                                         
                                "</td>";
                            echo "<td class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['ABSENTded'],2) .                                         
                                "</td>";
                            echo "<td style='background-color:#C5CAE9' class='leftright'>
                                    <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                    number_format ($data['Net'],2) .                                         
                                "</td>";
                        echo "</tr>";
                    }
                }
            }
            }else{ ?>
                <tr>
                    <td colspan="12"><center>No records found</center></td>
                </tr>
            <?php  } ?>
        </tbody>
        <tfoot>
            <tr style="background-color:blue;color:white;">
                <th colspan="4" class="leftright">TOTAL</th>
                <th class="leftright"><?=$totalincentives === null ? number_format (0,2): number_format ($totalincentives,2) ?></th>
                <th class="leftright"><?=$totalgross === null ? number_format (0,2): number_format ($totalgross,2) ?></th>
                <th class="leftright"><?=$totalsss === null ? number_format (0,2): number_format ($totalsss,2) ?></th>
                <th class="leftright"><?=$totalphic === null ? number_format (0,2): number_format ($totalphic,2) ?></th>
                <th class="leftright"><?=$totalhdmf === null ? number_format (0,2): number_format ($totalhdmf,2) ?></th>
                <th class="leftright"><?=$totaltax === null ? number_format (0,2): number_format ($totaltax,2) ?></th>
                <th class="leftright"><?=$totalabsent === null ? number_format (0,2): number_format ($totalabsent,2) ?></th>
                <th class="leftright"><?=$totalnet === null ? number_format (0,2): number_format (floatval($totalnet),2) ?></th>
            </tr>
        </tfoot>
    </table>

    
</body>
</html>
