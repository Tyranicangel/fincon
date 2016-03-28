app.controller('AdminMainCtrl', ['$scope', function($scope){
	
}]);

app.controller('AdminCompanyCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_company',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.companies=result;
	});

	$scope.create=function(){
		$scope.maincompany={};
		$('#modal').modal('show');
	}

	$scope.edit=function(company){
		$scope.maincompany={};
		$scope.maincompany=angular.copy(company);
		$('#modal').modal('show');
	}

	$scope.deactivate=function(company){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_company',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{company_id:company.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.companies=result;
		});
	}

	$scope.activate=function(company){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_company',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{company_id:company.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.companies=result;
		});
	}

	$scope.save=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_company',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.maincompany
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.companies=result;
			$scope.maincompany={};
			$('#modal').modal('hide');
		});
	}
}]);