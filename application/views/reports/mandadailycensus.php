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
                <b style="font-size: 20px;"><?= $title ?> List</b><br>  
                <b>Date: &nbsp; <?= $date ?>  </b> <br>
                <b>Total Records:</b> <?= count($census_month) ?>
            </div>
        </center>
<br>
    <table>
       <thead>
            <tr >
                <th><center>1</center></th>
                <th colspan="3"><center>2</center></th>
            </tr>
            <tr>
                <th rowspan="2" class="align-middle"><center>DATE</center></th>
                <th colspan="3"><center>CENSUS</center></th>
            </tr>
            <tr>
                <th><center>a. NHIP</center></th>
                <th><center>b. NON-NHIP</center></th>
                <th><center>c. TOTAL</center></th>
            </tr>
           
        </thead>
        <?php if(count($census_month) !== 0) {?>
            <?php foreach ($census_month as $census_month){ ?>
            <tr>
                <td><?= $census_month["datex"]?></td> 
                <td><?= $census_month["nhip"]?></td> 
                <td><?= $census_month["non"]?></td> 
                <td><?= $census_month["totalx"]?></td>
            </tr>
            <?php } ?>
            <tr>
                <td><b>TOTAL    </b>   </td>
               <td><b><?= $disphic ?> </b></td>
               <td><b><?= $disnon ?> </b> </td>
                <td><b><?= $dispat ?></b> </td>
          
            </tr>
        <?php }else{ ?>
            <tr>
                <td colspan="4"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
