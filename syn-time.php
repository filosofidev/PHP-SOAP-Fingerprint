<html>
<head><title>Sinkron Waktu Fingerprint</title></head>
<body bgcolor="#caffcb">

<H3>Sinkronisasi Waktu Mesin</H3>

<?
$IP=$HTTP_GET_VARS["ip"];
$Key=$HTTP_GET_VARS["key"];
if($IP=="") $IP="36.91.3.114";
if($Key=="") $Key="0";
?>
<form action="syn-time.php">
IP : <input type="Text" name="ip" value="<?=$IP?>" size=15><BR><BR>
Key : <input type="Text" name="key" size="5" value="<?=$Key?>"><BR><BR>

<input type="Submit" value="Sinkron Waktu">
</form>
<BR>

<?
if($HTTP_GET_VARS["ip"]!=""){
	$Connect = fsockopen($IP, "80", $errno, $errstr, 1);
	if($Connect){
		$soap_request="<SetDate><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><Date xsi:type=\"xsd:string\">12-02-02</Date><Time xsi:type=\"xsd:string\">".date("H:i:s")."</Time></Arg></SetDate>";
		$newLine="\r\n";
		fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($Connect, "Content-Type: text/xml".$newLine);
	    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($Connect, $soap_request.$newLine);
		$buffer="";
		while($Response=fgets($Connect, 1024)){
			$buffer=$buffer.$Response;
		}
	}else echo "Koneksi Gagal";
	include("parse.php");	
	$buffer=Parse_Data($buffer,"<Information>","</Information>");
	echo "<B>Result:</B><BR>";
	echo $buffer;
}	
?>
</body>
</html>

