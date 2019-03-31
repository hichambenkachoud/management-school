

// Afficher PopUP
function setModalBox(title,content,footer){
  document.getElementById('modal-bodyku').innerHTML=content;
  document.getElementById('myModalLabel').innerHTML=title;
  document.getElementById('modal-footerq').innerHTML=footer;
  $('#myModal').attr('class', 'modal fade bs-example-modal-md').attr('aria-labelledby','myLargeModalLabel');
  $('.modal-dialog').attr('class','modal-dialog modal-md');
}

// #btn-viewAddTestForm
$(document.body).on('click', '#btn-viewAddTestForm',  function() {
  var selectedCourse = document.getElementById('coursOfConnectedProf').value;

  var title = 'Ajouter un nouveau test';
  var content = '\
  <div id="messageInfo"></div>\
  <form class="form-horizontal" id="form-addTest">\
  <div class="form-group">\
  <label class="col-md-4 control-label" for="testToAdd">Épreuve</label>\
  <div class="col-md-4">\
  <select id="testToAdd" name="testToAdd" class="form-control" required="">\
  <option value="">------  Select  ------</option>';

  var tmp = "";
  $.ajax({
    url: 'ajax.php?action=getAllTypeOfTests&selectedCourse='+selectedCourse,
    type:'GET',
    success: function(data){
      //console.log(data);
      var json = $.parseJSON(data);
      //console.log(json);
      //console.log(json.length);
      var reste = json[2];
      for (var i = json[0].length - 1; i >= 0; i--) {
        tmp = '<option value="' + json[0][i] + '">' + json[1][i] + '</option>';
        content = content + tmp;
      }
      content = content + '\
      </select>\
      </div>\
      </div>\
      <!-- Text input-->\
      <div class="form-group">\
      <label class="col-md-4 control-label" for="pourcentage">Pourcentage de l\'épreuve</label>\
      <div class="col-md-4">';
      
      if (reste == 0) {
        content = content + '\
        <input id="pourcentage" name="pourcentage" type="number" placeholder="en %" min="0" max="'+reste+'" class="form-control input-md" disabled="">\
        <small class="text-muted" style="color: red;">Reste = 0%</small>\
        </div><div class="col-md-12"><h4><br>Modifier le % des épreuves passées pour ajouter d\'autres épreuves.</h4>';
      }
      else{
        content = content + '\
        <input id="pourcentage" value="' +reste+ '" name="pourcentage" type="number" placeholder="en %" min="1" max="'+reste+'" class="form-control input-md">\
        <small class="text-muted" style="color: blue;">Reste = ' +reste+ '%.</small>\
        ';
      }
      content = content + '\
      </div>\
      </div>\
      </form>';
      var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
      <button id="btn-addTest" name="btn-addTest" class="btn btn-success">Ajouter</button>';
      setModalBox(title,content,footer);
      $('#myModal').modal('show');
    },
    error: function(err){
      console.log(err);
    },
  });
  return false;
});

// #btn-addTest to Database
$(document.body).on('click', '#btn-addTest',  function() {
  var selectedCourse = document.getElementById('coursOfConnectedProf').value;
  var queryString = $("#form-addTest").serialize()+'&action=addTest';
  var msgDiv = document.getElementById('messageInfo');

  // form values
  var testToAdd = document.getElementById('testToAdd').value;
  var pourcentage = document.getElementById('pourcentage').value;

  if (testToAdd == "" || pourcentage < 0 || pourcentage > 100) {
    msgDiv.innerHTML = "Veuillez remplir/vérifier tous les champs !";
    msgDiv.className = "alert alert-danger";
  }
  else{
    $.ajax({
      url: 'ajax.php?&selectedCourse='+selectedCourse+'&'+queryString,
      type:'GET',
      success: function(data){
       //console.log(data);
       var json = $.parseJSON(data);

       if (json.reponse === 'ok') {
        msgDiv.innerHTML = 'Épreuve ajoutée avec succes !!';
        msgDiv.className = "alert alert-success";
        localStorage.setItem("id_cours", selectedCourse);

        window.setTimeout(function(){
          msgDiv.innerHTML = '';
          msgDiv.className = "";
          window.location.href = "indexx.php?page=p_notes";
        }, 2500);
      } else {
        msgDiv.innerHTML = json.reponse;
        msgDiv.className = "alert alert-danger";
      }
    },
    error: function(err){
      console.log(err);
    },
  });
  }
});


// TODO
$(document.body).on('click', '#btn-uploadMarksFile',  function(e) {
  var id_cours = $('#coursOfConnectedProf').val();
  e.preventDefault();
  var title = 'Importer les notes a partir d\'un fichier Excel';
  var content = '\
  <div id="messageInfo"></div>\
  <form class="form-horizontal" id="form-uploadMarksForAllTest" method="POST" action="uploadToExcel.php" enctype="multipart/form-data">\
  <!-- File Button --> \
  <div class="form-group">\
  <label class="col-md-4 control-label" for="filebutton">Fichier</label>\
  <div class="col-md-4">\
  <input id="file" name="file" class="input-file" type="file">\
  <input type="hidden" name="code_cours" value="'+id_cours+'">\
  </div>\
  </div>\
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button id="btn-uploadNotesForThisTest" name="btn-uploadNotesForThisTest-cc" class="btn btn-primary">Importer</button>\
  </form>\
  ';
  var footer = '';
  setModalBox(title,content,footer);
  $('#myModal').modal('show');
});


  // edit Mode
  function uploadMarksForThisTest(id_cours, code_test, col){

    var formData = $("#form-uploadMarksForThisTest").serialize();

    console.log(formData);
    var file = document.getElementById("file").value;
    console.log(fu1);
    /*
    $.ajax({
      url: 'ajax.php?action=getAllInfoAbtoutThisTest2&id_cours='+id_cours+'&code_test='+code_test,
      type: 'GET',
      success : function(data){
        //console.log(data);
        var json_obj = $.parseJSON(data);
        console.log(json_obj);

      },
      error : function(err){
        console.log(err);
      }
    });
    */
  }





  // col-1 (upload)
  $(document.body).on('click', '#btn-uploadNotesForThisTest',  function() {
    console.log("Upload-cc");
    var id_cours = $('#coursOfConnectedProf').val();
    var col = document.getElementById("col").value;

    uploadMarksForThisTest(id_cours, "cc", 1);
  });













































