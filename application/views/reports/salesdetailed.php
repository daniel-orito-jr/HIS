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
                <b><?= $datex ?></b><br>  
                <b>Total Records:</b> <?= count($inventory) ?>
                
            </div>
            
        </center>
    </div>
    <br>
    <table style="font-size:10px;">
        <thead>
            <tr>
                <th><center>Patient Name</center></th>
                <th><center>Transaction</center></th>
                <th><center>Add-on</center></th>
                <th><center>Total Amt</center></th>
                <th><center>Type</center></th>
                <th><center>Trans. D/T</center></th>
                <th><center>Req. No.</center></th>
                <th><center>Report No.</center></th>
                <th><center>Trans. No.</center></th>
                <th><center>Status</center></th>
                <?php if($dept =='lab') 
                { echo "<th><center>Med. Tech.</center></th>";
                }
                else if($dept == 'rad')
                {
                    echo "<th><center>Doc Reader</center></th>";
                }
                ?>
                
                <th><center>Requested by</center></th>
                <th><center>Recorded by</center></th>
               
            </tr>
            <tr style="background-color:green;color:white;">
                <th colspan="2" style="text-align: right;">TOTAL</th>
                <th style="text-align: right;"> <?= $addonrate === null ? number_format (0,2):number_format ($addonrate,2) ?>  </th>
                <th style="text-align: right;"> <?= $totalamt === null ? number_format (0,2):number_format ($totalamt,2) ?>  </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody >
            <?php if(count($inventory) !== 0) {?>
                <?php foreach ($inventory as $data){ ?>
                <tr>
                        
                    <td><?= $data['patientname']  ?></td>
                    <td><?= $data['transactiontype']  ?></td>
                    <td style="text-align: right;"> <?=$data['addonrate'] === null ? number_format (0,2):number_format ($data['addonrate'],2) ?>  </td> 
                    <td style="text-align: right;"> <?=$data['totalamt'] === null ? number_format (0,2):number_format ($data['totalamt'],2) ?>  </td> 
                    <td><?= $data['deptcateg']  ?></td>
                    <td> <?php $tdate = new DateTime($data['tdate']); echo date_format($tdate,'F j, Y'); ?>  </td>
                    <td><?= $data['reqcode']  ?></td>
                    <td><?= $data['reportcode']  ?></td>
                    <td><?= $data['transcode']  ?></td>
                    <td><?= $data['status']  ?></td>
                    <?php if($dept =='lab') 
                        { 
                            echo "<td>".$data['medtech']."</td>";
                        }
                        else if($dept == 'rad')
                        {
                            echo "<td>".$data['docreader']."</td>";
                        }
                    ?>
                    
                    <td><?= $data['reqby']  ?></td>
                    <td><?= $data['recby']  ?></td>
                </tr>
                <?php } ?>
            <?php }else{ ?>
                <tr>
                    <td colspan="13"><center>No records found</center></td>
                </tr>
            <?php  } ?>
        </tbody>
    
    </table>
</body>
</html>

