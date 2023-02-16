<html>
    <?php include "head.php" ?>
    <body>
        <table>
            <tr>
                <td>
                    <label for="wejscie" class="label">Wejście:</label>
                </td>
                <td>
                    <select id="piesn0" name="wejscie" class="input">
                        <option value="0">brak</option>
                        <?php
                            include "conn.php";
                            include "select.php";
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="psalm" class="label">Psalm</label>
                </td>
                <td id="psalminput">
                    <textarea name="psalm" id="psalm" class="input"></textarea>
                </td>
                <td><button>dzisiejszy</button></td>
            </tr>
            <tr>
                <td>
                    <label for="ofiarowanie" class="label">Ofiarowanie:</label>
                </td>
                <td>
                    <select id="piesn1" name="ofiarowanie" class="input">
                        <option value="0">brak</option>
                        <?php
                            include "select.php";
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                        <label for="komunia" class="label">Komunia:</label>
                </td>
                <td>
                    <select id="piesn2" name="komunia" class="input">
                        <option value="0">brak</option>
                        <?php
                            include "select.php";
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="dziekczynienie" class="label">Dziękczynienie:</label>
                </td>
                <td>
                    <select id="piesn3" name="dziekczynienie" class="input">
                        <option value="0">brak</option>
                        <?php
                            include "select.php";
                        ?>
                    </select>
                </td>
            </tr>
                <td>
                    <label for="zejscie" class="label">Zejście:</label>
                </td>
                <td>
                    <select id="piesn4" name="zejscie" class="input">
                        <option value="0">brak</option>
                        <?php
                            include "select.php";
                            $conn->close();
                        ?>
                    </select>
                </td>
            </tr>
        </table>

        <button id="btn_p" onclick="piesni()">KLIK</button>
    </body>
    <script>
        $(document).ready(function () {
            $("select").select2();
        });

        document.getElementById("btn_p").addEventListener("click", piesni());

        function piesni()
        {
            var tabpiesni = [];

            if(document.getElementById("psalm").value)
                var psalm = document.getElementById("piesn"+i).value;

            for(var i = 0; i < 5; i++)
            {
                var obj = document.getElementById("piesn"+i);
                tabpiesni[i] = parseInt(obj.value);
            }

            var lnt = 4;

            for(var i = 0; i <= lnt; i++)
            {
                if(tabpiesni[i]==0)
                {
                    tabpiesni.splice(i,1);
                    i--;
                    lnt--;
                }
            }

            var idlist;
            if(tabpiesni.length > 0)
            {
                if(tabpiesni.length > 1)
                    idlist = tabpiesni[0] + ",";
                else
                idlist = tabpiesni[0];

                for(var i = 1; i < tabpiesni.length-1; i++)
                idlist += tabpiesni[i] + ",";

                if(tabpiesni.length > 1)
                idlist += tabpiesni[tabpiesni.length-1];
            }

            document.write(idlist);

            if(tabpiesni.length > 0)
                $.post("teksty.php", {
                        "id_p": idlist,
                    }, function(tekstpiesni, status) {
                        var teksty = JSON.parse(tekstpiesni);
                        prezentacja(teksty);
                    })
        }

        function prezentacja(tekst)
        {
            tekstprep = [];
            teksty = [];
            lp = 0;

            for(var i = 0; i < tekst.length; i++)
                tekstprep[i] = tekst[i].split("\\n\\n");

            for(var i = 0; i < tekstprep.length; i++)
            {
                for(var j = 0; j < tekstprep[i].length; j++)
                {
                    teksty[lp] = tekstprep[i][j];
                    lp++;
                }
                teksty[lp] = "";
                lp++;
            }

            for(var i = 0; i < teksty.length; i++){
                teksty[i] = teksty[i].replaceAll("\\n","\n")
                document.write(teksty[i])
            debugger;}

            if(document.body.innerHTML)
                document.body.innerHTML = "<head><link rel='stylesheet' href='style.css'></head><body></body>";

            const containerdiv = document.createElement("div");
            containerdiv.setAttribute("id", "condiv");
            containerdiv.setAttribute("class", "containing");
            document.body.appendChild(containerdiv);

            const centererdiv = document.createElement("div");
            centererdiv.setAttribute("id", "cendiv");
            centererdiv.setAttribute("class", "centering");
            document.getElementById("condiv").appendChild(centererdiv);

            const pretxt = document.createElement("pre");
            pretxt.setAttribute("id", "txt");
            pretxt.setAttribute("class", "formated");
            document.getElementById("cendiv").appendChild(pretxt);

            var slide = 0;
            document.getElementById("txt").textContent = teksty[slide];


            document.body.addEventListener("keydown", function(event){
                if(event.key == "ArrowRight")
                {
                    slide++;
                    document.getElementById("txt").textContent = teksty[slide];
                }
                else if(event.key == "ArrowLeft")
                {
                    slide--;
                    document.getElementById("txt").textContent = teksty[slide];
                }
            });
        };
    </script>
</html>