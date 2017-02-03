<?php

// Global variable for table object
$tb_level4 = NULL;

//
// Table class for tb_level4
//
class ctb_level4 extends cTable {
	var $level4_id;
	var $level1_id;
	var $level2_id;
	var $level3_id;
	var $level4_no;
	var $level4_nama;
	var $saldo_awal;
	var $saldo;
	var $jurnal;
	var $jurnal_kode;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_level4';
		$this->TableName = 'tb_level4';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_level4`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// level4_id
		$this->level4_id = new cField('tb_level4', 'tb_level4', 'x_level4_id', 'level4_id', '`level4_id`', '`level4_id`', 3, -1, FALSE, '`level4_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->level4_id->Sortable = TRUE; // Allow sort
		$this->level4_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['level4_id'] = &$this->level4_id;

		// level1_id
		$this->level1_id = new cField('tb_level4', 'tb_level4', 'x_level1_id', 'level1_id', '`level1_id`', '`level1_id`', 3, -1, FALSE, '`EV__level1_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->level1_id->Sortable = TRUE; // Allow sort
		$this->level1_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['level1_id'] = &$this->level1_id;

		// level2_id
		$this->level2_id = new cField('tb_level4', 'tb_level4', 'x_level2_id', 'level2_id', '`level2_id`', '`level2_id`', 3, -1, FALSE, '`EV__level2_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->level2_id->Sortable = TRUE; // Allow sort
		$this->level2_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['level2_id'] = &$this->level2_id;

		// level3_id
		$this->level3_id = new cField('tb_level4', 'tb_level4', 'x_level3_id', 'level3_id', '`level3_id`', '`level3_id`', 3, -1, FALSE, '`EV__level3_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->level3_id->Sortable = TRUE; // Allow sort
		$this->level3_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['level3_id'] = &$this->level3_id;

		// level4_no
		$this->level4_no = new cField('tb_level4', 'tb_level4', 'x_level4_no', 'level4_no', '`level4_no`', '`level4_no`', 200, -1, FALSE, '`level4_no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->level4_no->Sortable = TRUE; // Allow sort
		$this->fields['level4_no'] = &$this->level4_no;

		// level4_nama
		$this->level4_nama = new cField('tb_level4', 'tb_level4', 'x_level4_nama', 'level4_nama', '`level4_nama`', '`level4_nama`', 200, -1, FALSE, '`level4_nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->level4_nama->Sortable = TRUE; // Allow sort
		$this->fields['level4_nama'] = &$this->level4_nama;

		// saldo_awal
		$this->saldo_awal = new cField('tb_level4', 'tb_level4', 'x_saldo_awal', 'saldo_awal', '`saldo_awal`', '`saldo_awal`', 20, -1, FALSE, '`saldo_awal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->saldo_awal->Sortable = TRUE; // Allow sort
		$this->saldo_awal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['saldo_awal'] = &$this->saldo_awal;

		// saldo
		$this->saldo = new cField('tb_level4', 'tb_level4', 'x_saldo', 'saldo', '`saldo`', '`saldo`', 20, -1, FALSE, '`saldo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->saldo->Sortable = FALSE; // Allow sort
		$this->saldo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['saldo'] = &$this->saldo;

		// jurnal
		$this->jurnal = new cField('tb_level4', 'tb_level4', 'x_jurnal', 'jurnal', '`jurnal`', '`jurnal`', 16, -1, FALSE, '`jurnal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->jurnal->Sortable = TRUE; // Allow sort
		$this->jurnal->OptionCount = 2;
		$this->jurnal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jurnal'] = &$this->jurnal;

		// jurnal_kode
		$this->jurnal_kode = new cField('tb_level4', 'tb_level4', 'x_jurnal_kode', 'jurnal_kode', '`jurnal_kode`', '`jurnal_kode`', 200, -1, FALSE, '`jurnal_kode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->jurnal_kode->Sortable = TRUE; // Allow sort
		$this->jurnal_kode->OptionCount = 2;
		$this->fields['jurnal_kode'] = &$this->jurnal_kode;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_level4`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlSelectList = "";

	function getSqlSelectList() { // Select for List page
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, (SELECT CONCAT(`level1_no`,'" . ew_ValueSeparator(1, $this->level1_id) . "',`level1_nama`) FROM `tb_level1` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`level1_id` = `tb_level4`.`level1_id` LIMIT 1) AS `EV__level1_id`, (SELECT CONCAT(`level2_no`,'" . ew_ValueSeparator(1, $this->level2_id) . "',`level2_nama`) FROM `tb_level2` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`level2_id` = `tb_level4`.`level2_id` LIMIT 1) AS `EV__level2_id`, (SELECT CONCAT(`level3_no`,'" . ew_ValueSeparator(1, $this->level3_id) . "',`level3_nama`) FROM `tb_level3` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`level3_id` = `tb_level4`.`level3_id` LIMIT 1) AS `EV__level3_id` FROM `tb_level4`" .
			") `EW_TMP_TABLE`";
		return ($this->_SqlSelectList <> "") ? $this->_SqlSelectList : $select;
	}

	function SqlSelectList() { // For backward compatibility
		return $this->getSqlSelectList();
	}

	function setSqlSelectList($v) {
		$this->_SqlSelectList = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		if ($this->UseVirtualFields()) {
			$sSort = $this->getSessionOrderByList();
			return ew_BuildSelectSql($this->getSqlSelectList(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		} else {
			$sSort = $this->getSessionOrderBy();
			return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		}
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->getSessionWhere();
		$sOrderBy = $this->getSessionOrderByList();
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->level1_id->AdvancedSearch->SearchValue <> "" ||
			$this->level1_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->level1_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->level1_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if ($this->level2_id->AdvancedSearch->SearchValue <> "" ||
			$this->level2_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->level2_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->level2_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if ($this->level3_id->AdvancedSearch->SearchValue <> "" ||
			$this->level3_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->level3_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->level3_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('level4_id', $rs))
				ew_AddFilter($where, ew_QuotedName('level4_id', $this->DBID) . '=' . ew_QuotedValue($rs['level4_id'], $this->level4_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`level4_id` = @level4_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->level4_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@level4_id@", ew_AdjustSql($this->level4_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "tb_level4list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tb_level4list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_level4view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_level4view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_level4add.php?" . $this->UrlParm($parm);
		else
			$url = "tb_level4add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tb_level4edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tb_level4add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_level4delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "level4_id:" . ew_VarToJson($this->level4_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->level4_id->CurrentValue)) {
			$sUrl .= "level4_id=" . urlencode($this->level4_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["level4_id"]))
				$arKeys[] = ew_StripSlashes($_POST["level4_id"]);
			elseif (isset($_GET["level4_id"]))
				$arKeys[] = ew_StripSlashes($_GET["level4_id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->level4_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->level4_id->setDbValue($rs->fields('level4_id'));
		$this->level1_id->setDbValue($rs->fields('level1_id'));
		$this->level2_id->setDbValue($rs->fields('level2_id'));
		$this->level3_id->setDbValue($rs->fields('level3_id'));
		$this->level4_no->setDbValue($rs->fields('level4_no'));
		$this->level4_nama->setDbValue($rs->fields('level4_nama'));
		$this->saldo_awal->setDbValue($rs->fields('saldo_awal'));
		$this->saldo->setDbValue($rs->fields('saldo'));
		$this->jurnal->setDbValue($rs->fields('jurnal'));
		$this->jurnal_kode->setDbValue($rs->fields('jurnal_kode'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// level4_id
		// level1_id
		// level2_id
		// level3_id
		// level4_no
		// level4_nama
		// saldo_awal
		// saldo
		// jurnal
		// jurnal_kode
		// level4_id

		$this->level4_id->ViewValue = $this->level4_id->CurrentValue;
		$this->level4_id->ViewCustomAttributes = "";

		// level1_id
		if ($this->level1_id->VirtualValue <> "") {
			$this->level1_id->ViewValue = $this->level1_id->VirtualValue;
		} else {
			$this->level1_id->ViewValue = $this->level1_id->CurrentValue;
		if (strval($this->level1_id->CurrentValue) <> "") {
			$sFilterWrk = "`level1_id`" . ew_SearchString("=", $this->level1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level1_id`, `level1_no` AS `DispFld`, `level1_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level1`";
		$sWhereWrk = "";
		$this->level1_id->LookupFilters = array("dx1" => '`level1_no`', "dx2" => '`level1_nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->level1_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->level1_id->ViewValue = $this->level1_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->level1_id->ViewValue = $this->level1_id->CurrentValue;
			}
		} else {
			$this->level1_id->ViewValue = NULL;
		}
		}
		$this->level1_id->ViewCustomAttributes = "";

		// level2_id
		if ($this->level2_id->VirtualValue <> "") {
			$this->level2_id->ViewValue = $this->level2_id->VirtualValue;
		} else {
			$this->level2_id->ViewValue = $this->level2_id->CurrentValue;
		if (strval($this->level2_id->CurrentValue) <> "") {
			$sFilterWrk = "`level2_id`" . ew_SearchString("=", $this->level2_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level2_id`, `level2_no` AS `DispFld`, `level2_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level2`";
		$sWhereWrk = "";
		$this->level2_id->LookupFilters = array("dx1" => '`level2_no`', "dx2" => '`level2_nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->level2_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->level2_id->ViewValue = $this->level2_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->level2_id->ViewValue = $this->level2_id->CurrentValue;
			}
		} else {
			$this->level2_id->ViewValue = NULL;
		}
		}
		$this->level2_id->ViewCustomAttributes = "";

		// level3_id
		if ($this->level3_id->VirtualValue <> "") {
			$this->level3_id->ViewValue = $this->level3_id->VirtualValue;
		} else {
			$this->level3_id->ViewValue = $this->level3_id->CurrentValue;
		if (strval($this->level3_id->CurrentValue) <> "") {
			$sFilterWrk = "`level3_id`" . ew_SearchString("=", $this->level3_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level3_id`, `level3_no` AS `DispFld`, `level3_nama` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_level3`";
		$sWhereWrk = "";
		$this->level3_id->LookupFilters = array("dx1" => '`level3_no`', "dx2" => '`level3_nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->level3_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->level3_id->ViewValue = $this->level3_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->level3_id->ViewValue = $this->level3_id->CurrentValue;
			}
		} else {
			$this->level3_id->ViewValue = NULL;
		}
		}
		$this->level3_id->ViewCustomAttributes = "";

		// level4_no
		$this->level4_no->ViewValue = $this->level4_no->CurrentValue;
		$this->level4_no->ViewCustomAttributes = "";

		// level4_nama
		$this->level4_nama->ViewValue = $this->level4_nama->CurrentValue;
		$this->level4_nama->ViewCustomAttributes = "";

		// saldo_awal
		$this->saldo_awal->ViewValue = $this->saldo_awal->CurrentValue;
		$this->saldo_awal->ViewValue = ew_FormatNumber($this->saldo_awal->ViewValue, 0, -2, -2, -1);
		$this->saldo_awal->CellCssStyle .= "text-align: right;";
		$this->saldo_awal->ViewCustomAttributes = "";

		// saldo
		$this->saldo->ViewValue = $this->saldo->CurrentValue;
		$this->saldo->ViewValue = ew_FormatNumber($this->saldo->ViewValue, 0, -2, -2, -1);
		$this->saldo->CellCssStyle .= "text-align: right;";
		$this->saldo->ViewCustomAttributes = "";

		// jurnal
		if (strval($this->jurnal->CurrentValue) <> "") {
			$this->jurnal->ViewValue = $this->jurnal->OptionCaption($this->jurnal->CurrentValue);
		} else {
			$this->jurnal->ViewValue = NULL;
		}
		$this->jurnal->ViewCustomAttributes = "";

		// jurnal_kode
		if (strval($this->jurnal_kode->CurrentValue) <> "") {
			$this->jurnal_kode->ViewValue = $this->jurnal_kode->OptionCaption($this->jurnal_kode->CurrentValue);
		} else {
			$this->jurnal_kode->ViewValue = NULL;
		}
		$this->jurnal_kode->ViewCustomAttributes = "";

		// level4_id
		$this->level4_id->LinkCustomAttributes = "";
		$this->level4_id->HrefValue = "";
		$this->level4_id->TooltipValue = "";

		// level1_id
		$this->level1_id->LinkCustomAttributes = "";
		$this->level1_id->HrefValue = "";
		$this->level1_id->TooltipValue = "";

		// level2_id
		$this->level2_id->LinkCustomAttributes = "";
		$this->level2_id->HrefValue = "";
		$this->level2_id->TooltipValue = "";

		// level3_id
		$this->level3_id->LinkCustomAttributes = "";
		$this->level3_id->HrefValue = "";
		$this->level3_id->TooltipValue = "";

		// level4_no
		$this->level4_no->LinkCustomAttributes = "";
		$this->level4_no->HrefValue = "";
		$this->level4_no->TooltipValue = "";

		// level4_nama
		$this->level4_nama->LinkCustomAttributes = "";
		$this->level4_nama->HrefValue = "";
		$this->level4_nama->TooltipValue = "";

		// saldo_awal
		$this->saldo_awal->LinkCustomAttributes = "";
		$this->saldo_awal->HrefValue = "";
		$this->saldo_awal->TooltipValue = "";

		// saldo
		$this->saldo->LinkCustomAttributes = "";
		$this->saldo->HrefValue = "";
		$this->saldo->TooltipValue = "";

		// jurnal
		$this->jurnal->LinkCustomAttributes = "";
		$this->jurnal->HrefValue = "";
		$this->jurnal->TooltipValue = "";

		// jurnal_kode
		$this->jurnal_kode->LinkCustomAttributes = "";
		$this->jurnal_kode->HrefValue = "";
		$this->jurnal_kode->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// level4_id
		$this->level4_id->EditAttrs["class"] = "form-control";
		$this->level4_id->EditCustomAttributes = "";
		$this->level4_id->EditValue = $this->level4_id->CurrentValue;
		$this->level4_id->ViewCustomAttributes = "";

		// level1_id
		$this->level1_id->EditAttrs["class"] = "form-control";
		$this->level1_id->EditCustomAttributes = "";
		$this->level1_id->EditValue = $this->level1_id->CurrentValue;
		$this->level1_id->PlaceHolder = ew_RemoveHtml($this->level1_id->FldCaption());

		// level2_id
		$this->level2_id->EditAttrs["class"] = "form-control";
		$this->level2_id->EditCustomAttributes = "";
		$this->level2_id->EditValue = $this->level2_id->CurrentValue;
		$this->level2_id->PlaceHolder = ew_RemoveHtml($this->level2_id->FldCaption());

		// level3_id
		$this->level3_id->EditAttrs["class"] = "form-control";
		$this->level3_id->EditCustomAttributes = "";
		$this->level3_id->EditValue = $this->level3_id->CurrentValue;
		$this->level3_id->PlaceHolder = ew_RemoveHtml($this->level3_id->FldCaption());

		// level4_no
		$this->level4_no->EditAttrs["class"] = "form-control";
		$this->level4_no->EditCustomAttributes = "";
		$this->level4_no->EditValue = $this->level4_no->CurrentValue;
		$this->level4_no->PlaceHolder = ew_RemoveHtml($this->level4_no->FldCaption());

		// level4_nama
		$this->level4_nama->EditAttrs["class"] = "form-control";
		$this->level4_nama->EditCustomAttributes = "";
		$this->level4_nama->EditValue = $this->level4_nama->CurrentValue;
		$this->level4_nama->PlaceHolder = ew_RemoveHtml($this->level4_nama->FldCaption());

		// saldo_awal
		$this->saldo_awal->EditAttrs["class"] = "form-control";
		$this->saldo_awal->EditCustomAttributes = "";
		$this->saldo_awal->EditValue = $this->saldo_awal->CurrentValue;
		$this->saldo_awal->PlaceHolder = ew_RemoveHtml($this->saldo_awal->FldCaption());

		// saldo
		$this->saldo->EditAttrs["class"] = "form-control";
		$this->saldo->EditCustomAttributes = "";
		$this->saldo->EditValue = $this->saldo->CurrentValue;
		$this->saldo->PlaceHolder = ew_RemoveHtml($this->saldo->FldCaption());

		// jurnal
		$this->jurnal->EditCustomAttributes = "";
		$this->jurnal->EditValue = $this->jurnal->Options(FALSE);

		// jurnal_kode
		$this->jurnal_kode->EditCustomAttributes = "";
		$this->jurnal_kode->EditValue = $this->jurnal_kode->Options(FALSE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->level1_id->Exportable) $Doc->ExportCaption($this->level1_id);
					if ($this->level2_id->Exportable) $Doc->ExportCaption($this->level2_id);
					if ($this->level3_id->Exportable) $Doc->ExportCaption($this->level3_id);
					if ($this->level4_no->Exportable) $Doc->ExportCaption($this->level4_no);
					if ($this->level4_nama->Exportable) $Doc->ExportCaption($this->level4_nama);
					if ($this->saldo_awal->Exportable) $Doc->ExportCaption($this->saldo_awal);
					if ($this->jurnal->Exportable) $Doc->ExportCaption($this->jurnal);
					if ($this->jurnal_kode->Exportable) $Doc->ExportCaption($this->jurnal_kode);
				} else {
					if ($this->level1_id->Exportable) $Doc->ExportCaption($this->level1_id);
					if ($this->level2_id->Exportable) $Doc->ExportCaption($this->level2_id);
					if ($this->level3_id->Exportable) $Doc->ExportCaption($this->level3_id);
					if ($this->level4_no->Exportable) $Doc->ExportCaption($this->level4_no);
					if ($this->level4_nama->Exportable) $Doc->ExportCaption($this->level4_nama);
					if ($this->saldo_awal->Exportable) $Doc->ExportCaption($this->saldo_awal);
					if ($this->jurnal->Exportable) $Doc->ExportCaption($this->jurnal);
					if ($this->jurnal_kode->Exportable) $Doc->ExportCaption($this->jurnal_kode);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->level1_id->Exportable) $Doc->ExportField($this->level1_id);
						if ($this->level2_id->Exportable) $Doc->ExportField($this->level2_id);
						if ($this->level3_id->Exportable) $Doc->ExportField($this->level3_id);
						if ($this->level4_no->Exportable) $Doc->ExportField($this->level4_no);
						if ($this->level4_nama->Exportable) $Doc->ExportField($this->level4_nama);
						if ($this->saldo_awal->Exportable) $Doc->ExportField($this->saldo_awal);
						if ($this->jurnal->Exportable) $Doc->ExportField($this->jurnal);
						if ($this->jurnal_kode->Exportable) $Doc->ExportField($this->jurnal_kode);
					} else {
						if ($this->level1_id->Exportable) $Doc->ExportField($this->level1_id);
						if ($this->level2_id->Exportable) $Doc->ExportField($this->level2_id);
						if ($this->level3_id->Exportable) $Doc->ExportField($this->level3_id);
						if ($this->level4_no->Exportable) $Doc->ExportField($this->level4_no);
						if ($this->level4_nama->Exportable) $Doc->ExportField($this->level4_nama);
						if ($this->saldo_awal->Exportable) $Doc->ExportField($this->saldo_awal);
						if ($this->jurnal->Exportable) $Doc->ExportField($this->jurnal);
						if ($this->jurnal_kode->Exportable) $Doc->ExportField($this->jurnal_kode);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
