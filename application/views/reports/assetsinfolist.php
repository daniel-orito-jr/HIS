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
            <div class="White">
                <b style="font-size: 20px;"><?=$title ?> List</b><br>  
                <b>Date:  </b> &nbsp; <?php $da = new DateTime($date); echo date_format($da,'F j, Y'); ?>  <br>
                <b>Total Records:</b> <?= count($asset_report) ?>
            </div>
        </center>

    <table>
        <tr>
            <th>ID</th>
            <th>Service Date</th>
            <th>Complaints</th>
            <th>Status</th>
            <th>Findings</th>
        </tr>
        <?php if(count($asset_report) !== 0) {?>
            <?php foreach ($asset_report as $data){ ?>
            <tr>
                <td><?= $data['Controlnumber'] ?></td>
                <td><?= $data['ServiceDate'] ?></td>
                <td><?= $data['Complaints'] ?></td>
                <td><?= $data['Assetstatus'] ?></td>
                <td><?= $data['Findings'] ?></td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="5"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
