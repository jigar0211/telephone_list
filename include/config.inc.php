<?php	
		error_reporting(E_ALL); // Debugging
		error_reporting(E_ERROR);

		$servername="localhost";
		$username="root";
		$password="";
		$dbname = "ticketing1";
		$conn= new mysqli($servername,$username,$password,$dbname);
		
        // if($conn){
        //     echo "connected";
        // }
        // else{
        //     echo "Error";
        // }
		//echo '<pre>'; print_r($_SERVER); echo '</pre>'; exit;

?>