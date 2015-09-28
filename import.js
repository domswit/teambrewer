var myApp = angular.module('myApp', ['ngCookies']);

myApp.controller('importCtrl', function($scope, $http, $cookies, $location, auth, session) {
$scope.access_token = $cookies.get('access_token');
auth.checkLogin();
  $scope.auth = auth;
$scope.logout = function(){
  
  if(auth.logout() === true){
    window.location.href = 'login.html';
  }else{
    alert("User still logged in");
  }
}
});