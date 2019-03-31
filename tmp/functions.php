<?php

if (!session_id())
	session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=db_scolarite;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}



function getAllAnneeUniversitaire(){
	global $bdd;
	$query = "SELECT annee_universitaire FROM referentiel GROUP BY annee_universitaire ORDER BY annee_universitaire DESC ";
	$q = $bdd->query($query);
	return $q->fetchall();
}


function getCoursOfProf(){
	global $bdd;
	$code_prof = $_SESSION['code_prof'];
	$annee = $_SESSION['annee'];
	$semestre = $_SESSION['semestre'];
	$query = "
	SELECT * FROM cours_professeur,cours,referentiel,niveau, filiere  
	WHERE cours.code_referentiel=referentiel.code_referentiel 
	AND cours.code_cours 	= cours_professeur.code_cours 
	AND referentiel.code_filiere = filiere.code_filiere
	AND referentiel.code_niveau = niveau.code_niveau 
	AND cours_professeur.code_prof='$code_prof'
	AND referentiel.code_semestre = '$semestre'
	AND referentiel.annee_universitaire='$annee'";
	$q = $bdd->query($query);
	return $q->fetchall();
}

function loginStud(){
	global $bdd;
	$login = $_GET['login-e'];
	$password = $_GET['password-e'];

	$recruiter = $bdd->query("SELECT * FROM etudiant where email_etudiant='$login' and password_etudiant ='$password'" );
	foreach ($recruiter->fetchall() as $data) {
		$_SESSION['email_etudiant'] = $data['email_etudiant'];
		$_SESSION['type_user'] = "stud";
		echo '?page=e_notes';
	}/*
	else {
		echo '<div class="alert alert-danger"><strong>Error!</strong> Données Incorrectes </div>';
	}/*/
}

function loginProf(){
	global $bdd;
	$login = $_GET['login-p'];
	$password = $_GET['password-p'];
	$semestre = $_GET['semestre'];
	$annee_universitaire = $_GET['annee'];
	

	$recruiter = $bdd->query("SELECT * FROM professeur where email_prof='$login' and password_prof ='$password'" );
	foreach ($recruiter->fetchall() as $data) {
		$_SESSION['code_prof'] = $data['code_prof'];
		$_SESSION['type_user'] = "prof";
		$_SESSION['semestre'] = $semestre;
		$_SESSION['annee'] = $annee_universitaire;

		echo '?page=p_notes';
	}/*
	else {
		echo '<div class="alert alert-danger"><strong>Error!</strong> Données Incorrectes </div>';
	}/*/
}

function logout(){
	session_destroy();
	echo 'index.php';
}

function getSelectedSemester(){
	return $_SESSION['semestre'];
}

function getSelectedAnneeUniversitaire(){
	return $_SESSION['annee'];
}

function getConnectedUserType(){
	return $_SESSION['type_user'];
}

function getNomPrenomConnectedUser(){
	global $bdd;
	if (getConnectedUserType() == "prof") {
		$code_prof = $_SESSION['code_prof'];
		$query = "SELECT * FROM professeur WHERE code_prof='$code_prof'";
		$q = $bdd->query($query);
		$result = $q->fetch();
		return strtoupper($result['nom_prof'])." ".ucwords($result['prenom_prof']);
	}
	else if (getConnectedUserType() == "stud") {
		$email_etudiant = $_SESSION['email_etudiant'];
		$query = "SELECT * FROM etudiant WHERE email_etudiant='$email_etudiant'";
		$q = $bdd->query($query);
		$result = $q->fetch();
		return strtoupper($result['nom_etudiant'])." ".ucwords($result['prenom_etudiant']);
	}
}

function getConnectedUser(){
	global $bdd;

	if (getConnectedUserType() == "prof") {
		$code_prof = $_SESSION['code_prof'];
		$query = "SELECT * FROM professeur WHERE code_prof='$code_prof'";
		$q = $bdd->query($query);
		$result = $q->fetch();
		return $result;
	}
	else if (getConnectedUserType() == "stud") {
		$email_etudiant = $_SESSION['email_etudiant'];
		$query = "SELECT * FROM etudiant WHERE email_etudiant='$email_etudiant'";
		$q = $bdd->query($query);
		$result = $q->fetch();
		return $result;
	}
}

function getConnectedUserProfile(){
	global $bdd;
	if (getConnectedUserType() == "prof") {
		$result = getConnectedUser();
		$content = 
		"<tr><td>Nom : </td><td>".ucwords($result['nom_prof'])."</td></tr>
		<tr><td>Prenom : </td><td>".ucwords($result['prenom_prof'])."</td></tr>
		<tr><td>Email : </td><td>".$result['email_prof']."</td></tr>
		<tr><td>Mot de passe : </td><td>********</td></tr>";
		return $content;
	}
	else if (getConnectedUserType() == "stud") {
		$result = getConnectedUser();
		$content = 
		"<tr><td>Nom : </td><td>".ucwords($result['nom_etudiant'])."</td></tr>
		<tr><td>Prenom : </td><td>".ucwords($result['prenom_etudiant'])."</td></tr>
		<tr><td>Email : </td><td>".$result['email_etudiant']."</td></tr>
		<tr><td>Telephonne : </td><td>".$result['tel_etudiant']."</td></tr>
		<tr><td>Mot de passe : </td><td>********</td></tr>";
		return $content;
	}
}