// Profile
$(document.body).on('click', '#btn-modifier-info-perso-prof',  function(e) {

  $.ajax({
    url: 'ajax.php?action=modifierProfileProf',
    type: 'GET',
    success : function(data){
      var json_obj = $.parseJSON(data);
      var title = json_obj['nom_prof']+' '+json_obj['prenom_prof']+ '<small> - Modifier Profile</small>';
      var content = '<div class="row">\
      <div id="msg" class="alert"></div>\
      <form id="form-modifierUserProfile" class="form-horizontal" role="form">\
      <div class="form-group">\
      <label class="col-lg-4 control-label">Nom : </label>\
      <div class="col-lg-7">\
      <input class="form-control" id="nom_user" name="nom_user" type="text" value="'+json_obj['nom_prof']+'" required="" >\
      </div>\
      </div>\
      <div class="form-group">\
      <label class="col-lg-4 control-label">Prenom : </label>\
      <div class="col-lg-7">\
      <input class="form-control" id="prenom_user" name="prenom_user" type="text" value="'+json_obj['prenom_prof']+'" required="">\
      </div>\
      </div>\
      <div class="form-group">\
      <label class="col-lg-4 control-label">Email:</label>\
      <div class="col-lg-7">\
      <input class="form-control" id="user_mail" name="user_mail" type="email" value="'+json_obj['email_prof']+'" required="">\
      </div>\
      </div>\
      <div class="form-group">\
      <label class="col-md-4 control-label" for="radio">Changer mot de passe ?</label>\
      <div class="col-md-4">\
      <label class="radio-inline" for="radio-0">\
      <input type="radio" name="radio" id="radio-0" onclick="viewChangePasswordDiv(this.value);" value="yes" required=""> Oui\
      </label>\
      <label class="radio-inline" for="radio-1">\
      <input type="radio" name="radio" id="radio-1" onclick="viewChangePasswordDiv(this.value);" value="no" required=""> Non\
      </label>\
      </div>\
      </div>\
      <div id="password-change">\
      </div>\
      </form>\
      </div>';
      var footer = '<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>\
      <a href="#" id="btn-confirmer-modifier-profile" name="btn-confirmer-modifier-profile" class="btn btn-success">Confirmer la modification</a>';
      setModalBox(title, content, footer);
      $('#myModal').modal('show');
    },
    error : function(err){
      console.log(err);
    }
  });

});
$(document.body).on('click', '#btn-modifier-info-perso-stud',  function() {
  $.ajax({
    url: 'ajax.php?action=modifierProfileStud',
    type: 'GET',
    success : function(data){
      var json_obj = $.parseJSON(data);
            //console.log(json_obj);
            var title = json_obj['nom_etudiant']+' '+json_obj['prenom_etudiant']+ '<small> - Modifier Profile</small>';
            var content = '<div class="row">\
            <div id="msg" class="alert"></div>\
            <form id="form-modifierUserProfile" class="form-horizontal" role="form">\
            <div class="form-group">\
            <label class="col-lg-4 control-label">Nom : </label>\
            <div class="col-lg-7">\
            <input class="form-control" id="nom_user" name="nom_user" type="text" value="'+json_obj['nom_etudiant']+'" required="" >\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-lg-4 control-label">Prenom : </label>\
            <div class="col-lg-7">\
            <input class="form-control" id="prenom_user" name="prenom_user" type="text" value="'+json_obj['prenom_etudiant']+'" required="">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-lg-4 control-label">Email:</label>\
            <div class="col-lg-7">\
            <input class="form-control" id="user_mail" name="user_mail" type="email" value="'+json_obj['email_etudiant']+'" required="">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-lg-4 control-label">Email:</label>\
            <div class="col-lg-7">\
            <input class="form-control" id="user_tel" name="user_tel" type="tel" value="'+json_obj['tel_etudiant']+'" required="">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-md-4 control-label" for="radio">Changer mot de passe ?</label>\
            <div class="col-md-4">\
            <label class="radio-inline" for="radio-0">\
            <input type="radio" name="radio" id="radio-0" onclick="viewChangePasswordDiv(this.value);" value="yes" required=""> Oui\
            </label>\
            <label class="radio-inline" for="radio-1">\
            <input type="radio" name="radio" id="radio-1" onclick="viewChangePasswordDiv(this.value);" value="no" required=""> Non\
            </label>\
            </div>\
            </div>\
            <div id="password-change">\
            </div>\
            </form>\
            </div>';
            var footer = '<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>\
            <a href="#" id="btn-confirmer-modifier-profile" name="btn-confirmer-modifier-profile" class="btn btn-success">Confirmer la modification</a>';
            setModalBox(title, content, footer);
            $('#myModal').modal('show');
          },
          error : function(err){
            console.log(err);
          }
        });
});

function viewChangePasswordDiv(val) {
  var password_div = document.getElementById('password-change');
  if (val == "yes") {
    var content = '\
    <div class="form-group">\
    <label class="col-md-4 control-label">Ancien Mot de passe : </label>\
    <div class="col-md-5">\
    <input class="form-control" id="user_pass" name="user_pass" type="password" required="">\
    </div>\
    </div>\
    <div class="form-group">\
    <label class="col-md-4 control-label">Tapez votre nouveau mot de passe : </label>\
    <div class="col-md-5">\
    <input class="form-control" id="new_pass_1" name="new_pass_1" type="password" required="">\
    </div>\
    </div>\
    <div class="form-group">\
    <label class="col-md-4 control-label">Retapez votre nouveau mot de passe : </label>\
    <div class="col-md-5">\
    <input class="form-control" id="new_pass_2" name="new_pass_2" type="password" onkeyup="checkPass(); return false;" required="">\
    <span id="confirmMessage" class="confirmMessage"></span>\
    </div>\
    </div>';
    password_div.innerHTML = content;
  } else if (val == "no") {
    password_div.innerHTML ='';
  }
}



function checkPass() {
  var pass1 = document.getElementById('new_pass_1');
  var pass2 = document.getElementById('new_pass_2');
  var message = document.getElementById('confirmMessage');
  var goodColor = "#66cc66";
  var badColor = "#ff6666";
  if (pass1.value == pass2.value) {
    pass2.style.backgroundColor = goodColor;
    message.style.color = goodColor;
    message.innerHTML = "Passwords Match!"
  } else {
    pass2.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.innerHTML = "Passwords Do Not Match!"
  }
}

