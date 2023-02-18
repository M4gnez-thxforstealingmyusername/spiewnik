<form method="post">
    <input type="text" name="tytul" placeholder="Tytul..." autocomplete="off" class="input"><br>
    <textarea name="text" cols="30" rows="10" placeholder="Tekst utworu..." class="input"></textarea><br>
    <input type="submit" name="submit" class="input">
</form>
<?php
    include "head.php";

    function dodaj()
    {
        include "../conn.php";
        $tytul = $_POST["tytul"];

        $tekst = str_replace('\n', "\n", $_POST['text']);

        $sql = "INSERT INTO piesn VALUES (default, '".$tytul."', '".$tekst."')";
        $result = mysqli_query($conn, $sql);
        echo $result;
    }

    if(isset($_POST['submit']))
    {
        dodaj();
        include "head.php";
    }
?>
