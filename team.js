angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies) {
  $scope.teams = '';
  $scope.updateData = {}
  $scope.pageArray = [];

  var access_token = $cookies.get('access_token');

    

  $scope.fillPageArray = function(num, page) {

      $scope.pageArray.splice(0);

      for(var i = 1; i <= num; i++){
        if (i >= page - 2 && i <= page + 2){
          $scope.pageArray.push(i);
        }
      }

      return $scope.pageArray;
  }

   $scope.getData = function(page) {

    if(page == undefined){
      page = 1;
    }


    var response = $http.get(
      "http://localhost/teambrewer/API/team-list.php?rand=" + new Date()
      .getTime() + "&page=" + page + "&access_token=" + access_token);
    response.success(function(data, status, headers, config) {
      console.log(data.teams);

     $scope.teams = data.teams;

     $scope.fillPageArray(data.total_rows, page);

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
      'access_token': access_token,
    }).success(function(data, status, headers, config) {

      $scope.getData();
      alert("Team successfully updated!");

    });
  }
  $scope.insertdata = function() {
    $http.post("API/insert-team.php", {
      'name': $scope.name,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      console.log(data);

      $scope.getData();
      alert("Team successfully added!");

    });
  }

  $scope.deleteData = function(id) {
    
    $http.post("API/delete-teams.php", {
      'rand': new Date().getTime(),
      'id': id,
      'access_token' : access_token
    }).success(function(data, status, headers, config) {
      console.log(data);
      alert("Team successfully deleted!");  

      $scope.getData();

      //popup here
    });
  }
});