<?php
    include "conn.php";

    $aResult = array();

    $id = explode(",", $_POST["id_p"]);

    for($i = 0; $i < count($id); $i++)
    {
        $sql = "SELECT tekst FROM piesn where id_piesn = ". $id[$i];
        $result = mysqli_query($conn, $sql);

        if ($result !== false && $result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $aResult[$i] = $row["tekst"];
            }
        }
        else
            $aResult = "Nie znaleziono tekstu";
    }
    echo json_encode($aResult);
?>