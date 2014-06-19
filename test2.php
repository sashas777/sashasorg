<?php
$param1 = $_POST ['title'];
$para2 = $_POST ['content'];
$file = $_POST ['picture'];
file_put_contents ( 'yourFilename.jpg', $file );
$myFile = "testFile.txt";
$fh = fopen ( $myFile, 'w+' ) or die ( "can't open file" );
$stringData = "Bobby Bopper\n";
fwrite ( $fh, $param1 );
$stringData = "Tracy Tanner\n";
fwrite ( $fh, $stringData );
fwrite ( $fh, $para2 );
fwrite ( $fh, $stringData );
fwrite ( $fh, $file );
fwrite ( $fh, $stringData );
  
if(move_uploaded_file($_FILES["picture"]["tmp_name"] , "images/android/" . $_FILES["picture"]["name"] )){
	fwrite ( $fh, "saved\n" );
}

foreach ( $_FILES as $key => $value ) {
	$st = ' ' . $key . ' '.$value;
	fwrite ( $fh, $st );
}
 
//fwrite ( $fh, print_r ( $_FILES ) );

fclose ( $fh );

 