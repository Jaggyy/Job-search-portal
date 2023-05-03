<?php
if(isset($_POST['submit']))
{
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var(htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    if($email == null || $password == null) 
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    else
    {
        $sql = "SELECT * FROM candidates WHERE email = :email";
        $result = $conn->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        $row = $result->fetch();
        $hash_password = $row['password'];
        $dehash = password_verify($password, $hash_password);
        if ($dehash == 0) 
        {
            $error = array('error' => 'Email and Password Combination Incorrect.');
            echo json_encode($error);
            exit;
        }
        elseif(empty($error)) 
        {
            $sql = "SELECT * FROM candidates WHERE email = :email  AND password = :password";
            $result = $conn->prepare($sql);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->bindParam(':password', $hash_password, PDO::PARAM_STR);
            $result->execute();
            $row = $result->fetch();

            if(empty($row)) 
            {
                $error2 = array('error' => 'Account Not Found.');
                echo json_encode($error2);
                exit;
            } 
            else 
            {
                if($row['status'] == 1)
                {
                    $_SESSION['candidate_id'] = $row['id'];
                    $_SESSION['candidate_name'] = $row['firstname'].' '.$row['lastname'];
                    $_SESSION['photo'] = $row['photo'];
                    $_SESSION['candidate_login'] = true;

                    $success = array('message' => 'Logged In.', 'title' => 'Success');
                    echo json_encode($success);
                    exit;
                }
                else
                {
                    $message = array('info' => 'Please Try Again Later.', 'title' => 'Your Account is Not Active.');
                    echo json_encode($message);
                    exit;
                }
            }
        }
    }
}
?>