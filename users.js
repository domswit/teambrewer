angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location) {
  $scope.fName = '';
  $scope.lName = '';
  $scope.passw1 = '';
  $scope.passw2 = '';
  $scope.updateData = {}
  $scope.first_name2 = "test";
  $scope.searchString = "123";

  $scope.search = function(keyEvent){
    var keyCode = window.event ? keyEvent.keyCode : keyEvent.which;

    if(keyCode == 13){
      $scope.getData( $scope.pageNum() );
    }
  }

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

   $scope.getData = function(page, searchString) {

    $scope.searchString;

    if(page == undefined){
      page = 1;
    }


    var response = $http.get(

      "API/user-list.php?rand=" + new Date()
      .getTime() + "&page=" + page + "&access_token=" + access_token + "&search=" + $scope.searchString);

    response.success(function(data, status, headers, config) {
      
      if(data.success){
        $scope.users = data.users;
        $scope.fillPageArray(data.total_rows, page);        
      } else {
        window.location.href = 'login.html';
      }
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getTeams() {
    var response = $http.get(
      "API/team-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {

      if(data.success){
        console.log(data.teams);
        $scope.teams = data.teams;
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
  getTeams();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;

  
  $scope.addUser = function() {
    $scope.form_mode = 'insert';
    $scope.form_title = "Add User Information";
    $scope.eusername = '';
    $scope.efullname = '';
    $scope.ebirthdate = '';
    $scope.eteam = '';
    $scope.eusername = '';
  }
  $scope.editUser = function(id) {
    $scope.form_mode = 'update';
    $scope.form_title = "Edit User Information";
    $scope.efullname = $scope.users[id].fullname.toString();
    $scope.ebirthdate = $scope.users[id].birthdate.toString();
    $scope.eteam = $scope.users[id].team_id.toString();
    $scope.user_id = $scope.users[id].user_id.toString();
    $scope.eusername = $scope.users[id].username.toString();
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
      'username': $scope.eusername,
      'password': $scope.epassword,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      if(data.success){
        $scope.getData($scope.pageNum());
        alert("User successfully updated!");
      } else {

        switch(data.message_code){
          case '1':
            window.location.href = 'login.html';  
          break;
          case '2':
            alert(data.message);
            break;
        }
      }
    });
  }
   
  $scope.insertData = function() {
    $http.post("API/insert-people.php", {
      'efullname': $scope.efullname,
      'ebirthdate': $scope.ebirthdate,
      'username': $scope.eusername,
      'password': $scope.epassword,
      'eteam': $scope.eteam,
      'access_token': access_token
    }).success(function(data, status, headers, config) {

      if(data.success){
        console.log(data);
        alert("User successfully added!");

        $scope.getData($scope.pageNum());
      } else {
        
        switch(data.message_code){
          case '1':
            window.location.href = 'login.html';  
          break;
          case '2':
            alert(data.message);
            break;
        }

      }

    });
  }
  
$scope.deleteData = function(id) {
  if (confirm("Do you want to delete this data?") == true) {
       
    $http.post("API/delete-people.php", {
      'rand': new Date().getTime(),
      'id': id,
      'access_token': access_token
    }).success(function(data, status, headers, config) {
      if(data.success){
        alert("User successfully deleted!");
    
        $scope.getData($scope.pageNum());
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }

      //popup here
    });
  }
}

});