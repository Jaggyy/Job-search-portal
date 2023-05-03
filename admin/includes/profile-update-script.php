<?php
if(isset($_POST['update']))
{
    $firstname = filter_var(htmlentities($_POST['firstname'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $lastname = filter_var(htmlentities($_POST['lastname'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $updated_at = date("F d, y");

    if($firstname == null || $lastname == null || $email == null)
    {
        $empty = 'Please Fill Required Fields.';
    }
    elseif(!filter_var($email, FILTER_SANITIZE_EMAIL))
    {
        $email_error = 'Invalid Email ID.';
    }
    elseif(empty($empty) && empty($email_error))
    {
        $sql = "UPDATE admin SET firstname = :firstname, lastname = :lastname, email = :email, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $query->bindParam(':id', $admin_id, PDO::PARAM_INT);
        $result = $query->execute();
        if($result)
        {
            $success = 'Operation Successfull.';
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
        }
    }
}
?>



<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $password = filter_var(htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $newpassword_var = filter_var(htmlentities($_POST['newpassword'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $newpassword = password_hash($newpassword_var, PASSWORD_DEFAULT);

    $confirmpassword = filter_var(htmlentities($_POST['confirmpassword'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $updated_at = date("F d, y");

    $sql = "SELECT * FROM admin WHERE id = :id";
    $exist = $conn->prepare($sql);
    $exist->bindParam('id', $admin_id, PDO::PARAM_INT);
    $exist->execute();
    $row = $exist->fetch();
    $hash_password = $row['password'];
    $dehash = password_verify($password, $hash_password);

    if($password == null || $newpassword_var == null || $confirmpassword == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($dehash == 0)
    {
        $pass_err = array('error' => 'Current Password is not correct.');
        echo json_encode($pass_err);
        exit;
    }
    elseif(strlen($newpassword_var) < 6)
    {
        $password_err = array('error' => 'New Password Must Have Atleast 6 Characters.');
        echo json_encode($password_err);
        exit;
    }
    elseif($newpassword_var != $confirmpassword)
    {
        $confirm_password_err = array('error' => 'New Password And Confirm Password Field Does Not Match.');
        echo json_encode($confirm_password_err);
        exit;
    }
    elseif(empty($empty) && empty($pass_err) && empty($password_err) && empty($confirm_password_err))
    {
        $sql = "UPDATE admin SET password = :password, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':password', $newpassword, PDO::PARAM_STR);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $query->bindParam(':id', $admin_id, PDO::PARAM_INT);
        $result = $query->execute();
        if($result)
        {
            $success = array('message' => 'Operation Successfull.', 'title' => 'Success');
            echo json_encode($success);
            exit;
        }
        else
        {
            $error = array('error' => 'Something went wrong. Please try again later.');
            echo json_encode($error);
            exit;
        }
    }
}
?>