angular.module('myApp', []).controller('loginCtrl', function($scope, $http) {

  $scope.authenticate = function(id) {


  

    $http.post("API/authentication.php",{
      'username' : $scope.username,
      'password' : $scope.password
    })
    .success(function(data,status,headers,config){
      console.log(data);
    });

    
   
  }
});