function getConncectedUserInfo(){
	global $bdd;

	if (getConnectedUserType() == "prof") {
		$code_prof = $_SESSION['code_prof'];
		$query = "SELECT * FROM professeur WHERE code_prof='$code_prof'";
		$q = $bdd->query($query);
		$r = $q->fetch();
		return json_encode($r);
	}
	else if (getConnectedUserType() == "stud") {
		$email_etudiant = $_SESSION['email_etudiant'];
		$query = "SELECT * FROM etudiant WHERE email_etudiant='$email_etudiant'";
		$q = $bdd->query($query);
		$r = $q->fetch();
		return json_encode($r);
	}
}

function modifierUserProfile(){
	global $bdd;
	$id_user = $_SESSION['id_user'];

	if (($_GET['radio'] == "no")) {
		if (!empty($_GET['nom_user']) && !empty($_GET['prenom_user']) && !empty($_GET['tel_user']) && !empty($_GET['user_mail'])) {
			$nom_manager = $_GET['nom_user'];
			$prenom_manager = $_GET['prenom_user'];
			$email_manager = $_GET['user_mail'];
			$tel_manager = $_GET['tel_user'];

			$query = "UPDATE manager SET nom_manager='$nom_manager', prenom_manager='$prenom_manager', email_manager='$email_manager', tel_manager='$tel_manager' WHERE id_user='$id_user'";

			$stmt = $bdd->prepare($query);

			$stmt->execute();
			$reponse = 'ok';
		}
		else{
			$reponse = 'Certains champs sont vides';
		}
	}
	else if (($_GET['radio'] == "yes")) {
		if (!empty($_GET['nom_user']) && !empty($_GET['prenom_user']) && !empty($_GET['tel_user']) && !empty($_GET['user_mail']) && !empty($_GET['user_pass']) && !empty($_GET['new_pass_1']) && !empty($_GET['new_pass_2'])) {
			$nom_manager = $_GET['nom_user'];
			$prenom_manager = $_GET['prenom_user'];
			$email_manager = $_GET['user_mail'];
			$tel_manager = $_GET['tel_user'];
			$manager_pass = $_GET['user_pass'];
			$new_pass_1 = $_GET['new_pass_1'];
			$new_pass_2 = $_GET['new_pass_2'];

			if (!empty($_GET['user_pass'])){
				$query = "SELECT * FROM users WHERE id_user='$id_user'";
				$q = $bdd->query($query);
				$result = $q->fetch();
				if ($manager_pass == $result['password']) {
					$val = 'ok';
				}
				else{
					$val = 'Mot de passe actuel : FAUX !';
				}
			}
			if ($val == "ok") {
				if ($new_pass_1 == $new_pass_2) {
					$query1 = "UPDATE manager SET nom_manager='$nom_manager', prenom_manager='$prenom_manager', email_manager='$email_manager', tel_manager='$tel_manager' WHERE id_user='$id_user'";
					$stmt1 = $bdd->prepare($query1);
					$stmt1->execute();

					$query2 = "UPDATE users SET password='$new_pass_1' WHERE id_user='$id_user'";
					$stmt2 = $bdd->prepare($query2);
					$stmt2->execute();

					$reponse = 'ok';
				}
				else{
					$reponse = 'Nouveau Mot de passe a verifier !';
				}
			}
			else{
				$reponse = $val;
			}		
		}
		else{
			$reponse = 'Certains champs sont vides';
		}
	}
	else{
		$reponse = 'Choix de modification du mot de passe';
	}
	echo json_encode(['reponse' => $reponse]);
}
function checkUserPass(){
	global $bdd;
	$id_user = $_SESSION['id_user'];
	if (!empty($_GET['user_pass'])){
		$query = "SELECT * FROM users WHERE id_user='$id_user'";
		$q = $bdd->query($query);
		$result = $q->fetch();
		if ($_GET['user_pass'] == $result['password']) {
			$reponse = 'ok';
		}
		else{
			$reponse = 'Mot de passe actuel : FAUX !';
		}
	}
	else{
		$reponse = 'Saisssez le mot de passe actuel';
	}
	echo json_encode(['reponse' => $reponse]);
}

function getCodeElementModuleOfCourse($id_cours){
	global $bdd;
	$query = "SELECT code_element_module FROM cours WHERE code_cours='$id_cours' ";
	$q = $bdd->query($query);
	$r = $q->fetch();
	$code_element_module = $r['code_element_module'];

	return $code_element_module;
}

function getCodeReferentielOfCourse($id_cours){
	global $bdd;
	$query = "SELECT code_referentiel FROM cours WHERE code_cours='$id_cours' ";
	$q = $bdd->query($query);
	$r = $q->fetch();
	$code_referentiel = $r['code_referentiel'];

	return $code_referentiel;
}


