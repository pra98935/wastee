app.controller('AuthCTRL', function ($http, $scope, $timeout) {
        
        
        $scope.RegData = {};
        $scope.DoRegister = function (RegData) {
            //console.log(RegData)
            var validate = validateform('RegForm');
            if (!validate) {
                return false;
            }
            ShowBtnLoader();
            $http.post("/index/registermemberremote", RegData)
                    .success(function (serverResponse, status, headers, config) {
                        if (serverResponse.res == 'true') {
                            //jQuery(".form-response").html(serverResponse.msg);
                            //window.location = '/index';
                            jQuery("#signUp").modal("hide");
                            alertify.success(serverResponse.msg);
                            jQuery("#loginSuccess").modal("show");
                        } else {

                            alertify.error(serverResponse.msg);
                            HideBtnLoader();
                        }

                        //console.log(serverResponse.errorCode + " " + JSON.stringify(serverResponse));
                    }).error(function (serverResponse, status, headers, config) {
                //alert("failure");
                HideBtnLoader();
            });
        };
        
        $scope.ForgetPwd = {};
        $scope.RetrievePassword = function () {
            
            var validate = validateform('ForgetPasswordForm');
            if (!validate) {
                return false;
            }
            ShowBtnLoader();
            $http.post("/index/retrievepasswordremote", $scope.ForgetPwd)
                    .success(function (serverResponse, status, headers, config) {
                        if (serverResponse.res == 'true') {
                            alertify.success(serverResponse.msg, 7);
                            $scope.ForgetPwd.Email = '';
                            jQuery("#forgotPW").modal('hide');
                            
                        } else {
                            alertify.error(serverResponse.msg, 5);
                        }
                        HideBtnLoader();
                        
                        //console.log(serverResponse.errorCode + " " + JSON.stringify(serverResponse));
                    }).error(function (serverResponse, status, headers, config) {
                //alert("failure");
                HideBtnLoader();
            });
        };
        
    });