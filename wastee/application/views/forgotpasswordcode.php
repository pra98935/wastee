
<?php
include('include/header.php');
?>


<div class="container pagebg"  id="AuthCTRL" ng-controller="AuthCTRL">
    <div class="row">
        <div class="col-md-12">
            <div class="whitebg-page col-md-12">

                <?php 
                if(isset($error) && $error != ''){
                    ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong> <?php echo $error; ?>
                  </div>
                <?php
                } 
                else {
                    ?>
                    <form role="form" id="resetpass" ng-submit="ResetPassword();">

                        <div class="col-sm-6" ng-init="RPwdData.link = '<?php echo $link; ?>';">
                        <div class="form-group">
                            <label for="email">Password<span>*</span>:</label>
                            <input type="password" class="form-control" name="pwd" ng-model="RPwdData.reset_pass">
                            
                        </div>
                        <div class="form-group">
                            <label for="email">Confirm Password<span>*</span>:</label>
                            <input type="password" class="form-control" name="cpwd" ng-model="RPwdData.reset_cpass">
                            
                        </div>
                            <input type="hidden" class="form-control" name="email" ng-model="RPwdData.link">
                         
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-contact forgot-btn btn-loadable" id="c-sub" name="mailbtn">send</button>
                        </div>
                    </div>

                </form>
                <?php
                }
                ?>
                


            </div>	
        </div>	
    </div>
</div>	

<?php
include('include/footer.php');
?>