<?php

date_default_timezone_set('Asia/Tokyo');

$maxsize = 300000;
$debug = FALSE;

$fpstofps = FALSE;
$time_shift_time = FALSE;
$convert = FALSE;
$sub_clean = FALSE;
$toUTF8 = FALSE;
$timecodeShift = FALSE;

$upload = FALSE;
$downloadable = FALSE;
$bmc = FALSE;
$exist = FALSE; // Exclusively used in get
$fps_in = "23.976";
$fps_out = "23.976";
$fileContent = ""; // Define the file content output variable
$advice = "";

$dir_in = "u".DIRECTORY_SEPARATOR."u".date("Ymd").DIRECTORY_SEPARATOR; // "uploads".DIRECTORY_SEPARATOR;
if (!is_dir($dir_in)) {
	mkdir($dir_in);
}
$dir_out = "d".DIRECTORY_SEPARATOR."d".date("Ymd").DIRECTORY_SEPARATOR;
if (!is_dir($dir_out)) {
	mkdir($dir_out);
}
$delimiter = ",";

$allowedExt =  array('.srt', '.vtt', '.txt', '.ass', '.ssa', '.sub', '.sub (MicroDVD)'); // Allowed File Extensions
$allowedFps =  array('23.976', '23.98', '24', '25' ,'29.970', '30'); // Allowed FPS Choices
	// 30		Real 30
	// 29.97	NTSC (30)
	// 25		Real 25
	// 24		Real 24
	// 23.98	On request
	// 23.976	PAL (24)

$tagsSRT = array('<i>', '</i>', '<b>', '</b>', '<u>', '</u>');
$tagsSSA = array('{\i1}', '{\i0}', '{\b1}', '{\b0}', '{\u1}', '{\u0}');
$tagsVTT = array('<i>', '</i>', '<b>', '</b>', '<u>', '</u>');
$ssaRegex = '/\\\N|\\\n/';

$error = "";
$logFileName = './logs/log_'.date("Ymd").'.csv';

