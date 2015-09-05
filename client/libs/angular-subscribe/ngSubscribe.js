var subscribeModule = angular.module('ngSubscribe', []);

subscribeModule.directive('subscribe', function() {
    return {
        restrict: 'EA',
        scope: {
            errorMatch: '@',
            errorEmail: '@',
            errorMinLength: '@',
            subFinish: '@',
            subNotFinish: '@',
            button: '@',
            url: '@',
            minLengthPassword: '@'
        },
        template:
        '<form name="formSubscribe">'+
        '<div ng-if="subscribeIsComplete"><div class="alert alert-success" role="alert">{{subFinish}}</div></div>'+
        '<div ng-if="subscribeIsNotComplete"><div class="alert alert-danger" role="alert">{{subNotFinish}}</div></div>'+
        '<div ng-show="formSubscribe.email.$error.email || user.password != user.passwordRepeat || formSubscribe.password.$error.minlength" class="alert alert-danger" role="alert"><span ng-if="formSubscribe.email.$error.email"><li>{{errorEmail}}</li></span><span ng-if="user.password != user.passwordRepeat"><li>{{errorMatch}}</li></span><span ng-if="formSubscribe.password.$error.minlength"><li>{{errorMinLength}} - {{minLengthPassword}} minimun.</li></span></div>' +
        '<div ng-if="subscribeIsLoading"><font color="white"><i class="fa fa-spinner fa-spin"></i></font></div><input class="form-control" name="email" type="email" placeholder="Email" ng-model="user.email" required></br>' +
        '<input class="form-control" name="password" ng-minlength="minLengthPassword" placeholder="Password" type="password" ng-model="user.password" required></br>' +
        '<input class="form-control" name="passwordRepeat" ng-minlength="minLengthPassword"  placeholder="Password repeter" type="password" ng-model="user.passwordRepeat" required></br>' +
        '<button ng-click="validSubscribe(user)" class="btn btn-sm btn-danger" ng-disabled="formSubscribe.$invalid || user.password != user.passwordRepeat || user.password.length <= minPassword">{{button}}</button>'+
        '</form>',

        controller: ['$scope', '$http', '$q', function($scope, $http, $q) {

            $scope.validSubscribe = function(user) {
                $scope.subscribeIsComplete = false;
                $scope.subscribeIsNotComplete = false;
                $scope.subscribeIsLoading = true;

                $scope.newUserAccount(user).then(function(msg){
                    if(msg === "ok") {
                        $scope.user = "";
                        $scope.subscribeIsLoading = false;
                        $scope.subscribeIsComplete = true;
                    } else {
                        $scope.subscribeIsLoading = false;
                        $scope.subscribeIsNotComplete = true;
                    }
                });
            };

            $scope.newUserAccount = function(user) {
                return $q(function(resolve, reject) {
                    $http.post($scope.url, user).success(function(newAccount) {
                        $scope.newAccount = newAccount;
                        resolve($scope.newAccount);
                    }).error(function(error) {
                        reject(error);
                    })
                });
            }
        }]
    };
});
subscribeModule.directive('connection', function() {
    return {
        restrict: 'EA',
        scope: {
            errorInvalid: '@',
            errorNotExist: '@',
            button: '@',
            url: '@',
            nextUrl: '@'
        },
        template:
        '<form name="formConnection">'+
        '<div ng-if="userDoesNotExist"><div class="alert alert-danger" role="alert">{{errorNotExist}}</div></div>'+
        '<input type="email" class="form-control" ng-model="user.email" placeholder="Email" required><br/>'+
        '<input type="password" class="form-control" ng-model="user.password" placeholder="Your password" required> <br/>'+
        '<button ng-click="validConnection(user)" class="btn btn-sm btn-danger" ng-disabled="formConnection.$invalid">{{button}}</button>'+
        '</form>',

            controller: ['$scope', '$http', '$q', '$location', function($scope, $http, $q, $location) {
                $scope.userDoesNotExist = false;
            $scope.validConnection = function(user) {
                $scope.userDoesNotExist = false;
                $scope.newConnectionAccount(user).then(function(msg){
                    if(msg === "ok") {
                        $scope.user = "";
                        $location.path($scope.nextUrl);
                    } else {
                        $scope.userDoesNotExist = true;
                    }
                });
            };

            $scope.newConnectionAccount = function(user) {
                return $q(function(resolve, reject) {
                    $http.post($scope.url, user).success(function(newAccount) {
                        $scope.newAccount = newAccount;
                        resolve($scope.newAccount);
                    }).error(function(error) {
                        reject(error);
                    })
                });
            }
        }]
    };
});
