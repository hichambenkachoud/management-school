<?php
if (empty($_GET['id_cours']) && empty($_POST['code_cours'])) {
  header('location: index.php?page=p_notes');
}
?>


<section class="content-header">
  <h1>
    Notes
    <small> - Gestion des notes</small>
  </h1>
  <ol class="breadcrumb unselectable-setting" id="session-info">
    Année universitaire 
    <?php
    echo getSelectedAnneeUniversitaire()." - ";
    if(getSelectedSemester() == "au") echo "Automne"; 
    elseif(getSelectedSemester() == "pr") echo"Printemps";
    ?>
  </ol>
</section>



<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Importation des notes</h3> - Information sur le cours
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>

    <div class="box-body">
      <div class="container">
        <form method="POST" action="index.php?page=uploadFile" enctype="multipart/form-data">
          <div class="form-group">
            <input type="hidden" name="code_cours" value="<?php 
            if (empty($_GET['id_cours'])) {
              echo $_POST['code_cours'];
            }
            elseif (empty($_POST['code_cours'])) {
              echo $_GET['id_cours'];
            }
            ?>">
            <input type="file" name="file" class="form-control">
          </div>
          <div class="form-group">
            <button type="submit" name="Submit" class="btn btn-success pull-right"><i class="fa fa-upload"></i> Importer</button>
          </div>
        </form>
      </div>
      <div class="container">
        <?php

        if (!empty($_FILES["file"]["tmp_name"])){
          $filename = $_FILES["file"]["tmp_name"];
          if (file_exists($filename)) {
            $file = fopen($filename, "r");

            $header = 5;

            $fp = file($filename);
            $nbr_e = count($fp) - $header;
            //nbr_e : nombre d'etudiant
            //echo $nbr_e;

            // Excel_NomComplet to TAB
            /*$ligne = fgets($file,4096);
            $liste = explode( ";",$ligne);
            fgets($file,4096);*/

            for ($i=0; $i < $header ; $i++) { 
              fgets($file,4096);
            }
            
            $Excel_NomComplet = array();
            $Excel_Email = array();
            $Excel_CC = array();
            $Excel_EF = array();
            $Excel_PR = array();
            $Excel_ST = array();
            $Excel_PF = array();


            $DataBase_test = array();
            $DataBase_email = array();

            while (!feof($file)){
              $ligne = fgets($file,4096); 
              $liste = explode( ";",$ligne); 
              $liste[0] = (isset($liste[0])) ? $liste[0] : Null;
              $liste[1] = (isset($liste[1])) ? $liste[1] : Null;
              $liste[2] = (isset($liste[2]) && $liste[2] >=0 && $liste[2]<=20) ? $liste[2] : Null;
              $liste[3] = (isset($liste[3]) && $liste[3] >=0 && $liste[3]<=20) ? $liste[3] : Null;
              $liste[4] = (isset($liste[4]) && $liste[4] >=0 && $liste[4]<=20) ? $liste[4] : Null;
              $liste[5] = (isset($liste[5]) && $liste[5] >=0 && $liste[5]<=20) ? $liste[5] : Null;
              $liste[6] = (isset($liste[6]) && $liste[6] >=0 && $liste[6]<=20) ? $liste[6] : Null;
              array_push($Excel_Email, $liste[0]);
              array_push($Excel_NomComplet, $liste[1]);
              array_push($Excel_CC, $liste[2]);
              array_push($Excel_EF, $liste[3]);
              array_push($Excel_PR, $liste[5]);
              array_push($Excel_ST, $liste[6]);
              array_push($Excel_PF, $liste[4]);
            }


            $dataS_1 = getNbrStudentFollowingThisCourse($_POST['code_cours']);
            $json_data = json_decode($dataS_1);

            //echo $dataS_1;
            //echo "<br/><br/>";
            //print_r($Excel_Email);

            //echo "<br/><br/>";
            //print_r($Excel_NomComplet);


            $RealNbr_e =  $json_data->{'RealNbr_e'};

            if ($nbr_e != $RealNbr_e) {
              //echo "<br/><div class='alert alert-danger'>Veuillez vérifier le nombre des étudiants sur le fichier Excel </div><br/>";
              echo "<br/><div class='alert alert-danger'>Format du fichier invalide <br/> Modifiez seulement les cellules concernant les notes.</div><br/>";
            }
            elseif ($nbr_e == $RealNbr_e) {
              //
              // Verification des noms des etudiants
              //

              /*
                $OBJ_nom_e =  $json_data->{'NomComplet'};
                $i=0;
                foreach($OBJ_nom_e as $e){
                  $nomComplet =  $e->nom_etudiant.' '.$e->prenom_etudiant;
                  $res_cmp = strcasecmp($Excel_NomComplet[$i], $nomComplet);

                  if ($res_cmp == 1) {
                    echo "<script>alert(\"Nom Etudiant non Valide (".$Excel_NomComplet[$i].")\");</script>";
                    //exit();
                    //header( "refresh:0.5;url=index.php?page=uploadFile&id_cours=".$_POST['code_cours']."" );
                    //header('location: index.php?page=uploadFile&id_cours='.$_POST['code_cours']);
                  }
                  $i++;
                }
              */

                $OBJ_infoStud =  $json_data->{'NomComplet'};
                foreach($OBJ_infoStud as $e){
                  array_push($DataBase_email, $e->email_etudiant);
                }
                //echo "<br/><br/>";
                //print_r($DataBase_email);

                $DataBase_codeT = getInfoTestAlreadyAdded($_POST['code_cours']);
                $json_test = json_decode($DataBase_codeT);

                foreach($json_test as $c){
                  array_push($DataBase_test, $c->code_type_test);
                }
                //echo "<br/><br/>";
                //print_r($DataBase_test);
                //echo "<br/><br/>";

                $code_cours = $_POST['code_cours'];

                if(checkEmails($DataBase_email, $Excel_Email) == "ok"){
                  echo "<br/><div class='alert alert-success'>Importation en cours... </div><br/>";
                  foreach($DataBase_test as $code_test){
                    if ($code_test == 'CC') {
                      $i=0;

                      try {
                        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $bdd->beginTransaction();

                        foreach($DataBase_email as $email_e){
                          $noteOfThatStudent=$Excel_CC[$i];

                          $qrADD = "UPDATE note SET note='$noteOfThatStudent'
                          WHERE code_cours='$code_cours' AND code_type_test='$code_test' AND email_etudiant='$email_e'";
                          $stmt = $bdd->prepare($qrADD);
                          $stmt->execute();

                          $i++;
                        }
                        $bdd->commit();
                        echo $code_test.'  :  importé.<br/>';
                      }
                      catch (Exception $e) {
                        $bdd->rollBack();
                        echo "Importation Echouée : ".$e->getMessage();
                      }
                    }
                    elseif ($code_test == 'EF') {
                      $i=0;

                      try {
                        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $bdd->beginTransaction();

                        foreach($DataBase_email as $email_e){
                          $noteOfThatStudent=$Excel_EF[$i];

                          $qrADD = "UPDATE note SET note='$noteOfThatStudent'
                          WHERE code_cours='$code_cours' AND code_type_test='$code_test' AND email_etudiant='$email_e'";
                          $stmt = $bdd->prepare($qrADD);
                          $stmt->execute();

                          $i++;
                        }
                        $bdd->commit();
                        echo $code_test.'  :  importé.<br/>';
                      }
                      catch (Exception $e) {
                        $bdd->rollBack();
                        echo "Importation Echouée : ".$e->getMessage();
                      }
                    }
                    elseif ($code_test == 'PRJ') {
                      $i=0;

                      try {
                        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $bdd->beginTransaction();

                        foreach($DataBase_email as $email_e){
                          $noteOfThatStudent=$Excel_PR[$i];

                          $qrADD = "UPDATE note SET note='$noteOfThatStudent'
                          WHERE code_cours='$code_cours' AND code_type_test='$code_test' AND email_etudiant='$email_e'";
                          $stmt = $bdd->prepare($qrADD);
                          $stmt->execute();

                          $i++;
                        }
                        $bdd->commit();
                        echo $code_test.'  :  importé.<br/>';
                      }
                      catch (Exception $e) {
                        $bdd->rollBack();
                        echo "Importation Echouée : ".$e->getMessage();
                      }
                    }
                    elseif ($code_test == 'STG') {
                      $i=0;

                      try {
                        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $bdd->beginTransaction();

                        foreach($DataBase_email as $email_e){
                          $noteOfThatStudent=$Excel_ST[$i];

                          $qrADD = "UPDATE note SET note='$noteOfThatStudent'
                          WHERE code_cours='$code_cours' AND code_type_test='$code_test' AND email_etudiant='$email_e'";
                          $stmt = $bdd->prepare($qrADD);
                          $stmt->execute();

                          $i++;
                        }
                        $bdd->commit();
                        echo $code_test.'  :  importé.<br/>';
                      }
                      catch (Exception $e) {
                        $bdd->rollBack();
                        echo "Importation Echouée : ".$e->getMessage();
                      }
                    }
                    elseif ($code_test == 'PFE') {
                      $i=0;

                      try {
                        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $bdd->beginTransaction();

                        foreach($DataBase_email as $email_e){
                          $noteOfThatStudent=$Excel_PF[$i];

                          $qrADD = "UPDATE note SET note='$noteOfThatStudent'
                          WHERE code_cours='$code_cours' AND code_type_test='$code_test' AND email_etudiant='$email_e'";
                          $stmt = $bdd->prepare($qrADD);
                          $stmt->execute();

                          $i++;
                        }
                        $bdd->commit();
                        echo $code_test.'  :  importé.<br/>';
                      }
                      catch (Exception $e) {
                        $bdd->rollBack();
                        echo "Importation Echouée : ".$e->getMessage();
                      }
                    }
                  }
                  header( "refresh:2;url=index.php?page=p_notes");
                }
                else{
                  //echo "<br/><div class='alert alert-danger'>Verifier les emails sur le fichier Excel... </div><br/>";
                  echo "<br/><div class='alert alert-danger'>Format du fichier invalide <br/> Modifiez seulement les cellules concernant les notes.</div><br/>";
                }
              }
            }
          }
          ?>
        </div>
      </div>
    </div>
  </section>
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="dist/js/functions.js"></script>
