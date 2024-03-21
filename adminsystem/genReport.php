<?php

//action.php

$connect = new PDO("mysql:host=localhost;dbname=barangay_incident", "root", "");

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('id', 'submitted_total', 'submitted_date');

		$main_query = "
		SELECT id, SUM(submitted_total) AS incident_total, submitted_date 
		FROM incident_reports
		";

		$search_query = 'WHERE 
		submitted_date IS NOT NULL AND ';


		if(isset($_POST["type"]) && $_POST["type"] !=='All Incident' )
		{
			$search_query .= 'calamities_incident = "'.$_POST["type"].'" AND ';
		}



		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= 'submitted_date >= "'.$_POST["start_date"].'" AND submitted_date <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= '(id LIKE "%'.$_POST["search"]["value"].'%" OR submitted_total LIKE "%'.$_POST["search"]["value"].'%" OR submitted_date LIKE "%'.$_POST["search"]["value"].'%")';
		}



		$group_by_query = " GROUP BY submitted_date ";

		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY submitted_date ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}




		$statement = $connect->prepare($main_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $connect->prepare($main_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $connect->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			// $sub_array[] = $row['id'];

			$sub_array[] = $row['incident_total'];

			$sub_array[] = $row['submitted_date'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}
}

?>