<?php include('include/header.php'); ?>
    <div class="container pagebg page-signup" id="AuthCTRL" ng-controller="AuthCTRL">
        <div class="row">
            <div class="col-md-1"> </div>
            <div class="col-md-10">
                <div class="whitebg-page col-md-12">
                    <div class="col-md-6 login-sec">
                        <div class="col-md-12 text-center">
                            <div class="heading-form">Login</div>
                        </div>
                        <form method="post" ng-submit="doLogin();">
                            <div class="col-md-6">
                                <label for="#field-email"></label>
                                <input type="text" ng-model="LoginObj.email" name="email" id="field-email" placeholder="Email Adresse"> </div>
                            <div class="col-md-6">
                                <label for="#field-pass"></label>
                                <input type="Password" ng-model="LoginObj.password" name="password" id="field-pass" placeholder="Passwort"> </div>
                            <div class="submit col-md-12">
                                <input type="submit" id="login-submit" class="btn-loadable" value="Login"> </div>
                            <div class="resetpass col-md-6"> <a href="<?php echo base_url(); ?>forgotpass">Passwort vergessen?</a> </div>
                        </form>
                    </div>
                    <div class="col-md-6 reg-sec">
                        <div class="col-md-12 text-center">
                            <div class="heading-form">Registrieren</div>
                        </div>
                        <form method="post" ng-submit="DoRegister(RegData);">
                            <div class="col-md-6">
                                <label for="#field-fname"></label>
                                <input type="text" ng-model="RegData.fname" name="fname" id="field-fname" placeholder="Vorname"> </div>
                            <div class="col-md-6">
                                <label for="#field-lname"></label>
                                <input type="text" ng-model="RegData.lname" name="lname" id="field-lname" placeholder="Nachname"> </div>
                            <div class="col-md-6">
                                <label for="#field-email"></label>
                                <input type="text" ng-model="RegData.email" name="email" id="field-email" placeholder="Email Adresse"> </div>
                            <div class="col-md-6">
                                <label for="#field-pass"></label>
                                <input type="Password" ng-model="RegData.password" name="pass" id="field-pass" placeholder="Passwort"> </div>
                            <div class="col-md-6">
                                <label for="#field-confirmpass"></label>
                                <input type="Password" ng-model="RegData.conf_password" name="conf_password" id="field-confirmpass" placeholder="Passwort bestätigen"> </div>
                            <div class="col-md-6 img-box-outer" ng-init="InitializeFineUpload('profile-pic');">
                                <label for="#profile-pic"></label>
                                <input type="file" name="profile" id="profile-pic" class="img-box"> <span ng-bind="uploadMessage" class="uploadmsgp"></span> <a ng-show="RegData.profile_image_url" ng-click="RemoveImage($index)" style="background: #000;padding: 0 3px;position: absolute;top: -1px;z-index: 999;">X</a> <img ng-show="RegData.profile_image_url" ng-src="{{RegData.profile_image_url}}" /> </div>
                            <div class="submit col-md-12">
                                <button type="submit" id="login-submit" class="btn-loadable">Registrieren <span class="loader"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"> </div>
        </div>
    </div>
    <script>
    </script>
    <?php include('include/footer.php'); ?>