function getAllTypeOfTests($selectedCourse){
	global $bdd;

	$code_element_module = getCodeElementModuleOfCourse($selectedCourse);
	$code_referentiel = getCodeReferentielOfCourse($selectedCourse);

	$query = "SELECT libelle_type_test, code_type_test FROM type_test ORDER BY code_type_test DESC";
	$q = $bdd->query($query);
	$codeTestWin = array();
	$libelleTestWin = array();
	while ($r = $q->fetch()) {
		$CodeTestCandidat = $r['code_type_test'];
		$libelle = $r['libelle_type_test'];
		$etat = checkIfTestAlreadyDefined($CodeTestCandidat, $code_referentiel, $code_element_module);

		if ($etat == 0) {
			array_push($codeTestWin, $CodeTestCandidat);
			array_push($libelleTestWin, $libelle);
		}
		$reste = checkRestPourcentage($code_referentiel, $code_element_module);
	}
	//return json_encode($codeTestWin,$libelleTestWin);['reponse' => $reponse]
	return json_encode(['0' => $codeTestWin, '1' => $libelleTestWin, '2' => $reste]);
}


function checkIfTestAlreadyDefined($codeToTest, $ref, $elem){
	global $bdd;

	$query = "SELECT * FROM referenciel_evaluation 
	WHERE code_referentiel='$ref' 
	AND code_element_module='$elem' 
	AND code_type_test='$codeToTest'";
	$q = $bdd->query($query);
	$count = $q->rowCount();
	return $count;
}

function getNumberOfTestAlreadyPassed($id_cours){
	global $bdd;

	$elem = getCodeElementModuleOfCourse($id_cours);
	$ref = getCodeReferentielOfCourse($id_cours);
	
	$query = "SELECT * FROM referenciel_evaluation 
	WHERE code_referentiel='$ref' 
	AND code_element_module='$elem'";
	$q = $bdd->query($query);
	$count = $q->rowCount();
	return $count;
}

function checkRestPourcentage($ref, $elem){
	global $bdd;
	$reste = 100;

	$query = "SELECT pourcentage_test FROM referenciel_evaluation 
	WHERE code_referentiel='$ref' 
	AND code_element_module='$elem'";
	$q = $bdd->query($query);
	while ($r = $q->fetch()) {
		$reste = $reste - $r['pourcentage_test'];
	}

	return $reste;
}

function addTestToDatabase($selectedCourse, $testToAdd, $pourcentage){
	global $bdd;

	$code_element_module = getCodeElementModuleOfCourse($selectedCourse);
	$code_referentiel = getCodeReferentielOfCourse($selectedCourse);

	if (checkRestPourcentage($code_referentiel, $code_element_module) >= $pourcentage) {
		try {
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$bdd->beginTransaction();



			$add1 = "INSERT INTO `referenciel_evaluation` (`code_referentiel`, `code_element_module`, `code_type_test`, `pourcentage_test`) 
			VALUES('$code_referentiel','$code_element_module','$testToAdd','$pourcentage')";
			$stmt1 = $bdd->prepare($add1);
			$stmt1->execute();


			$query = "SELECT etudiant.nom_etudiant, etudiant.email_etudiant
			FROM cours, cours_groupe, classe_groupe, groupe_etudiant, etudiant
			WHERE cours.code_cours = cours_groupe.code_cours
			AND cours_groupe.code_classe_groupe = classe_groupe.code_classe_groupe
			AND classe_groupe.code_classe_groupe = groupe_etudiant.code_classe_groupe
			AND groupe_etudiant.code_referentiel = cours.code_referentiel
			AND groupe_etudiant.email_etudiant = etudiant.email_etudiant
			AND cours.code_cours='$selectedCourse'
			ORDER BY etudiant.nom_etudiant ASC";
			$q = $bdd->query($query);
			while ($r = $q->fetch()) {
				$email = $r['email_etudiant'];
				$note = 0;

				$add2 = "INSERT INTO `note` (`code_cours`, `code_type_test`, `email_etudiant`, `note`) 
				VALUES('$selectedCourse','$testToAdd','$email', '$note')";
				$stmt2 = $bdd->prepare($add2);
				$stmt2->execute();
			}

			$reponse = 'ok';
			$bdd->commit();
		}
		catch (Exception $e) {
			$bdd->rollBack();
			$reponse = "Failed : ".$e->getMessage();
		}
	}
	else {
		$re = checkRestPourcentage($code_referentiel, $code_element_module);
		$reponse = 'Le pourcentage à saisir doit etre inférieur à '.$re.'%';
	}

	echo json_encode(['reponse' => $reponse]);
}

