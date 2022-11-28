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

            table, td, th {    

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
                <td style="text-align:center;width:90%;">
                    <strong>NOTICE OF</strong><br>
                    <strong>BOARD MEETING</strong><br>
                </td>
            </tr>
        </table>

        <table style="width:100%;">
            <tr>
                <td style="text-align:left;width:90%;">
                    <p>[DATE]</p>
                    <p>[RECIPIENT]</p>
                    <p>[PLACE]:</p><br><br>
                    <p>Dear Members:</p>
                    <p><strong>[SUBJECT] ON [DATE] </strong></p><br>
                    <p>Please be informed that the [SUBJECT] of the <?= $profile['compname'] ?> will be held at the [PLACE] on [DATE]</p>
                </td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td style="text-align:center;width:90%;">
                    <strong>AGENDA</strong><br>
                    <p>[AGENDA]</p>
                </td>
            </tr>
        </table>
        <br>
        <table style="width:100%;">
            <tr>
                <td style="text-align:left;width:90%;">
                    <p>Thank you.</p><br>
                    <p>Respectfully yours,</p>
                    <p>[NAME]</p>
                    <p>[POSITION]</p>
                </td>
            </tr>
        </table>
        <br>
    </body>
</html>
