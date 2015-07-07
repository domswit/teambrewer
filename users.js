angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
$scope.fName = '';
$scope.lName = '';
$scope.passw1 = '';
$scope.passw2 = '';

$scope.updateData = {}

$scope.first_name2 = "test";

$(document).ready(function () {
    $('#datetimepicker1').datetimepicker({
      format: 'YYYY-MM-DD hh:mm:ss'

    });
    $("#datetimepicker1").on("dp.change", function (e) {
      $scope.ebirthdate = $('#ebirthdate').val();
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

getData();
getTeams();



$scope.edit = true;
$scope.error = false;
$scope.incomplete = false; 


$scope.addUser = function() {
  $scope.form_mode = 'insert';
  $scope.form_title = "Add User Information";

  $scope.efirst_name = '';
  $scope.elast_name = '';
  $scope.ebirthdate = '';
  $scope.eteam = '';
}

$scope.editUser = function(id) {

  $scope.form_mode = 'update';
  $scope.form_title = "Edit User Information";
 
  $scope.efirst_name = $scope.users[id].first_name.toString();
  $scope.elast_name = $scope.users[id].last_name.toString();
 //alert();
  $scope.ebirthdate = $scope.users[id].birthdate.toString();

  $scope.eteam = $scope.users[id].team_id.toString();
 // console.log($scope.users[id].user_id);
$scope.user_id = $scope.users[id].user_id.toString();
};

$scope.savedata = function(){

  switch($scope.form_mode){
    case 'update':
      $scope.updateData();
    break;
    case 'insert':
      $scope.insertData();
    break;
  }
}

$scope.updateData = function(){

  var user_id = $scope.user_id;
  var efirst_name = $('#efirst_name').val();
  var elast_name = $('#elast_name').val();
  var ebirthdate = $('#ebirthdate').val();
  var eteam = $('#eteam').val();

  $http.post("API/update.php",{
    'user_id': user_id, 
    'first_name': efirst_name,
    'last_name': elast_name,
    'birthdate': ebirthdate,
    'team_id': eteam
    })
    .success(function(data,status,headers,config){
      console.log(data);
    getData();
      //popup here
    });

}
  $scope.insertData=function(){

      $http.post("API/insert.php",{'efirst_name':$scope.efirst_name,'elast_name':$scope.elast_name,'ebirthdate':$scope.ebirthdate,'eteam':$scope.eteam})
        .success(function(data,status,headers,config){
          console.log("nice");
    getData();
        });


  }


});


//   var edit_user_id = $scope.user_id;
//   var edit_first_name = $('#edit_first_name').val();
//   var edit_last_name = $('#edit_last_name').val();
//   var edit_birthdate = $('#edit_birthdate').val();

//   $http.post("API/update.php",{
//     'user_id': edit_user_id, 
//     'first_name': edit_first_name,
//     'last_name': edit_last_name,
//     'birthdate': edit_birthdate
//     })
//     .success(function(data,status,headers,config){
//       console.log(data);
//     getData();
//       //popup here
//     });

// }
  

// $scope.addUser = function() {
//   $scope.form_mode = 'insert';
//   $scope.form_title = "Add User Information";

//   $scope.efromdate = '';
//   $scope.etodate = '';
//   $scope.ename = '';
//   $scope.ealloc = '';
// }

// $scope.editUser = function(id) {

//   $scope.form_mode = 'update';
//   $scope.form_title = "Edit User Information";
 
//   $scope.efromdate = $scope.sched[id].fromdate.toString();
//   $scope.etodate = $scope.sched[id].todate.toString();
//  //alert();
//   $scope.ename = $scope.sched[id].name.toString();
//   $scope.ealloc = $scope.sched[id].allocation.toString();
//  console.log($scope.sched[id].sched_id);
// $scope.sched_id = $scope.sched[id].sched_id.toString();
// };

// $scope.savedata = function(){

//   switch($scope.form_mode){
//     case 'update':
//       $scope.updateData();
//     break;
//     case 'insert':
//       $scope.insertData();
//     break;
//   }
// }

// $scope.updateData = function(){

//   var sched_id = $scope.sched_id;
//   var ename = $('#ename').val();
//   var efromdate = $('#efromdate').val();
//   var etodate = $('#etodate').val();
//   var ealloc = $('#ealloc').val();

//   $http.post("API/update-sched.php",{
//     'sched_id':sched_id, 
//     'name': ename,
//     'fromdate': efromdate,
//     'todate': etodate,
//     'allocation': ealloc
//     })
//     .success(function(data,status,headers,config){
//       console.log(data);
//     getSched();
//       //popup here
//     });

// }
//   $scope.insertData=function(){

//       $http.post("API/insert-sched.php",{'ename':$scope.ename,'efromdate':$scope.efromdate,'etodate':$scope.etodate,'ealloc':$scope.ealloc})
//         .success(function(data,status,headers,config){
//           console.log("nice");
//     getSched();
//         });


//   }