// TODO
$(document.body).on('click', '#btn-confirmer-modifier-profile',  function() {
    //alert("Good");
    var msgDiv = document.getElementById("msg");
    
    
    /*if( $('#form-modifierUserProfile').val().length === 0 ) {
            msgDiv.innerHTML = 'Remplissez les champs vides !!!';
            msgDiv.className = "alert alert-danger";
          }else{*/

            var radio = document.getElementsByName("radio");
            var radioValue;
        // loop through list of radio buttons
        for (var i = 0, len = radio.length; i < len; i++) {
            if (radio[i].checked) { // radio checked?
                radioValue = radio[i].value; // if so, hold its value in val
                break; // and break out of for loop
              }
            }

            if (radioValue == "no") {
              var queryString = $("#form-modifierUserProfile").serialize()+'&action=modifierUserProfile';
            //console.log(queryString);
            $.ajax({
              url: 'ajax.php?'+queryString,
              type:'GET',
              success: function(data){
                var json = $.parseJSON(data);
                if (json.reponse === 'ok') {
                  var msgDiv = document.getElementById("message");
                  msgDiv.innerHTML = 'Modifications enregistrees avec succes !!';
                  msgDiv.className = "alert alert-success";
                  $("#myModal").hide();
                  $('#myModal').modal('hide');
                  window.setTimeout(function(){
                    window.location.href = "indexx.php?page=profile_user";
                  }, 2500);
                } else {
                  alert('Erreur au cours d\'enregistrement : ' + json.reponse);
                }

              }
            });
          } 
          else if (radioValue == "yes") {
            var user_pass = document.getElementById("user_pass").value;
            var new_pass_1 = document.getElementById("new_pass_1").value;
            var new_pass_2 = document.getElementById("new_pass_2").value;
            
            //GET user mot de passe
            $.ajax({
              url: 'ajax.php?action=checkUserPass&user_pass='+user_pass,
              type:'GET',
              success: function(data){
                var json = $.parseJSON(data);
                if (json.reponse === 'ok') {
                  alert('OK : ancien mot de passe');
                  if (new_pass_1 == new_pass_2) {
                    var queryString2 = $("#form-modifierUserProfile").serialize()+'&action=modifierUserProfile';
                            //console.log(queryString2);
                            $.ajax({
                              url: 'ajax.php?'+queryString2,
                              type:'GET',
                              success: function(data2)
                              {
                                   // console.log(data2);
                                   var json2 = $.parseJSON(data2);
                                    //console.log(json2);
                                    if (json2.reponse === 'ok') {
                                      var msgDiv = document.getElementById("message");
                                      msgDiv.innerHTML = 'Modifications enregistrees avec succes !!';
                                      msgDiv.className = "alert alert-success";
                                      $("#myModal").hide();
                                      $('#myModal').modal('hide');
                                      window.setTimeout(function(){
                                        window.location.href = "indexx.php?page=profile_user";
                                      }, 2500);
                                    } 
                                    else {
                                      alert('Erreur au cours d\'enregistrement : ' + json2.reponse);
                                    }
                                  }
                                });
                          }
                          else if (new_pass_1 != new_pass_2) {
                            document.getElementById("new_pass_1").value = "";
                            document.getElementById("new_pass_2").value = "";
                            alert("Retapez votre nouveau mot de passe");
                          }
                        }
                        else {
                          document.getElementById("user_pass").value = "";
                          alert('Erreur : ' + json.reponse);
                          if (new_pass_1 !== new_pass_2) {
                            document.getElementById("new_pass_1").value = "";
                            document.getElementById("new_pass_2").value = "";
                            alert("Verifiez votre nouveau mot de passe aussi");
                          }
                        }
                      }
                    });
          } 
          else {
            msgDiv.innerHTML = 'Vous devez decider si vous voulez changer votre mot de passe ou pas !!';
            msgDiv.className = "alert alert-danger";
          }
          /*}*/
        });



// onCoursChange (Prof)
$(document).on('change', '#coursOfConnectedProf', function() {
  var msgDiv = document.getElementById('message');
  msgDiv.innerHTML='';
  msgDiv.className='';

  var id_cours = $('#coursOfConnectedProf').val();
  getStudentFollowingCourse(id_cours);
  showAddTestButton(id_cours);
  showDownMarksFileButton(id_cours);
  showPrintButton_p(id_cours);
  localStorage.setItem("id_cours", id_cours);
  //checkIfTestPassedEqual3(id_cours);
});

function getStudentFollowingCourse(id_cours){
  $.ajax({
    url: 'ajax.php?action=getStudentFollowingThisCourse&id_cours='+id_cours,
    type:'GET',
    dataType: 'json',
    success: function(data){
      var json_infoTest = $.parseJSON(data['infoTest']);
      var content="";
      var nbrEpreuve = data['nbrEpreuve'];

      if (data[0].length == 0) {
        $('#ListOfStudentFollowingTheCourse').html('');
      }
      else if (data[0].length > 0) {
        content = '\
        <table id="listOfStudentFollCourse" class="table table-responsive table-bordered table-striped table-hover table-condensed">\
        <thead>\
        <th class="bg-info"><h4>Nom Complet</h4></th>\
        </thead>\
        <tbody>';

        var tmp = "";
        for (var i = 0; i <= data[0].length - 1; i++) {
          tmp = '\
          <tr>\
          <td>'+data[0][i].nom_etudiant.toUpperCase() + " " + data[0][i].prenom_etudiant.toUpperCase() + '</td>\
          </tr>\
          ';
          content = content + tmp;
        }
        content = content + '\
        </tbody>\
        <tfoot>\
        </tfoot>\
        </table>\ ';
        $('#ListOfStudentFollowingTheCourse').html(content);
        $('#ListOfStudentFollowingTheCourse').className ="box-body col-md-10";

        // Traitement des tests
        if (json_infoTest.length > 0) {
          // ajouter header of Test
          for (var i = 0; i < json_infoTest.length; i++) {
            var tableau = document.getElementById("listOfStudentFollCourse");
            var arrayLignes = tableau.rows; 
            var longueur = arrayLignes.length;
            var tmp = 0;
            var code_type_test = json_infoTest[i].code_type_test;
            //  console.log("tmp");
            $.ajax({
              url: 'ajax.php?action=getAllInfoAbtoutThisTest2&id_cours='+id_cours+'&code_test='+code_type_test,
              type: 'GET',
              success : function(data){
                //console.log(data);
                var json_obj = $.parseJSON(data);
                //console.log(json_obj);
                var json_infoTest = json_obj.infoTest;
                var json_noteTest = json_obj.noteOfThatTest;
                tmp++;
                for (var j = 0; j < longueur; j++) {
                  var cell = tableau.rows[j].insertCell(-1);
                  if (j==0) {
                    //console.log("tmp2");
                    cell.className ="bg-info";
                    cell.innerHTML += '<th>\
                    <center>\
                    <button type="button" class="btn btn-primary noPrint" id="btn-modifyTest-'+(json_infoTest[0].code_type_test)+'-col-'+(tmp)+'"><i class="fa fa-pencil-square-o"></i></button>\
                    <button type="button" class="btn btn-warning noPrint" id="btn-deleteTest-'+(json_infoTest[0].code_type_test)+'-col-'+(tmp)+'"><i class="fa fa-eraser "></i></button>\
                    </center>\
                    </th>\
                    <th><center><h4 id="header-modifyInfo" class="'+json_infoTest[0].code_type_test+' unselectable-po">'+json_infoTest[0].libelle_type_test+" - "+json_infoTest[0].pourcentage_test+"% "+'</h4></center></th>';
                  }
                  else{
                    cell.innerHTML += '<center>'+json_noteTest[(j-1)].note+'</center>';
                  }

                }

              },
              error : function(err){
                console.log(err);
              }
            });
          }
        }
      }
    },
    error: function(err){
      console.log(err);
    },
  });
}

