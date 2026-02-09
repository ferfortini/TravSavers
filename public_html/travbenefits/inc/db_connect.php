<?


session_start();

$con = mysqli_connect("localhost", "travnow_CHRISTN", "Trav404!", "travnow_TRAVNEW");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  } 
  
  ?>