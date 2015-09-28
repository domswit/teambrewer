myApp.factory('auth', function($cookies,$http, session) {
    return {
        logout: function() {
        	var logoutYes = confirm("Do you want to logout?");

        	if(logoutYes){
        		session.put('access_token', '');	
        		window.location.href = 'login.html';
        	}
				
			return true;
		},
		checkLogin: function(){
			var access_token = session.get('access_token');

   		    var response = $http.get(
     		 APIURL + "check-auth.php?rand=" + new Date()
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

		    return access_token;
		  }
	
    };
});