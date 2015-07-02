angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
  $scope.insertdata=function(){

      $http.post("API/insert.php",{'efirst_name':$scope.first_name,'elast_name':$scope.last_name,'ebirthdate':$scope.birthdate})
        .success(function(data,status,headers,config){
          console.log("nice");
        });

  }

});