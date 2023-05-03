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
    $updated_at = date("F d, y");

    if($qualification == null || $abbreviation == null || $status == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE qualifications SET qualification = :qualification, abbreviation = :abbreviation, slug = :slug, status = :status, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':qualification', $qualification, PDO::PARAM_STR);
        $query->bindParam(':abbreviation', $abbreviation, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
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
}
?>