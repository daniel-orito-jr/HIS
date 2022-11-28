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
                <strong>NOTICE OF</strong><br>
                <strong>ANNUAL GENERAL MEMBERS MEETING</strong><br>
            </td>
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <td style="text-align:left;width:90%;">

                <p>Dear [Name]:</p><br>
                <p>The Annual General Members Meeting of  <?= $profile['compname'] ?> has been scheduled for:  </p><br>
            </td>
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <td style="text-align:center;width:90%;">
                <strong>[Day], </strong><strong>[Date]</strong><br>
                <strong>At </strong><strong>[Time]</strong><br>
                <strong>In the </strong><strong>[Location]</strong><br>
                <strong>[(Address of the Location)]</strong><br>
                <strong>Registration starts at </strong><strong>[Registration time]</strong><br>
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%;">
        <tr>
            <td style="text-align:center;width:90%;">           
                <strong><u>Please note that quorum must be maintained</u></strong><br>
                <strong><u>during the entire meeting.</u></strong><br>  
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%; margin-top: 80px">
        <tr>
            <td style="text-align:left;width:90%;">           
                <p>[Signature]<p>
            </td>
        </tr>
    </table>
</body>
</html>
