myApp.factory('session', function($cookies,$http) {
    return {
        checkCookies: function(){
			var cookieEnabled=(navigator.cookieEnabled)? true : false
			 
			//if not IE4+ nor NS6+
			if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled){ 
			    document.cookie="testcookie"
			    cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? true : false
			}

			return cookieEnabled;
        },
        checkFileStorage: function(){
			if(window.localStorage) {
			    return true;
			} else {
			    return false;
			}
        },
        put: function(key,value){
			if(this.checkFileStorage()){
				window.localStorage.setItem(key, value);
        	} else if(this.checkCookies()){
        		$cookies.put(key, value);
        	} 
        },
        get: function(key){
        	if(this.checkFileStorage()){
				return window.localStorage.getItem(key);
        	} else if(this.checkCookies()){
        		return $cookies.get(key);
        	}
        }
    };
});