<?php echo $this->load->view('emailer/header'); ?>
  <tr>
    <td style="padding:20 20px 10px 20px">
    <p style="color:#000; font-family:Verdana, Geneva, sans-serif; font-size:16px; margin:0px; padding:0; font-weight:normal; line-height:50px;"><span style="color:#333333; font-weight:normal;">Hi,</span></p><span style="color:#333; display:block; font-size:26px;"></span></td>
  </tr>
  <tr>
    <td style="padding:0 20px 10px 20px; font-family:Verdana, Geneva, sans-serif; font-size:16px;"><?php echo $message;?></td>
  </tr>
  <tr>
    <td style="padding:0 20px 10px 20px; font-family:Verdana, Geneva, sans-serif; font-size:16px;">We looking forward to seeing you become a <?php echo PROJECT_NAME_FORMATED;?>.</td>
  </tr>
  <tr>
    <td style="padding:0 20px 10px 20px; font-family:Verdana, Geneva, sans-serif; font-size:16px;">
     Thank you for playing. Please <a href="<?php echo site_url('lobby'); ?>" style="color:#0083D3; text-decoration:none; cursor:pointer;">click here</a> to join another game.</td>
  </tr>
<?php echo $this->load->view('emailer/footer'); ?>