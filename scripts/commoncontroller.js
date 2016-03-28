app.controller('LoginCtrl', ['$scope','$rootScope','$http','$state', function($scope,$rootScope,$http,$state){
	$scope.loginuser={};
	$scope.login=function(){
		$rootScope.showloader=true;
		$rootScope.showerror=false;
		$rootScope.error="";
		$http({
			method:'POST',
			url:$rootScope.apiend+'login',
			data:$scope.loginuser
		}).success(function(result){
			$rootScope.showloader=false;
			if(result['statusCode']=="202")
			{
				localStorage.setItem("fincontoken",result['message']);
				$state.go(result['link']);
			}
			else
			{
				$rootScope.showerror=true;
				$rootScope.error=result['message'];
			}
		});
	}
}]);

app.controller('UserCtrl', ['$scope','$rootScope','$http','$state', function($scope,$rootScope,$http,$state){
	$http({
		method:'GET',
		url:$rootScope.apiend+'checkuser',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$scope.mainuser=result;
	}).error(function(err,data){
		$scope.logout();
	});

	$scope.logout=function(){
		localStorage.removeItem('surveyItem');
		$state.go('login');
	}
}]);

app.controller('PasswordCtrl', ['$scope','$rootScope','$http', function ($scope,$rootScope,$http) {
	$scope.reset_password=function(){
		if($scope.pass.new==$scope.pass.conf)
		{
			$http({
				method:'POST',
				url:$rootScope.apiend+'reset_password',
				headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
				data:$scope.pass
			}).success(function(result){
				if(result[0]=="success")
				{
					$scope.pass={};
				}
				swal(result[1]);
			});
		}
		else
		{
			swal('New Password and Confirm Password do not match');
		}
	}
}]);