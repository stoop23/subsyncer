<?php
	session_start();
	require_once("functions.php");
	require_once("var.php");
	include_once("parts-header.php");
	$bmc = TRUE;
?>
<?php
/********GET VERIF********/
// get.php?d=202005?t=testUTF.srt
// http://subsyncer/get.php?d=202005&t=testUTF.srt
if (isset($_GET['d']) AND !empty($_GET['d']) AND isset($_GET['t']) AND !empty($_GET['t'])) {
	// Si formulaire envoyé on vérifie le fichier
	$tempFile = new SplFileInfo(str_replace('/', '_', $_GET['t']));
	$fileOutputExtension = ".".$tempFile->getExtension();
	$fileInputName = $tempFile->getBasename($fileOutputExtension);
	$dateFolder = str_replace('/', '_', $_GET['d']);
	// echo "<br />fileOutputExtension=".$fileOutputExtension;
	// echo "<br />fileInputName=".$fileInputName;
	// echo "<br />dateFolder=".$dateFolder;
	if (in_array($fileOutputExtension, $allowedExt)) { // If extension is valid
		if (preg_match("/^\d{6,8}$/", $dateFolder)) { // If folder name is only numbers and has a length of 8 corresponding to YYYYMMDD
			$path = "d" .DIRECTORY_SEPARATOR. "d" . $dateFolder .DIRECTORY_SEPARATOR. filenameSanitizer($fileInputName) . $fileOutputExtension;
			if(file_exists($path)) {
				$selected_file = $fileInputName;
			} else {
				$error = "The file may have been removed or is not valid anymore.";
			}
			clearstatcache();
		} else {
			$error = "Folder not valid.";
		}
	} else {
		$error = "File extension not valid.";
	}
} else {
	$error = "Link not valid.";
}
?>
		<main role="main">
			<section id="main">
				<div class="container">
					<div class="row">
						<div class="col-9 mx-auto">
							<div class="intro-message mb-2">
								<h1><?php echo (empty($error) ? "Your file:" : $error); ?></h1>
								<?php if(empty($error)) { ?>
								<p class="mb-0 d-flex align-items-center">
									<svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M352 320c-22.608 0-43.387 7.819-59.79 20.895l-102.486-64.054a96.551 96.551 0 0 0 0-41.683l102.486-64.054C308.613 184.181 329.392 192 352 192c53.019 0 96-42.981 96-96S405.019 0 352 0s-96 42.981-96 96c0 7.158.79 14.13 2.276 20.841L155.79 180.895C139.387 167.819 118.608 160 96 160c-53.019 0-96 42.981-96 96s42.981 96 96 96c22.608 0 43.387-7.819 59.79-20.895l102.486 64.054A96.301 96.301 0 0 0 256 416c0 53.019 42.981 96 96 96s96-42.981 96-96-42.981-96-96-96z" class=""></path></svg>
									Easy to share! All links are valid for 60 days.<!-- <a href="#explanation">Explain me how it works.</a>-->
								</p>
								<?php } ?>
							</div>
							<?php if(empty($error)) { ?>
							<!-- <div class="d-flex align-items-center mb-2">
								<div class="mr-auto"><?php echo (empty($selected_file) ? "No file selected" : htmlspecialchars($selected_file . $fileOutputExtension)); ?></div>
								<div class="ml-2"><a class="" data-clipboard-target=".link" onclick="gtag('event', 'Click', {'event_category' : 'Get','event_label' : 'Copy Link'});" style="display: inline-block;">Copy the link</a></div>
								<div class="ml-2"><a href="<?php echo htmlspecialchars($path); ?>" class="btn btn-primary link" onclick="gtag('event', 'Click', {'event_category' : 'Get','event_label' : 'Download Action'});" style="display: inline-block;" download>Download now!</a></div>
							</div>-->
							<div class="d-flex align-items-center mb-2" style="height: 48px;line-break:anywhere;">
								<div class="file-name"><?php echo (empty($selected_file) ? "No file selected" : htmlspecialchars($selected_file . $fileOutputExtension)); ?></div>
								<div class="file-utilities">
									<a class="copy" data-clipboard-target=".link" onclick="gtag('event', 'Click', {'event_category' : 'Download','event_label' : 'Copy Link'});">Copy the link</a>
									<a href="<?php echo htmlspecialchars($path); ?>" class="btn btn-primary link" onclick="gtag('event', 'Click', {'event_category' : 'Get','event_label' : 'Download Action'});" style="display: inline-block;" download>Download now!</a>
								</div>
							</div>
							<?php } ?>
							<div style="height: 150px;background:transparent;" class="box"></div>
						</div>
					</div>
				</div>
			</section>

			<?php include_once("parts-update.php"); ?>
		
			<?php include_once("parts-body1.php"); ?>

			<?php include_once("parts-body2.php"); ?>

			<?php include_once("parts-footer.php"); ?>