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
                <!--<th><center>Batch</center></th>-->
                <th><center>Start</center></th>
                <th><center>End</center></th>
                <th><center>Month/Year</center></th>
                <th><center>Created By</center></th>
                <th><center>DONE</center></th>
            </tr>
        </thead>
        <tbody>
        <?php if(count($inventory) !== 0) {?>
            <?php foreach ($inventory as $data){ ?>
            <tr>
                <td><?php $indate = new DateTime($data['indate']); echo date_format($indate,'F j, Y');?></td>
                <td><?php $outdate = new DateTime($data['outdate']); echo date_format($outdate,'F j, Y');?></td>
                <td><?= $data['monthyear']  ?></td>
                <td><?= $data['createdby']  ?></td>
                <td><?php if( $data['actv'] == '1') 
                {
                    echo 'YES';
                }
                else 
                {
                    echo "NO";
                }
                ?></td>
    
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="12"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </tbody>
    
    <tfoot>
    </tfoot>
           
    </table>
</body>
</html>

     