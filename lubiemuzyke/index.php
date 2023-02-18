    <button id="btn_1" class="btn_act">Dodaj</button>
    <button id="btn_2" class="btn_nact">Usuń</button>
    <button id="btn_3" class="btn_nact">Edytuj</button>
<form method="post" id="inter">
        <input type="text" name="tytul" placeholder="Tytuł..." autocomplete="off" class="input">
        <br class="input">
        <textarea name="text" cols="60" rows="20" placeholder="Tekst utworu..." class="input"></textarea>
        <br class="input">
        <input type="submit" name="dodaj" class="input">
</form>
<script>
    document.getElementById("btn_1").addEventListener("click", function(){
        document.getElementById("btn_1").classList.add("btn_act")
        document.getElementById("btn_2").classList.add("btn_nact")
        document.getElementById("btn_3").classList.add("btn_nact")
        document.getElementById("btn_1").classList.remove("btn_nact")
        document.getElementById("btn_2").classList.remove("btn_act")
        document.getElementById("btn_3").classList.remove("btn_act")
        oper(0);
    });
    document.getElementById("btn_2").addEventListener("click", function(){
        document.getElementById("btn_1").classList.add("btn_nact")
        document.getElementById("btn_2").classList.add("btn_act")
        document.getElementById("btn_3").classList.add("btn_nact")
        document.getElementById("btn_1").classList.remove("btn_act")
        document.getElementById("btn_2").classList.remove("btn_nact")
        document.getElementById("btn_3").classList.remove("btn_act")
        oper(1);
    });
    document.getElementById("btn_3").addEventListener("click", function(){
        document.getElementById("btn_1").classList.add("btn_nact")
        document.getElementById("btn_2").classList.add("btn_nact")
        document.getElementById("btn_3").classList.add("btn_act")
        document.getElementById("btn_1").classList.remove("btn_act")
        document.getElementById("btn_2").classList.remove("btn_act")
        document.getElementById("btn_3").classList.remove("btn_nact")
        oper(2);
    });

    function oper(op)
    {
        var divb = document.getElementById("inter");

        var elemen = document.querySelectorAll(".input");

        console.log(elemen)

        elemen.forEach(el => {
            el.remove();
        });

        switch(op)
        {
            case 0:
                const br1 = document.createElement("br");
                br1.setAttribute("class", "input");
                const br2 = document.createElement("br");
                br2.setAttribute("class", "input");

                const input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("name", "tytul");
                input.setAttribute("placeholder", "Tytuł...");
                input.setAttribute("autocomplete", "off");
                input.setAttribute("class", "input");
                divb.appendChild(input);

                divb.appendChild(br1);

                const textarea = document.createElement("textarea");
                textarea.setAttribute("name", "text");
                textarea.setAttribute("cols", 60);
                textarea.setAttribute("rows", 20);
                textarea.setAttribute("placeholder", "Tekst utworu...");
                textarea.setAttribute("class", "input");
                divb.appendChild(textarea);

                divb.appendChild(br2);

                const submit = document.createElement("input");
                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "dodaj");
                submit.setAttribute("class", "input");
                divb.appendChild(submit);
            break;
            case 1:

            break;
            case 2:

            break;
        }
    }
</script>
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

    if(isset($_POST['dodaj']))
    {
        dodaj();
        include "head.php";
    }
?>
