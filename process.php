<?php
	session_start();
	require_once("functions.php");
	require_once("var.php");
	include_once("parts-header.php");
?>
<?php
/********POST VERIF********/
if (isset($_POST['fpstofps']) OR isset($_POST['sub_shift']) OR isset($_POST['ext_change']) OR isset($_POST['sub_clean']) OR isset($_POST['to_utf8']) OR isset($_POST['timecodeShift'])) {
	// Si formulaire envoyé on vérifie le fichier
	if (isset($_FILES["file"]) AND !empty($_FILES["file"])) { // Si on a les 2 variables
		$log_uploaded_file = TRUE;

		if ($_FILES['file']['error']) { // Si erreur
			$error = "There was an issue with this file. You may need to choose another file. " . $_FILES["file"]["error"];
		}
		elseif ($_FILES['file']['size'] > $maxsize) { // Sinon si taille trop grande
			$error = "The file is too big.";
		}
		elseif ($_FILES['file']['size'] == 0) {
			$error = "The file seems to be empty.";
		}
		else {
			$uploaded_file = new SplFileInfo(str_replace('/', '_', $_FILES["file"]["name"]));
			$uploadExtension = ".".$uploaded_file->getExtension();
			if (in_array($uploadExtension, $allowedExt)) { // Si extension valide
				$target_path = $dir_in . basename($_FILES["file"]["name"]);
				if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
					//$str_file = file_get_contents_utf8($target_path); // Before 19/05/2020
					$str_file = file_get_contents($target_path); // After 19/05/2020
					$fileInputName = $uploaded_file->getBasename($uploadExtension);
					$trueExtension = $uploadExtension;
					$saveExtension = $uploadExtension;

					include_once("encoding.php");

					$upload = TRUE;

					//Makes sure the file has enough empty lines to ensure regex to work properly.
					$str_file = $str_file . "\r\n\r\n";

					foreach($regexArray as $key => $value) {
						if(array_key_exists($key, $regexArrayHeader)) {
							if($sep = preg_split($regexArrayHeader[$key], $str_file, 0, PREG_SPLIT_DELIM_CAPTURE)) {
								if(count($sep) == 3) {
									$fileContent = trim($sep[1]) . "\r\n";
									$str_file = $sep[2];
								} elseif (!in_array($key, $optionalHeader)) {
									continue;
									// If header for vtt cannot be found then cannot be vtt as header is compulsory.
								}
							}
						}
						if(preg_match_all($value, $str_file, $matches, PREG_SET_ORDER)) {
							if($key != $trueExtension) { //If key same as extension then no need for advice
								if(!($key == ".sub (MicroDVD)" AND $trueExtension == ".sub")) {
									if(($trueExtension == ".ssa" AND $key == ".ass") OR ($trueExtension == ".ass" AND $key == ".ssa")) {
									} else {
										$advice = "Warning: Your original file has the wrong extension. Cues formatting indicates that it actually is a $key file. I would strongly recommend converting it to the proper extension. You can go back to the <a href='https://subsyncer.com'>home page</a> and select convert to $key.";
									}
								}
								$trueExtension = $key;
							}
							$error = "";
							break;
						} else {
							$error = "Sorry, your file cannot be recognized as valid. Please try with another file.";
						}
					}



					/*
					$preg_match = $regexArray[$uploadExtension];

					/* Test the cues separation using preg_match_all
					 * If it does not work, then maybe the extension did not suit the content
					 * Therefore checks all extensions's regex to find the good one.
					 *
					if(isset($preg_match)) {
						if(!preg_match_all($preg_match, $str_file, $matches, PREG_SET_ORDER)) {
							foreach($regexArray as $key => $value) {
								if(preg_match_all($value, $str_file, $matches, PREG_SET_ORDER)) {
									if($key != ".MicroDVDsub") {
										$advice = "Your file has the wrong extension. Cues formatting indicates that it actually is a " . getFileOutputExtension($key) . " file. I would strongly recommend converting it to the proper extension. You can go back to the <a href='https://subsyncer.com'>home page</a> and select convert to " . getFileOutputExtension($key) . ".";
									}
									$fileOutputExtension = $key;
									break;
								}
							}
						}
						/* 
						 * If there is a header regex
						 * Separates header from the body
						 * Inserts header in output file
						 * Keeps the body for processing
						 * 
						 * .ssa/.ass/.sub/.vtt
						 *
						if(isset($matches)) {
							if(array_key_exists($fileOutputExtension, $regexArrayHeader)) {
								$separate_scripts_from_dialogue = $regexArrayHeader[$fileOutputExtension];
								if (preg_match_all($separate_scripts_from_dialogue, $str_file, $separated, PREG_SET_ORDER)) { // Separate the $file using the $p pattern as $matches
									foreach($separated as $sep) {
										$fileContent = $sep[1] . "\r\n"; // Places the header in file output
									}
								}
								elseif (in_array($fileOutputExtension, $optionalHeader)) {
									// Optional header only, no need for error message.
								}
								else {
									$error = "Hum.. An error happened. I will investigate as soon as possible.";
								}
							}
						}
						else {
							$error = "Cues formatting does not seem to fit any recognizable format.";
						}
					}
					else {
						$error = "Regex not set";
					}
					*/
				}
				else {
					$error = "Error: " . $_FILES['file']['error']; //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
				}
			}
			else {
				$error = "This file format is currently not supported.";
			}
		}
	}
	else { // $_POST['file'] is NOT set
		$error = "Choose a file first.";
	}
}
else {
	$error ="You must fill in the form. <a href='https://subsyncer.com'>Go to Home Page</a>";
}