function showAddTestButton(id_cours){
  var div = document.getElementById("addButtonDiv");
  if (id_cours=="") {
    div.innerHTML = '';
  }
  else{
    $.ajax({
      url: 'ajax.php?action=getPourcentageOfTestAlreadyPassed&id_cours='+id_cours,
      type: 'GET',
      success : function(data){
        var json_obj = $.parseJSON(data);
        var nbrEpreuve = json_obj.nbrEpreuve;
        var pourcentageDone = json_obj.pourcentageDone;



      // ajouter le bouton add test dans le cas ou le nombre total d'epreuves est egale a {0,1,2}
      console.log("Nombre de test : " + nbrEpreuve);
      if (pourcentageDone != 100 && (nbrEpreuve == 1 | nbrEpreuve == 2 | nbrEpreuve == 0)) {
        div.innerHTML = '<th><button class="btn btn-success noPrint" id="btn-viewAddTestForm"><i class="fa fa-plus"></i> Nouvelle Épreuve</button></th><br/><br/>';
      }
      else if (pourcentageDone == 100 ) {
        div.innerHTML = '<th><div id="div-MoyenneCol"><button class="btn btn-primary noPrint" id="btn-viewMoyenneStudent"><i class="fa fa-eye" aria-hidden="true"></i> Afficher la moyenne</button></div></th>';
      }
      else
      {
        div.innerHTML = '';
      }


    },
    error : function(err){
      console.log(err);
    }
  });
  }
}

function showDownMarksFileButton(id_cours){
  var id_cours = $('#coursOfConnectedProf').val();
  var div = document.getElementById("marksFile");
  if (id_cours=="") {
    div.innerHTML = '';
  }
  else{
    div.innerHTML = '<a href="indexx.php?page=uploadFile&id_cours='+id_cours+'" class="btn btn-primary"><i class="fa fa-upload"></i> Importer les notes</a>&nbsp;&nbsp;<a href="indexx.php?page=dmf&id_cours='+id_cours+'" class="btn btn-primary"><i class="fa fa-download"></i> Fichier de notes</a>';
  }
}


$(document.body).on('click', '#btn-downloadMarksFile',  function(e) {
  var id_cours = $('#coursOfConnectedProf').val();
  console.log("Download " + id_cours);
  e.preventDefault();
  downloadMarksFile(id_cours);
});


function downloadMarksFile(id_cours){
  $.ajax({
    url: 'ajax.php?action=downloadMarksFile&id_cours='+id_cours,
    type: 'GET',
    success : function(data){
      //console.log("DOWNLOADED !");
      //console.log(data);
    },
    error : function(err){
      console.log(err);
    }
  });
}



// #btn-viewMoyenneStudent
$(document.body).on('click', '#btn-viewMoyenneStudent',  function(e) {
  var selectedCourse = document.getElementById('coursOfConnectedProf').value;
  e.preventDefault();
  addMoyenneCol(selectedCourse);

  return false;
});

function addMoyenneCol(id_cours){
  var msgDiv = document.getElementById("message");

  var tableau = document.getElementById("listOfStudentFollCourse");
  var arrayLignes = tableau.rows; 
  var longueur = arrayLignes.length;

  $.ajax({
    url: 'ajax.php?action=getMoyenneOfThisCourse&selectedCourse='+id_cours,
    type:'GET',
    success: function(data){
      //console.log(data);
      var json = $.parseJSON(data);
      //console.log(json);

      if (json.restePourcentage == 0) {
        for (var j = 0; j < longueur; j++) {
          var ligne = tableau.rows[j];
          var cell = ligne.insertCell(-1);

          if (j==0) {
            cell.className ="bg-info";
            cell.innerHTML += '<th><center><h4 class="unselectable"><strong>Moyenne</strong><br/><br/><center>/20</center></h4></th>';
          }
          else{
            cell.className ="bg-info";
            cell.innerHTML += '<div class="row"><div class="col-xs-8 col-md-offset-2"><center>'+ json.moyenne[j-1] +'</center></div></div>';
          }
        }
        var div_moyenne = document.getElementById("div-MoyenneCol");
        div_moyenne.innerHTML = '<button class="btn btn-primary noPrint" id="btn-hideMoyenneStudent"><i class="fa fa-eye-slash" aria-hidden="true"></i> Cacher la moyenne</button>';
      }
      else{
        window.setTimeout(function(){
          msgDiv.innerHTML = 'Veuillez compléter/modifier le pourcentage des tests pour avoir un total de 100%';
          msgDiv.className = 'alert alert-danger';
        }, 1000);
      }
    },
    error: function(err){
      console.log(err);
    },
  });
}



// #btn-hideMoyenneStudent
$(document.body).on('click', '#btn-hideMoyenneStudent',  function(e) {
  var selectedCourse = document.getElementById('coursOfConnectedProf').value;
  e.preventDefault();
  removeMoyenneCol();

  return false;
});


function removeMoyenneCol(){
  var tableau = document.getElementById("listOfStudentFollCourse");
  var arrayLignes = tableau.rows; 
  var longueur = arrayLignes.length;

  for (var j = 0; j < longueur; j++) {
    var ligne = tableau.rows[j];
    ligne.deleteCell(-1);
  }

  var div_moyenne = document.getElementById("div-MoyenneCol");
  div_moyenne.innerHTML = '<button class="btn btn-primary noPrint" id="btn-viewMoyenneStudent"><i class="fa fa-eye" aria-hidden="true"></i> Afficher la moyenne</button>';
}





























