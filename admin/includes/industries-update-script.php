<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $industry = filter_var(htmlentities($_POST['industry'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$industry);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $icon = $_FILES['icon']['name'];
    $status = filter_var(htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date("F d, y");

    if($industry == null || $status == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(empty($empty))
    {
        if($icon != null)
        {
            $sql = "UPDATE industries SET industry = :industry, slug = :slug, icon = :icon, status = :status, updated_at = :updated_at WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':industry', $industry, PDO::PARAM_STR);
            $query->bindParam(':slug', $slug, PDO::PARAM_STR);
            $query->bindParam(':icon', $icon, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_INT);
            $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
            $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $result = $query->execute();
            if($result)
            {
                move_uploaded_file($_FILES["icon"]["tmp_name"],"../../assets/images/icon/".$_FILES["icon"]["name"]);
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
            $sql = "UPDATE industries SET industry = :industry, slug = :slug, status = :status, updated_at = :updated_at WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':industry', $industry, PDO::PARAM_STR);
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
}
?>