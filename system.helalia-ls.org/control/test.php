<?php 
	$fields = array(
		'app_id' => "65ddec18-ce30-4e8c-ae11-5bfa7d1979a5",
		'include_player_ids' => array('fd059e11-4a1e-43d7-a572-16aa89097f59'),
		'data' => array("foo" => "bar"),
		'headings' => array("en" => 'HLS'),
		'contents' => array("en" => 'Hello Marwa')
	);
	
	$fields = json_encode($fields);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
										   'Authorization: Basic ODk5YTMwYWUtYjIyNy00MjAwLWFhNTgtZjk4ODFhY2JjZWMx'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	$response = curl_exec($ch);
	curl_close($ch);  
  
	//marwa old   8629163F-55BC-4E77-B4E2-A6977CBCEC9B
	//   69092b56-fd37-4b58-96e7-5cfc3e448d35
	 //    2695C94D-5A1E-4109-88DA-245B64C11214
  ?>