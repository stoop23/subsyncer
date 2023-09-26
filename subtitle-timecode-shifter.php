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
								<h1>Shift Subtitles By Timecodes</h1>
								<p class="m-0">Shift all your subtitles by timecodes.</p>
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
										<div id="settingBtn-timecodeShift" style="display: block;">
											<div class="d-inline-block">
												<label for="timecodeStart">First cue's beginning timecode: </label>
												<input type="time" name="timecodeStart" value="00:00:01.500" step="0.001"><a class="timecodeShiftDisable" target="timecodeStart">Ignore</a>
											</div>
											<div class="d-inline-block">
												<label for="timecodeEnd">Last cue's beginning timecode: </label>
												<input type="time" name="timecodeEnd" value="00:00:30.500" step="0.001"><a class="timecodeShiftDisable" target="timecodeEnd">Ignore</a>
											</div>
											<p style="margin:5px 0;">Format: hours&nbsp;<b>:</b>&nbsp;minutes&nbsp;<b>:</b>&nbsp;seconds&nbsp;<b>,</b>&nbsp;milliseconds</p>
										</div>
									</div>
									<div class="submit-list mt-3">
										<button type="submit" id="btn-timecodeShift" class="btn btn-primary btn-submit" name="timecodeShift" value="timecodeShift" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'timecodeShift'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Shift by timecode now!</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>

			<?php include_once("parts-update.php"); ?>
		
			<?php include_once("parts-body1.php"); ?>

			<?php include_once("parts-body2.php"); ?>

			<?php include_once("parts-footer.php"); ?>