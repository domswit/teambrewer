angular.module('myApp', ['ngCookies']).controller('loginCtrl', function($scope, $cookies, $http, $window) {

  $scope.authenticate = function(id) {

    $http.post("API/authentication.php?rand=" + new Date().getTime(),{
      'username' : $scope.username,
      'password' : $scope.password,
      'access_token' : $scope.access_token
    })
    .success(function(data,status,headers,config){
        console.log(data);

		    $cookies.put('access_token', data.user.access_token);

	      $window.location.href = '/teambrewer/charts.html';

    });

  }
});

