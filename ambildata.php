<?php
include("conn.php");
mysql_connect($hostname_conn, $username_conn, $password_conn) or die ("Tidak bisa terkoneksi ke Database server");
mysql_select_db($database_conn) or die ("Database tidak ditemukan");
$kode = $_GET['q'];
$hasil = $kode.date("Ym")."001";
if ($kode) {
	$query = mysql_query("select no_bukti from tb_jurnal where left(no_bukti, 2) = '".$kode."'");
	while($d = mysql_fetch_array($query)){
		//echo $d['alamat'];
		$sLastKode = intval(substr($d["no_bukti"], 8, 3)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$hasil = $kode.date("Ym").sprintf('%03s', $sLastKode);
	}
}
echo $hasil;

?>


