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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='main.js'></script>
    <title>STREAM</title>


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

    // Add comment
    if (isset($_POST['comment']) and isset($_GET['feedIDAddCmt']))
    {
      if (!empty($_POST['comment']))
      {
        $result = addComment($_GET['teacherEmail'], $_POST['comment'], $_GET['feedIDAddCmt']);
        if ($result['code'] != 0)
        {
          $error = $result['error'];
        }
        else{
          header("Location: classteacher.php?id=$classID&teacherEmail=$teacherEmail");
        }
      }
      else{
        header("Location: classteacher.php?id=$classID&teacherEmail=$teacherEmail");
      }
    }


    // Xóa feed
    if (isset($_GET['feedID']))
    {
      if (!empty($_GET['feedID']))
      {
        $resultRemove = deleteFeed($_GET['feedID']);
        if ($resultRemove['code'] != 0)
        {
          $error = $resultRemove['error'];
        }
        else
        {
          header("Location: classteacher.php?id=$classID&teacherEmail=$teacherEmail");
        }
      } 
    }

    // Xóa comment
    if (isset($_GET['cmtID']))
    {
      if (!empty($_GET['cmtID']))
      {
        $resultRemoveCmt = deleteComment($_GET['cmtID']);
        if ($resultRemoveCmt['code'] != 0)
        {
          $error = $resultRemoveCmt['error'];
        }
        else
        {
          header("Location: classteacher.php?id=$classID&teacherEmail=$teacherEmail");
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
              <a class="nav-link active" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="classworkteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Classwork</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="peopleTeacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">People</a>
            </li>
        </ul>
        <a href='Login.php' class="fa fa-sign-out p-2"></a>
    </nav>

    <div class="container">
        <div class="row">
          <div class="col-sm-12 pt-5">
            <div class="card navbg bg-primary">
              <h1 class="m-3"><?=$result['lastname'] . ' ' . $result['firstname']?></h1>
              <h4 class="ml-3"><?=$result['subject'] . '_' . $result['room']?></h4>
            </div>
          </div>
        </div> 

        <div class="row">
         
          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Upcoming</h5>
                <p class="card-text">Woohoo, no work due soon!</p>
                <a href="#" class=" ">View all</a>
              </div>
            </div>
            <div class="card">
              <a class="btn btn-primary" href="addFeed.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Thêm bài đăng</a>
            </div>
          </div>

          <?php
            $feeds = getFeedByClassID($_GET['id']);
            $arrayFeedRevert = array();
            if ($feeds['code'] != 0)
            {
              $error = $feeds['error'];
            }
            else
            {
              while ($row = $feeds['result']->fetch_assoc())
              {
                array_unshift($arrayFeedRevert, $row);
              }
            
              if (isset($arrayFeedRevert[0]))
              {
          ?>

          <div class="col-sm-9">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-10">
                    <h5 class="card-title"><?=$result['lastname'] . ' ' . $result['firstname']?></h5>
                  </div>
                  <div class="col-sm-2">
                    <div class="dropdown">
                      <button class="dropbtn">More</button>
                      <div class="dropdown-content">
                        <a href="editFeed.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&feedID=<?=$arrayFeedRevert[0]['id']?>&content=<?=$arrayFeedRevert[0]['content']?>">Edit</a>
                        <a data-toggle="modal" data-target="#confirm-delete">Delete</a>
  
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
                                  Bạn có chắc rằng muốn xóa lớp học không?
                                </div>
                            
                                <div class="modal-footer">
                                    <a class="btn btn-primary btn-sm" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&feedID=<?=$arrayFeedRevert[0]['id']?>">có</a>
                                    <a class="btn btn-primary btn-sm"href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Không</a>
                                </div>            
                              </div>
                          </div>
                      </div>


                  </div>   
                </div>

                <p class="card-text"><?=$arrayFeedRevert[0]['content']?></p>

              <?php
                if (!empty($arrayFeedRevert[0]['file']))
                {

              ?>

                <div class="container filelist">
                  <div class="row">
                    <div class="card">
                      <div class="row no-gutters">
                        <div class="col-sm-9">
                          <h5 class="card-title"><?=$arrayFeedRevert[0]['file']?></h6>
                        </div>
                        <div class="col-sm-2">
                          <button class="btn btn-light">
                            <a download="<?=$arrayFeedRevert[0]['file']?>" data-href="<?=$arrayFeedRevert[0]['file']?>" onclick='forceDownload(this)'><i class="fas fa-download"></i></a>                      
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                
              <?php
                }

              ?>

                <form action="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&feedIDAddCmt=<?=$arrayFeedRevert[0]['id']?>" method='POST'>
                  <div class="row">
                    <div class="col-sm-10">
                      <div class="input-group">
                        <textarea class="form-control cmt" rows="1" name='comment'></textarea>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <button class="btn btn-primary">Post</button>
                    </div>
                  </div>
                </form>
              </div>
        

          
              <?php
                $getCommentUserByFeedID = getCommentUserByFeedID($arrayFeedRevert[0]['id']);
                $arrayCommentRevert = array();
                if ($getCommentUserByFeedID['code'] != 0)
                {
                  $error = $getCommentUserByFeedID['error'];
                }
                else{
                  while ($rowComment = $getCommentUserByFeedID['result']->fetch_assoc())
                  {
                    array_unshift($arrayCommentRevert, $rowComment);
                  }
                  foreach ($arrayCommentRevert as $acr)
                  {

              ?>
                
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-10">
                      <h6><?=$acr['lastname'] . ' ' . $acr['firstname']?><h6>
                    </div>
                    <div class="col-sm-2">
                      <a data-toggle="modal" data-target="#confirm-delete">Delete</a>
                    </div>
                  </div>
                  <p><?=$acr['content']?></p>


                  <div class="modal fade" id="confirm-delete">
                      <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <div class="modal-header">
                              <h4 class="modal-title">Xóa bình luận</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                            Bạn có chắc rằng muốn xóa bình luận không?
                            </div>
                        
                            <div class="modal-footer">
                                <a class="btn btn-primary btn-sm" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&cmtID=<?=$acr['id']?>">có</a>
                                <a class="btn btn-primary btn-sm" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Không</a>
                            </div>            
                          </div>
                      </div>
                </div>
                </div>


                <?php
                    }
                  }
                ?>

              </div>
            </div>
          </div>
          <?php
              }

              array_shift($arrayFeedRevert);
              foreach ($arrayFeedRevert as $afr)
              {
          ?>

            <div class="row">
          
              <div class="col-sm-3">
                
              </div>
    
              <div class="col-sm-9">
                <div class="card">
                  <div class="card-body">
                    

                  <div class="row">
                  <div class="col-sm-10">
                    <h5 class="card-title"><?=$result['lastname'] . ' ' . $result['firstname']?></h5>
                  </div>
                  <div class="col-sm-2">
                    <div class="dropdown">
                      <button class="dropbtn">More</button>
                      <div class="dropdown-content">
                        <a href="editFeed.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&feedID=<?=$afr['id']?>&content=<?=$afr['content']?>">Edit</a>
                        <a data-toggle="modal" data-target="#confirm<?=$afr['id']?>">Delete</a>

                      </div>
                    </div>

                    <div class="modal fade" id="confirm<?=$afr['id']?>">
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
                                              <a class="btn btn-primary btn-sm" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&feedID=<?=$afr['id']?>">có</a>
                                              <a class="btn btn-primary btn-sm"href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Không</a>
                                          </div>            
                                      </div>
                                </div>
                      </div>


                  </div>
                </div>

                  <p class="card-text"><?=$afr['content']?></p>

                  <?php
                    if (!empty($afr['file']))
                    {

                  ?>
                    <div class="container filelist">
                      <div class="row">
                        <div class="card">
                          <div class="row no-gutters">
                            <div class="col-sm-9">
                              <h5 class="card-title"><?=$afr['file']?></h6>
                            </div>
                            <div class="col-sm-2">
                              <button class="btn btn-light">
                                <a download="<?=$afr['file']?>" data-href="<?=$afr['file']?>" onclick='forceDownload(this)'><i class="fas fa-download"></i></a>                      
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                    }

                  ?>

                    <form action="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&feedIDAddCmt=<?=$afr['id']?>" method='POST'>
                      <div class="row">
                        <div class="col-sm-10">
                          <div class="input-group">
                            <textarea class="form-control cmt" rows="1" name='comment'></textarea>
                          </div>

                        </div>
                        <div class="col-sm-2">
                          <button class="btn btn-primary cmtbtn" type="submit">Post</a>
                        </div>
                      </div>
                    </form>
                  </div>

                  <?php
                    $getCommentUserByFeedID = getCommentUserByFeedID($afr['id']);
                    $arrayCommentRevert = array();
                    if ($getCommentUserByFeedID['code'] != 0)
                    {
                      $error = $getCommentUserByFeedID['error'];
                    }
                    else{
                      while ($rowComment = $getCommentUserByFeedID['result']->fetch_assoc())
                      {
                        array_unshift($arrayCommentRevert, $rowComment);
                      }
                      foreach ($arrayCommentRevert as $acr)
                      {

                  ?>
                  
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-10">
                        <h6><?=$acr['lastname'] . ' ' . $acr['firstname']?><h6>
                      </div>
                      <div class="col-sm-2">
                        <a data-toggle="modal" data-target="#confirm<?=$acr['id']?>">Delete</a>
                      </div>
                    </div>
                    <p><?=$acr['content']?></p>

                        <div class="modal fade" id="confirm<?=$acr['id']?>">
                            <div class="modal-dialog">
                              <div class="modal-content">
                              
                                  <div class="modal-header">
                                    <h4 class="modal-title">Xóa bình luận?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>

                                    <div class="modal-body">
                                    Bạn có chắc rằng muốn bình luận không?
                                    </div>
                              
                                  <div class="modal-footer">
                                      <a class="btn btn-primary btn-sm" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>&cmtID=<?=$acr['id']?>">có</a>
                                      <a class="btn btn-primary btn-sm" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Không</a>
                                  </div>            
                                </div>
                            </div>
                      </div>
                  </div>

                  <?php
                      }
                    }
                  ?>
                
                </div>
              </div>
            </div>
            <?php
              }
            }
            ?> 
    

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
                $result = getClassRoom($teacherEmail);
                while($row = $result->fetch_assoc())
                {

            ?>
                    <li><a href="classteacher.php?id=<?=$row['id']?>&teacherEmail=<?=$teacherEmail?>"><?=$row['classname']?></a></li>
            <?php
                }
            ?>
            </ul>
        </div>

  
</body>
</html>