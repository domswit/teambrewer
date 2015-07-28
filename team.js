angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies) {
  $scope.teams = '';
  $scope.updateData = {}

  var access_token = $cookies.get('access_token');

  function getData() {
    var response = $http.get(
      "http://localhost/teambrewer/API/team-list.php?rand=" + new Date()
      .getTime(), {
        'access_token': $cookies.get('access_token')
      });
    response.success(function(data, status, headers, config) {
      console.log(data.teams);
      $scope.teams = data.teams;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }
  getData();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;
  $scope.editTeam = function(id) {
    console.log(id);
    console.log($scope.teams[id]);
    console.log($scope.teams[id].team_id);
    console.log($scope.teams[id].name);
    $scope.team_id = $scope.teams[id].team_id.toString();
    $scope.name = $scope.teams[id].name.toString();
  };
  $scope.updateData = function() {
    var team_id = $scope.team_id;
    var name = $('#name').val();
    $http.post("API/update-team.php", {
      'team_id': team_id,
      'name': name,
      'access_token': $cookies.get('access_token')
    }).success(function(data, status, headers, config) {
      getData();
    });
  }
  $scope.insertdata = function() {
    $http.post("API/insert-team.php", {
      'name': $scope.name,
      'access_token': $cookies.get('access_token')
    }).success(function(data, status, headers, config) {
      console.log(data);
      getData();
    });
  }
  $scope.deleteData = function(id) {
    
   
    $http.post("API/delete-teams.php?rand=" + new Date().getTime(), {
      'id': id
    }).success(function(data, status, headers, config) {
      console.log(data);
  
      getData();
      //popup here
    });
  }
});