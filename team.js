angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location) {
  $scope.teams = '';
  $scope.updateData = {}
  $scope.pageArray = [];
  $scope.pageNum = function(){
    return (($location.search().p) ? $location.search().p : 1);
  }

  var access_token = $cookies.get('access_token');

  $scope.fillPageArray = function(num, page) {

      $scope.pageArray.splice(0);

      for(var i = 1; i <= num; i++){
        if (i >= page*1 - 2 && i <= page*1 + 2){
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
      "API/team-list.php?rand=" + new Date()
      .getTime() + "&page=" + page + "&access_token=" + access_token);
    response.success(function(data, status, headers, config) {
      
      if(data.success){
        $scope.teams = data.teams;
        $scope.fillPageArray(data.total_rows, page);
      } else {
       window.location.href = 'login.html';
      }

    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getUsers() {
    var response = $http.get(
      "API/user-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {

      if(data.success){
        console.log(data.users);
        $scope.users = data.users;

        setTimeout(function(){
          $scope.$apply();  
          $('.selectpicker').selectpicker(
          {
              size: 4
          });          
        },1);
        
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });

  }

  $scope.getData($scope.pageNum());
  getUsers();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;

  $scope.addTeam = function() {
    $scope.form_mode = 'insert';
    $scope.form_title = "Add Team Information";
    $scope.name = '';
  };

  $scope.editTeam = function(id) {
    $scope.team_id = id;
    $scope.form_mode = 'update';
    $scope.form_title = "Edit Team Information";
    $scope.team_id = id;
    $scope.name = $scope.teams[id].name.toString();
    $scope.setSelectedMembers(id);
  };

  $scope.setSelectedMembers = function() {
    var response = $http.get("API/team-members-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);
    
    response.success(function(data, status, headers, config) {
      
      if(data.success){
        $scope.team_id = data.team_id;

        //declare id array
        //loop data.members
          //push item to id array data.members[i].user_id

        //$('.selectpicker').selectpicker('val', id...);

        var memberArray = [];

          for(var x = 0; x < data.members.length; x++){
            memberArray.push(data.members[x].user_id);
          }
          console.log(memberArray);
          $('.selectpicker').selectpicker('val', memberArray);
            
      } else {
       window.location.href = 'login.html';
      }

    });

    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  $scope.saveData = function() {
    switch ($scope.form_mode) {
      case 'update':
        $scope.updateData();
        break;
      case 'insert':
        $scope.insertData();
        break;  
    }
  }

  $scope.updateData = function() {
    var team_id = $scope.team_id;
    var name = $('#name').val();
    var members = $('#members').val().join();
    console.log(members);
    $http.post("API/update-team.php", {
      'team_id': team_id,
      'name': name,
      'members': members,
      'access_token': access_token,
    }).success(function(data, status, headers, config) {

      if(data.success){
        $scope.getData($scope.pageNum());
        alert("Team successfully updated!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
  }

  $scope.insertData = function() {
    $http.post("API/insert-team.php", {
      'name': $scope.name,
      'access_token': access_token
    }).success(function(data, status, headers, config) {

      if(data.success){
        console.log(data);
        $scope.getData($scope.pageNum());
        alert("Team successfully added!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }

    });
  }

  $scope.deleteData = function(id) {
    if (confirm("Do you want to delete this data?") == true) {
    $http.post("API/delete-teams.php", {
      'rand': new Date().getTime(),
      'id': id,
      'access_token' : access_token
    }).success(function(data, status, headers, config) {

      if(data.success){
        console.log(data);
        alert("Team successfully deleted!");  

        $scope.getData($scope.pageNum());
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
  }
  }
});