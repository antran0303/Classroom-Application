<?php
    session_start();
    require_once('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src='main.js'></script>
    <title>STREAM</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
  <?php
    $result = getClassTeacherById($_GET['id']);
  ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <nav class="navbar fixed-top navbar-expand-sm navbar-light">
      <span onclick="togMenu()">&#9776;</span>
      <a class="navbar-brand mb-0 navname" href="homestudent.php?username=<?=$_GET['studentEmail']?>">Trang chủ</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      
      <ul class="nav navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="classstudent.php?id=<?=$_GET['id']?>&studentEmail=<?=$_GET['studentEmail']?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="classworkstudent.php?id=<?=$_GET['id']?>&studentEmail=<?=$_GET['studentEmail']?>">Classwork</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="peopleStudent.php?id=<?=$_GET['id']?>&studentEmail=<?=$_GET['studentEmail']?>">People</a>
        </li>
      </ul>
      <a href='Login.php' class="fa fa-sign-out p-2"></a>
    </nav>

    <div class="container">
      <div class="row ">
        <div class="col-sm-12 pt-5">
          <div class="card classbg bg-primary bgStydent">
              <h1 class="fontStudent"><?=$result['subject'] . '_' . $result['room']?></h4>
              <h4 class="fontStudent"><?=$result['lastname'] . ' ' . $result['firstname']?></h1>
          </div>
        </div>
      </div> 
      
      <div class="row">
        <div class="col-sm-9 pt-5">
          <div class="">
            <div class="card-body border-dark">
              <h1 class="card-title" style="color:#1967D2;">Tutorials</h1>
              <div style="text-decoration: underline;"></div>
            </div>
          </div>
        </div>
      </div>

      
      <?php
        $resultGetClasswork = getAllClasswork($_GET['id']);
        //Xét trường hợp không có classWork
        if ($resultGetClasswork['code'] != 0)
        {
      ?>

        <div class="row">
         <div class="col-sm-9 pt-5">
           <div class="card border-dark">
             <div class="card-body">
               <h5 class="card-title" style="color:#1967D2">No exercise!</h5>
             </div>
           </div>
         </div>
       </div>

      <?php
        }

        // Trường hợp có nhiều hơn 1 classwork
        else
        {
          while($row = $resultGetClasswork['result']->fetch_assoc())
          {
      ?>
        <div class="row">
         
          <div class="col-sm-3 pt-5">
          </div>

          <div class="col-sm-9 pt-5">
            <div class="card border-dark">
              <div class="card-body">
                <h5 class="card-title" style="color:#1967D2"><?=$row['title']?></h5>
                <p class="card-text"><?=$row['content']?></p>
              </div>
            </div>
          </div>
        </div>

      <?php
          }
        }
      ?>

    </div>

    <div class="tab-content" style="height: 100%;">
      <div id="homesrc" class="container tab-pane active"><br>
      </div>
      <div id="classworksrc" class="container tab-pane fade"><br>
      </div>
      <div id="peoplesrc" class="container tab-pane fade"><br>
      </div>
    </div>

    <div id="leftMenu" class="sidenav">
      <a href="javascript:void(0)" class="closeMenubtn" onclick="closeNav()">&times;</a>
      <input type="text" id="searchbar" onkeyup="searchclass()" placeholder="Search for class...">
      <ul id="classlist">
      <?php
        $result = getClassForStudent($_GET['studentEmail']);
        while($row = $result->fetch_assoc())
        {
      ?>

        <li><a href="classstudent.php?id=<?=$row['id']?>&studentEmail=<?=$_GET['studentEmail']?>"><?=$row['classname']?></a></li>
      
      <?php
        }
      ?>

      </ul>
    </div>
  
</body>
</html>