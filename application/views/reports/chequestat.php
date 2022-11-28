<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />
    <title> <?= $title ?> </title>
    <style>
        html
        {
            font-size: 12px;
          font-family: Arial,sans-serif;
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
                <b style="font-size: 20px;"><?= $title ?> </b><br>  
                <small><span style="color:#90EE90;">GREEN - Cheques that have already been received.</span> |
                    <span style="color:grey;">GRAY - Receivable Cheques </span></small><br>
                Date: &nbsp;<b> <?= $startdate ?> - <?= $enddate ?>  </b> <br>
                Total Records: <b><?= count($checkstat) ?></b><br><br>

            </div>
        </center>
<br>
    <table style="font-size:10px;">
        <tr>
            <th>Claim Series No </th>
            <th>Patient Name</th>
            <th>Account No.</th>
            <th>Hospital</th>
            <th>Hosp. Variance</th>
            <th>Professional</th>
            <th>Prof. Variance</th>
            <th>Total</th>
            <th>Total Variance</th>
            <th>Voucher No.</th>
            <th>Cheque Date</th>
            <th>Status</th>
        </tr>
        
                    <tr style="background-color:#90EE90;">
                        <td colspan="3"  style="text-align:right;">TOTAL POSTED:</td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($ptotalamt['hosppaidx'],2)?>  
                        </td>
                        <td style="text-align:right;color:red;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($ptotalamt['hospunpaid'],2)?>  
                        </td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($ptotalamt['profpaidx'],2)?>  
                        </td>
                        <td style="text-align:right;color:red;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                           <?=   number_format($ptotalamt['profunpaid'],2)?>  
                        </td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                          <?=   number_format($ptotalamt['granpaidx'],2)?>  
                        </td>
                        <td style="text-align:right;color:red;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                           <?=   number_format($ptotalamt['grandunpaid'],2)?>  
                        </td>
                        <td></td>
                        <td></td>
                        <td>POSTED</td>
                    </tr>
              
                    <tr style="background-color:grey;">
                        <td colspan="3"  style="text-align:right;">TOTAL UNPOSTED:</td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($untotalamt['hosp'],2)?>  
                        </td>
                        <td></td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($untotalamt['prof'],2)?>  
                        </td>
                        <td></td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                          <?=   number_format($untotalamt['grand'],2)?>  
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>UNPOSTED</td>
                    </tr>
              
        <?php if(count($checkstat) !== 0) {?>
            <?php foreach ($checkstat as $data){ ?>
                <?php  if($data['tagged'] == 1){ ?>
                    <tr style="background-color:#90EE90;">
                        <td><?= $data['CSNO'] ?></td>
                        <td><?= $data['PatientName'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['hosppaid'],2)?>  
                        </td>
                        <td style="text-align:right;color:red;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['hospvar'],2)?>  
                        </td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['profpaid'],2)?>  
                        </td>
                        <td style="text-align:right;color:red;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['profvar'],2)?>  
                        </td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['granpaid'],2)?>  
                        </td>
                        <td style="text-align:right;color:red;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['granvar'],2)?>  
                        </td>
                        <td><?= $data['pvc'] ?></td>
                        <td><?php $asof = new DateTime($data['asof']); echo date_format($asof,'F j, Y'); ?></td>
                        <td>POSTED</td>
                    </tr>
                <?php } else {?>
                    <tr style="background-color:grey;">
                        <td><?= $data['CSNO'] ?></td>
                        <td><?= $data['PatientName'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['hcifee'],2)?>  
                        </td>
                        <td></td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['profee'],2)?>  
                        </td>
                        <td></td>
                        <td style="text-align:right;">
                            <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                            <?=   number_format($data['grandtotal'],2)?>  
                        </td>
                        <td></td>
                        <td><?= $data['pvc'] ?></td>
                        <td><?php $asof = new DateTime($data['asof']); echo date_format($asof,'F j, Y'); ?></td>
                        <td>UNPOSTED</td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="12"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
