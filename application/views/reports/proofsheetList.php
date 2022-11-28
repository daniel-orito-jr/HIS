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
                <b style="font-size: 20px;"><?= $title ?></b><br>  
                <b>From: </b> <?php $da = new DateTime($s_date); echo date_format($da,'F j, Y'); ?>
                <b>To: </b> <?php $da = new DateTime($e_date); echo date_format($da,'F j, Y'); ?><br>
                <b>Total Records:</b> <?= count($proof_record) ?>
            </div>
        </center>
<br>
<table >
        <tr>
            <th>Date</th>
            <?php if(intval($by) === 0){ ?> 
            <th>Cashier</th>
            <?php }?>
            <th>Total Credit</th>
            <th>Total Debit</th>
        </tr>
        <?php if(count($proof_record) !== 0) {?>
            <?php foreach ($proof_record as $data){ ?>
            <tr>
                <td><?= $data['udate'] ?></td>
                <?php if(intval($by) === 0){ ?> 
                <td><?= $data['updatedby'] ?></td>
                <?php }?>
                <td><span style="font-family: DejaVu Sans; sans-serif">&#8369;</span><?= number_format($data['credit'],2) ?></td>
                <td><span style="font-family: DejaVu Sans; sans-serif">&#8369;</span><?= number_format($data['debit'],2) ?></td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="4"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
