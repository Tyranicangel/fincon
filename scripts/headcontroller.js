app.controller('HeadMainCtrl', ['$scope', function($scope){
	
}]);

app.controller('HeadApproveCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_approval_list',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.translist=result;
	});

	$scope.viewtrans=function(trans){
		$scope.maintrans=angular.copy(trans);
		$('#modal').modal('show');
	}

	$scope.approve=function(){
		$rootScope.showloader=true;
		$http({
			method:'GET',
			url:$rootScope.apiend+'approve_trans',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			params:{transid:$scope.maintrans.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.translist=result;
			$('#modal').modal('hide');
		});
	}
}]);