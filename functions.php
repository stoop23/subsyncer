<?php

// Unicode BOM is U+FEFF, but after encoded, it will look like this.
define ('UTF32_BIG_ENDIAN_BOM'   , chr(0x00) . chr(0x00) . chr(0xFE) . chr(0xFF));
define ('UTF32_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE) . chr(0x00) . chr(0x00));
define ('UTF16_BIG_ENDIAN_BOM'   , chr(0xFE) . chr(0xFF));
define ('UTF16_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE));
define ('UTF8_BOM'               , chr(0xEF) . chr(0xBB) . chr(0xBF));

function detect_utf_encoding($str_file) {
    $first2 = substr($str_file, 0, 2);
    $first3 = substr($str_file, 0, 3);
    $first4 = substr($str_file, 0, 3);

    if ($first3 == UTF8_BOM) return 'UTF-8';
    elseif ($first4 == UTF32_BIG_ENDIAN_BOM) return 'UTF-32BE';
    elseif ($first4 == UTF32_LITTLE_ENDIAN_BOM) return 'UTF-32LE';
    elseif ($first2 == UTF16_BIG_ENDIAN_BOM) return 'UTF-16BE';
	elseif ($first2 == UTF16_LITTLE_ENDIAN_BOM) return 'UTF-16LE';
	elseif (mb_check_encoding($str_file, "UTF-8")) return 'UTF-8';
	else return false;
}

function mstostr($ms, $hdigit, $mdigit, $separator) {
	if($ms < 0) { // Nullify negative time
		$ms = 0;
	}
	$s = $ms/1000;
	$hours = 0;
	
	$ms = round($ms, 0, PHP_ROUND_HALF_UP); // if decimals after maths
	$ms = str_pad($ms, 3, "0", STR_PAD_LEFT);
	$ms = substr($ms, -3, $mdigit);
	
	/*if ($ms>100){ // To avoid infinite numbers (ofc > 100), can be done by length..
		$ms = substr($ms, 0, 4); // If milliseconds length > 3, cut at 4 numbers (to get a good round)
		$ms = round($ms/10, 0); // And round it to the closest value (3 numbers)
	}*/

	if ($s>3600) {
		$hours = floor($s/3600);
	}
	$s = $s%3600;
	
	$m_output = $separator . $ms;
	/*if ($mdigit === -2) {   //Until 2020.05.13
		$m_output = ($ms ? ".$ms" : '');
	}
	else {
		$m_output = ($ms ? ",$ms" : '');
	}*/
	$time = str_pad($hours, $hdigit, '0', STR_PAD_LEFT) . gmdate(':i:s', $s) . $m_output;
	return $time;
}

function strtoms($time) {
	if(!empty($time)) {
		$p2 = "/(?:(\d{1,}): ?)?(\d{2}): ?(\d{2})[:,.]?(\d{0,3})/"; // Separate times values (hours):(minutes):(seconds),(milliseconds)
		/* Supports missing hour
		 * Supports spacing
		 */
		//$p2 = "/(?:(\d{1,}):)?(\d{2}):(\d{2})[,.]?(\d{0,3})/"; // Separate times values (hours):(minutes):(seconds),(milliseconds)
		// $p2 = "/(\d{1,2}):(\d{2}):(\d{2})[,.](\d{2,3})/"; // Separate times values (hours):(minutes):(seconds),(milliseconds)
		if (preg_match_all($p2, $time, $m2, PREG_SET_ORDER)) {
			// Separate the $time using the $p2 pattern, get result as $m2
			foreach ($m2 as $m2) {
				$h = $m2[1]*60*60*1000; // 1hour = 60min = 60 sec = 1000 ms
				$m = $m2[2]*60*1000;
				$s = $m2[3]*1000;
				$ms = $m2[4];
				$ms = str_pad($ms, 3, "0", STR_PAD_RIGHT);
			}
			$ms = $h+$m+$s+$ms;
			return $ms;
		}
		else {
			global $error;
			$error = "There was an error with the timecode. Try again with another file.";
		}
	}
}

function fpstoms($time, $fps) {
	$ms = ($time/$fps)*1000;
	return $ms;
}

function mstofps($time, $fps) {
	$frames = round(($time/1000)*$fps);
	if($frames < 0) {
		return "0";
	} else {
		return $frames;
	}
}

function switchCleaning($text, $format) {
	global $tagsSRT;
	//echo "switchCleaningformat=".$format;
	switch($format) {
		case ".ass":
		case ".ssa": // Same format for .ass
			$regex = "/{\\\.*?}/"; // All override codes are within {} preceded by a \
		break;
		case ".srt":
			$regex = "/<font.*?>/"; // To avoid deleting non-html tags, we delete only the HTML tags that can be found in a .srt
			$text = str_replace($tagsSRT, '', $text);
		break;
		case ".vtt":
			$regex = "/<.*?>/"; // Deletes all HTML tags are non-HTML tags should be escaped
		break;
		case ".sub (MicroDVD)":
			$regex = "/{[a-zA-Z]:.*?}/"; // Deletes all syntax as they follow the format {x:y}
		break;
	}
	if(isset($regex)) {
		$text = preg_replace($regex, '', $text);
	}
	return $text;
}

function textCleaning($text, $format = FALSE, $a = "0") {
	//echo "a=".$a.";format=".$format;
	//echo "<xmp>" . $text . " => ";
	if($format) {
		if($a === "0") {
			global $allowedExt;
			foreach($allowedExt as $e) {
				if($e != $format) {
					if(($e == ".vtt" AND $format == ".srt") OR ($e == ".srt" AND $format == ".vtt")) {
						//
					} else {
						//echo $e . " != " . $format;
						$text = switchCleaning($text, $e);
					}
				}
			}
		} elseif($a === "1") {
			$text = switchCleaning($text, $format);
		} else {
			$cleanRegex = [2 => "/\(.*?\)/", "/{.*?}/", "/\[.*?\]/", "/\<.*?\>/", "/\*.*?\*/"];
			$text = preg_replace($cleanRegex[$a], '', $text);
		}
	}
	$text = str_replace("  ", " ", $text);
	//echo $text . "</xmp>";
	return $text;
}

function insertIntoSRT($subtitleKey, $timeStart, $timeEnd, $line1, $line2, $line3) {
	if(!empty($line1)) { // Makes sure there is at least 1 line
		$output = $subtitleKey . "\r\n" . mstostr($timeStart, 2, 3, ",") . " --> " . mstostr($timeEnd, 2, 3, ",");
		$output .= "\r\n" . trim($line1) . "\r\n";
		if(!empty($line2)) { $output .= "" . trim($line2) . "\r\n"; }
		if(!empty($line3)) { $output .= "" . trim($line3) . "\r\n"; }
		$output .= "\r\n";
		return $output;
	}
}

function insertIntoSSA($timeStart, $timeEnd, $text, $layer = "0", $style = "Default", $name = FALSE, $marginL = "0000", $marginR = "0000", $marginV = "0000", $effect = FALSE) {
	if(!empty($text)) { // Makes sure there is at least 1 line
		$output = "Dialogue: " . $layer . "," . mstostr($timeStart, 1, 2, ".") . "," . mstostr($timeEnd, 1, 2, ".") . "," . $style . "," . $name . "," . $marginL . "," . $marginR . "," . $marginV . "," . $effect . "," . trim($text) . "\r\n";
		return $output;
	}
}

function insertIntoSUB($timeStart, $timeEnd, $text) {
	if(!empty($text)) { // Makes sure there is at least 1 line
		$output = mstostr($timeStart, 2, 2, ".") . "," . mstostr($timeEnd, 2, 2, ".") . "\r\n" . trim($text) . "\r\n";
		$output .= "\r\n";
		return $output;
	}
}

function insertIntoMicroDVDsub($timeStart, $timeEnd, $text, $fps_out) {
	if(!empty($text)) { // Makes sure there is at least 1 line
		$output = "{" . mstofps($timeStart, $fps_out) . "}{" . mstofps($timeEnd, $fps_out) . "}" . trim($text) . "\r\n";
		return $output;
	}
}

function insertIntoVTT($subtitleKey, $timeStart, $timeEnd, $positioning = "", $line1, $line2, $line3, $comment = "") {
	if(!empty($comment)) {
		$output = "\r\n";
		$output .= $comment . "\r\n";
		return $output;
	} else if(!empty($line1)) { // Makes sure there is at least 1 line
		$output = "\r\n";
		$output .= $subtitleKey . "\r\n" . mstostr($timeStart, 2, 3, ".") . " --> " . mstostr($timeEnd, 2, 3, ".") . (!empty($positioning) ? ' '.$positioning : FALSE);
		if(!empty($line1)) { $output .= "\r\n" . trim($line1) . "\r\n"; }
		if(!empty($line2)) { $output .= "" . trim($line2) . "\r\n"; }
		if(!empty($line3)) { $output .= "" . trim($line3) . "\r\n"; }
		return $output;
	}
}

function getFileOutputExtension($fileOutputExtension) {
	if($fileOutputExtension == ".sub (MicroDVD)") {
		$fileOutputExtension = ".sub";
	}
	return $fileOutputExtension;
}

function filenameSanitizer($unsafeFilename) {
  // our list of "unsafe characters", add/remove characters if necessary
  $dangerousCharacters = array(";", '"', "'", "&", "/", "\\", "?", "#");
  $safe_filename = str_replace($dangerousCharacters, '_', $unsafeFilename);
  return $safe_filename;
}

$defaultSSA = "[Script Info]
Title: Created by https://subsyncer.com
Original Script: https://subsyncer.com
ScriptType: v4.00

; Thank you for using https://subsyncer.com
; Following SubStation Alpha v4 specifications.

[V4 Styles]
Format: Name, Fontname, Fontsize, PrimaryColour, SecondaryColour, OutlineColour, BackColour, Bold, Italic, Underline, StrikeOut, ScaleX, ScaleY, Spacing, Angle, BorderStyle, Outline, Shadow, Alignment, MarginL, MarginR, MarginV, Encoding
Style: Default,Arial,19,&H00FFFFFF,&H0300FFFF,&H901A1A1A,&H801A0000,0,0,0,0,100,100,0,0,1,1,1,2,10,10,10,0

[Events]
Format: Marked, Start, End, Style, Name, MarginL, MarginR, MarginV, Effect, Text\r\n";

$defaultSUB = "[INFORMATION]
[AUTHOR]https://subsyncer.com
[SOURCE]
[PRG]
[FILEPATH]
[DELAY]
[CD TRACK]
[COMMENT]
[END INFORMATION]

[SUBTITLE]
[COLF]&HFFFFFF,[STYLE]no,[SIZE]18,[FONT]Arial\r\n";

$defaultVTT = "WEBVTT - Created by https://subsyncer.com\r\n";

?>