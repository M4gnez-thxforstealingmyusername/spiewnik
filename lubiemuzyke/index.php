<?php
    include "head.php";

    function dodaj()
    {
        include "../conn.php";
        $tytul = $_POST["tytul"];

        $sql = "INSERT INTO piesn VALUES (default, '".$tytul."', '".$tekst."')";
        $result = mysqli_query($conn, $sql);
        echo $result;
    }

    function edytuj()
    {
        include "../conn.php";
        $text = $_POST["text"];
        $id = $_POST["id_p"];

        $sqlu = "UPDATE piesn SET tekst = '".$text."' WHERE id_piesn = ".$id;
        mysqli_query($conn, $sqlu);
    }

    if(isset($_POST['dodaj']))
    {
        dodaj();
        include "head.php";
    }

    if(isset($_POST['edit']))
    {
        edytuj();
        include "head.php";
    }
?>
<button id="btn_1" class="btn_act">Dodaj</button>
    <button id="btn_2" class="btn_nact">Usuń</button>
    <button id="btn_3" class="btn_nact">Edytuj</button>
<div id="operators">

</div>
<form method="post" id="inter">
        <input type="text" name="tytul" placeholder="Tytuł..." autocomplete="off" class="input">
        <br class="input">
        <textarea name="text" cols="60" rows="20" placeholder="Tekst utworu..." class="input"></textarea>
        <br class="input">
        <input type="submit" name="dodaj" class="input">
</form>
<div id="submits">

</div>
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
        var form_operations = document.getElementById("inter");
        var div_operators = document.getElementById("operators");
        var div_submits = document.getElementById("submits");

        var elemen = document.querySelectorAll(".input");

        textarea = document.createElement("textarea");

        const submit = document.createElement("input");

        const br1 = document.createElement("br");
        br1.setAttribute("class", "input");
        const br2 = document.createElement("br");
        br2.setAttribute("class", "input");

        elemen.forEach(el => {
            el.remove();
        });

        elemen = document.querySelectorAll("span");

        elemen.forEach(el => {
            el.remove();
        });

        elemen = document.querySelectorAll(".remove");

        elemen.forEach(el => {
            el.remove();
        });

        switch(op)
        {
            case 0:
                const input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("name", "tytul");
                input.setAttribute("placeholder", "Tytuł...");
                input.setAttribute("autocomplete", "off");
                input.setAttribute("class", "input");
                form_operations.appendChild(input);

                form_operations.appendChild(br1);

                textarea.setAttribute("id", "textarea");
                textarea.setAttribute("name", "text");
                textarea.setAttribute("cols", 60);
                textarea.setAttribute("rows", 20);
                textarea.setAttribute("placeholder", "Tekst utworu...");
                textarea.setAttribute("class", "input");
                form_operations.appendChild(textarea);

                form_operations.appendChild(br2);

                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "dodaj");
                submit.setAttribute("class", "input");
                form_operations.appendChild(submit);
            break;
            case 1:

            break;
            case 2:
                const select = document.createElement("select");
                select.setAttribute("id", "edited")
                select.setAttribute("name", "id_p")
                select.setAttribute("class", "input");
                form_operations.appendChild(select);

                const edit_button = document.createElement("button");
                edit_button.setAttribute("id", "edit_button");
                edit_button.setAttribute("class", "input");
                edit_button.setAttribute("type", "button");
                edit_button.textContent = "Dodaj do edycji";
                form_operations.appendChild(edit_button);

                $.post("../teksty.php", {
                    "ret": 2
                }, function(tekstpiesni, status) {
                    var options = JSON.parse(tekstpiesni);

                    console.log(options);

                    for(var i = 0; i < options[0].length; i++)
                    {
                        const option = document.createElement("option");
                        option.setAttribute("value", options[0][i]);
                        option.textContent = options[1][i];
                        document.getElementById("edited").appendChild(option);

                        $(document).ready(function () {
                            $("select").select2();
                        });
                    }
                });

                form_operations.appendChild(br1);

                const edit_table = document.createElement("table")
                edit_table.setAttribute("id", "edit_table")
                const edit_tr = document.createElement("tr")
                edit_tr.setAttribute("id", "edit_tr")
                const pre_edit_td = document.createElement("td")
                pre_edit_td.setAttribute("id", "pre_edit_td")
                const textarea_edit_td = document.createElement("td")
                textarea_edit_td.setAttribute("id", "textarea_edit_td")

                edit_tr.appendChild(pre_edit_td);
                edit_tr.appendChild(textarea_edit_td);

                textarea.setAttribute("id", "edit_textarea");
                textarea.setAttribute("name", "text");
                textarea.setAttribute("cols", 60);
                textarea.setAttribute("placeholder", "Tekst utworu...");
                textarea.setAttribute("class", "input");
                textarea.setAttribute("style", "white-space: pre-wrap;");
                textarea_edit_td.appendChild(textarea);

                const edit_pre = document.createElement("pre");
                edit_pre.setAttribute("id", "old_text");
                edit_pre.setAttribute("class", "edit_pre remove");
                pre_edit_td.appendChild(edit_pre);

                edit_table.appendChild(edit_tr);

                form_operations.appendChild(edit_table);

                form_operations.appendChild(br2);

                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "edit");
                submit.setAttribute("id", "edit_submit");
                submit.setAttribute("class", "input");
                form_operations.appendChild(submit);

                document.getElementById("edit_button").addEventListener("click", function(){
                    $.post("../teksty.php", {
                            "id_p": document.getElementById("edited").value,
                            "ret": 3
                    }, function(tekstpiesni, status) {
                        document.getElementById("old_text").innerText = tekstpiesni;
                        console.log(document.getElementById("old_text").offsetHeight);
                        document.getElementById("edit_textarea").style.height = document.getElementById("old_text").offsetHeight+30;
                    });
                });
                break;
            }
        }
</script>