/********FPS to FPS SYNC********/
if (isset($_POST['fpstofps']) AND $upload === TRUE) {
	if (isset($_POST['fps_in']) AND !empty($_POST['fps_in'])) { // On a les 2 variables
		if (in_array($_POST['fps_in'], $allowedFps)) {
			$fps_in = $_SESSION['fps_in'] = $_POST['fps_in'];
		}
		else {
			$error = "Selected Input FPS is not allowed";
		}
	}
	else {
		$error = "No Input FPS selected";
	}
	if (isset($_POST['fps_out']) AND !empty($_POST['fps_out'])) { // On a les 2 variables
		if (in_array($_POST['fps_out'], $allowedFps)) {
			$fps_out = $_SESSION['fps_out'] = $_POST['fps_out'];
		}
		else {
			$error = "Selected Output FPS is not allowed";
		}
	}
	else {
		$error = "No Output FPS selected";
	}
	if (isset($_SESSION['fps_in']) AND !empty($_POST['fps_in']) AND isset($_SESSION['fps_out']) AND !empty($_POST['fps_out'])) {
		$fpstofps = $fps_in/$fps_out;
		//$fpstofps = ($fps_in*1.0000546653)/$fps_out;
		//$lol = 1.042709;
		//25->23.976 = 1.042766;
		//23.976->25 = 0.9589875;
		$message = "Re-synchronized from " . $fps_in . "fps to " . $fps_out . "fps!";
		$fileNameSuffix = "_".$fps_out; // Define the output file name using the original input $file
	}
}



/********TIME SHIFT********/
if (isset($_POST['sub_shift']) AND $upload === TRUE) {
	if (isset($_POST["time_shift"]) AND !empty($_POST["time_shift"])) {
		if (preg_match('/([+-])(\d{0,4})[.,](\d{0,3})/', $_POST["time_shift"], $time_shift)) { // In seconds (with , or .)
			$abc = str_pad($time_shift[3], 3, "0", STR_PAD_RIGHT); // add 0 on the right (07 -> 070)			$abc = ltrim($abc, 0); // trim potential leading zeros (070 -> 70)
			$time_shift_time = $time_shift[1].($time_shift[2]*1000 + $abc);
			$message = "Shifted by " . $time_shift_time . "ms!";
			$fileNameSuffix = "_".$time_shift_time; // Define the output file name using the original input $file
		}
		else if (preg_match('/([+-])?(\d{0,9})/', $_POST["time_shift"], $time_shift)) {// Already in ms (without , or .)
			if(empty($time_shift[1])){
				$time_shift_time = "+".$time_shift[2]; //sign+time ms
			} else {
				$time_shift_time = $time_shift[1].$time_shift[2]; //sign+time ms
			}
			$message = "Shifted by " . $time_shift_time . "ms!";
			$fileNameSuffix = "_".$time_shift_time; // Define the output file name using the original input $file
		}
		else {
			$error = $_POST["time_shift"]." is not a valid input.";
		}
	}
	else {
		$error = "Time Shift not set";
	}
}



