
var myApp = angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location, pagination, auth) {

  $scope.form_title = "yeah";
  $scope.fName = '';
  $scope.lName = '';
  $scope.passw1 = '';
  $scope.passw2 = '';
  $scope.updateData = {}
  $scope.first_name2 = "test";
  $scope.pageArray = [];
  $scope.pagination = pagination;
  
  var access_token = $cookies.get('access_token');

  auth.checkLogin();    

  $scope.pageNum = function(){
    var page = (($location.search().p) ? $location.search().p : 1);   
    return page;
  }



$scope.logout = function(){
  
  if(auth.logout() === true){
    window.location.href = 'login.html';
  }else{
    alert("User still logged in");
  }
}

$scope.fillPageArray = function(num, page) {

      $scope.pageArray.splice(0);

      for(var i = 1; i <= num; i++){
        if (i >= page*1 - 2 && i <= page*1 + 2){
          $scope.pageArray.push(i);
        }
      }

      return $scope.pageArray;
  }
  
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


  $scope.getSched = function(page) {

    if(page == undefined){
      page = 1;
    }


    var response = $http.get(

      "API/sched-list.php?rand=" + new Date()
      .getTime() + "&page=" + page + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data);
      console.log(data.sched);
      if(data.success){
       $scope.sched = data.sched;
       $scope.fillPageArray(data.total_rows, page);        
        pagination.setCurrentPage(page);
        pagination.setMaxPage(data.total_rows);
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }

    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getAlloc() {
    var response = $http.get(
      "API/allocation.php?rand=" + new Date().getTime() + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.allocation);
      $scope.allocation = data.allocation;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  function getData() {
    var response = $http.get("API/user-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      if(data.success){
        console.log(data.users);
        $scope.users = data.users;
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });

  }

  function getProjects() {
    var response = $http.get("API/project-list.php?rand=" + new Date().getTime() + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      if(data.success){
        $scope.projects = data.projects;
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });

  }
  getAlloc();
  getData();
  getProjects();
  $scope.getSched($scope.pageNum());
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
    $scope.ealloc = $scope.sched[id].allocation.toString();
    $scope.sched_id = $scope.sched[id].sched_id.toString();
    $scope.project_id = $scope.sched[id].project_id.toString();
    console.log($scope.sched[id]);
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
    var eproject = $('#eproject').val();
    $http.post("API/update-sched.php", {
      'sched_id': sched_id,
      'name': ename,
      'project_id': eproject,
      'fromdate': efromdate,
      'todate': etodate,
      'allocation': ealloc
    }).success(function(data, status, headers, config) {
      if(data.success){
        $scope.getSched($scope.pageNum());
        alert("Schedule successfully updated!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
  }
  $scope.insertData = function() {
    $http.post("API/insert-sched.php", {
      'ename': $scope.ename,
      'efromdate': $scope.efromdate,
      'etodate': $scope.etodate,
      'ealloc': $scope.ealloc,
      'eproject': $scope.eproject
    }).success(function(data, status, headers, config) {
      if(data.success){
        console.log(data);
        $scope.getSched($scope.pageNum());
        alert("Schedule successfully added!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }

    });
  }
  $scope.deleteData = function(id) {
    
if (confirm("Do you want to delete this data?") == true) {
    $http.post("API/delete-sched.php?rand=" + new Date().getTime(), {
      'id': id
    }).success(function(data, status, headers, config) {
      if(data.success){
        console.log(data);
    
        $scope.getSched($scope.pageNum());
        alert("Schedule successfully deleted!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
      //popup here
    });
  }
}
});