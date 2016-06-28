// public/js/controllers/mainCtrl.js

angular.module('mainCtrl', [])

// inject the Lamb service into our controller
.controller('mainController', function($scope, $http, $timeout, Lamb) {
	$scope.day = 0;
	$scope.lambs=[[],[],[],[]];
	$scope.corrals = [0,1,2,3];
	var timer;

	var setLambs = function(lambs){
		for (var i = lambs.length - 1; i >= 0; i--) {
			$scope.lambs[lambs[i]['corral_id']].push(lambs[i]);
		};
	}
	var setCangedCorrals = function(corrals){
		for(var corral in corrals){
			$scope.lambs[corral] = corrals[corral];
		}
	}
	var nextday = function(){
		$scope.day++;
		Lamb.nextDay()
		.success(function(data){
			if (data.success) {
				setCangedCorrals(data.lambs);
			};
		});
		timer = $timeout(nextday, 10000);
	}
	var begins = function(){
		Lamb.get()
		.success(function(data){
			setLambs(data.lambs);
			console.log(data);
			$scope.day = data.time;
		});
		$timeout(nextday, 10000);
	}
	$scope.deleteLamb = function(id) {
		Lamb.destroy(id)
		.success(function(data){
			if (data.success) {
				setCangedCorrals(data.lambs);
			};
		});
	};
	$scope.nextDay = function() {
		nextday();
	};
	$scope.stopCounter = function() {
		$timeout.cancel(timer);
	};
	$scope.restartTime = function(){
		Lamb.init()
		.success(function(data){
			window.location.reload();
		});
	}
	$scope.update = function (id, to){
		Lamb.save({lamb_id: id, to:to}).
		success(function(data){
			if (data.success) {
				setCangedCorrals(data.lambs);
			};
		})
	}
	begins();
});