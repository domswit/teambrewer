angular.module('myApp', ['ui.bootstrap']);
angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
  $scope.teams = '';
  $scope.updateData = {}
  var filters = getUrlVars();

  function getTeam() {
    var response = $http.get(
      "API/team-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999");
    response.success(function(data, status, headers, config) {
      console.log(data.teams);
      $scope.teams = data.teams;
      $scope.eteam = filters.team_id;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getProject() {
    var response = $http.get(
      "API/project-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999");

    response.success(function(data, status, headers, config) {
      $scope.projects = data.projects;
      $scope.project_name = filters.project_id;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getData() {
    var response = $http.get(
      "API/user-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999");
    response.success(function(data, status, headers, config) {
      console.log(data.users);
      $scope.users = data.users;
      $scope.ename = filters.user_id;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }
function
   getSched() {
    var response = $http.get(
      "API/sched-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999");
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