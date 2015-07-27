angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location) {
  $scope.teams = '';
  $scope.updateData = {}
  $scope.pageArray = [];

  
  

  $scope.getPageNum = function(){
    //alert($location.search().p);
  }

    

  $scope.fillPageArray = function(num) {

      $scope.pageArray.splice(0);

      for(var i = 1; i <= num; i++){
        $scope.pageArray.push(i);
      }

      return $scope.pageArray;
  }

  $scope.getData = function(page) {
    //var page = $scope.getPageNum();

    //alert(page);
    var response = $http.get(
      "http://localhost/teambrewer/API/team-list.php?rand=" + new Date()
      .getTime() + "&page=" + page, {
        'access_token': $cookies.get('access_token')
      });
    response.success(function(data, status, headers, config) {
      $scope.teams = data.teams;

      $scope.fillPageArray(data.total_rows);
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }
  $scope.getData();
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
      $scope.getData();
    });
  }
  $scope.insertdata = function() {
    $http.post("API/insert-team.php", {
      'name': $scope.name,
      'access_token': $cookies.get('access_token')
    }).success(function(data, status, headers, config) {
      console.log(data);
      $scope.getData();
    });
  }
  $scope.deleteData = function(id) {
    
   
    $http.post("API/delete-teams.php?rand=" + new Date().getTime(), {
      'id': id
    }).success(function(data, status, headers, config) {
      console.log(data);
  
      $scope.getData();
      //popup here
    });
  }
});