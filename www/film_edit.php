<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($fil_id==0) 
        //création d'un enregistrement
        $sql="insert into film (fil_id,fil_nom,fil_date_sortie,fil_affiche) values (null,'$fil_nom','$fil_date_sortie','$fil_affiche')";
    else
        //maj d'un enregistrement
        $sql = "update film set fil_nom='$fil_nom',fil_date_sortie='$fil_date_sortie',fil_affiche='$fil_affiche' where fil_id=$fil_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:film_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from film where fil_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $fil_id=0;
        $fil_nom='';$fil_date_sortie='';$fil_affiche='';
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
        <h2>film : edition</h2>
        <form method="post">
            <input type="hidden" name="fil_id" value="<?= $fil_id ?>">
            <p>
                <label>fil_id</label> : <?= $fil_id ?>
            </p>
            <p>
<label for='fil_nom'>fil_nom</label>
<input type='text' name='fil_nom' id='fil_nom' value='<?= $fil_nom ?>'>
</p>

<p>
<label for='fil_date_sortie'>fil_date_sortie</label>
<input type='text' name='fil_date_sortie' id='fil_date_sortie' value='<?= $fil_date_sortie ?>'>
</p>

<p>
<label for='fil_affiche'>fil_affiche</label>
<input type='text' name='fil_affiche' id='fil_affiche' value='<?= $fil_affiche ?>'>
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