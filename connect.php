<?php
//ECHO "ONE";
session_start();
    $ID = $_POST['ID'];
   
    $password = $_POST['password'];
    $confirm = $_POST['password2'];
 
    //echo $position;
    //ECHO "TWO";
  
    
    $host = "mylibrary.cn6fzragcwuf.us-west-1.rds.amazonaws.com";
    $dbusername = "root";
    $dbpassword = "Houston16";
    $dbname = "FuelDatabase";
//echo"4";
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname); 
    //echo "5";
    if (mysqli_connect_error())
    {
        echo "It failed";
        die('Connection Failed: '.mysqli_connect_error());
    }
    else{
        echo "connect";
        if($password != $confirm){
            $_SESSION['message'] = "Password did not match, Please try again";
            header("location: error.php");
            exit();
        }
        
       
            
        $SELECT = "SELECT ID FROM Users WHERE ID = ? LIMIT 1";
        $INSERT = "INSERT INTO Users (ID, Password) VALUES (?, ?)";
        //ECHO"CHECK2";        
    
   
        

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
            $stmt->bind_param("is", $ID, $hashPassword);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "You have Successfully Registered, Please Login";
            header("location:register_success.php");
           
        }
        else{

            $_SESSION['message'] = "An Account is Already Associated with this UserID, Please Login";
            header("location: Register_error.php");


            
        }
        



    }
    $conn->close();
   
?>