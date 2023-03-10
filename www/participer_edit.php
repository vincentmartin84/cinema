<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($par_id==0) 
        //création d'un enregistrement
        $sql="insert into participer (par_id,par_fonction,par_individu,par_film) values (null,'$par_fonction','$par_individu','$par_film')";
    else
        //maj d'un enregistrement
        $sql = "update participer set par_fonction='$par_fonction',par_individu='$par_individu',par_film='$par_film' where par_id=$par_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:participer_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from participer where par_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $par_id=0;
        $par_fonction='';$par_individu='';$par_film='';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require "../include/inc_head.php"; ?>
</head>

<body>
    <!-- lien de navigation pour lecteur d'écran -->
    <a href="#main" class="sr-only">aller au contenu principal</a>
    <!-- entete de page -->
    <header>
        <?php require "../include/inc_header.php"; ?>
    </header>
    <!-- menu de navigation -->
    <nav>
        <?php require "../include/inc_menu.php"; ?>
    </nav>
    <!-- contenu principal -->
    <main id="main">
        <h2>participer : edition</h2>
        <form method="post">
            <input type="hidden" name="par_id" value="<?= $par_id ?>">
            <p>
                <label>par_id</label> : <?= $par_id ?>
            </p>
            <p>
<label for='par_fonction'>par_fonction</label>
<input type='text' name='par_fonction' id='par_fonction' value='<?= $par_fonction ?>'>
</p>

<p>
<label for='par_individu'>par_individu</label>
<input type='text' name='par_individu' id='par_individu' value='<?= $par_individu ?>'>
</p>

<p>
<label for='par_film'>par_film</label>
<input type='text' name='par_film' id='par_film' value='<?= $par_film ?>'>
</p>


            <p>
                <input type="submit" name="btsubmit" value="Envoyer">
            </p>
        </form>
    </main>
    <!-- pied de page -->
    <footer>
        <?php require "../include/inc_footer.php"; ?>
    </footer>

</body>

</html>