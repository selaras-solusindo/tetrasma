<?php
include("conn.php");
mysql_connect($hostname_conn, $username_conn, $password_conn) or die ("Tidak bisa terkoneksi ke Database server");
mysql_select_db($database_conn) or die ("Database tidak ditemukan");
$akun_id = $_GET['q'];
//$hasil = $kode.date("Ym")."001";
$hasil = "";
if ($akun_id) {
	$query = mysql_query("select * from v_akun_jurnal where level4_id = ".$akun_id."");
	while($d = mysql_fetch_array($query)){
		//echo $d['alamat'];
		//$sLastKode = intval(substr($d["no_bukti"], 8, 3)); // ambil 3 digit terakhir
		//$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		//$hasil = $kode.date("Ym").sprintf('%03s', $sLastKode);
		$hasil = $d["jurnal_kode"];
	}
}
echo $hasil;

?>



