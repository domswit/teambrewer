angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location) {
  $scope.fName = '';
  $scope.lName = '';
  $scope.passw1 = '';
  $scope.passw2 = '';
  $scope.updateData = {}
  $scope.first_name2 = "test";
  $scope.pageNum = function(){
    return (($location.search().p) ? $location.search().p : 1);
  }

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

      "API/user-list.php?rand=" + new Date()
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
      "API/team-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.teams);
      $scope.teams = data.teams;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });

  }

  $scope.getData($scope.pageNum());
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
    $scope.username = $scope.users[id].username.toString();
    $scope.password = $scope.users[id].password.toString();
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
    $http.post("API/update-people.php", {
      'user_id': $scope.user_id,
      'fullname': $scope.efullname,
      'birthdate': $scope.ebirthdate,
      'team_id': $scope.eteam,
      'username': $scope.username,
      'password': $scope.password,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      $scope.getData($scope.pageNum());
      alert("User successfully updated!");
    });
  }
   
  $scope.insertData = function() {
    $http.post("API/insert-people.php", {
      'efullname': $scope.efullname,
      'ebirthdate': $scope.ebirthdate,
      'username': $scope.username,
      'password': $scope.password,
      'eteam': $scope.eteam,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      console.log(data);
      alert("User successfully added!");

      $scope.getData($scope.pageNum());

    });
  }
  
$scope.deleteData = function(id) {

    $http.post("API/delete-people.php", {
      'rand': new Date().getTime(),
      'id': id,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      alert("User successfully deleted!");
  

    $scope.getData($scope.pageNum());

      //popup here
    });
  }

});