function updateTestPourcentage($selectedCourse, $newTest, $pourcentage, $oldTest){
	global $bdd;

	$code_element_module = getCodeElementModuleOfCourse($selectedCourse);
	$code_referentiel = getCodeReferentielOfCourse($selectedCourse);

	$reste = checkRestPourcentage($code_referentiel, $code_element_module);
	$old_obj = getAllInfoAbtoutThisTest3($selectedCourse, $oldTest);
	$old_pourc = $old_obj['pourcentage_test'];
	$new_pourcentage = ($old_pourc + $reste );

	if ($new_pourcentage >= $pourcentage) {
		try {
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$bdd->beginTransaction();

			$qrADD = "UPDATE referenciel_evaluation 
			SET pourcentage_test='$pourcentage', code_type_test='$newTest'
			WHERE code_element_module='$code_element_module' 
			AND code_referentiel='$code_referentiel' 
			AND code_type_test='$oldTest'";

			$stmt = $bdd->prepare($qrADD);
			$stmt->execute();

			$reponse = 'ok';
			$bdd->commit();
		}
		catch (Exception $e) {
			$bdd->rollBack();
			$reponse = "Failed : ".$e->getMessage();
		}
	}
	else {
		$re = checkRestPourcentage($code_referentiel, $code_element_module);
		$reponse = 'Le pourcentage doit etre inférieur à '.$new_pourcentage.'%';
	}

	echo json_encode(['reponse' => $reponse]);
}

function updateTestPropertiesDelAll($selectedCourse, $newTest, $pourcentage, $oldTest){
	global $bdd;

	$code_element_module = getCodeElementModuleOfCourse($selectedCourse);
	$code_referentiel = getCodeReferentielOfCourse($selectedCourse);

	$reste = checkRestPourcentage($code_referentiel, $code_element_module);
	$old_obj = getAllInfoAbtoutThisTest3($selectedCourse, $oldTest);
	$old_pourc = $old_obj['pourcentage_test'];
	$new_pourcentage = ($old_pourc + $reste );

	if ($new_pourcentage >= $pourcentage) {
		try {
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$bdd->beginTransaction();

			$qrADD = "UPDATE referenciel_evaluation 
			SET pourcentage_test='$pourcentage', code_type_test='$newTest'
			WHERE code_element_module='$code_element_module' 
			AND code_referentiel='$code_referentiel' 
			AND code_type_test='$oldTest'";

			$stmt = $bdd->prepare($qrADD);
			$stmt->execute();

			$qrDel = "UPDATE note 
			SET code_type_test='$newTest'
			WHERE code_cours='$selectedCourse' 
			AND code_type_test='$oldTest'";

			$stmt2 = $bdd->prepare($qrDel);
			$stmt2->execute();

			$reponse = 'ok';
			$bdd->commit();
		}
		catch (Exception $e) {
			$bdd->rollBack();
			$reponse = "Failed : ".$e->getMessage();
		}
	}
	else {
		$re = checkRestPourcentage($code_referentiel, $code_element_module);
		$reponse = 'Le pourcentage doit etre inférieur à '.$new_pourcentage.'%';
	}

	echo json_encode(['reponse' => $reponse]);
}

function getAllInfoAbtoutThisTest3($id_cours, $code_test){
	global $bdd;

	$elem = getCodeElementModuleOfCourse($id_cours);
	$ref = getCodeReferentielOfCourse($id_cours);

	$query = "SELECT * FROM referenciel_evaluation
	WHERE code_referentiel='$ref' 
	AND code_element_module='$elem'
	AND code_type_test='$code_test'";
	$q = $bdd->query($query);
	$infoTest = $q->fetch();

	return $infoTest;
}

function getStudentFollowingThisCourse($id_cours){
	global $bdd;

	$nbrEpreuve = getNumberOfTestAlreadyPassed($id_cours);
	$infoTest = getInfoTestAlreadyAdded($id_cours);

	$query = "SELECT etudiant.nom_etudiant, etudiant.prenom_etudiant
	FROM cours, cours_groupe, classe_groupe, groupe_etudiant, etudiant
	WHERE cours.code_cours = cours_groupe.code_cours
	AND cours_groupe.code_classe_groupe = classe_groupe.code_classe_groupe
	AND classe_groupe.code_classe_groupe = groupe_etudiant.code_classe_groupe
	AND groupe_etudiant.code_referentiel = cours.code_referentiel
	AND groupe_etudiant.email_etudiant = etudiant.email_etudiant
	AND cours.code_cours='$id_cours'
	ORDER BY etudiant.nom_etudiant ASC";
	$q = $bdd->query($query);
	$r = $q->fetchall();
	return json_encode(['0' => $r,'nbrEpreuve' => $nbrEpreuve, 'infoTest' => $infoTest]);
}

function getNbrStudentFollowingThisCourse($id_cours){
	global $bdd;

	$nbrEpreuve = getNumberOfTestAlreadyPassed($id_cours);
	$infoTest = getInfoTestAlreadyAdded($id_cours);

	$query = "SELECT etudiant.nom_etudiant, etudiant.prenom_etudiant, etudiant.email_etudiant
	FROM cours, cours_groupe, classe_groupe, groupe_etudiant, etudiant
	WHERE cours.code_cours = cours_groupe.code_cours
	AND cours_groupe.code_classe_groupe = classe_groupe.code_classe_groupe
	AND classe_groupe.code_classe_groupe = groupe_etudiant.code_classe_groupe
	AND groupe_etudiant.code_referentiel = cours.code_referentiel
	AND groupe_etudiant.email_etudiant = etudiant.email_etudiant
	AND cours.code_cours='$id_cours'
	ORDER BY etudiant.nom_etudiant ASC";
	$q = $bdd->query($query);
	$r = $q->fetchall();
	$count = $q->rowCount();
	return json_encode(['NomComplet' => $r,'nbrEpreuve' => $nbrEpreuve, 'infoTest' => $infoTest, 'RealNbr_e' => $count]);
}

