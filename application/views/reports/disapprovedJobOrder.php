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
                <b style="font-size: 20px;"><?=$title ?> List</b><br>  
                <b>Date: &nbsp; <?php $d = new DateTime(); echo date_format($d,'F j, Y') ?> </b> <br>
                <b>Total Records:</b> <?= count($disapproved_joborder_record) ?>
            </div>
        </center>
<br>
    <table>
        <tr>
            <th>Request ID </th>
            <th><?= $header ?> </th>
            <th>Request Date</th>
            <th>Type</th>
            <th>Department</th>
            <th>Complaint</th>
            <th>Details</th>
            <th>Note</th>
        </tr>
        <?php if(count($disapproved_joborder_record) !== 0) {?>
            <?php foreach ($disapproved_joborder_record as $data){ ?>
            <tr>
                <td><?= $data['requestid'] ?></td>
                <td><?php $d = new DateTime($data['updated']); echo date_format($d,'F j, Y H:i:s') ?></td>
                <td><?php $d = new DateTime($data['requestdate']); echo date_format($d,'F j, Y') ?></td>
                <td><?= $data['AssetType'] ?></td>
                <td><?= $data['Department'] ?></td>
                <td><?= $data['Complaints'] ?></td>
                <td><?= $data['details'] ?></td>
                <td><?= $data['note'] ?></td>
                
               
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
