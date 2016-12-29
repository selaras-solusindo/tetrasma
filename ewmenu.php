<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mi_tb_anggota", $Language->MenuPhrase("1", "MenuText"), "tb_anggotalist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_anggota'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mci_Manajemen_Akun", $Language->MenuPhrase("15", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(7, "mi_level1", $Language->MenuPhrase("7", "MenuText"), "level1list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}level1'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mi_level2", $Language->MenuPhrase("8", "MenuText"), "level2list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}level2'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mi_level3", $Language->MenuPhrase("9", "MenuText"), "level3list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}level3'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mi_level4", $Language->MenuPhrase("10", "MenuText"), "level4list.php", 15, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}level4'), FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mi_tb_user", $Language->MenuPhrase("16", "MenuText"), "tb_userlist.php", -1, "", AllowListMenu('{D8E5AA29-C8A1-46A6-8DFF-08A223163C5D}tb_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
