<?php
    /* Using an external library
     * https://github.com/voku/portable-utf8
     */
	require_once('vendor/autoload.php');
    $UTF8 = new voku\helper\UTF8();
    if($encoding = detect_utf_encoding($str_file)) {
        if($encoding != "UTF-8") {
            $str_file = iconv($encoding, "UTF-8", $str_file);
        }
    }
    else {
        $str_file = $UTF8->to_utf8_string($str_file);
        $encoding = "Auto";
        //$str_file = $UTF8->clean($str_file);
    }
    
    /* 13/06/2020
     * Clean file from NUL (Binary: 00000000, Hex: 00, Escaped: \0)
     * http://www.javascriptkit.com/javatutors/redev2.shtml)
     * https://www.eso.org/~ndelmott/ascii.html
     */
    $str_file = str_replace("\0", "", $str_file);
    
/* ENCODING
 * https://stackoverflow.com/questions/46842606/how-to-convert-a-file-to-utf-8-in-php
 * https://stackoverflow.com/questions/49546403/php-checking-if-string-is-utf-8-or-utf-16le
 * https://stackoverflow.com/questions/39924289/how-to-detect-the-proper-encoding-in-php-mb-detect-encoding-isnt-working
 * https://stackoverflow.com/questions/910793/detect-encoding-and-make-everything-utf-8
*/

/*
 * $encoding = mb_detect_encoding($d, "UTF-8", true); Originally this one (stackoverflow) but setting UTF-8 may take off the purpose of the detect_encoding function?
 * $encoding = mb_detect_encoding($d); <-- Used instead.
 * BUT while I believed that mb_detect_encoding would fill the encoding_list following https://www.php.net/manual/en/function.mb-detect-encoding automatically following detect_order,
 * it was not. As such, files encoded in ISO-8859-1 (seen as ANSI in Notepad++) were not being recognized as ISO-8859-1 and $encoding returned empty.
 * $encoding being empty iconv() silently returned an empty string ("iconv() detected an illegal character"), resulting in the algorithm's failure.
 * The.Morning.Show.2019.S01E04.720p.ATVP.WEBRip.x264-GalaxyTV.hu.srt
 * scrubs.5x22.my_deja_vu_my_deja_vu.dvdrip_xvid-fov.srt
 * The.Phantom.Of.The.Opera.At.The.Royal.Albert.Hall.2011.720p.BluRay.x264.spa.srt
 * 
 * Solution 1 (adopted) : Put a list of encodings in mb_detect_encoding(): May need to add more depending on what PHP7+ supports
 * Solution 2 : We add an //IGNORE flag to iconv() to remove unrecognized characters.
 * Solution 3 : We skip conversion if $encoding is empty
 */


 /*
  * This function below works great to convert all files (going through character (single-byte only) by character). However fails for multi-bytes.
    $a = $str_file;
    $b = strlen($a);
    $str_file = "";
    for($i = 0; $i < $b; $i++) {
        if(preg_match('#[\x7F-\x9F\xBC]#', $a[$i])) {
            $encoding = 'WINDOWS-1250';
        } else {
            $encoding = mb_detect_encoding($a[$i], array("UTF-8", "ISO-8859-1", "UTF-7", "ASCII", "EUC-JP", "SJIS", "eucJP-win", "SJIS-win", "JIS", "ISO-2022-JP"), true);
        }
        $str_file .= iconv($encoding, "UTF-8", $a[$i]);
    }
 */

// Tries first to detect the encoding of the file if possible (UTF16/UTF8)
/*if($encoding = detect_utf_encoding($str_file)) {
    if($encoding != "UTF-8") {
        $str_file = iconv($encoding, "UTF-8", $str_file);
    }
} else {
    $a = $str_file;
    $c = mb_strlen($a);
    $str_file = "";
    $z = 0;
    //echo "<table>";
    for($i = 0; $i < $c; $i++) {
        $x = mb_substr($a, $i, 1);
        if(mb_check_encoding($x, "UTF-8") == FALSE) { // If the multibyte got by mb_substr is not valid then it must be single-byte?
            for($y = 0; $y < strlen($x); $y++) {
                if(preg_match('#[\x7F-\x9F\xBC]#', $a[$z+$y])) {
                    $encoding = 'WINDOWS-1250';
                } else {
                    $encoding = mb_detect_encoding($a[$z+$y], array("UTF-8", "ISO-8859-1", "UTF-7", "ASCII", "EUC-JP", "SJIS", "eucJP-win", "SJIS-win", "JIS", "ISO-2022-JP"), true);
                }
                //echo "<tr><td>" . $a[$z+$y] . "</td><td>" . iconv($encoding, "UTF-8", $a[$z+$y]) . "</td></tr>";
                $str_file .= iconv($encoding, "UTF-8", $a[$z+$y]);
            }
        } else {
            //echo "<tr><td>" . $x . "</td><td>" . $x . "</td></tr>";
            $str_file .= $x;
        }
        $z = $z + strlen($x);
    }
    //echo "</table>";
}*/


/* ORIGINAL Get encoding of file.
if(preg_match('#[\x7F-\x9F\xBC]#', $str_file)) {
    $encoding = "Windows-1250";
} elseif(detect_utf_encoding($str_file)) {
    $encoding = detect_utf_encoding($str_file); //Passes the whole file into the function. Better to let the function get the file_content from the inside?
} else {
    $encoding = mb_detect_encoding($str_file, array("UTF-8", "ISO-8859-1", "UTF-7", "ASCII", "EUC-JP","SJIS", "eucJP-win", "SJIS-win", "JIS", "ISO-2022-JP"), true);
}
/*
// We try to check the encoding (UTF-16LE, UTF-16BE, UTF-32LE, UTF-32BE) with a handmade function
$encoding = detect_utf_encoding($str_file); //Passes the whole file into the function. Better to let the function get the file_content from the inside?
//$encoding = mb_detect_encoding($str_file, array("UTF-8", "ISO-8859-1", "UTF-7", "ASCII", "EUC-JP","SJIS", "eucJP-win", "SJIS-win", "JIS", "ISO-2022-JP"), true);
echo "<!-- $encoding -->";
// If cannot find then try php's internal function mb_detect_encoding
if(!$encoding) {
    $encoding = mb_detect_encoding($str_file, array("UTF-8", "ISO-8859-1", "UTF-7", "ASCII", "EUC-JP","SJIS", "eucJP-win", "SJIS-win", "JIS", "ISO-2022-JP"), true);
}*/

/* If different than utf-8 then convert to utf-8 using iconv https://www.php.net/manual/en/function.iconv
 * Also use mb_convert_encoding() to try brute forcing UTF-8 encoding from ASCII
 */


?>