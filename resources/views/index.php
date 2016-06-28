<!doctype html>
<html lang="en"> <head> <meta charset="UTF-8"> <title>Laravel and Angular Comment System</title>
	<link rel="stylesheet" href="/public/css/bootstrap.min.css"> 
	<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> -->
	<script type="text/javascript" src="/public/js/angular.min.js"></script>
	<script src="/public/js/controllers/mainCtrl.js"></script> <!-- load our controller -->
	<script src="/public/js/controllers/counterCtrl.js"></script> <!-- load our controller -->
	<script src="/public/js/services/lambService.js"></script> <!-- load our service -->
	<script src="/public/js/app.js"></script> <!-- load our application -->

<style>
.corrals{
	border: 1px solid #bbb;
	height: 400px;
	overflow: scroll;
}
.lamb{
	padding: 5px;
	margin: 2px;
	border: 1px solid #acc;
}
</style>
</head> 
<!-- declare our angular app and controller --> 
<body class="container" ng-app="lambApp" ng-controller="mainController"> <div class="col-md-8 col-md-offset-2">
	<div class="col-md-9">
		<h2>Фермочка для овечек</h2>
	</div>
	<div class="col-md-3">
		<br>
		<div>
			{{day}}
			<button ng-click="nextDay()">+1 Day</button>
			<button ng-click="stopCounter()">Stop</button>
			<button ng-click="restartTime()">Restart</button>
		</div>
	</div>
	<div class="corrals col-md-6" ng-repeat="i in corrals">
		<h3>Загон {{ i+1 }}</h3>
		<div class="lamb" ng-repeat="lamb in lambs[i]">
			<p id="lamb_" style='font-size: 12px'>
				Овечка #{{ lamb.id }}
				<a href="#" ng-click="deleteLamb(lamb.id)" class="text-muted">Зарубить</a>
				<label for="lamb_move">Переселить на:</label>
				<select name="lamb_move" id="lamb_{{lamb.id}}"
					ng-options="option+1 for option in corrals"
					ng-model="i"
					ng-change="update(lamb.id,i)"
					>
				</select>
			</p>
		</div>
	</div>

</div>
</body>
</html>