$regexArray = array(
	".ass" => "/Dialogue:\s([^,]*),(\d:\d{2}:\d{2}.\d{2,3}),(\d:\d{2}:\d{2}.\d{2,3}),([^,]*),([^,]*),(\d{1,4}),(\d{1,4}),(\d{1,4}),([^,]*),([^\r\n]*)/",
	".ssa" => "/Dialogue:\s([^,]*),(\d:\d{2}:\d{2}.\d{2,3}),(\d:\d{2}:\d{2}.\d{2,3}),([^,]*),([^,]*),(\d{1,4}),(\d{1,4}),(\d{1,4}),([^,]*),([^\r\n]*)/",
	".sub" => "/()(\d{2}:\d{2}:\d{2}.\d{2}),(\d{2}:\d{2}:\d{2}.\d{2})(?:\r\n|\r|\n)(?:([^\r\n]+))/", //Does NOT get empty cues
	".vtt" => "/(?:(?:([^\r\n]+)(?:\r\n|\r|\n))?((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3}) +--> +((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3})(?: +([^\r\n]+))?(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?|(?:(NOTE[\s\S]*?)(?:(?:(?:\r\n){2}|\r{2}|\n{2}))))/",
	".srt" => "/(\d*)(?:\r\n|\r|\n)(\d{1,3}: ?\d{2}: ?\d{2}[:,.]?\d{0,3}) +--> +(\d{1,3}: ?\d{2}: ?\d{2}[:,.]?\d{0,3})[\t\f\v ]*?(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?/",
  //".srt" => "/(\d*)(?:\r\n|\r|\n)(\d{1,3}:\d{2}:\d{2}[,.]?\d{0,3}) +--> +(\d{1,3}:\d{2}:\d{2}[,.]?\d{0,3})[\t\f\v ]*?(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?/",
	".sub (MicroDVD)" => "/(){(\d{1,7})}{(\d{1,7})}(?:([^\r\n]*))/",
	".txt" => "/()(\d{2}:\d{2}:\d{2}:\d{2})\s(\g<2>)\s([^\r\n]*)/"
);
$regexArrayHeader = array(
	".ass" => "/(?:(\[Script Info\].*?)(?=(?:\r\n|\r|\n)Dialogue:))/s",
	".ssa" => "/(?:(\[Script Info\].*?)(?=(?:\r\n|\r|\n)Dialogue:))/s",
	".sub" => "/(\[INFORMATION\](?:.*?)(?=(?:\r\n|\r|\n)\d\d:\d\d:\d\d))/s",
	".vtt" => "/(?:(WEBVTT[\s\S]*?)[\r\n]{2}(?=(?:[^\r\n]+(?:\r\n|\r|\n))?(?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3} +-->))/"
);
$optionalHeader = array(".ass", ".ssa");
//error_reporting(0);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

				/*
				switch($fileOutputExtension) { // Each extension gets its own regular expression
					case ".srt":
					// GOOD $preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})\s?(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?/'; // Added \s? after cue timings as sometimes there is a space..
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?/'; // Added (?:()) to avoid CR and LF to be included after each line.
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})(?:\r\n|\r|\n)([^\r\n]+(?:\r\n|\r|\n)?)([^\r\n]+(?:\r\n|\r|\n)?(?!\g<2>))?([^\r\n]+(?:\r\n|\r|\n)?(?!\g<2>))?/';
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})(?:\r\n|\r|\n)([^\r\n]+(?:\r\n|\r|\n))([^\r\n]+(?:\r\n|\r|\n)(?!\g<2>))?([^\r\n]+(?:\r\n|\r|\n)(?!\g<2>))?/'; // Working except for last line in the file if there is no CR or LF at the end.
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})(?:\r\n|\r|\n)?([^\r\n]+)(?:\r\n|\r|\n)?([^\r\n]+(?!.*\n\g<2>))?(?:\r\n|\r|\n)?([^\r\n]+(?!.*\n\g<2>))?/'; Deleted some parentheses
//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})(?:\r\n|\r|\n)?([^\r\n]+(?!(?:\r\n|\r|\n)\g<2>))?(?:\r\n|\r|\n)?([^\r\n]+(?!(?:\r\n|\r|\n)\g<2>))?(?:\r\n|\r|\n)?([^\r\n]+(?!(?:\r\n|\r|\n)\g<2>))?/'; Test only
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})(?:\r\n|\r|\n)?([^\r\n]+)(?:\r\n|\r|\n)?([^\r\n]+(?!.*\n\g<2>))?(?:\r\n|\r|\n)?([^\r\n]+(?!(.*\n\g<2>)))?/'; Used until 11/05/2020
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3}) --> (\d{1,2}:\d{2}:\d{2}[,.]?\d{0,3})((?:\r\n|\r|\n).*)(?:\r\n|\r|\n)?([^\r\n]+(?!.*\n\g<2>))?(?:\r\n|\r|\n)?([^\r\n]+(?!(.*\n\g<2>)))?/';
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})((?:\r\n|\r|\n).*)(?:\r\n|\r|\n)?([^\r\n]+(?!.*\n\g<2>))?(?:\r\n|\r|\n)?([^\r\n]+(?!(.*\n\g<2>)))?/';
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})((?:\r\n|\r|\n).*)(?:\r\n|\r|\n)?(.+(?!.*\n\g<2>))?(?:\r\n|\r|\n)?(.+(?!(.*\n\g<2>)))?/';
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})(?:\r\n|\r|\n)(.*)((?:\r\n|\r|\n)?.*(?!(.*\n\g<2>)))?((?:\r\n|\r|\n)?.*(?!(.*\n\g<2>)))?/';
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})(?:\r\n|\r|\n)(.*)(?:\r\n|\r|\n)?(.*(?!(.*\n\g<2>)))?(?:\r\n|\r|\n)?(.*(?!(.*\n\g<2>)))?/';
						//$preg_match = '/(\d*)(?:\r\n|\r|\n)(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})((?:\r\n|\r|\n).*)((?:\r\n|\r|\n).*(?!(.*\n\g<2>)))?((?:\r\n|\r|\n).*(?!(.*\n\g<2>)))?/';
						//$preg_match = '/(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})((?:\r\n|\r|\n).*)(?:\r\n|\r|\n)([^\r\n]*)?(?:\r\n|\r|\n)([^\r\n]*)?/';
						// (Tstart) --> (Tfinish)(1st line)(2nd line)?(3rd line)?
						//$preg_match = '/(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})((?:\r\n|\r|\n).*)(?:\r\n|\r|\n)([^\r\n]*)?(?:\r\n|\r|\n)([^\r\n]*)?(?=(?:\r\n|\r|\n){2})/';
						//$preg_match = '/(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})((?:\r\n|\r|\n).*)((?:\r\n|\r|\n).*)((?:\r\n|\r|\n).*)(?=(?:\r\n|\r|\n){2})/';
						//$preg_match = '/(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})(\D{0,}\d*?\D{1,}){0,6}(?=\D{1,}(\r\n|\r|\n))/'; // Pattern to separate subtiles (TimeSTART) --> (TimeSTOP) (LINES)
						//$p = '/(\d{0,4})\r\n(\d{2}:\d{2}:\d{2}[,.]\d{3}) --> (\d{2}:\d{2}:\d{2}[,.]\d{3})(\D{0,}\d*?\D{1,}){0,6}(?=\D{1,}(\r\n|\r|\n))/';	
						// 1: Key; 2: Time Start; 3: Time End; 4: Line1; 5*: Line2; 6*: Line7
					break;

					case ".ass":
					case ".ssa":
						$separate_scripts_from_dialogue = '/(?:(\[Script Info\].*?)(?=(?:\r\n|\r|\n)Dialogue:))/s';
						//$separate_scripts_from_dialogue = '/(\[Script Info\](?:.*?)(?=Dialogue:))/s'; // Good but also gets the line break..
						// Useless to match with Dialogue format?
						//$separate_scripts_from_dialogue ='/\[Script Info\](?:.*?)(?=Dialogue:\s\d,)/s';
					// GOOD $preg_match = '/Dialogue:\s([^,]*),(\d:\d{2}:\d{2}.\d{2,3}),(\d:\d{2}:\d{2}.\d{2,3}),([^,]*),([^,]*),(\d{1,4}),(\d{1,4}),(\d{1,4}),([^,]*),([^\r\n]*)/';
						//$preg_match = '/Dialogue:\s([0|1]),(\d:\d{2}:\d{2}.\d{2,3}),(\d:\d{2}:\d{2}.\d{2,3}),([^,]*),([^,]*),(\d{1,4}),(\d{1,4}),(\d{1,4}),([^,]*),(.*)/';
						// Dialogue: 0/1, time, time, 
						// (),(Tstart),(Tfinish),(),(),(),(),(),(),(lines)
						//$p2 = "/(\d):(\d{2}):(\d{2}).(\d{2,3})/";
						/* It seems that .ass subtitles may used a "%" modifier to skip fields.
						 * time,%%%%%,text would be skipping all the fiels between time and text.
						 * This results in shorter Dialogue lines but I saw it only once and is difficult to implement..
						*
					break;
				
					case ".sub":
						$separate_scripts_from_dialogue = '/(\[INFORMATION\](?:.*?)(?=\d\d:\d\d:\d\d))/s';
					// GOOD $preg_match = '/()(\d{2}:\d{2}:\d{2}.\d{2}),(\d{2}:\d{2}:\d{2}.\d{2})(?:\r\n|\r|\n)(.*)/';
						// (Tstart),(Tfinish)(lines)
						//$p2 = "/(\d):(\d{2}):(\d{2}).(\d{2})/";
					break;

					case ".vtt":
						$str_file = $str_file . "\r\n\r\n"; //Adds 2 lines breaks to help with the $preg_match regex
						$separate_scripts_from_dialogue = "/(?:(WEBVTT[\s\S]*?)[\r\n]{2}(?=(?:[^\r\n]+(?:\r\n|\r|\n))?(?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3} +-->))/";
						//$separate_scripts_from_dialogue = '/(WEBVTT[\s\S]*?(?=[\n\r]+(?:[^\r\n]+(?:\r\n|\r|\n))?(?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3} +-->))/';
					// GOOD $preg_match = '/(?:(?:([^\r\n]+)(?:\r\n|\r|\n))?((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3}) +--> +((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3})(?: +([^\r\n]+))?(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?|(?:(NOTE[\s\S]*?)(?:(?:(?:\r\n){2}|\r{2}|\n{2}))))/'; // Matches all Notes even on 2 lines. For Notes at the bottom, helped by the 2 line breaks added earlier.
						//$preg_match = '/(?:(?:([^\r\n]+)(?:\r\n|\r|\n))?((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3}) +--> +((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3})(?: +([^\r\n]+))?(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?|(NOTE[\s\S]*?(?=(?:\r\n|\r{1}|\n{1})$)))/m';
						//$preg_match = '/(?:(?:([^\r\n]+)(?:\r\n|\r|\n))?((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3}) +--> +((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3})(?: +([^\r\n]+))?(?:\r\n|\r|\n)(?:([^\r\n]+)(?:\r\n|\r|\n)?)(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?(?:([^\r\n]+)(?:\r\n|\r|\n)?(?!\g<2>))?|(NOTE[\s\S]*?(?=(?:(?:\r\n){2}|\r{2}|\n{2}))))/'; // Works well. But doesnt take a comment at the bottom of the file if no 2 empty lines after...
						//$preg_match = '/(?:([^\r\n]+(?:\r\n|\r|\n))?((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3}) +--> +((?:\d{2,}:)?\d{2}:\d{2}\.\d{0,3})(?: +(.*))?(?:\r\n|\r|\n)([^\r\n]+(?:\r\n|\r|\n)?)([^\r\n]+(?:\r\n|\r|\n)?(?!\g<2>))?([^\r\n]+(?:\r\n|\r|\n)?(?!\g<2>))?|(NOTE[\s\S]*?(?=\n\n)))/';
						//$preg_match = '/([^\r\n]+(?:\r\n|\r|\n))?((?:\d{2,}:)?\d{2}:\d{2}[,.]?\d{0,3}) +--> +((?:\d{2,}:)?\d{2}:\d{2}[,.]?\d{0,3})(?: +(.*))?(?:\r\n|\r|\n)([^\r\n]+(?:\r\n|\r|\n)?)([^\r\n]+(?:\r\n|\r|\n)?(?!\g<2>))?([^\r\n]+(?:\r\n|\r|\n)?(?!\g<2>))?/'; // 1: Cue identifier; 2*: Time Start; 3*: Time End; 4: Cue positioning; 5: Line1; 6*: Line2; 7*: Line3
						// 1*: Cue identifier; 2: Time Start; 3: Time End; 4*: Cue positioning; 5: Line1; 6*: Line2; 7*: Line3; 8*: Comments
					break;
				}*/
?>