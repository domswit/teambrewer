myApp.factory('auth', function($cookies,$http) {
    return {
        logout: function() {
        	var logoutYes = confirm("Do you want to logout?");

        	if(logoutYes){
        		$cookies.put('access_token', '');	
        		window.location.href = 'login.html';
        	}
				
			return true;
		},
		checkLogin: function(){
			var access_token = $cookies.get('access_token');

   		    var response = $http.get(
     		 "API/check-auth.php?rand=" + new Date()
		      .getTime() + "&access_token=" + access_token);
		    response.success(function(data, status, headers, config) {
		    	if (!data.success){
		    		alert("User not logged in")
		    		window.location.href = 'login.html';
		    	}
		    });
		    response.error(function(data, status, headers, config) {
		      alert("AJAX failed!");
		    });
		    return true;
		  }
	
    };
});