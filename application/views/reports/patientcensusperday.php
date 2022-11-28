<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title> <?= $title ?>  Report</title>
    <style>
        html
        {
            font-size: 12px;
          font-family: Georgia;
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
            <div >
                <b style="font-size: 20px;"><?= $title?> List</b><br>  
                <b>Date: &nbsp; <?php $da = new DateTime($date); echo date_format($da,'F j, Y'); ?> </b> <br>
                <b>Total Records:</b> <?= count($philhealth_now) ?>
            </div>
        </center>
<br>
    <table style="font-size:10px;">
        <tr>
            <th>Patient Name</th>
            <th>Admission Date</th>
            <th>Discharge Date</th>
            <th>Patient Classification</th>
            <th>Age</th>
            <th>Birthday</th>
            <th>Room</th>
            <th>Doctor</th>
            <th>Philhealth Membership</th>
        </tr>
        <?php if(count($philhealth_now) !== 0) {?>
            <?php foreach ($philhealth_now as $data){ ?>
            <tr>
              
                <td><?= $data['name'] ?></td>
                <td><?= $data['admitdate'] ?></td>
                <td><?= $data['dischadate'] ?></td>
                <td><?= $data['pat_classification'] ?></td>
                <td><center><?php echo (int)$data['age'] ?></center></td>
                <td><?= $data['bday'] ?></td>
                 <td><?= $data['roombrief'] ?></td>
                <td><?= $data['doctorname'] ?></td>
                 <td><?= $data['phicmembr'] ?></td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="9"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
