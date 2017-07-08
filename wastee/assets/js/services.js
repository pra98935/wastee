app.factory('dataSavingHttp', function($http,$location) {
	var wrapper = function(requestConfig) {
		var options = angular.extend({
			url: "",
			method: "POST",
			data : '',
			dataType: "json",
		},requestConfig);

		var key = sessionStorage.getItem(AUTH_KEY);
		options.headers = {};
		if(key == null)
		{
			options.headers[AUTH_KEY]='';
		}
		else 
		{
			options.headers[AUTH_KEY]=key;
		}
		var httpPromise = $http(options);
		httpPromise.success(function(result, status, headers, config){
			var l = window.location;
			wrapper.lastApiCallConfig = config;
			wrapper.lastApiCallUri = l.protocol + '//' + l.host + '' + config.url + '?' +
				(function(params){
					var pairs = [];
					angular.forEach(params, function(val, key){
						pairs.push(encodeURIComponent(key)+'='+encodeURIComponent(val));
					});
					return pairs.join('&')
				})(config.params);
			wrapper.lastApiCallResult = result;
		})
		return httpPromise;
	};
	return wrapper;
});

app.factory('showFormError', [function () {
	var bindError = function(error, element){
		var element_id = angular.element(element).attr('id');
		var field = '#'+element_id+'_error';
		angular.element(field).empty();
		angular.element(field).append(error.text());
		angular.element(field).show();
		return true;
	};
	return bindError;
}]);

app.factory('hideFormError', [function () {
	var bindError = function(error, element){
		var element_id = angular.element(element).attr('id');
		var field = '#'+element_id+'_error';
		angular.element(field).empty();
		angular.element(field).append(error.text());
		angular.element(field).hide();
		return true;
	};
	return bindError;
}]);

// directive to create salary format
app.filter('salaryFormat', function ($sce) {
	return function (item, withCurrency) {
		if(item || item == 0){
			if(typeof item === "string"){
				var n = item.split('.');
				if(n[1]!=undefined&&n[1]==0){
					item = n[0];
				}
			}
			formattedsalary = item.toString().replace(/(^\d{1,3}|\d{3})(?=(?:\d{3})+(?:$|\.))/g , '$1,');
			// Universal Currency code
			return (withCurrency==true)?$sce.trustAsHtml(formattedsalary):$sce.trustAsHtml(formattedsalary+' '+currency_code);
		}
		return item;
	};
});

app.filter('makeitbold', function($sce) {
	return function (input, query) {
		var r = RegExp('('+ query + ')', 'g');
		return $sce.trustAsHtml(input.replace(r,'<b>$1</b>'));
	}
});

app.filter('ordinal', [ function(){
	return function(number){
		if(isNaN(number) || number < 1){
			return number;
		} else {
			var lastDigit = number % 10;
			console.log(number.length);
			if(lastDigit === 1)
			{
				return number + 'st'
			} else if(lastDigit === 2)
			{
				return number + 'nd'
			} else if (lastDigit === 3)
			{
				return number + 'rd'
			} else if (lastDigit > 3){
				return number + 'th'
			}else
			{
				return number + 'th'
			}
		}
	}
}]);

app.factory('socket', ['$rootScope', '$timeout',function ($rootScope, $timeout) {
	var socket  = function(){};
	socket.on   = function(){};
	socket.emit = function(){};
	var socket = io(NodeAddr, {secure: 'https:' == location.protocol} );
	return {
		on: function (eventName, callback) {
			socket.on(eventName, function(){  
				var args = arguments;
				$timeout(function(){
					$rootScope.$apply(function(){
						callback.apply(socket, args);
					});
				});
			});
		},
		emit: function (eventName, data, callback) {
			socket.emit(eventName, data, function(){
				var args = arguments;
				$rootScope.$apply(function(){
					if (callback) {
						callback.apply(socket, args);
					}
				});
			})
		}
	};
}]);

app.filter('orderObjectBy', [function() {
	return function(items, field, reverse) {
		var filtered = [];
		angular.forEach(items, function(item) {
			filtered.push(item);
		});
		filtered.sort(function (a, b) {
			return (a[field] > b[field] ? 1 : -1);
		});
		if(reverse) filtered.reverse();
		return filtered;
	};
}]);

app.filter('spaceless',[function() {
	return function(input) {
		if (input) {
			var outstr =  input.replace(/\s+/g, '');
			return outstr.toLowerCase();
		}
	}
}]);

app.filter('cut', [function () {
        return function (value, wordwise, max, tail) {
            if (!value) return '';

            max = parseInt(max, 10);
            if (!max) return value;
            if (value.length <= max) return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace != -1) {
                  //Also remove . and , so its gives a cleaner result.
                  if (value.charAt(lastspace-1) == '.' || value.charAt(lastspace-1) == ',') {
                    lastspace = lastspace - 1;
                  }
                  value = value.substr(0, lastspace);
                }
            }

            return value + (tail || ' …');
        };
}]);

app.factory('Util', [function () {
		return {
			dhms: function (t) {

				var days, hours, minutes, seconds, days_str, hours_str, minutes_str, seconds_str;

				days = Math.floor(t / 86400);
				t -= days * 86400;
				days_str = (days <= 9) ? '0' + days : days;

				hours = Math.floor(t / 3600) % 24;
				t -= hours * 3600;
				hours_str = (hours <= 9) ? '0' + hours : hours;

				minutes = Math.floor(t / 60) % 60;
				t -= minutes * 60;
				minutes_str = (minutes <= 9) ? '0' + minutes : minutes;

				seconds = t % 60;
				seconds_str = (seconds <= 9) ? '0' + seconds : seconds;

				if (days > 0) {
					//return [days_str + 'Days', hours_str + ' :', minutes_str + ' :', seconds_str].join(' ');
					if(days_str=='1')
					{
						return [days_str + ' '+COUNTDOWN_DAY].join(' ');
					}
					else
					{
						return [days_str + ' '+COUNTDOWN_DAYS].join(' ');
					}
				} else {
					return [hours_str + ' :', minutes_str + ' :', seconds_str].join(' ');
				}
			}
		};
}]);