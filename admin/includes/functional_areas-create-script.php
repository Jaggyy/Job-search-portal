<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $functional_area = filter_var(htmlentities($_POST['functional_area'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$functional_area);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $status = filter_var(htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("F d, y");

    $sql = "SELECT * FROM functional_areas WHERE functional_area = :functional_area";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':functional_area', $functional_area, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($functional_area == null || $status == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $functional_area_err = array('error' => ''.$functional_area.' Already Exists.');
        echo json_encode($functional_area_err);
        exit;
    }
    elseif(empty($empty) && empty($functional_area_err))
    {
        $sql = "INSERT INTO functional_areas (functional_area, slug, status, created_at) VALUES(:functional_area, :slug, :status, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':functional_area', $functional_area, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
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