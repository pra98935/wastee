app.factory('dataSavingHttp', function ($http, $location) {

    var wrapper = function (requestConfig) {
        var options = angular.extend({url: "", method: "POST", data: '', dataType: "json", }, requestConfig);
        var key = sessionStorage.getItem(AUTH_KEY);
        options.headers = {};
        if (key == null) {
            options.headers[AUTH_KEY] = '';
        } else {
            options.headers[AUTH_KEY] = key;
        }
        var httpPromise = $http(options);
        httpPromise.success(function (result, status, headers, config) {
            var l = window.location;
            wrapper.lastApiCallConfig = config;
            wrapper.lastApiCallUri = l.protocol + '//' + l.host + '' + config.url + '?' + (function (params) {
                var pairs = [];
                angular.forEach(params, function (val, key) {
                    pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(val));
                });
                return pairs.join('&')
            })(config.params);
            wrapper.lastApiCallResult = result;
        });
        return httpPromise;
    };
    return wrapper;
});
app.controller('AuthCTRL', ['$scope', '$rootScope', 'dataSavingHttp', function ($scope, $rootScope, dataSavingHttp) {
        $scope.RegData = {};
        $scope.RegData.fname = '';
        $scope.RegData.lname = '';
        $scope.RegData.email = '';
        $scope.RegData.password = '';
        $scope.RegData.conf_password = '';
        $scope.RegData.social_type = '';
        $scope.RegData.social_id = 0;
        $scope.RegData.profile_image = '';
        $scope.RegData.profile_image_url = '';
        
        $scope.uploadMessage = '';
        
        $scope.process_loader = false;
        
        $scope.DoRegister = function () {                                            /*ShowBtnLoader();*/
            var sigupPass = window.md5($scope.RegData.password);
            var sigupconfpass = window.md5($scope.RegData.conf_password);
            var post_data = {
                "first_name": $scope.RegData.fname,
                "last_name": $scope.RegData.lname,
                "email": $scope.RegData.email,
                "user_name": $scope.RegData.username,
                "password": sigupPass,
                "conf_password": sigupconfpass,
                "image" : $scope.RegData.profile_image,
                "device_id": '0',
                "device_type": '1'
            };
            ShowBtnLoader();
            dataSavingHttp({url: base_url + "auth/signup", data: post_data, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                    $scope.RegData = {};
                } else {
                    alertify.error(response.GlobalError);
                }
                HideBtnLoader();
            }).error(function (error) {
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
        
        $scope.RemoveImage = function () {
            $scope.RegData.profile_image = '';
            $scope.RegData.profile_image_url = '';
            //console.log('delete index: ', Index, ' response: ', JSON.stringify($scope.EventInfo.Images));
        }
        
        $scope.InitializeFineUpload = function (field_id) {
            //console.log('jafsdj');
            //$scope.EventInfo.Images = [];
            var ImgIndex = 0;
            var btnUpload = $('#'+field_id);
            //var status = $('#status');
            new AjaxUpload(btnUpload, {
                action: base_url + 'auth/do_upload',
                name: field_id,
                responseType: "json",
                onSubmit: function (file, ext) {
                    
                    if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                        $scope.$apply(function () {
                            alertify.error('Only JPG, PNG or GIF files are allowed');
                        });
                        return false;
                    }
                    
                    $scope.$apply(function () {
                        $scope.uploadMessage = 'Processing...';
                        $scope.RegData.profile_image = '';
                        $scope.RegData.profile_image_url = '';
                        
                    });
                },
                onComplete: function (file, response) {

                    //On completion clear the status
                    //status.html('Updated Successfully');
                    if (response.ResponseCode == 200) {
                        //var length = $scope.MemberImages.push(response.data);
                        $scope.$apply(function () {
                            //add the file object to the scope's files collection
                            $scope.uploadMessage = '';
                            $scope.RegData.profile_image = response.Data.file_name;
                            $scope.RegData.profile_image_url = response.Data.image_url;
                        });
                    } else {
                        alertify.error(response.Message);
                        $scope.uploadMessage = '';
                    }                   
                }
            });
        }

        $scope.LoginObj = {};
        $scope.LoginObj.email = '';
        $scope.LoginObj.password = '';
        $scope.LoginObj.checkbox = false;

        $scope.LoginObj.social_type = '';
        $scope.LoginObj.social_id = 0;

        $scope.doLogin = function (socialData) {
            var loginPass = window.md5($scope.LoginObj.password);
            ShowBtnLoader();
            var post_data = {
                "device_id": '0',
                "device_type": '1',
                "email": $scope.LoginObj.email,
                "password": loginPass,
                "remember_me": $scope.LoginObj.checkbox,
            };

            if (socialData != undefined)
            {
                post_data = socialData;
            }
            dataSavingHttp({
                url: base_url + "auth/user_login",
                data: post_data,
            }).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                    sessionStorage.setItem(AUTH_KEY, response.Data[AUTH_KEY]);
                    if (response.Data.redirect_url)
                    {
                        window.location.href = response.Data.redirect_url;
                    }
                    else
                    {
                        window.location.href = base_url;
                    }
                } else {
                    alertify.error(response.GlobalError);
                    HideBtnLoader();
                }
                HideBtnLoader();

            }).error(function (error) {
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };

        /*Facebook Login*/
        $scope.FbLogin = function () {
            console.log('login');
            fb_obj.FbLoginStatusCheck('login');
        };
        /*Facebook Login aditional function*/
        $scope.FbUserData = function (user_data) {
            var post_data = {"first_name": user_data.first_name, 
                "last_name": user_data.last_name, 
                "email": user_data.email, 
                "device_id": '0', 
                "device_type": '1', 
                "social_type": 'facebook', 
                "social_id": user_data.id, 
                "page": 'signup', 
                "image": user_data.picture.large, 
            };
            if (user_data.id != '') {
                $scope.dosocialSignup(post_data);
            }
        };
        /*Facebook Login aditional function*/
        $scope.GoogleUSerData = function (user_data) {
            var img_size = 500;
            user_data.image = user_data.image.replace(/(sz=)[^\&]+/, '$1' + img_size);
            var post_data = {
                "first_name": user_data.first_name, 
                "last_name": user_data.last_name, 
                "email": user_data.email, 
                "device_id": '0', 
                "device_type": '1', 
                "social_type": 'google', 
                "social_id": user_data.id, 
                "page": 'signup', 
                "image": user_data.image, 
            };
            if (user_data.id != '') {
                $scope.dosocialSignup(post_data);
            }
        };

        $scope.dosocialSignup = function (post_data) {
            //console.log(post_data); //return;
            $rootScope.current_loader = "#signup_loader";
            dataSavingHttp({url: base_url + "auth/user_login", data: post_data, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    sessionStorage.setItem(AUTH_KEY, response.Data[AUTH_KEY]);
                    if (response.Data.redirect_url) {
                        window.location.href = response.Data.redirect_url;
                    } else {
                        window.location.href = base_url;
                    }
                }
            }).error(function (error) {
                if (error.ResponseCode == 500)
                    $rootScope.alert_error = err.Message;
            });
        };
        
        $scope.FPwdData = {};
        $scope.FPwdData.email = '';
        $scope.SendPwdResetLink = function() {
            ShowBtnLoader();
            
            var post_data = {
                "device_id": '0',
                "device_type": '1',
                "email": $scope.FPwdData.email,
            };
            
            dataSavingHttp({
                url: base_url + "auth/forgot_password",
                data: post_data,
            }).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                    
                } else {
                    alertify.error(response.GlobalError);
                    HideBtnLoader();
                }
                HideBtnLoader();

            }).error(function (error) {
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
        
        $scope.RPwdData = {};
        $scope.RPwdData.reset_pass = '';
        $scope.RPwdData.reset_cpass = '';
        $scope.RPwdData.link = '';
        
        $scope.ResetPassword = function() {
            ShowBtnLoader();
            
            var post_data = {
                "device_id": '0',
                "device_type": '1',
                "link": $scope.RPwdData.link,
                "reset_pass":  window.md5($scope.RPwdData.reset_pass),
                "reset_cpass":  window.md5($scope.RPwdData.reset_cpass),
            };
            
            dataSavingHttp({
                url: base_url + "auth/submit_reset_password",
                data: post_data,
            }).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                    window.location.href = base_url+'signup';
                } else { 
                    alertify.error(response.GlobalError);
                    HideBtnLoader();
                }
                HideBtnLoader();

            }).error(function (error) {
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
    }]);

