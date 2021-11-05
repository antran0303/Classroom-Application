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
    <title>WELCOMEEEEEE</title>
</head>
<body>
<?php
        $email = $_GET['username'];
        $error = "";
        $classID = "";

        if(isset($_POST['code']) && isset($_GET['username']))
        {
            $classID = $_POST['code'];
            if (empty($classID)) {
                $error = 'Class code invalid';
            }
          
            else
            {
                $result = joinToClass($email, (int)$classID);
                if ($result['code'] == 2 or $result['code'] == 1 or $result['code'] == 3)
                {
                    $error = $result['error'];
                }
                else{
                    header("Location: homestudent.php?username=$email");
                }
                
            }
        }  
    ?>

    <main class="home">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light">
            <span style="font-size:30px;cursor:pointer" onclick="togMenu()">&#9776;</span>
            <a class="navbar-brand mb-0 h1">DOGE CLASSROOM, Hello <?=$email?></a>  
            <span class="fas fa-pencil-alt ml-auto p-2" onclick="togJoin()"></span>
            <a href='Login.php' class="fa fa-sign-out fa-2x p-2"></a>
        </nav>

        <div id="leftMenu" class="sidenav">
            <a href="javascript:void(0)" class="closeMenubtn" onclick="closeNav()">&times;</a>
            <input type="text" id="searchbar" onkeyup="searchclass()" placeholder="Search for class...">
            <ul id="classlist">
            <?php
                $result = getClassForStudent($email);
                while($row = $result->fetch_assoc())
                {

            ?>
                    <li><a href="classstudent.php?id=<?=$row['id']?>&studentEmail=<?=$email?>"><?=$row['classname']?></a></li>
            <?php
                }
            ?>
            </ul>

        </div>
    

        <div id="joining" class="joinsrc">
            <a href="javascript:void(0)" class="closeJoinbtn" onclick="closeJoin()">&times;</a>
            <form action='homestudent.php?username=<?=$email?>' method='POST'>
                <table>
                    <tr>
                        <p style="font-size: larger">Input your Class Code to join</p>
                        <p>Ask your teacher for the class code, then enter it here</p>
                    </tr>
                    <tr>
                        <td>
                            <input name='code' id="classcode" type="text" placeholder="Class Code">
                        </td>
                        <td>
                            <button type="submit" id="joinbtn">Join</button>
                        </td>
                    </tr>
                    <?php
                        if (!empty($error))
                        {
                    ?>
                    <tr>
                        <div style='color:red' class='alert alert-danger'><?=$error?></div>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </form>
        </div>

        

        <div class="card-groups">
            <div class="row">
        <?php
            
            $result = getClassForStudent($email);
            while($row = $result->fetch_assoc())
            {
        ?>
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12">
                    <div class="card border-info">
                        <img class="card-img-top" src="/images/<?php echo $row['imageclass']?>" width="500" height="300" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title"><?=$row['classname']?> - ID: <?=$row['id']?></h4>
                            <p class="card-text"><?=$row['subject'] . ", " . $row['room'] . ", " . $row['emailteacher'] ?></p>
                            <div class="container">
                                <a href="classstudent.php?id=<?=$row['id']?>&studentEmail=<?=$email?>" class="btn btn-dark">GO TO CLASS</a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
            </div>
        </div>

        <footer>
            <p>Doge classroom vjp xi` lip'</p>
        </footer>
    </main>
</body>
</html>