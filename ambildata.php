<?php
mysql_connect("localhost","root","admin");
mysql_select_db("db_contoh");
$nip = $_GET['q'];
if($nip){
$query = mysql_query("select alamat from tabeldatakaryawan where
nip=$nip");
while($d = mysql_fetch_array($query)){
echo $d['alamat'];
}
}
?>