app.controller('logoutCtrl', ['$scope', '$rootScope', 'dataSavingHttp', function ($scope, $rootScope, dataSavingHttp) {
        $scope.logout = function () {
            sessionStorage.clear();
            window.location.href = base_url + "auth/logout";
        };
    }]);

app.controller('RootCTRL', ['$scope', '$rootScope', '$sce', 'dataSavingHttp', function ($scope, $rootScope, $sce, dataSavingHttp) {
        
        $scope.search_tag = '';
        $scope.is_process = false;
        $scope.CreateSearchTag = function () {
            if($scope.is_process || $scope.search_tag == ''){
                return;
            }
            
            $scope.is_process = true;
            ShowBtnLoader();
            dataSavingHttp({url: base_url + "api_setting/create_search_tag", data: {search_tag:$scope.search_tag}, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                    $scope.search_tag = '';
                    $scope.SearchTags = response.Data.SearchTag;
                    
                } else if(response.ResponseCode == 401){
                    alertify.error(response.GlobalError);
                    window.location = base_url+'login';
                } else {
                    alertify.error(response.GlobalError);
                }
                $scope.is_process = false;
                HideBtnLoader();
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
        
        $scope.RemoveSearchTag = function(index){
            if($scope.is_process){
                return;
            }
            $scope.is_process = true;
            
            ShowBtnLoader();
            dataSavingHttp({url: base_url + "api_setting/remove_search_tag", data: {search_tag:index}, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                    $scope.SearchTags = response.Data.SearchTag;
                    
                } else {
                    alertify.error(response.GlobalError);
                }
                HideBtnLoader();
                $scope.is_process = false;
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
        
        $scope.NotificationList = [];
        $scope.NotificationTotal = 0;
        $scope.load_notification = false;
        $scope.getNotification = function(){
            $scope.load_notification = true;
            dataSavingHttp({
			url: base_url + "notification/get_notification_list",
			data: {offset:$scope.offset, limit: 20},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			$scope.offset          = data.offset; 
                        
			//$scope.NotificationList = $scope.NotificationList.concat(data.results);
			$scope.NotificationList = data.results;
                        $scope.NotificationTotal = data.total;
                    } else {
                        //alertify.error(response.GlobalError);
                    }
                    $scope.load_notification = false;
		}).error(function (error) {

		});
        };
        
        $scope.trustAsHtml = function(html){
            return $sce.trustAsHtml(html);
        }
        
    }]);

app.controller('HomeCTRL', ['$scope', '$rootScope', '$timeout', 'dataSavingHttp', function ($scope, $rootScope, $timeout, dataSavingHttp) {
        
        $scope.ProductList = [];
        $scope.SearchLocation = '';
        
        $scope.SearchByLocation = function(){
            $scope.offset=0;
            $scope.getProductList('search');
            //$scope.getNearYouProduct();
        };
                      
        $scope.getProductList = function (Action) {
            $timeout(function(){

                dataSavingHttp({
			url: base_url + "api_product/get_product_list",
			data: {offset:$scope.offset, 
                            is_sold: '0', 
                            search_text: $scope.searchtext, 
                            category_id: $scope.search_cat,
                            search_location: $scope.SearchLocation,
                            location_lat: jQuery("#location_lat").val(),
                            location_long: jQuery("#location_lng").val(),
                            distance: 1
                        },
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			$scope.offset          = data.offset; 
                        
                        if(Action == 'search'){
                                $scope.ProductList = [];
                        }
			$scope.ProductList = $scope.ProductList.concat(data.results);
                        
                        $timeout(function(){
                            jQuery('#blog-landing').pinterest_grid({
                                no_columns: 3,
                                padding_x: 10,
                                padding_y: 10,
                                margin_bottom: 50,
                                single_column_breakpoint: 700
                            });
                        });
                            
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {

		});
            },100);
        };
        
        $scope.LoadMoreHomeProduct = function(){
            console.log('jhasdhgsd sadh j sd');
        }
        
        $scope.NearYouProduct = [];
        $scope.getNearYouProduct = function () {
            
            dataSavingHttp({
			url: base_url + "api_product/get_product_list",
			data: {
                            offset:$scope.offset, limit: 9,  
                            sort_field:'created_date', sort_order: 'DESC',
                            is_sold: '0',
                            search_location: $scope.SearchLocation,
                            location_lat: jQuery("#location_lat").val(),
                            location_long: jQuery("#location_lng").val(),
                            distance: 50
                        },
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
			$scope.NearYouProduct = data.results;
                            
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {

		});
        };
        
    }]);

app.controller('ProductCTRL', ['$scope', '$rootScope', '$timeout', 'dataSavingHttp', function ($scope, $rootScope, $timeout, dataSavingHttp) {
        
        $scope.item_id = 0;
        
        $scope.ItemSell = {};
        $scope.ItemSell.currency = 'CHF';
        $scope.ItemSell.item_images = [];
        $scope.ItemSell.fb_share = 0;
        $scope.uploadMessage1 = '';
        $scope.uploadMessage2 = '';
        
        $scope.offset = 0;
        $scope.RecentProductList = [];
                       
        $scope.CreateItem = function () {
            
            ShowBtnLoader();
            $scope.ItemSell.location_lat = jQuery("#location_lat").val();
            $scope.ItemSell.location_long = jQuery("#location_lng").val();
            
            dataSavingHttp({url: base_url + "api_product/create_item", data: $scope.ItemSell, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                        
                    var ItemURL = base_url+"product/detail/"+response.Data.item_id;
                        
                    if($scope.ItemSell.fb_share == true){
                        
                        $scope.FBShare(ItemURL, $scope.ItemSell);
                    }
                    $timeout(function(){
                        $scope.ItemSell = {};
                        $scope.ItemSell.item_images = [];
                        window.location.href = ItemURL;
                    }, 1000);
                    
                } else {
                    alertify.error(response.GlobalError);
                }
                HideBtnLoader();
            }).error(function (error) {
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
        
        $scope.FBShare = function (detailUrl, ItemObj) {

            //console.log('fb share', detailUrl, ItemObj);
            
            FB.ui({
                method: 'share',
                //  link: base_url +  $scope.userProfileLink + '/activity/'+ActivityGUID,
                href: detailUrl,
                title:ItemObj.title,
                caption: project_name,//site_name,
                description: jQuery.trim(ItemObj.description).substring(0, 100).split(" ").slice(0, -1).join(" ") + "...",
                name: ItemObj.title,
                picture: IMAGE_UPLOADS_URL+"product/"+ItemObj.cover_image,
                app_id: FacebookAppId,
            }, function (response) {

            });
        };

        $scope.AddToWatchList = function (buy_status) {
            if($scope.item_id == undefined){
                return;
            }
            
            var RegData = {
                item_id: $scope.item_id,
                buy_status: buy_status
            } 
            dataSavingHttp({url: base_url + "api_product/add_to_buylist", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    //alertify.success(response.Message);
                } else {
                    //alertify.error(response.GlobalError);
                }
            }).error(function (error) {
            });
        };
        
        $scope.question_text = '';
        $scope.last_question = 0;
        $scope.QuestionList = [];
        
        $scope.AskQuestion = function () {
            if($scope.is_process || $scope.question_text == '' || $scope.item_id == undefined){
                return;
            }
            
            $scope.is_process = true;
            ShowBtnLoader();
            var RegData = {
                item_id: $scope.item_id,
                question_text:$scope.question_text, 
                last_question:$scope.last_question
            } 
            dataSavingHttp({url: base_url + "api_product/ask_question", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    $scope.question_text = '';
                    $scope.QuestionList = $scope.QuestionList.concat(response.Data.question_result);
                    $scope.last_question = response.Data.last_question;
                    
                    alertify.success(response.Message);
                } else {
                    alertify.error(response.GlobalError);
                }
                $scope.is_process = false;
                HideBtnLoader();
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
        
        $scope.getProductQuestion = function () {
            if($scope.item_id == undefined){
                return;
            }
            
            dataSavingHttp({
			url: base_url + "api_product/get_product_question",
			data: {item_id:$scope.item_id, last_question: $scope.last_question},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
                        $scope.QuestionList = $scope.QuestionList.concat(response.Data.question_result);
                        $scope.last_question = response.Data.last_question;
                        
                    } else {
                        //alertify.error(response.GlobalError);
                    }
                    $timeout(function(){
                        $scope.getProductQuestion();
                    }, 10000);
		}).error(function (error) {

		});
        };
        
        $scope.add_offer = {
            message: '',
            price: '',
            owner_id: '',
            conversation_id: 0
        };
        $scope.AddOffer = function (index, conversation_id) {
            if($scope.is_process){
                return;
            }
            $scope.is_process = true;
            ShowBtnLoader();
            var RegData = $scope.add_offer;
            RegData.item_id = $scope.item_id;
            if(conversation_id != undefined && conversation_id>0){
                RegData.conversation_id = conversation_id;
            }
            
            dataSavingHttp({url: base_url + "api_product/add_offer", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    $scope.add_offer = {
                        message: '',
                        price: '',
                        owner_id: '',
                        conversation_id: 0,
                        item_id: $scope.item_id
                    };
                    $scope.is_process = false;
                    $scope.getProductOffers(response.Data.conversation_id);
                    
                    alertify.success(response.Message);
                } else {
                    alertify.error(response.GlobalError);
                }
                $scope.is_process = false;
                HideBtnLoader();
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };
        
        $scope.AcceptOffre = function(LastOffer, OwnerID){
            if($scope.is_process || LastOffer == undefined || OwnerID == undefined){
                return;
            }
            $scope.is_process = true;
            var RegData = LastOffer;
            RegData.owner_id = OwnerID;
            
            dataSavingHttp({url: base_url + "api_product/accept_offer", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    $scope.is_process = false;
                    $scope.getProductOffers(response.Data.conversation_id);
                    
                    alertify.success(response.Message);
                } else {
                    alertify.error(response.GlobalError);
                }
                $scope.is_process = false;
                HideBtnLoader();
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
            });
        }
        
        $scope.ConfirmDeal = function(conversation_id){
            if($scope.is_process || conversation_id == undefined){
                return;
            }
            $scope.is_process = true;
            var RegData = {conversation_id: conversation_id};
            
            dataSavingHttp({url: base_url + "api_product/confirm_deal", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    $scope.is_process = false;
                    $scope.getProductOffers(response.Data.conversation_id);
                    
                    alertify.success(response.Message);
                } else {
                    alertify.error(response.GlobalError);
                }
                $scope.is_process = false;
                HideBtnLoader();
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
            });
        }
        $scope.CancleDeal = function(conversation_id){
            if($scope.is_process || conversation_id == undefined){
                return;
            }
            $scope.is_process = true;
            var RegData = {conversation_id: conversation_id};
            
            dataSavingHttp({url: base_url + "api_product/cancel_deal", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    $scope.is_process = false;
                    $scope.getProductOffers(response.Data.conversation_id);
                    
                    alertify.success(response.Message);
                } else {
                    alertify.error(response.GlobalError);
                }
                $scope.is_process = false;
                HideBtnLoader();
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
            });
        }
        
        $scope.ConfirmPopup = function(conversation_id, action){
            jQuery("#cancle-deal-"+conversation_id).hide();
            if(action == 'show'){
                jQuery("#confirm-deal-"+conversation_id).show();
            } else {
                jQuery("#confirm-deal-"+conversation_id).hide();
            }
        }
        
        $scope.CanclePopup = function(conversation_id, action){
            jQuery("#confirm-deal-"+conversation_id).hide();
            if(action == 'show'){
                jQuery("#cancle-deal-"+conversation_id).show();
            } else {
                jQuery("#cancle-deal-"+conversation_id).hide();
            }
        }
        
        $scope.AddReview = function () {
            if($scope.is_process){
                return;
            }
            
            $scope.is_process = true;
            var RegData = {};
            $.each(jQuery('#review_form').serializeArray(), function(i, field) {
                RegData[field.name] = field.value;
            });
            
            dataSavingHttp({url: base_url + "api_product/add_review", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    jQuery("#review_form")[0].reset();
                    
                    alertify.success(response.Message);
                } else {
                    alertify.error(response.GlobalError);
                }
                $scope.is_process = false;
            }).error(function (error) {
                $scope.is_process = false;
                alertify.error(response.GlobalError);
            });
        };
        
        $scope.ConversationList = [];
        $scope.have_you_bid = 0;
        $scope.getProductOffers = function (conversation_id) {
            if($scope.is_process || $scope.item_id == undefined){
                return;
            }
            $scope.is_process = true;
            
            dataSavingHttp({
			url: base_url + "api_product/get_product_offers",
			data: {item_id:$scope.item_id},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			
                        $scope.ConversationList = response.Data.result;
                        $scope.have_you_bid = response.Data.have_you_bid;
                        console.log($scope.ConversationList);
                        if($scope.ConversationList.length > 0){
                                jQuery(".product_offer").show();
                            }
                        $timeout(function (){
                            jQuery(".product_offer .slide").hide();
                            jQuery(".opener").click(function(){
                                jQuery(this).next(".slide").slideToggle();
                            });
                            
                            //jQuery(".product_offer").hide();
                            jQuery(".no-offers-yet-login a").click(function(){
                                jQuery(".product_offer").slideDown();
                                jQuery(".no-offers-yet-login").hide();
                            });
                            
                            if(conversation_id != undefined){
                                jQuery("#opener-"+conversation_id).trigger('click');
                            }
                        }, 100);
                    } else {
                        //alertify.error(response.GlobalError);
                    }
                    $scope.is_process = false;
                    
		}).error(function (error) {

		});
        };
        
        $scope.getRecentProductList = function () {
            
            dataSavingHttp({
			url: base_url + "api_product/get_product_list",
			data: {offset:$scope.offset, limit: 9, is_sold: '0', sort_field:'created_date', sort_order: 'DESC'},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
			$scope.RecentProductList = data.results;
                            
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {

		});
        };
        
        $scope.moreOwnerProductList = [];  
        $scope.moreOwnerProductTotal = 0;
        $scope.getMoreOwnerProduct = function (user_guid, is_sold) {
            
            if(is_sold == '' || is_sold == undefined){
                is_sold = '';
            }
            dataSavingHttp({
			url: base_url + "api_product/get_product_list",
			//data: {offset:0, limit: 6, user_guid: user_guid},
			data: {user_guid: user_guid, is_sold: is_sold},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
			$scope.moreOwnerProductList = data.results;
                        $scope.moreOwnerProductTotal = data.total;
                            
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {

		});
        };
        
        $scope.latestCatProductList = [];  
        $scope.latestCatProductTotal = 0;
        $scope.getLatestCategoryProduct = function () {
            
            dataSavingHttp({
			url: base_url + "api_product/get_product_list",
			data: {offset:0, is_sold: '0', category_id: 1},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
			$scope.latestCatProductList = data.results;
                        $scope.latestCatProductTotal = data.total;
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {});
        };
        
        $scope.similarProductList = [];  
        $scope.similarProductTotal = 0;
        $scope.getSimilarProduct = function (category_id) {
            
            dataSavingHttp({
			url: base_url + "api_product/get_product_list",
			data: {offset:0, is_sold: '0', category_id: category_id},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
			$scope.similarProductList = data.results;
                        $scope.similarProductTotal = data.total;
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {});
        };
        
        $scope.EmptyItemImg = [{},{},{},{},{}];
        $scope.InitializeFineUpload = function (field_id, index) {
            $timeout(function(){
             if(index != undefined){
                field_id = field_id +index;
            }
            
            var ImgIndex = 0;
            var btnUpload = $('#'+field_id); //console.log(btnUpload); return;
            //var status = $('#status');
            new AjaxUpload(btnUpload, {
                action: base_url + 'api_product/do_upload',
                name: field_id,
                responseType: "json",
                onSubmit: function (file, ext) {
                    
                    if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                        $scope.$apply(function () {
                            alertify.error('Only JPG, PNG or GIF files are allowed');
                        });
                        return false;
                    }
                    if (field_id != 'upload-cover' && $scope.ItemSell.item_images.length >= 5) {
                        $scope.$apply(function () {
                            alertify.error('Max. 5 images allowed');
                        });
                        return false;
                    }
                    $scope.$apply(function () {
                        if (field_id == 'upload-cover'){
                            $scope.uploadMessage1 = 'Processing...';
                            $scope.ItemSell.cover_image = '';
                            $scope.ItemSell.cover_image_url = '';
                                
                        } else {
                            $scope.uploadMessage2 = 'Processing...';
                        }
                    });
                },
                onComplete: function (file, response) {

                    //On completion clear the status
                    //status.html('Updated Successfully');
                    if (response.ResponseCode == 200) {
                        //var length = $scope.MemberImages.push(response.data);
                        $scope.$apply(function () {
                            //add the file object to the scope's files collection
                            if(response.Data.field_name == 'upload-cover'){
                                $scope.uploadMessage1 = '';
                                $scope.ItemSell.cover_image = response.Data.file_name;
                                $scope.ItemSell.cover_image_url = response.Data.image_url;
                                
                            } else {
                                $scope.uploadMessage2 = '';
                                $scope.ItemSell.item_images.push(response.Data);
                                $scope.EmptyItemImg.splice(0, 1);
                                console.log($scope.ItemSell.item_images);
                            }
                        });
                    } else {
                        alertify.error(response.Message);
                        $scope.uploadMessage1 = '';
                        $scope.uploadMessage2 = '';
                    }                   
                }
            });
            }, 10);
        }

        $scope.RemoveImage = function (Index) {
            $scope.ItemSell.item_images.splice(Index, 1);
            var EmptyImg = {};
            $scope.EmptyItemImg.push(EmptyImg);
            //console.log('delete index: ', Index, ' response: ', JSON.stringify($scope.EventInfo.Images));
        }
    }]);

app.controller('SettingCTRL', ['$scope', '$rootScope', 'dataSavingHttp', function ($scope, $rootScope, dataSavingHttp) {
        $scope.is_follow = '0';
        $scope.setFollowStatus = function (following_id) {
            if (following_id == undefined || following_id == '') {
                return false;
            }
            ShowBtnLoader();
            dataSavingHttp({url: base_url + "api_setting/set_follow_status", data: {following_id: following_id, is_follow: $scope.is_follow}}).success(function (response) {
                if (response.ResponseCode == 200) {
                    alertify.success(response.Message);
                    $scope.is_follow = response.Data.is_follow;
                    //window.location.href = base_url;

                } else {
                    alertify.error(response.GlobalError);
                }
                HideBtnLoader();
            }).error(function (error) {
                alertify.error(response.GlobalError);
                HideBtnLoader();
            });
        };

        $scope.FollowsList = [];
        $scope.FollowersList = [];
        $scope.getFollowsNFollower = function (user_guid) {

            dataSavingHttp({
                url: base_url + "api_setting/get_follows_n_follower",
                data: {user_guid: user_guid},
            }).success(function (response) {
                if (response.ResponseCode == 200) {
                    var data = response.Data;

                    $scope.FollowsList = data.follows;
                    $scope.FollowersList = data.followers;

                } else {
                    //alertify.error(response.GlobalError);
                }
            }).error(function (error) {

            });
        };
        
        $scope.WatchList = [];
        $scope.getWatchList = function () {
            
            dataSavingHttp({
			url: base_url + "api_product/get_watch_list",
			data: {},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
			$scope.WatchList = data.results;
                            
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {

		});
        };

        $scope.ShowWCConfirm = function(index){
            jQuery("#WC-confirm-"+index).show();
        }
        
        $scope.HideWCConfirm = function(index){
            jQuery("#WC-confirm-"+index).hide();
        }
        
        $scope.ReviewList = [];
        $scope.total_review = 0;
        $scope.getReviewList = function (user_id) {
            
            dataSavingHttp({
			url: base_url + "api_product/get_review_list",
			data: {user_id: user_id},
		}).success(function (response) {
                    if (response.ResponseCode == 200) {
			var data = response.Data;
			
			$scope.ReviewList = data.results;
			$scope.total_review = data.total_review;
                            
                    } else {
                        //alertify.error(response.GlobalError);
                    }
		}).error(function (error) {

		});
        };
        
        $scope.getNumber = function(num) {
            return new Array(num);   
        }
        
        $scope.removeFromWatchlist = function (item_id, index) {
            if(item_id == undefined){
                return;
            }
            var RegData = {
                item_id: item_id
            } 
            dataSavingHttp({url: base_url + "api_product/remove_from_buylist", data: RegData, }).success(function (response) {
                if (response.ResponseCode == 200) {
                    
                    $scope.WatchList.splice(index, 1);
                    alertify.success(response.Message);
                } else {
                    alertify.error(response.GlobalError);
                }
            }).error(function (error) {
            });
        };
    }]);