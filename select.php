<?php
    $sql = "SELECT id_piesn, tytul FROM piesn";
    $result = mysqli_query($conn, $sql);

    if ($result !== false && $result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            echo "<option value='".$row["id_piesn"]."'>".$row["tytul"]."</option>";
        }
    }
    else
    {
        echo "0 results";
    }
?>