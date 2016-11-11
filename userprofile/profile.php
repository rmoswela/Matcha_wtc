<?php
session_start();
if (!isset($_SESSION['user_id']))
{
	header("location:../login/login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION['username']; ?></title>
	<link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body>

<div class="header default-primary-color">

	<h3>
		<?php echo "<p>".$_SESSION['username']."</p>"; ?>
	</h3>
</div>


	<div class="content">
		<div class="container">

			<div class="menu dark-primary-color">
			<div class="col-30" style="border-right: 1px solid #ccc;">
					<h3 id="photosButton">Photos</h3>
				</div>
				<div class="col-30" style="border-right: 1px solid #ccc;">
					<h3 id="updateButton">UpdateProfile</h3>
				</div>
				<div class="col-30" style="border-right: 1px solid #ccc;">
					<h3 id="likesButton">Likes</h3>
				</div>
				<div class="col-30" style="border-right: 1px solid #ccc;">
					<h3 id="fameButton" >Fame</h3>
				</div>
			</div>
		</div>

		<div class="container">
		<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
		<!-- UPDATE PROFILE PAGE -->

			<div id="update" class="hidden page form">
				<form id="profileForm" enctype="multipart/form-data" action="php/profile.php">
					<div class="col-50 side">
						<p>
							<label class="left-label">Firstname</label>
							<input class="left-input"type="text" name="firstname" value="<?php echo $_SESSION['firstname'] ?>">
						</p>
						<p>
							<label class="left-label">Lastname</label>
							<input class="left-input"type="text" name="lastname" value="<?php echo $_SESSION['lastname'] ?>">
						</p>
						<p>
							<label class="left-label">Email </label>
							<input class="left-input"type="email" name="email" value="<?php echo $_SESSION['email'] ?>">
						</p>
					</div>

					<div class="col-50 side">
						<p>I am a
							<select name="age" id="age">
								<option selected="selected" disabled="disabled">AGE</option>
							</select>
						years old
						<select id="gender" name="gender">
							<option value="bisexual">Bisexual</option>
							<option value="man">man</option>
							<option value="woman">woman</option>
						</select>
						</p>

						<p>
							Looking for a
							<select id="lookingFor" name="lookingFor">
								<option value="bisexual">Bisexual</option>
								<option value="man">man</option>
								<option value="woman">woman</option>
							</select>
						</p>
						<p>
							From age :
							<select id="beginAge" name="beginAge">
							</select>
							To
							<select id="toAge" name="toAge">
							</select>
						</p>
						<p>
							<label>Preferences</label>
							<input id="preferences" type="text" name="preferences" placeholder="#vegena, #geek, #piercing, etc">
						</p>
						<p>
							<label><input type="checkbox" name="locationEnable"> Share your location</label>
						</p>
						<p>
							<label>Biography</label>
							<br>
							<textarea name="biography" id="biography">
							</textarea>
						</p>
						<input type="submit" name="profileForm" value="submit">
					</div>
				</form>
			</div>

			<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
			<!-- LIKES PAGE -->
			<div id="likes" class="hidden page">
				<h3>Likes</h3>
			</div>


			<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
			<!-- UPLOAD IMAGES PAGE -->
			<div id="photos" class="hidden page">
				<h3>Photos</h3>
				<div class="left col-50 side">
					<button id="showUpload">Upload photos</button>
					<div class="row" id="photo-upload-div">
						<p>

							<form id="photosForm" method="post" action="php/profile.php" enctype="multipart/form-data">
								<p>
									<label>Profile picture</label>
									<input type="file" accept="image/*" name="profile">
								</p>
								<p>
									<label>Select four(4) images</label>
									<input type="file" accept="image/*" name="photos[]" multiple="multiple">
								</p>
								<p>
									<input type="submit" name="uploadPhotos" value="Upload Photos">
								</p>
							</form>

						</p>
					</div>
				</div>
				<div class="right col-50 side" id="userImagesDisplay">

				</div>
			</div>


			<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
			<!-- FAME RATING PAGE -->
			<div id="fame" class="hidden page">
				<h3>Fame</h3>
			</div>

		</div>
	</div>
</body>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/profile.js"></script>
</html>
