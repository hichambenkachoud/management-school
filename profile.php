<?php

if ((!isset($_SESSION['email_etudiant']) || !isset($_SESSION['code_prof'])) && !isset($_SESSION['type_user'])){
  header('location: index.php');
}

?>

<section class="content-header">
	<h1>
		Profile de <?php echo getNomPrenomConnectedUser();?> 
		<small> - Gestion du profile</small>
	</h1>
</section>
<section class="content">
	<div class="container" id="target">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-sm-offset-1 col-md-offset-3 col-lg-offset-3 toppad" >
				<div class="panel panel-info" style="">
					<div class="panel-heading">
						<h3 class="panel-title"><strong> <?php echo getNomPrenomConnectedUser(); ?></strong></h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3 col-lg-3 " align="center"> 
								<img src="dist/img/avatar.png" class="profile-user-img img-responsive img-circle" alt="User profile picture"> 
							</div>
							<div class=" col-md-9 col-lg-9 ">
								<form method="POST">
									<table class="table table-user-information">
										<tbody>
											<?php echo getConnectedUserProfile(); ?>
											<tr>
												<td colspan=2 align=center>
													<a href="#" id="btn-modifier-info-perso-<?php 
													if (getConnectedUserType() == "prof") {
														echo "prof";
													}
													elseif (getConnectedUserType() == "stud") {
														echo "stud";
													}
													?>" class="btn btn-default">Modifier informations personnelles</a>
												</td>
											</tr>                
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="dist/js/functions.js"></script>