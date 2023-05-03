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
    $created_at = date("F d, y");

    $sql = "SELECT * FROM industries WHERE industry = :industry";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':industry', $industry, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($industry == null || $icon == null || $status == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $industry_err = array('error' => ''.$industry.' Already Exists.');
        echo json_encode($industry_err);
        exit;
    }
    elseif(empty($empty) && empty($industry_err))
    {
        $sql = "INSERT INTO industries (industry, slug, icon, status, created_at) VALUES(:industry, :slug, :icon, :status, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':industry', $industry, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':icon', $icon, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':created_at', $created_at, PDO::PARAM_STR);
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
}
?>