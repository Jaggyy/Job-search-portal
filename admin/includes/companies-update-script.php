<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $status = filter_var(htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date("F d, y");

    $sql = "SELECT * FROM companies WHERE id = :id";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $exist->execute();
    $query_fetch = $exist->fetch();
    if($query_fetch['verified'] == 1)
    {
        $sql = "UPDATE companies SET status = :status, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
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
    else
    {
        $message = array('error' => 'You Have Not Verified This Account Yet. Please Verify First.');
        echo json_encode($message);
        exit;
    }
    
}
?>


<?php
if(isset($_POST['verify']))
{
    $verified = filter_var(htmlentities($_POST['verified'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    
    $sql = "UPDATE companies SET verified = :verified WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':verified', $verified, PDO::PARAM_INT);
    $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $result = $query->execute();
    if($result)
    {
        $success = "Account Verified Successfully.";
        header('Refresh:2;url='.$path.'/companies/view?id='.$_GET['id'].'');
    }
    else
    {
        $error = "Something Went Wrong. Please Try Again Later.";
        header('Refresh:2;url='.$path.'/companies/view?id='.$_GET['id'].'');
    }
}
?>