function getNbrStudentFollowingThisCourseCSV($id_cours){
	global $bdd;


	$query = "SELECT etudiant.nom_etudiant, etudiant.prenom_etudiant, etudiant.email_etudiant
	FROM cours, cours_groupe, classe_groupe, groupe_etudiant, etudiant
	WHERE cours.code_cours = cours_groupe.code_cours
	AND cours_groupe.code_classe_groupe = classe_groupe.code_classe_groupe
	AND classe_groupe.code_classe_groupe = groupe_etudiant.code_classe_groupe
	AND groupe_etudiant.code_referentiel = cours.code_referentiel
	AND groupe_etudiant.email_etudiant = etudiant.email_etudiant
	AND cours.code_cours='$id_cours'
	ORDER BY etudiant.nom_etudiant ASC";
	$q = $bdd->query($query);
	$r = $q->fetchall();
	return $r;
}

function getInfoTestAlreadyAdded($id_cours){
	global $bdd;

	$elem = getCodeElementModuleOfCourse($id_cours);
	$ref = getCodeReferentielOfCourse($id_cours);
	
	$query = "SELECT referenciel_evaluation.code_type_test, referenciel_evaluation.pourcentage_test, type_test.libelle_type_test, type_test.code_type_test FROM referenciel_evaluation, type_test
	WHERE referenciel_evaluation.code_type_test = type_test.code_type_test
	AND code_referentiel='$ref' 
	AND code_element_module='$elem' 
	ORDER BY type_test.code_type_test";
	$q = $bdd->query($query);
	$r = $q->fetchall();

	return json_encode($r);
}


function getAllInfoAbtoutThisTest($id_cours, $id_test){
	global $bdd;

	$elem = getCodeElementModuleOfCourse($id_cours);
	$ref = getCodeReferentielOfCourse($id_cours);

	$id_test = ($id_test-1);
	
	$query = "SELECT * FROM referenciel_evaluation, type_test
	WHERE referenciel_evaluation.code_type_test = type_test.code_type_test
	AND code_referentiel='$ref' 
	AND code_element_module='$elem'
	LIMIT 1 OFFSET $id_test";
	$q = $bdd->query($query);
	$infoTest = $q->fetchall();

	$type_test = $infoTest[0]['code_type_test'];

	$query2 = "SELECT etudiant.nom_etudiant, etudiant.prenom_etudiant, etudiant.code_etudiant, note.note
	FROM cours, etudiant, note, type_test
	WHERE cours.code_cours = note.code_cours
	AND type_test.code_type_test = note.code_type_test
	AND etudiant.email_etudiant = note.email_etudiant
	AND cours.code_cours='$id_cours'
	AND note.code_type_test='$type_test'
	ORDER BY etudiant.nom_etudiant ASC";

	$q2 = $bdd->query($query2);
	$noteOfThatTest = $q2->fetchall();

	return json_encode(['infoTest' => $infoTest, 'noteOfThatTest' => $noteOfThatTest]);
}

function getAllInfoAbtoutThisTest2($id_cours, $code_test){
	global $bdd;

	$elem = getCodeElementModuleOfCourse($id_cours);
	$ref = getCodeReferentielOfCourse($id_cours);

	
	$query = "SELECT * FROM referenciel_evaluation, type_test
	WHERE referenciel_evaluation.code_type_test = type_test.code_type_test
	AND code_referentiel='$ref' 
	AND code_element_module='$elem'
	AND type_test.code_type_test='$code_test'";
	$q = $bdd->query($query);
	$infoTest = $q->fetchall();

	$query2 = "SELECT etudiant.nom_etudiant, etudiant.prenom_etudiant, note.note, etudiant.code_etudiant
	FROM cours, etudiant, note, type_test
	WHERE cours.code_cours = note.code_cours
	AND type_test.code_type_test = note.code_type_test
	AND etudiant.email_etudiant = note.email_etudiant
	AND cours.code_cours='$id_cours'
	AND note.code_type_test='$code_test'
	ORDER BY etudiant.nom_etudiant ASC";

	$q2 = $bdd->query($query2);
	$noteOfThatTest = $q2->fetchall();

	return json_encode(['infoTest' => $infoTest, 'noteOfThatTest' => $noteOfThatTest]);
}

