<?php

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    // Load Composer's autoloader
    require 'vendor/autoload.php';


    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', '');
    define('DB', 'account_manager');
    
    function connection()
    {
        $conn = new mysqli(HOST, USER, PASS,DB);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    

    function login($username, $password)
    {
        $sql = "select * from account where email = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$username);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();

        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'user does not exists');

        }

        $data = $result->fetch_assoc();

        $hashed_pass = $data['password'];

        if(!password_verify($password, $hashed_pass))
        {
            return array('code' => 3,'error'=>'Invalid password' );

        }
        else if($data['activate'] == 0)
        {
            return array('code' => 4,'error'=>'The account is not activated' );

        }
        else
        {
            return array('code' => 0,'error'=>'','data'=> $data );

        }

    }
    function email_exists($email)
    {
        $sql = "select *from account where email = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if(!$stm->execute())
        {
            die('Query error:' . $stm->error);
        }

        $result = $stm->get_result();
        if($result->num_rows > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    function register($email,$pass, $first, $last, $role)
    {
        if ($role === "1")
        {
            $role = 1;
        }
        else
        {
            $role = 0;
        }
        if(email_exists($email))
        {
            return array('code' => 1,'error' => 'Email exists');
            
        }
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $rand = random_int(0, 1000);
        $token = md5($email .'+'. $rand);
        $sql = 'insert into account(firstname, lastname, email, password, activate_token, isGV) values(?,?,?,?,?,?)';

        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssi',$first,$last,$email,$hash,$token,$role);

        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }

        sendActivationEmail($email,$token);
        //send verification emailemail
        return array('code' => 0, 'error' => 'create account successful');

    }

    function sendActivationEmail($email, $token)
    {

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();      
            $mail->charSet = 'UTF-8';                                        // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'antranttl0303@gmail.com';                     // SMTP username
            $mail->Password   = 'kyxosocyovxowyfr';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('antranttl0303@gmai.com', 'Admin');
            $mail->addAddress($email, 'Ng?????i nh???n');     // Add a recipient
            /*$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Verify your email';
            $mail->Body    = "Click <a href='http://localhost/activate.php?email=$email&token=$token'>here</a> to verify your email";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    
    function sendResetPassword($email, $token)
    {

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP(); 
            $mail->charSet = 'UTF-8';                                           // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'antranttl0303@gmail.com';                     // SMTP username
            $mail->Password   = 'kyxosocyovxowyfr';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('antranttl0303@gmai.com', 'Admin');
            $mail->addAddress($email, 'Ng?????i nh???n');     // Add a recipient
            /*$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Reset your password';
            $mail->Body    = "Click <a href='http://localhost/reset_password.php?email=$email&token=$token'>here</a> to restore your password";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function activeAccount($email, $token)
    {
        $sql = 'select *from account where email = ? and activate_token = ? and activate = 0';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$email,$token);

        if(!$stm->execute())
        {
            return array('code'=> 1,'error'=>'Can not execute command');
        }

        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code'=> 2,'error' => 'Email address or token can not found');
        }

        $sql = "update account set activate = 1,activate_token='' where email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$email);
        if(!$stm->execute())
        {
            return array('code'=>1,'error'=>'Can not execute command');
        }


        return array('code'=> 0,'message' => 'Account activated');
    }

    function reset_password($email)
    {
        if(!email_exists($email))
        {
            return array('code'=> 1, 'error'=> 'Email does not exists');
        }

        $token = md5($email .'+'. random_int(1000,2000));
        $sql = 'update reset_token set token = ? where email = ?';

        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$token,$email);

        if(!$stm->execute())
        {
            return array('code'=> 2, 'error'=> 'Can not execute command');
        }

        if($stm->affected_rows == 0)
        {
            //ch??a c?? dong n??o cuar email n??y, m??nh s??? th??m v??o d??ng m???i.
            $exp = time() + 3600 * 24; //h???t h???n sau 24h 

            $sql = 'insert into reset_token values(?,?,?)';
            $stm = $conn->prepare($sql);
            $stm->bind_param('ssi',$email,$token,$exp);

            if(!$stm->execute())
            {
                return array('code'=> 1, 'error'=> 'Can not execute command');
            }
        }

        //ch??n th??nh c??ng or update th??nh c??ng token c???a d??ng ???? c??
        // gi??? g???i mail t???i user.
        $success = sendResetPassword($email,$token);

        return array('code'=>0,'success'=> $success);
    }


    function update_password($email,$pass)
    {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        //$rand = random_int(0, 1000);
        //$token = md5($email .'+'. $rand);
        $sql = ' update account set password = ? where email = ?';

        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$hash,$email);

        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'create account successful');

    }


    function addClassRoom($className, $room, $subject, $emailTeacher, $image)
    {
        $sql = 'insert into classroom(classname, room, subject, emailteacher, imageclass) values(?,?,?,?,?)';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssss',$className, $room, $subject, $emailTeacher, $image);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'create class room successful');
    }

    function deleteClassRoom($id)
    {
        //Delete all comment in class
        $sql = 'DELETE FROM comment where feedID in (Select id from feed where classID = ?)';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }


        //Delete all feed in class
        $sql = 'DELETE FROM feed where classID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }

        //Delete all student in class
        $sql = 'DELETE FROM studentofclass where classID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }

        //Delete classwork in class
        $sql = 'delete from classwork where classID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        

        //Delete class
        $sql = 'DELETE FROM classroom where id = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'delete class room successful');
    }

    function updateClassroom($id, $className, $room, $subject, $emailTeacher, $image)
    {
        $sql = 'update classroom set classname = ?, room = ?, subject = ?, emailteacher = ?, imageclass = ? where id = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssss',$className, $room, $subject, $emailTeacher, $image, $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'update class room successful');
    }
    
    function getClassRoom($emailTeacher)
    {
        $sql = "select * from classroom where emailteacher = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $emailTeacher);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        
        return $result;
    }

    function checkGV($email)
    {
        $sql = "select * from account where email = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        $data = $result->fetch_assoc();
        if ($data['isGV'] == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function getClassForStudent($emailStudent)
    {
        $sql = "select * from studentofclass, classroom where studentofclass.classID = classroom.id and studentofclass.studentemail = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $emailStudent);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        
        return $result;
    }

    function joinToClass($emailStudent, $classID)
    {
        //Check whether the student in class
        $sql = 'select * from studentofclass where studentemail = ? and classID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $emailStudent, $classID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows != 0)
        {
            return array('code' => 2,'error'=>'You was already in class');
        }

        $sql = "select * from classroom where id = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $classID);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'Class ID isn\'t valid');
        }
        

        $sql = 'insert into studentofclass(studentemail, classID) values(?,?)';
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('si', $emailStudent, $classID);
        if(!$stm->execute())
        {
            return array('code' => 3,'error'=>'cannot execute command');
        }
        else {
            return array('code' => 0,'error'=> 'Insert successfully');
        }
    }

    function getClassTeacherById($classID)
    {
        $sql = "SELECT * FROM classroom, account WHERE emailteacher = email and id = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $classID);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'Class ID isn\'t valid');
        }
        $data = $result->fetch_assoc();
        return $data;
    }

    function getFeedByClassID($classID)
    {
        $sql = "SELECT * FROM feed WHERE classID = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $classID);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'Class ID isn\'t valid');
        }
        return array('code' => 0, 'result' => $result);
    }

    function addFeed($content, $classID, $file)
    {
        $sql = 'insert into feed(content, classID, file) values(?,?,?)';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss', $content, $classID, $file);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'create feed successful');   
    }

    function updateFeed($id, $content, $file)
    {
        $sql = 'update feed set content = ?, file = ? where id = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss', $content, $file, $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'update feed successful');
    }

    function deleteFeed($id)
    {
        // Delete all comment in feed
        $sql = 'delete from comment where feedID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }

        // Delete feed
        $sql = 'delete from feed where id = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'delete feed successful');
    }

    

    function addStudent($email, $classID)
    {
        //Check student in database
        $sql = 'select * from account where email = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'Student email is invalid');
        }

        //Check isGV
        $sql = 'select * from account where email = ? and isGV = 0';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'You can not add teacher to your class');
        }



        //Check whether the student in class
        $sql = 'select * from studentofclass where studentemail = ? and classID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $email, $classID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows != 0)
        {
            return array('code' => 2,'error'=>'Student was already in class');
        }
        


        $sql = 'insert into studentofclass(studentemail, classID) values(?,?)';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $email, $classID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'Student was added successfully');
    }

    function deleteStudent($email, $classID)
    {
        // Delete cmt of student
        $sql = 'DELETE FROM comment where emailuser = ? AND feedID in (Select id from feed where classID = ?)';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $email, $classID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }


        // Delete student in class
        $sql = 'delete from studentofclass where studentemail = ? and classID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $email, $classID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'Student was deleted successfully');
    }

    function findStudentByClassID($classID)
    {
        $sql = 'select * from studentofclass where classID = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $classID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'No student was in class');
        }
        return array('code' => 0, 'result'=> $result);
    }


    function getAllTeacher()
    {
        $sql = 'select * from account where isGV = 1';
        $conn = connection();
        $stm = $conn->prepare($sql);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'No teacher was in database');
        }
        return array('code' => 0, 'result'=> $result);
    }

    function updateRole($email, $isAdmin)
    {
        $sql = 'update account set isAdmin = ? where email = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('is', $isAdmin, $email);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'update role successful');
    }

    function addComment($emailUser, $content, $feedID)
    {
        $sql = 'insert into comment(emailuser, content, feedID) values(?, ?, ?)';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss', $emailUser, $content, $feedID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'Student was added successfully');
    }

    function deleteComment($id)
    {
        $sql = 'delete from comment where id = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'delete comment successful');
    }

    function getCommentUserByFeedID($feedID)
    {
        $sql = "SELECT * FROM comment, account WHERE feedID = ? and emailuser = email";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $feedID);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'Class ID isn\'t valid');
        }
        
        return array('code' => 0, 'result' => $result);
    }

    function addClasswork($title, $content, $classID)
    {
        $sql = 'insert into classwork(title, content, classID) values(?, ?, ?)';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss', $title, $content, $classID);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'Classwork was added successfully');
    }

    function updateClasswork($id, $title, $content)
    {
        $sql = 'update classwork set title = ?, content = ? where id = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss', $title, $content, $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'update classwork successful');
    }

    function deleteClasswork($id)
    {
        $sql = 'delete from classwork where id = ?';
        $conn = connection();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 2, 'error' => 'execute failed: '. $stm->error);
        }
        return array('code' => 0, 'error' => 'delete classwork successful');
    }

    function getAllClasswork($id)
    {
        $sql = "SELECT * FROM classwork WHERE classID = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'No classwork');
        }
        
        return array('code' => 0, 'result' => $result);
    }

    function getClasswork($id)
    {
        $sql = "SELECT * FROM classwork WHERE id = ?";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();
        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'No classwork');
        }
        $data = $result->fetch_assoc();
        return array('code' => 0, 'data' => $data);
    }

    function loginAdmin($user, $pass)
    {
        $sql = "select * from account where email = ? and isAdmin = 1";
        $conn = connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if(!$stm->execute())
        {
            return array('code' => 1,'error'=>'cannot execute command');
        }

        $result = $stm->get_result();

        if($result->num_rows == 0)
        {
            return array('code' => 2,'error'=>'user does not exists');

        }

        $data = $result->fetch_assoc();

        $hashed_pass = $data['password'];

        if(!password_verify($pass, $hashed_pass))
        {
            return array('code' => 3,'error'=>'Invalid password' );

        }
        else if($data['activate'] == 0)
        {
            return array('code' => 4,'error'=>'The account is not activated' );

        }
        else
        {
            return array('code' => 0,'error'=>'','data'=> $data );

        }
    }
?>