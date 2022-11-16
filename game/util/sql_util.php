<?php
	function openConnect() {
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "";
		$db = "game";
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
		
		// Check connection
		if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		};

		if (!(mysqli_query($conn,"set names 'utf8'")))
			echo "Cannot set utf8";

		return $conn;
	}
	
	function execute($sql) {
		$conn = openConnect();
		
		$result = $conn->query($sql);

		
		if (!$result) {
			echo("<p class=\"text-white\"> $sql </p>");
		}
		
		closeConnect($conn);

		return $result;
	}

	function execute2($sql) {
		$conn = openConnect();
		
		$result = $conn->query($sql);
		

		if (!$result) {
			echo("<p class=\"text-white\"> $sql </p>");
		}
		
		return $conn;
	}

	function executeQuery($sql) {
		include ('ketnoi.php');
			// 1. Tao ket noi CSDL
		if (!($connection = mysqli_connect($host,$user,$pass)))
			die ("couldn't connect to localhost");
		if (!(mysqli_select_db($connection,$db)))
			echo "Khong the ket noi 1";
		//2. Thiet lap font Unicode
		if (!(mysqli_query($connection,"set names 'utf8'")))
			echo "Khong the set utf8";
		// Thuc thi cau truy van
		if (!($result = mysqli_query($connection,$sql)))
			echo "Khong the ket noi 3"; 
		// Dong ket noi CSDL
		if (!(mysqli_close($connection)))
			echo "Khong the ket noi 4";
		return $result;
	}

	function toArray($result) {
		$array = array();
		if ($result->num_rows > 0) {
			$index = 0;

			while($row = $result->fetch_assoc()) {
				array_push($array, $row);
			}
		}
		return $array;
	}

	function closeConnect($conn) {
		$conn -> close();
	}
?>