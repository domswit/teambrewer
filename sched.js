angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies) {
  $scope.form_title = "yeah";
  $scope.fName = '';
  $scope.lName = '';
  $scope.passw1 = '';
  $scope.passw2 = '';
  $scope.updateData = {}
  $scope.first_name2 = "test";
  

  var access_token = $cookies.get('access_token');

  $(document).ready(function() {
    $('#datetimepicker2').datetimepicker({
      format: 'YYYY-MM-DD hh:mm:ss'
    });
    $("#datetimepicker2").on("dp.change", function(e) {
      $scope.efromdate = $('#efromdate').val();
    });
  });
  $(document).ready(function() {
    $('#datetimepicker3').datetimepicker({
      format: 'YYYY-MM-DD hh:mm:ss'
    });
    $("#datetimepicker3").on("dp.change", function(e) {
      $scope.etodate = $('#etodate').val();
    });
  });

  function getSched() {
    var response = $http.get(
      "http://localhost/teambrewer/API/sched-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);
    response.success(function(data, status, headers, config) {
      console.log(data.sched);
      $scope.sched = data.sched;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getAlloc() {
    var response = $http.get(
      "http://localhost/teambrewer/API/allocation.php?rand=" + new Date().getTime() + "&access_token=" + access_token);
    response.success(function(data, status, headers, config) {
      console.log(data.allocation);
      $scope.allocation = data.allocation;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getData() {
    var response = $http.get(
      "http://localhost/teambrewer/API/user-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);
    response.success(function(data, status, headers, config) {
      console.log(data.users);
      $scope.users = data.users;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }
  getAlloc();
  getData();
  getSched();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;
  $scope.addUser = function() {
    $scope.form_mode = 'insert';
    $scope.form_title = "Add User Information";
    $scope.efromdate = '';
    $scope.etodate = '';
    $scope.ename = '';
    $scope.ealloc = '';
  }
  $scope.editUser = function(id) {
    $scope.form_mode = 'update';
    $scope.form_title = "Edit User Information";
    $scope.efromdate = $scope.sched[id].fromdate.toString();
    $scope.etodate = $scope.sched[id].todate.toString();
    $scope.ename = $scope.sched[id].user_id.toString();
    $scope.sched_id = $scope.sched[id].sched_id.toString();
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
    var sched_id = $scope.sched_id;
    var ename = $('#ename').val();
    var efromdate = $('#efromdate').val();
    var etodate = $('#etodate').val();
    var ealloc = $('#ealloc').val();
    $http.post("API/update-sched.php", {
      'sched_id': sched_id,
      'name': ename,
      'fromdate': efromdate,
      'todate': etodate,
      'allocation': ealloc
    }).success(function(data, status, headers, config) {
      console.log(data);
      getSched();
    });
  }
  $scope.insertData = function() {
    $http.post("API/insert-sched.php", {
      'ename': $scope.ename,
      'efromdate': $scope.efromdate,
      'etodate': $scope.etodate,
      'ealloc': $scope.ealloc
    }).success(function(data, status, headers, config) {
      console.log(data);
      getSched();
    });
  }
  $scope.deleteData = function(id) {
    

    $http.post("API/delete-sched.php?rand=" + new Date().getTime(), {
      'id': id
    }).success(function(data, status, headers, config) {
      console.log(data);
  
      getSched();
      //popup here
    });
  }
});