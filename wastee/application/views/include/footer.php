<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBAlwVw450AIN5bErWg_tc4B1U_91ryVTg&libraries=places"
        async defer></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/social/facebook_lib.js"></script>
<?php if($this->session->userdata('user_id') == ''){ ?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/vendor/md5.min.js"></script>

	
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/social/twitter_lib.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/social/google_lib.js"></script>
<?php }/*else{?>
	<script type="text/javascript" src="<?php echo base_url();?>js/ajaxupload.js"></script>
	<script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
<?php }*/?>
</main>
<script>
//            $(document).ready(function() {
//              var owl = $('.owl-carousel');
//              owl.owlCarousel({
//                margin: 10,
//                nav: true,
//                loop: true,
//                responsive: {
//                  0: {
//                    items: 1
//                  },
//                  600: {
//                    items: 3
//                  },
//                  1000: {
//                    items: 5
//                  }
//                }
//              })
//			  $( ".owl-prev").html('<i class="fa fa-chevron-left"></i>');
//			$( ".owl-next").html('<i class="fa fa-chevron-right"></i>');
//            })
//			
//			 
          </script>
 <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
		  
<footer class="outer footer-sec">
	<div class="footer_outer ftr_top">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3">
                    <ul class="ftr-social">
                        <li><div class="fb-like" data-href="https://www.facebook.com/WasteeInc/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false" ></div></li>
                        <li><a href="https://twitter.com/Wastee_net" class="twitter-follow-button" data-show-count="false">Follow</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script></li>
						
						
                    </ul>
                </div>

				<div class="col-md-6 text-center ftr-link display-table">
					<ul class="display-table-cell">
						<li><a href="<?php echo base_url();?>contact">Kontakt</a></li>
						<li>&nbsp; · &nbsp;<a href="<?php echo base_url();?>faq">FAQ</a></li>
						<li>&nbsp; · &nbsp;<a href="<?php echo base_url();?>terms">AGB</a></li>
						<li>&nbsp; · &nbsp;<a href="<?php echo base_url();?>privacy">Datenschutz</a></li>
						<li>&nbsp; · &nbsp;<a href="javascript:void('0');">Jobs</a></li>
					</ul>	
				</div>

                <div class="col-md-3">
                    <div class="ftr-made-with-love">made with <span style="color:red;"> ❤ </span> © FuTech</div>
                </div>

				

			</div>
		</div>
	</div>
    
        <div class="footer_outer ftr_btm">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3">
                                    <h3>Navigation</h3>
                                    <ul class="">
                                        <li><a href="<?php echo base_url();?>contact">&raquo; Contact</a></li>
                                        <li><a href="<?php echo base_url();?>faq">&raquo; FAQ</a></li>
                                        <li><a href="<?php echo base_url();?>terms">&raquo; Terms</a></li>
                                        <li><a href="<?php echo base_url();?>privacy">&raquo; Data Protection</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Press</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Jobs</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Advertising</a></li>
                                    </ul>
				</div>

				<div class="col-md-3">
                                    <h3>Navigation</h3>
                                    <ul class="">
                                        <li><a href="<?php echo base_url();?>contact">&raquo; Contact</a></li>
                                        <li><a href="<?php echo base_url();?>faq">&raquo; FAQ</a></li>
                                        <li><a href="<?php echo base_url();?>terms">&raquo; Terms</a></li>
                                        <li><a href="<?php echo base_url();?>privacy">&raquo; Data Protection</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Press</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Jobs</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Advertising</a></li>
                                    </ul>	
				</div>

				<div class="col-md-3">
				    <h3>Navigation</h3>
                                    <ul class="">
                                        <li><a href="<?php echo base_url();?>contact">&raquo; Contact</a></li>
                                        <li><a href="<?php echo base_url();?>faq">&raquo; FAQ</a></li>
                                        <li><a href="<?php echo base_url();?>terms">&raquo; Terms</a></li>
                                        <li><a href="<?php echo base_url();?>privacy">&raquo; Data Protection</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Press</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Jobs</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Advertising</a></li>
                                    </ul>
				</div>
                            
                                <div class="col-md-3">
                                    <h3>Navigation</h3>
                                    <ul class="">
                                        <li><a href="<?php echo base_url();?>contact">&raquo; Contact</a></li>
                                        <li><a href="<?php echo base_url();?>faq">&raquo; FAQ</a></li>
                                        <li><a href="<?php echo base_url();?>terms">&raquo; Terms</a></li>
                                        <li><a href="<?php echo base_url();?>privacy">&raquo; Data Protection</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Press</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Jobs</a></li>
                                        <li><a href="javascript:void('0');">&raquo; Advertising</a></li>
                                    </ul>
				</div>
                            
                        </div>
		</div>
	</div>
    
    <input type="hidden" id="location_lat" value="" />
    <input type="hidden" id="location_lng" value="" />
</footer><!-- .site-footer -->

</body>



</html>
