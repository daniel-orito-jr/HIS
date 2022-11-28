<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title> <?= $title ?> </title>
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
               
                Printed Date:  <?php $da = new DateTime($datenow); echo date_format($da,'F j, Y'); ?> <br>  
                 Printed Time: <?php $da = new DateTime($datenow); echo date_format($da,'H:i:s A'); ?>
            </td>
        </tr>
    </table>
    <hr>
        <center>
            <div class="White">
                <b style="font-size: 20px;"><?= $title ?> </b><br>  
               Date: &nbsp;<b> <?php $da = new DateTime($s_date); echo date_format($da,'F j, Y'); ?>  </b> <br>
                Total Records: <b><?= count($phicstat) ?></b>
            </div>
        </center>
    <br>
    <table style="font-size:10px;">
        <thead>
            <tr>
                <th >Aging (from Date of Discharge) </th>
                <th> Patients</th>
                <th>Amount</th>
            </tr>
        </thead>
        </tbody>
        <?php if(count($phicstat) !== 0) {?>
            <?php foreach ($phicstat as $data){ 
                if($data['aging'] === '61 Days above') {?>
                    <tr  style="color:red;">
                        <td><?= $data['aging'] ?></td>
                        <td class="leftright"><?= $data['total'] ?></td>
                        <td class="leftright">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['totalamount'],2)?>  
                        </td>
                    </tr>
                <?php }
                else
                { ?>
                    <tr>
                        <td><?= $data['aging'] ?></td>
                        <td class="leftright"><?= $data['total'] ?></td>
                        <td class="leftright">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['totalamount'],2)?>  
                        </td>
                    </tr>
                <?php }
                } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="3"><center>No records found</center></td>
            </tr>
        <?php  } ?>
        </tbody>
        <tfoot>
            <tr style="background-color:blue;color:white;">
                <th>TOTAL</th>
                <th class="leftright" ><span style="font-family: DejaVu Sans; sans-serif">&#8369;</span> <?=$pat === null ? number_format (0,2): number_format ($pat,2) ?></th>
                <th class="leftright"><span style="font-family: DejaVu Sans; sans-serif">&#8369;</span> <?=$totalamt === null ? number_format (0,2): number_format ($totalamt,2) ?></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
