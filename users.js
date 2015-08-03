angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies) {
  $scope.fName = '';
  $scope.lName = '';
  $scope.passw1 = '';
  $scope.passw2 = '';
  $scope.updateData = {}
  $scope.first_name2 = "test";

  var access_token = $cookies.get('access_token');

   $scope.pageArray = [];

   $(document).ready(function() {



    $('#datetimepicker1').datetimepicker({
      format: 'YYYY-MM-DD hh:mm:ss'
    });
    $("#datetimepicker1").on("dp.change", function(e) {
      $scope.ebirthdate = $('#ebirthdate').val();
    
    });
  });

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

      "http://localhost/teambrewer/API/user-list.php?rand=" + new Date()
      .getTime() + "&page=" + page + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.users);
     $scope.users = data.users;

     $scope.fillPageArray(data.total_rows, page);
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getTeams() {
    var response = $http.get(
      "http://localhost/teambrewer/API/team-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.teams);
      $scope.teams = data.teams;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });

  }

  $scope.getData();
  getTeams();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;

  
  $scope.addUser = function() {
    $scope.form_mode = 'insert';
    $scope.form_title = "Add User Information";
    $scope.efirst_name = '';
    $scope.elast_name = '';
    $scope.ebirthdate = '';
    $scope.eteam = '';
  }
  $scope.editUser = function(id) {
    $scope.form_mode = 'update';
    $scope.form_title = "Edit User Information";
    $scope.efullname = $scope.users[id].fullname.toString();
    $scope.ebirthdate = $scope.users[id].birthdate.toString();
    $scope.eteam = $scope.users[id].team_id.toString();
    $scope.user_id = $scope.users[id].user_id.toString();
  };
  $scope.savedata = function() {
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
    var user_id = $scope.user_id;
    var efullname = $('#efullname').val();
    var ebirthdate = $('#ebirthdate').val();
    var eteam = $('#eteam').val();
    $http.post("API/update-people.php", {
      'user_id': user_id,
      'fullname': efullname,
      'birthdate': ebirthdate,
      'team_id': eteam,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      $scope.getData();
      alert("User successfully updated!");
    });
  }
   
  $scope.insertData = function() {
    $http.post("API/insert-people.php", {
      'efullname': $scope.efullname,
      'ebirthdate': $scope.ebirthdate,
      'eteam': $scope.eteam,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      console.log(data);
      alert("User successfully added!");

      $scope.getData();

    });
  }
  
$scope.deleteData = function(id) {
    

    $http.post("API/delete-people.php", {
      'rand': new Date().getTime(),
      'id': id,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      alert("User successfully deleted!");
  

    $scope.getData();

      //popup here
    });
  }

});