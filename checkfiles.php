<html>
	<body>
	
<?php
$dir = "downloads2/";
$daysOld = '61';
$dateToCompare = date('Y-m-d H:i:s',  strtotime('-'.$daysOld.' days',time()));
$i = 0;
$max = 60000;
//$a = microtime(true);

echo "Directory: " . $dir . "<br />";
echo "Days old: " . $daysOld . "<br />";
echo "Date to compare: " . $dateToCompare . "<br />";
echo "Display: " . $max . " files<br /><br />";

/*
$num = count(glob($dir . "*"));
echo $num . "<br />";*/
/*
$files = glob($dir. '*.sub'); // get all file names
foreach($files as $file) { // iterate files
	if (++$i == 2) break;
	if(is_file($file)) {
		print_r($file); //unlink($file); // delete file
	}
}*/

// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			clearstatcache(); //Clear the file status cache
			
			if ($file != "." && $file != "..") {
				$lastModifiedTimestamp = filemtime($dir . $file);
				$lastModifiedDatetime = date("Y-m-d H:i:s", $lastModifiedTimestamp);
				
				if(strtotime($dateToCompare) >= $lastModifiedTimestamp) {
					echo "** " . $dateToCompare . " >= " . $lastModifiedDatetime;
				} else {
					echo $dateToCompare . " < " . $lastModifiedDatetime;;
				}
				//if(is_file($file))
				echo " filename: $file : filetype: " . filetype($dir . $file) . " - ";
				echo "Last modified on $lastModifiedDatetime";
				if(strtotime($dateToCompare) >= $lastModifiedTimestamp) {
					if(unlink($dir . $file)) {
						echo "  -  ****DELETED";
					} else {
						var_dump(unlink($dir . $file));
					}
				}


				echo "<br>";
				/*if(strtotime($dateToCompare) >= $modTime){ 
					if(!ftp_delete($connection,$file)){ //Deleting the file that needs to be deleted
						//If the file fails to delete we send a mail to the administrator
						mail($notificationEmail, 'FAILED TO DELETE FILE', 'FAILED TO DELETE FILE: '.$file);
					}
				}*/
				if (++$i == $max) break;
			}
        }
        closedir($dh);
    }
}
//echo "Execution: " . (microtime(true) - $a)."s<br />";
?>
	</body>
</html>