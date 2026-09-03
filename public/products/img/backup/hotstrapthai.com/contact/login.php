<?php 
 include("../db_connect.php");
session_start();
 /*echo $_POST['username'];
echo $_POST['password'];
*/
      $_SESSION["username"] = $_POST["username"];
      $_SESSION["password"] = $_POST["password"];

        if(isset($_POST['username'])&&isset($_POST['password']))
        {
                      $sql = "SELECT * FROM admin where  username='".$_SESSION["username"]."' and password='". $_SESSION["password"]."' ";
                      $result = $con->query($sql);
                      if ($result->num_rows > 0){
                        Header("Location: data.php");
                      }else {
                        Header("Location: test2.php");
                      }
                      
          $con->close();    
        }
                     /* if (($_SSESION['username1']==$row["username"]) &&  ($_SESSIONS['password2']==$row["password"])){
                        
                          


              
       
        
?>