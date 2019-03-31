<?php 

include 'functions.php';

// loginEtudiant
if ($_GET['action'] == 'loginStud'  && !empty($_GET['login-e']) && !empty($_GET['password-e']) ) {
	loginStud($_GET['login-e'],$_GET['password-e']);
}
// loginProf
elseif ($_GET['action'] == 'loginProf' && !empty($_GET['login-p']) && !empty($_GET['password-p']) && !empty($_GET['semestre']) && !empty($_GET['annee'])) {
	loginProf($_GET['login-p'], $_GET['password-p'], $_GET['semestre'], $_GET['annee']);
}
// logout
elseif ($_GET['action'] == 'logout') {
	logout();
}
// modifierInfoProf
elseif ($_GET['action'] == 'modifierProfileProf') {
	echo getConncectedUserInfo();
}
// modifierInfoEtudiant
elseif ($_GET['action'] == 'modifierProfileStud') {
	echo getConncectedUserInfo();
}







elseif ($_GET['action'] == 'modifierUserProfile'){
	echo modifierUserProfile();
}
elseif ($_GET['action'] == 'checkUserPass'){
	echo checkUserPass();
}






elseif ($_GET['action'] == 'getStudentFollowingThisCourse'){
	echo getStudentFollowingThisCourse($_GET['id_cours']);
}
elseif ($_GET['action'] == 'getAllTypeOfTests'){
	echo getAllTypeOfTests($_GET['selectedCourse']);
}
elseif ($_GET['action'] == 'addTest'){
	echo addTestToDatabase($_GET['selectedCourse'], $_GET['testToAdd'], $_GET['pourcentage']);
}
elseif ($_GET['action'] == 'getNumberOfTestAlreadyPassed'){
	echo getNumberOfTestAlreadyPassed($_GET['id_cours']);
}
elseif ($_GET['action'] == 'getPourcentageOfTestAlreadyPassed'){
	echo getPourcentageOfTestAlreadyPassed($_GET['id_cours']);
}
elseif ($_GET['action'] == 'getAllInfoAbtoutThisTest'){
	echo getAllInfoAbtoutThisTest($_GET['id_cours'], $_GET['id_test']);
}
elseif ($_GET['action'] == 'getAllInfoAbtoutThisTest2'){
	echo getAllInfoAbtoutThisTest2($_GET['id_cours'], $_GET['code_test']);
}

elseif ($_GET['action'] == 'removeMarksofThisTest'){
	echo removeMarksofThisTest($_GET['id_cours'], $_GET['code_type_test']);
}
elseif ($_GET['action'] == 'submitNoteStudent'){
	echo addNoteStudentToDatabase($_GET['selectedCourse']);
}
elseif ($_GET['action'] == 'getDataAboutThisTestToModify'){
	echo getDataAboutThisTestToModify($_GET['code_cours'], $_GET['selected_cours']);
}
elseif ($_GET['action'] == 'updateTestProperties'){
	echo updateTestPourcentage($_GET['selectedCourse'], $_GET['selectedTest'], $_GET['pourcentage'], $_GET['old_test']);
}
elseif ($_GET['action'] == 'updateTestPropertiesDelAll') {
	$res = updateTestPropertiesDelAll($_GET['selectedCourse'], $_GET['selectedTest'], $_GET['pourcentage'], $_GET['old_test']);
}

elseif ($_GET['action'] == 'deleteThisTest'){
	echo deleteThisTest($_GET['selectedCourse'], $_GET['old_test']);
}

elseif ($_GET['action'] == 'getSessionParam'){
	echo getSessionParam();
}
elseif ($_GET['action'] == 'updateSessionParams'){
	echo updateSessionParams($_GET['selectedYear'], $_GET['selectedSemestre']);
}
elseif ($_GET['action'] == 'getMoyenneOfThisCourse'){
	echo getMoyenneOfThisCourse($_GET['selectedCourse']);
}




elseif ($_GET['action'] == 'downloadMarksFile'){
	echo downloadMarksFile($_GET['id_cours']);
}


//::::::::::::::::::::MA PARTIE::::::::::::::::::::
elseif ($_GET['action'] == 'getNotesOfEtudiant'){
	echo getNotesOfEtudiant($_GET['code_referentiel']);
}
//::::::::::::::::::::   FIN   ::::::::::::::::::::






































?>