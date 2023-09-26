<?php
	session_start();
	require_once("functions.php");
	require_once("var.php");
	include_once("parts-header.php");
	$bmc = TRUE;
?>
		<main role="main">
			<section id="main">
				<div class="container">
					<div class="row">
						<div class="col-9 mx-auto">
							<div class="intro-message mb-2">
								<h1>Resync Subtitles</h1>
								<p class="m-0">Resynchronize all your subtitles to your desired FPS.</p>
							</div>
							<form enctype="multipart/form-data" action="/process.php" method="POST">
								<div class="file-upload-wrapper">
									<input name="file" type="file" id="file" class="file-upload-field" accept="<?php echo str_replace(",.sub (MicroDVD)", "" ,implode(",", $allowedExt)); ?>">
									<label for="file" id="file--label" data-text="Drop or Select your subtitle file: <?php echo str_replace("/.sub (MicroDVD)", "" ,implode("/", $allowedExt)); ?>" onclick="gtag('event', 'Click', {'event_category' : 'Upload','event_label' : 'Choose File'});">
										<strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path fill="currentcolor" d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>Choose a file…</strong>
									</label>
								</div>
								<input style="display:none;" name="file" type="file" id="file__nojs" accept="<?php echo str_replace(",.sub (MicroDVD)", "" ,implode(",", $allowedExt)); ?>" />
								<script>document.getElementById("file__nojs").disabled = true;</script>
								<div class="text-center position-relative">
									<div class="settings mt-3">
										<div id="settingBtn-fps" style="display: block;">
											<div class="d-inline-block">
												<label for="fps_in">Current FPS: </label>
												<select name="fps_in">
													<?php foreach($allowedFps as $value) {
														echo '<option value="' . $value .'">' . $value . '</option>';
													}
													?>
												</select>
											</div>
											<div class="d-inline-block">
												<label for="fps_out">Desired FPS: </label>
												<select name="fps_out">
													<?php foreach($allowedFps as $value) {
														echo '<option value="' . $value .'">' . $value . '</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="submit-list mt-3">
										<button type="submit" id="btn-fps" class="btn btn-primary btn-submit" name="fpstofps" value="FPS ReSync" onclick="gtag('event', 'Click', {'event_category' : 'Submit', 'event_label' : 'FPS Resync'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Resynchronize now!</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>

			<?php include_once("parts-update.php"); ?>

			<section>
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h1>Subtitle Re-Synchronization</h1>
						</div>
						<div class="col-md-6">
							<h3>What is subtitle re-synchronization?</h3>
							<p>Subtitle re-synchronization is the fact to re-align subtitles (dialogue cues) with a video.</p>
							<p>Subtitles can be found out of sync due various reasons. It can be due to the number of frames per second (FPS) of a video or it can be due to the video being longer or shorter.</p>
						</div>
						<div class="col-md-6">
							<h3>How to re-synchronize subtitles?</h3>
							<p>There are a couple of different ways to resynchronize subtitles. You can resynchronize by:</p>
							<ul>
								<li>Time shifting (linear shift), using VLC or this tool.</li>
								<li>FPS to FPS shifting (gradual shift) using this tool.</li>
							</ul>
							<p>SubSyncer can shift all your cues by time and by FPS in just one click.</p>
						</div>
						<div class="col-12">
							<h3>How does it work?</h3>
							<p>The algorithm transforms all timecodes in milliseconds for processing.</p>
							<p>All timings are then transformed following your desired output FPS. This will result in a graduale shift of all cues. The file is then recreated without any other alterations.</p>
						</div>
					</div>
				</div>
			</section>
		
			<?php include_once("parts-body1.php"); ?>

			<?php include_once("parts-body2.php"); ?>

			<?php include_once("parts-footer.php"); ?>