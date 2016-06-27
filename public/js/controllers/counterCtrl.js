angular.module('counterCtrl', [])
.controller('counterController', function($scope, $http,$timeout, Lamb) {
	$scope.lambData = {};
	$scope.loading = true;
	$scope.day = 0;
	var timer;
	$scope.stopCounter = function() {
		$timeout.cancel(timer);
		timer = null;
	};
	$scope.startCounter = function() {
		if (timer === null) {
			updateCounter();
		}
	};
	var some = function(){
		$scope.day++;
		Lamb.nextDay();
		$timeout(some, 4000);
	}
	some();
	updateCounter();
});