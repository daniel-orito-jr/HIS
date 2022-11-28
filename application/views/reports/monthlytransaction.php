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
                <b style="font-size: 20px;"><?= $title?> List</b><br>  
                <b>Date: &nbsp; <?= $dates ?></b> <br>
                <b>Total Records:</b> <?= count($daily_transaction) ?>
            </div>
        </center>
<br>
    <table >
        <tr>
            <th >Date</th>
            <th style="background-color:#BBDEFB;">Total Income</th>
            <th>Drugs/Meds</th>
            <th>Medical Supply</th>
            <th>Pharmacy Miscellaneous</th>
            <th style="background-color:#C5CAE9;">Pharmacy Income</th>
             <th>Laboratory</th>
            <th>Radiology</th>
            <th>Hospital</th>
            <th>IPD Payment</th>
            <th>HMO</th>
            <th>PCSO</th>
            <th>PHIC</th>
            <th>OPD Laboratory</th>
            <th>OPD Radiology</th>
            <th>ODP Payment</th>
            <th>PN Account</th>
            <th>Delivery Pharmacy</th>
            <th>Delivery Laboratory</th>
            <th>Delivery Radiology</th>
            <th>Delivery Hospital</th>
        </tr>
        <?php if(count($daily_transaction) !== 0) {?>
            <?php foreach (array_reverse($daily_transaction) as $data){ ?>
            <tr>
                <td><?php $da = new DateTime($data['datex']); echo date_format($da,'F Y'); ?></td>
            <td style="background-color:#BBDEFB;"><b>&#8369;<?php echo number_format($data['total'],2)?></b>    </td>
                <td>₱<?php echo number_format ($data['drugin'],2) ?>                                             </td>
                <td>₱<?php echo number_format ($data['medsplyin'],2) ?>                                           </td>
                <td>₱<?php echo number_format ($data['pharmiscin'],2) ?>                                          </td>
                <td style="background-color:#C5CAE9;"><b>₱<?php echo number_format($data['pharmacy'],2) ?></b>  </td>
                <td>₱<?php echo number_format( $data['labin'],2) ?>                                               </td>
                <td>₱<?php echo number_format( $data['radin'],2) ?>                                               </td>
                <td>₱<?php echo number_format( $data['hospin'],2) ?>                                              </td>
                <td>₱<?php echo number_format( $data['ipdayin'],2) ?>                                            </td>
                <td>₱<?php echo number_format( $data['hmoacctin'],2) ?>                                           </td>
                <td>₱<?php echo number_format( $data['pcsoacctin'],2) ?>                                          </td>
                <td>₱<?php echo number_format( $data['phicacctin'],2) ?>                                          </td>
                <td>₱<?php echo number_format( $data['opdlabin'],2) ?>                                            </td>
                <td>₱<?php echo number_format( $data['opdradin'],2) ?>                                            </td>
                <td>₱<?php echo number_format( $data['opdhospin'],2) ?>                                           </td>
                <td>₱<?php echo number_format( $data['pnacctin'],2) ?>                                            </td>
                <td>₱<?php echo number_format(  $data['deliverypharin'],2) ?>                                     </td>
                <td>₱<?php echo number_format( $data['deliverylabin'],2) ?>                                       </td>
                <td>₱<?php echo number_format( $data['deliveryradin'],2) ?>                                       </td>
                <td>₱<?php echo number_format( $data['deliveryhospin'],2) ?>                                      </td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="21"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
