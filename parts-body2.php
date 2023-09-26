			<section id="resync-subtitle">
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
					</div>
				</div>
			</section>

			<section id="shift-subtitle">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h1>Subtitle Time Shifting</h1>
						</div>
						<div class="col-md-6">
							<h3>What is subtitle time shifting?</h3>
							<p>Subtitle time shifting is the fact to move all subtitles (dialogue cues) by a certain time.</p>
							<p>There are many reasons for such issue. This may be due to the video being cut shorter or made longer.</p>
						</div>
						<div class="col-md-6">
							<h3>How to time shift subtitles?</h3>
							<p>There are a couple of different ways to time shift subtitles. You can do it by following one of the methods below:</p>
							<ul>
								<li>Using VLC: Press G to add a 50 milliseconds delay or press H to remove 50 milliseconds delay (fasten).</li>
								<li>You can use SubSyncer's shifting tool to permanently shift your subtitles.</li>
							</ul>
						</div>
					</div>
				</div>
			</section>

			<section>
				<div class="container">
					<div class="row">
						<div class="col-12 pb-4">
							<h2 class="text-center">All subtitle tools in one click</h2> <!-- <font color="#E04C5A"> -->
						</div>
						<div class="col-md-6 pb-4">
							<h4 class="section-heading">Re-Synchronize</h4>
							<p>Subtitles are slowly becoming out of sync?<br/>This is due to the number of frames per second (FPS) of videos that will result in subtitles become slightly delayed over time.<br />
							This tool gets the FPS of the original subtitle file and changes all cues' timings according to your video's FPS.</p>
							<p><b>Supported formats: ALL</b> (<?php echo str_replace(",.sub (MicroDVD)", "" ,implode(",", $allowedExt)); ?>)</p>
						</div>
						<div class="col-md-6 pb-4">
							<h4 class="section-heading">Time Shift</h4>
							<p>All cues are out of sync by the same interval?<br />This may be due to your video being cut shorter or longer at some places.<br />
							This tool can shift all cues by the same time interval at once. You can choose to fasten or delay all cues in milliseconds, and shift the subtitles until it fits your video.</p>
							<p><b>Supported formats: ALL</b> (<?php echo str_replace(",.sub (MicroDVD)", "" ,implode(",", $allowedExt)); ?>)</p>
						</div>
						<div class="col-md-6 pb-4">
							<h4 class="section-heading">Convert</h4>
							<p>Different video players support different file formats.<br />Or it could be that you want more flexibility using one format over another.<br />
							SubSyncer's conversion tool can convert your subtitle files to your desired format. When possible, it will automatically translate all cue syntaxes to fit the new file format!</p>
							<p><b>Supported formats: ALL</b> (<?php echo str_replace(",.sub (MicroDVD)", "" ,implode(",", $allowedExt)); ?>)</p>
						</div>
						<div class="col-md-6 pb-4">
							<h4 class="section-heading">Clean</h4>
							<p>Syntaxes are specific to subtitle file formats.<br />Some files may have wrong syntaxes or may include closed captions.<br />
							SubSyncer's cleaning tool allows you to remove all syntaxes that may not be suitable or that you do not want (ex: Closed Captions). You can decide what to keep or what to remove.</p>
							<p><b>Supported formats: ALL</b> (<?php echo str_replace(",.sub (MicroDVD)", "" ,implode(",", $allowedExt)); ?>)</p>
						</div>
					</div>
				</div>
			</section>

			<?php include_once("parts-faq.php"); ?>

			<section>
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<h2 id="about">About SubSync<font color="#E04C5A">er</font></h2>
							<p>This was originally a personal project that originated from my own need in having such tools without downloading any software. I decided to make it public and free of use so that everyone can enjoy this tool.<br />I am always looking to improve the website/algorithm further so <b>if you have any problem, feedback or suggestion please send me an e-mail. I will answer within 48 hours.</b></p>
							<div class="box">
								<a href="mailto:contact@subsyncer.com" class="mail">contact@subsyncer.com</a><button class="btn copy" data-clipboard-target=".mail">Copy</button>
							</div>
						</div>
						<div class="col-md-6">
							<img class="img-fluid" src="/img/coding.min2.jpg" loading="lazy" width="540" height="288" alt="About SubSyncer">
						</div>
					</div>
				</div>
			</section>
			
			<section id="privacy">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h2>Privacy and<br>Personal Informations</h2>
							<div>
								<p>This website does not record any browsing informations. Subtitle files are uploaded upon submission and temporarily saved for 60 days on the server. Files will not be shared with other third-parties and may only be used to improve this tool's accuracy.</p>
							</div>
						</div>
					</div>
				</div>
			</section>