/********CONVERT EXTENSION********/
if (isset($_POST['ext_change']) AND $upload === TRUE) {
	if (isset($_POST['ext_out']) AND !empty($_POST['ext_out'])) {
		if (in_array($_POST['ext_out'], $allowedExt)) { // Si extension valide
			$convert = $_POST['ext_out'];
			$fileNameSuffix = "_converted"; // Define the output file name using the original input $file
			$message = "Converted to " . $convert . " !";
			$fileContent = ""; // Reset the output file
			$saveExtension = getFileOutputExtension($convert);
			if($convert == $trueExtension) { // If the conversion is from and to the same extension (for some reasons)
				if(isset($sep[1])) {
					$fileContent = trim($sep[1]) . "\r\n";
				}
			} else if($convert == ".ssa" OR $convert == ".ass") {
				$fileContent = $defaultSSA;
			} else if($convert == ".sub") {
				$fileContent = $defaultSUB;
			} else if($convert == ".vtt") {
				$fileContent = $defaultVTT;
			} else if($convert == ".txt") {
				$convert = $trueExtension;
			}
		}
	}
	else {
		$error = "Extension Change not set";
	}
}



/********CLEANING********/
if (isset($_POST['sub_clean']) AND $upload === TRUE) {
	if (isset($_POST['cleanList']) AND !empty($_POST['cleanList'])) {
		$_POST['cleanList'] = array_filter($_POST['cleanList'], "is_numeric");
		if(!empty($_POST['cleanList'])) {
			$fileNameSuffix = "_cleaned"; // Define the output file name using the original input $file
			$message = "Cleaned!";
			$sub_clean = TRUE;
		}
	}
	else {
		$error = "No cleaning set.";
	}
}



/********CONVERT TO UTF-8********/
if (isset($_POST['to_utf8']) AND $upload === TRUE) {
	$message = "Converted to UTF-8";
	$fileNameSuffix = "_utf8"; // Define the output file name using the original input $file
	$toUTF8 = TRUE;
}

/********NBCUNIVERSAL********/
if (isset($_POST['timecodeShift']) AND $upload === TRUE) {
	if (isset($_POST['timecodeStart']) AND !empty($_POST['timecodeStart'])) { // On a les 2 variables
		if(preg_match('/(\d{1,3})(?::(\d{2}))?(?::(\d{2}))?(?:[,.](\d{0,3}))?/', $_POST['timecodeStart'], $m)) {
			$timecodeStart = $m[1] . (isset($m[2]) ? ":" . $m[2] : FALSE) . (isset($m[3]) ? ":" . $m[3] : FALSE) . (isset($m[4]) ? "," . $m[4] : FALSE);
			$timecodeStart = strtoms($timecodeStart);
		}
	}
	if (isset($_POST['timecodeEnd']) AND !empty($_POST['timecodeEnd'])) { // On a les 2 variables
		if(preg_match('/(\d{1,3})(?::(\d{2}))?(?::(\d{2}))?(?:[,.](\d{0,3}))?/', $_POST['timecodeEnd'], $m)) {
			$timecodeEnd = $m[1] . (isset($m[2]) ? ":" . $m[2] : ":00") . (isset($m[3]) ? ":" . $m[3] : ":00") . (isset($m[4]) ? "," . $m[4] : ",000");
			$timecodeEnd = strtoms($timecodeEnd);
		}
	}
	if ((isset($_POST['timecodeStart']) AND !empty($_POST['timecodeStart'])) OR (isset($_POST['timecodeEnd']) AND !empty($_POST['timecodeEnd']))) {
		$timecodeShift = TRUE;
		$message = "Shifted!";
		$fileNameSuffix = "_shifted"; // Define the output file name using the original input $file
	}
	if ( (!isset($_POST['timecodeStart']) OR empty($_POST['timecodeStart'])) AND (!isset($_POST['timecodeEnd']) OR empty($_POST['timecodeEnd'])) ) {
		$error = "You must set at least one timecode.";
	}
}


