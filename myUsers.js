angular.module('myApp', []).controller('userCtrl', function($scope, $http) {
$scope.fName = '';
$scope.lName = '';
$scope.passw1 = '';
$scope.passw2 = '';

$scope.updateData = {}

$scope.first_name2 = "test";
// $scope.users = [
// {id:1, fName:'Hege',  lName:"Pege", email:"hegepege@email.com"},
// {id:2, fName:'Kim',   lName:"Pim", email:"kimpim@email.com"},
// {id:3, fName:'Sal',   lName:"Smith", email:"salsmith@email.com"},
// {id:4, fName:'Jack',  lName:"Jones", email:"jonesjack@email.com"},
// {id:5, fName:'John',  lName:"Doe", email:"doejohn@email.com"},
// {id:6, fName:'Peter', lName:"Pan", email:"peterpan@email.com"}];

/*$scope.userstest = {
  '1': {fName: 'Hege', lName:"Pege", bdate:"12/11/96", email:"hegepege@email.com"},
  '2': {fName: 'Kim', lName:"Pim", bdate:"4/30/96", email:"kimpim@email.com"},
  '3': {fName:'Sal',   lName:"Smith", bdate:"5/21/92", email:"salsmith@email.com"},
  '4': {fName:'Jack',  lName:"Jones", bdate:"2/2/92", email:"jonesjack@email.com"},
  '5': {fName:'John',  lName:"Doe", bdate:"1/1/90", email:"doejohn@email.com"},
  '6': {fName:'Peter', lName:"Pan", bdate:"6/8/89", email:"peterpan@email.com"},
}; */



function getData(){

  var response = $http.get("http://localhost/trial/API/user-list.php");

  response.success(function(data, status, headers, config) {
      console.log(data.users);
      //console.log($scope.userstest);
      $scope.users = data.users;
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

  //$scope.fName = "hi";
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
      //popup here
    });

    getData();
}
  $scope.insertdata=function(){

      $http.post("API/insert.php",{'efirst_name':$scope.efirst_name,'elast_name':$scope.elast_name,'ebirthdate':$scope.ebirthdate})
        .success(function(data,status,headers,config){
          console.log("nice");
        });

      getData();

  }

$scope.$watch('passw1',function() {$scope.test();});
$scope.$watch('passw2',function() {$scope.test();});
$scope.$watch('fName', function() {$scope.test();});
$scope.$watch('lName', function() {$scope.test();});

$scope.test = function() {
  if ($scope.passw1 !== $scope.passw2) {
    $scope.error = true;
    } else {
    $scope.error = false;
  }
  $scope.incomplete = false;
  if ($scope.edit && (!$scope.fName.length ||
  !$scope.lName.length ||
  !$scope.passw1.length || !$scope.passw2.length)) {
       $scope.incomplete = true;
  }
};

});