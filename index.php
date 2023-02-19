<html>
    <?php include "head.php" ?>
    <body>

        <select id="songlist" name="ofiarowanie" class="input">
            <option value="0">brak</option>
            <?php
                include "conn.php";
                include "select.php";
                $conn -> close();
            ?>
        </select>
        <button id="btn_add">+</button>
        <table id="listedsongs">

        </table>
        <button id="btn_p" onclick="piesni()">KLIK</button>
    </body>
    <script>
        document.getElementById("btn_add").addEventListener("click", () => {dodajpiesn(document.getElementById("songlist").value)});

        $(document).ready(function () {
            $("select").select2();
        });

        document.getElementById("btn_p").addEventListener("click", ()=>piesni());

        var songcount = -1;
        var songorder = 0;

        var song = [];

        function lista()
        {
            const songlist = document.getElementById("listedsongs");

            const container = document.querySelectorAll('.songdiv');
            container.forEach((obj)=>{
                obj.remove();
            });

            var id_giver = 0;

            song.forEach((song_el)=>{
                const songdiv = document.createElement("tr");
                songdiv.setAttribute("id", "songdiv" + id_giver)
                songdiv.setAttribute("class", "songdiv");
                songlist.appendChild(songdiv);

                const buttondiv = document.createElement("td");
                buttondiv.setAttribute("id", "buttondiv" + id_giver)
                buttondiv.setAttribute("class", "line");
                document.getElementById("songdiv" + id_giver).appendChild(buttondiv);

                const delete_button = document.createElement("button");
                delete_button.setAttribute("id", "btn_delete_songdiv" + id_giver);
                delete_button.setAttribute("class", id_giver);
                document.getElementById("buttondiv" + id_giver).appendChild(delete_button);
                document.getElementById("btn_delete_songdiv" + id_giver).textContent = "-";

                if(id_giver > 0)
                {
                const up_button = document.createElement("button");
                up_button.setAttribute("id", "btn_up_songdiv" + id_giver);
                up_button.setAttribute("class", id_giver);
                document.getElementById("buttondiv" + id_giver).appendChild(up_button);
                document.getElementById("btn_up_songdiv" + id_giver).textContent = "/\\";
                }

                if(id_giver < songcount)
                {
                const down_button = document.createElement("button");
                down_button.setAttribute("id", "btn_down_songdiv" + id_giver);
                down_button.setAttribute("class", id_giver);
                document.getElementById("buttondiv" + id_giver).appendChild(down_button);
                document.getElementById("btn_down_songdiv" + id_giver).textContent = "\\/";
                }

                const listedtitle = document.createElement("td");
                listedtitle.setAttribute("id", "song" + id_giver);
                listedtitle.setAttribute("style", "color: white;");
                document.getElementById("songdiv" + id_giver).appendChild(listedtitle);

                document.getElementById("song" + id_giver).textContent = song_el.title;

                document.getElementById("btn_delete_songdiv" + id_giver).addEventListener("click", function(){
                    song.splice(event.target.className, 1);
                    document.getElementById("songdiv"+event.target.className).remove();
                    songcount--;
                    lista();
                });

                if(id_giver > 0)
                    document.getElementById("btn_up_songdiv" + id_giver).addEventListener("click", function(){
                        var con = song[event.target.className];
                        song[event.target.className] = song[event.target.className-1];
                        song[event.target.className-1] = con;
                        lista();
                    });

                if(id_giver < songcount)
                    document.getElementById("btn_down_songdiv" + id_giver).addEventListener("click", function(){
                        var con = song[event.target.className];
                        song[event.target.className] = song[parseInt(event.target.className) + 1];
                        song[parseInt(event.target.className) + 1] = con;
                        lista();
                    });

                id_giver++
            });
        }

        function piesni()
        {
            if(song.length == 0)
            {
                return 0
            }

            var tabpiesni = []

            song.forEach((song_el)=>{
                tabpiesni[tabpiesni.length] = song_el.id;
            });

            console.log(tabpiesni)

            // if(document.getElementById("psalm").value)
            //     var psalm = document.getElementById("piesn"+i).value;

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
                        "ret": 0
                    }, function(tekstpiesni, status) {
                        var teksty = JSON.parse(tekstpiesni);
                        prezentacja(teksty);
                    })
        };

        function prezentacja(tekst)
        {
            tekstprep = [];
            teksty = [];
            lp = 0;

            for(var i = 0; i < tekst.length; i++)
                tekstprep[i] = tekst[i].split("#");

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
            ;}

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

            document.body.addEventListener("click", function(){
                slide++;
                document.getElementById("txt").textContent = teksty[slide];
            });

            document.body.addEventListener('contextmenu', function(e) {
                slide--;
                document.getElementById("txt").textContent = teksty[slide];
                e.preventDefault()
                return false;
            }, false);
        };

        function dodajpiesn(id)
        {
            if(id == 0)
            {}
            else
            {
                var title;

                $.post("teksty.php", {
                            "id_p": id,
                            "ret": 1
                }, function(tekstpiesni, status) {
                    title = tekstpiesni;
                    song[songcount] =
                    {
                        id: id,
                        title: title,
                        obj_id: songcount
                    };

                    lista();
                });
                songcount++;
                songorder++;
            };
        }
    </script>
</html>