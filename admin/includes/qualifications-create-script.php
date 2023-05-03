<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $qualification = filter_var(htmlentities($_POST['qualification'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $abbreviation = filter_var(htmlentities($_POST['abbreviation'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$abbreviation);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $status = filter_var(htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("F d, y");

    $sql = "SELECT * FROM qualifications WHERE qualification = :qualification";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':qualification', $qualification, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($qualification == null || $abbreviation == null || $status == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $qualification_err = array('error' => ''.$qualification.' Already Exists.');
        echo json_encode($qualification_err);
        exit;
    }
    elseif(empty($empty) && empty($qualification_err))
    {
        $sql = "INSERT INTO qualifications (qualification, abbreviation, slug, status, created_at) VALUES(:qualification, :abbreviation, :slug, :status, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':qualification', $qualification, PDO::PARAM_STR);
        $query->bindParam(':abbreviation', $abbreviation, PDO::PARAM_STR);
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