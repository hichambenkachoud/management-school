<?php

if (!empty($_GET['id_cours'])) {

	$code_cours = $_GET['id_cours'];
	$NamesOfStudent = getNbrStudentFollowingThisCourseCSV($code_cours);


	$array_line_1 = array();
	$array_line_2 = array();
	$array_line_3 = array();
	


	// Ligne 1
	$annee_univ = _getAnneeUniv($code_cours); echo $annee_univ.'<br/>';
	array_push($array_line_1, "Annee : ".$annee_univ);
	$professeur = _getNomPrenomProf($code_cours); echo $professeur.'<br/>';
	array_push($array_line_1, "Professeur : ".$professeur);

	// Ligne 2
	$niveau = _getNiveau($code_cours); echo $niveau.'<br/>';
	array_push($array_line_2, "Niveau : ".$niveau);
	$nomCours = _getNomCours($code_cours); echo $nomCours.'<br/>';
	array_push($array_line_2, "Cours : ".$nomCours);

	// Ligne 3
	$filiere = _getFiliere($code_cours); echo $filiere.'<br/>';
	array_push($array_line_3, "Filiere : ".$filiere);
	$semestre = _getSemestre($code_cours); echo $semestre.'<br/>';
	array_push($array_line_3, "Semestre : ".$semestre);

	// Ligne 4
	
	$array_line_4 = _getPourcentage($code_cours);
	//print_r($array_line_4);

	$array_line_5 = _getTestTypes();
	//print_r($array_line_5);
	
	// Ligne 5
	$dataToCSV = array($array_line_1, $array_line_2, $array_line_3, $array_line_4, $array_line_5);

	//print_r($dataToCSV);

	foreach ($NamesOfStudent as $key1 => $value1) {
		array_push($dataToCSV, 
			array($value1['email_etudiant'],strtoupper($value1['nom_etudiant'].' '. $value1['prenom_etudiant'])));
	}

	array_to_csv_download($dataToCSV, $annee_univ."_".$semestre."_".$nomCours."_".$niveau.".csv");
}



function _getAnneeUniv($code_cours){
	return $_SESSION['annee'];

}

function _getNomPrenomProf($code_cours){
	global $bdd;

	$code_prof = $_SESSION['code_prof'];
	$query = "SELECT * FROM professeur WHERE code_prof='$code_prof'";
	$q = $bdd->query($query);
	$result = $q->fetch();
	return strtoupper($result['nom_prof'])." ".ucwords($result['prenom_prof']);
}

function _getNiveau($code_cours){
	global $bdd;

	$query = "SELECT * FROM cours WHERE code_cours='$code_cours'";
	$q = $bdd->query($query);
	$result = $q->fetch();
	$code_ref =  $result['code_referentiel'];

	$query2 = "SELECT * FROM referentiel WHERE code_referentiel='$code_ref'";
	$q2 = $bdd->query($query2);
	$result2 = $q2->fetch();
	$code_niv =  $result2['code_niveau'];

	$query3 = "SELECT * FROM niveau WHERE code_niveau='$code_niv'";
	$q3 = $bdd->query($query3);
	$result3 = $q3->fetch();

	return $result3['libelle_niveau'];
}

function _getNomCours($code_cours){
	global $bdd;

	$code_prof = $_SESSION['code_prof'];
	$query = "SELECT * FROM cours WHERE code_cours='$code_cours'";
	$q = $bdd->query($query);
	$result = $q->fetch();
	return $result['libelle_cours'];
}

function _getSemestre($code_cours){
	return $_SESSION['semestre'];
}

function _getFiliere($code_cours){
	global $bdd;

	$query = "SELECT * FROM cours WHERE code_cours='$code_cours'";
	$q = $bdd->query($query);
	$result = $q->fetch();
	$code_ref =  $result['code_referentiel'];

	$query2 = "SELECT * FROM referentiel WHERE code_referentiel='$code_ref'";
	$q2 = $bdd->query($query2);
	$result2 = $q2->fetch();
	$code_fil =  $result2['code_filiere'];

	$query3 = "SELECT * FROM filiere WHERE code_filiere='$code_fil'";
	$q3 = $bdd->query($query3);
	$result3 = $q3->fetch();

	return $result3['libelle_filiere'];
	
}


function _getEpreuvesInfo($code_cours){
	global $bdd;

	$query = "SELECT * FROM cours WHERE code_cours='$code_cours'";
	$q = $bdd->query($query);
	$result = $q->fetch();
	$code_ref =  $result['code_referentiel'];

	$query2 = "SELECT * FROM referentiel WHERE code_referentiel='$code_ref'";
	$q2 = $bdd->query($query2);
	$result2 = $q2->fetch();
	$code_fil =  $result2['code_filiere'];

	$query3 = "SELECT * FROM filiere WHERE code_filiere='$code_fil'";
	$q3 = $bdd->query($query3);
	$result3 = $q3->fetch();

	return $result3['libelle_filiere'];
}

function _getAllTypeTest(){
	global $bdd;

	$query = "SELECT * FROM type_test ORDER BY code_type_test ASC";
	$q = $bdd->query($query);
	return $q->fetchall();
}

function _getTestTypes(){
	global $bdd;

	$allTypeTest = _getAllTypeTest();
	$array_line_5 = array("Email", "Nom Complet");

	foreach ($allTypeTest as $test) {
		array_push($array_line_5, $test['libelle_type_test']);
	}
	return $array_line_5;
}


function _getPourcentage($code_cours){
	global $bdd;
	$array_line_4 = array("", "");

	$allTypeTest = _getAllTypeTest();

	$code_element_module = getCodeElementModuleOfCourse($code_cours);
	$code_referentiel = getCodeReferentielOfCourse($code_cours);

	foreach ($allTypeTest as $test) {
		$type_1 = $test['code_type_test'];
		$qr = "SELECT * FROM referenciel_evaluation WHERE code_referentiel='$code_referentiel' AND code_element_module='$code_element_module' AND code_type_test='$type_1'";
		$exe_qr = $bdd->query($qr);
		$res = $exe_qr->fetch();

		if (isset($res['pourcentage_test'])) {
			array_push($array_line_4, $res['pourcentage_test']." %");
		}
		else{
			array_push($array_line_4, "0 %");
		}
	}
	return $array_line_4;
}





function array_to_csv_download($array, $filename = "notesFile.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    // Clean file
	ob_end_clean();

	$f = fopen('php://memory', 'w'); 
	fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));

    // loop over the input array
	foreach ($array as $line) { 
        // generate csv lines from the inner arrays
		fputcsv($f, $line, $delimiter); 
	}
    // reset the file pointer to the start of the file
	fseek($f, 0);
    // tell the browser it's going to be a csv file
	header('Content-Type: application/csv');
	//header('Content-Type: text/csv; charset=utf-8');

    // tell the browser we want to save it instead of displaying it
	header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
	fpassthru($f);
	exit();
}


?>