<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title>  <?php if ($type == 1)
                {
                    echo "Discharged";
                }
                else
                {
                     echo "Admitted";
                }  ?>  Report</title>
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
      
                <b style="font-size: 20px;">
               <?php if ($type == 1)
                {
                    echo "Discharged";
                }
                else
                {
                     echo "Admitted";
                } ?>
                Patients List</b><br>  
                <b>From: </b> <?= $s_datex ?> <br>
                <b>Total Records:</b> <?= count($pat_record) ?>
            </div>
        </center>
<br>
    <table>
        <tr>
            <th>Account Number</th>
            <th>Patient's Name</th>
            <th>Admit Date/Time</th>
            <th>Discharged Date/Time</th>
            <th>Classification</th>
            <th>Room</th>
            <th>Doctor</th>
        </tr>
        <?php if(count($pat_record) !== 0) {?>
            <?php foreach ($pat_record as $data){ ?>
            <tr>
                <td><?= $data['caseno'] ?></td>
                <td><?= $data['name'] ?></td>
                <td><?= $data['admitdate']." ".$data['admittime']  ?></td>
                <td><?= $data['dischadate']." ".$data['dischatime']  ?></td>
                <td><?= $data['pat_classification'] ?></td>
                <td><?= $data['roombrief'] ?></td>
                <td><?= $data['doctorname'] ?></td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="7"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
