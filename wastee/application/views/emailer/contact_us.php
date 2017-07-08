<?php echo $this->load->view('emailer/header'); ?>
  <tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:16px; padding:20px 20px 0px 20px;" class="toppadding10">Hi <span style="color:#333333; font-weight:bold;"><?php echo ADMIN;?></span>,</td>
  </tr>
  <tr>
    <td style="padding:0 20px 20px 20px; vertical-align:top; background-color:#FFFFFF;">
      <p class="text" style="font-family:'Roboto' ,Arial, Helvetica, sans-serif; font-size:16px; line-height:20px; color:#333333; padding-top:2px;">A user wants to contact you. Details of user is given below.</p>
      <p class="text" style="font-family:'Roboto' ,Arial, Helvetica, sans-serif; font-size:16px; line-height:20px; color:#333333; padding-top:2px;">Name : <?php echo $name;?></p>
      <p class="text" style="font-family:'Roboto' ,Arial, Helvetica, sans-serif; font-size:16px; line-height:20px; color:#333333; padding-top:2px;">Email : <?php echo $email;?></p>
      <p class="text" style="font-family:'Roboto' ,Arial, Helvetica, sans-serif; font-size:16px; line-height:20px; color:#333333; padding-top:2px;">Description : <?php echo $description;?></p>
    </td>
  </tr>
<?php echo $this->load->view('emailer/footer'); ?>