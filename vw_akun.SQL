SELECT 
  concat(tb_level1.level1_no, '.', tb_level2.level2_no, '.', tb_level3.level3_no, '.', tb_level4.level4_no) as kode_akun,
  tb_level4.level4_nama AS nama_akun
FROM ((tb_level4
  JOIN tb_level1 ON tb_level4.level1_id = tb_level1.level1_id)
  JOIN tb_level2 ON tb_level4.level2_id = tb_level2.level2_id)
  JOIN tb_level3 ON tb_level4.level3_id = tb_level3.level3_id