if(!$error) {
	$x = array_keys($matches); // array_keys(); put as variable to avoid Error (since PHP5.4?)
	/*$first_key = reset($x);
	$last_key = end($x);*/
	// Get $matches keys and retrieve the first and the last keys


	//print_r($matches);
	// DEBUG print_r($x); Print as array, the keys of the subtitles
	$subtitleKey = 1;
	foreach ($matches as $key => $val) {
		if($trueExtension == ".sub (MicroDVD)") {
			$timeStart = fpstoms($val[2], $fps_in); // Get time in ms
			$timeEnd = fpstoms($val[3], $fps_in); // Get time in ms
		} else {
			$timeStart = strtoms($val[2]); // Get time in ms
			$timeEnd = strtoms($val[3]); // Get time in ms
		}
		if($timeStart > $timeEnd) {
			$temp = $timeStart;
			$timeStart = $timeEnd;
			$timeEnd = $temp;
		}
		if($trueExtension == ".vtt") {
			(!empty($val[8]) ? $subtitleKey-- : FALSE);
		}
		if($trueExtension == ".ass" OR $trueExtension == ".ssa") {
			(empty($val[10]) ? $subtitleKey-- : FALSE);
		}
		if($trueExtension == ".sub (MicroDVD)") {
			(empty($val[4]) ? $subtitleKey-- : FALSE);
		}

		//echo "timeStart=$timeStart---timeEnd=$timeEnd<br />";
		/*
		if ($key === $first_key) {
			$first_subtime_start = $timeStart; // Retrieve the first key's timestart value
		}
		if ($key === $last_key) {
			$last_subtime_finish = $timeEnd; // Retrieve the last key's timestart value
		}*/

		///////////////////////////////////
		if ($fpstofps) { // If $fpstofps is set, it means the upload was OK and all fps are set.
			$timeStart = $timeStart*$fpstofps;
			$timeEnd = $timeEnd*$fpstofps;
		}
		if ($time_shift_time) { // If $time_shift_time is set, it means the upload was OK and time was set.
			$timeStart = $timeStart+$time_shift_time;
			$timeEnd = $timeEnd+$time_shift_time;
		}
		if ($convert) { // $convert is set => CONVERSION ALGORITHM
			switch($trueExtension) {
				case ".srt":
					if($convert == ".ass" OR $convert == ".ssa") {
						$val[10] = $val[4] . (!empty($val[5]) ? "\N" . $val[5] : FALSE) . (!empty($val[6]) ? "\N" . $val[6] : FALSE);
						$val[10] = str_replace($tagsSRT, $tagsSSA, $val[10]); // Changes SRT tags to SSA tags
						// Resets variables that will be used in SSA/ASS files
						$val[1] = "0";
						$val[4] = "Default";
						$val[5] = "";
						$val[6] = "0000";
					} else if($convert == ".sub") {
						$val[4] = $val[4] . (!empty($val[5]) ? "[br]" . $val[5] : FALSE) . (!empty($val[6]) ? "[br]" . $val[6] : FALSE);
					} else if($convert == ".vtt") {
						for ($i = 7; $i >= 5; $i--) {
							$val[$i] = $val[$i-1] ?? FALSE; // Assign .srt lines to .vtt cues
						}
						$val[4] = ""; // nullify positioning
					} else if($convert == ".sub (MicroDVD)") { // https://en.wikipedia.org/wiki/MicroDVD#cite_note-2 //{y:i} b u
						$val[4] = $val[4] . (!empty($val[5]) ? "|" . $val[5] : FALSE) . (!empty($val[6]) ? "|" . $val[6] : FALSE);
					}
				break;
				case ".ass":
				case ".ssa":
					if($convert == ".srt") {
						$val[10] = str_replace($tagsSSA, $tagsSRT, $val[10]); // Changes SSA tags to SRT tags
						$val[10] = switchCleaning($val[10], ".ssa"); // Deletes remaining SSA variables that are found between {}
						$lists = preg_split($ssaRegex, $val[10]); // Uses preg_split to match \N or \n as SSA's line break
						for ($i = 4; $i <= 6; $i++) {
							$val[$i] = $lists[$i-4] ?? FALSE; // Assign the exploded line or define the variable as FALSE to avoid offset errors.
						}
					} else if($convert == ".sub") {
						$val[10] = switchCleaning($val[10], ".ssa"); // Deletes remaining SSA variables that are found between {}
						$val[4] = preg_replace($ssaRegex, '[br]', $val[10]); // Uses preg_split to match \N or \n as SSA's line break
					} else if($convert == ".vtt") {
						$val[10] = str_replace($tagsSSA, $tagsVTT, $val[10]); // Changes SSA tags to VTT tags
						$val[10] = switchCleaning($val[10], ".ssa"); // Deletes remaining SSA variables that are found between {}
						$lists = preg_split($ssaRegex, $val[10]); // Uses preg_split to match \N or \n as SSA's line break
						for ($i = 5; $i <= 7; $i++) {
							$val[$i] = $lists[$i-5] ?? FALSE; // Assign the exploded line or define the variable as FALSE to avoid offset errors.
						}
						$val[1] = $subtitleKey;
						$val[8] = ""; // nullify comments
						$val[4] = ""; // nullify positioning
					} else if($convert == ".sub (MicroDVD)") {
						$val[10] = switchCleaning($val[10], ".ssa"); // Deletes remaining SSA variables that are found between {}
						$val[4] = preg_replace($ssaRegex, '|', $val[10]); // Uses preg_split to match \N or \n as SSA's line break
					}
				break;
				case ".sub":
					if($convert == ".ass" OR $convert == ".ssa") {
						$val[10] = str_replace("[br]", "\N", $val[4]);
						// Reset variables that will be used in SSA/ASS files
						$val[1] = "0";
						$val[4] = "Default";
						$val[5] = "";
						$val[6] = "0000";
					} else if($convert == ".srt") {
						$lists = explode("[br]", $val[4]);
						for ($i = 4; $i <= 6; $i++) {
							$val[$i] = $lists[$i-4] ?? FALSE; // Assign the exploded line or define the variable as FALSE to avoid offset errors.
						}
					} else if($convert == ".vtt") {
						$lists = explode("[br]", $val[4]);
						for ($i = 5; $i <= 7; $i++) {
							$val[$i] = $lists[$i-5] ?? FALSE; // Assign the exploded line or define the variable as FALSE to avoid offset errors.
						}
						$val[4] = ""; // nullify positioning
					} else if($convert == ".sub (MicroDVD)") { // https://en.wikipedia.org/wiki/MicroDVD#cite_note-2 //{y:i} b u
						$val[4] = str_replace("[br]", "|", $val[4]);
					}
					// TODO: Clean sub->sub of line breaks
				break;
				case ".sub (MicroDVD)":
					if($convert == ".ass" OR $convert == ".ssa") {
						$val[4] = switchCleaning($val[4], ".sub (MicroDVD)");
						$val[10] = str_replace("|", "\N", $val[4]);
						// Reset variables that will be used in SSA/ASS files
						$val[1] = "0";
						$val[4] = "Default";
						$val[5] = "";
						$val[6] = "0000";
					} else if($convert == ".srt") {
						$val[4] = switchCleaning($val[4], ".sub (MicroDVD)");
						$lists = explode("|", $val[4]);
						for ($i = 4; $i <= 6; $i++) {
							$val[$i] = $lists[$i-4] ?? FALSE; // Assign the exploded line or define the variable as FALSE to avoid offset errors.
						}
					} else if($convert == ".vtt") {
						$val[4] = switchCleaning($val[4], ".sub (MicroDVD)");
						$lists = explode("|", $val[4]);
						for ($i = 5; $i <= 7; $i++) {
							$val[$i] = $lists[$i-5] ?? FALSE; // Assign the exploded line or define the variable as FALSE to avoid offset errors.
						}
						$val[4] = ""; // nullify positioning
					} else if($convert == ".sub") {
						$val[4] = switchCleaning($val[4], ".sub (MicroDVD)");
						$val[4] = str_replace("|", "[br]", $val[4]);
					}
				break;
				case ".vtt":
					if($convert == ".srt") {
						for ($i = 5; $i <= 7; $i++) {
							$val[$i-1] = $val[$i] ?? FALSE;
						}
					} else if($convert == ".ass" OR $convert == ".ssa") {
						$val[10] = $val[5] . (!empty($val[6]) ? "\N" . $val[6] : FALSE) . (!empty($val[7]) ? "\N" . $val[7] : FALSE);
						$val[10] = str_replace($tagsVTT, $tagsSSA, $val[10]); // Changes SRT tags to SSA tags
						// Resets variables that will be used in SSA/ASS files
						$val[1] = "0";
						$val[4] = "Default";
						$val[5] = "";
						$val[6] = "0000";
						$val[7] = "0000";
						$val[8] = "0000";
					} else if($convert == ".sub") {
						//https://en.wikipedia.org/wiki/MicroDVD#cite_note-2
						//{y:i} b u
						$val[4] = $val[5] . (!empty($val[6]) ? "[br]" . $val[6] : FALSE) . (!empty($val[7]) ? "[br]" . $val[7] : FALSE);
					} else if($convert == ".sub (MicroDVD)") { // https://en.wikipedia.org/wiki/MicroDVD#cite_note-2 //{y:i} b u
						$val[4] = $val[5] . (!empty($val[6]) ? "|" . $val[6] : FALSE) . (!empty($val[7]) ? "|" . $val[7] : FALSE);
					}
				break;
				// 1*: Cue identifier; 2: Time Start; 3: Time End; 4*: Cue positioning; 5: Line1; 6*: Line2; 7*: Line3; 8*: Comments
			}
		}
		if ($sub_clean) { // If $sub_clean is set, it means the upload was OK and that the user wants to clean the file.
			//print_r($_POST['cleanList']);
			//echo "extension=" . $trueExtension;
			foreach($_POST['cleanList'] as $a) {
				switch($trueExtension) {
					case ".srt":
						for ($i = 4; $i <= 6; $i++) {
							$val[$i] = (!empty($val[$i]) ? textCleaning($val[$i], $trueExtension, $a) : FALSE);
						}
					break;
					case ".ass":
					case ".ssa":
						$val[10] = textCleaning($val[10], $trueExtension, $a) ?? FALSE;
					break;
					case ".sub (MicroDVD)":
						$val[4] = textCleaning($val[4], $trueExtension, $a) ?? FALSE;
					break;
					case ".vtt":
						for ($i = 5; $i <= 7; $i++) {
							if(!empty($val[$i])) {
								$val[$i] = textCleaning($val[$i], $trueExtension, $a) ?? FALSE;
							} 
						}
					break;
				}
			}
		}
		if($timecodeShift) {
			if(!isset($firstKey) AND !isset($lastKey)) {
				$firstKey = reset($x);
				$lastKey = end($x);
				if($trueExtension == ".sub (MicroDVD)") {
					$diffStart = ($timecodeStart ?? fpstoms($matches[$firstKey][2], $fps_in)) - fpstoms($matches[$firstKey][2], $fps_in);
					$diffEnd = ($timecodeEnd ?? fpstoms($matches[$lastKey][2], $fps_in)) - fpstoms($matches[$lastKey][2], $fps_in);
				} else {
					$diffStart = ($timecodeStart ?? strtoms($matches[$firstKey][2])) - strtoms($matches[$firstKey][2]);
					$diffEnd = ($timecodeEnd ?? strtoms($matches[$lastKey][2])) - strtoms($matches[$lastKey][2]);
				}
				$countd = count($x) - 1;
				
				$coeff = (($diffEnd - $diffStart) / $countd);
			}
			if($key == $firstKey) {
				$diff = $diffStart;
			} else {
				$diff = $diff + $coeff;
			}
			$timeStart = $timeStart + $diff;
			$timeEnd = $timeEnd + $diff;
		}
		//////////////////////////////
		
		/*echo "uploadExtension=$uploadExtension<br />";
		echo "trueExtension=$trueExtension<br />";
		echo "savedUsing=" . ($convert ? $convert : $trueExtension)."<br />";
		echo "saveExtension=$saveExtension<br />";*/
		switch(($convert ? $convert : $trueExtension)) {
			case ".srt":
				for ($i = 4; $i <= 6; $i++) {
					$val[$i] = $val[$i] ?? FALSE;
				}
				$fileContent .= insertIntoSRT($subtitleKey, $timeStart, $timeEnd, $val[4], $val[5], $val[6]);
			break;
			case ".ass":
			case ".ssa":
				$fileContent .= insertIntoSSA($timeStart, $timeEnd, $val[10], $val[1], $val[4], (!empty($val[5]) ? $val[5] : FALSE), (!empty($val[6]) ? $val[6] : "0000"), (!empty($val[7]) ? $val[7] : "0000"), (!empty($val[8]) ? $val[8] : "0000"), (!empty($val[9]) ? $val[9] : FALSE));
			break;
			case ".sub":
				$fileContent .= insertIntoSUB($timeStart, $timeEnd, $val[4]);
			break;
			case ".sub (MicroDVD)":
				$fileContent .= insertIntoMicroDVDsub($timeStart, $timeEnd, $val[4], $fps_in);
			break;
			case ".vtt":
				$fileContent .= insertIntoVTT((!empty($val[1]) ? $val[1] : $subtitleKey), $timeStart, $timeEnd, (!empty($val[4]) ? $val[4] : FALSE), $val[5], (!empty($val[6]) ? $val[6] : FALSE), (!empty($val[7]) ? $val[7] : FALSE), (!empty($val[8]) ? $val[8] : FALSE));
			break;
		}
		++$subtitleKey;
	}

	$fileOutputName = filenameSanitizer($fileInputName) . $fileNameSuffix . $saveExtension;

	if (file_put_contents($dir_out.$fileOutputName, rtrim($fileContent))) {
	// Put the processed content in the new file created
		$downloadable = TRUE;
	} else {
		$error = "There was an error. Please try again with another file while I investigate. E_F";
	}
}
?>

		<main role="main">
			<section id="main">
				<div class="container">
					<div class="row">
						<div class="col-9 mx-auto">
							<div class="intro-message mb-2">
								<h1><?php echo (empty($error) ? htmlspecialchars($message) : '<span id="error">'.htmlspecialchars($error).'</span>'); ?></h1>
								<p class="mb-0 d-flex align-items-center">
								<?php if(empty($error)) { ?>
									<svg focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M352 320c-22.608 0-43.387 7.819-59.79 20.895l-102.486-64.054a96.551 96.551 0 0 0 0-41.683l102.486-64.054C308.613 184.181 329.392 192 352 192c53.019 0 96-42.981 96-96S405.019 0 352 0s-96 42.981-96 96c0 7.158.79 14.13 2.276 20.841L155.79 180.895C139.387 167.819 118.608 160 96 160c-53.019 0-96 42.981-96 96s42.981 96 96 96c22.608 0 43.387-7.819 59.79-20.895l102.486 64.054A96.301 96.301 0 0 0 256 416c0 53.019 42.981 96 96 96s96-42.981 96-96-42.981-96-96-96z" class=""></path></svg>
									Easy to share! All links are valid for 60 days.<!-- <a href="#explanation">Explain me how it works.</a>-->
								<?php } ?>
								</p>
							</div>
							<?php if(empty($error)) { ?>
							<!--<div class="d-flex align-items-center mb-2">
								<div class="mr-auto"><?php echo (empty($fileInputName) ? "No file selected" : htmlspecialchars($fileInputName)); ?></div>
								<div class="ml-2"><a class="copy" data-clipboard-target=".link" onclick="gtag('event', 'Click', {'event_category' : 'Download','event_label' : 'Copy Link'});" style="display: inline-block;">Copy the link</a></div>
								<div class="ml-2"><a href="<?php echo htmlspecialchars($dir_out.$fileOutputName); ?>" class="btn btn-primary link" onclick="gtag('event', 'Click', {'event_category' : 'Download','event_label' : 'Download Action'});" style="display: inline-block;" download>Download now!</a></div>
							</div>-->
							<div class="d-flex align-items-center mb-2" style="height: 48px;line-break:anywhere;">
								<div class="file-name"><?php echo (empty($fileInputName) ? "No file selected" : htmlspecialchars($fileInputName)); ?></div>
								<div class="file-utilities">
									<a class="copy" data-clipboard-target=".link" onclick="gtag('event', 'Click', {'event_category' : 'Download','event_label' : 'Copy Link'});">Copy the link</a>
									<a href="<?php echo ($dir_out.$fileOutputName); ?>" class="btn btn-primary link" onclick="gtag('event', 'Click', {'event_category' : 'Download','event_label' : 'Download Action'});" download>Download now!</a>
								</div>
							</div>
							<?php } ?>
							<p>Try again? <a href="https://subsyncer.com">Go back</a></p>
							<?php if(!empty($advice) AND ($convert != $trueExtension)) { ?>
								<p class="alert alert-warning"><?php echo $advice; ?></p>
							<?php } ?>
							<div style="height: 150px;background:transparent;" class="box"></div>
						</div>
					</div>
				</div>
			</section>
			<script>gtag('event', 'error_dimension', {'error': '<?php echo $error; ?>' });</script>

			<?php include_once("parts-update.php"); ?>
		
			<?php include_once("parts-body1.php"); ?>

			<?php include_once("parts-body2.php"); ?>

			<?php include_once("parts-footer.php"); ?>
	
			<?php
			if($upload === TRUE) {
			// LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG
			// LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG
			// LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG LOG
				$fp = fopen($logFileName, 'a');

				if (flock($fp, LOCK_EX)) {
					$delimiter = ";";
					if(filesize($logFileName) == 0) {
						$array = array('Date', 'Time', 'Uploaded', 'FileName', 'uploadExtension', 'trueExtension', 'saveExtension', 'Encoding', 'FPS IN', 'FPStoFPS', 'TimeShift', 'Convert', 'Clean', 'UTF8', 'Timecode', 'Downloadable', 'Error', 'Advice');
						fputcsv($fp, $array, $delimiter);
					}
					$array = array(date("F j Y"), date("H:i:s"), $log_uploaded_file, filenameSanitizer($fileInputName), $uploadExtension, $trueExtension, $saveExtension, $encoding, $fps_in, ($fpstofps ? $fps_out : ""), $time_shift_time, $convert, ($sub_clean ? implode("", $_POST['cleanList']) : ""), ($toUTF8 ?? ""),  ($timecodeShift ? ($timecodeStart ?? "unset") . "-->" . ($timecodeEnd ?? "unset") : ""), $downloadable, $error, $advice);
					fputcsv($fp, $array, $delimiter);
					// 23/05/2020 Fixed: Output extension being inserted instead of input extension (as used in cleaning with $convertFromExtension).
					// 23/11/2002 Changed: Flock in order to prevent simultaneous writing in the log file creating logs issues. TO check if it actually works.
				
					flock($fp, LOCK_UN);
				}
/*
				if($fp) {
					if(filesize($logFileName) == 0) {
						$array = array('Date', 'Time', 'Uploaded', 'FileName', 'uploadExtension', 'trueExtension', 'saveExtension', 'Encoding', 'FPS IN', 'FPStoFPS', 'TimeShift', 'Convert', 'Clean', 'UTF8', 'Timecode', 'Downloadable', 'Error', 'Advice');
						fputcsv($fp, $array);
					}
					$array = array(date("F j Y"), date("H:i:s"), $log_uploaded_file, $fileInputName, $uploadExtension, $trueExtension, $saveExtension, $encoding, $fps_in, ($fpstofps ? $fps_out : ""), $time_shift_time, $convert, ($sub_clean ? implode("", $_POST['cleanList']) : ""), ($toUTF8 ?? ""), ($timecodeShift ?? ""), $downloadable, $error, $advice);
					fputcsv($fp, $array);
					// 23/05/2020 Fixed: Output extension being inserted instead of input extension (as used in cleaning with $convertFromExtension).
				}
				fclose($fp);*/
				clearstatcache();
			}
			?>