<?php
//ECHO "ONE";
;
    $UserID = $_POST['UserID'];
    
    $password = $_POST['password'];

    $host = "mylibrary.cn6fzragcwuf.us-west-1.rds.amazonaws.com";
    $dbusername = "root";
    $dbpassword = "Houston16";
    $dbname = "librarydatabase";
//echo"4";
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname); 
    //echo "5";
    if (mysqli_connect_error())
    {
        echo "It failed";
        die('Connection Failed: '.mysqli_connect_error());
    }
	  if($password != $confirm){
            $_SESSION['message'] = "Password did not match, Please try again";
            header("location: error.php");
            exit();
        }
		
	    $SELECT = "SELECT UserID FROM Users WHERE ID = ? LIMIT 1";
        $INSERT = "INSERT INTO Users (ID, Password) VALUES (?, ?)";
		
		   //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $stmt->bind_result($ID);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum == 0){
      

                $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("i", $ID);
            $stmt->execute();
            $stmt->close();
            $_SESSION['message'] = "You have Successfully Registered, Please Login";
            header("location:register_success.php");
           
        }
        else{

            $_SESSION['message'] = "An Account is Already Associated with this UserID, Please Login";
            header("location: Register_error.php");
     
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
  <form action = "register.php" method = "POST" id="register" class="input-group">
                <h4>Please fill out section below to register</h4>
                <input type= "text"   name = "UserID" class="input-field" placeholder="UserID" required> <!-- Create a user Id  required-->
                
                <input type= "password"  name = "password" class="input-field" placeholder="Enter Password" required> <!-- Create a user pass  required-->
                
                <input type= "password" name = "password2" class="input-field" placeholder="Confirm Password" required>
              
                <input type="submit" class = "submit-btn" value = "Register">
            </form>
</body>
</html>