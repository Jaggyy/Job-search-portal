<?php
if(isset($_POST['submit']))
{
    $title = filter_var(htmlentities($_POST['title'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $category_id = filter_var(htmlentities($_POST['category_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var(htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];

    //Title to friendly URL conversion
    $newurltitle = str_replace(" ","-",$title);
    $newurltitle = strtolower($newurltitle);
    $slug = $newurltitle; // Final URL

    $created_at = date("F d, Y");

    if($title == null || $category_id == null || $description == null || $image == null)
    {
        $empty = 'Please Fill Required Fields.';
    }
    elseif(empty($empty))
    {
        $sql = "INSERT INTO blogs (title, slug, category_id, image, description, created_at) VALUES(:title, :slug, :category_id, :image, :description, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $result = $query->execute();
        if($result)
        {
            move_uploaded_file($_FILES["image"]["tmp_name"],"../../assets/images/blog_images/".$_FILES["image"]["name"]);
            $success = 'Operation Successfull.';
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
        }
    }
}
?>