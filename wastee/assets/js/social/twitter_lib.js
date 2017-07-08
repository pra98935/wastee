/* Twitter lib */
var Twitter = function(callback){
	self_twt = this;
	self_twt.callback = callback;
}

$.extend(Twitter.prototype, {
	self_twt : {},
	callback : '',
	child_window:{},

	Login : function()
	{
		self_twt.child_window = window.open("twitter/auth",'Twitter','width=500,height=500,scrollbars=yes');
	},

	TwtCallback : function( user_data)
	{
		//console.log('Twitter data ',user_data);
		var array_string = JSON.stringify(user_data);
        parent.$("#twtUserData").val(array_string);

        var data = JSON.parse( $("#twtUserData").val() );

		if(data.status == true)
		{
			window[self_twt.callback](data);
		}
	}
});

$(document).ready(function() {
	twt_obj = new Twitter('TwitterCallback');
	$('<input>').attr({type:'hidden', id:'twtUserData', name:'twtUserData'}).appendTo('body');
});

function TwitterCallback (user_data){
	twt_obj.child_window.close();
	if(user_data.status)
	{
		var appElement = document.querySelector('[ng-app=vfantasy]');
		var $rootscope = angular.element(appElement).scope();
	  	$rootscope.twitter_user_data = user_data;
   		$rootscope.$apply();
	}
}


/*function TwitterCallback (user_data)
{
 // console.log(user_data);
 twt_obj.child_window.close();

 if(user_data.status)
 {
  var appElement = document.querySelector('[ng-app=allprodraft]');
  var $rootscope = angular.element(appElement).scope();
    $rootscope.twitter_user_data = user_data;
    $rootscope.$apply();
 }
}*/