/*
 *
 * MODIFIER
 *
 */

  // disable action buttons
  function disableButtons(){
    var type_test = ["CC", "EF", "PFE", "PRJ", "STG"];
    var element_mod, element_sup;
    for (var i = 1; i <= 3; i++) {
      for (var j = 0; j < type_test.length; j++) {
        element_mod  =  document.getElementById("btn-modifyTest-"+type_test[j]+"-col-"+i);
        element_sup  =  document.getElementById("btn-deleteTest-"+type_test[j]+"-col-"+i);
        if (typeof(element_mod) != 'undefined' && element_mod != null) {
          element_mod.disabled = true;
          element_sup.disabled = true;
        }
      }
    }
    $('.unselectable-po').removeClass('unselectable-po').addClass('unselectable');

    document.getElementById('btn-viewAddTestForm').disabled = true;
    document.getElementById('btn-viewMoyenneStudent').disabled = true;
    document.getElementById('btn-print_p').disabled = true;
  }

  // edit Mode
  function getTableData(id_cours, code_test, col){
    $.ajax({
      url: 'ajax.php?action=getAllInfoAbtoutThisTest2&id_cours='+id_cours+'&code_test='+code_test,
      type: 'GET',
      success : function(data){
        //console.log(data);
        var json_obj = $.parseJSON(data);
        console.log(json_obj);
        var json_infoTest = json_obj.infoTest;
        var json_noteTest = json_obj.noteOfThatTest;

        var tableau = document.getElementById("listOfStudentFollCourse");
        var arrayLignes = tableau.rows; 
        var longueur = arrayLignes.length;

        for (var j = 0; j < longueur; j++) {
          var ligne = tableau.rows[j];
          ligne.deleteCell(col);
          var cell = ligne.insertCell(col);

          if (j==0) {
            cell.className ="bg-info";
            /*cell.innerHTML += '<th>\
            <center>\
            <button type="button" class="btn btn-success" id="btn-exportMarksFromExcelforTest-'+json_infoTest[j].code_type_test+"-col-"+col+'"><i class="fa fa-file-excel-o "></i></button>\
            </center>\
            </th>';*/
            cell.innerHTML += '<th><center><h4 class="unselectable">'+json_infoTest[j].libelle_type_test+" - "+json_infoTest[j].pourcentage_test+"% "+'</h4></center></th>';
          }
          else{
            //cell.innerHTML += '<input id="pourcentage" name="pourcentage" type="number" placeholder="" min="0" max="20" step="0.01" class="form-control input-md" style=" margin: -0.3em;font-size: 25px;height: 35px;" value="'+json_noteTest[(j-1)].note+'">';
            cell.innerHTML += '<div class="row"><div class="col-xs-8 col-md-offset-2"><input id="note" name="noteStud'+j+'" type="number" placeholder="" min="0" max="20" step="0.01" class="form-control input-md input_mod" value="'+json_noteTest[(j-1)].note+'"></div></div>';
          }
        }
        var ligneFoot = tableau.insertRow(-1);
        var k=0;
        while(k < col){
          ligneFoot.insertCell(0);
          k++;
        }
        var cellFoot = ligneFoot.insertCell(col);
        cellFoot.innerHTML += '<input type="hidden" name="code_type_test" value="'+json_infoTest[0].code_type_test+'"><center><button id="btn-submitNoteStudent" class="btn btn-success"><i class="fa fa-floppy-o"></i>   Enregistrer</button></center>';
      },
      error : function(err){
        console.log(err);
      }
    });
  }

  // check input field (edit Mode)
  $(document.body).on('blur', '#note',  function() {
    if (this.value > 0 && this.value <= 20 ){
      $(this).css({'background-color' : '#69F0AE'});
    }
    if (this.value == 0 ){
      $(this).css({'background-color' : '#fff'});
    }
    if (this.value < 0 || this.value > 20) {
      $(this).css({'background-color' : '#F44336'});
    }
  });

  // col-1 (modifier)
  $(document.body).on('click', '#btn-modifyTest-CC-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "CC", 1);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-EF-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "EF", 1);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-PFE-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "PFE", 1);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-PRJ-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "PRJ", 1);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-STG-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "STG", 1);
    disableButtons();
  });


  // col-2 (modifier)
  $(document.body).on('click', '#btn-modifyTest-CC-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "CC", 2);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-EF-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "EF", 2);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-PFE-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "PFE", 2);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-PRJ-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "PRJ", 2);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-STG-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "STG", 2);
    disableButtons();
  });


  // col-3 (modifier)
  $(document.body).on('click', '#btn-modifyTest-CC-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "CC", 3);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-EF-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "EF", 3);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-PFE-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "PFE", 3);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-PRJ-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "PRJ", 3);
    disableButtons();
  });

  $(document.body).on('click', '#btn-modifyTest-STG-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    getTableData(id_cours, "STG", 3);
    disableButtons();
  });

