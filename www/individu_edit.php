<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($ind_id==0) 
        //création d'un enregistrement
        $sql="insert into individu (ind_id,ind_nom,ind_prenom) values (null,'$ind_nom','$ind_prenom')";
    else
        //maj d'un enregistrement
        $sql = "update individu set ind_nom='$ind_nom',ind_prenom='$ind_prenom' where ind_id=$ind_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:individu_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from individu where ind_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $ind_id=0;
        $ind_nom='';$ind_prenom='';
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
        <h2>individu : edition</h2>
        <form method="post">
            <input type="hidden" name="ind_id" value="<?= $ind_id ?>">
            <p>
                <label>ind_id</label> : <?= $ind_id ?>
            </p>
            <p>
<label for='ind_nom'>ind_nom</label>
<input type='text' name='ind_nom' id='ind_nom' value='<?= $ind_nom ?>'>
</p>

<p>
<label for='ind_prenom'>ind_prenom</label>
<input type='text' name='ind_prenom' id='ind_prenom' value='<?= $ind_prenom ?>'>
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