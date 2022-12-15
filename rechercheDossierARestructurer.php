<?php
include_once "Fichier.php";
include_once "Dossier.php";
include_once "baseDeDonneePhysique.php";

function RechercheDossierARestructurer($somme,$dossierParent,$listeObject,$trouver,$objetAPlacer){
    $listEnfant = new \SplObjectStorage();
    echo 'test';
    echo '<br>';
    $listEnfant->addAll($dossierParent->getListeEnfantFichier());
    if ($trouver == true) {
        echo "trouvé";
        //Fin procedure
        return;
 
    }elseif ($listEnfant->valid()) {
        //Debut de la recherche 
        echo "recherche";   
        while ($listEnfant->valid()) { 
            $somme = $somme + $listEnfant->current()->getTaille();
            
            //Test si on a trouvé tous nos fichier
            if ($somme > $objetAPlacer->getTaille()) {
                //if ($_POST["oui"]) (pour après avec les boutons)
                $trouver = true;
                break;
            }
        }
        echo 'rt';
        //Initialisation du/des fichier(s) a restructurer et mise a jour du pointeur
        $listeObject->attach($listEnfant->current());
        $dossierParent->supprimerEnfant($listEnfant->current());
    }
    //Recherche avec les enfants
    echo 'si t triste';
    $listEnfantDossier = $dossierParent->getListeEnfantDossier();
    var_dump($listEnfantDossier);
    if (isset($listEnfantDossier)) {
        while ($listEnfantDossier->valid()) {
            $dossierParent = $listEnfantDossier->current();
    RechercheDossierARestructurer($somme,$dossierParent,$listeObject,$trouver,$objetAPlacer);
    $listEnfantDossier->next();
        }
    }
}

$listeObject = new \SplObjectStorage();
$listeObject->attach($drive);
$listeObject->attach($cloud);
$listeObject->attach($FTP);
$maSomme = 0;
$trouve = false;
RechercheDossierARestructurer($maSomme,$dossier1,$listeObject ,$trouve,$objetAPlacer);
echo"finish";
?>