angular.module('myApp', ['ui.bootstrap']);
angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
$scope.teams = '';

$scope.updateData = {}

//$scope.first_name2 = "test";

function getTeam(){

  var response = $http.get("http://localhost/teambrewer/API/team-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.teams);
      
      $scope.teams = data.teams;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

function getProject(){

  var response = $http.get("http://localhost/teambrewer/API/project-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.projects);
      
      $scope.projects = data.projects;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

function getData(){

  var response = $http.get("http://localhost/teambrewer/API/user-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.users);
      
      $scope.users = data.users;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

function getSched(){

  var response = $http.get("http://localhost/teambrewer/API/sched-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.sched);
      
      $scope.sched = data.sched;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}


getTeam();
getProject();
getData();
getSched();

$scope.edit = true;
$scope.error = false;
$scope.incomplete = false; 

});