angular.module('myApp1', []).controller('userCtrl', function($scope, $http) {
  $scope.insertdata=function(){

      $http.post("API/update.php",{'first_name':$scope.first_name,'last_name':$scope.last_name,'birthdate':$scope.birthdate})
        .success(function(data,status,headers,config){
          console.log("nice");
        });

  }

});