/*
 *
 * SUPPRIMER
 *
 */

  // function vider les notes
  function removeMarksofThisTest(code_cours, code_type_test, col){
    var msgDiv = document.getElementById('message');

    if (confirm("Voulez-vouz effacer les notes de ce test ? ")) {
      $.ajax({
        url: 'ajax.php?action=removeMarksofThisTest&id_cours='+code_cours+'&code_type_test='+code_type_test,
        type: 'GET',
        success : function(data){
          console.log(data);
          var json_obj = $.parseJSON(data);
          console.log(json_obj);
          if (json_obj.reponse=="ok") {
            msgDiv.innerHTML = 'Toutes les notes de ce test ont été effacées avec succes !!';
            msgDiv.className = "alert alert-success";
            var tableau = document.getElementById("listOfStudentFollCourse");
            var arrayLignes = tableau.rows; 
            var longueur = arrayLignes.length;
            
            for (var j = 1; j < longueur; j++) {
              tableau.rows[j].deleteCell(col);
              var cellAdded = tableau.rows[j].insertCell(col);
              cellAdded.innerHTML += '<center>0</center>';
            }

            window.setTimeout(function(){
              msgDiv.innerHTML = '';
              msgDiv.className = "";
              //window.location.href = "index.php?page=p_notes";
            }, 5000);
          }
          else{
            msgDiv.innerHTML = 'Erreur lors de la suppression : ' + json.reponse;
            msgDiv.className = "alert alert-danger";
          }
        },
        error : function(err){
          console.log(err);
        }
      });
    }
  }

  // col-1 (supprimer)
  $(document.body).on('click', '#btn-deleteTest-CC-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "CC", 1);
  });

  $(document.body).on('click', '#btn-deleteTest-EF-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "EF", 1);
  });

  $(document.body).on('click', '#btn-deleteTest-PFE-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "PFE", 1);
  });

  $(document.body).on('click', '#btn-deleteTest-PRJ-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "PRJ", 1);
  });

  $(document.body).on('click', '#btn-deleteTest-STG-col-1',  function() {
    console.log("Modifier-Test-1");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "STG", 1);
  });


  // col-2 (supprimer)
  $(document.body).on('click', '#btn-deleteTest-CC-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "CC", 2);
  });

  $(document.body).on('click', '#btn-deleteTest-EF-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "EF", 2);
  });

  $(document.body).on('click', '#btn-deleteTest-PFE-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "PFE", 2);
  });

  $(document.body).on('click', '#btn-deleteTest-PRJ-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "PRJ", 2);
  });

  $(document.body).on('click', '#btn-deleteTest-STG-col-2',  function() {
    console.log("Modifier-Test-2");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "STG", 2);
  });


  // col-3 (supprimer)
  $(document.body).on('click', '#btn-deleteTest-CC-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "CC", 3);
  });

  $(document.body).on('click', '#btn-deleteTest-EF-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "EF", 3);
  });

  $(document.body).on('click', '#btn-deleteTest-PFE-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "PFE", 3);
  });

  $(document.body).on('click', '#btn-deleteTest-PRJ-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "PRJ", 3);
  });

  $(document.body).on('click', '#btn-deleteTest-STG-col-3',  function() {
    console.log("Modifier-Test-3");
    var id_cours = $('#coursOfConnectedProf').val();

    removeMarksofThisTest(id_cours, "STG", 3);
  });

/*
 *
 * Submit 
 *
 */

  // #btn-submitNoteStudent to Database
  $(document.body).on('click', '#btn-submitNoteStudent',  function() {
    console.log("Submit-Test-1");

    var selectedCourse = document.getElementById('coursOfConnectedProf').value;
    var queryString = $("#form-affectNotesToStudent").serialize()+'&action=submitNoteStudent';
    var msgDiv = document.getElementById('message');

    console.log(queryString);


    $.ajax({
      url: 'ajax.php?&selectedCourse='+selectedCourse+'&'+queryString,
      type:'GET',
      success: function(data){
       console.log(data);
       var json = $.parseJSON(data);

       if (json.reponse === 'ok') {
        msgDiv.innerHTML = 'Toutes les notes ont été modifiées avec succes !!';
        msgDiv.className = "alert alert-success";
        localStorage.setItem("id_cours", selectedCourse);

        window.setTimeout(function(){
          msgDiv.innerHTML = '';
          msgDiv.className = "";
          window.location.href = "indexx.php?page=p_notes";
        }, 2500);
      } else {
        msgDiv.innerHTML = json.reponse;
        msgDiv.className = "alert alert-danger";
      }
    },
    error: function(err){
      console.log(err);
    },
  });
    return false; // to not refresh the page
  });
























// Modify Test Properties - Pop Up Form
$(document.body).on('click', '.unselectable-po',  function() {
  var code_cours = $('#coursOfConnectedProf').val();
  var event_h = event.target.className;
  var type_test = event_h.charAt(0)+event_h.charAt(1)+event_h.charAt(2);
  var title = 'Modifier les propriétés du test';

  var content = '\
  <div id="messageInfo"></div>\
  <form class="form-horizontal" id="form-modifyTestProperties">\
  <div class="form-group">\
  <label class="col-md-4 control-label" for="selectedTest">Épreuve</label>\
  <div class="col-md-4">\
  <select id="selectedTest" name="selectedTest" class="form-control" required="" disabled="">';
  var tmp = "";
  $.ajax({
    url: 'ajax.php?action=getDataAboutThisTestToModify&code_cours='+code_cours+'&selected_cours='+type_test,
    type:'GET',
    success: function(data){
      var json = $.parseJSON(data);
      console.log(json);
      var x= parseFloat(json[2]);
      var y= parseFloat(json[3][2]);
      var reste = x+y;
      content = content + '<option value="' + json[3][0] + '">' + json[3][1] + '</option>';
      for (var i = json[0].length - 1; i >= 0; i--) {
        tmp = '<option value="' + json[0][i] + '">' + json[1][i] + '</option>';
        content = content + tmp;
      }
      content = content + '\
      </select>\
      </div>\
      </div>\
      <!-- Text input-->\
      <div class="form-group">\
      <label class="col-md-4 control-label" for="pourcentage">Pourcentage de l\'épreuve</label>\
      <div class="col-md-4">\
      <input id="pourcentage" value="' +json[3][2]+ '" name="pourcentage" type="number" placeholder="en %" min="1" max="'+reste+'" class="form-control input-md" disabled="" required="">\
      <small class="text-muted" style="color: blue;">Reste total = ' +reste+ '%.</small>\
      </div>\
      </div>\
      <input value="' + json[3][0] + '" name="old_test" id="old_test" type="hidden">\
      </form>';
      var footer = '\
      <div id="div-buttonModal">\
      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>\
      <button type="button" class="pull-right btn btn-primary" id="btn-unlockOptions"><i class="fa fa-unlock-alt"></i> Dévérouiller</button>\
      </div>';
      setModalBox(title,content,footer);
      $('#myModal').modal('show');
    },
    error: function(err){
      console.log(err);
    },
  });
  return false;
});

// Modify Test Properties - footer switch
$(document.body).on('click', '#btn-unlockOptions',  function() {
  var div = document.getElementById("div-buttonModal");
  document.getElementById("selectedTest").disabled= false;
  document.getElementById("pourcentage").disabled= false;
  div.innerHTML = '\
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>\
  <button id="btn-updateTestProperties" name="btn-updateTestProperties" class="btn btn-success"><i class="fa fa-check-square-o"></i> Valider les modifications</button>\
  <button id="btn-deleteTestProperties" name="btn-deleteTestProperties" class="btn btn-danger"><i class="fa fa-trash-o"></i> Retirer le test</button>';
});

