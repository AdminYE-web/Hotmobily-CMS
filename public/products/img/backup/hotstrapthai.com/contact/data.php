<?php 
 include("../db_connect.php");
 session_start();
?> 
<!DOCTYPE html>
<html>
<head>
  
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div>Find From Date</div>
  <form method="POST">
    <input type="date" name="DateStart">
    <input type="date" name="DateEnd">
    <input  class="button button4" type="submit" value="Submit">
    &nbsp;&nbsp;
    <select name="select2">
      <option value="name" >name</option>
      <option value="phone" >phone_number</option>
      <option value="mail" >mail</option>
      <option value="company" >company</option>
      <option value="date" >Date</option>
    </select>
    <input type="text" name="findData">
  <input  class="button button4" type="submit" value="Submit">
  <div class="">
    <table class="table table-hover">
<?php
$timeStart = str_replace('/', '-', $_POST["DateStart"]);
$_SESSION["DateStart"]  = date('Y-m-d',strtotime($timeStart));
$timeEnd = str_replace('/', '-', $_POST["DateEnd"]);
$_SESSION["DateEnd"]  = date('Y-m-d',strtotime($timeEnd));
$_SESSION["findData"] = $_POST["findData"];


                if (isset($_SESSION["DateStart"])&&isset($_SESSION["DateEnd"]) && $_SESSION["DateStart"]!=' ' && $_SESSION["DateEnd"]!=' '&& isset($_SESSION["findData"])&&$_SESSION["findData"]!=' '){
                  $sql = "SELECT * FROM contact WHERE date_create BETWEEN '".$_SESSION["DateStart"]."' AND '".$_SESSION["DateEnd"]."' ORDER BY date_create ASC";
                  $result = $con->query($sql);  
                  
                  if ($result->num_rows > 0) {
                    echo "<tr><th>Date</th><th>Name</th><th>mail</th><th>Phone</th><th>Company</th></tr>";
                            while($row = $result->fetch_assoc())
                            {
                            echo "<tr><td>" .$row["date_create"]."</td><td>". $row["name"]. "</td><td>" . $row["mail"]. "</td><td>" . $row["phone"]."</td><td>".$row["company"]."</td></tr>";  
                            }
                             
                        } 
 
                           else{

                            switch ($_POST["select2"]){
                          case 'name':
                              $sql = "SELECT * FROM contact where  name='".$_SESSION["findData"]."' ";                            
                            break;
                          case 'phone':
                              $sql = "SELECT * FROM contact where  phone LIKE '".$_SESSION["findData"]." ' '0_%'";                  
                            break;
                          case 'mail':
                              $sql = "SELECT * FROM contact where  mail='".$_SESSION["findData"]."'";
                            break;
                          case 'company':
                              $sql = "SELECT * FROM contact where  company='".$_SESSION["findData"]."'";
                            break;
                          case 'date':
                              $sql = "SELECT * FROM contact where  date_create='".$_SESSION["findData"]."'";
                            break;
                        }
                        $result = $con->query($sql);  
                          echo "<tr><th>Date</th><th>Name</th><th>mail</th><th>Phone</th><th>Company</th></tr>";
                            if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()){
                                      echo "<tr><td>" .$row["date_create"]."</td><td>". $row["name"]. "</td><td>" . $row["mail"]. "</td><td>" . $row["phone"]."</td><td>".$row["company"]."</td></tr>";   
                                    }
                            }
                             else{
                                         echo "<tr><td>" ."-"."</td><td>". "-". "</td><td>" . "-". "</td><td>" . "-"."</td><td>"."-"."</td></tr>";
                                   }
                          
                        }
                  }

?>

  </form>
  </table>
</div>
      
 <!--  <div class="container">
    <p>Find From Date</p>
	<form method="POST">
    <input type="date" name="DateStart">
    <input type="date" name="DateEnd">
    <input  class="button button4" type="submit" value="Submit">
    <p>Find from Data</p>
		<select name="select2">
  		<option value="name" >name</option>
  		<option value="phone" >phone_number</option>
  		<option value="mail" >mail</option>
  		<option value="company" >company</option>
  		<option value="date" >Date</option>
		</select>
		<input type="text" name="findData">
	<input  class="button button4" type="submit" value="Submit">
</div>
<br>
<div class="showdata"> -->



</body>
</html>