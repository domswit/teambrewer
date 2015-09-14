
var myApp = angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location, pagination, auth) {

  $scope.init = function(){
    $scope.access_token = $cookies.get('access_token');
    $scope.auth = auth;
    auth.checkLogin();

    $scope.fName = '';
    $scope.lName = '';
    $scope.passw1 = '';
    $scope.passw2 = '';
    $scope.updateData = {}
    $scope.first_name2 = "test";

    $scope.pageArray = [];
    $scope.pagination = pagination;

    $scope.query = $scope.users;
    $scope.getData($scope.pageNum());
    $scope.edit = true;
    $scope.error = false;
    $scope.incomplete = false;
  }

  $scope.pageNum = function(){
    var page = (($location.search().p) ? $location.search().p : 1);   
    return page;
  }

  $scope.fillPageArray = function(num, page) {

    $scope.pageArray.splice(0);

    console.log("yay " + num + " - " + page);

    for(var i = 1; i <= num; i++){
      if (i >= page*1 - 2 && i <= page*1 + 2){
        $scope.pageArray.push(i);
      }
    }

    console.log($scope.pageArray);

    return $scope.pageArray;
  }

  $scope.search = function(keyEvent){
    var keyCode = window.event ? keyEvent.keyCode : keyEvent.which;

    if(keyCode == 13){
      $scope.pageNum = 1;
      $scope.getData();
    }
  }

  $scope.getPageNum = function(){
    var queryPage = (($location.search().p) ? $location.search().p : 1);

    if($scope.pageNum != '' && $scope.pageNum != undefined){
      return $scope.pageNum;
    } else if( queryPage != '' ){
      return queryPage;
    } else {
      return '';
    }
  }
  
  $scope.getSearchString = function(){

    var querySearch = (($location.search().search) ? $location.search().search : '');

    if($scope.searchString != '' && $scope.searchString != undefined){
      return $scope.searchString;
    } else if( querySearch != '' ){
      return querySearch;
    } else {
      return '';
    }
  }

  $scope.getData = function(page) {

    var page = ( page ? page : $scope.getPageNum() );

    var response = $http.get(
        "API/project-list.php?rapnd=" + new Date()
        .getTime() + "&page=" + page + "&access_token=" + $scope.access_token + "&search=" + $scope.getSearchString());
      response.success(function(data, status, headers, config) {
        console.log(data.projects);
        if(data.success){

          $scope.projects = data.projects;
          $scope.fillPageArray(data.total_rows, page);
          pagination.setCurrentPage(page);
          pagination.setMaxPage(data.total_rows);
        } else {
          window.location.href = 'login.html';
        }
      });
      response.error(function(data, status, headers, config) {
        alert("AJAX failed!");
      }); 
  }

  $scope.addProject = function() {
    $scope.form_mode = 'insert';
    $scope.form_title = "Add Project Information";
    $scope.eproject_name = '';
  };

  $scope.editProject = function(id) {
    $scope.project_id = id;
    $scope.form_mode = 'update';
    $scope.form_title = "Edit Project Information";
    $scope.project_id = id;
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
    $http.post("API/update-project.php", {
      'project_id': $scope.project_id,
      'project_name': $scope.eproject_name,
      'access_token': $scope.access_token
    }).success(function(data, status, headers, config) {
      console.log(data);
      if(data.success){
        $scope.getData($scope.pageNum());
        alert("Project successfully updated!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
  }

  $scope.insertData = function() {
    $http.post("API/insert-project.php", {
      'eproject_name': $scope.eproject_name,
      'access_token': $scope.access_token
    }).success(function(data, status, headers, config) {
      console.log(data);
      if(data.success){
        $scope.getData($scope.pageNum());
        alert("Project successfully added!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
  }

  $scope.deleteData = function(id) {
    if (confirm("Do you want to delete this data?") == true) {
      $http.post("API/delete-project.php?rand=" + new Date().getTime(), {
        'id': id,
        'access_token':  $scope.access_token
      }).success(function(data, status, headers, config) {
        console.log(data);
        if(data.success){
          $scope.getData($scope.pageNum());
          alert("Project successfully deleted!");  
        } else {
          alert(data.message);
          window.location.href = 'login.html';
        }
        
        //popup here
      });
    }
  }

  $scope.init();
});