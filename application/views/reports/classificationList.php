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
            <div>
                <b style="font-size: 20px;"><?= $title ?></b><br>  
                <b>From: &nbsp; <?= $date ?> &nbsp; To: &nbsp; <?= $end_date ?> </b> <br>
                <b> Doctor: &nbsp; <?= $docname ?></b><br>
                <b>Total Records:</b> <?= count($class_record) ?>
            </div>
        </center>
<br>
    <table>
        <tr>
            <th>Classification</th>
            <th>Counts</th>
        </tr>
        <?php if(count($class_record) !== 0) {?>
            <?php foreach ($class_record as $data){ ?>
            <tr>
                <td><?= $data['pat_classification'] ?></td>
                <td><?= $data['c'] ?></td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="2">No records found</td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
