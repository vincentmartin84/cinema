<?php
require("../include/inc_config.php");

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require("../include/inc_head.php"); ?>
</head>

<body>
    <!-- lien de navigation pour lecteur d'écran -->
    <a href="#main" class="sr-only">aller au contenu principal</a>
    <!-- En-tête de page -->
    <header>
        <?php require("../include/inc_header.php"); ?>
    </header>

    <!-- menu de navigation -->
    <nav>
        <?php require("../include/inc_menu.php"); ?>
    </nav>

    <!-- contenu principal de la page -->
    <main id="main">
        <h1>Génération des données</h1>
        <?php
        //génération des films, 10 par semaine         
        $nbf = 0;
        $tab = [];
        for ($i = 1; $i <= 51; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                $nbf++;
                $titre = "film $nbf";
                $date = date("Y-m-d", mktime(0, 0, 0, 1, 1 + 7 * ($i - 1), 2022));
                $affiche = "film_$nbf.png";
                $tab[] = "(null,'$titre','$date','$affiche')";
            }
        }
        $sql = "insert into film values " . implode(",", $tab);
        mysqli_query($link, $sql);
        echo "<p>génération de $nbf films</p>";

        //génération des individus : 1000
        $nbi = 1000;
        $tab = [];
        for ($i = 1; $i <= $nbi; $i++) {
            $tab[] = "(null,'nom$i','prenom$i')";
        }
        $sql = "insert into individu values " . implode(",", $tab);
        mysqli_query($link, $sql);
        echo "<p>génération de $nbi individu</p>";

        //génération des cinemas : 
        $nbc = 0;
        $tab = [];
        for ($i = 1; $i <= 50; $i++) {
            $nbc++;
            $x = mt_rand(1, 2);
            for ($j = 1; $j <= $x; $j++)
                $tab[] = "(null,'cinema$nbc','ville$i')";
        }
        $sql = "insert into cinema values " . implode(",", $tab);
        mysqli_query($link, $sql);
        echo "<p>génération de $nbc cinemas</p>";

        //génération des particpation :          
        $tab = [];
        $nbp = 0;
        for ($i = 1; $i <= $nbf; $i++) {
            //nb de réalisateur
            $x = mt_rand(1, 10) < 2 ? 2 : 1;
            $t = range(1, $nbi);
            shuffle($t);
            for ($j = 1; $j <= $x; $j++) {
                $ind = $t[$j];
                $tab[] = "(null,'réalisateur',$ind,$i)";
                $nbp++;
            }

            //nb de acteur
            $x = mt_rand(1, 5);
            shuffle($t);
            for ($j = 1; $j <= $x; $j++) {
                $ind = $t[$j];
                $tab[] = "(null,'acteur',$ind,$i)";
                $nbp++;
            }
        }
        $sql = "insert into participer values " . implode(",", $tab);
        mysqli_query($link, $sql);
        echo "<p>génération de $nbp participations</p>";

        //génération des projections :          
        $tab = [];
        for ($i = 1; $i <= $nbf; $i++) {
            $dtdebut = mktime(0, 0, 0, 1, 1 + floor($i / 5) * 7, 2022);
            $dtfin = $dtdebut + mt_rand(15, 30) * 60 * 60 * 24;
            //nombre de salle
            $nbsalle = mt_rand(1, 10);
            $salles = range(1, $nbc);
            shuffle($salles);
            for ($j = 1; $j < $nbsalle; $j++) {
                $dt1 = date("Y-m-d", $dtdebut);
                $dt2 = date("Y-m-d", $dtfin);
                $cin = $salles[$j];
                $tab[] = "(null,'$dt1','$dt2',$cin,$i)";
            }
        }
        $sql = "insert into projeter values " . implode(",", $tab);
        mysqli_query($link, $sql);
        echo "<p>génération des projections</p>";

        ?>
    </main>

    <!-- pied de page -->
    <footer>
        <?php require("../include/inc_footer.php"); ?>
    </footer>
</body>

</html>