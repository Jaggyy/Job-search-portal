<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $country = filter_var(htmlentities($_POST['country'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $state_id = filter_var(htmlentities($_POST['state_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $city = filter_var(htmlentities($_POST['city'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$city);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $created_at = date("F d, y");

    $sql = "SELECT * FROM cities WHERE city = :city";
    $exist = $conn->prepare($sql);
    $exist->bindParam('city', $city, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($country == null || $state_id == null || $city == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $city_err = array('error' => ''.$city.' Already Exists.');
        echo json_encode($city_err);
        exit;
    }
    elseif(empty($empty) && empty($city_err))
    {
        $sql = "INSERT INTO cities (city, slug, state_id, country, created_at) VALUES(:city, :slug, :state_id, :country, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
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