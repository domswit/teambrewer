angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
$scope.fName = '';
$scope.lName = '';
$scope.passw1 = '';
$scope.passw2 = '';

$scope.updateData = {}

$scope.first_name2 = "test";


$(document).ready(function () {
      $('.selectpicker').selectpicker({
          style: 'btn-info',
          size: 4
      });
});

$(document).ready(function () {
    $('#datetimepicker2').datetimepicker();
    $("#datetimepicker2").on("dp.change", function (e) {
      $scope.ebirthdate = e.date;
    });
});


function getData(){

  var response = $http.get("http://localhost/teambrewer/API/user-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.users);
      
      $scope.users = data.users;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

function getTeams(){

  var response = $http.get("http://localhost/teambrewer/API/team-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.teams);
      
      $scope.teams = data.teams;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

function getTeams(){

  var response = $http.get("http://localhost/teambrewer/API/team-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.teams);
      
      $scope.teams = data.teams;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

getData();
getTeams();



$scope.edit = true;
$scope.error = false;
$scope.incomplete = false; 

$scope.editUser = function(id) {

  
  console.log(id);
  console.log($scope.users[id]);
  console.log($scope.users[id].user_id);
  console.log($scope.users[id].first_name);
  console.log($scope.users[id].last_name);
  console.log($scope.users[id].birthdate);

 $scope.user_id = $scope.users[id].user_id.toString();
 $scope.first_name = $scope.users[id].first_name.toString();
 $scope.last_name = $scope.users[id].last_name.toString();
 $scope.birthdate = $scope.users[id].birthdate.toString();

};

$scope.updateData = function(){

  var edit_user_id = $scope.user_id;
  var edit_first_name = $('#edit_first_name').val();
  var edit_last_name = $('#edit_last_name').val();
  var edit_birthdate = $('#edit_birthdate').val();

  $http.post("API/update.php",{
    'user_id': edit_user_id, 
    'first_name': edit_first_name,
    'last_name': edit_last_name,
    'birthdate': edit_birthdate
    })
    .success(function(data,status,headers,config){
      console.log(data);
    getData();
      //popup here
    });

}
  $scope.insertdata=function(){

      $http.post("API/insert.php",{'efirst_name':$scope.efirst_name,'elast_name':$scope.elast_name,'ebirthdate':$scope.ebirthdate})
        .success(function(data,status,headers,config){
          console.log("nice");
    getData();
        });


  }


});