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
          font-family:Arial, Helvetica, sans-serif;
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
        .leftright{
            text-align: right;
        }
        
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
               
                Printed Date:  <?= $date ?> <br>  
                 Printed Time: <?= $time  ?>
            </td>
        </tr>
    </table>
    <hr>
          <div >
        <center>
            <div >
                <b style="font-size: 15px;"><?= $title ?></b><br>  
                From: <b> <?= $start ?> </b> | 
                To:  <b>  <?= $end ?> </b><br>
                <b>HMO: </b> <?= $hmonamex ?> <br>
                <b>Hospital HMO:</b> <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span><u> <?= $hospital ?></u> | 
                <b>Professional Fee HMO:</b> <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span><u> <?= $proffee ?></u> <br>
                <b>Total Records:</b> <?= count($hmo) ?>
                
            </div>
            
        </center>
    </div>
    <br>
    <table >
        <thead>
        <tr >
            <th rowspan="2"><center>Type</center></th>
            <th rowspan="2"><center>Name</center></th>
            <th rowspan="2"><center>Discharge Date</center></th>
            <th rowspan="2">HMO </th>
            <th colspan="2"><center>HMO Fees</center></th>
        </tr>
        <tr>
            <th><center>Hospital</center></th>
            <th><center>Professional Fee</center></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($hmo) !== 0) {?>
            <?php foreach ($hmo as $data){ ?>
            <tr>
              
                <td><?= $data['pxtype']  ?></td>
                <td><?= $data['patientname'] ?></td>
                <td><?php $d = new DateTime($data['discha']); echo date_format($d,'F j, Y') ?></td>
                <td><?= $data['hmoname'] ?></td>
                <td  class="leftright">
                     <?=$data['HMOHOSP'] === null ? number_format (0,2):number_format (abs($data['HMOHOSP']),2) ?>                                       
                </td>
                <td class="leftright">
                    <?=$data['HMOPF'] === null ? number_format (0,2): number_format (abs($data['HMOPF']),2) ?>                                          
                </td>
               
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="6"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </tbody>
    <tfoot>
        <tr >
            <th colspan="4" class="leftright">TOTAL</th>
            <th class="leftright"><?=$totalHMOHOSP === null ? number_format (0,2): number_format (abs($totalHMOHOSP),2) ?></th>
            <th class="leftright"><?=$totalHMOPF === null ? number_format (0,2): number_format (abs($totalHMOPF),2) ?></th>
        </tr>
    </tfoot>
           
    </table>
</body>
</html>
     