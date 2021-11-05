<?php
    require_once("connect.php");
    $result = getClassTeacherById($_GET['id']);
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


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <nav class="navbar fixed-top navbar-expand-sm navbar-light">
        
        <a class="navbar-brand mb-0 navname">Hello Mr. <?=$result['firstname']?>, you are editing class <?=$result['classname']?></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
       
    </nav>


    <?php
        if (isset($_POST['classname']) && isset($_POST['subject']) && isset($_POST['room'])
         && isset($_POST['image']))
        {
            $classID = $_GET['id'];
            $className = $_POST['classname'];
            $subject = $_POST['subject'];
            $room = $_POST['room'];
            $image = $_POST['image'];
            $emailTeacher = $result['emailteacher'];

            if (empty($className)) {
                $error = 'Please enter your class name';
            }
            else if (empty($subject)) {
                $error = 'Please enter your subject';
            }
            else if (empty($room)) {
                $error = 'Please enter your room';
            }
            else if (empty($image)) {
                $error = 'Please add your image';
            }
            
            else {
                
                $result = updateClassroom($classID, $className, $room, $subject, $emailTeacher, $image);
                if ($result['code'] == 2)
                {
                    $error = 'An error occured. Please try again later';
                }
                else
                {
                    header("Location:hometeacher.php?username=$emailTeacher"); 
                }
            }
        }
    ?>
    <div class="container">
        <div class="row">
          <div class="col-sm-12 pt-5">
           
          </div>
        </div> 

        <div class="container">
            <div class="row">
                <form action="editClass.php?id=<?=$_GET['id']?>" method="POST">
                    <div class="mb-3">
                        <label>Class name (required)</label>
                        <div class="input-group">
                            <input value="<?=$result['classname']?>" name="classname" type="text" class="form-control" id="classname" required>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label>Subject</label>
                        <div class="input-group">
                            <input value="<?=$result['subject']?>" name="subject" type="text" class="form-control" id="subject">
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label>Room</label>
                        <div class="input-group">
                            <input value="<?=$result['room']?>" name="room" type="text" class="form-control" id="room">
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label>Class image</label>
                        <div class="input-group">
                            <input value="<?=$result['imageclass']?>" name="image" type="file" id="image">
                        </div>
                    </div>
                
                    <hr class="mb-4">
                    <button class="btn-lg btn-block" id="createbtn" type="submit">Save</button>
                    <hr class="mb-4">
                    <a class="btn-lg btn-block" id="backbtn" href="hometeacher.php?username=<?=$result['emailteacher']?>">Back</a>
                    </form>
            </div>
            </div>
          <div class="col-lg-3">
          
          </div>
        </div>     
    </div>


  
</body>
</html>s