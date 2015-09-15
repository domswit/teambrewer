var myApp = angular.module('myApp', ['ngCookies']);
var access_token;

myApp.controller('chartsCtrl', function($scope,$http, $cookies, $location, auth) {

  $scope.teams = '';
   $scope.projects = '';
  $scope.updateData = {}
  var filters = getUrlVars();

  access_token = $cookies.get('access_token');

  auth.checkLogin();
  $scope.logout = function(){
  
  if(auth.logout() === true){
    window.location.href = 'login.html';
  }else{
    alert("User still logged in");
  }
}


  function getTeam() {
    var response = $http.get(

      APIURL + "team-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999" + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.teams);
      $scope.teams = data.teams;
      $scope.eteam = filters.team_id;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

 function getProject() {
    var response = $http.get(
      "API/project-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999" + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.projects);
      $scope.projects = data.projects;
      $scope.project_name = filters.project_id;
    });

    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }


  function getData() {
    var response = $http.get(

      APIURL + "user-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999" + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.users);
      $scope.users = data.users;
      var user_ids = [];

      
      var urlPeople = decodeURIComponent(filters.people);
      var people = urlPeople.split(',');

      for(var i in people){
        user_ids.push(people[i]);
      }
      
      $scope.selectedPeople = user_ids;
      
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }
function
   getSched() {
    var response = $http.get(

      APIURL + "sched-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999" + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.sched);
      $scope.sched = data.sched;
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  $scope.submit = function(){
    $scope.people = $('#user_id').val();
    $scope.$apply();
  }

  getTeam();
  getProject();
  getData();
  getSched();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;
 

});