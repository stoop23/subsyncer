<?php
	session_start();
	include("functions.php");
	include("var.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include_once("analyticstracking.php"); ?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="ジェイビ">
		<title>SubSyncer - Online SRT/SSA/SUB.. Subtitle Synchronizer !</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
		
	</head>
	<body>
		<header class="intro-header">
			<nav class="navbar navbar-expand-lg navbar-light">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
					<a class="navbar-brand" href="#"><img src="img/subsyncer5_min.png" height="50"></a>
					<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
						<li class="nav-item">
							<a class="nav-link" href="#about">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#privacy">Privacy</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#privacy">How it works</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="mailto:contact@subsyncer.com">Suggestion / Contact</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<main role="main" class="inner cover">
			<section id="main">
				<div class="container">
					<div class="row">
						<div class="col-9 mx-auto">
							<div class="intro-message mb-2">
								<h1>Subtitles 
									<span class="txt-rotate" data-period="3000"	data-rotate='["resynchronized.", "shifted.", "converted."]'></span>
								</h1>
							</div>
							<form enctype="multipart/form-data" action="process.php" method="POST">
								<div class="file-upload-wrapper">
									<input name="file" type="file" id="file" class="file-upload-field" accept="<?php foreach($allowedExt as $value) { echo $value . ", ";} ?>">
									<label for="file" id="file--label" data-text="<?php foreach($allowedExt as $value) { echo $value . "/";} ?>" onclick="gtag('event', 'Click', {'event_category' : 'Upload','event_label' : 'Choose File'});">
										<strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path fill="currentcolor" d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>Choose a file…</strong>
									</label>
								</div>	
								<!-- <div class="box">
									<input type="file" name="file" id="file-7" class="inputfile inputfile-6" data-multiple-caption="{count} files selected" multiple="">
									<label for="file-7">
										<span></span>
										<strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>Choose a file…</strong>
									</label>
								</div>-->
								<!--
								<div class="file-upload-wrapper" data-text="Select your file!">
									<input name="file-upload-field" type="file" class="file-upload-field" value="">
								</div>
								-->
								<div class="mt-2 text-center position-relative">
									<div class="btn-list">
										<a class="btn" target="fps">
											<svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z"></path></svg>FPS to FPS</a>
										<a class="btn" target="time">
											<svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M544 224l-128-16-48-16h-24L227.158 44h39.509C278.333 44 288 41.375 288 38s-9.667-6-21.333-6H152v12h16v164h-48l-66.667-80H18.667L8 138.667V208h8v16h48v2.666l-64 8v42.667l64 8V288H16v16H8v69.333L18.667 384h34.667L120 304h48v164h-16v12h114.667c11.667 0 21.333-2.625 21.333-6s-9.667-6-21.333-6h-39.509L344 320h24l48-16 128-16c96-21.333 96-26.583 96-32 0-5.417 0-10.667-96-32z"></path></svg>Time Shift</a>
										<a class="btn" target="convert">
											<svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M512.9 192c-14.9-.1-29.1 2.3-42.4 6.9L437.6 144H520c13.3 0 24-10.7 24-24V88c0-13.3-10.7-24-24-24h-45.3c-6.8 0-13.3 2.9-17.8 7.9l-37.5 41.7-22.8-38C392.2 68.4 384.4 64 376 64h-80c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h66.4l19.2 32H227.9c-17.7-23.1-44.9-40-99.9-40H72.5C59 104 47.7 115 48 128.5c.2 13 10.9 23.5 24 23.5h56c24.5 0 38.7 10.9 47.8 24.8l-11.3 20.5c-13-3.9-26.9-5.7-41.3-5.2C55.9 194.5 1.6 249.6 0 317c-1.6 72.1 56.3 131 128 131 59.6 0 109.7-40.8 124-96h84.2c13.7 0 24.6-11.4 24-25.1-2.1-47.1 17.5-93.7 56.2-125l12.5 20.8c-27.6 23.7-45.1 58.9-44.8 98.2.5 69.6 57.2 126.5 126.8 127.1 71.6.7 129.8-57.5 129.2-129.1-.7-69.6-57.6-126.4-127.2-126.9zM128 400c-44.1 0-80-35.9-80-80s35.9-80 80-80c4.2 0 8.4.3 12.5 1L99 316.4c-8.8 16 2.8 35.6 21 35.6h81.3c-12.4 28.2-40.6 48-73.3 48zm463.9-75.6c-2.2 40.6-35 73.4-75.5 75.5-46.1 2.5-84.4-34.3-84.4-79.9 0-21.4 8.4-40.8 22.1-55.1l49.4 82.4c4.5 7.6 14.4 10 22 5.5l13.7-8.2c7.6-4.5 10-14.4 5.5-22l-48.6-80.9c5.2-1.1 10.5-1.6 15.9-1.6 45.6-.1 82.3 38.2 79.9 84.3z"></path></svg>Convert File</a>
										<a class="btn" target="clean">
											<svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32,384a95.4,95.4,0,0,0,32,71.09V496a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V480H384v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V455.09A95.4,95.4,0,0,0,480,384V336H32ZM496,256H80V69.25a21.26,21.26,0,0,1,36.28-15l19.27,19.26c-13.13,29.88-7.61,59.11,8.62,79.73l-.17.17A16,16,0,0,0,144,176l11.31,11.31a16,16,0,0,0,22.63,0L283.31,81.94a16,16,0,0,0,0-22.63L272,48a16,16,0,0,0-22.62,0l-.17.17c-20.62-16.23-49.83-21.75-79.73-8.62L150.22,20.28A69.25,69.25,0,0,0,32,69.25V256H16A16,16,0,0,0,0,272v16a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V272A16,16,0,0,0,496,256Z"></path></svg>Clean File</a>
									</div>
									<div class="settings mt-4">
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
												<input id="c1" type="checkbox" name="cleanList[]" value="0" checked>
												<label for="c1">Formating syntaxes corresponding to your subtitle file</label>
											</li>
											<li>
												<input id="c2" type="checkbox" name="cleanList[]" value="1">
												<label for="c2">Text between parentheses ( )</label>
											</li>
											<li>
												<input id="c3" type="checkbox" name="cleanList[]" value="2">
												<label for="c3">Text between curly brackets { }</label>
											</li>
											<li>
												<input id="c4" type="checkbox" name="cleanList[]" value="3">
												<label for="c4">Text between square brackets [ ]</label>
											</li>
											<li>
												<input id="c5" type="checkbox" name="cleanList[]" value="4">
												<label for="c5">Text between angle brackets &lt; &gt;</label>
											</li>
											<li>
												<input id="c6" type="checkbox" name="cleanList[]" value="5">
												<label for="c6">Text between asterisks * *</label>
											</li>
										</ul>
    										<!--<input type="checkbox" id="strip_speaker_label" name="cleaning" value="strip_speaker_label" checked><label for="strip_speaker_label">Strip speaker labels</label>-->
										</div>
									</div>
									<div class="submit-list mt-3">
										<button type="submit" id="btn-fps" class="btn btn-primary btn-none" name="index_choice" value="FPS ReSync" onclick="gtag('event', 'Click', {'event_category' : 'Submit', 'event_label' : 'FPS Resync'});">Resynchronize now !</button>
										<button type="submit" id="btn-time" class="btn btn-primary btn-none" name="sub_shift" value="Time Shift" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'Time Shift'});">Shift time now !</button>
										<button type="submit" id="btn-convert" class="btn btn-primary btn-none" name="ext_change" value="Convert" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'Convert'});">Convert your file now !</button>
										<button type="submit" id="btn-clean" class="btn btn-primary btn-none" name="sub_clean" value="Clean" onclick="gtag('event', 'Click', {'event_category' : 'Submit','event_label' : 'Clean'});">Clean now !</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>

			<section class="overlap">
				<div class="container">
					<div class="row">
						<div class="col-11 mx-auto">
							<h2 class="section-heading" id="updates">Updates</h2>
							<div>
								<ul class="list-unstyled m-0">							
									<li>
										<date class="d-inline-block mb-0 mr-4">2020.11.05</date>
										<p class="d-inline-block mb-0">[FIXED] Carriage returns being skipped in .srt files. Thanks Johnny!</p>
									</li>
									<li>
										<date class="d-inline-block mb-0 mr-4">2018.03.27</date>
										<p class="d-inline-block mb-0">[NOTE] To avoid possible problems, make sure your file is encoded in UTF-8.</p>
									</li>
									<li>
										<date class="d-inline-block mb-0 mr-4">2018.01.15</date>
										<p class="d-inline-block mb-0">[FIXED] Incorrect time shifting when using decimals. Thanks Benjamin!</p>
									</li>
									<li>
										<date class="d-inline-block mb-0 mr-4">2017.11.28</date>
										<p class="d-inline-block mb-0">[ADDED] Filesize limit increased.</p>
									</li>
									<li>
										<date class="d-inline-block mb-0 mr-4">2017.11.15</date>
										<p class="d-inline-block mb-0">[FIXED] Line feeds being skipped in .srt files. (currently monitoring) Thanks Yvonne!</p>
									</li>
									<li>
										<date class="d-inline-block mb-0 mr-4">2017.03.28</date>
										<p class="d-inline-block mb-0">[ADDED] More format flexibility on .srt files.</p>
									</li>
								</ul>
							</div>
							<!-- <p class="lead" style="font-size: 16px;">01/09/2016 - [FIXED] .srt subtitles keys being unintentionally displayed.</p>-->
							<!-- <p class="lead" style="font-size: 16px;">31/08/2016 - [FIXED] Files encoding errors fixed. (Note: Tamil encoded in UTF-16LE not working)</p> -->
							<!-- <p class="lead" style="font-size: 16px;">09/08/2016 - [FIXED] .ass/.ssa custom headers/styles blocking the execution.</p> -->
							<!-- <p class="lead" style="font-size: 16px;">13/07/2016 - [FIXED] .ass/.ssa margins error causing the algorithm to stop.</p> -->
							<!-- <p class="lead" style="font-size: 16px;">13/07/2016 - [FIXED] .srt subtitles keys being unintentionally displayed.</p> -->
							<!-- <p class="lead" style="font-size: 16px;">10/05/2016 - [FIXED] .ass/.ssa not displaying the good ending time of subtitles.</p> -->
						</div>
					</div>
				</div>
			</section>
		
			<section class="content-section-a">
				<div class="container">
					<div class="row">
						<div class="col-6">
							<h2 class="section-heading" id="about">About SubSync<font color="#E04C5A">er</font></h2>
							<p>SubSyncer is an online tool able to re-synchronize subtitles in any languages and in the most popular subtitles formats. It currently supports:
								<ul>
									<?php foreach($allowedExt as $value) {
										echo '<li>' . $value . '</li>';
									}
									?>
								</ul>This was originally a personal project that I public. I am always looking to improve the algorithm further so <b>if you have any problems, feedbacks or suggestions please don't hesitate to send me an e-mail at:<a class="mail">contact@subsyncer.com</a> <button class="btn" data-clipboard-target=".mail">Copy</button></b></p>
						</div>
						<div class="col-6">
							<img class="img-fluid" src="coding.jpg" alt="">
						</div>
					</div>
				</div>
			</section>
		<?php 
