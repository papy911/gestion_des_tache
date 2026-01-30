<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Gestion des Tâches</title>
<link rel="stylesheet" href="css/bootstrap.css">
</head>

<?php

$tache_edit = null;

if(!file_exists("taches.json")){
    file_put_contents("taches.json","[]");
}

$taches = json_decode(file_get_contents("taches.json"),true);

if(isset($_POST['add'])){

    $tache = [
        "titre"=>$_POST['titre'],
        "desc"=>$_POST['desc'],
        "statut"=>$_POST['statut']
    ];

    if(isset($_GET['edit'])){
        $taches[$_GET['edit']] = $tache;
    }else{
        $taches[] = $tache;
    }

    file_put_contents("taches.json",json_encode($taches,JSON_PRETTY_PRINT));
    header("location:gestion_tache.php");
}

if(isset($_GET['sup'])){
    array_splice($taches,$_GET['sup'],1);
    file_put_contents("taches.json",json_encode($taches,JSON_PRETTY_PRINT));
    header("location:gestion_tache.php");
}

if(isset($_GET['edit'])){
    $tache_edit = $taches[$_GET['edit']];
}

?>

<body class="bg-light">

<div class="container mt-4">

<h2 class="text-center mb-4">Gestion des Tâches</h2>

<div class="card mb-4">
<div class="card-header bg-primary text-white">Ajouter une tâche</div>

<div class="card-body">
<form method="post">

<input class="form-control mb-2" placeholder="Titre"
name="titre" value="<?= $tache_edit['titre'] ?? '' ?>">

<textarea class="form-control mb-2" placeholder="Description"
name="desc"><?= $tache_edit['desc'] ?? '' ?></textarea>

<select name="statut" class="form-control mb-2">
<option>En cours</option>
<option <?= ($tache_edit['statut']??'')=="Terminée"?"selected":"" ?>>Terminée</option>
</select>

<button name="add" class="btn btn-success">Ajouter la tâche</button>

</form>
</div>
</div>

<h4>Liste des tâches</h4>

<div class="row">

<?php foreach($taches as $k=>$t){ ?>

<div class="col-md-4 mb-3">

<div class="card">

<div class="card-body">

<h5><?= $t['titre'] ?></h5>

<p><?= $t['desc'] ?></p>

<?php if($t['statut']=="Terminée"){ ?>
<span class="badge bg-success">Terminée</span>
<?php } else { ?>
<span class="badge bg-warning">En cours</span>
<?php } ?>

<hr>

<a href="?edit=<?=$k?>" class="btn btn-primary btn-sm">Modifier</a>
<a onclick="return confirm('Supprimer ?')" href="?sup=<?=$k?>" class="btn btn-danger btn-sm">Supprimer</a>

</div>
</div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>
