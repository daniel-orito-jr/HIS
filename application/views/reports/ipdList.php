<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title>IPD Discharges/Admissions List Report</title>
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
<!--    <script type="text/php">

        if ( isset($pdf) ) {

          $font = Font_Metrics::get_font("helvetica", "bold");
          $pdf->page_text(500,10, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));

        }
    </script>-->
    <?php//--------------END OF THE STYLE-------------- ?>
</head>

<body>
    <?php//-------------HEADER------------ ?>
    <div class="blue">
        <img class="imageSize" src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo"/>
        <center>
            <div class="White">
                <b style="font-size: 20px;">IPD Discharges/Admissions List</b><br>  
                <b>From: </b> <?= $s_date ?>  <b>To: </b> <?= $e_date ?><br>
                <b>Total Records:</b> <?= count($ipd) ?>
            </div>
        </center>
    </div>
    <table>
        <tr>
            <th>Patient Classification</th>
            <th>Admissions</th>
            <th>Discharges</th>
        </tr>
        <?php if(count($ipd) !== 0) {?>
            <?php foreach ($ipd as $data){ ?>
            <tr>
                <td><?= $data['pat_classification'] ?></td>
                <td><?= $data['admitted'] ?></td>
                <td><?= $data['discharged_px'] ?></td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="3"><center>No records found</center></td>
            </tr>
        <?php  } ?>
    </table>
</body>
</html>
