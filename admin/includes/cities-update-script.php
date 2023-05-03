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

    $updated_at = date("F d, y");

    if($country == null || $state_id == null || $city == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE cities SET country = :country, state_id = :state_id, city = :city, slug = :slug, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
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
}
?>