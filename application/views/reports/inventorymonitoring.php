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
                Month: <b> <?= $datex ?> </b><br>
             
                <b>Beginning:</b> <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span><u> <?= $beginning ?></u> | 
                <b>Sales:</b> <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span><u> <?= $sales ?></u> |
                <b>Ending Total:</b> <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span><u> <?= $ending ?></u><br>
                <b>Total Records:</b> <?= count($inventory) ?>
                
            </div>
            
        </center>
    </div>
    <br>
    <table style="font-size:10px;">
        <thead>
        <tr>
            <th rowspan="2" valign="middle">PARTICULARS</th>
            <th rowspan="2" valign="middle">COST</th>
            <th colspan="2"><center>BEGINNING</center></th>
            <th colspan="2"><center>PURCHASES</center></th>
            <th colspan="2"><center>ADJUSTMENTS</center></th>
            <th colspan="2"><center>SALES</center></th>
            <th colspan="2"><center>ENDING</center></th>
        </tr>
        <tr>
            <th><center>QUANTITY</center></th>
            <th><center>COST</center></th>
            <th><center>QUANTITY</center></th>
            <th><center>COST</center></th>
            <th><center>QUANTITY</center></th>
            <th><center>COST</center></th>
            <th><center>QUANTITY</center></th>
            <th><center>COST</center></th>
            <th><center>QUANTITY</center></th>
            <th><center>COST</center></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($inventory) !== 0) {?>
            <?php foreach ($inventory as $data){ ?>
            <tr>

                <td><?= $data['groupname']  ?></td>
                <td><?= '0' ?></td>
                <td class="leftright">
                   
                    <?=$data['beginningbalance'] === null ? number_format (0,2):number_format ($data['beginningbalance'],2) ?>                                             
                </td>
                <td  class="leftright">
                   
                     <?=$data['beginningcost'] === null ? number_format (0,2):number_format ($data['beginningcost'],2) ?>                         
                </td>
                <td  class="leftright">
                 
                       <?=$data['purchaseqty'] === null ? number_format (0,2):number_format ($data['purchaseqty'],2) ?>                                       
                </td>
                <td  class="leftright">
                   
                       <?=$data['purchasescost'] === null ? number_format (0,2): number_format ($data['purchasescost'],2) ?>                                         
                </td>
                <td class="leftright">
                    
                       <?=$data['adjustqty'] === null ? number_format (0,2): number_format ($data['adjustqty'],2) ?>                                        
                </td>
                <td class="leftright">
                   
                       <?=$data['adjustcost'] === null ? number_format (0,2): number_format ($data['adjustcost'],2) ?>                                          
                </td>
                 <td  class="leftright">
                   
                       <?=$data['salesqty'] === null ? number_format (0,2): number_format ($data['salesqty'],2) ?>                                         
                </td>
                <td class="leftright">
                    
                       <?=$data['salescost'] === null ? number_format (0,2): number_format ($data['salescost'],2) ?>                                        
                </td>
                <td class="leftright">
                   
                       <?=$data['endingbalance'] === null ? number_format (0,2): number_format ($data['endingbalance'],2) ?>                                          
                </td>
                <td class="leftright">
                   
                       <?=$data['endingcost'] === null ? number_format (0,2): number_format ($data['endingcost'],2) ?>                                          
                </td>
               
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="12"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </tbody>
    <tfoot>
        <tr >
            <th colspan="2" class="leftright">TOTAL</th>
            <th class="leftright"> <?=$totalbegqty === null ? number_format (0,2): number_format ($totalbegqty,2) ?></th>
            <th class="leftright"><?=$totalbegcost === null ? number_format (0,2): number_format ($totalbegcost,2) ?></th>
            <th class="leftright"><?=$totalpurqty === null ? number_format (0,2): number_format ($totalpurqty,2) ?></th>
            <th class="leftright"><?=$totalpurcost === null ? number_format (0,2): number_format ($totalpurcost,2) ?></th>
            <th class="leftright"><?=$totaladjqty === null ? number_format (0,2): number_format ($totaladjqty,2) ?></th>
            <th class="leftright"><?=$totaladjcost === null ? number_format (0,2): number_format ($totaladjcost,2) ?></th>
            <th class="leftright"><?=$totalsalesqty === null ? number_format (0,2): number_format ($totalsalesqty,2) ?></th>
            <th class="leftright"><?=$totalsalescost === null ? number_format (0,2): number_format ($totalsalescost,2) ?></th>
            <th class="leftright"><?=$totalendqty === null ? number_format (0,2): number_format ($totalendqty,2) ?></th>
            <th class="leftright"><?=$totalendcost === null ? number_format (0,2): number_format (floatval($totalendcost),2) ?></th>
        </tr>
    </tfoot>
           
    </table>
</body>
</html>

     