if(isset($_POST['submit'])){
    $to = "contact@subsyncer.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subject = "Form submission";
    $subject2 = "Copy of your form submission";
    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    }
?>
			<section class="suggestion">
<form action="" method="post">
First Name: <input type="text" name="first_name"><br>
Last Name: <input type="text" name="last_name"><br>
Email: <input type="text" name="email"><br>
Message:<br><textarea rows="5" name="message" cols="30"></textarea><br>
<input type="submit" name="submit" value="Submit">
</form>
			</section>
			<section class="dark">
				<div class="container">
					<div class="row">
						<div class="col-11 mx-auto">
							<h2 class="section-heading" id="privacy">Privacy and<br>Personal Informations</h2>
							<div>
							This website does not record any browsing informations. Re-synchronized subtitle files are uploaded upon submission and temporarily (30~60 days) saved on this server. Files will not be shared with other third-party websites and may only be used to improve this tool's accuracy :)
							</div>
						</div>
					</div>
				</div>
			</section>

			<aside class="aside--fixed">
				<div class="aside--child text-center">
					<div class="container updatealert mb-0 pb-0" role="alert">
						<div class="row">
							<div class="col-8 mx-auto">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<b>Welcome to the new Subsyncer!</b><br />A new design, .vtt files support, new features and lots of adjustments, I truly hope you will like it!<br />Thank you for your support!
								<!--<ul class="mb-0">
									<li class="text-left">New file support: .srt, .ass, .ssa, .sub, <b>.vtt</b></li>
									<li class="text-left">You can now convert your files! (example: .ssa -> .srt)</li>
								</ul>-->
								<!--<button type="button" class="btn btn-primary btn-sm closealert">Your welcome!</button>-->
							</div>
						</div>
					</div>
					<style>.bmc-button img{height: 34px !important;width: 35px !important;margin-bottom: 1px !important;box-shadow: none !important;border: none !important;vertical-align: middle !important;}.bmc-button{padding: 7px 10px 7px 10px !important;line-height: 35px !important;height:51px !important;min-width:217px !important;text-decoration: none !important;display:inline-flex !important;color:#ffffff !important;background-color:#FF813F !important;border-radius: 5px !important;border: 1px solid transparent !important;padding: 7px 10px 7px 10px !important;font-size: 28px !important;letter-spacing:0.6px !important;;margin: 0 auto !important;font-family:'Cookie', cursive !important;-webkit-box-sizing: border-box !important;box-sizing: border-box !important;-o-transition: 0.3s all linear !important;-webkit-transition: 0.3s all linear !important;-moz-transition: 0.3s all linear !important;-ms-transition: 0.3s all linear !important;transition: 0.3s all linear !important;}.bmc-button:hover, .bmc-button:active, .bmc-button:focus {-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;text-decoration: none !important;box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;opacity: 0.85 !important;color:#ffffff !important;}</style><link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet"><a class="bmc-button" target="_blank" href="https://www.buymeacoffee.com/subsyncer"><img src="https://cdn.buymeacoffee.com/buttons/bmc-new-btn-logo.svg" alt="Buy me a coffee"><span style="margin-left:15px;font-size:28px !important;">Buy me a coffee</span></a>
				</div>
			</aside>

			<footer>
				<div class="container">
					<div class="row">
						<div class="col-11 mx-auto">
							Created with 
							<svg aria-hidden="true" title="love" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"></path></svg>
						</div>
					</div>
				</div>
			</footer>
		</main>
		<!-- jQuery -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/custom-file-input.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript">
		jQuery(function(){
			jQuery('.btn-list a').click(function(){
				//jQuery('.btn-list').hide();
				$('.btn-list a').removeClass('active');
				$(this).addClass('active');
				jQuery('#btn-fps, #btn-time, #btn-convert, #btn-clean').hide();
				jQuery('#settingBtn-fps, #settingBtn-time, #settingBtn-convert, #settingBtn-clean').css('display', 'none');
				jQuery('#btn-'+$(this).attr('target')).show();
				jQuery('#settingBtn-'+$(this).attr('target')).css('display', 'inline-block');
			});
		});
		</script>
		<script>
			var TxtRotate = function(el, toRotate, period) {
  this.toRotate = toRotate;
  this.el = el;
  this.loopNum = 0;
  this.period = parseInt(period, 10) || 2000;
  this.txt = '';
  this.tick();
  this.isDeleting = false;
};

TxtRotate.prototype.tick = function() {
  var i = this.loopNum % this.toRotate.length;
  var fullTxt = this.toRotate[i];

  if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

  var that = this;
  var delta = 300 - Math.random() * 100;

  if (this.isDeleting) { delta /= 2; }

  if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
  } else if (this.isDeleting && this.txt === '') {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
  }

  setTimeout(function() {
    that.tick();
  }, delta);
};

window.onload = function() {
  var elements = document.getElementsByClassName('txt-rotate');
  for (var i=0; i<elements.length; i++) {
    var toRotate = elements[i].getAttribute('data-rotate');
    var period = elements[i].getAttribute('data-period');
    if (toRotate) {
      new TxtRotate(elements[i], JSON.parse(toRotate), period);
    }
  }
  // INJECT CSS
  var css = document.createElement("style");
  css.type = "text/css";
  css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #666 }";
  document.body.appendChild(css);
};
		</script>
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
	</body>
</html>