<?php
session_start();
include_once ('process.php');
include_once('registdb.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <script type="text/javascript" language="javascript">
    window.history.forward();
  </script>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width initial-scale=1,shrink-to-fit=no">
	<title>Sample</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#checkAll").click(function(){
      if($(this).is(":checked")){
          $(".checkItem").prop('checked',true);
      }
      else{
        $(".checkItem").prop('checked',false);
      }
    });
  });
</script>
</head>
<body>
  <form action="registdb.php" method="POST">
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="pending.php">ADMIN</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="records.php">Records</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pending.php">Pending</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="registerd.php">Registered</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="logout.php" onclick="return confirm('do you want to logout?')">Log out</a>
      </li>
    </ul>
  </div>
    <div class="form-inline">
          <label for="search" class="font-weight-bold lead text-dark">Search record</label>&nbsp;&nbsp;&nbsp;
          <input type="text" name="search" id="search_text" class="form-control form-control-lg rounded-0 border-primary" placeholder="search">
    </div>
</nav>
   <div class="col-md-15">

    <?php
      
         
      $show="SELECT *FROM registerd";
      $stmt=$con->prepare($show);
      $stmt->execute();
      $result=$stmt->get_result();

    ?>
    <h3 class="text-center text-info">All Records are presented in database</h3>
            <table class="table table-hover" id="table-data">
      <thread>
        <tr>
          <td colspan="9" align="right">
            <input type="submit" name="submit" value="Delete" onclick="return confirm('delete all checked data?')" class="btn btn-danger">
          </td>
        </tr>
        <tr>
          <th><input type="checkbox" id="checkAll"></th>
          <th>ID</th>
          <th>Name</th>
          <th>Address</th>
          <th>School</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Date</th>
          <th>Time</th>
        </tr>
      </thread>
      <tbody>
        
          <?php while($row=$result->fetch_assoc()){?>
      <tr>
        <td><input type="checkbox" class="checkItem" value="<?= $row['id']?>" name="id[]"></td>
        <td><?=$row['id'];?></td>
        <td> <?=$row['name'];?></td>
        <td><?=$row['address'];?></td>
        <td><?=$row['school'];?></td>
        <td><?=$row['email'];?></td>
        <td><?=$row['contact'];?></td>
        <td><?=$row['date'];?></td>
        <td><?=$row['timeslot'];?></td>
        <td>
          

    </td>
      </tr>
   <?php }?>
      </tbody>
      </table>
    </div>
      <script type="text/javascript">
  
  $(document).ready(function(){
    $("#search_text").keyup(function(){

      var search=$(this).val();
      $.ajax({
        url:'registerdAC.php',
        method:'POST',
        data:{query:search},
        success:function(response){
          $("#table-data").html(response);
        }
      });


    });
  });
</script>
</form>
</body>
</html>