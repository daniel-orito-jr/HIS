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
                Total Records: <b><?= count($pendingclaim) ?></b><br><br>

            </div>
        </center>
<br>
    <table style="font-size:10px;">
        <tr>
            <th>Batch No </th>
            <th>Patient Name</th>
            <th>Process Date</th>
            <th>Claim Number</th>
            <th>HCI Case Number</th>
            <th>Age (Days)</th>
        </tr>
        
        <?php if(count($pendingclaim) !== 0) {?>
            <?php foreach ($pendingclaim as $data){ ?>
                <?php if( $data['aging'] <= 15){ ?>
                    <tr style="background-color:#d9ebc6">
                        <td><?= $data['batchno'] ?></td>
                        <td><?= $data['PatientName'] ?></td>
                        <td><?php $processdate = new DateTime($data['processdate']); echo date_format($processdate,'F j, Y'); ?></td>
                        <td><?= $data['claimno'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td style="text-align:center;"><?= $data['aging'] ?></td>
                    </tr>
                <?php } else if( $data['aging'] >= 16 && $data['aging'] <= 30) { ?>
                    <tr style="background-color:#cae8cb">
                        <td><?= $data['batchno'] ?></td>
                        <td><?= $data['PatientName'] ?></td>
                        <td><?php $processdate = new DateTime($data['processdate']); echo date_format($processdate,'F j, Y'); ?></td>
                        <td><?= $data['claimno'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td style="text-align:center;"><?= $data['aging'] ?></td>
                    </tr>
                <?php } else if( $data['aging'] >= 31 && $data['aging'] <= 45) { ?>
                    <tr style="background-color:#ffecb3">
                        <td><?= $data['batchno'] ?></td>
                        <td><?= $data['PatientName'] ?></td>
                        <td><?php $processdate = new DateTime($data['processdate']); echo date_format($processdate,'F j, Y'); ?></td>
                        <td><?= $data['claimno'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td style="text-align:center;"><?= $data['aging'] ?></td>
                    </tr>
                <?php } else if( $data['aging'] >= 46 && $data['aging'] <= 60) { ?>
                    <tr style="background-color:#ffe0b3">
                        <td><?= $data['batchno'] ?></td>
                        <td><?= $data['PatientName'] ?></td>
                        <td><?php $processdate = new DateTime($data['processdate']); echo date_format($processdate,'F j, Y'); ?></td>
                        <td><?= $data['claimno'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td style="text-align:center;"><?= $data['aging'] ?></td>
                    </tr>
                <?php } else { ?>
                    <tr style="background-color:#ffc4b3">
                        <td><?= $data['batchno'] ?></td>
                        <td><?= $data['PatientName'] ?></td>
                        <td><?php $processdate = new DateTime($data['processdate']); echo date_format($processdate,'F j, Y'); ?></td>
                        <td><?= $data['claimno'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td style="text-align:center;"><?= $data['aging'] ?></td>
                    </tr>
                    <?php } ?>
            
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="6"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
