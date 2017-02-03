<?php

// Global variable for table object
$tb_detail = NULL;

//
// Table class for tb_detail
//
class ctb_detail extends cTable {
	var $detail_id;
	var $jurnal_id;
	var $akun_id;
	var $nilai;
	var $anggota_id;
	var $dk;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_detail';
		$this->TableName = 'tb_detail';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_detail`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// detail_id
		$this->detail_id = new cField('tb_detail', 'tb_detail', 'x_detail_id', 'detail_id', '`detail_id`', '`detail_id`', 3, -1, FALSE, '`detail_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->detail_id->Sortable = TRUE; // Allow sort
		$this->detail_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['detail_id'] = &$this->detail_id;

		// jurnal_id
		$this->jurnal_id = new cField('tb_detail', 'tb_detail', 'x_jurnal_id', 'jurnal_id', '`jurnal_id`', '`jurnal_id`', 3, -1, FALSE, '`jurnal_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jurnal_id->Sortable = TRUE; // Allow sort
		$this->jurnal_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jurnal_id'] = &$this->jurnal_id;

		// akun_id
		$this->akun_id = new cField('tb_detail', 'tb_detail', 'x_akun_id', 'akun_id', '`akun_id`', '`akun_id`', 3, -1, FALSE, '`EV__akun_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->akun_id->Sortable = TRUE; // Allow sort
		$this->akun_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['akun_id'] = &$this->akun_id;

		// nilai
		$this->nilai = new cField('tb_detail', 'tb_detail', 'x_nilai', 'nilai', '`nilai`', '`nilai`', 20, -1, FALSE, '`nilai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nilai->Sortable = TRUE; // Allow sort
		$this->nilai->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['nilai'] = &$this->nilai;

		// anggota_id
		$this->anggota_id = new cField('tb_detail', 'tb_detail', 'x_anggota_id', 'anggota_id', '`anggota_id`', '`anggota_id`', 3, -1, FALSE, '`EV__anggota_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->anggota_id->Sortable = TRUE; // Allow sort
		$this->anggota_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['anggota_id'] = &$this->anggota_id;

		// dk
		$this->dk = new cField('tb_detail', 'tb_detail', 'x_dk', 'dk', '`dk`', '`dk`', 16, -1, FALSE, '`dk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dk->Sortable = TRUE; // Allow sort
		$this->dk->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dk'] = &$this->dk;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "tb_jurnal") {
			if ($this->jurnal_id->getSessionValue() <> "")
				$sMasterFilter .= "`jurnal_id`=" . ew_QuotedValue($this->jurnal_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "tb_jurnal") {
			if ($this->jurnal_id->getSessionValue() <> "")
				$sDetailFilter .= "`jurnal_id`=" . ew_QuotedValue($this->jurnal_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_tb_jurnal() {
		return "`jurnal_id`=@jurnal_id@";
	}

	// Detail filter
	function SqlDetailFilter_tb_jurnal() {
		return "`jurnal_id`=@jurnal_id@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_detail`";
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
			"SELECT *, (SELECT `no_nama_akun` FROM `view_akun_jurnal` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`level4_id` = `tb_detail`.`akun_id` LIMIT 1) AS `EV__akun_id`, (SELECT `nama` FROM `tb_anggota` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`anggota_id` = `tb_detail`.`anggota_id` LIMIT 1) AS `EV__anggota_id` FROM `tb_detail`" .
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
		if ($this->akun_id->AdvancedSearch->SearchValue <> "" ||
			$this->akun_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->akun_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->akun_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if ($this->anggota_id->AdvancedSearch->SearchValue <> "" ||
			$this->anggota_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->anggota_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->anggota_id->FldVirtualExpression . " ") !== FALSE)
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
			if (array_key_exists('detail_id', $rs))
				ew_AddFilter($where, ew_QuotedName('detail_id', $this->DBID) . '=' . ew_QuotedValue($rs['detail_id'], $this->detail_id->FldDataType, $this->DBID));
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
		return "`detail_id` = @detail_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->detail_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@detail_id@", ew_AdjustSql($this->detail_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "tb_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tb_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_detailview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_detailadd.php?" . $this->UrlParm($parm);
		else
			$url = "tb_detailadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tb_detailedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tb_detailadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_detaildelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "tb_jurnal" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_jurnal_id=" . urlencode($this->jurnal_id->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "detail_id:" . ew_VarToJson($this->detail_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->detail_id->CurrentValue)) {
			$sUrl .= "detail_id=" . urlencode($this->detail_id->CurrentValue);
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
			if ($isPost && isset($_POST["detail_id"]))
				$arKeys[] = ew_StripSlashes($_POST["detail_id"]);
			elseif (isset($_GET["detail_id"]))
				$arKeys[] = ew_StripSlashes($_GET["detail_id"]);
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
			$this->detail_id->CurrentValue = $key;
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
		$this->detail_id->setDbValue($rs->fields('detail_id'));
		$this->jurnal_id->setDbValue($rs->fields('jurnal_id'));
		$this->akun_id->setDbValue($rs->fields('akun_id'));
		$this->nilai->setDbValue($rs->fields('nilai'));
		$this->anggota_id->setDbValue($rs->fields('anggota_id'));
		$this->dk->setDbValue($rs->fields('dk'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// detail_id
		// jurnal_id
		// akun_id
		// nilai
		// anggota_id
		// dk
		// detail_id

		$this->detail_id->ViewValue = $this->detail_id->CurrentValue;
		$this->detail_id->ViewCustomAttributes = "";

		// jurnal_id
		$this->jurnal_id->ViewValue = $this->jurnal_id->CurrentValue;
		$this->jurnal_id->ViewCustomAttributes = "";

		// akun_id
		if ($this->akun_id->VirtualValue <> "") {
			$this->akun_id->ViewValue = $this->akun_id->VirtualValue;
		} else {
			$this->akun_id->ViewValue = $this->akun_id->CurrentValue;
		if (strval($this->akun_id->CurrentValue) <> "") {
			$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akun_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
		$sWhereWrk = "";
		$this->akun_id->LookupFilters = array("dx1" => '`no_nama_akun`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun_id->ViewValue = $this->akun_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun_id->ViewValue = $this->akun_id->CurrentValue;
			}
		} else {
			$this->akun_id->ViewValue = NULL;
		}
		}
		$this->akun_id->ViewCustomAttributes = "";

		// nilai
		$this->nilai->ViewValue = $this->nilai->CurrentValue;
		$this->nilai->ViewValue = ew_FormatNumber($this->nilai->ViewValue, 0, -2, -2, -1);
		$this->nilai->CellCssStyle .= "text-align: right;";
		$this->nilai->ViewCustomAttributes = "";

		// anggota_id
		if ($this->anggota_id->VirtualValue <> "") {
			$this->anggota_id->ViewValue = $this->anggota_id->VirtualValue;
		} else {
			$this->anggota_id->ViewValue = $this->anggota_id->CurrentValue;
		if (strval($this->anggota_id->CurrentValue) <> "") {
			$sFilterWrk = "`anggota_id`" . ew_SearchString("=", $this->anggota_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `anggota_id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tb_anggota`";
		$sWhereWrk = "";
		$this->anggota_id->LookupFilters = array("dx1" => '`nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->anggota_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->anggota_id->ViewValue = $this->anggota_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->anggota_id->ViewValue = $this->anggota_id->CurrentValue;
			}
		} else {
			$this->anggota_id->ViewValue = NULL;
		}
		}
		$this->anggota_id->ViewCustomAttributes = "";

		// dk
		$this->dk->ViewValue = $this->dk->CurrentValue;
		$this->dk->ViewCustomAttributes = "";

		// detail_id
		$this->detail_id->LinkCustomAttributes = "";
		$this->detail_id->HrefValue = "";
		$this->detail_id->TooltipValue = "";

		// jurnal_id
		$this->jurnal_id->LinkCustomAttributes = "";
		$this->jurnal_id->HrefValue = "";
		$this->jurnal_id->TooltipValue = "";

		// akun_id
		$this->akun_id->LinkCustomAttributes = "";
		$this->akun_id->HrefValue = "";
		$this->akun_id->TooltipValue = "";

		// nilai
		$this->nilai->LinkCustomAttributes = "";
		$this->nilai->HrefValue = "";
		$this->nilai->TooltipValue = "";

		// anggota_id
		$this->anggota_id->LinkCustomAttributes = "";
		$this->anggota_id->HrefValue = "";
		$this->anggota_id->TooltipValue = "";

		// dk
		$this->dk->LinkCustomAttributes = "";
		$this->dk->HrefValue = "";
		$this->dk->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// detail_id
		$this->detail_id->EditAttrs["class"] = "form-control";
		$this->detail_id->EditCustomAttributes = "";
		$this->detail_id->EditValue = $this->detail_id->CurrentValue;
		$this->detail_id->ViewCustomAttributes = "";

		// jurnal_id
		$this->jurnal_id->EditAttrs["class"] = "form-control";
		$this->jurnal_id->EditCustomAttributes = "";
		if ($this->jurnal_id->getSessionValue() <> "") {
			$this->jurnal_id->CurrentValue = $this->jurnal_id->getSessionValue();
		$this->jurnal_id->ViewValue = $this->jurnal_id->CurrentValue;
		$this->jurnal_id->ViewCustomAttributes = "";
		} else {
		$this->jurnal_id->EditValue = $this->jurnal_id->CurrentValue;
		$this->jurnal_id->PlaceHolder = ew_RemoveHtml($this->jurnal_id->FldCaption());
		}

		// akun_id
		$this->akun_id->EditAttrs["class"] = "form-control";
		$this->akun_id->EditCustomAttributes = "";
		$this->akun_id->EditValue = $this->akun_id->CurrentValue;
		$this->akun_id->PlaceHolder = ew_RemoveHtml($this->akun_id->FldCaption());

		// nilai
		$this->nilai->EditAttrs["class"] = "form-control";
		$this->nilai->EditCustomAttributes = "";
		$this->nilai->EditValue = $this->nilai->CurrentValue;
		$this->nilai->PlaceHolder = ew_RemoveHtml($this->nilai->FldCaption());

		// anggota_id
		$this->anggota_id->EditAttrs["class"] = "form-control";
		$this->anggota_id->EditCustomAttributes = "";
		$this->anggota_id->EditValue = $this->anggota_id->CurrentValue;
		$this->anggota_id->PlaceHolder = ew_RemoveHtml($this->anggota_id->FldCaption());

		// dk
		$this->dk->EditAttrs["class"] = "form-control";
		$this->dk->EditCustomAttributes = "";
		$this->dk->EditValue = $this->dk->CurrentValue;
		$this->dk->PlaceHolder = ew_RemoveHtml($this->dk->FldCaption());

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
					if ($this->akun_id->Exportable) $Doc->ExportCaption($this->akun_id);
					if ($this->nilai->Exportable) $Doc->ExportCaption($this->nilai);
					if ($this->anggota_id->Exportable) $Doc->ExportCaption($this->anggota_id);
				} else {
					if ($this->detail_id->Exportable) $Doc->ExportCaption($this->detail_id);
					if ($this->jurnal_id->Exportable) $Doc->ExportCaption($this->jurnal_id);
					if ($this->akun_id->Exportable) $Doc->ExportCaption($this->akun_id);
					if ($this->nilai->Exportable) $Doc->ExportCaption($this->nilai);
					if ($this->anggota_id->Exportable) $Doc->ExportCaption($this->anggota_id);
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
						if ($this->akun_id->Exportable) $Doc->ExportField($this->akun_id);
						if ($this->nilai->Exportable) $Doc->ExportField($this->nilai);
						if ($this->anggota_id->Exportable) $Doc->ExportField($this->anggota_id);
					} else {
						if ($this->detail_id->Exportable) $Doc->ExportField($this->detail_id);
						if ($this->jurnal_id->Exportable) $Doc->ExportField($this->jurnal_id);
						if ($this->akun_id->Exportable) $Doc->ExportField($this->akun_id);
						if ($this->nilai->Exportable) $Doc->ExportField($this->nilai);
						if ($this->anggota_id->Exportable) $Doc->ExportField($this->anggota_id);
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
		//$total_nilai = ew_ExecuteScalar("select sum(nilai) ");

		$jenis_jurnal = ew_ExecuteScalar("select jenis_jurnal from tb_jurnal where jurnal_id = ".$rsnew["jurnal_id"]."");
		if ($jenis_jurnal == "M") {
			$dk = 1;
			$dk_lawan = 0;
		}
		else {
			$dk = 0;
			$dk_lawan = 1;
		}
		ew_Execute("update tb_detail set dk = ".$dk." where jurnal_id = ".$rsnew["jurnal_id"]."");
		$total_lawan = ew_ExecuteScalar("select sum(nilai) from tb_detail where jurnal_id = ".$rsnew["jurnal_id"]."");
		ew_Execute("update tb_jurnal set nilai = ".$total_lawan." where jurnal_id = ".$rsnew["jurnal_id"]."");
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
		//$total_nilai = ew_ExecuteScalar("select sum(nilai) ");

		$jenis_jurnal = ew_ExecuteScalar("select jenis_jurnal from tb_jurnal where jurnal_id = ".$rsold["jurnal_id"]."");
		if ($jenis_jurnal == "M") {
			$dk = 1;
			$dk_lawan = 0;
		}
		else {
			$dk = 0;
			$dk_lawan = 1;
		}
		ew_Execute("update tb_detail set dk = ".$dk." where jurnal_id = ".$rsold["jurnal_id"]."");
		$total_lawan = ew_ExecuteScalar("select sum(nilai) from tb_detail where jurnal_id = ".$rsold["jurnal_id"]."");
		ew_Execute("update tb_jurnal set nilai = ".$total_lawan." where jurnal_id = ".$rsold["jurnal_id"]."");
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
		$row_count = ew_ExecuteScalar("select count(nilai) from tb_detail where jurnal_id = ".$rs["jurnal_id"]."");
		if ($row_count > 0) {
			$total_lawan = ew_ExecuteScalar("select sum(nilai) from tb_detail where jurnal_id = ".$rs["jurnal_id"]."");
			ew_Execute("update tb_jurnal set nilai = ".$total_lawan." where jurnal_id = ".$rs["jurnal_id"]."");
		}
		else {
			ew_Execute("update tb_jurnal set nilai = 0 where jurnal_id = ".$rs["jurnal_id"]."");
		}
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

		$this->nilai->EditAttrs["onchange"] = "myfunction.call(this, ".$this->RowIndex.");";
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
