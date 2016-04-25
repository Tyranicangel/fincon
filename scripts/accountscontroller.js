app.controller('AccountsMainCtrl', ['$scope', function($scope){
	
}]);

app.controller('AccountsTransactionUpdateCtrl', ['$scope','$rootScope','$http','$stateParams','$state', function($scope,$rootScope,$http,$stateParams,$state){
	$rootScope.showloader=true;
	$scope.dlist=[];
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_transaction_details',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
		params:{id:$stateParams.id}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.exptypes=result[0];
		$scope.incometypes=result[1];
		$scope.accounts=result[2];
		$scope.sources=result[3];
		$scope.parties=result[4];
		if($stateParams.id==0)
		{
			$scope.transaction={};
		}
		else
		{
			result[5]['duedate']=new Date(result[5]['duedate']);
			$scope.transaction=result[5];
			$scope.dlist=result[6];
		}
	});

	$scope.save_transaction=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_transaction',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.transaction
		}).success(function(result){
			$rootScope.showloader=false;
			$state.go('accounts.transactions');
		});
	}

	$scope.change_type=function(){
		delete $scope.transaction.details;
		$scope.dlist=[];
	}

	$scope.adddetail=function(){
		$scope.maindetail={};
		$('#modal').modal('show');
	}

	$scope.detailfilter=function(a){
		if($scope.dlist.indexOf(a.id)>=0)
		{
			return false;
		}
		return true;
	}

	$scope.removedetail=function(i){
		if($scope.transaction.type==1)
		{
			$scope.dlist.splice($scope.dlist.indexOf($scope.transaction.details[i].source),1);
		}
		else
		{
			$scope.dlist.splice($scope.dlist.indexOf($scope.transaction.details[i].party),1);
		}
		$scope.transaction.details.splice(i,1);
	}

	$scope.transactionamount=function(){
		var sum=0;
		if($scope.transaction && $scope.transaction.details)
		{
			for(var i=0;i<$scope.transaction.details.length;i++)
			{
				sum=sum+Number($scope.transaction.details[i].amount);
			}
		}
		return sum;
	}

	$scope.editdetail=function(detail){
		$scope.maindetail=angular.copy(detail);
		$('#modal').modal('show');
	}

	$scope.save=function(){
		if($scope.maindetail.id)
		{
			for(var i=0;i<$scope.transaction.details.length;i++)
			{
				if($scope.transaction.details[i].id==$scope.maindetail.id)
				{
					$scope.transaction.details[i]=angular.copy($scope.maindetail);
				}
			}
		}
		else
		{
			sdet=angular.copy($scope.maindetail);
			if($scope.transaction.type==1)
			{
				for(var i=0;i<$scope.parties.length;i++)
				{
					if($scope.parties[i].id==sdet['party'])
					{
						sdet['partydets']=angular.copy($scope.parties[i]);
					}
				}
				$scope.dlist.push(angular.copy($scope.maindetail.party));
			}
			else
			{
				for(var i=0;i<$scope.sources.length;i++)
				{
					if($scope.sources[i].id==sdet['source'])
					{
						sdet['sourcedets']=angular.copy($scope.sources[i]);
					}
				}
				$scope.dlist.push(angular.copy($scope.maindetail.source));
			}
			if(!$scope.transaction.details)
			{
				$scope.transaction.details=[];
			}
			$scope.transaction.details.push(sdet);
			$scope.maindetail={};
		}
		$('#modal').modal('hide');
	}

}]);

app.controller('AccountsTransactionsCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_transaction_list',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.translist=result;
	});

	$scope.deactivate=function(trans){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_transaction',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{trans_id:trans.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.translist=result;
		});
	}

	$scope.activate=function(trans){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_transaction',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{trans_id:trans.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.translist=result;
		});
	}
}]);

app.controller('AccountsIncomeUpdateCtrl', ['$scope','$rootScope','$http','$stateParams','$state', function($scope,$rootScope,$http,$stateParams,$state){
	$rootScope.showloader=true;
	$scope.slist=[];
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_income_details',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
		params:{id:$stateParams.id}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.types=result[0];
		$scope.accounts=result[1];
		$scope.sources=result[2];
		if($stateParams.id=='0')
		{
			$scope.income={};
		}
		else
		{
			$scope.income=result[3];
			$scope.slist=result[4];
		}
	});

	$scope.save_income=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_income',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.income
		}).success(function(result){
			$rootScope.showloader=false;
			$state.go('accounts.income');
		});
	}

	$scope.removesource=function(i){
		$scope.slist.splice($scope.slist.indexOf($scope.income.sources[i].source),1);
		$scope.income.sources.splice(i,1);
	}

	$scope.incomeamount=function(){
		var sum=0;
		if($scope.income && $scope.income.sources)
		{
			for(var i=0;i<$scope.income.sources.length;i++)
			{
				sum=sum+Number($scope.income.sources[i].amount);
			}
		}
		return sum;
	}

	$scope.editsource=function(source){
		$scope.mainsource=angular.copy(source);
		$('#modal').modal('show');
	}

	$scope.addsource=function(){
		$scope.mainsource={};
		$('#modal').modal('show');
	}

	$scope.sourcefilter=function(a){
		if($scope.slist.indexOf(a.id)>=0)
		{
			return false;
		}
		return true;
	}

	$scope.save=function(){
		if($scope.mainsource.id)
		{
			for(var i=0;i<$scope.income.sources.length;i++)
			{
				if($scope.income.sources[i].id==$scope.mainsource.id)
				{
					$scope.income.sources[i]=angular.copy($scope.mainsource);
				}
			}
		}
		else
		{
			sdet=angular.copy($scope.mainsource);
			for(var i=0;i<$scope.sources.length;i++)
			{
				if($scope.sources[i].id==sdet['source'])
				{
					sdet['sourcedets']=angular.copy($scope.sources[i]);
				}
			}
			if(!$scope.income.sources)
			{
				$scope.income.sources=[];
			}
			$scope.income.sources.push(sdet);
			$scope.slist.push(angular.copy($scope.mainsource.source));
			$scope.mainsource={};
		}
		$('#modal').modal('hide');
	}
}]);

