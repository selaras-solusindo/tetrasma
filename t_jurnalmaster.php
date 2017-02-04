<?php

// akun_id
// jenis_jurnal
// no_bukti
// tgl
// ket
// nilai

?>
<?php if ($t_jurnal->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_jurnal->TableCaption() ?></h4> -->
<table id="tbl_t_jurnalmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t_jurnal->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_jurnal->akun_id->Visible) { // akun_id ?>
		<tr id="r_akun_id">
			<td><?php echo $t_jurnal->akun_id->FldCaption() ?></td>
			<td<?php echo $t_jurnal->akun_id->CellAttributes() ?>>
<span id="el_t_jurnal_akun_id">
<span<?php echo $t_jurnal->akun_id->ViewAttributes() ?>>
<?php echo $t_jurnal->akun_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnal->jenis_jurnal->Visible) { // jenis_jurnal ?>
		<tr id="r_jenis_jurnal">
			<td><?php echo $t_jurnal->jenis_jurnal->FldCaption() ?></td>
			<td<?php echo $t_jurnal->jenis_jurnal->CellAttributes() ?>>
<span id="el_t_jurnal_jenis_jurnal">
<span<?php echo $t_jurnal->jenis_jurnal->ViewAttributes() ?>>
<?php echo $t_jurnal->jenis_jurnal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnal->no_bukti->Visible) { // no_bukti ?>
		<tr id="r_no_bukti">
			<td><?php echo $t_jurnal->no_bukti->FldCaption() ?></td>
			<td<?php echo $t_jurnal->no_bukti->CellAttributes() ?>>
<span id="el_t_jurnal_no_bukti">
<span<?php echo $t_jurnal->no_bukti->ViewAttributes() ?>>
<?php echo $t_jurnal->no_bukti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnal->tgl->Visible) { // tgl ?>
		<tr id="r_tgl">
			<td><?php echo $t_jurnal->tgl->FldCaption() ?></td>
			<td<?php echo $t_jurnal->tgl->CellAttributes() ?>>
<span id="el_t_jurnal_tgl">
<span<?php echo $t_jurnal->tgl->ViewAttributes() ?>>
<?php echo $t_jurnal->tgl->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnal->ket->Visible) { // ket ?>
		<tr id="r_ket">
			<td><?php echo $t_jurnal->ket->FldCaption() ?></td>
			<td<?php echo $t_jurnal->ket->CellAttributes() ?>>
<span id="el_t_jurnal_ket">
<span<?php echo $t_jurnal->ket->ViewAttributes() ?>>
<?php echo $t_jurnal->ket->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_jurnal->nilai->Visible) { // nilai ?>
		<tr id="r_nilai">
			<td><?php echo $t_jurnal->nilai->FldCaption() ?></td>
			<td<?php echo $t_jurnal->nilai->CellAttributes() ?>>
<span id="el_t_jurnal_nilai">
<span<?php echo $t_jurnal->nilai->ViewAttributes() ?>>
<?php echo $t_jurnal->nilai->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
