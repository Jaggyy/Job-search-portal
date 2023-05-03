<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $category = filter_var(htmlentities($_POST['category'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle = str_replace(" ","-",$category);
    $newurltitle = strtolower($newurltitle);
    $slug = $newurltitle; // Final URL

    $created_at = date("F d, Y");

    $sql = "SELECT * FROM blog_categories WHERE category = :category";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':category', $category, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($category == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $category_err = array('error' => ''.$category.' Already Exists.');
        echo json_encode($category_err);
        exit;
    }
    elseif(empty($empty) && empty($category_err))
    {
        $sql = "INSERT INTO blog_categories (category, slug, created_at) VALUES(:category, :slug, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
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