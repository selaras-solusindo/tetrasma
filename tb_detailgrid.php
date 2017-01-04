<?php include_once "tb_userinfo.php" ?>
<?php

// Create page object
if (!isset($tb_detail_grid)) $tb_detail_grid = new ctb_detail_grid();

// Page init
$tb_detail_grid->Page_Init();

// Page main
$tb_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tb_detail_grid->Page_Render();
?>
<?php if ($tb_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftb_detailgrid = new ew_Form("ftb_detailgrid", "grid");
ftb_detailgrid.FormKeyCountName = '<?php echo $tb_detail_grid->FormKeyCountName ?>';

// Validate form
ftb_detailgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_jurnal_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->jurnal_id->FldCaption(), $tb_detail->jurnal_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jurnal_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detail->jurnal_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_item");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->item->FldCaption(), $tb_detail->item->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_item");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detail->item->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_akun_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->akun_id->FldCaption(), $tb_detail->akun_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->debet->FldCaption(), $tb_detail->debet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debet");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detail->debet->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kredit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->kredit->FldCaption(), $tb_detail->kredit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kredit");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detail->kredit->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftb_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "jurnal_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "item", false)) return false;
	if (ew_ValueChanged(fobj, infix, "akun_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "debet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kredit", false)) return false;
	if (ew_ValueChanged(fobj, infix, "anggota_id", false)) return false;
	return true;
}

// Form_CustomValidate event
ftb_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftb_detailgrid.ValidateRequired = true;
<?php } else { ?>
ftb_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftb_detailgrid.Lists["x_akun_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_level4_no","x_level4_nama","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_level4"};
ftb_detailgrid.Lists["x_anggota_id"] = {"LinkField":"x_anggota_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tb_anggota"};

// Form object for search
</script>
<?php } ?>
<?php
if ($tb_detail->CurrentAction == "gridadd") {
	if ($tb_detail->CurrentMode == "copy") {
		$bSelectLimit = $tb_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$tb_detail_grid->TotalRecs = $tb_detail->SelectRecordCount();
			$tb_detail_grid->Recordset = $tb_detail_grid->LoadRecordset($tb_detail_grid->StartRec-1, $tb_detail_grid->DisplayRecs);
		} else {
			if ($tb_detail_grid->Recordset = $tb_detail_grid->LoadRecordset())
				$tb_detail_grid->TotalRecs = $tb_detail_grid->Recordset->RecordCount();
		}
		$tb_detail_grid->StartRec = 1;
		$tb_detail_grid->DisplayRecs = $tb_detail_grid->TotalRecs;
	} else {
		$tb_detail->CurrentFilter = "0=1";
		$tb_detail_grid->StartRec = 1;
		$tb_detail_grid->DisplayRecs = $tb_detail->GridAddRowCount;
	}
	$tb_detail_grid->TotalRecs = $tb_detail_grid->DisplayRecs;
	$tb_detail_grid->StopRec = $tb_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $tb_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tb_detail_grid->TotalRecs <= 0)
			$tb_detail_grid->TotalRecs = $tb_detail->SelectRecordCount();
	} else {
		if (!$tb_detail_grid->Recordset && ($tb_detail_grid->Recordset = $tb_detail_grid->LoadRecordset()))
			$tb_detail_grid->TotalRecs = $tb_detail_grid->Recordset->RecordCount();
	}
	$tb_detail_grid->StartRec = 1;
	$tb_detail_grid->DisplayRecs = $tb_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tb_detail_grid->Recordset = $tb_detail_grid->LoadRecordset($tb_detail_grid->StartRec-1, $tb_detail_grid->DisplayRecs);

	// Set no record found message
	if ($tb_detail->CurrentAction == "" && $tb_detail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$tb_detail_grid->setWarningMessage(ew_DeniedMsg());
		if ($tb_detail_grid->SearchWhere == "0=101")
			$tb_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tb_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tb_detail_grid->RenderOtherOptions();
?>
<?php $tb_detail_grid->ShowPageHeader(); ?>
<?php
$tb_detail_grid->ShowMessage();
?>
<?php if ($tb_detail_grid->TotalRecs > 0 || $tb_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid tb_detail">
<div id="ftb_detailgrid" class="ewForm form-inline">
<div id="gmp_tb_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_tb_detailgrid" class="table ewTable">
<?php echo $tb_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$tb_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tb_detail_grid->RenderListOptions();

// Render list options (header, left)
$tb_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($tb_detail->detail_id->Visible) { // detail_id ?>
	<?php if ($tb_detail->SortUrl($tb_detail->detail_id) == "") { ?>
		<th data-name="detail_id"><div id="elh_tb_detail_detail_id" class="tb_detail_detail_id"><div class="ewTableHeaderCaption"><?php echo $tb_detail->detail_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="detail_id"><div><div id="elh_tb_detail_detail_id" class="tb_detail_detail_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->detail_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->detail_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->detail_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detail->jurnal_id->Visible) { // jurnal_id ?>
	<?php if ($tb_detail->SortUrl($tb_detail->jurnal_id) == "") { ?>
		<th data-name="jurnal_id"><div id="elh_tb_detail_jurnal_id" class="tb_detail_jurnal_id"><div class="ewTableHeaderCaption"><?php echo $tb_detail->jurnal_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jurnal_id"><div><div id="elh_tb_detail_jurnal_id" class="tb_detail_jurnal_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->jurnal_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->jurnal_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->jurnal_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detail->item->Visible) { // item ?>
	<?php if ($tb_detail->SortUrl($tb_detail->item) == "") { ?>
		<th data-name="item"><div id="elh_tb_detail_item" class="tb_detail_item"><div class="ewTableHeaderCaption"><?php echo $tb_detail->item->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="item"><div><div id="elh_tb_detail_item" class="tb_detail_item">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->item->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->item->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->item->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detail->akun_id->Visible) { // akun_id ?>
	<?php if ($tb_detail->SortUrl($tb_detail->akun_id) == "") { ?>
		<th data-name="akun_id"><div id="elh_tb_detail_akun_id" class="tb_detail_akun_id"><div class="ewTableHeaderCaption"><?php echo $tb_detail->akun_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun_id"><div><div id="elh_tb_detail_akun_id" class="tb_detail_akun_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->akun_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->akun_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->akun_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detail->debet->Visible) { // debet ?>
	<?php if ($tb_detail->SortUrl($tb_detail->debet) == "") { ?>
		<th data-name="debet"><div id="elh_tb_detail_debet" class="tb_detail_debet"><div class="ewTableHeaderCaption"><?php echo $tb_detail->debet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="debet"><div><div id="elh_tb_detail_debet" class="tb_detail_debet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->debet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->debet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->debet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detail->kredit->Visible) { // kredit ?>
	<?php if ($tb_detail->SortUrl($tb_detail->kredit) == "") { ?>
		<th data-name="kredit"><div id="elh_tb_detail_kredit" class="tb_detail_kredit"><div class="ewTableHeaderCaption"><?php echo $tb_detail->kredit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kredit"><div><div id="elh_tb_detail_kredit" class="tb_detail_kredit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->kredit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->kredit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->kredit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detail->anggota_id->Visible) { // anggota_id ?>
	<?php if ($tb_detail->SortUrl($tb_detail->anggota_id) == "") { ?>
		<th data-name="anggota_id"><div id="elh_tb_detail_anggota_id" class="tb_detail_anggota_id"><div class="ewTableHeaderCaption"><?php echo $tb_detail->anggota_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="anggota_id"><div><div id="elh_tb_detail_anggota_id" class="tb_detail_anggota_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->anggota_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->anggota_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->anggota_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tb_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tb_detail_grid->StartRec = 1;
$tb_detail_grid->StopRec = $tb_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tb_detail_grid->FormKeyCountName) && ($tb_detail->CurrentAction == "gridadd" || $tb_detail->CurrentAction == "gridedit" || $tb_detail->CurrentAction == "F")) {
		$tb_detail_grid->KeyCount = $objForm->GetValue($tb_detail_grid->FormKeyCountName);
		$tb_detail_grid->StopRec = $tb_detail_grid->StartRec + $tb_detail_grid->KeyCount - 1;
	}
}
$tb_detail_grid->RecCnt = $tb_detail_grid->StartRec - 1;
if ($tb_detail_grid->Recordset && !$tb_detail_grid->Recordset->EOF) {
	$tb_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $tb_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $tb_detail_grid->StartRec > 1)
		$tb_detail_grid->Recordset->Move($tb_detail_grid->StartRec - 1);
} elseif (!$tb_detail->AllowAddDeleteRow && $tb_detail_grid->StopRec == 0) {
	$tb_detail_grid->StopRec = $tb_detail->GridAddRowCount;
}

// Initialize aggregate
$tb_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tb_detail->ResetAttrs();
$tb_detail_grid->RenderRow();
if ($tb_detail->CurrentAction == "gridadd")
	$tb_detail_grid->RowIndex = 0;
if ($tb_detail->CurrentAction == "gridedit")
	$tb_detail_grid->RowIndex = 0;
while ($tb_detail_grid->RecCnt < $tb_detail_grid->StopRec) {
	$tb_detail_grid->RecCnt++;
	if (intval($tb_detail_grid->RecCnt) >= intval($tb_detail_grid->StartRec)) {
		$tb_detail_grid->RowCnt++;
		if ($tb_detail->CurrentAction == "gridadd" || $tb_detail->CurrentAction == "gridedit" || $tb_detail->CurrentAction == "F") {
			$tb_detail_grid->RowIndex++;
			$objForm->Index = $tb_detail_grid->RowIndex;
			if ($objForm->HasValue($tb_detail_grid->FormActionName))
				$tb_detail_grid->RowAction = strval($objForm->GetValue($tb_detail_grid->FormActionName));
			elseif ($tb_detail->CurrentAction == "gridadd")
				$tb_detail_grid->RowAction = "insert";
			else
				$tb_detail_grid->RowAction = "";
		}

		// Set up key count
		$tb_detail_grid->KeyCount = $tb_detail_grid->RowIndex;

		// Init row class and style
		$tb_detail->ResetAttrs();
		$tb_detail->CssClass = "";
		if ($tb_detail->CurrentAction == "gridadd") {
			if ($tb_detail->CurrentMode == "copy") {
				$tb_detail_grid->LoadRowValues($tb_detail_grid->Recordset); // Load row values
				$tb_detail_grid->SetRecordKey($tb_detail_grid->RowOldKey, $tb_detail_grid->Recordset); // Set old record key
			} else {
				$tb_detail_grid->LoadDefaultValues(); // Load default values
				$tb_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tb_detail_grid->LoadRowValues($tb_detail_grid->Recordset); // Load row values
		}
		$tb_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tb_detail->CurrentAction == "gridadd") // Grid add
			$tb_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tb_detail->CurrentAction == "gridadd" && $tb_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tb_detail_grid->RestoreCurrentRowFormValues($tb_detail_grid->RowIndex); // Restore form values
		if ($tb_detail->CurrentAction == "gridedit") { // Grid edit
			if ($tb_detail->EventCancelled) {
				$tb_detail_grid->RestoreCurrentRowFormValues($tb_detail_grid->RowIndex); // Restore form values
			}
			if ($tb_detail_grid->RowAction == "insert")
				$tb_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tb_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tb_detail->CurrentAction == "gridedit" && ($tb_detail->RowType == EW_ROWTYPE_EDIT || $tb_detail->RowType == EW_ROWTYPE_ADD) && $tb_detail->EventCancelled) // Update failed
			$tb_detail_grid->RestoreCurrentRowFormValues($tb_detail_grid->RowIndex); // Restore form values
		if ($tb_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tb_detail_grid->EditRowCnt++;
		if ($tb_detail->CurrentAction == "F") // Confirm row
			$tb_detail_grid->RestoreCurrentRowFormValues($tb_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tb_detail->RowAttrs = array_merge($tb_detail->RowAttrs, array('data-rowindex'=>$tb_detail_grid->RowCnt, 'id'=>'r' . $tb_detail_grid->RowCnt . '_tb_detail', 'data-rowtype'=>$tb_detail->RowType));

		// Render row
		$tb_detail_grid->RenderRow();

		// Render list options
		$tb_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tb_detail_grid->RowAction <> "delete" && $tb_detail_grid->RowAction <> "insertdelete" && !($tb_detail_grid->RowAction == "insert" && $tb_detail->CurrentAction == "F" && $tb_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $tb_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_detail_grid->ListOptions->Render("body", "left", $tb_detail_grid->RowCnt);
?>
	<?php if ($tb_detail->detail_id->Visible) { // detail_id ?>
		<td data-name="detail_id"<?php echo $tb_detail->detail_id->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_detail_id" class="form-group tb_detail_detail_id">
<span<?php echo $tb_detail->detail_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->detail_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->CurrentValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_detail_id" class="tb_detail_detail_id">
<span<?php echo $tb_detail->detail_id->ViewAttributes() ?>>
<?php echo $tb_detail->detail_id->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tb_detail_grid->PageObjName . "_row_" . $tb_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tb_detail->jurnal_id->Visible) { // jurnal_id ?>
		<td data-name="jurnal_id"<?php echo $tb_detail->jurnal_id->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tb_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_jurnal_id" class="form-group tb_detail_jurnal_id">
<span<?php echo $tb_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_jurnal_id" class="form-group tb_detail_jurnal_id">
<input type="text" data-table="tb_detail" data-field="x_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $tb_detail->jurnal_id->EditValue ?>"<?php echo $tb_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_jurnal_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($tb_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_jurnal_id" class="form-group tb_detail_jurnal_id">
<span<?php echo $tb_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_jurnal_id" class="form-group tb_detail_jurnal_id">
<input type="text" data-table="tb_detail" data-field="x_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $tb_detail->jurnal_id->EditValue ?>"<?php echo $tb_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_jurnal_id" class="tb_detail_jurnal_id">
<span<?php echo $tb_detail->jurnal_id->ViewAttributes() ?>>
<?php echo $tb_detail->jurnal_id->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_jurnal_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_detail->item->Visible) { // item ?>
		<td data-name="item"<?php echo $tb_detail->item->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_item" class="form-group tb_detail_item">
<input type="text" data-table="tb_detail" data-field="x_item" name="x<?php echo $tb_detail_grid->RowIndex ?>_item" id="x<?php echo $tb_detail_grid->RowIndex ?>_item" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->item->getPlaceHolder()) ?>" value="<?php echo $tb_detail->item->EditValue ?>"<?php echo $tb_detail->item->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_item" name="o<?php echo $tb_detail_grid->RowIndex ?>_item" id="o<?php echo $tb_detail_grid->RowIndex ?>_item" value="<?php echo ew_HtmlEncode($tb_detail->item->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_item" class="form-group tb_detail_item">
<input type="text" data-table="tb_detail" data-field="x_item" name="x<?php echo $tb_detail_grid->RowIndex ?>_item" id="x<?php echo $tb_detail_grid->RowIndex ?>_item" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->item->getPlaceHolder()) ?>" value="<?php echo $tb_detail->item->EditValue ?>"<?php echo $tb_detail->item->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_item" class="tb_detail_item">
<span<?php echo $tb_detail->item->ViewAttributes() ?>>
<?php echo $tb_detail->item->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_item" name="x<?php echo $tb_detail_grid->RowIndex ?>_item" id="x<?php echo $tb_detail_grid->RowIndex ?>_item" value="<?php echo ew_HtmlEncode($tb_detail->item->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_item" name="o<?php echo $tb_detail_grid->RowIndex ?>_item" id="o<?php echo $tb_detail_grid->RowIndex ?>_item" value="<?php echo ew_HtmlEncode($tb_detail->item->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_detail->akun_id->Visible) { // akun_id ?>
		<td data-name="akun_id"<?php echo $tb_detail->akun_id->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_akun_id" class="form-group tb_detail_akun_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id"><?php echo (strval($tb_detail->akun_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_detail->akun_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_akun_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->CurrentValue ?>"<?php echo $tb_detail->akun_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_akun_id" class="form-group tb_detail_akun_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id"><?php echo (strval($tb_detail->akun_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_detail->akun_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_akun_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->CurrentValue ?>"<?php echo $tb_detail->akun_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_akun_id" class="tb_detail_akun_id">
<span<?php echo $tb_detail->akun_id->ViewAttributes() ?>>
<?php echo $tb_detail->akun_id->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_detail->debet->Visible) { // debet ?>
		<td data-name="debet"<?php echo $tb_detail->debet->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_debet" class="form-group tb_detail_debet">
<input type="text" data-table="tb_detail" data-field="x_debet" name="x<?php echo $tb_detail_grid->RowIndex ?>_debet" id="x<?php echo $tb_detail_grid->RowIndex ?>_debet" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->debet->getPlaceHolder()) ?>" value="<?php echo $tb_detail->debet->EditValue ?>"<?php echo $tb_detail->debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_debet" name="o<?php echo $tb_detail_grid->RowIndex ?>_debet" id="o<?php echo $tb_detail_grid->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($tb_detail->debet->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_debet" class="form-group tb_detail_debet">
<input type="text" data-table="tb_detail" data-field="x_debet" name="x<?php echo $tb_detail_grid->RowIndex ?>_debet" id="x<?php echo $tb_detail_grid->RowIndex ?>_debet" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->debet->getPlaceHolder()) ?>" value="<?php echo $tb_detail->debet->EditValue ?>"<?php echo $tb_detail->debet->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_debet" class="tb_detail_debet">
<span<?php echo $tb_detail->debet->ViewAttributes() ?>>
<?php echo $tb_detail->debet->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_debet" name="x<?php echo $tb_detail_grid->RowIndex ?>_debet" id="x<?php echo $tb_detail_grid->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($tb_detail->debet->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_debet" name="o<?php echo $tb_detail_grid->RowIndex ?>_debet" id="o<?php echo $tb_detail_grid->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($tb_detail->debet->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_detail->kredit->Visible) { // kredit ?>
		<td data-name="kredit"<?php echo $tb_detail->kredit->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_kredit" class="form-group tb_detail_kredit">
<input type="text" data-table="tb_detail" data-field="x_kredit" name="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $tb_detail->kredit->EditValue ?>"<?php echo $tb_detail->kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_kredit" name="o<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="o<?php echo $tb_detail_grid->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($tb_detail->kredit->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_kredit" class="form-group tb_detail_kredit">
<input type="text" data-table="tb_detail" data-field="x_kredit" name="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $tb_detail->kredit->EditValue ?>"<?php echo $tb_detail->kredit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_kredit" class="tb_detail_kredit">
<span<?php echo $tb_detail->kredit->ViewAttributes() ?>>
<?php echo $tb_detail->kredit->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_kredit" name="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($tb_detail->kredit->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_kredit" name="o<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="o<?php echo $tb_detail_grid->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($tb_detail->kredit->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id"<?php echo $tb_detail->anggota_id->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_anggota_id" class="form-group tb_detail_anggota_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id"><?php echo (strval($tb_detail->anggota_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_detail->anggota_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->CurrentValue ?>"<?php echo $tb_detail->anggota_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_anggota_id" class="form-group tb_detail_anggota_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id"><?php echo (strval($tb_detail->anggota_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_detail->anggota_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->CurrentValue ?>"<?php echo $tb_detail->anggota_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_anggota_id" class="tb_detail_anggota_id">
<span<?php echo $tb_detail->anggota_id->ViewAttributes() ?>>
<?php echo $tb_detail->anggota_id->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_detail_grid->ListOptions->Render("body", "right", $tb_detail_grid->RowCnt);
?>
	</tr>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD || $tb_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftb_detailgrid.UpdateOpts(<?php echo $tb_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tb_detail->CurrentAction <> "gridadd" || $tb_detail->CurrentMode == "copy")
		if (!$tb_detail_grid->Recordset->EOF) $tb_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tb_detail->CurrentMode == "add" || $tb_detail->CurrentMode == "copy" || $tb_detail->CurrentMode == "edit") {
		$tb_detail_grid->RowIndex = '$rowindex$';
		$tb_detail_grid->LoadDefaultValues();

		// Set row properties
		$tb_detail->ResetAttrs();
		$tb_detail->RowAttrs = array_merge($tb_detail->RowAttrs, array('data-rowindex'=>$tb_detail_grid->RowIndex, 'id'=>'r0_tb_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tb_detail->RowAttrs["class"], "ewTemplate");
		$tb_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tb_detail_grid->RenderRow();

		// Render list options
		$tb_detail_grid->RenderListOptions();
		$tb_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tb_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tb_detail_grid->ListOptions->Render("body", "left", $tb_detail_grid->RowIndex);
?>
	<?php if ($tb_detail->detail_id->Visible) { // detail_id ?>
		<td data-name="detail_id">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_detail_id" class="form-group tb_detail_detail_id">
<span<?php echo $tb_detail->detail_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->detail_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detail->jurnal_id->Visible) { // jurnal_id ?>
		<td data-name="jurnal_id">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<?php if ($tb_detail->jurnal_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_tb_detail_jurnal_id" class="form-group tb_detail_jurnal_id">
<span<?php echo $tb_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_tb_detail_jurnal_id" class="form-group tb_detail_jurnal_id">
<input type="text" data-table="tb_detail" data-field="x_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->getPlaceHolder()) ?>" value="<?php echo $tb_detail->jurnal_id->EditValue ?>"<?php echo $tb_detail->jurnal_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_jurnal_id" class="form-group tb_detail_jurnal_id">
<span<?php echo $tb_detail->jurnal_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->jurnal_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_jurnal_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_jurnal_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_jurnal_id" value="<?php echo ew_HtmlEncode($tb_detail->jurnal_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detail->item->Visible) { // item ?>
		<td data-name="item">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_item" class="form-group tb_detail_item">
<input type="text" data-table="tb_detail" data-field="x_item" name="x<?php echo $tb_detail_grid->RowIndex ?>_item" id="x<?php echo $tb_detail_grid->RowIndex ?>_item" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->item->getPlaceHolder()) ?>" value="<?php echo $tb_detail->item->EditValue ?>"<?php echo $tb_detail->item->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_item" class="form-group tb_detail_item">
<span<?php echo $tb_detail->item->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->item->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_item" name="x<?php echo $tb_detail_grid->RowIndex ?>_item" id="x<?php echo $tb_detail_grid->RowIndex ?>_item" value="<?php echo ew_HtmlEncode($tb_detail->item->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_item" name="o<?php echo $tb_detail_grid->RowIndex ?>_item" id="o<?php echo $tb_detail_grid->RowIndex ?>_item" value="<?php echo ew_HtmlEncode($tb_detail->item->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detail->akun_id->Visible) { // akun_id ?>
		<td data-name="akun_id">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_akun_id" class="form-group tb_detail_akun_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id"><?php echo (strval($tb_detail->akun_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_detail->akun_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_akun_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->CurrentValue ?>"<?php echo $tb_detail->akun_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_akun_id" class="form-group tb_detail_akun_id">
<span<?php echo $tb_detail->akun_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->akun_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detail->debet->Visible) { // debet ?>
		<td data-name="debet">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_debet" class="form-group tb_detail_debet">
<input type="text" data-table="tb_detail" data-field="x_debet" name="x<?php echo $tb_detail_grid->RowIndex ?>_debet" id="x<?php echo $tb_detail_grid->RowIndex ?>_debet" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->debet->getPlaceHolder()) ?>" value="<?php echo $tb_detail->debet->EditValue ?>"<?php echo $tb_detail->debet->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_debet" class="form-group tb_detail_debet">
<span<?php echo $tb_detail->debet->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->debet->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_debet" name="x<?php echo $tb_detail_grid->RowIndex ?>_debet" id="x<?php echo $tb_detail_grid->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($tb_detail->debet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_debet" name="o<?php echo $tb_detail_grid->RowIndex ?>_debet" id="o<?php echo $tb_detail_grid->RowIndex ?>_debet" value="<?php echo ew_HtmlEncode($tb_detail->debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detail->kredit->Visible) { // kredit ?>
		<td data-name="kredit">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_kredit" class="form-group tb_detail_kredit">
<input type="text" data-table="tb_detail" data-field="x_kredit" name="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->kredit->getPlaceHolder()) ?>" value="<?php echo $tb_detail->kredit->EditValue ?>"<?php echo $tb_detail->kredit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_kredit" class="form-group tb_detail_kredit">
<span<?php echo $tb_detail->kredit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->kredit->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_kredit" name="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="x<?php echo $tb_detail_grid->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($tb_detail->kredit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_kredit" name="o<?php echo $tb_detail_grid->RowIndex ?>_kredit" id="o<?php echo $tb_detail_grid->RowIndex ?>_kredit" value="<?php echo ew_HtmlEncode($tb_detail->kredit->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_anggota_id" class="form-group tb_detail_anggota_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id"><?php echo (strval($tb_detail->anggota_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $tb_detail->anggota_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->CurrentValue ?>"<?php echo $tb_detail->anggota_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_anggota_id" class="form-group tb_detail_anggota_id">
<span<?php echo $tb_detail->anggota_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->anggota_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tb_detail_grid->ListOptions->Render("body", "right", $tb_detail_grid->RowCnt);
?>
<script type="text/javascript">
ftb_detailgrid.UpdateOpts(<?php echo $tb_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tb_detail->CurrentMode == "add" || $tb_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tb_detail_grid->FormKeyCountName ?>" id="<?php echo $tb_detail_grid->FormKeyCountName ?>" value="<?php echo $tb_detail_grid->KeyCount ?>">
<?php echo $tb_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tb_detail_grid->FormKeyCountName ?>" id="<?php echo $tb_detail_grid->FormKeyCountName ?>" value="<?php echo $tb_detail_grid->KeyCount ?>">
<?php echo $tb_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tb_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftb_detailgrid">
</div>
<?php

// Close recordset
if ($tb_detail_grid->Recordset)
	$tb_detail_grid->Recordset->Close();
?>
<?php if ($tb_detail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($tb_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($tb_detail_grid->TotalRecs == 0 && $tb_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tb_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tb_detail->Export == "") { ?>
<script type="text/javascript">
ftb_detailgrid.Init();
</script>
<?php } ?>
<?php
$tb_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tb_detail_grid->Page_Terminate();
?>
