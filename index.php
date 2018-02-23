<html>

<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

</head>


<body>

	<div ng-app='myApp' ng-controller='myController'>

		<modal:form></modal:form>

		<!-- HEADER BUTTONS -->
			<div id='header' class='col-xs-12'>
				<div class='button_container col-md-2 col-xs-12'>
			 		<button class='content_button' ng-click='content_obj.show_search=!content_obj.show_search'>
			 			Toggle Layout
			 		</button>
			 	</div>
			 	<div class='button_container col-md-2 col-xs-12'>
					<button class='content_button' ng-click='content_obj.select_form();content_obj.form_action="Create";content_obj.form_show=true'>
						Create
					</button>
				</div>
			</div>



		<div id='wrapper' class='col-md-9 col-md-push-2 col-xs-12'>
			<!-- NAVIGATION BAR -->
				<div id='navbar' class='col-xs-12'>
					<div class='col-md-9 col-md-push-2 col-xs-12'>
						<a href='#' ng-repeat='nav_elem in navigation' ng-click='set_type(nav_elem);switch_page("0")' class='navbar_button change_content col-md-2 col-md-push-2 col-xs-12'>
							{{ nav_elem }}
						</a>
					</div>
				</div>



			<!-- CENTER CONTENT (DASHBOARD) -->				
				<div id='dashboard' ng-show='content_obj.show_dashboard' class='col-xs-12'>



					<div ng-show='content_obj.show_search' id='search_posts'>
						<div id='info' class='main_container col-md-4 col-xs-12 ' >
						<!-- SEARCH -->
								<div id='search_form' class='col-xs-12'>
									<form ng-submit='send_search()'>
										<input id='search' ng-model='search' type='text' placeholder='Search'>
										<input type='submit' value='Search'>
									</form>
								</div>

								<div id='cart_info' class='col-xs-12'>
									<span id='cart_info_header' class='col-xs-12'>Cart Info</span>
									<span>No Items in Cart</span>
									<!--
									<div ng-repeat='cart_item in cart_items' class='cart_item'>
										<cart:post></cart:post>
									</div>
									-->
								</div>

							</div>

						<!-- POSTS -->
							<div id='shop_body' class='main_container col-md-8 col-xs-12'>
								<div ng-repeat='post in posts' class='post_container col-md-6 col-xs-12'>
									<post></post>
								</div>
							</div>
					</div>



				<!-- ONLY POSTS (NO SEARCH) -->					
					<div ng-show='!content_obj.show_search' id='only_posts'>
						<div class='col-xs-12'>
							<div ng-repeat='post in posts' class='post_container col-md-4 col-xs-12'>
								<post></post>
							</div>
						</div>
					</div>


				<!-- PREV AND NEXT BUTTONS -->
					<div ng-show='content_obj.current_type' id='limit_buttons_container' class='col-xs-12'>
						<div class='col-md-2 col-xs-12'>
							<button ng-show='(content_obj.current_page!=0)' ng-click='switch_page("-")' id='prev' class='limit_button'>Prev</button>
						</div>
						<div class='col-md-2 col-md-push-8 col-xs-12'>
							<button ng-show='(content_obj.current_page<content_obj.last_page)' ng-click='switch_page("+")' id='next' class='limit_button'>Next</button>
						</div>
					</div>



				</div>



			<!-- INDIVIDUAL POST  -->
				<div id='individual_post' ng-show='!content_obj.show_dashboard' class='col-xs-12'>
					<div id='individual_post_img_container' class='col-md-6 col-xs-12'>
						<img src='images/post_images/{{current_post_obj.image}}' id='individual_post_image' class='col-xs-12'>
					</div>
					<div id='individual_post_info_container' class='col-md-6 col-xs-12'>
						<span class='col-xs-12'>{{current_post_obj.name}}</span>
						<span class='col-xs-12'>{{current_post_obj.price}}</span>
						<button class='col-md-2 col-xs-12' ng-click='content_obj.show_dashboard=true'>Go Back</button>
					</div>
				</div>



		</div>


	</div>



	<script type='text/javascript' src='angular/myApp.js'></script>
	<script type='text/javascript' src='angular/myController.js'></script>
	<script type='text/javascript' src='angular/myDirectives.js'></script>

</body>

</html>



