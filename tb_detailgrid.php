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
			elm = this.GetElements("x" + infix + "_akun_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->akun_id->FldCaption(), $tb_detail->akun_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tb_detail->nilai->FldCaption(), $tb_detail->nilai->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tb_detail->nilai->FldErrMsg()) ?>");

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
	if (ew_ValueChanged(fobj, infix, "akun_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nilai", false)) return false;
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
ftb_detailgrid.Lists["x_akun_id"] = {"LinkField":"x_level4_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"view_akun_jurnal"};
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
<?php if ($tb_detail->akun_id->Visible) { // akun_id ?>
	<?php if ($tb_detail->SortUrl($tb_detail->akun_id) == "") { ?>
		<th data-name="akun_id"><div id="elh_tb_detail_akun_id" class="tb_detail_akun_id"><div class="ewTableHeaderCaption"><?php echo $tb_detail->akun_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun_id"><div><div id="elh_tb_detail_akun_id" class="tb_detail_akun_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->akun_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->akun_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->akun_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tb_detail->nilai->Visible) { // nilai ?>
	<?php if ($tb_detail->SortUrl($tb_detail->nilai) == "") { ?>
		<th data-name="nilai"><div id="elh_tb_detail_nilai" class="tb_detail_nilai"><div class="ewTableHeaderCaption"><?php echo $tb_detail->nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilai"><div><div id="elh_tb_detail_nilai" class="tb_detail_nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tb_detail->nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tb_detail->nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tb_detail->nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	<?php if ($tb_detail->akun_id->Visible) { // akun_id ?>
		<td data-name="akun_id"<?php echo $tb_detail->akun_id->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_akun_id" class="form-group tb_detail_akun_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->akun_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->akun_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="sv_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>"<?php echo $tb_detail->akun_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="q_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detail_grid->RowIndex ?>_akun_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_akun_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(false) ?>">
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_akun_id" class="form-group tb_detail_akun_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->akun_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->akun_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="sv_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>"<?php echo $tb_detail->akun_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="q_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detail_grid->RowIndex ?>_akun_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_akun_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(false) ?>">
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_akun_id" class="tb_detail_akun_id">
<span<?php echo $tb_detail->akun_id->ViewAttributes() ?>>
<?php echo $tb_detail->akun_id->ListViewValue() ?></span>
</span>
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="ftb_detailgrid$x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="ftb_detailgrid$x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" name="ftb_detailgrid$o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="ftb_detailgrid$o<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $tb_detail_grid->PageObjName . "_row_" . $tb_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->CurrentValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT || $tb_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="tb_detail" data-field="x_detail_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_detail_id" value="<?php echo ew_HtmlEncode($tb_detail->detail_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($tb_detail->nilai->Visible) { // nilai ?>
		<td data-name="nilai"<?php echo $tb_detail->nilai->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_nilai" class="form-group tb_detail_nilai">
<input type="text" data-table="tb_detail" data-field="x_nilai" name="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->nilai->getPlaceHolder()) ?>" value="<?php echo $tb_detail->nilai->EditValue ?>"<?php echo $tb_detail->nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_nilai" name="o<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="o<?php echo $tb_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($tb_detail->nilai->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_nilai" class="form-group tb_detail_nilai">
<input type="text" data-table="tb_detail" data-field="x_nilai" name="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->nilai->getPlaceHolder()) ?>" value="<?php echo $tb_detail->nilai->EditValue ?>"<?php echo $tb_detail->nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_nilai" class="tb_detail_nilai">
<span<?php echo $tb_detail->nilai->ViewAttributes() ?>>
<?php echo $tb_detail->nilai->ListViewValue() ?></span>
</span>
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_detail" data-field="x_nilai" name="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($tb_detail->nilai->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_nilai" name="o<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="o<?php echo $tb_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($tb_detail->nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_detail" data-field="x_nilai" name="ftb_detailgrid$x<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="ftb_detailgrid$x<?php echo $tb_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($tb_detail->nilai->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_nilai" name="ftb_detailgrid$o<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="ftb_detailgrid$o<?php echo $tb_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($tb_detail->nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tb_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id"<?php echo $tb_detail->anggota_id->CellAttributes() ?>>
<?php if ($tb_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_anggota_id" class="form-group tb_detail_anggota_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->anggota_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->anggota_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="sv_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>"<?php echo $tb_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="q_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(false) ?>">
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->OldValue) ?>">
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_anggota_id" class="form-group tb_detail_anggota_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->anggota_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->anggota_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="sv_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>"<?php echo $tb_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="q_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(false) ?>">
</span>
<?php } ?>
<?php if ($tb_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tb_detail_grid->RowCnt ?>_tb_detail_anggota_id" class="tb_detail_anggota_id">
<span<?php echo $tb_detail->anggota_id->ViewAttributes() ?>>
<?php echo $tb_detail->anggota_id->ListViewValue() ?></span>
</span>
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="ftb_detailgrid$x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="ftb_detailgrid$x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->FormValue) ?>">
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" name="ftb_detailgrid$o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="ftb_detailgrid$o<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->OldValue) ?>">
<?php } ?>
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
	<?php if ($tb_detail->akun_id->Visible) { // akun_id ?>
		<td data-name="akun_id">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_akun_id" class="form-group tb_detail_akun_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->akun_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->akun_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="sv_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->akun_id->getPlaceHolder()) ?>"<?php echo $tb_detail->akun_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_akun_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->akun_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo ew_HtmlEncode($tb_detail->akun_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="q_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detail_grid->RowIndex ?>_akun_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->akun_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_akun_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_akun_id" value="<?php echo $tb_detail->akun_id->LookupFilterQuery(false) ?>">
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
	<?php if ($tb_detail->nilai->Visible) { // nilai ?>
		<td data-name="nilai">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_nilai" class="form-group tb_detail_nilai">
<input type="text" data-table="tb_detail" data-field="x_nilai" name="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->nilai->getPlaceHolder()) ?>" value="<?php echo $tb_detail->nilai->EditValue ?>"<?php echo $tb_detail->nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tb_detail_nilai" class="form-group tb_detail_nilai">
<span<?php echo $tb_detail->nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tb_detail->nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_nilai" name="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="x<?php echo $tb_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($tb_detail->nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tb_detail" data-field="x_nilai" name="o<?php echo $tb_detail_grid->RowIndex ?>_nilai" id="o<?php echo $tb_detail_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($tb_detail->nilai->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tb_detail->anggota_id->Visible) { // anggota_id ?>
		<td data-name="anggota_id">
<?php if ($tb_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tb_detail_anggota_id" class="form-group tb_detail_anggota_id">
<?php
$wrkonchange = trim(" " . @$tb_detail->anggota_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$tb_detail->anggota_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tb_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="sv_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($tb_detail->anggota_id->getPlaceHolder()) ?>"<?php echo $tb_detail->anggota_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tb_detail" data-field="x_anggota_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $tb_detail->anggota_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo ew_HtmlEncode($tb_detail->anggota_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="q_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ftb_detailgrid.CreateAutoSuggest({"id":"x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($tb_detail->anggota_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" id="s_x<?php echo $tb_detail_grid->RowIndex ?>_anggota_id" value="<?php echo $tb_detail->anggota_id->LookupFilterQuery(false) ?>">
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
