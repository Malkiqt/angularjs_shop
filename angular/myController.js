app.controller('myController',function($scope,$http,$window){
	
	$scope.content_obj = {
		'current_type' : '',
		'current_page' : 0,
		'last_page' : 2,
		'show_search' : false,
		'show_dashboard' : true,
		'form_show' : false,
		'form_action' : '',
	};
	$scope.content_obj.select_post = function(obj){
		$scope.current_post_obj = {};
		for(prop in obj){
			$scope.current_post_obj[prop] = obj[prop];
		}	
		$scope.content_obj.show_dashboard = false;			
	}
	$scope.content_obj.select_form = function(obj){
		$scope.current_form_obj = {};
		if(obj !== undefined){
			for(prop in obj){
				$scope.current_form_obj[prop] = obj[prop];
			}				
		}		
	};

	$scope.navigation = ['men','women','art','book','blog'];

	$scope.current_post_obj = {};
	$scope.current_form_obj = {};

	$scope.posts = [];
	$scope.cart_items = [];




	$scope.create = function(){
		///Take the form info and just send it...
	};

	$scope.update = function(){
		///Take the form info(same as create but + id) and just send it...
	};

	$scope.delete = function(this_id){
		var data = {
			'action' : 'delete' ,
			'id' : this_id
		};
		send_ajax(data,
			function(response){
				alert('Post Deleted');
				$scope.load($scope.content_obj.current_type);
			},
			function(error){
				alert(error);
			}
		);		
	};

	$scope.load = function(post_type,search_string){

		var data = {
			'action' : 'load',
			'limit' : $scope.content_obj.current_page
		};
		if(post_type !== undefined){
			data.type = post_type;
			$scope.content_obj.current_type = post_type;
		}
		if(search_string !== undefined){
			data.search_string = search_string;
			$scope.content_obj.current_type = '';
		}

		send_ajax(data,
			function success(response){
				var stringified_data = JSON.stringify(response.data);
				var result_data = JSON.parse(stringified_data);
				var count = 0;
				$scope.posts = [];

				for(data of result_data){

					$scope.posts.push( {} );

					for(var prop_name in data){
						if(prop_name=='total_rows'){

							$scope.content_obj.last_page = data[prop_name];
							$scope.content_obj.last_page = Math.floor((parseInt($scope.content_obj.last_page))/12);
							$scope.posts.pop();

						}else{

							$scope.posts[count][prop_name] = data[prop_name];

						}
						
					}
					count++;
				}
			},
			function error(error){
				alert(error);
			}
		);
	};

	function send_ajax(data,success_callback,error_callback){
		$http({
			method: 'POST',
			url: 'php/process.php',	
			data: data	
		}).then(function(response){
			success_callback(response);
		},function(error){
			error_callback(error);
		});	
	};



	$scope.switch_page = function(operation){
		if(operation=='+'){
			$scope.content_obj.current_page++;
		}else if(operation=='-'){
			$scope.content_obj.current_page--;
		}else{
			$scope.content_obj.current_page=0;
		}
		
		//$scope.dashboard = true;
		$scope.content_obj.show_dashboard = true;
		$scope.load($scope.content_obj.current_type);
		$window.scrollTo(0, 0);
	};

	$scope.set_type = function(selected_type){
		$scope.content_obj.current_type = selected_type;
	};
/*
	$scope.debug = function(){
		console.log($scope.content_obj.show_dashboard);
		console.log($scope.content_obj.form_action);
	}
*/
});