// Modify Test Properties - Update database
$(document.body).on('click', '#btn-updateTestProperties',  function() {
  var selectedCourse = document.getElementById('coursOfConnectedProf').value;
  var queryString = $("#form-modifyTestProperties").serialize()+'&action=updateTestProperties';
  var queryStringDelAll = $("#form-modifyTestProperties").serialize()+'&action=updateTestPropertiesDelAll';
  var msgDiv = document.getElementById('messageInfo');

  // form values
  var testToAdd = document.getElementById('selectedTest').value;
  var pourcentage = document.getElementById('pourcentage').value;
  var old_test = document.getElementById('old_test').value;
  //console.log(queryString);
  if (testToAdd == "" || pourcentage < 0 || pourcentage > 100) {
    msgDiv.innerHTML = "Veuillez remplir/vérifier tous les champs !";
    msgDiv.className = "alert alert-danger";
  }
  else{
    if (testToAdd == old_test) {
      $.ajax({
        url: 'ajax.php?selectedCourse='+selectedCourse+'&'+queryString,
        type:'GET',
        success: function(data){
          console.log(data);
          var json = $.parseJSON(data);

          if (json.reponse === 'ok') {
            msgDiv.innerHTML = 'Propriétés du test modifiées avec succes !!';
            msgDiv.className = "alert alert-success";
            localStorage.setItem("id_cours", selectedCourse);

            window.setTimeout(function(){
              msgDiv.innerHTML = '';
              msgDiv.className = "";
              window.location.href = "indexx.php?page=p_notes";
            }, 2500);

          } else {
            msgDiv.innerHTML = json.reponse;
            msgDiv.className = "alert alert-danger";
          }
        },
        error: function(err){
          console.log(err);
        },
      });
    }
    else{
      if (confirm("Toutes les notes de l'ancienne épreuve seront écrasées. Confirmer ?")) {
        $.ajax({
          url: 'ajax.php?selectedCourse='+selectedCourse+'&'+queryStringDelAll,
          type:'GET',
          success: function(data){
            console.log(data);
            var json = $.parseJSON(data);
            console.log(json);

            if (json.reponse1 === 'ok') {
              msgDiv.innerHTML = 'Propriétés du test modifiées avec succès !!';
              msgDiv.className = "alert alert-success";
              localStorage.setItem("id_cours", selectedCourse);
              
              window.setTimeout(function(){
                msgDiv.innerHTML = '';
                msgDiv.className = "";
                window.location.href = "indexx.php?page=p_notes";
              }, 2500);
            } else {
              msgDiv.innerHTML = json.reponse;
              msgDiv.className = "alert alert-danger";
            }
          },
          error: function(err){
            console.log(err);
          },
        });
      }
    }
  }
});

// Modify Test Properties - Delete database
$(document.body).on('click', '#btn-deleteTestProperties',  function() {
  var selectedCourse = document.getElementById('coursOfConnectedProf').value;
  var queryString = $("#form-modifyTestProperties").serialize()+'&action=deleteThisTest';
  var msgDiv = document.getElementById('messageInfo');

  var old_test = document.getElementById('old_test').value;

  if (confirm("Toutes les notes de cette épreuve seront écrasées. Confirmer ?")) {
    $.ajax({
      url: 'ajax.php?selectedCourse='+selectedCourse+'&'+queryString,
      type:'GET',
      success: function(data){
        console.log(data);
        var json = $.parseJSON(data);
        console.log(json);

        if (json.reponse === 'ok') {
          msgDiv.innerHTML = 'Epreuve supprimée avec succès !!';
          msgDiv.className = "alert alert-success";
          localStorage.setItem("id_cours", selectedCourse);

          window.setTimeout(function(){
            msgDiv.innerHTML = '';
            msgDiv.className = "";
            window.location.href = "indexx.php?page=p_notes";
          }, 2500);
        } else {
          msgDiv.innerHTML = json.reponse;
          msgDiv.className = "alert alert-danger";
        }
      },
      error: function(err){
        console.log(err);
      },
    });
  }
});











// Pop-up SetUp Session Params
$(document.body).on('click', '#session-info',  function() {
  var id_cours = $('#coursOfConnectedProf').val();
  var title = 'Paramètres de connexion';
  var content = '\
  <div id="messageInfo"></div>\
  <form class="form-horizontal" id="form-sessionParam">\
  <div class="form-group">\
  <label class="col-md-4 control-label" for="selectedYear">Année universitaire</label>\
  <div class="col-md-4">\
  <select id="selectedYear" name="selectedYear" class="form-control" required="" disabled="">';
  var tmp = "";
  $.ajax({
    url: 'ajax.php?action=getSessionParam',
    type:'GET',
    success: function(data){
      //console.log(data);
      var json = $.parseJSON(data);
      console.log(json);
      var annee = json.annee;
      var semestre = json.semestre;
      var semestre_str = "";

      if (semestre == "S1") semestre_str = "Semestre 1";
      else if(semestre == "S2") semestre_str = "Semestre 2";

      for (var i = json.allAnnee.length - 1; i >= 0; i--) {
        if (annee == json.allAnnee[i].annee_universitaire) {
          tmp = '<option value="' + annee + '" selected>' + annee + '</option>';
        }
        else{
          tmp = '<option value="' + annee + '">' + annee + '</option>';
        }
        content = content + tmp;
      }

      content = content + '\
      </select>\
      </div>\
      </div>\
      <!-- Text input-->\
      <div class="form-group">\
      <label class="col-md-4 control-label" for="selectedSemestre">Semestre</label>\
      <div class="col-md-4">\
      <select id="selectedSemestre" name="selectedSemestre" class="form-control" required="" disabled="">';

      if (semestre == "S2") {
        content = content + '<option value="' + semestre + '" selected>' + semestre_str + '</option>\
        <option value="S1">Semestre 1</option>';
      }
      else if (semestre == "S1") {
        content = content + '<option value="' + semestre + '" selected>' + semestre_str + '</option>\
        <option value="S2">Semestre 2</option>';
      }

      content = content + '</select>\
      </div>\
      </div>\
      </form>';
      var footer = '\
      <div id="div-buttonModal">\
      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>\
      <button type="button" class="pull-right btn btn-primary" id="btn-unlockOptionsParams"><i class="fa fa-unlock-alt"></i> Dévérouiller</button>\
      </div>';
      setModalBox(title,content,footer);
      $('#myModal').modal('show');
    },
    error: function(err){
      console.log(err);
    },
  });
  return false;
});

// Modify Session Params - footer switch
$(document.body).on('click', '#btn-unlockOptionsParams',  function() {
  var div = document.getElementById("div-buttonModal");
  document.getElementById("selectedYear").disabled= false;
  document.getElementById("selectedSemestre").disabled= false;
  div.innerHTML = '\
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>\
  <button id="btn-updateSessionParams" name="btn-updateSessionParams" class="btn btn-success"><i class="fa fa-check-square-o"></i> Valider les modifications</button>';
});

