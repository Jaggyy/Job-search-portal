<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
if(!empty($_POST["state_id"]))
{
    $state_id = $_POST['state_id'];
    $sql_retrieve = "SELECT * FROM cities WHERE state_id = :state_id ORDER BY city";
    $query = $conn->prepare($sql_retrieve);
    $query->bindParam(':state_id', $state_id, PDO::PARAM_INT);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        foreach($results as $query_fetch)
        {
        ?>
            <option value="<?php echo $query_fetch->city; ?>"><?php echo $query_fetch->city; ?></option>
        <?php
        }
    }
}
?>