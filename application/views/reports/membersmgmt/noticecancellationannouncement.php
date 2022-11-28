<html>
<head>
<!--    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png'); ?>" />-->
    <title> <?= $title ?>  </title>
    <style>
        html
        {
            font-size: 20px;
          font-family: Arial;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
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
            margin-left: 40px;
        }
        .MarginTop{
            margin-top: 20px;
        }
        /*---------- End of margin---------*/

        
    </style>

</head>

<body>
    <table style="width:100%;">
        <tr>
            <td style="text-align:right;width:90%;">
                <p style=""><small> <?= $profile['compadrs'] ?></small><p>
                <hr>
            </td>
        </tr>
    </table>
    <table style="width:100%; margin-top: 50px">
        <tr>
            <td style="text-align:center;width:90%;">
                <strong>NOTICE</strong><br>
            </td>
        </tr>
    </table>
    <table style="width:100%; margin-top: 50px">
        <tr>
            <td style="text-align:center;width:90%;">
                <strong>Meeting Cancellation</strong><br>
            </td>
        </tr>  
    </table>
    <table style="width:100%; margin-top: 20px">
        <tr>
            <td style="text-align:center;width:90%;">
                <p>[SUBJECT]</p><br>
            </td>
        </tr>  
    </table>
    <table style="width:100%; margin-top: 20px">
        <tr>
            <td style="text-align:center;width:90%;">
                <p>The [Date] meeting has been cancelled due to [Reason of Cancellation]. The meeting 
                    will be resheduled at a later date.</p><br>
            </td>
        </tr>  
    </table>
    <table style="width:100%; margin-top: 10px">
        <tr>

            <td style="text-align:center;width:90%;">
                <p> For any questions please contact [Contact Person] [Contact Number]. </p>
            </td>
        </tr>  
    </table>
</body>
</html>
