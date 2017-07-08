<?php include('include/header.php'); ?>
<div class="container pagebg page-login" id="AuthCTRL" ng-controller="AuthCTRL">	
    <div class="row">		
        <div class="col-md-4">		
        </div>		

        <div class="col-md-4 col-xs-12 whitebg-page">			

            <div class="joinnow-outer col-md-12">
                <div class="joinnow">join now!</div>
            </div>

            <div class="col-md-12">			
                <div class="col-md-1"></div>
                <div class="social-login-div col-md-10">	
                    <div class="social-login ">
                        <div class="fblogin col-md-12">
                            <div class="facebook-link facebook">
                                <a href="javascript:void(0);" class="disabled" ng-click="FbLogin();">
                                    <span class="text">Log in with Facebook</span>
                                </a>
                            </div>
                        </div>				
                        <div class="gmaillogin col-md-12">
                            <div class="google-link">
                                <button id="login-via-google">Log in with Google</button>
                            </div>
                        </div>				
                        <div class="customlogin col-md-12 text-center">
                            <a href="<?php echo base_url() ?>signup">Log in with e-mail + text</a>
                        </div>			
                    </div>
                </div>	
                <div class="col-md-1"></div>		
            </div>

        </div>

        <div class="col-md-4">		
        </div>		
    </div>
</div>	

<?php include('include/footer.php'); ?>