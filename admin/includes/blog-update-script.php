<?php
if(isset($_POST['submit']))
{
    $title = filter_var(htmlentities($_POST['title'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $category_id = filter_var(htmlentities($_POST['category_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var(htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle = str_replace(" ","-",$title);
    $newurltitle = strtolower($newurltitle);
    $slug = $newurltitle; // Final URL

    $updated_at = date("F d, Y");

    if($title == null || $category_id == null || $description == null)
    {
        $empty = 'Please Fill Required Fields.';
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE blogs SET title = :title, slug = :slug, category_id = :category_id, description = :description, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $query->execute();
        if($result)
        {
            $success = 'Operation Successfull.';
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
        }
    }
}
?>