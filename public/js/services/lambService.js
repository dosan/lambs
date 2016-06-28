// public/js/services/lambService.js

angular.module('lambService', [])

.factory('Lamb', function($http) {
	var  hostname = 'http://sandor.cu.cc/public';
	return {
		init : function() {
			return $http.get(hostname+'/api/lambs/init');
		},
		get : function() {
			return $http.get(hostname+'/api/lambs');
		},
		save : function(lambData) {
			return $http({
				method: 'POST',
				url: hostname+'/api/lamb',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: lambData
			});
		},
		destroy : function(id) {
			return $http.post(hostname+'/api/lamb/' + id);
		},
		begins : function(){
			return $http.get(hostname+'/api/lamb/begins');
		},
		nextDay : function(){
			return $http.post(hostname+'/api/lamb/nextday');
		}
	}

});