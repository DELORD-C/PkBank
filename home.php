<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="src/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous">
    </script>
    <title>Showdown</title>
</head>

<body>
    <?php
    include_once('php/config.php');
    if (isset($_SESSION['pass']) && $_SESSION['pass'] == 1) {
        echo "<div><a href='index.php?dc=1'><button class='deconnection'>Deconnection</button></a></div>";
    }
    ?>
    <div class='home__title'>
        <a href='index.php' class='title__a'>Pokemon Showdown Custom Teams</a>
    </div>
    <?php
    if (isset($_POST['nom'])) {
        $inom = $_POST['nom'];
        $inom = preg_replace('/\?/', '', $inom);
        $inom = preg_replace('/\//', '', $inom);
        $inom = preg_replace('/\\\/', '', $inom);
        $inom = preg_replace('/\./', '', $inom);
        $inom = preg_replace('/\;/', '', $inom);
        $inom = preg_replace('/\,/', '', $inom);
        $inom = preg_replace('/\:/', '', $inom);
        $inom = trim(htmlspecialchars($inom));
        $itier = $_POST['tier'];
        $itext = $_POST['text'];
        $stmt = $conn->prepare("SELECT * FROM teams WHERE name = '$inom'");
        $stmt->execute();
        $tiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($tiers) <= 0) {
            $stmt = $conn->prepare("INSERT INTO teams (name, Tier, team) VALUES (\"$inom\", \"$itier\", \"$itext\")");
            $stmt->execute();
            echo "<meta http-equiv=\'refresh\'  content=\'0;URL=home.php\'>";
        }
        else {
            echo "<b>Nom de Team déjà utilisé !</b>";
        }
    }

    if (isset($_GET['del'])) {
        $idel = $_GET['del'];
        $stmt = $conn->prepare("DELETE FROM teams WHERE ID = '$idel'");
        $stmt->execute();
        echo "<meta http-equiv=\'refresh\'  content=\'0;URL=home.php\'>";
    }


    $stmt = $conn->prepare("SELECT DISTINCT Tier FROM teams");
    $stmt->execute();
    $tiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "
    <ul class='tab-list'>
    ";
    foreach($tiers as $key => $value) {
        $tier = $value['Tier'];
        echo "
        <li class='tab-element' data-target='tab-$tier'>$tier</li>
        ";
    }
    if (isset($_SESSION['pass']) && $_SESSION['pass'] == 1) {
        echo "<li class = 'tab-element' data-target='tab-input'>Ajout</li>";
    }
    ?>
    </ul>
    <div class='teams'>
        <?php
    foreach($tiers as $key => $value) {
        $tier = $value['Tier'];
        echo "
        <div class='tab-content tab-$tier'>
        ";
        $stmt = $conn->prepare("SELECT * FROM teams WHERE Tier = '$tier'");
        $stmt->execute();
        $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($teams as $cle => $team) {
            $nom = $team['name'];
            $nomm = preg_replace('/ /', '-', $nom);
            $text = $team['team'];
            $sprites = [];
            $a = 0;
            foreach(preg_split("/((\r?\n)|(\r\n?))/", $text) as $line){
                preg_match('/^(.*)(?=\s@)/', $line, $matches);
                if(count($matches) > 0) {
                    preg_match('/^(.*)(?=\s\()/', $matches[0], $newmatch);
                    if(count($newmatch) > 0) {
                        $matches[0] = $newmatch[0];
                    }
                    preg_match('/^(.*)(?=(-X))/', $matches[0], $newmatch);
                    if(count($newmatch) > 0) {
                        $matches[0] = $newmatch[0] . 'x';
                    }
                    preg_match('/^(.*)(?=(-Y))/', $matches[0], $newmatch);
                    if(count($newmatch) > 0) {
                        $matches[0] = $newmatch[0] . 'x';
                    }
                    preg_match('/^(.*)(?=(Kommo-o))/', $matches[0], $newmatch);
                    if(count($newmatch) > 0) {
                        $matches[0] = 'Kommoo';
                    }
		            preg_match('/^(.*)(?=(-Mane))/', $matches[0], $newmatch);
                    if(count($newmatch) > 0) {
                        $matches[0] = 'necrozma-duskmane';
                    }
                    preg_match('/^(.*)(?=(Ho-Oh))/', $matches[0], $newmatch);
                    if(count($newmatch) > 0) {
                        $matches[0] = 'hooh';
                    }
                    $matches[0] = preg_replace('/ /', '', $matches[0]);
                    $sprites[$a] = "<img class='pkmn' src='https://play.pokemonshowdown.com/sprites/xyani/" . strtolower($matches[0]) . ".gif' alt='pokemon$a'.gif'>";
                    $a++;
                }
            }
            $textt = preg_replace('/\n/', '<br/>', $text);
            $id = $team['ID'];
            echo "
            <div class='team'>
                <div class='team__header'>
                    <h3 class='name'>Nom : $nom</h3>
                    <button class='team-btn' target='modal-$nomm'>More</button>
                    <button id='copy' class='team-btn copy-btn' target='$id'>Copy</button>
                    <textarea id='$id' class='hidden' value='$text'>$text</textarea>
                </div>
                <div class='teamdisplay' id='$id'>
                $sprites[0]
                $sprites[1]
                $sprites[2]
                $sprites[3]
                $sprites[4]
                $sprites[5]
                </div>
            </div>
            <div class='modal modal-$nomm'>
                <div class='modalin'>
                <h3 class='name'>Nom : $nom</h3>
                <button id='copy' class='team-btn copy-btn' target='$id'>Copy</button>
                <button class='team-btn modal-close'>Close</button>
                $textt";
            if (isset($_SESSION['pass']) && $_SESSION['pass'] == 1) {
                echo "<br/><a href='home.php?del=$id' class='del-btn'><button class='delete'>Delete</button></a>";
            }
            echo "
                </div>
            </div>
            ";
        }
        echo "</div>";
    }



    ?>
        <div class='tab-content tab-input'>
            <p></p>
            <form class='formu' action='home.php' method='post'>
                <div class='form'>
                    Nom
                    <input type='text' name='nom' placeholder="Nom de l'équipe" required> Tier
                    <select name='tier' required>
                        <option value='OU'>OU</option>
                        <option value='Ubers'>Ubers</option>
                        <option value='UU'>UU</option>
                        <option value='RU'>RU</option>
                        <option value='NU'>NU</option>
                        <option value='PU'>PU</option>
                        <option value='LC'>LC</option>
                        <option value='Monotype'>Monotype</option>
                        <option value='Anything'>Anything</option>
                    </select>
                    Import
                    <textarea class='text' name='text' required></textarea>
                </div>
                <input type='submit'>
            </form>
        </div>
    </div>


    <script src="js/modal.js">
    </script>
    <script src="js/script.js">
    </script>
</body>

</html>