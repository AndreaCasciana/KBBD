<?php
//if the user is not logged in, it redirects to the login page
session_start();
if(!isset($_SESSION['username']))
    header("Location: ../login.html");
?>

<html>
<head>
    <meta http-equiv="content-language" content="id">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/jQuery.js"></script>


</head>
<body style=" background:url('../images/Searchs_006.png') no-repeat; background-size:cover;">
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="?">KBBD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#kbbdnavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="kbbdnavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white">ADMIN AREA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container rounded-3">
    <div class="container rounded bg-white mt-5 mb-5 px-5">
        <div class="row text-center">
            <div class="row mt-3">
                <form method="get" action="">
                    <div class="col-md-12">
                        <div class="row mt-3 inputs">
                            <h4 class="text-center col-md-12">TAMBAH KATA KE DATABASE</h4>
                            <div class="col-md-4"><label class="labels"><b>Kata: </b></label>
                                <input class="form-control" size="10" type="text"  id="addWordField" name="word" required/></div>
                            <div class="col-md-4"><label class="labels"><b>Jenis kata: </b></label>
                                <select class="form-select" name="type">
                                    <option>n (nomina)</option>
                                    <option>v (verba)</option>
                                    <option>a (adjektiva)</option>
                                    <option>adv (adverbia)</option>
                                    <option>num (numeralia)</option>
                                    <option>p (partikel)</option>
                                    <option>pron (pronomina)</option>
                                </select>
                            </div>
                            <div class="col-md-4"><label class="labels"><b>Ejaan: </b></label>
                                <input  class="form-control" size="10" type="text"  id="addSpellingField" name="spelling" required/></div>
                            <div class="col-md-12"><label class="labels"><b>Arti: </b></label>
                                <textarea class="form-control"  size="10" type="text"  id="addDefinitionField" name="definition" required></textarea></div>
                            <div class="col-md-12"><label class="labels"><b>Contoh: </b></label>
                                <textarea class="form-control"  size="10" type="text"  id="addExampleField" name="example" required></textarea></div>
                        </div>
                    </div>
                    <br>
                    <button id="submitAddWord" type="submit" class="btn btn-primary edit">Tambah</button>
                    <div id="labelAddGame"></div>
                </form>
            </div>
            <hr>
            <div class="text-center">
                <h4>HAPUS/EDIT KATA DI DATABASE</h4>
                <form method="post" action="" class="mx-auto d-flex col-md-8">
                    <input class="form-control" type="text" placeholder="tiruh" name="search">
                    <button class="btn btn-primary" type="submit" name="edit">CARI KATA</button>
                </form>
            </div>

            <?php

            include ("connect.php");

            if(isset($_POST['edit']))
                searchWordInDB();
            if(isset($_POST['delete']))
                deleteWord($_POST['id']);
            if(isset($_POST['editWord']))
                editWord($_POST['id']);

            //if there is a GET request with the 'word' parameter, then it adds a word into the database with the specified parameters
            if(!empty( $_GET) && isset($_GET['word'])) {
                $word = $_GET['word'];
                $spelling = $_GET['spelling'];
                $type = $_GET['type'];
                $definition = $_GET['definition'];
                $example = $_GET['example'];
                $id = 0;
                //it adds the word only if all parameters are not empty
                if ($word != '' && $spelling != '' && $type != '' && $definition != '' && $example != '') {
                    $sql = "SELECT MAX(ID) AS id FROM KBBD";
                    $result = executeQuery($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = intval($row["id"]);
                        }
                    }

                }
                //the ID of the new word will be the old ID + 1
                $id += 1;
                $type = strstr($type, ' ', true);
                //adds the word into the database
                $sql = "INSERT INTO KBBD VALUES ('" . $id . "','" . $word . "','" . $spelling . "','" . $type . "','" . $definition . "','" . $example . "' )";
                $result = executeQuery($sql);
                echo "<script type='text/javascript'>alert('Kata berhasil ditambahkan ke database!')</script>";
                echo "<script>window.location.href='adminArea.php'</script>";
            }

            //searches a word in the database and displays a table with the results
            function searchWordInDB(){
                $word = $_POST['search'];
                if($word!='') {

                    $sql = "SELECT * FROM KBBD WHERE Word LIKE  '%" . $word . "%'";
                    $result = executeQuery($sql);

                    if ($result->num_rows > 0) {

                        echo "
<div class='table-responsive' id='tableResults'>
                    <table class='table'>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kata</th>
                    <th>Ejaan</th>
                    <th>Jenis kata</th>
                    <th>Arti</th>
                    <th>Contoh</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>";

                        while ($row = $result->fetch_assoc()) {
                            $types = ['n', 'v', 'a', 'adv', 'num', 'p', 'pron'];
                            $currType =  $row["Type"];
                            $types = array_merge(array_diff($types, array($currType)));
                            echo"
                <tr>
                <form method='post' action='' id='tableSearch'>
                    <td><input type='text' name='id' value='" . $row["ID"] . "'  style='border:0; outline:0;' readonly></td>
                    <td><input type='text' name='word' value='" . $row["Word"] . "'></td>
                    <td><input type='text' name='spelling' value='" . $row["Spelling"] . "'></td>
                    <td>
                     <select name='type'>
                                    <option>$currType </option>
                                    <option>$types[0]</option>
                                    <option>$types[1]</option>
                                    <option>$types[2]</option>
                                    <option>$types[3]</option>
                                    <option>$types[4]</option>
                                    <option>$types[5]</option>
                                </select>
                    </td>
                    <td><input type='text' name='definition' value='" . $row["Definition"] . "'></td>
                    <td><input type='text' name='example' value='" . $row["Example"] . "'>
                    <td><button type='submit' class='btn btn-info edit' name='editWord'>Edit</button></td>
                     <td><button type='submit' class='btn btn-danger edit' name='delete'>Hapus</button></td>
                    </form>
                </tr>";
                        }

                        echo"                </tbody>
                                                  </table>
                                 ";
                    } else { //displays an empty table if there are no results
                        echo "
                    <table class='table'>
                <thead>
                <tr>
                    <th>Kata</th>
                    <th>Ejaan</th>
                    <th>Jenis kata</th>
                    <th>Arti</th>
                    <th>Contoh</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table></div>
        ";
                    }
                }
            }

            //deletes the specified $ID word from the database
            function deleteWord($ID){
                $sql = "DELETE FROM KBBD WHERE ID =  '" . $ID . "'";
                executeQuery($sql);
                echo "<script type='text/javascript'>alert('Kata berhasil dihapus dari database!')</script>";
            }

            //updates the specified $ID word in the database
            function editWord($ID){
                $sql = "UPDATE KBBD SET  Word = '" . $_POST['word'] . "', Spelling = '" .$_POST['spelling'] ."', Type = '" . $_POST['type'] . "', Definition =  '" . $_POST['definition'] . "', Example = '" . $_POST['example'] . "' WHERE ID =  '" . $ID . "'";
                executeQuery($sql);
                echo "<script type='text/javascript'>alert('Kata berhasil diedit di database!')</script>";
            }

            ?>
        </div>
    </div>
</div>
</body>
</html>