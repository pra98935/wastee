<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Wastee</title>

    </head>
    <body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; background:#f1f1f1; margin:0; padding:0;">

        <table>
            <tr>
                <td width="100%" style="padding:40px 40px 10px 40px;background-color:#FFFFFF;">
                    <div class="sub-title" style="font-family:'Roboto' ,Arial, Helvetica, sans-serif; color:#333; padding:0 0 8px;font-weight:bold">Hi <?php echo $username; ?>,
                    </div>
                </td>
            </tr>
            <tr>				 
                <td style="padding:0 20px 20px 20px; vertical-align:top; background-color:#FFFFFF;">
                    <p class="text" style="font-family:'Roboto' ,Arial, Helvetica, sans-serif;  line-height:20px; color:#333;">
                        Thank you for signing up for <?php echo PROJECT_NAME;?> . We are very excited to have you as a customer. There is only one more step to take. Please click on the following link to activate your account:
                    </p>
                    <a href="<?php echo $link; ?>" style="text-decoration:none">
                        <span style="color:#007EFB">
                            <?php echo $link; ?>
                        </span>
                    </a>
                    <p class="text" style="font-family:'Roboto' ,Arial, Helvetica, sans-serif; line-height:20px; color:#333;">We looking forward to seeing you become a <?php echo PROJECT_NAME;?> user.</p>
                </td>
            </tr>

        </table>

    </body>
</html>