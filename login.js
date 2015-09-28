var myApp = angular.module('myApp', ['ngCookies']);

myApp.controller('loginCtrl', function($scope, $cookies, $http, $window, session) {

  session.put('access_token', '');
    
  $scope.authenticate = function(id) {

    $http.post(APIURL + "authentication.php?rand=" + new Date().getTime(),{
      'username' : $scope.username,
      'password' : $scope.password,
      'access_token' : $scope.access_token
    })
    .success(function(data,status,headers,config){
        console.log(data);

        if (data.user){
		      session.put('access_token', data.user.access_token);
          window.location.href = 'charts.html';
        } 

        else  {
          $scope.message = "User does not exist";
        }
    });
  }
});
