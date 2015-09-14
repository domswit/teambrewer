myApp.factory('pagination', function($cookies){

	var currentPage = 1;
	var maxPage = null;
	

	return {
		setCurrentPage: function(page){
			currentPage = page;
		},
		getFirst: function(){
			return 1;
		},
		getPrevious: function(){
			var newpage = currentPage * 1 - 1;
			 	if (newpage < 1){
			 		newpage = 1;
			 	}
			 	return newpage;
		},
		getNext: function(){
			var newpage = currentPage * 1 + 1;
			 	if (newpage > maxPage){
			 		newpage = maxPage;
			 	}
			 	return newpage;
		},
		getLast: function(){
			return maxPage;
		},
		setMaxPage: function(num){
			maxPage = num;
		},
		
	}
});