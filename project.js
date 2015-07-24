angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies) {
  $scope.fName = '';
  $scope.lName = '';
  $scope.passw1 = '';
  $scope.passw2 = '';
  $scope.updateData = {}
  $scope.first_name2 = "test";

  function getData() {
    var response = $http.get(
      "http://localhost/teambrewer/API/project-list.php?rand=" + new Date()
      .getTime(), {
        'access_token': $cookies.get('access_token')
      });
    response.success(function(data, status, headers, config) {
      console.log(data.projects);
      $scope.projects = data.projects;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }
  getData();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;
  $scope.editUser = function(id) {
    console.log(id);
    console.log($scope.projects[id]);
    console.log($scope.projects[id].project_id);
    console.log($scope.projects[id].project_name);
    $scope.project_id = $scope.projects[id].project_id.toString();
    $scope.project_name = $scope.projects[id].name.toString();
  };
  $scope.updateData = function() {
    var edit_project_id = $scope.project_id;
    var edit_project_name = $('#edit_project_name').val();
    $http.post("API/update-project.php", {
      'project_id': edit_project_id,
      'project_name': edit_project_name,
      'access_token': $cookies.get('access_token')
    }).success(function(data, status, headers, config) {
      console.log(data);
      getData();
    });
  }
  $scope.insertdata = function() {
    $http.post("API/insert-project.php", {
      'eproject_name': $scope.eproject_name,
      'access_token': $cookies.get('access_token')
    }).success(function(data, status, headers, config) {
      console.log(data);
      getData();
    });
  }
  $scope.deleteData = function(id) {
    

    $http.post("API/delete-project.php?rand=" + new Date().getTime(), {
      'id': id
    }).success(function(data, status, headers, config) {
      console.log(data);
  
      getData();
      //popup here
    });
  }
});