function removeMarksofThisTest($id_cours, $code_test){
	global $bdd;
	try {
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$bdd->beginTransaction();

		$elem = getCodeElementModuleOfCourse($id_cours);
		$ref = getCodeReferentielOfCourse($id_cours);
		$note = "";

		$qr2 = "UPDATE note 
		SET note='$note'
		WHERE code_cours='$id_cours'
		AND code_type_test='$code_test'";
		$stmt2 = $bdd->prepare($qr2);
		$stmt2->execute();

		$reponse = 'ok';
		$bdd->commit();
	}
	catch (Exception $e) {
		$bdd->rollBack();
		$reponse = "Failed : ".$e->getMessage();
	}
	echo json_encode(['reponse' => $reponse]);
}
function deleteThisTest($id_cours, $code_test){
	global $bdd;
	try {
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$bdd->beginTransaction();

		$elem = getCodeElementModuleOfCourse($id_cours);
		$ref = getCodeReferentielOfCourse($id_cours);


		$qr2 = "DELETE FROM `note` 
		WHERE code_type_test='$code_test' 
		AND code_cours='$id_cours'";
		$stmt2 = $bdd->prepare($qr2);
		$stmt2->execute();

		$qr3 = "DELETE FROM `referenciel_evaluation` 
		WHERE code_type_test='$code_test' 
		AND code_referentiel='$ref' 
		AND code_element_module='$elem'";
		$stmt3 = $bdd->prepare($qr3);
		$stmt3->execute();

		$reponse = 'ok';
		$bdd->commit();
	}
	catch (Exception $e) {
		$bdd->rollBack();
		$reponse = "Failed : ".$e->getMessage();
	}
	echo json_encode(['reponse' => $reponse]);
}

function addNoteStudentToDatabase($selectedCourse){
	global $bdd;

	$code_type_test = $_GET['code_type_test'];

	// Get students Following the course

	$query = "SELECT etudiant.email_etudiant, etudiant.code_etudiant, etudiant.nom_etudiant, etudiant.prenom_etudiant
	FROM cours, cours_groupe, classe_groupe, groupe_etudiant, etudiant
	WHERE cours.code_cours = cours_groupe.code_cours
	AND cours_groupe.code_classe_groupe = classe_groupe.code_classe_groupe
	AND classe_groupe.code_classe_groupe = groupe_etudiant.code_classe_groupe
	AND groupe_etudiant.code_referentiel = cours.code_referentiel
	AND groupe_etudiant.email_etudiant = etudiant.email_etudiant
	AND cours.code_cours='$selectedCourse'
	ORDER BY etudiant.nom_etudiant ASC";
	$q = $bdd->query($query);
	while($r = $q->fetch()){
		$code_etudiant = $r['code_etudiant'];
		$emailofThatStudent = $r['email_etudiant'];
		$noteOfThatStudent = $_GET['noteStud'.$code_etudiant];

		if (!isset($noteOfThatStudent) || $noteOfThatStudent == "") {
			$reponse = 'Veuillez verifier tout les champs !';
		}

		else{
			if ($noteOfThatStudent > 20 || $noteOfThatStudent < 0) {
				$reponse = 'Veuillez verifier la note de l\'etudiant(e) : <strong>'.strtoupper($r['nom_etudiant']).' '.strtoupper($r['prenom_etudiant']). '</strong>. La note doit etre entre 0 et 20' ;
				break;
			}
			else{
				try {
					$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$bdd->beginTransaction();

					$qrADD = "UPDATE note 
					SET note='$noteOfThatStudent'
					WHERE code_cours='$selectedCourse'
					AND code_type_test='$code_type_test' 
					AND email_etudiant='$emailofThatStudent'";

					$stmt = $bdd->prepare($qrADD);
					$stmt->execute();
					
					$reponse = 'ok';
					$bdd->commit();
				}
				catch (Exception $e) {
					$bdd->rollBack();
					$reponse = "Failed : ".$e->getMessage();
				}
			}
		}


		
	}

	echo json_encode(['reponse' => $reponse]);
}

function getDataAboutThisTestToModify($id_cours, $selected_cours){
	global $bdd;

	$code_element_module = getCodeElementModuleOfCourse($id_cours);
	$code_referentiel = getCodeReferentielOfCourse($id_cours);

	$query = "SELECT libelle_type_test, code_type_test FROM type_test ORDER BY code_type_test DESC";
	$q = $bdd->query($query);
	$codeTestWin = array();
	$libelleTestWin = array();
	while ($r = $q->fetch()) {
		$CodeTestCandidat = $r['code_type_test'];
		$libelle = $r['libelle_type_test'];
		$etat = checkIfTestAlreadyDefined($CodeTestCandidat, $code_referentiel, $code_element_module);

		if ($etat == 0) {
			array_push($codeTestWin, $CodeTestCandidat);
			array_push($libelleTestWin, $libelle);
		}
		$reste = checkRestPourcentage($code_referentiel, $code_element_module);
	}


	$query3 = "SELECT type_test.code_type_test, type_test.libelle_type_test, referenciel_evaluation.pourcentage_test 
	FROM type_test, referenciel_evaluation
	WHERE type_test.code_type_test=referenciel_evaluation.code_type_test
	AND referenciel_evaluation.code_type_test='$selected_cours' 
	AND referenciel_evaluation.code_referentiel='$code_referentiel'
	AND referenciel_evaluation.code_element_module='$code_element_module'";
	$q3 = $bdd->query($query3);
	$r3 = $q3->fetch();

	return json_encode(['0' => $codeTestWin, '1' => $libelleTestWin, '2' => $reste, '3' => $r3]);
}




