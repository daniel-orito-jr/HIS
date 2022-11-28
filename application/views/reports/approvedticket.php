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
    <div >
  
        <center>
            <div >
                <b style="font-size: 20px;"><?= $title ?></b><br>  
                <b>Date: </b> <?php $da = new DateTime($s_date); echo date_format($da,'F j, Y'); ?>  <br>
                <b>Total Records:</b> <?= count($approvedticket_record) ?>
            </div>
        </center>
    </div>
    <br>
    <table b>
        <tr>
            <th>Date</th>
            <th>Explanation</th>
            <th>Payee</th>
            <th>Amount</th>
            <th>Note</th>
        </tr>
        <?php if(count($approvedticket_record) !== 0) {?>
            <?php foreach ($approvedticket_record as $data){ ?>
            <tr>
                <td><?php $d = new DateTime($data['TICKETDATE']); echo date_format($d,'F j, Y') .'<br>'. $data['TICKETCODE']?></td>
                <td><?= $data['EXPLANATION']  ?></td>
                <td><b><?= $data['PAYEE'] ?></b></td>
                <td><?= number_format($data['CHEQUEAMT'],2) ?></td>
                <td><?= $data['note'] ?></td>
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
