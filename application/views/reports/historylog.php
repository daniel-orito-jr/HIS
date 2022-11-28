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
                Total Records: <b><?= count($historylog) ?></b><br><br>

            </div>
        </center>
<br>
    <table style="font-size:10px;">
        <tr>
           <th>Transaction No. </th>
            <th>Claim Series No</th>
            <th>Patient</th>
            <th>Account No.</th>
            <th>Amount</th>
            <th>Tagged Date</th>
            <th>Tagged By</th>
            <th>Untagged Date</th>
            <th>Untagged By</th>
            <th>Age (Days) </th>
            <th>Voucher No. </th>
        </tr>
        
        <?php if(count($historylog) !== 0) {?>
            <?php foreach ($historylog as $data){ ?>
<!--        $sub_array = array();
            $sub_array[] = $row->;
            $sub_array[] = $row->;
            $sub_array[] = $row->;
            $sub_array[] = $row->;
            $sub_array[] = $this->format_moneyx($row->);
            if($row->tagby == "")
            {
                $sub_array[] = "";
            }
            else
            {
               $sub_array[] = $this->format_datexx($row->tagdate);  
            }
            $sub_array[] = $row->;
            if($row->untagby == "")
            {
                $sub_array[] = "";
            }
            else
            {
               $sub_array[] = $this->format_datexx($row->untagdate);  
            }
            $sub_array[] = $row->untagby;
            $sub_array[] = $row->;
            $sub_array[] = $row->;-->
                <?php if( $data['untagby'] == ""){ ?>
                    <tr style="background-color:#bdf5bd">
                        <td><?= $data['transactno'] ?></td>
                        <td><?= $data['csno'] ?></td>
                        <td><?= $data['pname'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td>  <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                                <?=   number_format($data['amount'],2)?>  
                        </td>
                        <td><?php $tagdate = new DateTime($data['tagdate']); echo date_format($tagdate,'F j, Y'); ?></td>
                        <td><?= $data['tagby'] ?></td>
                        <td></td>
                        <td></td>
                        <td><?= $data['aging'] ?></td>
                        <td><?= $data['vchr'] ?></td>
                    </tr>
                <?php } else { ?>
                    <tr style="background-color:#d9d9d9;">
                        <td><?= $data['transactno'] ?></td>
                        <td><?= $data['csno'] ?></td>
                        <td><?= $data['pname'] ?></td>
                        <td><?= $data['patpin'] ?></td>
                        <td>  <span style="font-family: DejaVu Sans; sans-serif">&#8369;</span>
                                <?=   number_format($data['amount'],2)?>  
                        </td>
                        <td></td>
                        <td></td>
                        <td><?php $untagdate = new DateTime($data['untagdate']); echo date_format($untagdate,'F j, Y'); ?></td>
                        <td><?= $data['untagby'] ?></td>
                        <td><?= $data['aging'] ?></td>
                        <td><?= $data['vchr'] ?></td>
                    </tr>
               
                
                    <?php } ?>
            
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="11"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
