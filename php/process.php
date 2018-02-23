<?php 
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'angularjs_shop';

	$conn = new mysqli($host,$user,$pass,$db);

	header('Content-Type: application/json');

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);


	$action = $request->action;


	switch($action){

		case 'create':

			$type = $request->type;
			$name = $request->name;

			$search_query = "type='".$type."' AND name='".$name."'";

			$query = "SELECT * FROM items WHERE ".$search_query;

			$result = $conn->query($query);

		
			if($result->num_rows){
				echo json_encode('[{"result" : "0"}]');
			}else{
				$query_keys = '';
				$query_values = '';
				$count = 0;
				$total_count = count((array)$request);
				foreach($request as $request_key => $request_value){
					$count++;
					if($request_key!='action'){
						$query_keys .= $request_key;
						$query_values .= "'".$request_value."'";			
						if($count<$total_count){
							$query_keys .= ',';
							$query_values .= ',';				
						}						
					}
				}

				$query = "INSERT INTO items(".$query_keys.") VALUES(".$query_values.")";					
			
				$result = $conn->query($query);

				echo json_encode('[{"result" : "1"}]');
			}					


			break;

		case 'update':
		
			$id = $request->id;

			$query_set = '';
			$count = 0;
			$total_count = count((array)$request);
			foreach($request as $request_key => $request_value){
				$count++;
				if($request_key!='action' && $request_key!='id'){
					$query_set .= $request_key."='".$request_value."'";		
					if($count<$total_count){
						$query_set .= ',';				
					}						
				}
			}

			$query = "UPDATE items SET ".$query_set." WHERE id='".$id."'";

			$result = $conn->query($query);

			if($result){
				echo json_encode('[{"result" : "1"}]');
			}else{
				echo json_encode('[{"result" : "0"}]');
			}

			break;

		case 'delete':

			$id = $request->id;

			$query = "DELETE FROM items WHERE id='".$id."'";

			$conn->query($query);
			
			break;

		case 'load':
			$type = $request->type;

			$limit_start = ($request->limit)*12;
			$per_page = 12;

			$search_query = "type='".$type."'";

			if(isset($request->search_string)){
				$search_query .=  " AND name LIKE '%".$request->search_string."%'";
			}

			$query = "SELECT * FROM items WHERE ".$search_query." ORDER BY id DESC LIMIT ".$limit_start.",".$per_page;	

			$result = $conn->query($query);

			if($result){
				$result_query = '';
				$rows_count = 0;
				$total_result_rows = $result->num_rows;
				while($result_row = $result->fetch_assoc()){
					$total_property_count = count((array)$result_row);
					$property_count = 0;
					$result_query .= '{';
					foreach($result_row as $result_key => $result_value){
						$result_query .= '"'.$result_key.'" : "'.$result_value.'"';
						$property_count++;
						if($property_count<$total_property_count){
							$result_query .= ',';				
						}
					}
					$result_query .= '}';
					$rows_count++;
					if($rows_count<$total_result_rows){
						$result_query .= ',';
					}						
				}

				$query = "SELECT * FROM items WHERE ".$search_query;	

				$result = $conn->query($query);

				$total_rows = $result->num_rows;

				$result_query .= ',{ "total_rows" : "'.$total_rows.'" }';

				echo "[".$result_query."]";
			}

			
			break;	

	}

?>