// Modify Session Params - Update Session Params
$(document.body).on('click', '#btn-updateSessionParams',  function() {
  var queryString = $("#form-sessionParam").serialize()+'&action=updateSessionParams';
  var msgDiv = document.getElementById('messageInfo');
  console.log(queryString);

  $.ajax({
    url: 'ajax.php?'+queryString,
    type:'GET',
    dataType: 'json',
    success: function(data){
      //console.log(data);
      if (data.reponse === 'ok') {
        msgDiv.innerHTML = 'Paramétres de session modifiés avec succès !!';
        msgDiv.className = "alert alert-success";
        localStorage.setItem("id_cours", "");

        window.setTimeout(function(){
          msgDiv.innerHTML = '';
          msgDiv.className = "";
          window.location.href = "indexx.php?page=p_notes";
        }, 1000);

      } else {
        msgDiv.innerHTML = data.reponse;
        msgDiv.className = "alert alert-danger";
      }
    },
    error: function(err){
      console.log(err);
    },
  });
});






































/*
function checkIfTestPassedEqual3(id_cours){
  $.ajax({
    url: 'ajax.php?action=getNumberOfTestAlreadyPassed&id_cours='+id_cours,
    type:'GET',
    dataType: 'json',
    success: function(data){
      console.log(data+" epreuves en total");
      if (data == 3) {
        var tableau = document.getElementById("listOfStudentFollCourse");//on prend le tableau
        var arrayLignes = tableau.rows; //l'array est stocké dans une variable
        var longueur = arrayLignes.length;
        for (var i = longueur - 1; i >= 0; i--) {
          var ligne = tableau.rows[i];
          ligne.deleteCell(-1);
        }
      }
    },
    error: function(err){
      console.log(err);
    },
  });
}
*/

























//::::::::::::::::::::MA PARTIE::::::::::::::::::::



$(document).on('change', '#elementModuleOfEtudiant', function() {

  var code_referentiel = $('#elementModuleOfEtudiant').val();
  console.log(code_referentiel);
  if (code_referentiel =="") {
    $('#tableNotes').html('');
    $('#e_printDiv').html('');
    
  }
  else{
    getStudentMarks(code_referentiel);
    localStorage.setItem("code_referentiel", code_referentiel);
    showPrintButton(code_referentiel);
    //checkIfTestPassedEqual3(id_cours);
  }
});

function getStudentMarks(code_referentiel){
  $.ajax({
    url: 'ajax.php?action=getNotesOfEtudiant&code_referentiel='+code_referentiel,
    type:'GET',
    dataType: 'json',
    success: function(data){

      console.log(data);
      var content="";
      var tableElementModule = new Array();
      if (data["elements_modules"][0].length == 0) {
        $('#tableNotes').html('');
      }

      else if (data["elements_modules"][0].length > 0) {
        var module = '';
        var rowpa = 1;
        var temp = data["moyenneSecondaire"].length-1;
        console.log();
        
        content = '\
        <table class="table table-responsive ">\
        <thead>\
        <th class="bg-primary"><center><h4>Matière</h4></center></th>\
        <th class="bg-primary"><center><h4>Coefficient</h4></center></th>\
        <th colspan="3" class="bg-primary"><center><h4>Notes</h4></center></th>\
        <th class="bg-primary"><center><h4>Moyenne</h4></center></th>\
        </thead>\
        <tbody>';

        for (var j = data["elements_modules"][0].length - 1; j >= 0; j--) {

          if (data["titre_elements_modules"][0][j]!=module) {

            rowpa = 0;            

            module = data["titre_elements_modules"][0][j];

            for (var i = data["elements_modules"][0].length - 1; i >= 0; i--) {

              if (data["titre_elements_modules"][0][i]==module) {
                rowpa++;
                console.log('rowpa = '+rowpa);
              }
            }

            module = data["titre_elements_modules"][0][j];
            content = content + '\
            <tr>\
            <td rowspan="'+rowpa+'">'+data["titre_elements_modules"][0][j]+'</td>\
            <td rowspan="'+rowpa+'"><center>'+data["coeff_element_module"][0][j]+'</center></td>\
            <td><center>'+data['libelle_type_test'][0][j]+'</center></td>\
            <td><center>'+data['notes'][0][j]+'</center></td>\
            <td><center>'+data['pourcentages_test'][0][j]+'%</center></td>\
            <td rowspan="'+rowpa+'"><center>'+data['moyenneSecondaire'][temp]+'</center></td></tr>';
            temp = temp - 1 ;

            console.log(temp);
          }
          else if(data["titre_elements_modules"][0][j]==module && rowpa >= 2){

            content = content + '\
            <tr>\
            <td><center>'+data['libelle_type_test'][0][j]+'</center></td>\
            <td><center>'+data['notes'][0][j]+'</center></td>\
            <td><center>'+data['pourcentages_test'][0][j]+'%</center></td>\
            </tr>';
            rowpa --;
          }

          

        }
        content = content + '\
        </tbody>\
        <tfoot class="bg-primary">\
        <th colspan="4"><center><h3>Note Générale</h3></center></th>\
        <th><center><h3>'+data['moyenneGenerale'][0]+'</h3></center></th>\
        <th></th>\
        </tfoot>\
        </table>';
        $('#tableNotes').html(content);
        $('#tableNotes').className ="table table-responsive";

      }
    },
    error: function(err){
      console.log(err);
    },
  });
}


//::::::::::::::::::::   FIN   ::::::::::::::::::::




function showPrintButton(id_cours){
  var id_cours = $('#elementModuleOfEtudiant').val();
  var div = document.getElementById("e_printDiv");
  if (id_cours=="") {
    div.innerHTML = '';
  }
  else{
    div.innerHTML = '<button class="btn btn-primary noPrint" id="btn-print_e" onclick="imprimer_page(); return false;"><i class="fa fa-print"></i> Imprimer le résultat</button>';
  }
}

function showPrintButton_p(id_cours){
  var div = document.getElementById("p_printDiv");
  if (id_cours=="") {
    div.innerHTML = '';
  }
  else{
    div.innerHTML = '<button class="btn btn-primary noPrint" id="btn-print_p" onclick="imprimer_page(); return false;"><i class="fa fa-print"></i> Imprimer</button>';
  }
}

function imprimer_page(){
  window.print();
}