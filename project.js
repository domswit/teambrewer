angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location) {
  $scope.fName = '';
  $scope.lName = '';
  $scope.passw1 = '';
  $scope.passw2 = '';
  $scope.updateData = {}
  $scope.first_name2 = "test";
  $scope.pageArray = [];
  $scope.pageNum = (($location.search().p) ? $location.search().p : 1);

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
      "API/project-list.php?rand=" + new Date()
      .getTime() + "&page=" + page + "&access_token=" + access_token);
    response.success(function(data, status, headers, config) {
      console.log(data.projects);
     $scope.projects = data.projects;

     $scope.fillPageArray(data.total_rows, page);
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  $scope.getData($scope.pageNum);
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;


$scope.addProject = function() {
    $scope.form_mode = 'insert';
    $scope.form_title = "Add Project Information";
    $scope.eproject_name = '';
  };
  $scope.editProject = function(id) {
    $scope.form_mode = 'update';
    $scope.form_title = "Edit Project Information";
    $scope.eproject_name = $scope.projects[id].name.toString();
  };

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
    var edit_project_id = $scope.project_id;
    var edit_project_name = $('#edit_project_name').val();
    $http.post("API/update-project.php", {
      'project_id': edit_project_id,
      'project_name': edit_project_name,
      'access_token': $cookies.get('access_token')
    }).success(function(data, status, headers, config) {
      console.log(data);
      $scope.getData($scope.pageNum);
      alert("Project successfully updated!");
    });
  }
  $scope.insertData = function() {
    $http.post("API/insert-project.php", {
      'eproject_name': $scope.eproject_name,
      'access_token': $cookies.get('access_token')
    }).success(function(data, status, headers, config) {
      console.log(data);
      $scope.getData($scope.pageNum);
      alert("Project successfully added!");
    });
  }
  $scope.deleteData = function(id) {
    if (confirm("Do you want to delete this data?") == true) {

    $http.post("API/delete-project.php?rand=" + new Date().getTime(), {
      'id': id
    }).success(function(data, status, headers, config) {
      console.log(data);
     $scope.getData($scope.pageNum);
      alert("Project successfully deleted!");
      //popup here
    });
  }
  }
});