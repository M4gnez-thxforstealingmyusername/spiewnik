<?php
    include "conn.php";

    if($_POST["ret"] == 0)
    {
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
    }
    else if($_POST["ret"] == 1)
    {
        $sql = "SELECT tytul FROM piesn where id_piesn = ". $_POST["id_p"];
            $result = mysqli_query($conn, $sql);

            if ($result !== false && $result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $aResult = $row["tytul"];
                }
            }
            else
                $aResult = "Nie znaleziono tekstu";

            echo $aResult;
    }
    else if($_POST["ret"] == 2)
    {
        $aResult = array();
        $aResult[0] = array();
        $aResult[1] = array();

        $sql = "SELECT id_piesn, tytul FROM piesn";
        $result = mysqli_query($conn, $sql);

        if ($result !== false && $result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                array_push($aResult[0], $row["id_piesn"]);
                array_push($aResult[1], $row["tytul"]);
            }
        }
        else
            $aResult = "Nie znaleziono tekstu";

        echo json_encode($aResult);
    }
    else if($_POST["ret"] == 3)
    {
        $sql = "SELECT tekst FROM piesn where id_piesn = ". $_POST["id_p"];
            $result = mysqli_query($conn, $sql);

            if ($result !== false && $result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $aResult = $row["tekst"];
                }
            }
            else
                $aResult = "Nie znaleziono tekstu";

            echo $aResult;
    }
?>