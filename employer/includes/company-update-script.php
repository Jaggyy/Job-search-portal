<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $firstname = filter_var(htmlentities($_POST['firstname'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $lastname = filter_var(htmlentities($_POST['lastname'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var(htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $companyname = filter_var(htmlentities($_POST['companyname'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$companyname);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $industry_id = filter_var(htmlentities($_POST['industry_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $country = filter_var(htmlentities($_POST['country'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $state_id = filter_var(htmlentities($_POST['state_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $city_id = filter_var(htmlentities($_POST['city_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var(htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $updated_at = date("F d, y");

    if($firstname == null || $lastname == null || $email == null || $phone == null || $companyname == null || $industry_id == null || $country == null || $state_id == null || $city_id == null || $description == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(!filter_var($email, FILTER_SANITIZE_EMAIL))
    {
        $email_error = array('error' => 'Invalid Email ID.');
        echo json_encode($email_error);
        exit;
    }
    elseif(empty($empty) && empty($email_error))
    {
        $sql = "UPDATE companies SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone, companyname = :companyname, slug = :slug, industry_id = :industry_id, country = :country, state_id = :state_id, city_id = :city_id, description = :description, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_INT);
        $query->bindParam(':companyname', $companyname, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':industry_id', $industry_id, PDO::PARAM_INT);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $query->bindParam(':city_id', $city_id, PDO::PARAM_INT);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $query->bindParam(':id', $company_id, PDO::PARAM_INT);
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