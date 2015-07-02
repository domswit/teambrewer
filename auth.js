angular.module('myApp', []).controller('loginCtrl', function($scope, $http) {

  $scope.authenticate = function(id) {


    //$scope.fName = "hi";
    

    $http.post("API/authentication.php",{
      'username' : $scope.username,
      'password' : $scope.password
    })
    .success(function(data,status,headers,config){
      console.log(data);
    });

    
    /*
    alert(id);
    if (id == 'new') {
      $scope.edit = true;
      $scope.incomplete = true;
      $scope.fName = '';
      $scope.lName = '';
      } else {
      $scope.edit = false;
      $scope.fName = $scope.users[id-1].fName;
      $scope.lName = $scope.users[id-1].lName; 
    }
    */
  }
});







