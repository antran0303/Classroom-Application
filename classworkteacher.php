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
    $error = null;
    $classID = $_GET['id'];
    $teacherEmail = $_GET['teacherEmail'];

    // Xóa feed
    if (isset($_GET['classworkID']))
    {
      if (!empty($_GET['classworkID']))
      {
        $resultRemove = deleteClasswork($_GET['classworkID']);
        if ($resultRemove['code'] != 0)
        {
          $error = $resultRemove['error'];
        }
        else
        {
          header("Location: classworkteacher.php?id=$classID&teacherEmail=$teacherEmail");
        }
      }
    }
  ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <nav class="navbar fixed-top navbar-expand-sm navbar-light">
        <span onclick="togMenu()">&#9776;</span>
        <a class="navbar-brand mb-0 navname" href="hometeacher.php?username=<?=$_GET['teacherEmail']?>">Trang chủ</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <ul class="nav navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="classworkteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Classwork</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="peopleTeacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">People</a>
        </li>
        </ul>
        <a href='Login.php' class="fa fa-sign-out p-2"></a>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-sm-12 pt-5 ">
              <div class="card bg-primary navbg">
                  <h1 class="m-3"><?=$result['subject'] . '_' . $result['room']?></h4>
                  <h4 class="ml-3"><?=$result['lastname'] . ' ' . $result['firstname']?></h1>
              </div>
        </div> 
      </div>
      

        <div class="row">
         
          <div class="col-sm-3 pt-5">
            <div class="card border-dark">
              <a class="btn btn-primary" href="addClasswork.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Thêm bài tập</a>
            </div>
          </div>

          <?php
            $classworks = getAllClasswork($_GET['id']);
            $arrayClassworkRevert = array();
            if ($classworks['code'] != 0)
            {
              $error = $classworks['error'];
            }
            else
            {
              while ($row = $classworks['result']->fetch_assoc())
              {
                array_unshift($arrayClassworkRevert, $row);
              }
            
              if (isset($arrayClassworkRevert[0]))
              {
          ?>

          <div class="col-sm-9 pt-5">
            <div class="card border-dark">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-10">
                    <h5 class="card-title" style="color:#1967D2"><?=$arrayClassworkRevert[0]['title']?></h5>

                  </div>
                  <div class="col-sm-2">
                    <div class="dropdown">
                      <button class="dropbtn">More</button>
                      <div class="dropdown-content">
                        <a href="editClasswork.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&classworkID=<?=$arrayClassworkRevert[0]['id']?>">Edit</a>
                        <a data-toggle="modal" data-target="#confirm-delete">Delete</a>
                        
                      </div>
                    </div>
                  </div>
                </div>
                <p class="card-text"><?=$arrayClassworkRevert[0]['content']?></p>
              
              
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="confirm-delete">
              <div class="modal-dialog">
                <div class="modal-content">
                
                    <div class="modal-header">
                      <h4 class="modal-title">Xóa bài đăng</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                    Bạn có chắc rằng muốn xóa bài đăng này không?
                    </div>
                
                    <div class="modal-footer">
                        <a class="btn btn-primary btn-sm" href="classworkteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&classworkID=<?=$arrayClassworkRevert[0]['id']?>">có</a>
                        <a class="btn btn-primary btn-sm" href="classworkteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Không</a>
                    </div>            
                  </div>
              </div>
        </div>

        

        <?php
          }
          array_shift($arrayClassworkRevert);
          foreach ($arrayClassworkRevert as $acr)
          {
        ?>

        <div class="row">
        
          <div class="col-sm-3">
            <div>
            </div>
          </div>

          <div class="col-sm-9 pt-5">
            <div class="card border-dark">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-10">
                    <h5 class="card-title" style="color:#1967D2"><?=$acr['title']?></h5>

                  </div>
                  <div class="col-sm-2">
                    <div class="dropdown">
                      <button class="dropbtn">More</button>
                      <div class="dropdown-content">
                        <a href="editClasswork.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&classworkID=<?=$acr['id']?>">Edit</a>
                        <a data-toggle="modal" data-target="#confirm<?=$acr['id']?>">Delete</a>
                        
                      </div>
                    </div>
                  </div>
                </div>
                <p class="card-text"><?=$acr['content']?></p>
              </div>
            </div>
          </div>
        </div>


        <div class="modal fade" id="confirm<?=$acr['id']?>">
              <div class="modal-dialog">
                <div class="modal-content">
                
                    <div class="modal-header">
                      <h4 class="modal-title">Xóa bài đăng</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                    Bạn có chắc rằng muốn xóa bài đăng không?
                    </div>
                
                    <div class="modal-footer">
                        <a class="btn btn-primary btn-sm" href="classworkteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&classworkID=<?=$acr['id']?>">có</a>
                        <a class="btn btn-primary btn-sm" href="classworkteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Không</a>
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
        $result = getClassRoom($_GET['teacherEmail']);
        while($row = $result->fetch_assoc())
        {
      ?>

        <li><a href="classteacher.php?id=<?=$row['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>"><?=$row['classname']?></a></li>
      
      <?php
        }
      ?>

      </ul>
    </div>

  
</body>
</html>