function getSessionParam(){

	$semestre = $_SESSION['semestre'];
	$annee_universitaire = $_SESSION['annee'];
	$allAnnee = getAllAnneeUniversitaire();

	return json_encode(['annee' => $annee_universitaire, 'semestre' => $semestre, 'allAnnee' => $allAnnee]);
}

function updateSessionParams($year, $semestre){
	$_SESSION['semestre'] = $semestre;
	$_SESSION['annee'] = $year;

	$reponse = "ok";

	echo json_encode(['reponse' => $reponse]);
}


function getMoyenneOfThisCourse($id_cours){
	global $bdd;

	$code_element_module = getCodeElementModuleOfCourse($id_cours);
	$code_referentiel = getCodeReferentielOfCourse($id_cours);

	$restePourcentage = checkRestPourcentage($code_referentiel, $code_element_module);
	$moyenne = array();

	if ($restePourcentage == 0) {
		$tmp=0;

		$query1 = "SELECT etudiant.code_etudiant, etudiant.nom_etudiant, etudiant.email_etudiant
		FROM cours, cours_groupe, classe_groupe, groupe_etudiant, etudiant
		WHERE cours.code_cours = cours_groupe.code_cours
		AND cours_groupe.code_classe_groupe = classe_groupe.code_classe_groupe
		AND classe_groupe.code_classe_groupe = groupe_etudiant.code_classe_groupe
		AND groupe_etudiant.code_referentiel = cours.code_referentiel
		AND groupe_etudiant.email_etudiant = etudiant.email_etudiant
		AND cours.code_cours='$id_cours'
		ORDER BY etudiant.nom_etudiant ASC";
		$q1 = $bdd->query($query1);
		while ($stud = $q1->fetch()) {
			$etudiant = $stud['email_etudiant'];
			$tmp = 0;

			$query2 = "SELECT referenciel_evaluation.code_type_test, referenciel_evaluation.pourcentage_test FROM referenciel_evaluation, type_test
			WHERE referenciel_evaluation.code_type_test = type_test.code_type_test
			AND code_referentiel='$code_referentiel' 
			AND code_element_module='$code_element_module' 
			ORDER BY type_test.code_type_test";
			$q2 = $bdd->query($query2);

			while ($typeT = $q2->fetch()) {

				$code_test = $typeT['code_type_test'];
				$porc_test = $typeT['pourcentage_test'];

				$query3 = "SELECT note FROM note
				WHERE code_cours = '$id_cours'
				AND code_type_test='$code_test'
				AND email_etudiant='$etudiant'";
				$q3 = $bdd->query($query3);
				$r3 = $q3->fetch();

				$note = $r3['note'];
				$tmp += $note * ($porc_test / 100 );

			}
			array_push($moyenne, round($tmp, 2));
		}
	}


	return json_encode(['restePourcentage' => $restePourcentage , 'moyenne' => $moyenne]);
}






function checkEmails($db_e, $excel_e){
	for ($i=0; $i < count($db_e); $i++) {
		if ($db_e[$i] != $excel_e[$i]) {
			return false;
		}
	}

	return "ok";
}































//::::::::::::::::::::MA PARTIE::::::::::::::::::::


function getReferencielsOfEtudiant(){
	global $bdd;
	$code_etudiant = $_SESSION['email_etudiant'];
	$query = "
	SELECT * FROM referenciel_etudiant  
	WHERE email_etudiant = '$code_etudiant'";
	$q = $bdd->query($query);
	return $q->fetchall();
}

function getSemestresOfEtudiant($code_referentiel){
	global $bdd;
	$query = "
	SELECT * FROM referentiel NATURAL JOIN filiere NATURAL JOIN niveau NATURAL JOIN annee_universitaire NATURAL JOIN semestre
	WHERE code_referentiel = '$code_referentiel'";
	$q = $bdd->query($query);
	return $q->fetchall();
}


function getElementModuleOfReferentiel($code_referentiel){
	global $bdd;
	
	$query = "
	SELECT * FROM `referenciel_evaluation` NATURAL JOIN element_module NATURAL JOIN type_test 
	WHERE code_referentiel = '$code_referentiel' ORDER BY titre_element_module" ;
	
	$q = $bdd->query($query);
	$r = $q->fetchall();

	return json_encode($r);
}


function getElementModuleOfReferentiel2($code_referentiel){
	global $bdd;
	
	$tab=array();
	
	$query = "
	SELECT * FROM `referenciel_evaluation` NATURAL JOIN element_module NATURAL JOIN type_test 
	WHERE code_referentiel = '$code_referentiel' ORDER BY titre_element_module" ;
	
	$q = $bdd->query($query);
	$r = $q->fetchall();
	$r = json_encode($r);

	$tab[0]=$r;
	
	return $tab;
}

