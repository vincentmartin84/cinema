<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($cin_id==0) 
        //création d'un enregistrement
        $sql="insert into cinema (cin_id,cin_nom,cin_ville) values (null,'$cin_nom','$cin_ville')";
    else
        //maj d'un enregistrement
        $sql = "update cinema set cin_nom='$cin_nom',cin_ville='$cin_ville' where cin_id=$cin_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:cinema_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from cinema where cin_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $cin_id=0;
        $cin_nom='';$cin_ville='';
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
        <h2>cinema : edition</h2>
        <form method="post">
            <input type="hidden" name="cin_id" value="<?= $cin_id ?>">
            <p>
                <label>cin_id</label> : <?= $cin_id ?>
            </p>
            <p>
<label for='cin_nom'>cin_nom</label>
<input type='text' name='cin_nom' id='cin_nom' value='<?= $cin_nom ?>'>
</p>

<p>
<label for='cin_ville'>cin_ville</label>
<input type='text' name='cin_ville' id='cin_ville' value='<?= $cin_ville ?>'>
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