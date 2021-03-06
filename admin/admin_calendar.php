<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="pending.php">ADMIN</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
   <script type="text/javascript">
  
  $(document).ready(function(){
    $("#search_text").keyup(function(){

      var search=$(this).val();
      $.ajax({
        url:'actionRecord.php',
        method:'POST',
        data:{query:search},
        success:function(response){
          $("#table-data").html(response);
        }
      });


    });
  });
</script>

  <!-- Navbar links -->
   <style type="text/css">
   .active{
    background-color: green;
   }
   li {
  border-right: 2px solid #bbb;
     }
  .navbar {
 
  position: fixed; /* Set the navbar to fixed position */
  top: 0; /* Position the navbar at the top of the page */
  width: 100%; /* Full width */
}
.main {
  margin-top: 60px; /* Add a top margin to avoid content overlay */
}


 </style>
   <div class="collapse navbar-collapse" id="collapsibleNavbar">
     <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="records.php">Records History</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="registerd.php">Reservation Approval</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pending.php">Accepted Request</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../admin/admin_calendar.php">Calendar</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Edit
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
           <a class="dropdown-item" href="package.php">Package</a>
          <a class="dropdown-item" href="imageupload/index.php">Gallery</a>
          <a class="dropdown-item" href="chatapp/chat.php">Chatbox</a>
        </div>
      </li>
      
       <li class="nav-item">
        <a class="nav-link" href="logout.php" onclick="return confirm('do you want to logout?')">Log out</a>
      </li>
    </ul>
  </div>
    <div class="form-inline">
          <label for="search" class="font-weight-bold lead text-dark">Search record</label>&nbsp;&nbsp;&nbsp;
          <input type="text" name="search" id="search_text" class="form-control form-control-lg rounded-0 border-primary" placeholder="search">
            <form method="post">  
        <input type="submit" name="generate_pdf" class="btn btn-success" value="Generate" />  
        </form>  
    </div>
</nav>


</body>
</html>

<?php
function build_calendar($month, $year) {
    include ('../admin/config.php');
    
    $con=new mysqli("localhost","root","","finaltest5");

     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers
     
    $datetoday = date('Y-m-d');
    
    
    
    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</a> ";
    
    $calendar.= " <a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";
    
    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month</a></center><br>";
    
    
        
      $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th  class='header'>$day</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
         for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= "<td  class='empty'></td>"; 

         }
     }
    
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          $date = "$year-$month-$currentDayRel";
          
            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
            if ($dayname=='sunday') {
             $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>N/A</button>";
              }
         elseif($date<date('Y-m-d')){
             $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>N/A</button>";
        }
        // ?ReRrdf/r3e
        else{
            $totalbookings=checkSlot($con,$date);
            if ($totalbookings==27) {
                 $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='#' class='btn btn-danger btn-xs'>ALL BOOKED</a>";
            }else{
                $available=27-$totalbookings;
                  $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='regform.php?Book=".$date."' class='btn btn-success btn-xs'>BOOK</a><small><i>$available slot/s</i></small>";
            }
           
         }
            
            
           
            
          $calendar .="</td>";
          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

     }
     
     

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty'></td>"; 

         }

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     echo $calendar;

}
function checkSlot($con,$date){ 
    $stmt = $con->prepare ("SELECT *  from records where date=?");
    $stmt->bind_param('s', $date);
    $totalbookings=0;
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                 $totalbookings++;
            }
            
        }
    }
    return $totalbookings;
}
    
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
       @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;

            }
            
            

            .empty {
                display: none;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }



            /*
        Label the data
        */
            td:nth-of-type(1):before {
                content: "Sunday";
            }
            td:nth-of-type(2):before {
                content: "Monday";
            }
            td:nth-of-type(3):before {
                content: "Tuesday";
            }
            td:nth-of-type(4):before {
                content: "Wednesday";
            }
            td:nth-of-type(5):before {
                content: "Thursday";
            }
            td:nth-of-type(6):before {
                content: "Friday";
            }
            td:nth-of-type(7):before {
                content: "Saturday";
            }


        }

        /* Smartphones (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        /* iPads (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
        }

        @media (min-width:641px) {
            table {
                table-layout: fixed;
            }
            td {
                width: 33%;
            }
        }
        
        .row{
            margin-top: 20px;
        }
        
        .today{
            background:#5C9C96;
        }
        
        
        
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                     $dateComponents = getdate();
                     if(isset($_GET['month']) && isset($_GET['year'])){
                         $month = $_GET['month'];                
                         $year = $_GET['year'];
                     }else{
                         $month = $dateComponents['mon'];                
                         $year = $dateComponents['year'];
                     }
                    echo build_calendar($month,$year);
                ?>
            </div>
        </div>
    </div>
</body>

</html>

