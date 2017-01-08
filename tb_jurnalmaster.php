<?php

// akun_id
// jenis_jurnal
// no_bukti
// tgl
// ket
// nilai

?>
<?php if ($tb_jurnal->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $tb_jurnal->TableCaption() ?></h4> -->
<table id="tbl_tb_jurnalmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $tb_jurnal->TableCustomInnerHtml ?>
	<tbody>
<?php if ($tb_jurnal->akun_id->Visible) { // akun_id ?>
		<tr id="r_akun_id">
			<td><?php echo $tb_jurnal->akun_id->FldCaption() ?></td>
			<td<?php echo $tb_jurnal->akun_id->CellAttributes() ?>>
<span id="el_tb_jurnal_akun_id">
<span<?php echo $tb_jurnal->akun_id->ViewAttributes() ?>>
<?php echo $tb_jurnal->akun_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_jurnal->jenis_jurnal->Visible) { // jenis_jurnal ?>
		<tr id="r_jenis_jurnal">
			<td><?php echo $tb_jurnal->jenis_jurnal->FldCaption() ?></td>
			<td<?php echo $tb_jurnal->jenis_jurnal->CellAttributes() ?>>
<span id="el_tb_jurnal_jenis_jurnal">
<span<?php echo $tb_jurnal->jenis_jurnal->ViewAttributes() ?>>
<?php echo $tb_jurnal->jenis_jurnal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_jurnal->no_bukti->Visible) { // no_bukti ?>
		<tr id="r_no_bukti">
			<td><?php echo $tb_jurnal->no_bukti->FldCaption() ?></td>
			<td<?php echo $tb_jurnal->no_bukti->CellAttributes() ?>>
<span id="el_tb_jurnal_no_bukti">
<span<?php echo $tb_jurnal->no_bukti->ViewAttributes() ?>>
<?php echo $tb_jurnal->no_bukti->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_jurnal->tgl->Visible) { // tgl ?>
		<tr id="r_tgl">
			<td><?php echo $tb_jurnal->tgl->FldCaption() ?></td>
			<td<?php echo $tb_jurnal->tgl->CellAttributes() ?>>
<span id="el_tb_jurnal_tgl">
<span<?php echo $tb_jurnal->tgl->ViewAttributes() ?>>
<?php echo $tb_jurnal->tgl->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_jurnal->ket->Visible) { // ket ?>
		<tr id="r_ket">
			<td><?php echo $tb_jurnal->ket->FldCaption() ?></td>
			<td<?php echo $tb_jurnal->ket->CellAttributes() ?>>
<span id="el_tb_jurnal_ket">
<span<?php echo $tb_jurnal->ket->ViewAttributes() ?>>
<?php echo $tb_jurnal->ket->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tb_jurnal->nilai->Visible) { // nilai ?>
		<tr id="r_nilai">
			<td><?php echo $tb_jurnal->nilai->FldCaption() ?></td>
			<td<?php echo $tb_jurnal->nilai->CellAttributes() ?>>
<span id="el_tb_jurnal_nilai">
<span<?php echo $tb_jurnal->nilai->ViewAttributes() ?>>
<?php echo $tb_jurnal->nilai->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
