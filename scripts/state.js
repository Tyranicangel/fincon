app.config(function($stateProvider,$urlRouterProvider){
	$urlRouterProvider.otherwise("/login");

	$stateProvider.
		state('login',{
			url: '/login',
			views:{
				"main":{
					templateUrl:"partials/common/login.html",
					controller:'LoginCtrl'
				}
			}
		}).
		state('admin',{
			views:{
				"main":{
					templateUrl:"partials/admin/common.html",
					controller:'UserCtrl'
				}
			}
		}).
		state('admin.main',{
			url: '/admin/main',
			views:{
				"content":{
					templateUrl:"partials/admin/main.html",
					controller:'AdminMainCtrl'
				}
			}
		}).
		state('admin.company',{
			url: '/admin/company',
			views:{
				"content":{
					templateUrl:"partials/admin/company.html",
					controller:'AdminCompanyCtrl'
				}
			}
		}).
		state('admin.password',{
			url: '/admin/password',
			views:{
				"content":{
					templateUrl:"partials/common/password.html",
					controller:'PasswordCtrl'
				}
			}
		}).
		state('general',{
			views:{
				"main":{
					templateUrl:"partials/general/common.html",
					controller:'UserCtrl'
				}
			}
		}).
		state('general.main',{
			url: '/general/main',
			views:{
				"content":{
					templateUrl:"partials/general/main.html",
					controller:'GeneralMainCtrl'
				}
			}
		}).
		state('general.user',{
			url: '/general/user',
			views:{
				"content":{
					templateUrl:"partials/general/user.html",
					controller:'GeneralUserCtrl'
				}
			}
		}).
		state('general.account',{
			url: '/general/account',
			views:{
				"content":{
					templateUrl:"partials/general/account.html",
					controller:'GeneralAccountCtrl'
				}
			}
		}).
		state('general.exptype',{
			url: '/general/exptype',
			views:{
				"content":{
					templateUrl:"partials/general/exptype.html",
					controller:'GeneralExptypeCtrl'
				}
			}
		}).
		state('general.incometype',{
			url: '/general/incometype',
			views:{
				"content":{
					templateUrl:"partials/general/incometype.html",
					controller:'GeneralIncometypeCtrl'
				}
			}
		}).
		state('general.password',{
			url: '/general/password',
			views:{
				"content":{
					templateUrl:"partials/common/password.html",
					controller:'PasswordCtrl'
				}
			}
		}).
		state('accounts',{
			views:{
				"main":{
					templateUrl:"partials/accounts/common.html",
					controller:'UserCtrl'
				}
			}
		}).
		state('accounts.main',{
			url: '/accounts/main',
			views:{
				"content":{
					templateUrl:"partials/accounts/main.html",
					controller:'AccountsMainCtrl'
				}
			}
		}).
		state('accounts.parties',{
			url: '/accounts/parties',
			views:{
				"content":{
					templateUrl:"partials/accounts/parties.html",
					controller:'AccountsPartiesCtrl'
				}
			}
		}).
		state('accounts.sources',{
			url: '/accounts/sources',
			views:{
				"content":{
					templateUrl:"partials/accounts/sources.html",
					controller:'AccountsSourcesCtrl'
				}
			}
		}).
		state('accounts.expenditure',{
			url: '/accounts/expenditure',
			views:{
				"content":{
					templateUrl:"partials/accounts/expenditure.html",
					controller:'AccountsExpenditureCtrl'
				}
			}
		}).
		state('accounts.expupdate',{
			url: '/accounts/expupdate/:id',
			views:{
				"content":{
					templateUrl:"partials/accounts/expupdate.html",
					controller:'AccountsExpUpdateCtrl'
				}
			}
		}).
		state('accounts.income',{
			url: '/accounts/income',
			views:{
				"content":{
					templateUrl:"partials/accounts/income.html",
					controller:'AccountsIncomeCtrl'
				}
			}
		}).
		state('accounts.incomeupdate',{
			url: '/accounts/incomeupdate/:id',
			views:{
				"content":{
					templateUrl:"partials/accounts/incomeupdate.html",
					controller:'AccountsIncomeUpdateCtrl'
				}
			}
		}).
		state('accounts.transactions',{
			url: '/accounts/transactions',
			views:{
				"content":{
					templateUrl:"partials/accounts/transactions.html",
					controller:'AccountsTransactionsCtrl'
				}
			}
		}).
		state('accounts.transactionupdate',{
			url: '/accounts/transactionupdate/:id',
			views:{
				"content":{
					templateUrl:"partials/accounts/transactionupdate.html",
					controller:'AccountsTransactionUpdateCtrl'
				}
			}
		}).
		state('accounts.password',{
			url: '/accounts/password',
			views:{
				"content":{
					templateUrl:"partials/common/password.html",
					controller:'PasswordCtrl'
				}
			}
		}).
		state('head',{
			views:{
				"main":{
					templateUrl:"partials/head/common.html",
					controller:'UserCtrl'
				}
			}
		}).
		state('head.main',{
			url: '/head/main',
			views:{
				"content":{
					templateUrl:"partials/head/main.html",
					controller:'HeadMainCtrl'
				}
			}
		}).
		state('head.approve',{
			url: '/head/approve',
			views:{
				"content":{
					templateUrl:"partials/head/approve.html",
					controller:'HeadApproveCtrl'
				}
			}
		}).
		state('head.password',{
			url: '/head/password',
			views:{
				"content":{
					templateUrl:"partials/common/password.html",
					controller:'PasswordCtrl'
				}
			}
		});
});