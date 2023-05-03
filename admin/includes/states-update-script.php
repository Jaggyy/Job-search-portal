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

    $updated_at = date("F d, y");

    if($country == null || $state == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE states SET country = :country, state = :state, slug = :slug, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':state', $state, PDO::PARAM_STR);
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