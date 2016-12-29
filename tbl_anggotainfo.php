<?php

// Global variable for table object
$tbl_anggota = NULL;

//
// Table class for tbl_anggota
//
class ctbl_anggota extends cTable {
	var $anggota_id;
	var $no_anggota;
	var $nama;
	var $tgl_masuk;
	var $alamat;
	var $kota;
	var $no_telp;
	var $pekerjaan;
	var $jns_pengenal;
	var $no_pengenal;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_anggota';
		$this->TableName = 'tbl_anggota';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tbl_anggota`";
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

		// anggota_id
		$this->anggota_id = new cField('tbl_anggota', 'tbl_anggota', 'x_anggota_id', 'anggota_id', '`anggota_id`', '`anggota_id`', 3, -1, FALSE, '`anggota_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->anggota_id->Sortable = TRUE; // Allow sort
		$this->anggota_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['anggota_id'] = &$this->anggota_id;

		// no_anggota
		$this->no_anggota = new cField('tbl_anggota', 'tbl_anggota', 'x_no_anggota', 'no_anggota', '`no_anggota`', '`no_anggota`', 200, -1, FALSE, '`no_anggota`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_anggota->Sortable = TRUE; // Allow sort
		$this->fields['no_anggota'] = &$this->no_anggota;

		// nama
		$this->nama = new cField('tbl_anggota', 'tbl_anggota', 'x_nama', 'nama', '`nama`', '`nama`', 200, -1, FALSE, '`nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama->Sortable = TRUE; // Allow sort
		$this->fields['nama'] = &$this->nama;

		// tgl_masuk
		$this->tgl_masuk = new cField('tbl_anggota', 'tbl_anggota', 'x_tgl_masuk', 'tgl_masuk', '`tgl_masuk`', 'DATE_FORMAT(`tgl_masuk`, \'%Y/%m/%d\')', 133, 0, FALSE, '`tgl_masuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_masuk->Sortable = TRUE; // Allow sort
		$this->tgl_masuk->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_masuk'] = &$this->tgl_masuk;

		// alamat
		$this->alamat = new cField('tbl_anggota', 'tbl_anggota', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, -1, FALSE, '`alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alamat->Sortable = TRUE; // Allow sort
		$this->fields['alamat'] = &$this->alamat;

		// kota
		$this->kota = new cField('tbl_anggota', 'tbl_anggota', 'x_kota', 'kota', '`kota`', '`kota`', 200, -1, FALSE, '`kota`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kota->Sortable = TRUE; // Allow sort
		$this->fields['kota'] = &$this->kota;

		// no_telp
		$this->no_telp = new cField('tbl_anggota', 'tbl_anggota', 'x_no_telp', 'no_telp', '`no_telp`', '`no_telp`', 200, -1, FALSE, '`no_telp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_telp->Sortable = TRUE; // Allow sort
		$this->fields['no_telp'] = &$this->no_telp;

		// pekerjaan
		$this->pekerjaan = new cField('tbl_anggota', 'tbl_anggota', 'x_pekerjaan', 'pekerjaan', '`pekerjaan`', '`pekerjaan`', 200, -1, FALSE, '`pekerjaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pekerjaan->Sortable = TRUE; // Allow sort
		$this->fields['pekerjaan'] = &$this->pekerjaan;

		// jns_pengenal
		$this->jns_pengenal = new cField('tbl_anggota', 'tbl_anggota', 'x_jns_pengenal', 'jns_pengenal', '`jns_pengenal`', '`jns_pengenal`', 200, -1, FALSE, '`jns_pengenal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jns_pengenal->Sortable = TRUE; // Allow sort
		$this->fields['jns_pengenal'] = &$this->jns_pengenal;

		// no_pengenal
		$this->no_pengenal = new cField('tbl_anggota', 'tbl_anggota', 'x_no_pengenal', 'no_pengenal', '`no_pengenal`', '`no_pengenal`', 200, -1, FALSE, '`no_pengenal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_pengenal->Sortable = TRUE; // Allow sort
		$this->fields['no_pengenal'] = &$this->no_pengenal;
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
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tbl_anggota`";
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
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
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
			if (array_key_exists('anggota_id', $rs))
				ew_AddFilter($where, ew_QuotedName('anggota_id', $this->DBID) . '=' . ew_QuotedValue($rs['anggota_id'], $this->anggota_id->FldDataType, $this->DBID));
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
		return "`anggota_id` = @anggota_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->anggota_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@anggota_id@", ew_AdjustSql($this->anggota_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "tbl_anggotalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_anggotalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tbl_anggotaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tbl_anggotaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tbl_anggotaadd.php?" . $this->UrlParm($parm);
		else
			$url = "tbl_anggotaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tbl_anggotaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tbl_anggotaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_anggotadelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "anggota_id:" . ew_VarToJson($this->anggota_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->anggota_id->CurrentValue)) {
			$sUrl .= "anggota_id=" . urlencode($this->anggota_id->CurrentValue);
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
			if ($isPost && isset($_POST["anggota_id"]))
				$arKeys[] = ew_StripSlashes($_POST["anggota_id"]);
			elseif (isset($_GET["anggota_id"]))
				$arKeys[] = ew_StripSlashes($_GET["anggota_id"]);
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
			$this->anggota_id->CurrentValue = $key;
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
		$this->anggota_id->setDbValue($rs->fields('anggota_id'));
		$this->no_anggota->setDbValue($rs->fields('no_anggota'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->tgl_masuk->setDbValue($rs->fields('tgl_masuk'));
		$this->alamat->setDbValue($rs->fields('alamat'));
		$this->kota->setDbValue($rs->fields('kota'));
		$this->no_telp->setDbValue($rs->fields('no_telp'));
		$this->pekerjaan->setDbValue($rs->fields('pekerjaan'));
		$this->jns_pengenal->setDbValue($rs->fields('jns_pengenal'));
		$this->no_pengenal->setDbValue($rs->fields('no_pengenal'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// anggota_id
		// no_anggota
		// nama
		// tgl_masuk
		// alamat
		// kota
		// no_telp
		// pekerjaan
		// jns_pengenal
		// no_pengenal
		// anggota_id

		$this->anggota_id->ViewValue = $this->anggota_id->CurrentValue;
		$this->anggota_id->ViewCustomAttributes = "";

		// no_anggota
		$this->no_anggota->ViewValue = $this->no_anggota->CurrentValue;
		$this->no_anggota->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// tgl_masuk
		$this->tgl_masuk->ViewValue = $this->tgl_masuk->CurrentValue;
		$this->tgl_masuk->ViewValue = ew_FormatDateTime($this->tgl_masuk->ViewValue, 0);
		$this->tgl_masuk->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// kota
		$this->kota->ViewValue = $this->kota->CurrentValue;
		$this->kota->ViewCustomAttributes = "";

		// no_telp
		$this->no_telp->ViewValue = $this->no_telp->CurrentValue;
		$this->no_telp->ViewCustomAttributes = "";

		// pekerjaan
		$this->pekerjaan->ViewValue = $this->pekerjaan->CurrentValue;
		$this->pekerjaan->ViewCustomAttributes = "";

		// jns_pengenal
		$this->jns_pengenal->ViewValue = $this->jns_pengenal->CurrentValue;
		$this->jns_pengenal->ViewCustomAttributes = "";

		// no_pengenal
		$this->no_pengenal->ViewValue = $this->no_pengenal->CurrentValue;
		$this->no_pengenal->ViewCustomAttributes = "";

		// anggota_id
		$this->anggota_id->LinkCustomAttributes = "";
		$this->anggota_id->HrefValue = "";
		$this->anggota_id->TooltipValue = "";

		// no_anggota
		$this->no_anggota->LinkCustomAttributes = "";
		$this->no_anggota->HrefValue = "";
		$this->no_anggota->TooltipValue = "";

		// nama
		$this->nama->LinkCustomAttributes = "";
		$this->nama->HrefValue = "";
		$this->nama->TooltipValue = "";

		// tgl_masuk
		$this->tgl_masuk->LinkCustomAttributes = "";
		$this->tgl_masuk->HrefValue = "";
		$this->tgl_masuk->TooltipValue = "";

		// alamat
		$this->alamat->LinkCustomAttributes = "";
		$this->alamat->HrefValue = "";
		$this->alamat->TooltipValue = "";

		// kota
		$this->kota->LinkCustomAttributes = "";
		$this->kota->HrefValue = "";
		$this->kota->TooltipValue = "";

		// no_telp
		$this->no_telp->LinkCustomAttributes = "";
		$this->no_telp->HrefValue = "";
		$this->no_telp->TooltipValue = "";

		// pekerjaan
		$this->pekerjaan->LinkCustomAttributes = "";
		$this->pekerjaan->HrefValue = "";
		$this->pekerjaan->TooltipValue = "";

		// jns_pengenal
		$this->jns_pengenal->LinkCustomAttributes = "";
		$this->jns_pengenal->HrefValue = "";
		$this->jns_pengenal->TooltipValue = "";

		// no_pengenal
		$this->no_pengenal->LinkCustomAttributes = "";
		$this->no_pengenal->HrefValue = "";
		$this->no_pengenal->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// anggota_id
		$this->anggota_id->EditAttrs["class"] = "form-control";
		$this->anggota_id->EditCustomAttributes = "";
		$this->anggota_id->EditValue = $this->anggota_id->CurrentValue;
		$this->anggota_id->ViewCustomAttributes = "";

		// no_anggota
		$this->no_anggota->EditAttrs["class"] = "form-control";
		$this->no_anggota->EditCustomAttributes = "";
		$this->no_anggota->EditValue = $this->no_anggota->CurrentValue;
		$this->no_anggota->PlaceHolder = ew_RemoveHtml($this->no_anggota->FldCaption());

		// nama
		$this->nama->EditAttrs["class"] = "form-control";
		$this->nama->EditCustomAttributes = "";
		$this->nama->EditValue = $this->nama->CurrentValue;
		$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

		// tgl_masuk
		$this->tgl_masuk->EditAttrs["class"] = "form-control";
		$this->tgl_masuk->EditCustomAttributes = "";
		$this->tgl_masuk->EditValue = ew_FormatDateTime($this->tgl_masuk->CurrentValue, 8);
		$this->tgl_masuk->PlaceHolder = ew_RemoveHtml($this->tgl_masuk->FldCaption());

		// alamat
		$this->alamat->EditAttrs["class"] = "form-control";
		$this->alamat->EditCustomAttributes = "";
		$this->alamat->EditValue = $this->alamat->CurrentValue;
		$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

		// kota
		$this->kota->EditAttrs["class"] = "form-control";
		$this->kota->EditCustomAttributes = "";
		$this->kota->EditValue = $this->kota->CurrentValue;
		$this->kota->PlaceHolder = ew_RemoveHtml($this->kota->FldCaption());

		// no_telp
		$this->no_telp->EditAttrs["class"] = "form-control";
		$this->no_telp->EditCustomAttributes = "";
		$this->no_telp->EditValue = $this->no_telp->CurrentValue;
		$this->no_telp->PlaceHolder = ew_RemoveHtml($this->no_telp->FldCaption());

		// pekerjaan
		$this->pekerjaan->EditAttrs["class"] = "form-control";
		$this->pekerjaan->EditCustomAttributes = "";
		$this->pekerjaan->EditValue = $this->pekerjaan->CurrentValue;
		$this->pekerjaan->PlaceHolder = ew_RemoveHtml($this->pekerjaan->FldCaption());

		// jns_pengenal
		$this->jns_pengenal->EditAttrs["class"] = "form-control";
		$this->jns_pengenal->EditCustomAttributes = "";
		$this->jns_pengenal->EditValue = $this->jns_pengenal->CurrentValue;
		$this->jns_pengenal->PlaceHolder = ew_RemoveHtml($this->jns_pengenal->FldCaption());

		// no_pengenal
		$this->no_pengenal->EditAttrs["class"] = "form-control";
		$this->no_pengenal->EditCustomAttributes = "";
		$this->no_pengenal->EditValue = $this->no_pengenal->CurrentValue;
		$this->no_pengenal->PlaceHolder = ew_RemoveHtml($this->no_pengenal->FldCaption());

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
					if ($this->no_anggota->Exportable) $Doc->ExportCaption($this->no_anggota);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->tgl_masuk->Exportable) $Doc->ExportCaption($this->tgl_masuk);
					if ($this->alamat->Exportable) $Doc->ExportCaption($this->alamat);
					if ($this->kota->Exportable) $Doc->ExportCaption($this->kota);
					if ($this->no_telp->Exportable) $Doc->ExportCaption($this->no_telp);
					if ($this->pekerjaan->Exportable) $Doc->ExportCaption($this->pekerjaan);
					if ($this->jns_pengenal->Exportable) $Doc->ExportCaption($this->jns_pengenal);
					if ($this->no_pengenal->Exportable) $Doc->ExportCaption($this->no_pengenal);
				} else {
					if ($this->no_anggota->Exportable) $Doc->ExportCaption($this->no_anggota);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->tgl_masuk->Exportable) $Doc->ExportCaption($this->tgl_masuk);
					if ($this->alamat->Exportable) $Doc->ExportCaption($this->alamat);
					if ($this->kota->Exportable) $Doc->ExportCaption($this->kota);
					if ($this->no_telp->Exportable) $Doc->ExportCaption($this->no_telp);
					if ($this->pekerjaan->Exportable) $Doc->ExportCaption($this->pekerjaan);
					if ($this->jns_pengenal->Exportable) $Doc->ExportCaption($this->jns_pengenal);
					if ($this->no_pengenal->Exportable) $Doc->ExportCaption($this->no_pengenal);
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
						if ($this->no_anggota->Exportable) $Doc->ExportField($this->no_anggota);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->tgl_masuk->Exportable) $Doc->ExportField($this->tgl_masuk);
						if ($this->alamat->Exportable) $Doc->ExportField($this->alamat);
						if ($this->kota->Exportable) $Doc->ExportField($this->kota);
						if ($this->no_telp->Exportable) $Doc->ExportField($this->no_telp);
						if ($this->pekerjaan->Exportable) $Doc->ExportField($this->pekerjaan);
						if ($this->jns_pengenal->Exportable) $Doc->ExportField($this->jns_pengenal);
						if ($this->no_pengenal->Exportable) $Doc->ExportField($this->no_pengenal);
					} else {
						if ($this->no_anggota->Exportable) $Doc->ExportField($this->no_anggota);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->tgl_masuk->Exportable) $Doc->ExportField($this->tgl_masuk);
						if ($this->alamat->Exportable) $Doc->ExportField($this->alamat);
						if ($this->kota->Exportable) $Doc->ExportField($this->kota);
						if ($this->no_telp->Exportable) $Doc->ExportField($this->no_telp);
						if ($this->pekerjaan->Exportable) $Doc->ExportField($this->pekerjaan);
						if ($this->jns_pengenal->Exportable) $Doc->ExportField($this->jns_pengenal);
						if ($this->no_pengenal->Exportable) $Doc->ExportField($this->no_pengenal);
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
