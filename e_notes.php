<?php

if (getConnectedUserType() == "prof")
  header('location: indexx.php?page=p_notes');

?>

<section class="content-header">
  <h1>Notes
    <small> - Affichage des notes</small>
  </h1>
</section>

<section class="content">
  <div class="box noPrint">
    <div class="box-header">
      <h3 class="box-title">Selection du semestre</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form class="form-horizontal">
        <div class="form-group">
          <label class="col-md-2 control-label" for="selectbasic">Liste des semestres</label>
          <div class="col-md-7">
            <select id="elementModuleOfEtudiant" name="elementModuleOfEtudiant" class="form-control">
              <option value="">Select...</option>
              <?php
              foreach (getReferencielsOfEtudiant() as $data) {
                $code_referentiel = $data['code_referentiel'];

                foreach (getSemestresOfEtudiant($code_referentiel) as $dataRef){

                  ?>
                  <option value="<?php echo $data['code_referentiel']?>">
                    <?php echo $dataRef['libelle_niveau']." - ".$dataRef['libelle_filiere'] ." ( ".$dataRef['libelle_semestre'] ." ".$dataRef['annee_universitaire'] ." )";?> 
                  </option> 
                  <?php  
                }
              } ?> 
            </select>
          </div>
          <div class="col-md-3" id="e_printDiv">
          </div>
        </div>
      </form>
    </div>
  </div>


  <div class="box">
    <div class="box-header noPrint">
      <h3 class="box-title">Résultat</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
        <div class="box-body">
    <div class="pull-left col-md-2"></div>
    <div id="tableNotes" class="box-body table-responsive col-md-8">
    <div class="pull-right col-md-2"></div>
    </div>
  </div>
  </div>

</section>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="dist/js/functions.js"></script>
<script type="text/javascript">
  var someVarName = localStorage.getItem("code_referentiel");
  var element = document.getElementById('elementModuleOfEtudiant');
  if (someVarName !== null) {
    element.value = someVarName;
          //console.log("local - "+localStorage.getItem("id_cours"));
          localStorage.setItem("code_referentiel", "");
          getStudentMarks(someVarName);
          showPrintButton(someVarName);
        }
      </script>