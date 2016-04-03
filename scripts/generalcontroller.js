app.controller('GeneralMainCtrl', ['$scope', function($scope){
	
}]);

app.controller('GeneralIncometypeCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_income_types',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.types=result;
	});

	$scope.create=function(){
		$scope.maintype={};
		$('#modal').modal('show');
	}

	$scope.edit=function(type){
		$scope.type={};
		$scope.maintype=angular.copy(type);
		$('#modal').modal('show');
	}

	$scope.deactivate=function(type){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_income_type',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{type_id:type.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.types=result;
		});
	}

	$scope.activate=function(type){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_income_type',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{type_id:type.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.types=result;
		});
	}

	$scope.save=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_income_type',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.maintype
		}).success(function(result){
			$rootScope.showloader=false;
			if(result[0]=="success")
			{
				swal("Income type saved");
				$scope.types=result[1];
				$scope.maintype={};
				$('#modal').modal('hide');
			}
			else
			{
				swal(result[1]);
			}
		});
	}
}]);

app.controller('GeneralExptypeCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_exp_types',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.types=result;
	});

	$scope.create=function(){
		$scope.maintype={};
		$('#modal').modal('show');
	}

	$scope.edit=function(type){
		$scope.type={};
		$scope.maintype=angular.copy(type);
		$('#modal').modal('show');
	}

	$scope.deactivate=function(type){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_exp_type',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{type_id:type.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.types=result;
		});
	}

	$scope.activate=function(type){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_exp_type',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{type_id:type.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.types=result;
		});
	}

	$scope.save=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_exp_type',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.maintype
		}).success(function(result){
			$rootScope.showloader=false;
			if(result[0]=="success")
			{
				swal("Expenditure type saved");
				$scope.types=result[1];
				$scope.maintype={};
				$('#modal').modal('hide');
			}
			else
			{
				swal(result[1]);
			}
		});
	}
}]);

app.controller('GeneralAccountCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_accounts',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.accounts=result;
	});

	$scope.create=function(){
		$scope.mainaccount={};
		$('#modal').modal('show');
	}

	$scope.edit=function(account){
		$scope.mainaccount={};
		$scope.mainaccount=angular.copy(account);
		$('#modal').modal('show');
	}

	$scope.deactivate=function(account){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_account',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{account_id:account.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.accounts=result;
		});
	}

	$scope.activate=function(account){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_account',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{account_id:account.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.accounts=result;
		});
	}

	$scope.save=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_account',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.mainaccount
		}).success(function(result){
			$rootScope.showloader=false;
			if(result[0]=="success")
			{
				swal("Account saved");
				$scope.accounts=result[1];
				$scope.mainaccount={};
				$('#modal').modal('hide');
			}
			else
			{
				swal(result[1]);
			}
		});
	}
}]);

app.controller('GeneralUserCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_users',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.users=result;
	});

	$http({
		method:'GET',
		url:$rootScope.apiend+'get_roles',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.roles=result;
	});

	$scope.create=function(){
		$scope.muser={};
		$('#modal').modal('show');
	}

	$scope.edit=function(user){
		$scope.muser={};
		$scope.muser=angular.copy(user);
		$('#modal').modal('show');
	}

	$scope.deactivate=function(user){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_user',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{user_id:user.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.users=result;
		});
	}

	$scope.activate=function(user){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_user',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{user_id:user.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.users=result;
		});
	}

	$scope.save=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_user',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.muser
		}).success(function(result){
			$rootScope.showloader=false;
			if(result[0]=="success")
			{
				swal("User saved");
				$scope.users=result[1];
				$scope.muser={};
				$('#modal').modal('hide');
			}
			else
			{
				swal(result[1]);
			}
		});
	}
}]);