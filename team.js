angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
$scope.teams = '';

$scope.updateData = {}

//$scope.first_name2 = "test";

function getData(){

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



$scope.edit = true;
$scope.error = false;
$scope.incomplete = false; 

$scope.editTeam = function(id) {
  
  console.log(id);
  console.log($scope.teams[id]);
  console.log($scope.teams[id].team_id);
  console.log($scope.teams[id].team_name);

 $scope.team_id = $scope.teams[id].team_id.toString();
 $scope.team_name = $scope.teams[id].team_name.toString();

};

$scope.updateData = function(){

  var edit_team_id = $scope.team_id;
  var edit_team_name = $('#edit_team_name').val();

  $http.post("API/update-team.php",{
    'team_id': edit_team_id, 
    'team_name': edit_team_name,
    })
    .success(function(data,status,headers,config){
      console.log(data);
      getData();

      //popup here
    });
}
$scope.insertdata=function(){

    $http.post("API/insert-team.php",{'eteam_name':$scope.eteam_name})
      .success(function(data,status,headers,config){
        console.log(data);
        getData();

    });

     
  }


});