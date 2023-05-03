<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
if(!empty($_POST["stateid"]))
{
    $stateid = $_POST['stateid'];
    $select_cities = "SELECT * FROM cities WHERE state_id = :state_id ORDER BY city";
    $qry_run = $conn->prepare($select_cities);
    $qry_run->bindParam(':state_id', $stateid, PDO::PARAM_INT);
    $qry_run->execute();
    $output = $qry_run->fetchAll(PDO::FETCH_OBJ);
    if($qry_run->rowCount() > 0)
    {
        foreach($output as $query_fetch)
        {
        ?>
            <option value="<?php echo $query_fetch->id; ?>"><?php echo $query_fetch->city; ?></option>
        <?php
        }
    }
}
?>