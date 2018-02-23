
app.directive('modalForm',function(){
	return{
		restrict : 'E',
		scope: false,
	    templateUrl: './directives//modal_form.html',
		link: function (scope, el) {
			el.on('click', function (e) {
				var modal_content = document.querySelector('#modal_content');
				if( (modal_content !== e.target) && (!modal_content.contains(e.target)) ){	
					scope.$apply(function(){
						scope.content_obj.form_show = false;
					});
				}
			});
		}
	}
});



app.directive('post',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/post.html',
	    link: function(scope,el){
	    	el.on('click',function(e){
	    		var update_button = el[0].querySelector('.update_button');

	    		if( (update_button === e.target)  ){
					scope.$apply(function(){
						scope.content_obj.form_show = true;
						scope.content_obj.form_action = "Update";
						scope.content_obj.select_form(scope.post);
						///use $parent because we call post directive in an ng-repeat directive....
						///sooo we are in the ng-repeat child scope right now
						///when we call $parent we go to the controller parent scope and update the variables there
						///I think we can achieve the same thing using objects and their properties		
					});
	    		}else{
					scope.$apply(function(){
		    			scope.content_obj.show_dashboard = false;
		    			scope.content_obj.select_post(scope.post);
						///scope.post is the post in the ng-repeat child scope..
						///select post is a function from the controller
						//scope.$parent.select_post(scope.post);
					}); 

	    		}
	    	})
	    }
	}
});



app.directive('stringToNumber', function() {
	return {
		require: 'ngModel',
		link: function(scope, element, attrs, ngModel) {
			ngModel.$parsers.push(function(value) {
				return '' + value;
			});
			ngModel.$formatters.push(function(value) {
				return parseFloat(value);
			});
		}	
	};
});

/*
app.directive('post',function(){
	return{
		restrict : 'E',
	    scope: false,
	    templateUrl: './directives/post.html'
	}
});*/