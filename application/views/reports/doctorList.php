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
          font-family: Arial;
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
                From: <b><?php $da = new DateTime($s_date); echo date_format($da,'F j, Y'); ?></b>
                &nbsp; &nbsp; | &nbsp; &nbsp;
                To: <b><?php $de = new DateTime($e_date); echo date_format($de,'F j, Y'); ?></b>
                <br>
                Total Records:<b><?= count($dx_record) ?></b> 
            </div>
        </center>
<br>
    <table>
        <tr style="background-color: #00A6C7;color:white;">
            <th>No.</th>
            <th>Doctor's Name </th>
            <th>Expertise</th>
            <th>PHIC</th>
            <th>Non-PHIC</th>
            <th>Total Patient</th>
        </tr>
        <?php if(count($dx_record) !== 0) {
            $t_phic = 0;
            $t_nphic = 0;
            $t = 0;
            $i=0;
            ?>
            <?php foreach ($dx_record as $data){ 
                $t_phic += intval($data['nhip']);
                $t_nphic += intval($data['non']);
                $t += (intval($data['nhip']) + intval($data['non']));
                 $i++;
                ?>
           
            <tr>
                <td><?= $i ?></td>
                <td><?= $data['doctorname'] ?></td>
                <td><?= strtoupper($data['expertise']) ?></td>
                <td><?= $data['nhip'] ?></td>
                <td><?= $data['non'] ?></td>
                <td><?= $data['nhip'] + $data['non'] ?></td>
            </tr>
            <?php } ?>
            <tr style="background-color: #00A6C7;color:white;">
                <th colspan="3" style="text-align:right;">TOTAL</th>
                <th><?= $t_phic ?></th>
                <th><?= $t_nphic ?></th>
                <th><?= $t?></th>
            </tr>
        <?php }else{ ?>
            <tr>
                <td colspan="4"><center>No records found</center></td>
            </tr>
            
        <?php  } ?>
    </table>
</body>
</html>
