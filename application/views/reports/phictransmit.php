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
          font-family: Calibri;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        }      

        table, td, th {    
             border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
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

<body>
    <?php//-------------HEADER------------ ?>
   
    <table border="0">
        <tr>
            <td>
                <b style="font-size: 25px;"><?= $profile['compname'] ?></b><br>  
                <?= $profile['compadrs'] ?>  
            </td>
            <td>
               
                Printed Date:  <?php $da = new DateTime($datenow); echo date_format($da,'F j, Y'); ?> <br>  
                 Printed Time: <?php $da = new DateTime($datenow); echo date_format($da,'H:i:s A'); ?>
            </td>
        </tr>
    </table>
    <hr>
        <center>
            <div class="White">
                <b style="font-size: 20px;"><?= $title ?> </b><br>  
               Date: &nbsp;<b> <?php $da = new DateTime($s_date); echo date_format($da,'F j, Y'); ?> - 
                               <?php $da = new DateTime($e_date); echo date_format($da,'F j, Y'); ?></b> <br>
                Total Records: <b><?= count($phicstat) ?></b>
            </div>
        </center>
<br>
    <table style="font-size:10px;">
        <thead>
            <tr>
                <th>Account Number</th>
                <th>Patient Name</th>
                <th>Discharge Date</th>
                <th>Hospital Fee</th>
                <th>Professional Fee</th>
                <th>Total Amount</th>
                <th>Transmitted By</th>
                <th>Aging</th>
            </tr>
        </thead>
        <tbody>
        <?php if(count($phicstat) !== 0) {?>
        <?php foreach ($phictdate as $phictdate){ 
            $processdatex = new DateTime($phictdate['processdate']); 
//            echo $phictdate['processdate'];
                echo "<tr style='background-color:green;color:white;text-transform: uppercase'>
                   <td colspan='3'> <b>".date_format($processdatex,'F j, Y')."</b></td>";
                   foreach ($phictrate as $phictratex){
                       if($phictdate['processdate'] === $phictratex['processdate'])
                       {
//                            $this->dweclaims_db->select('processdate,sum(hcifee) as hosp, sum(profee) as prof,sum(grandtotal) as totalamt')
                           echo "<td class='leftright'> <b>
                                   <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                   number_format ($phictratex['hosp'],2) .                                         
                               "</b></td>";
                           echo "<td class='leftright'> <b>
                                   <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                   number_format ($phictratex['prof'],2) .                                         
                               "</b></td>";
                           echo "<td class='leftright'> <b>
                                   <span style='font-family: DejaVu Sans; sans-serif'>&#8369;</span>".
                                   number_format ($phictratex['totalamt'],2) .                                         
                               "</b></td>";
                       }
                   }
                   echo "<td></td>";
                   echo "<td></td>";
//                   echo $phictratex['processdate'];
               echo "</tr>"; ?>
            <?php foreach ($phicstat as $data){ 
                if($phictdate['processdate'] == $data['processdate'])
                    {
                ?>
            <tr>
                <td><?= $data['patpin'] ?></td>
                <td><?= $data['PatientName'] ?></td>
                <td><?php $dischargedate = new DateTime($data['dischargedate']); echo date_format($dischargedate,'F j, Y'); ?></td>
                <td class='leftright'>
                    <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($data['hcifee'],2)?>  
                </td>
                <td class='leftright'>
                    <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($data['profee'],2)?>  
                </td>
                <td class='leftright'>
                    <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($data['grandtotal'],2)?>  
                </td>
                <td><?= $data['claimedby'] ?></td>
                <td><?= $data['aging'] ?></td>


            </tr>
                    <?php }}} ?>
        <?php }else{ ?>
            <tr>
                <td colspan="6"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </tbody>
    <tfoot>
            <tr style="background-color:blue;color:white;">
                <th colspan="3" >TOTAL</th>
                <th style="text-align:right;"><?=$hosp === null ? number_format (0,2): number_format ($hosp,2) ?></th>
                <th style="text-align:right;"><?=$prof === null ? number_format (0,2): number_format ($prof,2) ?></th>
                <th style="text-align:right;"><?=$totalamount === null ? number_format (0,2): number_format ($totalamount,2) ?></th>
                <th ></th>
                <th ></th>
              </tr>
        </tfoot>
    </table>
</body>
</html>