function getCoursOfEtudiant($code_referentiel){
	global $bdd;

	$r = getElementModuleOfReferentiel2($code_referentiel);

	$tableau_titre_elements_modules = array();
	$tableau_coeff_element_module = array();
	$tableau_libelle_type_test = array();
	$tableau_elements_modules = array();
	$tableau_pourcentages_test = array();
	$tableau_code_type_test = array();

	$s=json_decode($r[0],true);

	$j=count($s)-1;

	foreach ($s as $i) {

		array_push($tableau_elements_modules,$s[$j]['code_element_module']);
		array_push($tableau_pourcentages_test, $s[$j]['pourcentage_test']);
		array_push($tableau_code_type_test, $s[$j]['code_type_test']);
		array_push($tableau_titre_elements_modules, $s[$j]['titre_element_module']);
		array_push($tableau_coeff_element_module, $s[$j]['coeff_element_module']);
		array_push($tableau_libelle_type_test, $s[$j]['libelle_type_test']);
		$j--;
	}


	$tableau_cours=array();

	foreach ($tableau_elements_modules as $i) {
    	$element_module=$i;

   		$query = "
		SELECT * FROM cours
		WHERE code_referentiel = '$code_referentiel' AND code_element_module = '$element_module'";

		$q = $bdd->query($query);

		$r=$q->fetch();
		
		array_push($tableau_cours, $r['code_cours']);
	}
	
	$tableau_general = array();
	$tableau_general['elements_modules'] = array();
	$tableau_general['pourcentages_test'] = array();
	$tableau_general['code_type_test'] = array();
	$tableau_general['cours'] = array();
	$tableau_general['titre_elements_modules'] = array();
	$tableau_general['coeff_element_module'] = array();
	$tableau_general['libelle_type_test'] = array();

	array_push($tableau_general['elements_modules'],$tableau_elements_modules);
	array_push($tableau_general['pourcentages_test'],$tableau_pourcentages_test);
	array_push($tableau_general['code_type_test'],$tableau_code_type_test);
	array_push($tableau_general['cours'],$tableau_cours);
	array_push($tableau_general['titre_elements_modules'],$tableau_titre_elements_modules);
	array_push($tableau_general['coeff_element_module'],$tableau_coeff_element_module);
	array_push($tableau_general['libelle_type_test'],$tableau_libelle_type_test);
	return $tableau_general;
}


function getNotesOfEtudiant($code_referentiel){

	global $bdd;


	$tableau_general = array();
	$tableau_general = getCoursOfEtudiant($code_referentiel);
	$email = $_SESSION['email_etudiant'];
	$tableau_general['notes'] = array();
	$tab=array();
	$p=0;

	foreach ($tableau_general['cours'][0] as $i) {
    	$code_cours=$i;
    	$type_test=$tableau_general['code_type_test'][0][$p];
    	$p++;

   		$query = "
		SELECT * FROM note
		WHERE code_cours = '$code_cours' AND code_type_test = '$type_test' AND email_etudiant = '$email'";

		$q = $bdd->query($query);

		$r=$q->fetch();
		
		array_push($tab, $r['note']);
	}

	array_push($tableau_general['notes'],$tab);

	//Calcule des moyennes secondaires par rapport à leurs pourcentages

	$tableau_general['moyenneSecondaire'] = array();

	$module = $tableau_general['elements_modules'][0][0];

	$module_notes = array();
	$module_pourcentages = array();
	$tableau_coeff = array();
	$i=0;
	foreach ($tableau_general['notes'][0] as $note) {

		if ($tableau_general['elements_modules'][0][$i]==$module) {

			array_push($module_notes, $tableau_general['notes'][0][$i]);
			array_push($module_pourcentages, $tableau_general['pourcentages_test'][0][$i]);
		
		}
		if ($tableau_general['elements_modules'][0][$i]!= $module || $i== count($tableau_general['notes'][0])-1) {
			$module = $tableau_general['elements_modules'][0][$i];
			array_push($tableau_coeff,$tableau_general['coeff_element_module'][0][$i-1]);
			$tableau_temp=moyenneSec($module_notes,$module_pourcentages);
			
			array_push($tableau_general['moyenneSecondaire'],$tableau_temp);
			$module_notes = array();
			$module_pourcentages = array();
			array_push($module_notes, $tableau_general['notes'][0][$i]);
			array_push($module_pourcentages, $tableau_general['pourcentages_test'][0][$i]);
		}
		
		$i++;
	}

	//calcule de la moyenne generale !

		$tableau_general['moyenneGenerale'] = array();

		$temp = moyenneGenerale($tableau_general['moyenneSecondaire'],$tableau_coeff);

		array_push($tableau_general['moyenneGenerale'],$temp);




	return json_encode($tableau_general);
}


function moyenneSec($tableau,$pourcentage){
	$r=0;
	$k=0;

	foreach ($tableau as $i) {

		$r = $r + ($i * ($pourcentage[$k]/100));
		
		$k++;
	}

	$r=$r;

	return round($r,3);
}

function moyenneGenerale($notes,$coeff){
	$r=0;
	$k=0;
	$total=0;
	foreach ($notes as $i) {

		$total = $total + $coeff[$k];
		$r = $r + ($i * ($coeff[$k]));
		
		$k++;
	}

	$r=$r/$total;
	return round($r,3);
}



////::::::::::::::::::::   FIN  ::::::::::::::::::::



?>


