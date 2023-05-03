<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $experience_title = filter_var(htmlentities($_POST['experience_title']), FILTER_SANITIZE_STRING);
    $company = filter_var(htmlentities($_POST['company']), FILTER_SANITIZE_STRING);
    $state_id = filter_var(htmlentities($_POST['state_id']), FILTER_SANITIZE_NUMBER_INT);
    $city_id = filter_var(htmlentities($_POST['city_id']), FILTER_SANITIZE_NUMBER_INT);
    $start_date = filter_var(htmlentities($_POST['start_date']), FILTER_SANITIZE_STRING);
    $end_date = filter_var(htmlentities($_POST['end_date']), FILTER_SANITIZE_STRING);
    $description = filter_var(htmlentities($_POST['description']),FILTER_SANITIZE_STRING);
    $updated_at = date("F d, Y");

    if($experience_title == null || $company == null || $state_id == null || $city_id == null || $start_date == null || $end_date == null || $description == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    else
    {
        $sql = "UPDATE manage_candidate_experiences SET experience_title = :experience_title, company = :company, state_id = :state_id, city_id = :city_id, start_date = :start_date, end_date = :end_date, description = :description, updated_at = :updated_at WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->bindParam(':experience_title', $experience_title, PDO::PARAM_STR);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $stmt->bindParam(':city_id', $city_id, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $statement = $stmt->execute();
        if($statement)
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