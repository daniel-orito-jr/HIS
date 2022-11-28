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
                <b>Total Records:</b> <?= count($inventory) ?>
                
            </div>
            
        </center>
    </div>
    <br>
    <table style="font-size:10px;">
        <thead>
            <tr>
                <th><center>TEST</center></th>
                <th><center>TOTAL QTY</center></th>
                <th><center>TOTAL AMOUNT</center></th>
                <th><center>OPD QTY</center></th>
                <th><center>IPD QTY</center></th>
                <th><center>ADD-ON TOTAL</center></th>
                <th><center>RETAIL</center></th>
            </tr>
            <tr style="background-color:green;color:white;">
                <th style="text-align: right;">TOTAL</th>
                <th style="text-align: right;"> <?= $qty === null ? 0:$qty ?>  </th>
                <th style="text-align: right;"> <?= $totalamount === null ? number_format (0,2):number_format ($totalamount,2) ?>  </th>
                <th style="text-align: right;"> <?= $opdqty === null ? 0:$opdqty ?>  </th>
                <th style="text-align: right;"> <?= $ipdqty === null ? 0:$ipdqty ?>  </th>
                <th style="text-align: right;"> <?= $addonprice === null ? number_format (0,2):number_format ($addonprice,2) ?>  </th>
                <th></th>
            </tr>
        </thead>
        <tbody style="text-align: right;">
            <?php if(count($inventory) !== 0) {?>
                <?php foreach ($inventory as $data){ ?>
                <tr>
                      
                    <td style="text-align:left;"><?= $data['dscr']  ?></td>
                    <td> <?=$data['qty'] === null ? intval(0):intval($data['qty']) ?>  </td> 
                    <td> <?=$data['totalamount'] === null ? number_format (0,2):number_format ($data['totalamount'],2) ?>  </td>
                    <td> <?=$data['opdqty'] === null ? 0:$data['opdqty'] ?>  </td> 
                    <td> <?=$data['ipdqty'] === null ? 0:$data['ipdqty'] ?>  </td> 
                    <td> <?=$data['addonprice'] === null ? number_format (0,2):number_format ($data['addonprice'],2) ?>  </td>
                    <td> <?=$data['unitprice'] === null ? number_format (0,2):number_format ($data['unitprice'],2) ?>  </td>

                </tr>
                <?php } ?>
            <?php }else{ ?>
                <tr>
                    <td colspan="12"><center>No records found</center></td>
                </tr>
            <?php  } ?>
        </tbody>
    
    </table>
</body>
</html>