app.controller('AccountsIncomeCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_income_list',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.incomelist=result;
	});

	$scope.deactivate=function(income){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_income',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{income_id:income.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.incomelist=result;
		});
	}

	$scope.activate=function(income){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_income',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{income_id:income.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.incomelist=result;
		});
	}
}]);

app.controller('AccountsExpUpdateCtrl', ['$scope','$rootScope','$http','$stateParams','$state', function($scope,$rootScope,$http,$stateParams,$state){
	$rootScope.showloader=true;
	$scope.plist=[];
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_exp_details',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
		params:{id:$stateParams.id}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.types=result[0];
		$scope.accounts=result[1];
		$scope.parties=result[2];
		if($stateParams.id=='0')
		{
			$scope.exp={};
		}
		else
		{
			$scope.exp=result[3];
			$scope.plist=result[4];
		}
	});

	$scope.save_exp=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_exp',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.exp
		}).success(function(result){
			$rootScope.showloader=false;
			$state.go('accounts.expenditure');
		});
	}

	$scope.removeparty=function(i){
		$scope.plist.splice($scope.plist.indexOf($scope.exp.parties[i].third_party),1);
		$scope.exp.parties.splice(i,1);
	}

	$scope.expamount=function(){
		var sum=0;
		if($scope.exp && $scope.exp.parties)
		{
			for(var i=0;i<$scope.exp.parties.length;i++)
			{
				sum=sum+Number($scope.exp.parties[i].amount);
			}
		}
		return sum;
	}

	$scope.editparty=function(party){
		$scope.mainparty=angular.copy(party);
		$('#modal').modal('show');
	}

	$scope.addparty=function(){
		$scope.mainparty={};
		$('#modal').modal('show');
	}

	$scope.partyfilter=function(a){
		if($scope.plist.indexOf(a.id)>=0)
		{
			return false;
		}
		return true;
	}

	$scope.save=function(){
		if($scope.mainparty.id)
		{
			for(var i=0;i<$scope.exp.parties.length;i++)
			{
				if($scope.exp.parties[i].id==$scope.mainparty.id)
				{
					$scope.exp.parties[i]=angular.copy($scope.mainparty);
				}
			}
		}
		else
		{
			pdet=angular.copy($scope.mainparty);
			for(var i=0;i<$scope.parties.length;i++)
			{
				if($scope.parties[i].id==pdet['third_party'])
				{
					pdet['partydets']=angular.copy($scope.parties[i]);
				}
			}
			if(!$scope.exp.parties)
			{
				$scope.exp.parties=[];
			}
			$scope.exp.parties.push(pdet);
			$scope.plist.push(angular.copy($scope.mainparty.third_party));
			$scope.mainparty={};
		}
		$('#modal').modal('hide');
	}
}]);

app.controller('AccountsExpenditureCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_exp_list',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.explist=result;
	});

	$scope.deactivate=function(exp){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_exp',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{exp_id:exp.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.explist=result;
		});
	}

	$scope.activate=function(exp){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_exp',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{exp_id:exp.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.explist=result;
		});
	}
}]);

app.controller('AccountsPartiesCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_parties',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.parties=result;
	});

	$scope.create=function(){
		$scope.mainparty={};
		$('#modal').modal('show');
	}

	$scope.edit=function(party){
		$scope.mainparty={};
		$scope.mainparty=angular.copy(party);
		$('#modal').modal('show');
	}

	$scope.deactivate=function(party){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_party',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{party_id:party.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.parties=result;
		});
	}

	$scope.activate=function(party){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_party',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{party_id:party.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.parties=result;
		});
	}

	$scope.save=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_party',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.mainparty
		}).success(function(result){
			$rootScope.showloader=false;
			if(result[0]=="success")
			{
				swal("Party saved");
				$scope.parties=result[1];
				$scope.mainparty={};
				$('#modal').modal('hide');
			}
			else
			{
				swal(result[1]);
			}
		});
	}
}]);

app.controller('AccountsSourcesCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.showloader=true;
	$http({
		method:'GET',
		url:$rootScope.apiend+'get_sources',
		headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')}
	}).success(function(result){
		$rootScope.showloader=false;
		$scope.sources=result;
	});

	$scope.create=function(){
		$scope.mainsource={};
		$('#modal').modal('show');
	}

	$scope.edit=function(source){
		$scope.mainsource={};
		$scope.mainsource=angular.copy(source);
		$('#modal').modal('show');
	}

	$scope.deactivate=function(source){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'deactivate_source',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{source_id:source.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.sources=result;
		});
	}

	$scope.activate=function(source){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'activate_source',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:{source_id:source.id}
		}).success(function(result){
			$rootScope.showloader=false;
			$scope.sources=result;
		});
	}

	$scope.save=function(){
		$rootScope.showloader=true;
		$http({
			method:'POST',
			url:$rootScope.apiend+'save_source',
			headers:{'JWT-AuthToken':localStorage.getItem('fincontoken')},
			data:$scope.mainsource
		}).success(function(result){
			$rootScope.showloader=false;
			if(result[0]=="success")
			{
				swal("Party saved");
				$scope.sources=result[1];
				$scope.mainsource={};
				$('#modal').modal('hide');
			}
			else
			{
				swal(result[1]);
			}
		});
	}
}]);
