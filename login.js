angular.module('myApp', ['ngCookies']).controller('loginCtrl', function($scope, $cookies, $http, $window) {

    $cookies.put('access_token', '');
    
  $scope.authenticate = function(id) {

    $http.post("API/authentication.php?rand=" + new Date().getTime(),{
      'username' : $scope.username,
      'password' : $scope.password,
      'access_token' : $scope.access_token
    })
    .success(function(data,status,headers,config){
        console.log(data);

        if (data.user){

		      $cookies.put('access_token', data.user);
          $window.location.href = '/teambrewer/charts.html';
        } 

        else  {
          $scope.message = "User does not exist";
        }
    });
  }
});