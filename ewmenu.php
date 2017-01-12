<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(25, "mi_ambiljurnalkode_php", $Language->MenuPhrase("25", "MenuText"), "ambiljurnalkode.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}ambiljurnalkode.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(22, "mi_home_php", $Language->MenuPhrase("22", "MenuText"), "home.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mi_tb_anggota", $Language->MenuPhrase("1", "MenuText"), "tb_anggotalist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_anggota'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mci_Manajemen_Akun", $Language->MenuPhrase("15", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(7, "mi_tb_level1", $Language->MenuPhrase("7", "MenuText"), "tb_level1list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level1'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mi_tb_level2", $Language->MenuPhrase("8", "MenuText"), "tb_level2list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level2'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mi_tb_level3", $Language->MenuPhrase("9", "MenuText"), "tb_level3list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level3'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mi_tb_level4", $Language->MenuPhrase("10", "MenuText"), "tb_level4list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level4'), FALSE, FALSE);
$RootMenu->AddMenuItem(19, "mi_view_akun_php", $Language->MenuPhrase("19", "MenuText"), "view_akun.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}view_akun.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(42, "mci_Jurnal", $Language->MenuPhrase("42", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(20, "mi_tb_jurnal", $Language->MenuPhrase("20", "MenuText"), "tb_jurnallist.php", 42, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_jurnal'), FALSE, FALSE);
$RootMenu->AddMenuItem(27, "mi_tb_jurnalm", $Language->MenuPhrase("27", "MenuText"), "tb_jurnalmlist.php", 42, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_jurnalm'), FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mi_tb_user", $Language->MenuPhrase("16", "MenuText"), "tb_userlist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
