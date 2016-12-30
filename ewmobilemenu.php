<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mmi_tb_anggota", $Language->MenuPhrase("1", "MenuText"), "tb_anggotalist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_anggota'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mmci_Manajemen_Akun", $Language->MenuPhrase("15", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(7, "mmi_tb_level1", $Language->MenuPhrase("7", "MenuText"), "tb_level1list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level1'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_tb_level2", $Language->MenuPhrase("8", "MenuText"), "tb_level2list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level2'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mmi_tb_level3", $Language->MenuPhrase("9", "MenuText"), "tb_level3list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level3'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mmi_tb_level4", $Language->MenuPhrase("10", "MenuText"), "tb_level4list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_level4'), FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mmi_tb_user", $Language->MenuPhrase("16", "MenuText"), "tb_userlist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mmi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
