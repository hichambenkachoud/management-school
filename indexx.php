<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
session_start();
include'functions.php';
if ((!isset($_SESSION['email_etudiant']) || !isset($_SESSION['code_prof'])) && !isset($_SESSION['type_user'])){
  header('location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MundiaSis</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="dist/css/print.css" type="text/css" media="print" />
</head>

<body class="skin-blue layout-top-nav">
  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="indexx.php?page=<?php
          if (isset($_SESSION['code_prof'])) {
            echo "p_notes";
          }
          elseif (isset($_SESSION['email_etudiant'])) {
            echo "e_notes";
          }
          ?>" class="navbar-brand"><b>Mundia</b>Sis</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="indexx.php?page=<?php
              if (isset($_SESSION['code_prof'])) {
                echo "p_notes";
              }
              elseif (isset($_SESSION['email_etudiant'])) {
                echo "e_notes";
              }
              ?>">Notes</a></li>
              <li><a href="indexx.php?page=p_absences">Absences</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown user user-menu">
                <a href="?page=profile_user">
                    <img src="<?php echo $_SESSION['profile_image']; ?>" width="30" height="30" class="user-image" alt="User Image">
                    <span class=\"hidden-xs\"><?php echo getNomPrenomConnectedUser(); ?></span>
                                      <small>
                    <?php 
                    if (getConnectedUserType() == "prof") {
                      echo " - Professeur";
                    }
                    elseif (getConnectedUserType() == "stud") {
                      echo " - Etudiant";
                    }
                    ?>

                  </small>

                </a>
              </li>
              <li>
                <a href="#" id="btn-logout">
                  <span class="glyphicon glyphicon-log-out"></span>
                  Deconnexion
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <div class="content-wrapper">
      <div id="message" class=""></div>
      <?php 
      if (isset($_GET['page'])) {
        if ($_GET['page']=='p_notes') {
          include 'p_notes.php';
        }
        if ($_GET['page']=='e_notes') {
          include 'e_notes.php';
        }
        if ($_GET['page']=='profile_user') {
          include 'profile.php';
        }
        if ($_GET['page']=='uploadFile') {
          include 'uploadFile.php';
        }
        if ($_GET['page']=='dmf') {
          include 'downloadMarksFile.php';
        }
      }
      ?>

    </div>


    <!--POP-UP-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <div class="modal-body" id="modal-bodyku">
          </div>
          <div class="modal-footer" id="modal-footerq">
          </div>
        </div>
      </div>
    </div>

  <!--
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2017 <a href="http://mundiapolis.ma">Universite Mundiapolis</a>.</strong> All rights
    reserved.
  </footer>
  ./wrapper -->

  <!-- jQuery 2.2.3 -->
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src=""></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <script src="plugins/knob/jquery.knob.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>
  <script>
    $(document.body).on('click', '#btn-logout',  function() {
      console.log("dkjcnjkdnjk");
      localStorage.setItem("id_cours", "");
      $.ajax({
        url:'ajax.php?action=logout',
        type: 'GET',
        success : function(data){
          window.location= data;
        },
        error : function(err){
          console.log(err);
        }
      });
    });
  </script>
</body>
</html>