angular.module('myApp', ['ui.bootstrap']);
angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
$scope.teams = '';

$scope.updateData = {}

//$scope.first_name2 = "test";


$(document).ready(function () {

    $('#datetimepicker1').datetimepicker({
      format: 'YYYY-MM-DD hh:mm:ss'
    });

    $("#datetimepicker1").on("dp.change", function (e) {
      $scope.efromdate = $('#efromdate').val();
    });

    $('#datetimepicker2').datetimepicker({
      format: 'YYYY-MM-DD hh:mm:ss'
    });

    $("#datetimepicker2").on("dp.change", function (e) {
      $scope.etodate = $('#etodate').val();
    });

});



function getTeam(){

  var response = $http.get("http://localhost/teambrewer/API/team-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.teams);
      
      $scope.teams = data.teams;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

function getProject(){

  var response = $http.get("http://localhost/teambrewer/API/project-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.projects);
      
      $scope.projects = data.projects;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}

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

function getSched(){

  var response = $http.get("http://localhost/teambrewer/API/sched-list.php?rand=" + new Date().getTime());

  response.success(function(data, status, headers, config) {
      console.log(data.sched);
      
      $scope.sched = data.sched;
  });
  response.error(function(data, status, headers, config) {
      alert("AJAX failed!");
  });
}


function getTwoDates(){

  var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
  var firstDate = new Date(2015,07,01);
  var secondDate = new Date(2015,07,10);

  var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));

  console.log("here")
  console.log(diffDays);

}

getTeam();
getProject();
getData();
getSched();
<<<<<<< HEAD
getChart();
getTwoDates();
=======
>>>>>>> 387e2cc73ab1a41227e2fc31fd8da4960f3a4067

$scope.edit = true;
$scope.error = false;
$scope.incomplete = false; 

// $scope.editTeam = function(id) {
  
//   console.log(id);
//   console.log($scope.teams[id]);
//   console.log($scope.teams[id].team_id);
//   console.log($scope.teams[id].team_name);

//  $scope.team_id = $scope.teams[id].team_id.toString();
//  $scope.team_name = $scope.teams[id].team_name.toString();

// };

// $scope.updateData = function(){

//   var edit_team_id = $scope.team_id;
//   var edit_team_name = $('#edit_team_name').val();

//   $http.post("API/update-team.php",{
//     'team_id': edit_team_id, 
//     'team_name': edit_team_name,
//     })
//     .success(function(data,status,headers,config){
//       console.log(data);
//     getData();
//       //popup here
//     });

// }
//   $scope.insertdata=function(){

//       $http.post("API/insert-team.php",{'eteam_name':$scope.eteam_name})
//         .success(function(data,status,headers,config){
//           console.log(data);
//         });


//   }

// DATETIMEPICKER GET VALUE TRIAL3
// function getDateDTP()
// {
//   var efromdate = $('#fromdate').val();
//   var etodate = $('#todate').val();

//   console.log("here");
//   console.log(efromdate);
//   console.log(etomdate);
// }

});