
<?php
include('include/header.php');
?>


<div class="container pagebg"  id="AuthCTRL" ng-controller="AuthCTRL">
    <div class="row">
        <div class="col-md-12">
            <div class="whitebg-page col-md-12">


                <form role="form" id="resetpass" ng-submit="SendPwdResetLink();">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email<span>*</span>:</label>
                            <input type="email" class="form-control" name="email" ng-model="FPwdData.email">
                            <span class="email err"></span>
                            <span class="error"></span>
                            <span class="success"></span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-contact forgot-btn btn-loadable" id="c-sub" name="mailbtn">send</button>
                        </div>
                    </div>

                </form>


            </div>	
        </div>	
    </div>
</div>	

<?php
include('include/footer.php');
?>