<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(22, "mi_home_php", $Language->MenuPhrase("22", "MenuText"), "home.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mi_t_anggota", $Language->MenuPhrase("1", "MenuText"), "t_anggotalist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_anggota'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mci_Manajemen_Akun", $Language->MenuPhrase("15", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(7, "mi_t_level1", $Language->MenuPhrase("7", "MenuText"), "t_level1list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_level1'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mi_t_level2", $Language->MenuPhrase("8", "MenuText"), "t_level2list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_level2'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mi_t_level3", $Language->MenuPhrase("9", "MenuText"), "t_level3list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_level3'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mi_t_level4", $Language->MenuPhrase("10", "MenuText"), "t_level4list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_level4'), FALSE, FALSE);
$RootMenu->AddMenuItem(19, "mi_view_akun_php", $Language->MenuPhrase("19", "MenuText"), "view_akun.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}view_akun.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(42, "mci_Jurnal", $Language->MenuPhrase("42", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(20, "mi_t_jurnal", $Language->MenuPhrase("20", "MenuText"), "t_jurnallist.php", 42, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_jurnal'), FALSE, FALSE);
$RootMenu->AddMenuItem(27, "mi_t_jurnalm", $Language->MenuPhrase("27", "MenuText"), "t_jurnalmlist.php", 42, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_jurnalm'), FALSE, FALSE);
$RootMenu->AddMenuItem(10020, "mci_Laporan", $Language->MenuPhrase("10020", "MenuText"), "", -1, "{0947E56A-59DA-4545-A2FF-20A7F7239C7D}", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(10019, "mri_r5fbukubesar", $Language->MenuPhrase("10019", "MenuText"), "r_bukubesarsmry.php", 10020, "{0947E56A-59DA-4545-A2FF-20A7F7239C7D}", AllowListMenu('{0947E56A-59DA-4545-A2FF-20A7F7239C7D}r_bukubesar'), FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mi_t_user", $Language->MenuPhrase("16", "MenuText"), "t_userlist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}t_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
