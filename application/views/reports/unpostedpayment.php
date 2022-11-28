<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />
    <title> <?= $title ?> </title>
    <style>
        html
        {
            font-size: 12px;
          font-family: Arial,sans-serif;
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
               Date: &nbsp;<b> <?= $startdate ?> - <?= $enddate ?>  </b> <br>
               Total Records: <b><?= count($unpostedpayment) ?></b><br><br>
                TOTAL AMOUNT <br>
                HOSPITAL: <b><span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($totalamt['hosp'],2)?></b>   | 
                PROFESSIONAL: <b><span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($totalamt['prof'],2)?></b> |
                GRAND TOTAL: <b><span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($totalamt['grand'],2)?> </b>
            </div>
        </center>
<br>
    <table style="font-size:10px;">
        <tr>
            <th>Claim Series No</th>
            <th>Patient Name</th>
            <th>Account Name</th>
            <th>Hospital</th>
            <th>Professional</th>
            <th>Total</th>
            <th>Process Date</th>
            <th>Cheque Date</th>
        </tr>
        <?php if(count($unpostedpayment) !== 0) {?>
            <?php foreach ($unpostedpayment as $data){ ?>
            <tr>
                <td><?= $data['CSNO'] ?></td>
                <td><?= $data['PatientName'] ?></td>
                <td><?= $data['patpin'] ?></td>
                <td>
                    <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($data['hcifee'],2)?>  
                </td>
                <td>
                    <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($data['profee'],2)?>  
                </td>
                <td>
                    <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                    <?=   number_format($data['grandtotal'],2)?>  
                </td>
                <td><?php $processdate = new DateTime($data['processdate']); echo date_format($processdate,'F j, Y'); ?></td>
                <td><?php $asof = new DateTime($data['processdate']); echo date_format($asof,'F j, Y'); ?></td>

               

            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="8"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
