<?php

// Global variable for table object
$tb_detailm = NULL;

//
// Table class for tb_detailm
//
class ctb_detailm extends cTable {
	var $detailm_id;
	var $jurnalm_id;
	var $akunm_id;
	var $nilaim_debet;
	var $nilaim_kredit;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tb_detailm';
		$this->TableName = 'tb_detailm';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tb_detailm`";
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

		// detailm_id
		$this->detailm_id = new cField('tb_detailm', 'tb_detailm', 'x_detailm_id', 'detailm_id', '`detailm_id`', '`detailm_id`', 3, -1, FALSE, '`detailm_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->detailm_id->Sortable = TRUE; // Allow sort
		$this->detailm_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['detailm_id'] = &$this->detailm_id;

		// jurnalm_id
		$this->jurnalm_id = new cField('tb_detailm', 'tb_detailm', 'x_jurnalm_id', 'jurnalm_id', '`jurnalm_id`', '`jurnalm_id`', 3, -1, FALSE, '`jurnalm_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jurnalm_id->Sortable = TRUE; // Allow sort
		$this->jurnalm_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jurnalm_id'] = &$this->jurnalm_id;

		// akunm_id
		$this->akunm_id = new cField('tb_detailm', 'tb_detailm', 'x_akunm_id', 'akunm_id', '`akunm_id`', '`akunm_id`', 3, -1, FALSE, '`EV__akunm_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'TEXT');
		$this->akunm_id->Sortable = TRUE; // Allow sort
		$this->akunm_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['akunm_id'] = &$this->akunm_id;

		// nilaim_debet
		$this->nilaim_debet = new cField('tb_detailm', 'tb_detailm', 'x_nilaim_debet', 'nilaim_debet', '`nilaim_debet`', '`nilaim_debet`', 20, -1, FALSE, '`nilaim_debet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nilaim_debet->Sortable = TRUE; // Allow sort
		$this->nilaim_debet->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['nilaim_debet'] = &$this->nilaim_debet;

		// nilaim_kredit
		$this->nilaim_kredit = new cField('tb_detailm', 'tb_detailm', 'x_nilaim_kredit', 'nilaim_kredit', '`nilaim_kredit`', '`nilaim_kredit`', 20, -1, FALSE, '`nilaim_kredit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nilaim_kredit->Sortable = TRUE; // Allow sort
		$this->nilaim_kredit->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['nilaim_kredit'] = &$this->nilaim_kredit;
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
		if ($this->getCurrentMasterTable() == "tb_jurnalm") {
			if ($this->jurnalm_id->getSessionValue() <> "")
				$sMasterFilter .= "`jurnalm_id`=" . ew_QuotedValue($this->jurnalm_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "tb_jurnalm") {
			if ($this->jurnalm_id->getSessionValue() <> "")
				$sDetailFilter .= "`jurnalm_id`=" . ew_QuotedValue($this->jurnalm_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_tb_jurnalm() {
		return "`jurnalm_id`=@jurnalm_id@";
	}

	// Detail filter
	function SqlDetailFilter_tb_jurnalm() {
		return "`jurnalm_id`=@jurnalm_id@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tb_detailm`";
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
			"SELECT *, (SELECT `no_nama_akun` FROM `view_akun_jurnal` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`level4_id` = `tb_detailm`.`akunm_id` LIMIT 1) AS `EV__akunm_id` FROM `tb_detailm`" .
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
		if ($this->akunm_id->AdvancedSearch->SearchValue <> "" ||
			$this->akunm_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->akunm_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->akunm_id->FldVirtualExpression . " ") !== FALSE)
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
			if (array_key_exists('detailm_id', $rs))
				ew_AddFilter($where, ew_QuotedName('detailm_id', $this->DBID) . '=' . ew_QuotedValue($rs['detailm_id'], $this->detailm_id->FldDataType, $this->DBID));
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
		return "`detailm_id` = @detailm_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->detailm_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@detailm_id@", ew_AdjustSql($this->detailm_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "tb_detailmlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tb_detailmlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tb_detailmview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tb_detailmview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tb_detailmadd.php?" . $this->UrlParm($parm);
		else
			$url = "tb_detailmadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tb_detailmedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tb_detailmadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tb_detailmdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "tb_jurnalm" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_jurnalm_id=" . urlencode($this->jurnalm_id->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "detailm_id:" . ew_VarToJson($this->detailm_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->detailm_id->CurrentValue)) {
			$sUrl .= "detailm_id=" . urlencode($this->detailm_id->CurrentValue);
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
			if ($isPost && isset($_POST["detailm_id"]))
				$arKeys[] = ew_StripSlashes($_POST["detailm_id"]);
			elseif (isset($_GET["detailm_id"]))
				$arKeys[] = ew_StripSlashes($_GET["detailm_id"]);
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
			$this->detailm_id->CurrentValue = $key;
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
		$this->detailm_id->setDbValue($rs->fields('detailm_id'));
		$this->jurnalm_id->setDbValue($rs->fields('jurnalm_id'));
		$this->akunm_id->setDbValue($rs->fields('akunm_id'));
		$this->nilaim_debet->setDbValue($rs->fields('nilaim_debet'));
		$this->nilaim_kredit->setDbValue($rs->fields('nilaim_kredit'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// detailm_id
		// jurnalm_id
		// akunm_id
		// nilaim_debet
		// nilaim_kredit
		// detailm_id

		$this->detailm_id->ViewValue = $this->detailm_id->CurrentValue;
		$this->detailm_id->ViewCustomAttributes = "";

		// jurnalm_id
		$this->jurnalm_id->ViewValue = $this->jurnalm_id->CurrentValue;
		$this->jurnalm_id->ViewCustomAttributes = "";

		// akunm_id
		if ($this->akunm_id->VirtualValue <> "") {
			$this->akunm_id->ViewValue = $this->akunm_id->VirtualValue;
		} else {
			$this->akunm_id->ViewValue = $this->akunm_id->CurrentValue;
		if (strval($this->akunm_id->CurrentValue) <> "") {
			$sFilterWrk = "`level4_id`" . ew_SearchString("=", $this->akunm_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `level4_id`, `no_nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `view_akun_jurnal`";
		$sWhereWrk = "";
		$this->akunm_id->LookupFilters = array("dx1" => '`no_nama_akun`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akunm_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akunm_id->ViewValue = $this->akunm_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akunm_id->ViewValue = $this->akunm_id->CurrentValue;
			}
		} else {
			$this->akunm_id->ViewValue = NULL;
		}
		}
		$this->akunm_id->ViewCustomAttributes = "";

		// nilaim_debet
		$this->nilaim_debet->ViewValue = $this->nilaim_debet->CurrentValue;
		$this->nilaim_debet->ViewValue = ew_FormatNumber($this->nilaim_debet->ViewValue, 0, -2, -2, -1);
		$this->nilaim_debet->CellCssStyle .= "text-align: right;";
		$this->nilaim_debet->ViewCustomAttributes = "";

		// nilaim_kredit
		$this->nilaim_kredit->ViewValue = $this->nilaim_kredit->CurrentValue;
		$this->nilaim_kredit->ViewValue = ew_FormatNumber($this->nilaim_kredit->ViewValue, 0, -2, -2, -1);
		$this->nilaim_kredit->CellCssStyle .= "text-align: right;";
		$this->nilaim_kredit->ViewCustomAttributes = "";

		// detailm_id
		$this->detailm_id->LinkCustomAttributes = "";
		$this->detailm_id->HrefValue = "";
		$this->detailm_id->TooltipValue = "";

		// jurnalm_id
		$this->jurnalm_id->LinkCustomAttributes = "";
		$this->jurnalm_id->HrefValue = "";
		$this->jurnalm_id->TooltipValue = "";

		// akunm_id
		$this->akunm_id->LinkCustomAttributes = "";
		$this->akunm_id->HrefValue = "";
		$this->akunm_id->TooltipValue = "";

		// nilaim_debet
		$this->nilaim_debet->LinkCustomAttributes = "";
		$this->nilaim_debet->HrefValue = "";
		$this->nilaim_debet->TooltipValue = "";

		// nilaim_kredit
		$this->nilaim_kredit->LinkCustomAttributes = "";
		$this->nilaim_kredit->HrefValue = "";
		$this->nilaim_kredit->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// detailm_id
		$this->detailm_id->EditAttrs["class"] = "form-control";
		$this->detailm_id->EditCustomAttributes = "";
		$this->detailm_id->EditValue = $this->detailm_id->CurrentValue;
		$this->detailm_id->ViewCustomAttributes = "";

		// jurnalm_id
		$this->jurnalm_id->EditAttrs["class"] = "form-control";
		$this->jurnalm_id->EditCustomAttributes = "";
		if ($this->jurnalm_id->getSessionValue() <> "") {
			$this->jurnalm_id->CurrentValue = $this->jurnalm_id->getSessionValue();
		$this->jurnalm_id->ViewValue = $this->jurnalm_id->CurrentValue;
		$this->jurnalm_id->ViewCustomAttributes = "";
		} else {
		$this->jurnalm_id->EditValue = $this->jurnalm_id->CurrentValue;
		$this->jurnalm_id->PlaceHolder = ew_RemoveHtml($this->jurnalm_id->FldCaption());
		}

		// akunm_id
		$this->akunm_id->EditAttrs["class"] = "form-control";
		$this->akunm_id->EditCustomAttributes = "";
		$this->akunm_id->EditValue = $this->akunm_id->CurrentValue;
		$this->akunm_id->PlaceHolder = ew_RemoveHtml($this->akunm_id->FldCaption());

		// nilaim_debet
		$this->nilaim_debet->EditAttrs["class"] = "form-control";
		$this->nilaim_debet->EditCustomAttributes = "";
		$this->nilaim_debet->EditValue = $this->nilaim_debet->CurrentValue;
		$this->nilaim_debet->PlaceHolder = ew_RemoveHtml($this->nilaim_debet->FldCaption());

		// nilaim_kredit
		$this->nilaim_kredit->EditAttrs["class"] = "form-control";
		$this->nilaim_kredit->EditCustomAttributes = "";
		$this->nilaim_kredit->EditValue = $this->nilaim_kredit->CurrentValue;
		$this->nilaim_kredit->PlaceHolder = ew_RemoveHtml($this->nilaim_kredit->FldCaption());

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
					if ($this->akunm_id->Exportable) $Doc->ExportCaption($this->akunm_id);
					if ($this->nilaim_debet->Exportable) $Doc->ExportCaption($this->nilaim_debet);
					if ($this->nilaim_kredit->Exportable) $Doc->ExportCaption($this->nilaim_kredit);
				} else {
					if ($this->detailm_id->Exportable) $Doc->ExportCaption($this->detailm_id);
					if ($this->jurnalm_id->Exportable) $Doc->ExportCaption($this->jurnalm_id);
					if ($this->akunm_id->Exportable) $Doc->ExportCaption($this->akunm_id);
					if ($this->nilaim_debet->Exportable) $Doc->ExportCaption($this->nilaim_debet);
					if ($this->nilaim_kredit->Exportable) $Doc->ExportCaption($this->nilaim_kredit);
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
						if ($this->akunm_id->Exportable) $Doc->ExportField($this->akunm_id);
						if ($this->nilaim_debet->Exportable) $Doc->ExportField($this->nilaim_debet);
						if ($this->nilaim_kredit->Exportable) $Doc->ExportField($this->nilaim_kredit);
					} else {
						if ($this->detailm_id->Exportable) $Doc->ExportField($this->detailm_id);
						if ($this->jurnalm_id->Exportable) $Doc->ExportField($this->jurnalm_id);
						if ($this->akunm_id->Exportable) $Doc->ExportField($this->akunm_id);
						if ($this->nilaim_debet->Exportable) $Doc->ExportField($this->nilaim_debet);
						if ($this->nilaim_kredit->Exportable) $Doc->ExportField($this->nilaim_kredit);
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

		$this->nilaim_debet->EditAttrs["onchange"] = "debet_onchange(event);";
		$this->nilaim_debet->EditAttrs["onfocus"] = "debet_onfocus(event);";
		$this->nilaim_kredit->EditAttrs["onchange"] = "kredit_onchange(event);";
		$this->nilaim_kredit->EditAttrs["onfocus"] = "kredit_onfocus(event);";
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
