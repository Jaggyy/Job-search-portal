<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
if(isset($_POST['update']))
{
    header('Content-Type: application/json');
    $category = filter_var(htmlentities($_POST['category'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle = str_replace(" ","-",$category);
    $newurltitle = strtolower($newurltitle);
    $slug = $newurltitle; // Final URL

    $updated_at = date("F d, Y");

    if($category == null)
    {
        header ("Location: ".$path."/admin/blogs/categories?empty=inputs");
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE blog_categories SET category = :category, slug = :slug, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $result = $query->execute();
        if($result)
        {
            header ("Location: ".$path."/admin/blogs/categories?operation=success");
        }
        else
        {
            header ("Location: ".$path."/admin/blogs/categories?error=error");
        }
    }
}
?>