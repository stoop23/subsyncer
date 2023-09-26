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
						<div class="index-file-selection__js col-9 mx-auto">
							<div class="intro-message mb-2">
								<h1>Subtitles,
									<span class="txt-rotate" data-period="2700"	data-rotate='["resynch&#39;ed.", "shifted.", "converted."]'>resynch&#39;ed.</span>
								</h1>
								<p class="m-0">Professional grade subtitle tools. Shift, Resync, Convert, Clean all your subtitles.</p>
							</div>
							<form enctype="multipart/form-data" action="/process.php" method="POST">
								<div class="file-upload-wrapper">
									<input name="file" type="file" id="file" class="file-upload-field" accept="<?php echo str_replace(",.sub (MicroDVD)", "" ,implode(",", $allowedExt)); ?>">
									<label for="file" id="file--label" data-text="Drop or Select your subtitle file: <?php echo str_replace("/.sub (MicroDVD)", "" ,implode("/", $allowedExt)); ?>" onclick="gtag('event', 'Click', {'event_category' : 'Upload','event_label' : 'Choose File'});">
										<strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path fill="currentcolor" d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>Choose a file…</strong>
									</label>
								</div>
								<div class="text-center position-relative">
									<div class="btn-list">
										<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" target="fps">
											<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg> -->
											FPS to FPS</a>
										<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" target="time">
											<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M544 224l-128-16-48-16h-24L227.158 44h39.509C278.333 44 288 41.375 288 38s-9.667-6-21.333-6H152v12h16v164h-48l-66.667-80H18.667L8 138.667V208h8v16h48v2.666l-64 8v42.667l64 8V288H16v16H8v69.333L18.667 384h34.667L120 304h48v164h-16v12h114.667c11.667 0 21.333-2.625 21.333-6s-9.667-6-21.333-6h-39.509L344 320h24l48-16 128-16c96-21.333 96-26.583 96-32 0-5.417 0-10.667-96-32z"></path></svg> -->
											Time Shift</a>
										<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" target="convert">
											<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M512.9 192c-14.9-.1-29.1 2.3-42.4 6.9L437.6 144H520c13.3 0 24-10.7 24-24V88c0-13.3-10.7-24-24-24h-45.3c-6.8 0-13.3 2.9-17.8 7.9l-37.5 41.7-22.8-38C392.2 68.4 384.4 64 376 64h-80c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h66.4l19.2 32H227.9c-17.7-23.1-44.9-40-99.9-40H72.5C59 104 47.7 115 48 128.5c.2 13 10.9 23.5 24 23.5h56c24.5 0 38.7 10.9 47.8 24.8l-11.3 20.5c-13-3.9-26.9-5.7-41.3-5.2C55.9 194.5 1.6 249.6 0 317c-1.6 72.1 56.3 131 128 131 59.6 0 109.7-40.8 124-96h84.2c13.7 0 24.6-11.4 24-25.1-2.1-47.1 17.5-93.7 56.2-125l12.5 20.8c-27.6 23.7-45.1 58.9-44.8 98.2.5 69.6 57.2 126.5 126.8 127.1 71.6.7 129.8-57.5 129.2-129.1-.7-69.6-57.6-126.4-127.2-126.9zM128 400c-44.1 0-80-35.9-80-80s35.9-80 80-80c4.2 0 8.4.3 12.5 1L99 316.4c-8.8 16 2.8 35.6 21 35.6h81.3c-12.4 28.2-40.6 48-73.3 48zm463.9-75.6c-2.2 40.6-35 73.4-75.5 75.5-46.1 2.5-84.4-34.3-84.4-79.9 0-21.4 8.4-40.8 22.1-55.1l49.4 82.4c4.5 7.6 14.4 10 22 5.5l13.7-8.2c7.6-4.5 10-14.4 5.5-22l-48.6-80.9c5.2-1.1 10.5-1.6 15.9-1.6 45.6-.1 82.3 38.2 79.9 84.3z"></path></svg> -->
											Convert File</a>
										<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" target="clean">
											<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32,384a95.4,95.4,0,0,0,32,71.09V496a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V480H384v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V455.09A95.4,95.4,0,0,0,480,384V336H32ZM496,256H80V69.25a21.26,21.26,0,0,1,36.28-15l19.27,19.26c-13.13,29.88-7.61,59.11,8.62,79.73l-.17.17A16,16,0,0,0,144,176l11.31,11.31a16,16,0,0,0,22.63,0L283.31,81.94a16,16,0,0,0,0-22.63L272,48a16,16,0,0,0-22.62,0l-.17.17c-20.62-16.23-49.83-21.75-79.73-8.62L150.22,20.28A69.25,69.25,0,0,0,32,69.25V256H16A16,16,0,0,0,0,272v16a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V272A16,16,0,0,0,496,256Z"></path></svg> -->
											Clean File</a>
										<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" target="utf8">
											<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32,384a95.4,95.4,0,0,0,32,71.09V496a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V480H384v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V455.09A95.4,95.4,0,0,0,480,384V336H32ZM496,256H80V69.25a21.26,21.26,0,0,1,36.28-15l19.27,19.26c-13.13,29.88-7.61,59.11,8.62,79.73l-.17.17A16,16,0,0,0,144,176l11.31,11.31a16,16,0,0,0,22.63,0L283.31,81.94a16,16,0,0,0,0-22.63L272,48a16,16,0,0,0-22.62,0l-.17.17c-20.62-16.23-49.83-21.75-79.73-8.62L150.22,20.28A69.25,69.25,0,0,0,32,69.25V256H16A16,16,0,0,0,0,272v16a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V272A16,16,0,0,0,496,256Z"></path></svg> -->
											Encode to UTF-8</a>
										<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" target="timecodeShift">
											<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32,384a95.4,95.4,0,0,0,32,71.09V496a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V480H384v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V455.09A95.4,95.4,0,0,0,480,384V336H32ZM496,256H80V69.25a21.26,21.26,0,0,1,36.28-15l19.27,19.26c-13.13,29.88-7.61,59.11,8.62,79.73l-.17.17A16,16,0,0,0,144,176l11.31,11.31a16,16,0,0,0,22.63,0L283.31,81.94a16,16,0,0,0,0-22.63L272,48a16,16,0,0,0-22.62,0l-.17.17c-20.62-16.23-49.83-21.75-79.73-8.62L150.22,20.28A69.25,69.25,0,0,0,32,69.25V256H16A16,16,0,0,0,0,272v16a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V272A16,16,0,0,0,496,256Z"></path></svg> -->
											Shift by Timecode</a>
									</div>
									<div class="settings mt-3">
										<div id="settingBtn-fps">
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
										<div id="settingBtn-time">
											<label for="time_shift">Add + Remove - (in milliseconds ex: -1000): </label>
											<input type="text" name="time_shift" size="10" maxlength="10" value="-1000" />
										</div>
										<div id="settingBtn-convert">
											<label for="ext_out">Desired Extension: </label>
											<select name="ext_out">
												<?php foreach($allowedExt as $value) {
													echo '<option value="' . $value .'">' . $value . '</option>';
												}
												?>
											</select>
										</div>
										<div id="settingBtn-clean" class="text-justify">
											<ul class="list-unstyled">
												<li>
													<input id="c0" type="checkbox" name="cleanList[]" value="0" checked>
													<label for="c0">Keep only the formating syntaxes corresponding to your file</label>
												</li>
												<li>
													<input id="c1" type="checkbox" name="cleanList[]" value="1">
													<label for="c1">Remove current file formating syntaxes</label>
												</li>
												<li>
													<input id="c2" type="checkbox" name="cleanList[]" value="2">
													<label for="c2">Remove text between parentheses ( )</label>
												</li>
												<li>
													<input id="c3" type="checkbox" name="cleanList[]" value="3">
													<label for="c3">Remove text between curly brackets { }</label>
												</li>
												<li>
													<input id="c4" type="checkbox" name="cleanList[]" value="4">
													<label for="c4">Remove text between square brackets [ ]</label>
												</li>
												<li>
													<input id="c5" type="checkbox" name="cleanList[]" value="5">
													<label for="c5">Remove text between angle brackets &lt; &gt;</label>
												</li>
												<!--<li>
													<input id="c6" type="checkbox" name="cleanList[]" value="6">
													<label for="c6">Remove text between asterisks * *</label>
												</li>-->
											</ul>
										</div>
										<div id="settingBtn-timecodeShift">
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
										<button type="submit" id="btn-fps" class="btn btn-primary btn-none btn-submit" name="fpstofps" value="FPS ReSync" onclick="gtag('event', 'Click', {'event_category' : 'Submit', 'event_label' : 'FPS Resync'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Resynchronize now!</button>
										<button type="submit" id="btn-time" class="btn btn-primary btn-none btn-submit" name="sub_shift" value="Time Shift" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'Time Shift'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Shift time now!</button>
										<button type="submit" id="btn-convert" class="btn btn-primary btn-none btn-submit" name="ext_change" value="Convert" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'Convert'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Convert your file now!</button>
										<button type="submit" id="btn-clean" class="btn btn-primary btn-none btn-submit" name="sub_clean" value="Clean" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'Clean'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Clean now!</button>
										<button type="submit" id="btn-utf8" class="btn btn-primary btn-none btn-submit" name="to_utf8" value="Encode" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'Encode'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Encode to UTF-8 now!</button>
										<button type="submit" id="btn-timecodeShift" class="btn btn-primary btn-none btn-submit" name="timecodeShift" value="timecodeShift" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'timecodeShift'});"><svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>Shift by timecode now!</button>
									</div>
								</div>
							</form>
						</div>
						<div class="index-file-selection col-9 mx-auto" style="display: none;">
							<div class="intro-message mb-2">
								<h1>Subtitle Tools</h1>
								<p class="m-0">Professional grade subtitle tools. Shift, Resync, Convert, Clean all your subtitles.</p>
							</div>
							<div class="text-center position-relative">
								<div class="btn-list">
									<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" href="/subtitle-fps-resync.php">
										<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg> -->
										FPS to FPS</a>
									<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" href="/subtitle-time-shifter.php">
										<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M544 224l-128-16-48-16h-24L227.158 44h39.509C278.333 44 288 41.375 288 38s-9.667-6-21.333-6H152v12h16v164h-48l-66.667-80H18.667L8 138.667V208h8v16h48v2.666l-64 8v42.667l64 8V288H16v16H8v69.333L18.667 384h34.667L120 304h48v164h-16v12h114.667c11.667 0 21.333-2.625 21.333-6s-9.667-6-21.333-6h-39.509L344 320h24l48-16 128-16c96-21.333 96-26.583 96-32 0-5.417 0-10.667-96-32z"></path></svg> -->
											Time Shift</a>
									<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" href="/subtitle-convert.php">
										<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M512.9 192c-14.9-.1-29.1 2.3-42.4 6.9L437.6 144H520c13.3 0 24-10.7 24-24V88c0-13.3-10.7-24-24-24h-45.3c-6.8 0-13.3 2.9-17.8 7.9l-37.5 41.7-22.8-38C392.2 68.4 384.4 64 376 64h-80c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h66.4l19.2 32H227.9c-17.7-23.1-44.9-40-99.9-40H72.5C59 104 47.7 115 48 128.5c.2 13 10.9 23.5 24 23.5h56c24.5 0 38.7 10.9 47.8 24.8l-11.3 20.5c-13-3.9-26.9-5.7-41.3-5.2C55.9 194.5 1.6 249.6 0 317c-1.6 72.1 56.3 131 128 131 59.6 0 109.7-40.8 124-96h84.2c13.7 0 24.6-11.4 24-25.1-2.1-47.1 17.5-93.7 56.2-125l12.5 20.8c-27.6 23.7-45.1 58.9-44.8 98.2.5 69.6 57.2 126.5 126.8 127.1 71.6.7 129.8-57.5 129.2-129.1-.7-69.6-57.6-126.4-127.2-126.9zM128 400c-44.1 0-80-35.9-80-80s35.9-80 80-80c4.2 0 8.4.3 12.5 1L99 316.4c-8.8 16 2.8 35.6 21 35.6h81.3c-12.4 28.2-40.6 48-73.3 48zm463.9-75.6c-2.2 40.6-35 73.4-75.5 75.5-46.1 2.5-84.4-34.3-84.4-79.9 0-21.4 8.4-40.8 22.1-55.1l49.4 82.4c4.5 7.6 14.4 10 22 5.5l13.7-8.2c7.6-4.5 10-14.4 5.5-22l-48.6-80.9c5.2-1.1 10.5-1.6 15.9-1.6 45.6-.1 82.3 38.2 79.9 84.3z"></path></svg> -->
										Convert File</a>
									<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" href="/subtitle-clean.php">
										<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32,384a95.4,95.4,0,0,0,32,71.09V496a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V480H384v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V455.09A95.4,95.4,0,0,0,480,384V336H32ZM496,256H80V69.25a21.26,21.26,0,0,1,36.28-15l19.27,19.26c-13.13,29.88-7.61,59.11,8.62,79.73l-.17.17A16,16,0,0,0,144,176l11.31,11.31a16,16,0,0,0,22.63,0L283.31,81.94a16,16,0,0,0,0-22.63L272,48a16,16,0,0,0-22.62,0l-.17.17c-20.62-16.23-49.83-21.75-79.73-8.62L150.22,20.28A69.25,69.25,0,0,0,32,69.25V256H16A16,16,0,0,0,0,272v16a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V272A16,16,0,0,0,496,256Z"></path></svg> -->
										Clean File</a>
									<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" href="/subtitle-utf8.php">
											<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32,384a95.4,95.4,0,0,0,32,71.09V496a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V480H384v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V455.09A95.4,95.4,0,0,0,480,384V336H32ZM496,256H80V69.25a21.26,21.26,0,0,1,36.28-15l19.27,19.26c-13.13,29.88-7.61,59.11,8.62,79.73l-.17.17A16,16,0,0,0,144,176l11.31,11.31a16,16,0,0,0,22.63,0L283.31,81.94a16,16,0,0,0,0-22.63L272,48a16,16,0,0,0-22.62,0l-.17.17c-20.62-16.23-49.83-21.75-79.73-8.62L150.22,20.28A69.25,69.25,0,0,0,32,69.25V256H16A16,16,0,0,0,0,272v16a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V272A16,16,0,0,0,496,256Z"></path></svg> -->
										Encode to UTF-8</a>
									<a class="btn col-7 col-lg-3 d-inline-flex align-items-center justify-content-center" href="/subtitle-timecode-shifter.php">
										<!-- <svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32,384a95.4,95.4,0,0,0,32,71.09V496a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V480H384v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V455.09A95.4,95.4,0,0,0,480,384V336H32ZM496,256H80V69.25a21.26,21.26,0,0,1,36.28-15l19.27,19.26c-13.13,29.88-7.61,59.11,8.62,79.73l-.17.17A16,16,0,0,0,144,176l11.31,11.31a16,16,0,0,0,22.63,0L283.31,81.94a16,16,0,0,0,0-22.63L272,48a16,16,0,0,0-22.62,0l-.17.17c-20.62-16.23-49.83-21.75-79.73-8.62L150.22,20.28A69.25,69.25,0,0,0,32,69.25V256H16A16,16,0,0,0,0,272v16a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V272A16,16,0,0,0,496,256Z"></path></svg> -->
										Shift by Timecode</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<?php include_once("parts-update.php"); ?>
		
			<?php include_once("parts-body1.php"); ?>

			<?php include_once("parts-body2.php"); ?>
			
			<script type="application/ld+json">
			{
				"@context": "http://www.schema.org",
				"@type": "SoftwareApplication",
				"name": "Subtitle Online Tools",
				"url": "https://subsyncer.com",
				"sameAs": [
					"https://www.subsyncer.com",
					"http://subsyncer.com",
					"http://www.subsyncer.com"
				],
				"logo": "https://subsyncer.com/img/subsyncer5_min.png",
				"description": "Free Online Subtitle Tools",
				"offers": {
					"@type": "Offer",
					"price": "0"
				},
				"applicationCategory": "https://schema.org/UtilitiesApplication",
				"aggregateRating": {
					"@type": "AggregateRating",
					"ratingValue": "4.8",
					"bestRating": "5",
					"reviewCount": "28639"
				}
			}
			</script>
			<script type="application/ld+json">
			{
			"@context": "http://schema.org",
			"@type": "HowTo",
			"name": "How to resynchronize subtitles in VLC?",
			"description": "There are 3 ways to temporarily synchronize your subtitle in VLC media player. Let me explain the first way:",
			"supply": [
				{
					"@type": "HowToSupply",
					"name": "SubSyncer"
				}
			],
			"tool": [
				{
					"@type": "HowToTool",
					"name": "SubSyncer"
				}
			],
			"step": [
				{
					"@type": "HowToStep",
					"url": "https://subsyncer.com",
					"image": "https://subsyncer.com",
					"text": "Press Shift+H when you hear a specific sentence.",
					"name": "Press Shift+H when you hear a specific sentence."
				}, {
					"@type": "HowToStep",
					"url": "https://subsyncer.com",
					"image": "https://subsyncer.com",
					"text": "Press Shift+J when this sentence appears in the subtitles.",
					"name": "Press Shift+J when this sentence appears in the subtitles."
				}, {
					"@type": "HowToStep",
					"url": "https://subsyncer.com",
					"image": "https://subsyncer.com",
					"text": "Press Shift+K to resynchronize the subtitles by the time difference between steps 1 and 2.",
					"name": "Press Shift+K to resynchronize the subtitles by the time difference between steps 1 and 2."
				}
			],
			"totalTime": "PT5S"
			}
			</script>

			<?php include_once("parts-footer.php"); ?>