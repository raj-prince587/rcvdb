<?php
//string exec ( string $command [, array &$output [, int &$return_var ]] )
// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)
//echo exec('whoami');
exec('mysqlfrm --server=dev:dev@localhost:3306 --quiet "C:\Users\rupak.18THM001\Desktop\Database Migration\cmswebe\cmswebe_cmsdb" --port=3333 > output.txt');
$file1 = fopen("output.txt", "r") or die("Unable to open file!");
$file2 = fopen("output1.txt", "w") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($file1)) {
	$line = fgets($file1);
	$pos = strpos($line, '#');
	$posW = strpos($line, 'WARNING');
	$posE = strpos($line, 'ENGINE');
	
	if( $posE !== false )
	{
		$line .= ';';
	}
	
	//var_dump($pos);
	//echo '<br>';
	if( $pos === 0 || $posW === 0 )
	{
	}
	else
	{
		fwrite($file2, $line);
		//echo $line;
		//echo '<br>';
	}
}
fclose($file1);
fclose($file2);

echo 'Done';