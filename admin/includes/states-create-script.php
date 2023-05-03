<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $country = filter_var(htmlentities($_POST['country'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $state = filter_var(htmlentities($_POST['state'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$state);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $created_at = date("F d, y");

    $sql = "SELECT * FROM states WHERE state = :state";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':state', $state, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($country == null || $state == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $state_err = array('error' => ''.$state.' Already Exists.');
        echo json_encode($state_err);
        exit;
    }
    elseif(empty($empty) && empty($state_err))
    {
        $sql = "INSERT INTO states (country, state, slug, created_at) VALUES(:country, :state, :slug, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':state', $state, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':created_at', $created_at, PDO::PARAM_STR);
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