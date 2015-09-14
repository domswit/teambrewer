
var myApp = angular.module('myApp', ['ngCookies']).controller('userCtrl', function($scope,
  $http, $cookies, $location, pagination, auth) {

  $scope.init = function(){

    $scope.access_token = $cookies.get('access_token');
    auth.checkLogin();

    $scope.auth = auth;
    $scope.form_title = "yeah";
    $scope.teams = '';
    $scope.pageArray = [];
    $scope.pagination = pagination;
    $scope.selectedPeople = [];

    $scope.getData($scope.pageNum());
    $scope.getUsers();
    $scope.edit = true;
    $scope.error = false;
    $scope.incomplete = false;
  }

  $scope.pageNum = function(){
    var page = (($location.search().p) ? $location.search().p : 1);   
    return page;
  }
  
  $scope.search = function(keyEvent){
    var keyCode = window.event ? keyEvent.keyCode : keyEvent.which;

    if(keyCode == 13){
      $scope.pageNum = 1;
      $scope.getData();
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
      "API/team-list.php?rand=" + new Date()
      .getTime() + "&page=" + page + "&access_token=" + $scope.access_token + "&search=" + $scope.getSearchString());
    response.success(function(data, status, headers, config) {
      
      if(data.success){
        $scope.teams = data.teams;
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

  $scope.getUsers =function() {
    var response = $http.get(
      "API/user-list.php?rand=" + new Date().getTime() + "&access_token=" + $scope.access_token);

    response.success(function(data, status, headers, config) {

      if(data.success){
        console.log(data.users);
        $scope.users = data.users;

        setTimeout(function(){
          $scope.$apply();  
          $('.selectpicker').selectpicker(
          {
              size: 4
          });          
        },1);
        
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });

  }

  $scope.addTeam = function() {
    $scope.form_mode = 'insert';
    $scope.form_title = "Add Team Information";
    $scope.name = '';
  };

  $scope.editTeam = function(id) {
    $scope.team_id = id;
    $scope.form_mode = 'update';
    $scope.form_title = "Edit Team Information";
    $scope.name = $scope.teams[id].name.toString();
    $scope.setSelectedMembers(id);
  };

  $scope.setSelectedMembers = function(team_id) {

    var response = $http.get("API/team-members-list.php?rand=" + new Date().getTime()  + "&team_id=" + team_id + "&access_token=" + $scope.access_token);

    response.success(function(data, status, headers, config) {
      
      if(data.success){
        //declare id array
        //loop data.members
          //push item to id array data.members[i].user_id

        //$('.selectpicker').selectpicker('val', id...);

        var memberArray = [];

          for(var x = 0; x < data.members.length; x++){
            memberArray.push(data.members[x].user_id);
          }
          
          $scope.selectedPeople = memberArray;


          console.log('members:');
          console.log($scope.selectedPeople);
          $('#members').selectpicker('val', memberArray);
          $('#members').selectpicker('render');
      } else {
       window.location.href = 'login.html';
      }

    });

    response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
    });
  }

  $scope.updateData = function() {
    var team_id = $scope.team_id;
    var name = $('#name').val();
    var members = $('#members').val().join();
    console.log(members);
    $http.post("API/update-team.php", {
      'team_id': team_id,
      'name': name,
      'members': members,
      'access_token': $scope.access_token,
    }).success(function(data, status, headers, config) {

      if(data.success){
        $scope.getData($scope.pageNum());
        alert("Team successfully updated!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
  }

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

  $scope.insertData = function() {
    $http.post("API/insert-team.php", {
      'name': $scope.name,
      'access_token': $scope.access_token
    }).success(function(data, status, headers, config) {

      if(data.success){
        console.log(data);
        $scope.getData($scope.pageNum());
        alert("Team successfully added!");
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }

    });
  }

  $scope.deleteData = function(id) {
    if (confirm("Do you want to delete this data?") == true) {
    $http.post("API/delete-teams.php", {
      'rand': new Date().getTime(),
      'id': id,
      'access_token' : $scope.access_token
    }).success(function(data, status, headers, config) {

      if(data.success){
        console.log(data);
        alert("Team successfully deleted!");  

        $scope.getData($scope.pageNum());
      } else {
        alert(data.message);
        window.location.href = 'login.html';
      }
    });
  }
  }

  $scope.init();
});