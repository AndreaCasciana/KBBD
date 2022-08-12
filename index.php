<html>
<head>
    <meta http-equiv="content-language" content="id">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,800" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/jQuery.js"></script>
    <link href="css/main.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="?">KBBD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#kbbdnavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="kbbdnavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">Log in</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="text" placeholder="tiruh" name="search">
                <button class="btn btn-primary" type="submit">Cari</button>
            </form>
        </div>
    </div>
</nav>
<div id="background">
    <?php
    //function for displaying the search box on the home page
    function displaySearch(){
        echo "
<div class=\"s006\">
    <div id=\"searchForm\">
    <form method=\"get\" action=\"\">
        <fieldset>
            <legend id=\"titleMainPage\">Kamus Besar Bahasa Dayak</legend>
            <div class=\"inner-form\">
                <div class=\"input-field\">
                    <button class=\"btn-search\" type=\"submit\">
                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\">
                        <path d=\"M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z\"></path>
                    </svg>
                    </button>
                    <input id=\"search\" type=\"text\" placeholder=\"Mahining\" value=\"\" name=\"search\"/>
                </div>
            </div>
            <div class=\"suggestion-wrap\">
                <span><a id=\"suggestion1\" href=\"?search=Dumah\">Dumah</a></span>
                <span><a id=\"suggestion2\" href=\"?search=Tulak\">Tulak</a></span>
                <span><a id=\"suggestion3\" href=\"?search=Kuman\">Kuman</a></span>
                <span><a id=\"suggestion4\" href=\"?search=Narai\">Narai</a></span>
                <span id='optionalSuggestion'><a id=\"suggestion5\" href=\"?search=Tege\">Tege</a></span>
            </div>
        </fieldset>
    </form>
    </div>
    </div>
";
    }
    if(!isset($_GET['search'])) {
        displaySearch();
    }
    ?>



    <?php
    include ("php/connect.php");
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
        if($search!='') {
            //if there is a GET request with a parameter 'search' not empty
            //then the word specified in the parameter will be searched in the database
            echo "<div id='definition' class='container rounded-3 shadow'>";
            $sql = "SELECT * FROM KBBD WHERE Word LIKE  '%" . $search . "%' OR Definition LIKE '%" .$search. "%'";
            $result = executeQuery($sql);
            echo "<div>";
            echo "<div class='row d-none d-md-block'>";
            echo "<div class='col text-center pt-3'>";
            echo "<img class='' src='images/KBBDtitle.png' width='700' height='80'>";
            echo "</div></div>";
            echo "<div class='row'>";
            echo "<div class='col justify-content-end hidden-xs d-none d-md-flex'>";
            echo "<img src='images/dayakshield.jpg' width='200' height='500'>";
            echo "</div>";

            if ($result->num_rows > 0) {
                echo "<div class='col'>";
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $contoh = explode(", ",  $row["Example"]);
                    //separates the examples in indonesian and dayak
                    $contohDayak = $contoh[0];
                    $contohIndo = $contoh[1];

                    if($i==1) //if more than a result is found
                        echo "<button  id='showMore' class='btn btn-dark mb-2' data-bs-toggle='collapse' data-bs-target='#moreResults'>Tampilkan lainnya</button><div id='moreResults' class='collapse'>";
                    echo "<h1>" . $row["Word"] . "</h1>
                        <p> /" . $row["Spelling"] . "/ " . $row["Type"] . "  - arti:  " . $row["Definition"] . "</p>
                        <p>Contoh:  " . $contohDayak. " </br> ($contohIndo) </p><br>
                        <p>Pranala (link): <a href='https://scascian2.alwaysdata.net/index.php?search=". $row["Word"] . "'>https://scascian2.alwaysdata.net/index.php?search=". $row["Word"] . "</a></p></br>";

                    $i++;
                }
                if($i>1) //if more than a result is found
                    echo "</div>";

                echo "</div>";
                echo "<div class='col'>";
                echo    "<img src='images/dayakbird.png' width='250' height='500'>";
                echo "</div></div></div></div>";
            } else { //if the word is not present in the database
                echo "<div class='col'>";
                echo "<h1>Kata \"$search\" belum ada di KBBD database. </h1>";
                echo "</div>";
                echo "<div class='col'>";
                echo "<img src='images/dayakbird.png' width='250' height='500'>";
                echo "</div></div></div>";
            }
        }else
            displaySearch();

    }?>

</div>
</body>
</html>
