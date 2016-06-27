// public/js/services/lambService.js

angular.module('lambService', [])

.factory('Lamb', function($http) {
	return {
		get : function() {
			return $http.get('/api/lambs');
		},
		save : function(lambData) {
			return $http({
				method: 'POST',
				url: '/api/lamb',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: lambData
			});
		},
		destroy : function(id) {
			return $http.delete('/api/lamb/' + id);
		},
		begins : function(){
			return $http.get('/api/lamb/begins');
		},
		nextDay : function(){
			return $http.post('/api/lamb/nextday');
		}
	}

});