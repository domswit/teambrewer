var myApp = angular.module('myApp', ['ngCookies']);
var access_token;

  function resizeChart(){
    var wrapperWidth = $('#page-wrapper').width();
    var legendWidth = $('#legend-container').width();
    var graphWidth = wrapperWidth*1 - legendWidth*1 - 50;

    $('#placeholder').css('width', graphWidth + 'px');     
  }

myApp.controller('chartsCtrl', function($scope,$http, $cookies, $location, auth, session) {

  $scope.teams = '';
  $scope.projects = '';
  $scope.updateData = {};
  $scope.auth = auth;

  var filters = getUrlVars();

  access_token = session.get('access_token');

  auth.checkLogin();
  $scope.logout = function(){
  
  if(auth.logout() === true){
    window.location.href = 'login.html';
  }else{
    alert("User still logged in");
  }
}

  $(window).resize(function(){
    resizeChart();
  });

  $(window).ready(function(){
    resizeChart();    
  })


  $scope.getTeam = function() {
    var response = $http.get(

      APIURL + "team-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999" + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.teams);
      $scope.teams = data.teams;
      $scope.eteam = filters.team_id;

      setTimeout(function(){
        $scope.$apply();  
      }, 1);
      
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

 $scope.getProject = function() {
    var response = $http.get(
      APIURL + "project-list.php?rand=" + new Date()
      .getTime() + "&max_per_page=99999999" + "&access_token=" + access_token);

    response.success(function(data, status, headers, config) {
      console.log(data.projects);
      $scope.projects = data.projects;
      $scope.project_name = filters.project_id;

      setTimeout(function(){
        $scope.$apply();  
      }, 1);
    });

    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }


  $scope.getUsers = function() {
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

      setTimeout(function(){
        $scope.$apply();  
        $('#user_id').selectpicker('val', $scope.selectedPeople);
        $('#user_id').selectpicker();          
      },1);
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }
  
  $scope.getSched = function() {
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

  $scope.getTeam();
  $scope.getProject();
  $scope.getUsers();
  $scope.getSched();
  $scope.edit = true;
  $scope.error = false;
  $scope.incomplete = false;
 

});