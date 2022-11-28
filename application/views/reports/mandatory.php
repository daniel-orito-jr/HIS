<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title>Mandatory Monthly Report</title>
    <style>
        html
        {
            font-size: 12px;
          font-family: sans-serif;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        }      

        table, td, th {    
            border: 2px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
             padding: 6px;
        }

        .White{
            color:white;
            margin-left: -50px;
            margin-top: -30px;
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

        /*-----------Colors----------*/
        .blue{                                            
            background-color: #29b6f6;
            width:auto; 
            height:80px;
        }
        .darkblue{
            background-color: #2090c3;
            width:auto; 
            height:40px;
        }
        /*-----------End of the colors----------*/

        /*------Nix Coop Image-------*/
        .imageSize{
            margin-top:10px ;
            margin-left: 10px;
            width:30px;
            height:30px;
        }      
    </style>

</head>

<body>
    <?php//-------------HEADER------------ ?>
    <div class="blue">
        <img class="imageSize" src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo"/>
        <center>
            <div>
                <b style="font-size: 20px;"><?php echo ($type === 1) ? "Discharged" : "Admitted" ?> Patients List</b><br>  
                <b>From: </b> <?= $s_date ?>  <br>
                <b>Total Records:</b> <?= count($pat_record) ?>
            </div>
        </center>
    </div>
    <table>
        <tr>
            <th>Patient's Name</th>
            <th>Admit Date/Time</th>
            <th>Discharged Date/Time</th>
            <th>Classification</th>
        </tr>
        <?php if(count($pat_record) !== 0) {?>
            <?php foreach ($pat_record as $data){ ?>
            <tr>
                <td><?= $data['name'] ?></td>
                <td><?= $data['admitdate']."/".$data['admittime']  ?></td>
                <td><?= $data['dischadate']."/".$data['dischatime']  ?></td>
                <td><?= $data['pat_classification'] ?></td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="4"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
