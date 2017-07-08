<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Wastee</title>

    </head>
    <body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; background:#f1f1f1; margin:0; padding:0;">

        <table>
     
  <tr>
    <td colspan="2" class="content-padding" style="padding:40px 40px 20px; border-bottom:1px solid #E5E5E5;background:#FFFFFF;" ><p style="font-family: 'Roboto', sans-serif; font-size:16px; color:#444444; font-weight:500; margin-bottom:30px;">Hi <?php echo $username; ?>,</p>
      <p style="font-family: 'Roboto', sans-serif; font-size:16px; color:#444444; font-weight:500; margin-bottom:30px;">We received a forgot password request associated with this e-mail address. If you made this request, please follow the instructions below. </p>
      <p style="font-family: 'Roboto', sans-serif; font-size:16px; color:#444444; font-weight:500; margin-bottom:30px;">One time password reset link is given below, you can reset your password by clicking on given link.</p>
      <p style="font-family: 'Roboto', sans-serif; font-size:16px; color:#444444; font-weight:500; margin-bottom:30px;"><?php echo anchor($link, 'Reset Password', 'style="color:#00529F;cursor:pointer; display:block; text-decoration:none;"');?></p>
      <p style="font-family: 'Roboto', sans-serif; font-size:16px; color:#444444; font-weight:500; margin-bottom:30px;">If you did not request you can safely ignore this email. Rest assured your account is safe.</p>
    </td>
  </tr>

        </table>

    </body>
</html>