<?php

  function tampilkan_laporan_packing_po($po){
    global $koneksi;
  
    $query = "SELECT F.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W71', 1,0)) as size_w71,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W74', 1,0)) as size_w74,
    Sum(IF(C.size='W75', 1,0)) as size_w75,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W77', 1,0)) as size_w77,
    Sum(IF(C.size='W78', 1,0)) as size_w78,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W80', 1,0)) as size_w80,
    Sum(IF(C.size='W81', 1,0)) as size_w81,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W83', 1,0)) as size_w83,
    Sum(IF(C.size='W84', 1,0)) as size_w84,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W86', 1,0)) as size_w86,
    Sum(IF(C.size='W87', 1,0)) as size_w87,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W89', 1,0)) as size_w89,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton, G.kelompok_size
  From transaksi_packing A
   inner Join master_order B On A.orc=B.orc
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
    JOIN label E ON B.id_label=E.id_label
    JOIN po F ON B.id_po = F.id_po
    JOIN size G on C.size = G.size
  WHERE F.no_po = '$po' and A.kelompok != 'mix_style'
  Group By  A.no_karton, C.id_style,  b.orc
Order By b.orc, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
A.kode_barcode asc, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

function tampilkan_laporan_packing_orc($orc){
    global $koneksi;
  
    $query = "SELECT A.orc, F.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W71', 1,0)) as size_w71,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W74', 1,0)) as size_w74,
    Sum(IF(C.size='W75', 1,0)) as size_w75,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W77', 1,0)) as size_w77,
    Sum(IF(C.size='W78', 1,0)) as size_w78,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W80', 1,0)) as size_w80,
    Sum(IF(C.size='W81', 1,0)) as size_w81,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W83', 1,0)) as size_w83,
    Sum(IF(C.size='W84', 1,0)) as size_w84,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W86', 1,0)) as size_w86,
    Sum(IF(C.size='W87', 1,0)) as size_w87,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W89', 1,0)) as size_w89,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton,
  G.kelompok_size
  From transaksi_packing A
   inner Join master_order B On A.orc=B.orc
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
    JOIN label E ON B.id_label=E.id_label
    JOIN po F ON B.id_po = F.id_po
    JOIN size G ON C.size = G.size
  where B.orc = '$orc' and A.kelompok != 'mix_style'
  Group By  A.no_karton, C.id_style,  b.orc
Order By b.orc, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='8L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7', 1,0))>0,1,0)+
IF(Sum(IF(C.size='9', 1,0))>0,1,0)+IF(Sum(IF(C.size='11', 1,0))>0,1,0)+
IF(Sum(IF(C.size='13', 1,0))>0,1,0)+IF(Sum(IF(C.size='15', 1,0))>0,1,0)+
IF(Sum(IF(C.size='17', 1,0))>0,1,0)), 
A.kode_barcode asc, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_packing_orc_full(){
    global $koneksi;
  
    $query = "SELECT A.orc, F.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='0', 1,0)) as size_0,
    Sum(IF(C.size='1', 1,0)) as size_1,
    Sum(IF(C.size='2', 1,0)) as size_2,
    Sum(IF(C.size='3', 1,0)) as size_3,
    Sum(IF(C.size='4', 1,0)) as size_4,
    Sum(IF(C.size='5', 1,0)) as size_5,
    Sum(IF(C.size='6', 1,0)) as size_6,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='8', 1,0)) as size_8,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='10', 1,0)) as size_10,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='12', 1,0)) as size_12,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='14', 1,0)) as size_14,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='16', 1,0)) as size_16,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='18', 1,0)) as size_18,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W71', 1,0)) as size_w71,
    Sum(IF(C.size='W74', 1,0)) as size_w74,
    Sum(IF(C.size='W75', 1,0)) as size_w75,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W77', 1,0)) as size_w77,
    Sum(IF(C.size='W78', 1,0)) as size_w78,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W80', 1,0)) as size_w80,
    Sum(IF(C.size='W81', 1,0)) as size_w81,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W83', 1,0)) as size_w83,
    Sum(IF(C.size='W84', 1,0)) as size_w84,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W86', 1,0)) as size_w86,
    Sum(IF(C.size='W87', 1,0)) as size_w87,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W89', 1,0)) as size_w89,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton,
  G.kelompok_size
  From transaksi_packing A
   inner Join master_order B On A.orc=B.orc
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
    JOIN label E ON B.id_label=E.id_label
    JOIN po F ON B.id_po = F.id_po
    JOIN size G ON C.size = G.size
  where A.kelompok != 'mix_style'
  Group By  A.no_karton, C.id_style,  b.orc
Order By b.orc, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='8L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7', 1,0))>0,1,0)+
IF(Sum(IF(C.size='9', 1,0))>0,1,0)+IF(Sum(IF(C.size='11', 1,0))>0,1,0)+
IF(Sum(IF(C.size='13', 1,0))>0,1,0)+IF(Sum(IF(C.size='15', 1,0))>0,1,0)+
IF(Sum(IF(C.size='17', 1,0))>0,1,0)), 
A.kode_barcode asc, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_packing_orc_mix(){
    global $koneksi;
  
    $query = "SELECT A.orc, F.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
     Sum(IF(C.size='7', 1,0)) as size_7,
     Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W71', 1,0)) as size_w71,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W74', 1,0)) as size_w74,
    Sum(IF(C.size='W75', 1,0)) as size_w75,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W77', 1,0)) as size_w77,
    Sum(IF(C.size='W78', 1,0)) as size_w78,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W80', 1,0)) as size_w80,
    Sum(IF(C.size='W81', 1,0)) as size_w81,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W83', 1,0)) as size_w83,
    Sum(IF(C.size='W84', 1,0)) as size_w84,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W86', 1,0)) as size_w86,
    Sum(IF(C.size='W87', 1,0)) as size_w87,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W89', 1,0)) as size_w89,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton, G.kelompok_size
  From transaksi_packing A
   inner Join master_order B On A.orc=B.orc
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
    JOIN label E ON B.id_label=E.id_label
    JOIN po F ON B.id_po = F.id_po
    JOIN size G ON C.size = G.size
  where A.kelompok = 'mix_style'
  Group By  A.no_karton, C.id_style,  b.orc
  Order By A.no_karton, b.orc, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
  A.kode_barcode asc, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }



function tampilkan_laporan_packinglist($po, $style){
  global $koneksi;

  $query = "SELECT po.no_po, style.style, barang.warna, transaksi_packing.no_karton, transaksi_packing.tanggal,
         transaksi_packing.no_karton,        
                  SUM(IF(barang.size='SS',1,0)) AS size_ss,
                  SUM(IF(barang.size='S',1,0)) AS size_s,
                  SUM(IF(barang.size='M',1,0)) AS size_m,
                  SUM(IF(barang.size='L',1,0)) AS size_l,
                  SUM(IF(barang.size='LL',1,0)) AS size_ll,
                  SUM(IF(barang.size='3L',1,0)) AS size_3l,
                  SUM(IF(barang.size='4L',1,0)) AS size_4l,
                  SUM(IF(barang.size='5L',1,0)) AS size_5l,
                  SUM(IF(barang.size='6L',1,0)) AS size_6l,
                  SUM(IF(barang.size='7L',1,0)) AS size_7l,
                  COUNT(barang.size) AS jumlah_size ,
                  COUNT(DISTINCT transaksi_packing.no_karton) AS karton
                  FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
  join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style 
  where transaksi_packing.id_po = '$po' AND barang.id_style = '$style'
   group by transaksi_packing.no_karton, transaksi_packing.id_po 
   having COUNT(DISTINCT transaksi_packing.kode_barcode) < 2
   order by transaksi_packing.kode_barcode, transaksi_packing.tanggal, jumlah_size desc ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packinglist_mix($po, $style){
  global $koneksi;

  $query = "SELECT po.no_po, style.style, barang.warna, transaksi_packing.no_karton, transaksi_packing.tanggal,
         transaksi_packing.no_karton,        
                  SUM(IF(barang.size='SS',1,0)) AS size_ss,
                  SUM(IF(barang.size='S',1,0)) AS size_s,
                  SUM(IF(barang.size='M',1,0)) AS size_m,
                  SUM(IF(barang.size='L',1,0)) AS size_l,
                  SUM(IF(barang.size='LL',1,0)) AS size_ll,
                  SUM(IF(barang.size='3L',1,0)) AS size_3l,
                  SUM(IF(barang.size='4L',1,0)) AS size_4l,
                  SUM(IF(barang.size='5L',1,0)) AS size_5l,
                  SUM(IF(barang.size='6L',1,0)) AS size_6l,
                  SUM(IF(barang.size='7L',1,0)) AS size_7l,
                  COUNT(barang.size) AS jumlah_size ,
                  COUNT(DISTINCT transaksi_packing.no_karton) AS karton
                  FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
  join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style 
  where transaksi_packing.id_po = '$po' AND barang.id_style = '$style'
   group by transaksi_packing.no_karton, transaksi_packing.id_po 
   having COUNT(DISTINCT transaksi_packing.kode_barcode) > 1
   order by transaksi_packing.kode_barcode, transaksi_packing.tanggal, jumlah_size desc ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packinglist_tanggal($po, $style, $tgl_awal, $tgl_akhir){
  global $koneksi;

  $query = "SELECT po.no_po, style.style, barang.warna, transaksi_packing.no_karton, transaksi_packing.tanggal,       
                  SUM(IF(barang.size='SS',1,0)) AS size_ss,
                  SUM(IF(barang.size='S',1,0)) AS size_s,
                  SUM(IF(barang.size='M',1,0)) AS size_m,
                  SUM(IF(barang.size='L',1,0)) AS size_l,
                  SUM(IF(barang.size='LL',1,0)) AS size_ll,
                  SUM(IF(barang.size='3L',1,0)) AS size_3l,
                  SUM(IF(barang.size='4L',1,0)) AS size_4l,
                  SUM(IF(barang.size='5L',1,0)) AS size_5l,
                  SUM(IF(barang.size='6L',1,0)) AS size_6l,
                  SUM(IF(barang.size='7L',1,0)) AS size_7l,
                  COUNT(barang.size) AS jumlah_size ,
                  COUNT(DISTINCT transaksi_packing.no_karton) AS karton
                  FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
  join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style 
  where transaksi_packing.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' AND transaksi_packing.id_po = '$po' AND barang.id_style = '$style'
   group by transaksi_packing.no_karton, transaksi_packing.id_po 
   having COUNT(DISTINCT transaksi_packing.kode_barcode) < 2
   order by transaksi_packing.kode_barcode, transaksi_packing.tanggal, jumlah_size desc ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packinglist_tanggal_mix($po, $style, $tgl_awal, $tgl_akhir){
  global $koneksi;

  $query = "SELECT po.no_po, style.style, barang.warna, transaksi_packing.no_karton, transaksi_packing.tanggal,
         transaksi_packing.no_karton,        
                  SUM(IF(barang.size='SS',1,0)) AS size_ss,
                  SUM(IF(barang.size='S',1,0)) AS size_s,
                  SUM(IF(barang.size='M',1,0)) AS size_m,
                  SUM(IF(barang.size='L',1,0)) AS size_l,
                  SUM(IF(barang.size='LL',1,0)) AS size_ll,
                  SUM(IF(barang.size='3L',1,0)) AS size_3l,
                  SUM(IF(barang.size='4L',1,0)) AS size_4l,
                  SUM(IF(barang.size='5L',1,0)) AS size_5l,
                  SUM(IF(barang.size='6L',1,0)) AS size_6l,
                  SUM(IF(barang.size='7L',1,0)) AS size_7l,
                  COUNT(barang.size) AS jumlah_size ,
                  COUNT(DISTINCT transaksi_packing.no_karton) AS karton
                  FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
  join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style 
  where transaksi_packing.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' AND transaksi_packing.id_po = '$po' AND barang.id_style = '$style'
   group by transaksi_packing.no_karton, transaksi_packing.id_po 
   having COUNT(DISTINCT transaksi_packing.kode_barcode) > 1
   order by transaksi_packing.kode_barcode, transaksi_packing.tanggal, jumlah_size desc ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packinglist_perstyle($po, $style){
    global $koneksi;
  
    $query = "SELECT po.no_po, style.style, barang.warna, transaksi_packing.no_karton, transaksi_packing.tanggal,
           transaksi_packing.no_karton,        
                    SUM(IF(barang.size='SS',1,0)) AS size_ss,
                    SUM(IF(barang.size='S',1,0)) AS size_s,
                    SUM(IF(barang.size='M',1,0)) AS size_m,
                    SUM(IF(barang.size='L',1,0)) AS size_l,
                    SUM(IF(barang.size='LL',1,0)) AS size_ll,
                    SUM(IF(barang.size='3L',1,0)) AS size_3l,
                    SUM(IF(barang.size='4L',1,0)) AS size_4l,
                    SUM(IF(barang.size='5L',1,0)) AS size_5l,
                    SUM(IF(barang.size='6L',1,0)) AS size_6l,
                    SUM(IF(barang.size='7L',1,0)) AS size_7l,
                    COUNT(barang.size) AS jumlah_size ,
                    COUNT(DISTINCT transaksi_packing.no_karton) AS karton
                    FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
    join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style 
    where transaksi_packing.id_po = '$po' AND style.style like '$style%'
     group by transaksi_packing.no_karton, transaksi_packing.id_po 
     having COUNT(DISTINCT transaksi_packing.kode_barcode) < 2
     order by style.style, transaksi_packing.kode_barcode, transaksi_packing.tanggal, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_packinglist_perstyle_mix($po, $style){
    global $koneksi;
  
    $query = "SELECT po.no_po, style.style, barang.warna, transaksi_packing.no_karton, transaksi_packing.tanggal,
           transaksi_packing.no_karton,        
                    SUM(IF(barang.size='SS',1,0)) AS size_ss,
                    SUM(IF(barang.size='S',1,0)) AS size_s,
                    SUM(IF(barang.size='M',1,0)) AS size_m,
                    SUM(IF(barang.size='L',1,0)) AS size_l,
                    SUM(IF(barang.size='LL',1,0)) AS size_ll,
                    SUM(IF(barang.size='3L',1,0)) AS size_3l,
                    SUM(IF(barang.size='4L',1,0)) AS size_4l,
                    SUM(IF(barang.size='5L',1,0)) AS size_5l,
                    SUM(IF(barang.size='6L',1,0)) AS size_6l,
                    SUM(IF(barang.size='7L',1,0)) AS size_7l,
                    COUNT(barang.size) AS jumlah_size ,
                    COUNT(DISTINCT transaksi_packing.no_karton) AS karton
                    FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
    join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style 
    where transaksi_packing.id_po = '$po' AND style.style like '$style%'
     group by transaksi_packing.no_karton, transaksi_packing.id_po 
     having COUNT(DISTINCT transaksi_packing.kode_barcode) > 1
     order by style.style, transaksi_packing.kode_barcode, transaksi_packing.tanggal, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_packinglist_perstyle_lengkap($po, $style){
    global $koneksi;
  
    $query = "SELECT B.no_po, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton
  From transaksi_packing A
   inner Join PO B On A.id_po=B.id_po
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
  WHERE A.id_po = $po AND D.style LIKE '$style%'
  Group By  A.no_karton, C.id_style,  B.no_po
  Order By b.no_po, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
  A.kode_barcode asc, jumlah_size desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

function tampilkan_laporan_packinglist_perstyle_lengkap_tanggal($po, $style, $tgl_awal, $tgl_akhir){
  global $koneksi;

  $query = "SELECT B.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton
  From transaksi_packing A
  inner Join PO B On A.id_po=B.id_po
  inner Join Barang C On A.kode_barcode=C.kode_barcode
  inner Join Style D On C.id_style=D.id_style
  inner join label E on B.id_label=E.id_label
  WHERE A.id_po = $po AND D.style LIKE '$style%' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
  Group By  A.no_karton, C.id_style,  B.no_po
  Order By b.no_po, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)), 
  A.kode_barcode asc, jumlah_size desc";  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packinglist_perstyle_tanggal($po, $style, $invoice){
  global $koneksi;
  
    $query = "SELECT po.no_po, style.style, barang.warna, transaksi_shipment.no_karton, transaksi_shipment.tanggal_scan,
           transaksi_shipment.no_karton,        
                    SUM(IF(barang.size='SS',1,0)) AS size_ss,
                    SUM(IF(barang.size='S',1,0)) AS size_s,
                    SUM(IF(barang.size='M',1,0)) AS size_m,
                    SUM(IF(barang.size='L',1,0)) AS size_l,
                    SUM(IF(barang.size='LL',1,0)) AS size_ll,
                    SUM(IF(barang.size='3L',1,0)) AS size_3l,
                    SUM(IF(barang.size='4L',1,0)) AS size_4l,
                    SUM(IF(barang.size='5L',1,0)) AS size_5l,
                    SUM(IF(barang.size='6L',1,0)) AS size_6l,
                    SUM(IF(barang.size='7L',1,0)) AS size_7l,
                    COUNT(barang.size) AS jumlah_size ,
                    COUNT(DISTINCT transaksi_shipment.no_karton) AS karton
                    FROM barang join transaksi_shipment on barang.kode_barcode = transaksi_shipment.kode_barcode
    join po on po.id_po = transaksi_shipment.id_po join style on barang.id_style = style.id_style 
    where transaksi_shipment.id_shipment='$invoice' AND transaksi_shipment.id_po = '$po' AND style.style like '$style%'
     group by transaksi_shipment.no_karton, transaksi_shipment.id_po 
     having COUNT(DISTINCT transaksi_shipment.kode_barcode) < 2
     order by style.style, transaksi_shipment.kode_barcode, transaksi_shipment.tanggal_scan, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_packinglist_perstyle_lengkap_invoice($po, $style, $invoice){
    global $koneksi;
  
    $query = "SELECT B.no_po, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, 
              Sum(IF(C.size='SS', 1,0)) as size_ss,
              Sum(IF(C.size='S', 1,0)) as size_s,
              Sum(IF(C.size='M', 1,0)) as size_m,
              Sum(IF(C.size='L', 1,0)) as size_l,
              Sum(IF(C.size='LL', 1,0)) as size_ll,
              Sum(IF(C.size='3L', 1,0)) as size_3l,
              Sum(IF(C.size='4L', 1,0)) as size_4l,
              Sum(IF(C.size='5L', 1,0)) as size_5l,
              Sum(IF(C.size='6L', 1,0)) as size_6l,
              Sum(IF(C.size='7L', 1,0)) as size_7l,
              Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton,
              sum(C.weight) as nett, (sum(C.weight)+1) as gross
              From transaksi_shipment A
              inner Join PO B On A.id_po=B.id_po
              inner Join Barang C On A.kode_barcode=C.kode_barcode
              inner Join Style D On C.id_style=D.id_style
              Where A.id_shipment='$invoice' and kriteria='tidak' AND A.id_po = '$po' AND D.style like '$style%'
              Group By  A.no_karton, C.id_style,  B.no_po
              Order By b.no_po, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
              IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
              IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
              IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
              IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)), 
              A.kode_barcode asc, jumlah_size desc, nett";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
    return $result;
  }

  function tampilkan_laporan_packinglist_lengkap_invoice_buyer($invoice){
    global $koneksi;
  
    $query = "SELECT A.id_max, A.orc, A.no_po, A.label, A.style, A.description, A.warna, A.no_karton, A.tanggal_scan, 
    A.size_ss, A.size_s, A.size_m, A.size_l, A.size_ll, A.size_3l, A.size_4l, A.size_5l, A.size_6l, A.size_7l, A.size_8l,
    A.size_1, A.size_2, A.size_3, A.size_4, A.size_5, A.size_6, A.size_7, A.size_8, A.size_9, A.size_10, A.size_11, A.size_12, 
    A.size_13, A.size_14, A.size_15, A.size_16, A.size_17, A.size_18, A.size_19, 
     A.size_w70, A.size_w71, A.size_w72, A.size_w73, A.size_w74, A.size_w75, A.size_w76, A.size_w77, A.size_w78, A.size_w79, 
     A.size_w80, A.size_w81, A.size_w82, A.size_w83, A.size_w84, A.size_w85, A.size_w86, A.size_w87, A.size_w88, A.size_w89, 
     A.size_w90, A.size_w91, A.size_w95, A.size_w96, A.size_w100, A.size_w105, A.size_w106, A.size_w110, A.size_w115, A.size_w120, A.size_w125, A.size_w130,
     A.jumlah_size, A.karton, A.nett, A.gross, A.kelompok, A.no_invoice, A.inspection, A.kelompok_size, A.costomer, A.ukuran_karton, A.no_contract
     FROM
(SELECT max(A.id_transaksi_shipment)id_max, A.orc, F.no_po, G.label, A.kode_barcode, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, 
     Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='1', 1,0)) as size_1,
    Sum(IF(C.size='2', 1,0)) as size_2,
    Sum(IF(C.size='3', 1,0)) as size_3,
    Sum(IF(C.size='4', 1,0)) as size_4,
    Sum(IF(C.size='5', 1,0)) as size_5,
    Sum(IF(C.size='6', 1,0)) as size_6,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='8', 1,0)) as size_8,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='10', 1,0)) as size_10,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='12', 1,0)) as size_12,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='14', 1,0)) as size_14,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='16', 1,0)) as size_16,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='18', 1,0)) as size_18,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W71', 1,0)) as size_w71,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W74', 1,0)) as size_w74,
    Sum(IF(C.size='W75', 1,0)) as size_w75,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W77', 1,0)) as size_w77,
    Sum(IF(C.size='W78', 1,0)) as size_w78,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W80', 1,0)) as size_w80,
    Sum(IF(C.size='W81', 1,0)) as size_w81,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W83', 1,0)) as size_w83,
    Sum(IF(C.size='W84', 1,0)) as size_w84,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W86', 1,0)) as size_w86,
    Sum(IF(C.size='W87', 1,0)) as size_w87,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W89', 1,0)) as size_w89,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
     Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton,
     sum(C.weight) as nett, (sum(C.weight)+1) as gross, A.kelompok, E.no_invoice, E.inspection, H.kelompok_size, E.costomer, E.ukuran_karton, I.no_contract
     From transaksi_shipment A
     inner JOIN master_order B On A.orc = B.orc
     inner Join Barang C On A.kode_barcode=C.kode_barcode
     inner Join Style D On C.id_style=D.id_style
     inner join shipment E on A.id_shipment = E.id_shipment
     INNER JOIN po F ON B.id_po = F.id_po
     INNER JOIN label G ON B.id_label = G.id_label
     INNER JOIN size H ON C.size = H.size
     INNER JOIN contract_number I on B.id_contract = I.id_contract
     Where A.id_shipment = $invoice AND A.kelompok = 'full' 
     Group BY F.no_po, G.label, C.id_style, C.size, A.kelompok
     UNION
SELECT max(A.id_transaksi_shipment)id_max, A.orc, F.no_po, G.label, A.kode_barcode, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, 
     Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='1', 1,0)) as size_1,
    Sum(IF(C.size='2', 1,0)) as size_2,
    Sum(IF(C.size='3', 1,0)) as size_3,
    Sum(IF(C.size='4', 1,0)) as size_4,
    Sum(IF(C.size='5', 1,0)) as size_5,
    Sum(IF(C.size='6', 1,0)) as size_6,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='8', 1,0)) as size_8,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='10', 1,0)) as size_10,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='12', 1,0)) as size_12,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='14', 1,0)) as size_14,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='16', 1,0)) as size_16,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='18', 1,0)) as size_18,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W71', 1,0)) as size_w71,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W74', 1,0)) as size_w74,
    Sum(IF(C.size='W75', 1,0)) as size_w75,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W77', 1,0)) as size_w77,
    Sum(IF(C.size='W78', 1,0)) as size_w78,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W80', 1,0)) as size_w80,
    Sum(IF(C.size='W81', 1,0)) as size_w81,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W83', 1,0)) as size_w83,
    Sum(IF(C.size='W84', 1,0)) as size_w84,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W86', 1,0)) as size_w86,
    Sum(IF(C.size='W87', 1,0)) as size_w87,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W89', 1,0)) as size_w89,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
     Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton,
     sum(C.weight) as nett, (sum(C.weight)+1) as gross, A.kelompok, E.no_invoice, E.inspection, H.kelompok_size, E.costomer, E.ukuran_karton, I.no_contract
     From transaksi_shipment A
     inner JOIN master_order B On A.orc = B.orc
     inner Join Barang C On A.kode_barcode=C.kode_barcode
     inner Join Style D On C.id_style=D.id_style
     inner join shipment E on A.id_shipment = E.id_shipment
     INNER JOIN po F ON B.id_po = F.id_po
     INNER JOIN label G ON B.id_label = G.id_label
     INNER JOIN size H ON C.size = H.size
     INNER JOIN contract_number I on B.id_contract = I.id_contract
     Where A.id_shipment = $invoice AND A.kelompok='ecer'
	  Group BY A.no_karton, F.no_po, G.label, C.id_style 
UNION
SELECT max(A.id_transaksi_shipment)id_max, A.orc, F.no_po, G.label, A.kode_barcode, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, 
     Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='1', 1,0)) as size_1,
    Sum(IF(C.size='2', 1,0)) as size_2,
    Sum(IF(C.size='3', 1,0)) as size_3,
    Sum(IF(C.size='4', 1,0)) as size_4,
    Sum(IF(C.size='5', 1,0)) as size_5,
    Sum(IF(C.size='6', 1,0)) as size_6,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='8', 1,0)) as size_8,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='10', 1,0)) as size_10,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='12', 1,0)) as size_12,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='14', 1,0)) as size_14,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='16', 1,0)) as size_16,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='18', 1,0)) as size_18,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W71', 1,0)) as size_w71,
    Sum(IF(C.size='W72', 1,0)) as size_w72,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W74', 1,0)) as size_w74,
    Sum(IF(C.size='W75', 1,0)) as size_w75,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W77', 1,0)) as size_w77,
    Sum(IF(C.size='W78', 1,0)) as size_w78,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W80', 1,0)) as size_w80,
    Sum(IF(C.size='W81', 1,0)) as size_w81,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W83', 1,0)) as size_w83,
    Sum(IF(C.size='W84', 1,0)) as size_w84,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W86', 1,0)) as size_w86,
    Sum(IF(C.size='W87', 1,0)) as size_w87,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W89', 1,0)) as size_w89,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
     Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton,
     sum(C.weight) as nett, (sum(C.weight)+1) as gross, A.kelompok, E.no_invoice, E.inspection, H.kelompok_size, E.costomer, E.ukuran_karton, I.no_contract
     From transaksi_shipment A
     inner JOIN master_order B On A.orc = B.orc
     inner Join Barang C On A.kode_barcode=C.kode_barcode
     inner Join Style D On C.id_style=D.id_style
     inner join shipment E on A.id_shipment = E.id_shipment
     INNER JOIN po F ON B.id_po = F.id_po
     INNER JOIN label G ON B.id_label = G.id_label
	  INNER JOIN size H ON C.size = H.size
    INNER JOIN contract_number I on B.id_contract = I.id_contract
     Where A.id_shipment = $invoice  AND A.kelompok='mix' 
     Group BY A.no_karton, F.no_po, G.label, C.id_style) A
     Order BY A.no_po, A.label, A.style, IF(A.kelompok = 'mix', A.id_max, 0), A.kode_barcode, 
     A.jumlah_size DESC";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
    return $result;
  }


  function tampilkan_laporan_packinglist_perstyle_lengkap_invoice_buyer_mix($po, $style, $invoice){
    global $koneksi;

    $query = "SELECT B.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, A.jam_scan,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton, 
  A.kelompok, F.no_invoice, F.inspection, sum(C.weight) as nett
  From transaksi_shipment A
   inner Join PO B On A.id_po=B.id_po
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
    inner join label E on B.id_label = E.id_label
    inner join shipment F on A.id_shipment = F.id_shipment
  WHERE A.id_shipment=$invoice and A.id_po = $po and D.style LIKE '$style%' and A.kriteria = 'mix_style'
  Group By  A.no_karton, B.no_po, C.id_style
  Order By b.no_po, D.style, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
  IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
  A.kode_barcode asc, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
    return $result;
  }
  
  function tampilkan_laporan_shipment_per_invoice_lengkap($invoice){
    global $koneksi;
  
    $query = "SELECT F.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, A.jam_scan,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
    Sum(IF(C.size='W130', 1,0)) as size_w130,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton, G.kelompok_size
  From transaksi_shipment A
   inner Join master_order B On A.orc=B.orc
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
    JOIN label E ON B.id_label=E.id_label
    JOIN po F ON B.id_po = F.id_po
    JOIN size G on C.size = G.size
  WHERE A.id_shipment=$invoice and A.kelompok != 'mix_style'
  Group By  A.no_karton, C.id_style,  b.orc
Order By b.orc, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
A.kode_barcode asc, jumlah_size desc, A.id_transaksi_shipment";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
    return $result;
}

function tampilkan_laporan_shipment_per_invoice_lengkap_mixstyle($invoice){
  global $koneksi;
  
  $query = "SELECT F.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, A.jam_scan,
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
  Sum(IF(C.size='1', 1,0)) as size_1,
  Sum(IF(C.size='2', 1,0)) as size_2,
  Sum(IF(C.size='3', 1,0)) as size_3,
  Sum(IF(C.size='4', 1,0)) as size_4,
  Sum(IF(C.size='5', 1,0)) as size_5,
  Sum(IF(C.size='6', 1,0)) as size_6,
  Sum(IF(C.size='7', 1,0)) as size_7,
  Sum(IF(C.size='8', 1,0)) as size_8,
  Sum(IF(C.size='9', 1,0)) as size_9,
  Sum(IF(C.size='10', 1,0)) as size_10,
  Sum(IF(C.size='11', 1,0)) as size_11,
  Sum(IF(C.size='12', 1,0)) as size_12,
  Sum(IF(C.size='13', 1,0)) as size_13,
  Sum(IF(C.size='14', 1,0)) as size_14,
  Sum(IF(C.size='15', 1,0)) as size_15,
  Sum(IF(C.size='16', 1,0)) as size_16,
  Sum(IF(C.size='17', 1,0)) as size_17,
  Sum(IF(C.size='18', 1,0)) as size_18,
  Sum(IF(C.size='19', 1,0)) as size_19,
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W71', 1,0)) as size_w71,
  Sum(IF(C.size='W72', 1,0)) as size_w72,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W74', 1,0)) as size_w74,
  Sum(IF(C.size='W75', 1,0)) as size_w75,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W77', 1,0)) as size_w77,
  Sum(IF(C.size='W78', 1,0)) as size_w78,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W80', 1,0)) as size_w80,
  Sum(IF(C.size='W81', 1,0)) as size_w81,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W83', 1,0)) as size_w83,
  Sum(IF(C.size='W84', 1,0)) as size_w84,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W86', 1,0)) as size_w86,
  Sum(IF(C.size='W87', 1,0)) as size_w87,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W89', 1,0)) as size_w89,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125,
  Sum(IF(C.size='W130', 1,0)) as size_w130,
Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton, G.kelompok_size, H.costomer, H.ukuran_karton, I.no_contract
From transaksi_shipment A
 inner Join master_order B On A.orc=B.orc
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  inner Join Style D On C.id_style=D.id_style
  JOIN label E ON B.id_label=E.id_label
  JOIN po F ON B.id_po = F.id_po
  JOIN size G on C.size = G.size
  JOIN shipment H ON A.id_shipment = H.id_shipment
  JOIN contract_number I on B.id_contract = I.id_contract
WHERE A.id_shipment= $invoice and A.kelompok = 'mix_style'
Group By  A.no_karton, C.id_style,  b.orc
Order By b.orc, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
A.kode_barcode asc, jumlah_size DESC, G.kelompok_size, A.id_transaksi_shipment";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
}

  function tampilkan_laporan_shipment_packinglist_po_invoice($po, $invoice){
    global $koneksi;
  
    $query = "SELECT F.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal_scan, A.jam_scan,
    Sum(IF(C.size='SS', 1,0)) as size_ss,
    Sum(IF(C.size='S', 1,0)) as size_s,
    Sum(IF(C.size='M', 1,0)) as size_m,
    Sum(IF(C.size='L', 1,0)) as size_l,
    Sum(IF(C.size='LL', 1,0)) as size_ll,
    Sum(IF(C.size='3L', 1,0)) as size_3l,
    Sum(IF(C.size='4L', 1,0)) as size_4l,
    Sum(IF(C.size='5L', 1,0)) as size_5l,
    Sum(IF(C.size='6L', 1,0)) as size_6l,
    Sum(IF(C.size='7L', 1,0)) as size_7l,
    Sum(IF(C.size='8L', 1,0)) as size_8l,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='19', 1,0)) as size_19,
    Sum(IF(C.size='W70', 1,0)) as size_w70,
    Sum(IF(C.size='W73', 1,0)) as size_w73,
    Sum(IF(C.size='W76', 1,0)) as size_w76,
    Sum(IF(C.size='W79', 1,0)) as size_w79,
    Sum(IF(C.size='W82', 1,0)) as size_w82,
    Sum(IF(C.size='W85', 1,0)) as size_w85,
    Sum(IF(C.size='W88', 1,0)) as size_w88,
    Sum(IF(C.size='W90', 1,0)) as size_w90,
    Sum(IF(C.size='W91', 1,0)) as size_w91,
    Sum(IF(C.size='W95', 1,0)) as size_w95,
    Sum(IF(C.size='W96', 1,0)) as size_w96,
    Sum(IF(C.size='W100', 1,0)) as size_w100,
    Sum(IF(C.size='W105', 1,0)) as size_w105,
    Sum(IF(C.size='W106', 1,0)) as size_w106,
    Sum(IF(C.size='W110', 1,0)) as size_w110,
    Sum(IF(C.size='W115', 1,0)) as size_w115,
    Sum(IF(C.size='W120', 1,0)) as size_w120,
    Sum(IF(C.size='W125', 1,0)) as size_w125,
  Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton, G.kelompok_size
  From transaksi_shipment A
   inner Join master_order B On A.orc=B.orc
   inner Join Barang C On A.kode_barcode=C.kode_barcode
    inner Join Style D On C.id_style=D.id_style
    JOIN label E ON B.id_label=E.id_label
    JOIN po F ON B.id_po = F.id_po
    JOIN size G on C.size = G.size
  WHERE A.id_shipment=$invoice and B.id_po = $po and A.kelompok != 'mix_style'
  Group By  A.no_karton, C.id_style,  b.orc
Order By b.orc, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
A.kode_barcode asc, jumlah_size desc, A.id_transaksi_shipment";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_shipment_per_invoice($invoice){
    global $koneksi;
  
    $query = "SELECT po.no_po, style.style, style.description, barang.warna, transaksi_shipment.no_karton, transaksi_shipment.tanggal_scan,
           transaksi_shipment.no_karton,        
                    SUM(IF(barang.size='SS',1,0)) AS size_ss,
                    SUM(IF(barang.size='S',1,0)) AS size_s,
                    SUM(IF(barang.size='M',1,0)) AS size_m,
                    SUM(IF(barang.size='L',1,0)) AS size_l,
                    SUM(IF(barang.size='LL',1,0)) AS size_ll,
                    SUM(IF(barang.size='3L',1,0)) AS size_3l,
                    SUM(IF(barang.size='4L',1,0)) AS size_4l,
                    SUM(IF(barang.size='5L',1,0)) AS size_5l,
                    SUM(IF(barang.size='6L',1,0)) AS size_6l,
                    SUM(IF(barang.size='7L',1,0)) AS size_7l,
                    COUNT(barang.size) AS jumlah_size ,
                    COUNT(DISTINCT transaksi_shipment.no_karton) AS karton
                    FROM barang join transaksi_shipment on barang.kode_barcode = transaksi_shipment.kode_barcode
    join po on po.id_po = transaksi_shipment.id_po join style on barang.id_style = style.id_style 
    where transaksi_shipment.id_shipment = '$invoice' 
    group by transaksi_shipment.id_po, style.style, transaksi_shipment.no_karton
     having COUNT(DISTINCT transaksi_shipment.kode_barcode) < 2
     order by style.style, transaksi_shipment.kode_barcode, transaksi_shipment.tanggal_scan, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_shipment_per_invoice_mix($invoice){
    global $koneksi;
  
    $query = "SELECT po.no_po, style.style, style.description, barang.warna, transaksi_shipment.no_karton, transaksi_shipment.tanggal_scan,
           transaksi_shipment.no_karton,        
                    SUM(IF(barang.size='SS',1,0)) AS size_ss,
                    SUM(IF(barang.size='S',1,0)) AS size_s,
                    SUM(IF(barang.size='M',1,0)) AS size_m,
                    SUM(IF(barang.size='L',1,0)) AS size_l,
                    SUM(IF(barang.size='LL',1,0)) AS size_ll,
                    SUM(IF(barang.size='3L',1,0)) AS size_3l,
                    SUM(IF(barang.size='4L',1,0)) AS size_4l,
                    SUM(IF(barang.size='5L',1,0)) AS size_5l,
                    SUM(IF(barang.size='6L',1,0)) AS size_6l,
                    SUM(IF(barang.size='7L',1,0)) AS size_7l,
                    COUNT(barang.size) AS jumlah_size ,
                    COUNT(DISTINCT transaksi_shipment.no_karton) AS karton
                    FROM barang join transaksi_shipment on barang.kode_barcode = transaksi_shipment.kode_barcode
    join po on po.id_po = transaksi_shipment.id_po join style on barang.id_style = style.id_style 
    where transaksi_shipment.id_shipment = '$invoice' 
    group by transaksi_shipment.no_karton, transaksi_shipment.id_po
     having COUNT(DISTINCT transaksi_shipment.kode_barcode) > 1
     order by style.style, transaksi_shipment.kode_barcode, transaksi_shipment.tanggal_scan, jumlah_size desc";
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }

  function tampilkan_laporan_shipment_tanggal_periode($tgl_awal, $tgl_akhir, $invoice){
    global $koneksi;
  
    $query = "SELECT G.no_invoice, A.tanggal_scan, E.no_po, A.no_karton, A.kode_barcode, C.style, B.warna, B.size, A.jam_scan,
    COUNT(DISTINCT A.no_karton) AS karton, COUNT(B.size) AS jumlah_size, A.kelompok, F.label
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode JOIN style C ON B.id_style = C.id_style
   JOIN master_order D ON A.orc = D.orc JOIN po E ON D.id_po = E.id_po JOIN label F ON D.id_label = F.id_label
   JOIN shipment G ON A.id_shipment = G.id_shipment   		
     WHERE A.id_shipment= $invoice and A.tanggal_scan BETWEEN '$tgl_awal' AND '$tgl_akhir'
            group by A.tanggal_scan, A.no_karton, A.orc,  A.kode_barcode
               order by A.tanggal_scan, A.no_karton, A.kode_barcode asc";
  
    $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  return $result;
  }
  

function tampilkan_laporan_packing_periode_tanggal($tgl_awal, $tgl_akhir){
  global $koneksi;

  $query = "SELECT B.tanggal, B.orc, F.no_po, E.label, B.no_karton, B.kode_barcode, D.style, A.warna, A.size, B.jam, 
            COUNT(DISTINCT B.no_karton) AS karton, COUNT(A.size) AS jumlah_size, B.kelompok
            FROM barang A join transaksi_packing B on A.kode_barcode = B.kode_barcode join master_order C ON B.orc = C.orc 
            join style D on A.id_style = D.id_style JOIN label E ON C.id_label=E.id_label JOIN po F ON C.id_po = F.id_po 
            where B.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
            group by B.tanggal, B.no_karton, B.orc, A.kode_barcode
            order BY B.tanggal, B.no_karton, B.orc, B.kode_barcode asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_laporan_packing_tanggal($tanggal){
  global $koneksi;

  $query = "SELECT B.tanggal, B.orc, F.no_po, E.label, B.no_karton, B.kode_barcode, D.style, A.warna, A.size, B.jam, 
            COUNT(DISTINCT B.no_karton) AS karton, COUNT(A.size) AS jumlah_size, B.kelompok
            FROM barang A join transaksi_packing B on A.kode_barcode = B.kode_barcode join master_order C ON B.orc = C.orc 
            join style D on A.id_style = D.id_style JOIN label E ON C.id_label=E.id_label JOIN po F ON C.id_po = F.id_po 
            where B.tanggal = '$tanggal'
            group by B.tanggal, B.no_karton, B.orc, A.kode_barcode
            order BY B.tanggal, B.no_karton, B.orc, B.kode_barcode asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function tampilkan_laporan_packing_po_style($po, $style){
  global $koneksi;

  $query = "SELECT B.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton
From transaksi_packing A
 inner Join PO B On A.id_po=B.id_po
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  inner Join Style D On C.id_style=D.id_style
  inner join label E on B.id_label = E.id_label
WHERE A.id_po = $po and D.style LIKE '$style%' and A.kriteria = 'tidak'
Group By  A.no_karton, C.id_style,  B.no_po
Order By b.no_po, D.style, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)+
IF(Sum(IF(C.size='8L', 1,0))>0,1,0)), 
A.kode_barcode asc, jumlah_size desc";
$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}


function tampilkan_laporan_packing_po_style_hidesize($po, $style){
  global $koneksi;

  $query ="SELECT B.no_po, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l
From transaksi_packing A
 inner Join PO B On A.id_po=B.id_po
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
WHERE A.id_po = $po and D.style LIKE '%$style%' and A.kriteria = 'tidak'
Group BY   B.no_po, C.id_style
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing_orc_hidesize($orc){
  global $koneksi;

  $query ="SELECT B.orc, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W71', 1,0)) as size_w71,
  Sum(IF(C.size='W72', 1,0)) as size_w72,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W74', 1,0)) as size_w74,
  Sum(IF(C.size='W75', 1,0)) as size_w75,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W77', 1,0)) as size_w77,
  Sum(IF(C.size='W78', 1,0)) as size_w78,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W80', 1,0)) as size_w80,
  Sum(IF(C.size='W81', 1,0)) as size_w81,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W83', 1,0)) as size_w83,
  Sum(IF(C.size='W84', 1,0)) as size_w84,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W86', 1,0)) as size_w86,
  Sum(IF(C.size='W87', 1,0)) as size_w87,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W89', 1,0)) as size_w89,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125,
  Sum(IF(C.size='W130', 1,0)) as size_w130
From transaksi_packing A
  inner Join master_order B On A.orc=B.orc
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
WHERE A.orc = '$orc' and A.kelompok != 'mix_style'
Group BY   B.orc, C.id_style
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing_orc_full_hidesize(){
  global $koneksi;

  $query ="SELECT B.orc, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
  Sum(IF(C.size='0', 1,0)) as size_0,
  Sum(IF(C.size='1', 1,0)) as size_1,
  Sum(IF(C.size='2', 1,0)) as size_2,
  Sum(IF(C.size='3', 1,0)) as size_3,
  Sum(IF(C.size='4', 1,0)) as size_4,
  Sum(IF(C.size='5', 1,0)) as size_5,
  Sum(IF(C.size='6', 1,0)) as size_6,
  Sum(IF(C.size='7', 1,0)) as size_7,
  Sum(IF(C.size='8', 1,0)) as size_8,
  Sum(IF(C.size='9', 1,0)) as size_9,
  Sum(IF(C.size='10', 1,0)) as size_10,
  Sum(IF(C.size='11', 1,0)) as size_11,
  Sum(IF(C.size='12', 1,0)) as size_12,
  Sum(IF(C.size='13', 1,0)) as size_13,
  Sum(IF(C.size='14', 1,0)) as size_14,
  Sum(IF(C.size='15', 1,0)) as size_15,
  Sum(IF(C.size='16', 1,0)) as size_16,
  Sum(IF(C.size='17', 1,0)) as size_17,
  Sum(IF(C.size='18', 1,0)) as size_18,
  Sum(IF(C.size='19', 1,0)) as size_19,
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W71', 1,0)) as size_w71,
  Sum(IF(C.size='W72', 1,0)) as size_w72,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W74', 1,0)) as size_w74,
  Sum(IF(C.size='W75', 1,0)) as size_w75,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W77', 1,0)) as size_w77,
  Sum(IF(C.size='W78', 1,0)) as size_w78,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W80', 1,0)) as size_w80,
  Sum(IF(C.size='W81', 1,0)) as size_w81,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W83', 1,0)) as size_w83,
  Sum(IF(C.size='W84', 1,0)) as size_w84,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W86', 1,0)) as size_w86,
  Sum(IF(C.size='W87', 1,0)) as size_w87,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W89', 1,0)) as size_w89,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125,
  Sum(IF(C.size='W130', 1,0)) as size_w130
From transaksi_packing A
  inner Join master_order B On A.orc=B.orc
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
WHERE A.kelompok != 'mix_style'
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing_hidesize($costomer, $po, $orc, $style){
  global $koneksi;

  $query ="SELECT E.costomer, B.orc, B.no_po, D.style, D.description, 
        Sum(IF(C.size='SS', 1,0)) as size_ss,
        Sum(IF(C.size='S', 1,0)) as size_s,
        Sum(IF(C.size='M', 1,0)) as size_m,
        Sum(IF(C.size='L', 1,0)) as size_l,
        Sum(IF(C.size='LL', 1,0)) as size_ll,
        Sum(IF(C.size='3L', 1,0)) as size_3l,
        Sum(IF(C.size='4L', 1,0)) as size_4l,
        Sum(IF(C.size='5L', 1,0)) as size_5l,
        Sum(IF(C.size='6L', 1,0)) as size_6l,
        Sum(IF(C.size='7L', 1,0)) as size_7l,
        Sum(IF(C.size='8L', 1,0)) as size_8l,
        Sum(IF(C.size='W70', 1,0)) as size_w70,
        Sum(IF(C.size='W71', 1,0)) as size_w71,
        Sum(IF(C.size='W72', 1,0)) as size_w72,
        Sum(IF(C.size='W73', 1,0)) as size_w73,
        Sum(IF(C.size='W74', 1,0)) as size_w74,
        Sum(IF(C.size='W75', 1,0)) as size_w75,
        Sum(IF(C.size='W76', 1,0)) as size_w76,
        Sum(IF(C.size='W77', 1,0)) as size_w77,
        Sum(IF(C.size='W78', 1,0)) as size_w78,
        Sum(IF(C.size='W79', 1,0)) as size_w79,
        Sum(IF(C.size='W80', 1,0)) as size_w80,
        Sum(IF(C.size='W81', 1,0)) as size_w81,
        Sum(IF(C.size='W82', 1,0)) as size_w82,
        Sum(IF(C.size='W83', 1,0)) as size_w83,
        Sum(IF(C.size='W84', 1,0)) as size_w84,
        Sum(IF(C.size='W85', 1,0)) as size_w85,
        Sum(IF(C.size='W86', 1,0)) as size_w86,
        Sum(IF(C.size='W87', 1,0)) as size_w87,
        Sum(IF(C.size='W88', 1,0)) as size_w88,
        Sum(IF(C.size='W89', 1,0)) as size_w89,
        Sum(IF(C.size='W90', 1,0)) as size_w90,
        Sum(IF(C.size='W91', 1,0)) as size_w91,
        Sum(IF(C.size='W95', 1,0)) as size_w95,
        Sum(IF(C.size='W96', 1,0)) as size_w96,
        Sum(IF(C.size='W100', 1,0)) as size_w100,
        Sum(IF(C.size='W105', 1,0)) as size_w105,
        Sum(IF(C.size='W106', 1,0)) as size_w106,
        Sum(IF(C.size='W110', 1,0)) as size_w110,
        Sum(IF(C.size='W115', 1,0)) as size_w115,
        Sum(IF(C.size='W120', 1,0)) as size_w120,
        Sum(IF(C.size='W125', 1,0)) as size_w125,
        Sum(IF(C.size='W130', 1,0)) as size_w130,
        Sum(IF(C.size='70', 1,0)) as size_70,
        Sum(IF(C.size='73', 1,0)) as size_73,
        Sum(IF(C.size='76', 1,0)) as size_76,
        Sum(IF(C.size='79', 1,0)) as size_79,
        Sum(IF(C.size='82', 1,0)) as size_82,
        Sum(IF(C.size='85', 1,0)) as size_85,
        Sum(IF(C.size='88', 1,0)) as size_88,
        Sum(IF(C.size='91', 1,0)) as size_91,
        Sum(IF(C.size='95', 1,0)) as size_95,
        Sum(IF(C.size='100', 1,0)) as size_100,
        Sum(IF(C.size='105', 1,0)) as size_105,
        Sum(IF(C.size='110', 1,0)) as size_110,
        Sum(IF(C.size='115', 1,0)) as size_115,
        Sum(IF(C.size='120', 1,0)) as size_120,
        Sum(IF(C.size='130', 1,0)) as size_130,
        Sum(IF(C.size='140', 1,0)) as size_140,
        Sum(IF(C.size='150', 1,0)) as size_150,	
        Sum(IF(C.size='86-3', 1,0)) as size_86_3,
        Sum(IF(C.size='90-4', 1,0)) as size_90_4,
        Sum(IF(C.size='94-5', 1,0)) as size_94_5,
        Sum(IF(C.size='98-6', 1,0)) as size_98_6,
        Sum(IF(C.size='0', 1,0)) as size_0,
        Sum(IF(C.size='1', 1,0)) as size_1,
        Sum(IF(C.size='2', 1,0)) as size_2,
        Sum(IF(C.size='3', 1,0)) as size_3,
        Sum(IF(C.size='4', 1,0)) as size_4,
        Sum(IF(C.size='5', 1,0)) as size_5,
        Sum(IF(C.size='6', 1,0)) as size_6,
        Sum(IF(C.size='7', 1,0)) as size_7,
        Sum(IF(C.size='8', 1,0)) as size_8,
        Sum(IF(C.size='9', 1,0)) as size_9,
        Sum(IF(C.size='10', 1,0)) as size_10,
        Sum(IF(C.size='11', 1,0)) as size_11,
        Sum(IF(C.size='12', 1,0)) as size_12,
        Sum(IF(C.size='13', 1,0)) as size_13,
        Sum(IF(C.size='14', 1,0)) as size_14,
        Sum(IF(C.size='15', 1,0)) as size_15,
        Sum(IF(C.size='16', 1,0)) as size_16,
        Sum(IF(C.size='17', 1,0)) as size_17,
        Sum(IF(C.size='18', 1,0)) as size_18,
        Sum(IF(C.size='19', 1,0)) as size_19
From transaksi_packing A
  inner Join master_order B On A.orc=B.orc
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
	WHERE B.no_po LIKE '%$po%' AND B.orc LIKE '%$orc%' AND D.style LIKE '%$style%' AND E.id_costomer = $costomer AND A.shipment = 'n' 
  ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_temp_shipment_hidesize($invoice){
  global $koneksi;

  $query ="SELECT E.costomer, B.orc, B.no_po, D.style, D.description, 
        Sum(IF(C.size='SS', 1,0)) as size_ss,
        Sum(IF(C.size='S', 1,0)) as size_s,
        Sum(IF(C.size='M', 1,0)) as size_m,
        Sum(IF(C.size='L', 1,0)) as size_l,
        Sum(IF(C.size='LL', 1,0)) as size_ll,
        Sum(IF(C.size='3L', 1,0)) as size_3l,
        Sum(IF(C.size='4L', 1,0)) as size_4l,
        Sum(IF(C.size='5L', 1,0)) as size_5l,
        Sum(IF(C.size='6L', 1,0)) as size_6l,
        Sum(IF(C.size='7L', 1,0)) as size_7l,
        Sum(IF(C.size='8L', 1,0)) as size_8l,
        Sum(IF(C.size='W70', 1,0)) as size_w70,
        Sum(IF(C.size='W71', 1,0)) as size_w71,
        Sum(IF(C.size='W72', 1,0)) as size_w72,
        Sum(IF(C.size='W73', 1,0)) as size_w73,
        Sum(IF(C.size='W74', 1,0)) as size_w74,
        Sum(IF(C.size='W75', 1,0)) as size_w75,
        Sum(IF(C.size='W76', 1,0)) as size_w76,
        Sum(IF(C.size='W77', 1,0)) as size_w77,
        Sum(IF(C.size='W78', 1,0)) as size_w78,
        Sum(IF(C.size='W79', 1,0)) as size_w79,
        Sum(IF(C.size='W80', 1,0)) as size_w80,
        Sum(IF(C.size='W81', 1,0)) as size_w81,
        Sum(IF(C.size='W82', 1,0)) as size_w82,
        Sum(IF(C.size='W83', 1,0)) as size_w83,
        Sum(IF(C.size='W84', 1,0)) as size_w84,
        Sum(IF(C.size='W85', 1,0)) as size_w85,
        Sum(IF(C.size='W86', 1,0)) as size_w86,
        Sum(IF(C.size='W87', 1,0)) as size_w87,
        Sum(IF(C.size='W88', 1,0)) as size_w88,
        Sum(IF(C.size='W89', 1,0)) as size_w89,
        Sum(IF(C.size='W90', 1,0)) as size_w90,
        Sum(IF(C.size='W91', 1,0)) as size_w91,
        Sum(IF(C.size='W95', 1,0)) as size_w95,
        Sum(IF(C.size='W96', 1,0)) as size_w96,
        Sum(IF(C.size='W100', 1,0)) as size_w100,
        Sum(IF(C.size='W105', 1,0)) as size_w105,
        Sum(IF(C.size='W106', 1,0)) as size_w106,
        Sum(IF(C.size='W110', 1,0)) as size_w110,
        Sum(IF(C.size='W115', 1,0)) as size_w115,
        Sum(IF(C.size='W120', 1,0)) as size_w120,
        Sum(IF(C.size='W125', 1,0)) as size_w125,
        Sum(IF(C.size='W130', 1,0)) as size_w130,
        Sum(IF(C.size='70', 1,0)) as size_70,
        Sum(IF(C.size='73', 1,0)) as size_73,
        Sum(IF(C.size='76', 1,0)) as size_76,
        Sum(IF(C.size='79', 1,0)) as size_79,
        Sum(IF(C.size='82', 1,0)) as size_82,
        Sum(IF(C.size='85', 1,0)) as size_85,
        Sum(IF(C.size='88', 1,0)) as size_88,
        Sum(IF(C.size='91', 1,0)) as size_91,
        Sum(IF(C.size='95', 1,0)) as size_95,
        Sum(IF(C.size='100', 1,0)) as size_100,
        Sum(IF(C.size='105', 1,0)) as size_105,
        Sum(IF(C.size='110', 1,0)) as size_110,
        Sum(IF(C.size='115', 1,0)) as size_115,
        Sum(IF(C.size='120', 1,0)) as size_120,
        Sum(IF(C.size='130', 1,0)) as size_130,
        Sum(IF(C.size='140', 1,0)) as size_140,
        Sum(IF(C.size='150', 1,0)) as size_150,
        Sum(IF(C.size='86-3', 1,0)) as size_86_3,
        Sum(IF(C.size='90-4', 1,0)) as size_90_4,
        Sum(IF(C.size='94-5', 1,0)) as size_94_5,
        Sum(IF(C.size='98-6', 1,0)) as size_98_6,
        Sum(IF(C.size='0', 1,0)) as size_0,
        Sum(IF(C.size='1', 1,0)) as size_1,
        Sum(IF(C.size='2', 1,0)) as size_2,
        Sum(IF(C.size='3', 1,0)) as size_3,
        Sum(IF(C.size='4', 1,0)) as size_4,
        Sum(IF(C.size='5', 1,0)) as size_5,
        Sum(IF(C.size='6', 1,0)) as size_6,
        Sum(IF(C.size='7', 1,0)) as size_7,
        Sum(IF(C.size='8', 1,0)) as size_8,
        Sum(IF(C.size='9', 1,0)) as size_9,
        Sum(IF(C.size='10', 1,0)) as size_10,
        Sum(IF(C.size='11', 1,0)) as size_11,
        Sum(IF(C.size='12', 1,0)) as size_12,
        Sum(IF(C.size='13', 1,0)) as size_13,
        Sum(IF(C.size='14', 1,0)) as size_14,
        Sum(IF(C.size='15', 1,0)) as size_15,
        Sum(IF(C.size='16', 1,0)) as size_16,
        Sum(IF(C.size='17', 1,0)) as size_17,
        Sum(IF(C.size='18', 1,0)) as size_18,
        Sum(IF(C.size='19', 1,0)) as size_19
From transaksi_shipment A
  inner Join master_order B On A.orc=B.orc
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
	WHERE A.id_shipment = $invoice 
  ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing_a_hidesize(){
  global $koneksi;

  $query ="SELECT B.orc, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l, E.kelompok_size
From transaksi_packing A
  inner Join master_order B On A.orc=B.orc
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  join size E on C.size = E.size
  where E.kelompok_size = 'a'
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}
function tampilkan_laporan_shipment_a_hidesize(){
  global $koneksi;

  $query ="SELECT B.orc, D.style, D.description, 
        Sum(IF(C.size='SS', 1,0)) as size_ss,
        Sum(IF(C.size='S', 1,0)) as size_s,
        Sum(IF(C.size='M', 1,0)) as size_m,
        Sum(IF(C.size='L', 1,0)) as size_l,
        Sum(IF(C.size='LL', 1,0)) as size_ll,
        Sum(IF(C.size='3L', 1,0)) as size_3l, 
        Sum(IF(C.size='4L', 1,0)) as size_4l,
        Sum(IF(C.size='5L', 1,0)) as size_5l,
        Sum(IF(C.size='6L', 1,0)) as size_6l,
        Sum(IF(C.size='7L', 1,0)) as size_7l,
        Sum(IF(C.size='8L', 1,0)) as size_8l, E.kelompok_size
        From transaksi_shipment A
        inner Join master_order B On A.orc=B.orc
        inner Join Barang C On A.kode_barcode=C.kode_barcode
        INNER JOIN style D ON C.id_style = D.id_style
        join size E on C.size = E.size
        where E.kelompok_size = 'a'
  ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_shipment_b_hidesize(){
  global $koneksi;

  $query ="SELECT B.orc, D.style, D.description, 
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W71', 1,0)) as size_w71,
  Sum(IF(C.size='W72', 1,0)) as size_w72,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W74', 1,0)) as size_w74,
  Sum(IF(C.size='W75', 1,0)) as size_w75,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W77', 1,0)) as size_w77,
  Sum(IF(C.size='W78', 1,0)) as size_w78,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W80', 1,0)) as size_w80,
  Sum(IF(C.size='W81', 1,0)) as size_w81,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W83', 1,0)) as size_w83,
  Sum(IF(C.size='W84', 1,0)) as size_w84,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W86', 1,0)) as size_w86,
  Sum(IF(C.size='W87', 1,0)) as size_w87,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W89', 1,0)) as size_w89,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125,
  Sum(IF(C.size='W130', 1,0)) as size_w130, 
  E.kelompok_size
From transaksi_shipment A
inner Join master_order B On A.orc=B.orc
inner Join Barang C On A.kode_barcode=C.kode_barcode
INNER JOIN style D ON C.id_style = D.id_style
join size E on C.size = E.size
where E.kelompok_size = 'b'
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_shipment_po_hidesize($invoice, $po){
  global $koneksi;

  $query ="SELECT E.no_po, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125
From transaksi_shipment A
  inner Join master_order B On A.orc=B.orc
  inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN po E on B.id_po = E.id_po
  INNER JOIN label F on B.id_label = F.id_label
WHERE A.id_shipment = $invoice and B.id_po = $po and  A.kelompok != 'mix_style'
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_shipment_hidesize_mix($invoice){
  global $koneksi;

  $query ="SELECT E.no_po, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W71', 1,0)) as size_w71,
  Sum(IF(C.size='W72', 1,0)) as size_w72,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W74', 1,0)) as size_w74,
  Sum(IF(C.size='W75', 1,0)) as size_w75,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W77', 1,0)) as size_w77,
  Sum(IF(C.size='W78', 1,0)) as size_w78,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W80', 1,0)) as size_w80,
  Sum(IF(C.size='W81', 1,0)) as size_w81,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W83', 1,0)) as size_w83,
  Sum(IF(C.size='W84', 1,0)) as size_w84,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W86', 1,0)) as size_w86,
  Sum(IF(C.size='W87', 1,0)) as size_w87,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W89', 1,0)) as size_w89,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125,
  Sum(IF(C.size='W130', 1,0)) as size_w130,
  Sum(IF(C.size='1', 1,0)) as size_1,
    Sum(IF(C.size='2', 1,0)) as size_2,
    Sum(IF(C.size='3', 1,0)) as size_3,
    Sum(IF(C.size='4', 1,0)) as size_4,
    Sum(IF(C.size='5', 1,0)) as size_5,
    Sum(IF(C.size='6', 1,0)) as size_6,
    Sum(IF(C.size='7', 1,0)) as size_7,
    Sum(IF(C.size='8', 1,0)) as size_8,
    Sum(IF(C.size='9', 1,0)) as size_9,
    Sum(IF(C.size='10', 1,0)) as size_10,
    Sum(IF(C.size='11', 1,0)) as size_11,
    Sum(IF(C.size='12', 1,0)) as size_12,
    Sum(IF(C.size='13', 1,0)) as size_13,
    Sum(IF(C.size='14', 1,0)) as size_14,
    Sum(IF(C.size='15', 1,0)) as size_15,
    Sum(IF(C.size='16', 1,0)) as size_16,
    Sum(IF(C.size='17', 1,0)) as size_17,
    Sum(IF(C.size='18', 1,0)) as size_18,
    Sum(IF(C.size='19', 1,0)) as size_19
From transaksi_shipment A
  inner Join master_order B On A.orc=B.orc
  inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN po E on B.id_po = E.id_po
  INNER JOIN label F on B.id_label = F.id_label
WHERE A.id_shipment = $invoice and A.kelompok = 'mix_style'";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing_orc_mix_hidesize(){
  global $koneksi;

  $query ="SELECT B.orc, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W71', 1,0)) as size_w71,
  Sum(IF(C.size='W72', 1,0)) as size_w72,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W74', 1,0)) as size_w74,
  Sum(IF(C.size='W75', 1,0)) as size_w75,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W77', 1,0)) as size_w77,
  Sum(IF(C.size='W78', 1,0)) as size_w78,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W80', 1,0)) as size_w80,
  Sum(IF(C.size='W81', 1,0)) as size_w81,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W83', 1,0)) as size_w83,
  Sum(IF(C.size='W84', 1,0)) as size_w84,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W86', 1,0)) as size_w86,
  Sum(IF(C.size='W87', 1,0)) as size_w87,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W89', 1,0)) as size_w89,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125,
  Sum(IF(C.size='W130', 1,0)) as size_w130
From transaksi_packing A
  inner Join master_order B On A.orc=B.orc
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
WHERE A.kelompok = 'mix_style'
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing_po_hidesize($po){
  global $koneksi;

  $query ="SELECT E.no_po, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l,
  Sum(IF(C.size='W70', 1,0)) as size_w70,
  Sum(IF(C.size='W71', 1,0)) as size_w71,
  Sum(IF(C.size='W72', 1,0)) as size_w72,
  Sum(IF(C.size='W73', 1,0)) as size_w73,
  Sum(IF(C.size='W74', 1,0)) as size_w74,
  Sum(IF(C.size='W75', 1,0)) as size_w75,
  Sum(IF(C.size='W76', 1,0)) as size_w76,
  Sum(IF(C.size='W77', 1,0)) as size_w77,
  Sum(IF(C.size='W78', 1,0)) as size_w78,
  Sum(IF(C.size='W79', 1,0)) as size_w79,
  Sum(IF(C.size='W80', 1,0)) as size_w80,
  Sum(IF(C.size='W81', 1,0)) as size_w81,
  Sum(IF(C.size='W82', 1,0)) as size_w82,
  Sum(IF(C.size='W83', 1,0)) as size_w83,
  Sum(IF(C.size='W84', 1,0)) as size_w84,
  Sum(IF(C.size='W85', 1,0)) as size_w85,
  Sum(IF(C.size='W86', 1,0)) as size_w86,
  Sum(IF(C.size='W87', 1,0)) as size_w87,
  Sum(IF(C.size='W88', 1,0)) as size_w88,
  Sum(IF(C.size='W89', 1,0)) as size_w89,
  Sum(IF(C.size='W90', 1,0)) as size_w90,
  Sum(IF(C.size='W91', 1,0)) as size_w91,
  Sum(IF(C.size='W95', 1,0)) as size_w95,
  Sum(IF(C.size='W96', 1,0)) as size_w96,
  Sum(IF(C.size='W100', 1,0)) as size_w100,
  Sum(IF(C.size='W105', 1,0)) as size_w105,
  Sum(IF(C.size='W106', 1,0)) as size_w106,
  Sum(IF(C.size='W110', 1,0)) as size_w110,
  Sum(IF(C.size='W115', 1,0)) as size_w115,
  Sum(IF(C.size='W120', 1,0)) as size_w120,
  Sum(IF(C.size='W125', 1,0)) as size_w125,
  Sum(IF(C.size='W130', 1,0)) as size_w130
From transaksi_packing A
  inner Join master_order B On A.orc=B.orc
  inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN po E on B.id_po = E.id_po
  INNER JOIN label F on B.id_label = F.id_label
WHERE E.no_po = '$po' and A.kelompok != 'mix_style'
-- Group BY   B.orc, C.id_style
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_shipment_po_style_hidesize_all($invoice){
  global $koneksi;

  $query ="SELECT B.no_po, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l
From transaksi_shipment A
 inner Join PO B On A.id_po=B.id_po
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
WHERE  A.id_shipment = $invoice  and A.kriteria = 'tidak'
ORDER BY B.no_po, D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_shipment_po_style_hidesize($po, $style, $invoice){
  global $koneksi;

  $query ="SELECT B.no_po, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l
From transaksi_shipment A
 inner Join PO B On A.id_po=B.id_po
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
WHERE  A.id_shipment = $invoice and A.id_po = $po and D.style LIKE '%$style%' and A.kriteria = 'tidak'
Group BY   B.no_po, C.id_style
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_shipment_po_style_hidesize_mix($po, $style, $invoice){
  global $koneksi;

  $query ="SELECT B.no_po, D.style, D.description, 
  Sum(IF(C.size='SS', 1,0)) as size_ss,
  Sum(IF(C.size='S', 1,0)) as size_s,
  Sum(IF(C.size='M', 1,0)) as size_m,
  Sum(IF(C.size='L', 1,0)) as size_l,
  Sum(IF(C.size='LL', 1,0)) as size_ll,
  Sum(IF(C.size='3L', 1,0)) as size_3l,
  Sum(IF(C.size='4L', 1,0)) as size_4l,
  Sum(IF(C.size='5L', 1,0)) as size_5l,
  Sum(IF(C.size='6L', 1,0)) as size_6l,
  Sum(IF(C.size='7L', 1,0)) as size_7l,
  Sum(IF(C.size='8L', 1,0)) as size_8l
From transaksi_shipment A
 inner Join PO B On A.id_po=B.id_po
 inner Join Barang C On A.kode_barcode=C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
WHERE  A.id_shipment = $invoice and A.id_po = $po and D.style LIKE '%$style%' and A.kriteria = 'mix_style'
Group BY   B.no_po, C.id_style
ORDER BY D.style";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}


function tampilkan_laporan_packing_header($po, $style){
  global $koneksi;

  $query = "SELECT po.no_po, style.style, barang.warna FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
  join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style
  where transaksi_packing.id_po = '$po' AND barang.id_style = '$style'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_packing_po_style_tanggal($po, $style, $tgl_awal, $tgl_akhir){
  global $koneksi;

  $query = "SELECT po.no_po, style.style, barang.warna, transaksi_packing.no_karton, transaksi_packing.tanggal, transaksi_packing.jam, transaksi_packing.id_po,
                  SUM(IF(barang.size='SS',1,0)) AS size_ss,
                  SUM(IF(barang.size='S',1,0)) AS size_s,
                  SUM(IF(barang.size='M',1,0)) AS size_m,
                  SUM(IF(barang.size='L',1,0)) AS size_l,
                  SUM(IF(barang.size='LL',1,0)) AS size_ll,
                  SUM(IF(barang.size='3L',1,0)) AS size_3l,
                  SUM(IF(barang.size='4L',1,0)) AS size_4l,
                  SUM(IF(barang.size='5L',1,0)) AS size_5l,
                  SUM(IF(barang.size='6L',1,0)) AS size_6l,
                  SUM(IF(barang.size='7L',1,0)) AS size_7l,
                  COUNT(barang.size) AS jumlah_size
                  FROM barang join transaksi_packing on barang.kode_barcode = transaksi_packing.kode_barcode
  join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style
  where transaksi_packing.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' AND transaksi_packing.id_po = '$po' AND style.style like '$style%'
  group by transaksi_packing.no_karton, transaksi_packing.id_po order by style.style";
$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing_po_tanggal($po, $tgl_awal, $tgl_akhir){
  global $koneksi;

  $query = "SELECT B.no_po, E.label, D.style, D.description, C.warna, A.no_karton, A.tanggal, A.jam,
            Sum(IF(C.size='SS', 1,0)) as size_ss,
            Sum(IF(C.size='S', 1,0)) as size_s,
            Sum(IF(C.size='M', 1,0)) as size_m,
            Sum(IF(C.size='L', 1,0)) as size_l,
            Sum(IF(C.size='LL', 1,0)) as size_ll,
            Sum(IF(C.size='3L', 1,0)) as size_3l,
            Sum(IF(C.size='4L', 1,0)) as size_4l,
            Sum(IF(C.size='5L', 1,0)) as size_5l,
            Sum(IF(C.size='6L', 1,0)) as size_6l,
            Sum(IF(C.size='7L', 1,0)) as size_7l,
            Count(C.size)jumlah_size, Count(Distinct A.no_karton) as karton
            From transaksi_packing A
            inner Join PO B On A.id_po=B.id_po
            inner Join Barang C On A.kode_barcode=C.kode_barcode
            inner Join Style D On C.id_style=D.id_style
            inner join label E on B.id_label=E.id_label
            WHERE A.id_po = $po AND ( A.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir')
            Group By  A.no_karton, C.id_style,  B.no_po
            Order By b.no_po, (IF(Sum(IF(C.size='ss', 1,0))>0,1,0)+IF(Sum(IF(C.size='S', 1,0))>0,1,0)+
            IF(Sum(IF(C.size='M', 1,0))>0,1,0)+IF(Sum(IF(C.size='L', 1,0))>0,1,0)+
            IF(Sum(IF(C.size='LL', 1,0))>0,1,0)+IF(Sum(IF(C.size='3L', 1,0))>0,1,0)+
            IF(Sum(IF(C.size='4L', 1,0))>0,1,0)+IF(Sum(IF(C.size='5L', 1,0))>0,1,0)+
            IF(Sum(IF(C.size='6L', 1,0))>0,1,0)+IF(Sum(IF(C.size='7L', 1,0))>0,1,0)), 
            A.kode_barcode asc, jumlah_size desc";
  
$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_kenzin(){
  global $koneksi;

  $query = "SELECT *, COUNT(barang.size) AS jumlah_size FROM transaksi_kenzin join barang on transaksi_kenzin.kode_barcode = barang.kode_barcode
  join po on po.id_po = transaksi_kenzin.id_po join style on barang.id_style = style.id_style

  group by no_po, size order by tanggal, no_po";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_laporan_packing(){
  global $koneksi;

  $query = "SELECT *, COUNT(barang.size) AS jumlah_size_packing FROM transaksi_packing join barang on transaksi_packing.kode_barcode = barang.kode_barcode
  join po on po.id_po = transaksi_packing.id_po join style on barang.id_style = style.id_style
  group by no_po, size order by tanggal, no_po";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}


function tampilkan_cetak_packing(){
  global $koneksi;

  $query = "SELECT * FROM transaksi_packing join barang on transaksi_packing.kode_barcode = barang.kode_barcode
  join style on barang.id_style = style.id_style group by transaksi_packing.id_po, style.id_style
  order by style.style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_cetak_packing2(){
  global $koneksi;

  $query = "SELECT transaksi_packing.id_po,  barang.id_style,  barang.warna FROM transaksi_packing join barang on transaksi_packing.kode_barcode = barang.kode_barcode
  join style on barang.id_style = style.id_style group by transaksi_packing.id_po, barang.id_style
  order by style.style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}

function tampilkan_balance_order_labelkenzin($po){
  global $koneksi; 

  $query = "SELECT  H.orc, h.kode_barcode, D.no_po, E.label, h.style, h.description, h.size, H.color, H.qty_order, ((IFNULL(A.qtya,0) - IFNULL(G.qtyg,0))-IFNULL(B.qtyb,0)-IFNULL(F.qtyc,0))stok_kenzin,
  IFNULL(B.qtyb,0) qtyp, IFNULL(F.qtyc,0) qtys, 
 ((IFNULL(A.qtya,0) - IFNULL(G.qtyg,0)) - H.qty_order)kekurangan_shipment
  from (
		SELECT A.orc, A.id_po, A.id_label, IFNULL(D.kode_barcode, 'Blm Ada Master') kode_barcode, A.id_style, C.style, C.description, B.size, A.color, B.qty_order FROM master_order A 
	  		JOIN ORDER_detail B ON A.id_order = B.id_order 
	  		JOIN style C ON A.id_style = C.id_style
	  		LEFT JOIN barang D on A.id_style = D.id_style AND B.size = D.size
  		group BY A.orc, C.id_style, B.size)H
  	LEFT OUTER JOIN( 
    	SELECT  A.orc, B.id_style, C.style, B.size, sum(qty) qtya FROM transaksi_kenzin A 
		 	join barang B ON A.kode_barcode = B.kode_barcode 
		   JOIN style C ON B.id_style = C.id_style
		group BY A.orc, B.id_style, B.size)A
  	ON H.orc = A.orc AND H.id_style = A.id_style AND H.size = A.size 
	Left Outer join (
  		SELECT A.orc, B.id_style, C.style, B.size, sum(qty) qtyg 
 	   FROM transaksi_ganti_label A
 	   	join barang B ON A.kode_barcode = B.kode_barcode 
		   JOIN style C ON B.id_style = C.id_style
 		group BY A.orc, B.id_style, B.size)G
	ON H.orc = G.orc AND H.id_style = G.id_style AND H.size = G.size 
  	Left Outer join (
    	SELECT A.orc, B.id_style, C.style, B.size, sum(qty) qtyb FROM transaksi_packing A
			join barang B ON A.kode_barcode = B.kode_barcode 
	   	JOIN style C ON B.id_style = C.id_style
  		group BY A.orc, B.id_style, B.size)B	
  	ON H.orc = B.orc AND H.id_style = B.id_style AND H.size = B.size 
  	Left Outer join (
   	SELECT A.orc, B.id_style, C.style, B.size, sum(qty) qtyc FROM transaksi_shipment A
			join barang B ON A.kode_barcode = B.kode_barcode 
	   	JOIN style C ON B.id_style = C.id_style
  		group BY A.orc, B.id_style, B.size)F			
	ON H.orc = F.orc AND H.id_style = F.id_style AND H.size = F.size
  INNER JOIN PO D ON H.id_po = D.id_po
  inner join LABEL E ON H.id_label = E.id_label
  WHERE D.no_po = '$po'
  order by H.orc, H.style ASC, H.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_orc($orc){
  global $koneksi; 

  $query = "SELECT A.costomer, A.barcode_number, A.orc, A.no_po, A.label, A.style, A.color, A.size, A.qty_order, 
  IFNULL(D.qty_qc_kensa,0) qty_qc_kensa, (IFNULL(D.qty_qc_kensa,0)-IFNULL(B.qty_tatami_in,0)) bal_qc_kensa 
  ,IFNULL(B.qty_tatami_in,0) qty_tatami_in, IFNULL(C.qty_tatami_out,0) qty_tatami_out, (IFNULL(B.qty_tatami_in,0)-IFNULL(C.qty_tatami_out,0)) outstanding,
   (A.qty_order-IFNULL(D.qty_qc_kensa,0)) balance_order FROM 
  (SELECT A.barcode_number, B.orc, B.no_po, C.style, A.size, A.qty_order, D.costomer, B.label, B.color FROM order_detail A join master_order B ON A.id_order = B.id_order JOIN style C ON B.id_style = C.id_style JOIN costomer D ON B.id_costomer = D.id_costomer) A
  LEFT OUTER JOIN 
  (SELECT kode_barcode, COUNT(kode_barcode) qty_tatami_in FROM transaksi_tatami_in GROUP BY kode_barcode)B
  ON A.barcode_number = B.kode_barcode
  LEFT OUTER JOIN 
  (SELECT kode_barcode, COUNT(kode_barcode) qty_tatami_out FROM transaksi_tatami_out GROUP BY kode_barcode)C
  ON A.barcode_number = C.kode_barcode
LEFT OUTER JOIN 
  (SELECT kode_barcode, COUNT(kode_barcode) qty_qc_kensa FROM transaksi_qc_kensa GROUP BY kode_barcode)D
  ON A.barcode_number = D.kode_barcode
  WHERE orc = '$orc' order BY size='10L', size='9L',
   size='8L', size='7L', size='6L', size='5L', size='4L', size='3L', size='LL', size='L', 
   size='M', size='S', size='SS'
";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_all($tanggal){
  global $koneksi; 

  $query = "SELECT A.costomer, ifnull(C.kode_barcode, '') kode_barcode, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size,  A.qty_order,
  (IFNULL(F.qty_qc_kensa, 0) - IFNULL(B.qty_tatami_in, 0) + IFNULL(H.qty_reject_tatami_qckensa, 0) - IFNULL(I.qty_reject_tatami_ganti_label, 0)) wip_qc_kensa, 
  (IFNULL(B.qty_tatami_in, 0) - IFNULL(C.qty_kenzin, 0) - IFNULL(G.qty_reject_tatami, 0) - IFNULL(I.qty_reject_tatami_ganti_label, 0)) wip_tatami,
 (IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin,
 (IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
 IFNULL(E.qty_shipment, 0) qty_shipment,
 (IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
   (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.qty_order,  A.`status`, D.costomer, B.barcode_number, D.barcode_costomer 
     FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
     JOIN style C ON A.id_style = C.id_style 
     JOIN costomer D ON A.id_costomer = D.id_costomer 
    GROUP BY A.orc, A.id_style, B.size) A 
   LEFT OUTER JOIN
   (SELECT A.kode_barcode, sum(A.qty) qty_tatami_in  
     FROM transaksi_tatami_in A JOIN order_detail B ON A.kode_barcode = B.barcode_number 
     JOIN master_order C ON B.id_order = C.id_order
     WHERE A.tanggal <= '$tanggal'
     GROUP BY B.barcode_number
   ) B
   ON A.barcode_number = B.kode_barcode
   LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, A.kode_barcode, SUM(A.qty) qty_kenzin 
   FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )C
  ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size 
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size 
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size  
    LEFT OUTER JOIN
   (SELECT A.kode_barcode, sum(A.qty) qty_qc_kensa 
     FROM transaksi_qc_kensa A JOIN order_detail B ON A.kode_barcode = B.barcode_number 
     JOIN master_order C ON B.id_order = C.id_order
     WHERE A.tanggal <= '$tanggal'
     GROUP BY B.barcode_number
   ) F
   ON A.barcode_number = F.kode_barcode
      LEFT OUTER JOIN
   (SELECT A.kode_barcode, sum(A.qty) qty_reject_tatami 
     FROM transaksi_reject_tatami A JOIN order_detail B ON A.kode_barcode = B.barcode_number 
     JOIN master_order C ON B.id_order = C.id_order
     WHERE A.tanggal <= '$tanggal' AND A.adjuzt = 'y' AND A.keterangan != 'ganti_label'
     GROUP BY B.barcode_number
   ) G
   ON A.barcode_number = G.kode_barcode
        LEFT OUTER JOIN
   (SELECT A.kode_barcode, sum(A.qty) qty_reject_tatami_qckensa 
     FROM transaksi_reject_tatami A JOIN order_detail B ON A.kode_barcode = B.barcode_number 
     JOIN master_order C ON B.id_order = C.id_order
     WHERE A.tanggal <= '$tanggal' AND A.adjuzt = 'y' AND A.to_reject = 'qc_kensa'
     GROUP BY B.barcode_number
   ) H
   ON A.barcode_number = H.kode_barcode
   LEFT OUTER JOIN
     (SELECT A.kode_barcode, sum(A.qty) qty_reject_tatami_ganti_label 
     FROM transaksi_reject_tatami A JOIN order_detail B ON A.kode_barcode = B.barcode_number 
     JOIN master_order C ON B.id_order = C.id_order
     WHERE A.tanggal <= '$tanggal' AND A.adjuzt = 'y' AND A.keterangan = 'ganti_label'
     GROUP BY B.barcode_number
   ) I
   ON A.barcode_number = I.kode_barcode
  WHERE  A.status = 'open'
   ORDER BY A.no_po, A.label, A.style, A.size='10L', A.size='9L', A.size='8L', A.size='7L', A.size='6L', A.size='5L', A.size='4L', A.size='3L', A.size='LL', A.size='L', A.size='M', A.size='S', A.size='SS', A.size";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_style($id_style, $tanggal, $no_po, $color){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size,  A.qty_order,
  IFNULL(C.qty_kenzin, 0) total_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
 IFNULL(D.qty_packing, 0) total_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
IFNULL(E.qty_shipment, 0) qty_shipment,
(IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
  (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
    FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
    JOIN style C ON A.id_style = C.id_style 
    JOIN costomer D ON A.id_costomer = D.id_costomer 
    LEFT OUTER JOIN size E on B.size = E.size
   GROUP BY A.orc, A.id_style, B.size) A 
 LEFT OUTER JOIN
  (SELECT A.orc, B.id_style, B.size, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
  FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
  WHERE A.tanggal <= '$tanggal'
  GROUP BY A.orc, A.kode_barcode
  )C
 ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size 
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.warna, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size 
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size  
  
   WHERE A.id_style = '$id_style' AND A.status = 'open' AND A.no_po like '%$no_po%' AND A.color like '%$color%'
   ORDER BY A.no_po, A.label, A.style, A.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_style2($id_style, $tanggal, $no_po, $color){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size, A.cup, A.qty_order,
  IFNULL(C.qty_kenzin, 0) total_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
 IFNULL(D.qty_packing, 0) total_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
IFNULL(E.qty_shipment, 0) qty_shipment,
(IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
  (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.cup, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
    FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
    JOIN style C ON A.id_style = C.id_style 
    JOIN costomer D ON A.id_costomer = D.id_costomer 
    LEFT OUTER JOIN size E on B.size = E.size AND ifnull(B.cup, '') = IFNULL(E.cup, '')
   GROUP BY A.orc, A.id_style, B.size, B.cup) A 
 LEFT OUTER JOIN
  (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
  FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
  WHERE A.tanggal <= '$tanggal'
  GROUP BY A.orc, A.kode_barcode
  )C
 ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size AND ifnull(A.cup, '') = ifnull(C.cup, '')
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size  AND IFNULL(A.cup, '') = IFNULL(D.cup, '')
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size AND IFNULL(A.cup, '') = IFNULL(E.cup, '')  
  
   WHERE A.id_style = '$id_style' AND A.status = 'open' AND A.no_po like '%$no_po%' AND A.color like '%$color%'
   ORDER BY A.no_po, A.label, A.style, A.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_po($po, $tanggal){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size,  A.qty_order,
  IFNULL(C.qty_kenzin, 0) total_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
 IFNULL(D.qty_packing, 0) total_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
IFNULL(E.qty_shipment, 0) qty_shipment,
(IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
  (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
    FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
    JOIN style C ON A.id_style = C.id_style 
    JOIN costomer D ON A.id_costomer = D.id_costomer 
    LEFT OUTER JOIN size E on B.size = E.size
   GROUP BY A.orc, A.id_style, B.size) A 
 LEFT OUTER JOIN
  (SELECT A.orc, B.id_style, B.size, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
  FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
  WHERE A.tanggal <= '$tanggal'
  GROUP BY A.orc, A.kode_barcode
  )C
 ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size 
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.warna, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size 
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size  
  
   WHERE A.no_po LIKE '%$po%' AND A.status = 'open'
   ORDER BY A.no_po, A.label, A.style, A.urutan";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_po2($po, $tanggal){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size, A.cup, A.qty_order,
  IFNULL(C.qty_kenzin, 0) total_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
 IFNULL(D.qty_packing, 0) total_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
IFNULL(E.qty_shipment, 0) qty_shipment,
(IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
  (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.cup, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
    FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
    JOIN style C ON A.id_style = C.id_style 
    JOIN costomer D ON A.id_costomer = D.id_costomer 
    LEFT OUTER JOIN size E on B.size = E.size AND ifnull(B.cup, '') = IFNULL(E.cup, '')
   GROUP BY A.orc, A.id_style, B.size, B.cup) A 
 LEFT OUTER JOIN
  (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
  FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
  WHERE A.tanggal <= '$tanggal'
  GROUP BY A.orc, A.kode_barcode
  )C
 ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size AND ifnull(A.cup, '') = ifnull(C.cup, '')
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size  AND IFNULL(A.cup, '') = IFNULL(D.cup, '')
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size AND IFNULL(A.cup, '') = IFNULL(E.cup, '')
  
   WHERE A.no_po LIKE '%$po%' AND A.status = 'open'
   ORDER BY A.no_po, A.label, A.style, A.urutan";
   
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_costomer($costomer, $tanggal){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size,  A.qty_order,
  IFNULL(C.qty_kenzin, 0) total_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
 IFNULL(D.qty_packing, 0) total_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
IFNULL(E.qty_shipment, 0) qty_shipment,
(IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
  (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
    FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
    JOIN style C ON A.id_style = C.id_style 
    JOIN costomer D ON A.id_costomer = D.id_costomer 
    LEFT OUTER JOIN size E on B.size = E.size
   GROUP BY A.orc, A.id_style, B.size) A 
 LEFT OUTER JOIN
  (SELECT A.orc, B.id_style, B.size, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
  FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
  WHERE A.tanggal <= '$tanggal'
  GROUP BY A.orc, A.kode_barcode
  )C
 ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size 
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.warna, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size 
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size  
  
   WHERE A.costomer = '$costomer' AND A.status = 'open'
   ORDER BY A.no_po, A.label, A.style, A.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_costomer2($costomer, $tanggal){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size, A.cup, A.qty_order,
  IFNULL(C.qty_kenzin, 0) total_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
 IFNULL(D.qty_packing, 0) total_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
IFNULL(E.qty_shipment, 0) qty_shipment,
(IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
  (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.cup, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
    FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
    JOIN style C ON A.id_style = C.id_style 
    JOIN costomer D ON A.id_costomer = D.id_costomer 
    LEFT OUTER JOIN size E on B.size = E.size AND ifnull(B.cup, '') = IFNULL(E.cup, '')
   GROUP BY A.orc, A.id_style, B.size, B.cup) A 
 LEFT OUTER JOIN
  (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
  FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
  WHERE A.tanggal <= '$tanggal'
  GROUP BY A.orc, A.kode_barcode
  )C
 ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size AND ifnull(A.cup, '') = ifnull(C.cup, '')
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size  AND IFNULL(A.cup, '') = IFNULL(D.cup, '')
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size AND IFNULL(A.cup, '') = IFNULL(E.cup, '')
  
   WHERE A.costomer = '$costomer' AND A.status = 'open'
   ORDER BY A.no_po, A.label, A.style, A.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_orc($orc, $tanggal){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size,  A.qty_order,
   IFNULL(C.qty_kenzin, 0) total_kenzin, 
 (IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
 (IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
  IFNULL(D.qty_packing, 0) total_packing, 
 (IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
 (IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
 IFNULL(E.qty_shipment, 0) qty_shipment,
 (IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
   (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
     FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
     JOIN style C ON A.id_style = C.id_style 
     JOIN costomer D ON A.id_costomer = D.id_costomer 
     LEFT OUTER JOIN size E on B.size = E.size
    GROUP BY A.orc, A.id_style, B.size) A 
  LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
   FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )C
  ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size   
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size 
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size  
  
   WHERE A.orc = '$orc' AND A.status = 'open'
   ORDER BY A.no_po, A.label, A.style, A.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_barcode_buyer_per_orc2($orc, $tanggal){
  global $koneksi; 

  $query = "SELECT A.costomer, C.kode_barcode, C.warna, A.id_order,A.no_po, A.label, A.orc, A.style, A.color, A.size, A.cup,  A.qty_order,
  IFNULL(C.qty_kenzin, 0) total_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(D.qty_packing, 0)) wip_kenzin, 
(IFNULL(C.qty_kenzin, 0) - IFNULL(A.qty_order, 0)) balance_kenzin, 
 IFNULL(D.qty_packing, 0) total_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(E.qty_shipment, 0)) wip_packing, 
(IFNULL(D.qty_packing, 0) - IFNULL(A.qty_order, 0)) balance_packing, 
IFNULL(E.qty_shipment, 0) qty_shipment,
(IFNULL(E.qty_shipment, 0) - IFNULL(A.qty_order, 0)) balance_shipment FROM
  (SELECT A.id_order, A.orc, A.no_po, A.label, C.style, A.id_style, A.color, B.size, B.cup, B.qty_order, A.`status`, D.costomer, B.barcode_number, D.barcode_costomer, E.urutan
    FROM master_order A JOIN order_detail B ON A.id_order = B.id_order 
    JOIN style C ON A.id_style = C.id_style 
    JOIN costomer D ON A.id_costomer = D.id_costomer 
    LEFT OUTER JOIN size E on B.size = E.size AND ifnull(B.cup, '') = IFNULL(E.cup, '')
   GROUP BY A.orc, A.id_style, B.size, B.cup) A 
 LEFT OUTER JOIN
  (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_kenzin 
  FROM transaksi_kenzin A JOIN barang B ON A.kode_barcode = B.kode_barcode 
  WHERE A.tanggal <= '$tanggal'
  GROUP BY A.orc, A.kode_barcode
  )C
 ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size AND ifnull(A.cup, '') = ifnull(C.cup, '')
    LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, B.warna, A.kode_barcode, SUM(A.qty) qty_packing 
   FROM transaksi_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   WHERE A.tanggal <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size  AND IFNULL(A.cup, '') = IFNULL(D.cup, '')
     LEFT OUTER JOIN
   (SELECT A.orc, B.id_style, B.size, B.cup, A.kode_barcode, SUM(A.qty) qty_shipment 
   FROM transaksi_shipment A JOIN barang B ON A.kode_barcode = B.kode_barcode 
   JOIN shipment C ON A.id_shipment = C.id_shipment
   WHERE C.inspection <= '$tanggal'
   GROUP BY A.orc, A.kode_barcode
   )E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size AND IFNULL(A.cup, '') = IFNULL(E.cup, '')
  
   WHERE A.orc = '$orc' AND A.status = 'open'
   ORDER BY A.no_po, A.label, A.style, A.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_popacking($orc){
  global $koneksi; 

  $query = "SELECT  h.kode_barcode, D.no_po, E.label, h.style, h.description, h.size, H.color, H.qty_order, IFNULL(B.qtyb,0) qtyp, IFNULL(F.qtyc,0) qtys, 
	((IFNULL(B.qtyb,0) + IFNULL(F.qtyc,0)) - H.qty_order)kekurangan_shipment
  	from (
		SELECT A.orc, A.id_po, A.id_label, IFNULL(D.kode_barcode, 'Blm Ada Master') kode_barcode, A.id_style, C.style, C.description, B.size, A.color, B.qty_order FROM master_order A
		JOIN ORDER_detail B ON A.id_order = B.id_order 
		JOIN style C ON A.id_style = C.id_style
		LEFT JOIN barang D on A.id_style = D.id_style AND B.size = D.size
  		group BY A.orc, C.id_style, B.size)H
	Left Outer join (
    	SELECT A.orc, B.id_style, C.style, B.size, sum(qty) qtyb FROM transaksi_packing A
			join barang B ON A.kode_barcode = B.kode_barcode 
	   	JOIN style C ON B.id_style = C.id_style
  			group BY A.orc, B.id_style, B.size)B	
  		ON H.orc = B.orc AND H.id_style = B.id_style AND H.size = B.size 
  	Left Outer join (
   	SELECT A.orc, B.id_style, C.style, B.size, sum(qty) qtyc FROM transaksi_shipment A
			join barang B ON A.kode_barcode = B.kode_barcode 
	   	JOIN style C ON B.id_style = C.id_style
  			group BY A.orc, B.id_style, B.size)F			
		ON H.orc = F.orc AND H.id_style = F.id_style AND H.size = F.size
  	INNER JOIN PO D ON H.id_po = D.id_po
  	INNER join LABEL E ON H.id_label = E.id_label
  	WHERE D.no_po = '$po'
  	order by H.orc, H.style ASC, H.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_balance_order_poshipment($po){
  global $koneksi; 

  $query = "SELECT  h.kode_barcode, D.no_po, E.label, h.style, h.description, h.size, H.color, H.qty_order,  IFNULL(F.qtyc,0) qtys, 
	(IFNULL(F.qtyc,0) - H.qty_order)kekurangan_shipment
  	from (
		SELECT A.orc, A.id_po, A.id_label, IFNULL(D.kode_barcode, 'Blm Ada Master') kode_barcode, A.id_style, C.style, C.description, B.size, A.color, B.qty_order FROM master_order A
		JOIN ORDER_detail B ON A.id_order = B.id_order 
		JOIN style C ON A.id_style = C.id_style
		LEFT JOIN barang D on A.id_style = D.id_style AND B.size = D.size
  		group BY A.orc, C.id_style, B.size)H
  	Left Outer join (
   	SELECT A.orc, B.id_style, C.style, B.size, sum(qty) qtyc FROM transaksi_shipment A
			join barang B ON A.kode_barcode = B.kode_barcode 
	   	JOIN style C ON B.id_style = C.id_style
  			group BY A.orc, B.id_style, B.size)F			
		ON H.orc = F.orc AND H.id_style = F.id_style AND H.size = F.size
  	INNER JOIN PO D ON H.id_po = D.id_po
  	INNER join LABEL E ON H.id_label = E.id_label
  	WHERE D.no_po = '$po'
  	order by H.orc, H.style ASC, H.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');  
  return $result;
}

function tampilkan_hasil_tatami_in_periode_hari($tglawal, $tglakhir){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, C.orc, C.no_po, C.label, D.style, C.color, B.size, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_tatami_in A 
   inner join order_detail B ON A.kode_barcode = B.barcode_number 
   inner JOIN master_order C ON B.id_order = C.id_order 
   INNER JOIN style D ON C.id_style = D.id_style
   INNER JOIN costomer E ON C.id_costomer = E.id_costomer
   WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir'
  GROUP BY A.tanggal, C.id_costomer, A.kode_barcode
  ORDER BY A.tanggal, E.costomer, C.orc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_tatami_reject_periode_hari($tglawal, $tglakhir){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, C.orc, C.no_po, C.label, D.style, C.color, B.size, A.kode_barcode, sum(A.qty) qtya, A.keterangan
  FROM transaksi_reject_tatami A 
   inner join order_detail B ON A.kode_barcode = B.barcode_number 
   inner JOIN master_order C ON B.id_order = C.id_order 
   INNER JOIN style D ON C.id_style = D.id_style
   INNER JOIN costomer E ON C.id_costomer = E.id_costomer
   WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir'
  GROUP BY A.tanggal, C.id_costomer, A.kode_barcode, A.keterangan
  ORDER BY A.tanggal, E.costomer, C.orc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_tatami_out_periode_hari($tglawal, $tglakhir){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, C.orc, C.no_po, C.label, D.style, C.color, B.size, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_tatami_out A 
   inner join order_detail B ON A.kode_barcode = B.barcode_number 
   inner JOIN master_order C ON B.id_order = C.id_order 
   INNER JOIN style D ON C.id_style = D.id_style
   INNER JOIN costomer E ON C.id_costomer = E.id_costomer
   WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir'
  GROUP BY A.tanggal, C.id_costomer, A.kode_barcode
  ORDER BY A.tanggal, E.costomer, C.orc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_laporan_hasil_shipment_awal($invoice){
  global $koneksi; 

  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.size, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_shipment A 
  inner JOIN master_order B ON A.orc = B.orc
  INNER JOIN barang C ON A.kode_barcode = C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
     WHERE A.id_shipment = $invoice
  GROUP BY B.no_po, B.orc, D.style, A.kode_barcode
  ORDER BY B.no_po, D.style, B.color, C.size='10L', C.size='9L',
   C.size='8L', C.size='7L', C.size='6L', C.size='5L', C.size='4L', C.size='3L', C.size='LL', C.size='L', 
   C.size='M', C.size='S', C.size='SS', C.size asc ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_packing_periode_hari($tglawal, $tglakhir){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, C.size, C.cup, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_packing A 
  inner JOIN master_order B ON A.orc = B.orc
  INNER JOIN barang C ON A.kode_barcode = C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
  JOIN size F on C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
     WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir'
  GROUP BY A.tanggal, B.id_costomer, A.kode_barcode
  ORDER BY B.no_po, D.style, C.warna, F.urutan, A.tanggal";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_packing_periode_hari_costomer($tglawal, $tglakhir, $id_costomer){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, C.size, C.cup, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_packing A 
  inner JOIN master_order B ON A.orc = B.orc
  INNER JOIN barang C ON A.kode_barcode = C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
  JOIN size F on C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
  WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir' AND B.id_costomer = $id_costomer
  GROUP BY  A.orc, A.kode_barcode 
  ORDER BY B.no_po, D.style, C.warna, F.urutan, A.tanggal ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_kenzin_periode_hari($tglawal, $tglakhir){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, B.orc, C.warna, B.no_po, B.label, D.style, B.color, C.size, C.cup, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_kenzin A 
  inner JOIN master_order B ON A.orc = B.orc
  INNER JOIN barang C ON A.kode_barcode = C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
  JOIN size F on C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
     WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir' 
  GROUP BY A.tanggal, B.id_costomer, A.kode_barcode
  ORDER BY  A.tanggal, B.no_po, B.orc, D.style, C.warna, F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_kenzin_periode_hari_costomer($tglawal, $tglakhir, $id_costomer){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, B.orc, C.warna, B.no_po, B.label, D.style, B.color, C.size, C.cup, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_kenzin A 
  inner JOIN master_order B ON A.orc = B.orc
  INNER JOIN barang C ON A.kode_barcode = C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
  JOIN size F on C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
  WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir' AND B.id_costomer = $id_costomer
  GROUP BY  A.orc, A.kode_barcode 
  ORDER BY B.no_po, B.orc, D.style, C.warna, F.urutan, A.tanggal ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function tampilkan_laporan_daily_production_scan($tgl, $table, $orc, $style, $costomer, $no_po, $category){
  global $koneksi; 

  $query = "SELECT A.id_order_detail, A.costomer, A.no_po, A.orc, A.style, A.color, A.size, A.cup, IFNULL(B.total_order, 0) total_order,IFNULL(C.total_output,0) total_output,  IFNULL(A.daily,0) daily, A.item
    FROM 
  (SELECT C.id_order_detail, F.costomer, D.no_po, D.orc, E.style, D.color, C.size, C.cup , SUM(qty) daily, E.item
    FROM $table A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    JOIN master_order D ON C.id_order = D.id_order
    JOIN style E ON D.id_style = E.id_style
    JOIN costomer F ON D.id_costomer = F.id_costomer
    JOIN items G ON E.item = G.item
    WHERE A.tanggal = '$tgl' AND D.orc LIKE '%$orc%' AND E.style LIKE '%$style%' AND F.costomer LIKE '%$costomer%'
    AND D.no_po like '%$no_po%' AND G.category like '%$category%'
    GROUP BY D.orc, D.id_style, D.color, C.size, C.cup)A
    LEFT OUTER JOIN
  (SELECT A.id_order_detail, SUM(A.qty_isi_bundle) total_order FROM master_bundle A
  GROUP BY A.id_order_detail)B
  ON A.id_order_detail = B.id_order_detail
    LEFT OUTER JOIN
  (SELECT B.id_order_detail, SUM(A.qty) total_output FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    WHERE A.tanggal <= '$tgl'
    GROUP BY B.id_order_detail)C
  ON A.id_order_detail = C.id_order_detail
  ORDER BY A.costomer, A.orc, A.style, A.color, A.id_order_detail ASC";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_laporan_daily_production_scan_line($tgl, $table, $orc, $style, $costomer, $no_po, $category, $line){
  global $koneksi; 

  $query = "SELECT A.id_order_detail, A.line, A.costomer, A.no_po, A.orc, A.style, A.color, A.size, A.cup, IFNULL(B.total_order, 0) total_order,IFNULL(C.total_output,0) total_output,  IFNULL(A.daily,0) daily, A.item
    FROM 
  (SELECT C.id_order_detail, A.line, F.costomer, D.no_po, D.orc, E.style, D.color, C.size, C.cup , SUM(qty) daily, E.item
    FROM $table A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    JOIN master_order D ON C.id_order = D.id_order
    JOIN style E ON D.id_style = E.id_style
    JOIN costomer F ON D.id_costomer = F.id_costomer
    JOIN items G ON E.item = G.item
    WHERE A.tanggal = '$tgl' AND D.orc LIKE '%$orc%' AND E.style LIKE '%$style%' AND F.costomer LIKE '%$costomer%'
    AND D.no_po like '%$no_po%' AND G.category like '%$category%'
    GROUP BY B.id_order_detail, A.line)A
    LEFT OUTER JOIN
  (SELECT A.id_order_detail, SUM(A.qty_isi_bundle) total_order FROM master_bundle A
  GROUP BY A.id_order_detail)B
  ON A.id_order_detail = B.id_order_detail
    LEFT OUTER JOIN
  (SELECT B.id_order_detail, A.line, SUM(A.qty) total_output FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    WHERE A.tanggal <= '$tgl'
    GROUP BY B.id_order_detail, A.line)C
  ON A.id_order_detail = C.id_order_detail
  GROUP by A.id_order_detail, A.line
  ORDER BY A.line, A.costomer, A.orc, A.style, A.color, A.id_order_detail ASC";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_qcfinal_periode_hari($tglawal, $tglakhir){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.size, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_qcfinal A 
  inner JOIN master_order B ON A.orc = B.orc
  INNER JOIN barang C ON A.kode_barcode = C.kode_barcode
  INNER JOIN style D ON C.id_style = D.id_style
  INNER JOIN costomer E ON B.id_costomer = E.id_costomer
     WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir'
  GROUP BY A.tanggal, B.id_costomer, B.orc, A.kode_barcode
  ORDER BY A.tanggal, E.costomer, D.style, B.orc, B.no_po, B.label, D.style, C.size='10L', C.size='9L',
   C.size='8L', C.size='7L', C.size='6L', C.size='5L', C.size='4L', C.size='3L', C.size='LL', C.size='L', 
   C.size='M', C.size='S', C.size='SS', C.size asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_hasil_qc_kensa_periode_hari($tglawal, $tglakhir){
  global $koneksi; 

  $query = "SELECT A.tanggal, E.costomer, C.orc, C.no_po, C.label, D.style, C.color, B.size, A.kode_barcode, sum(A.qty) qtya
  FROM transaksi_qc_kensa A 
   inner join order_detail B ON A.kode_barcode = B.barcode_number 
   inner JOIN master_order C ON B.id_order = C.id_order 
   INNER JOIN style D ON C.id_style = D.id_style
   INNER JOIN costomer E ON C.id_costomer = E.id_costomer
   WHERE A.tanggal BETWEEN '$tglawal' AND '$tglakhir'
  GROUP BY A.tanggal, C.id_costomer, A.kode_barcode
  ORDER BY A.tanggal, E.costomer, C.orc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_laporan_ganti_label($tgl){
  global $koneksi; 

  $query = "SELECT E.no_po, F.label, A.ke_label, A.kode_barcode, D.style, C.warna, C.size, SUM(A.qty) qtya FROM transaksi_ganti_label A 
          INNER JOIN master_order B ON A.orc = B.orc
          inner join barang C on A.kode_barcode=C.kode_barcode
          inner join style d on c.id_style=d.id_style
          inner JOIN po E ON B.id_po = E.id_po
          INNER JOIN Label F ON B.id_label = F.id_label 
          WHERE A.tanggal = '$tgl'
          GROUP BY A.orc, A.ke_label,  A.kode_barcode      
          order BY A.orc, A.ke_label, D.style, A.kode_barcode asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}



function tampilkan_laporan_stok_packing($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx
  From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
   
    WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'
  Group By  A.no_trx, C.id_style,  b.orc
  ORDER BY B.orc desc";
  
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing2($tgl, $orc, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal, A.jam, 
  $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok
 From transaksi_packing A
   JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
   JOIN size F on C.size = F.size
  
   WHERE A.tanggal <= '$tgl' AND A.orc = '$orc' AND A.shipment = 'n'
   AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'
 Group By  A.no_trx, C.id_style,  b.orc
 ORDER BY B.orc, IF(A.kelompok = 'mix', A.no_trx, 0), F.urutan, jumlah_size desc, A.tanggal asc, A.jam asc";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing_mix_style4($tgl, $no_trx, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal, A.jam, 
  $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok
 From transaksi_packing A
   JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
   JOIN size F on C.size = F.size AND IFNULL(C.cup, '' ) = IFNULL(F.cup, '') 
  
   WHERE A.tanggal <= '$tgl' AND A.no_trx = '$no_trx' AND A.shipment = 'n'
   AND A.kelompok = 'mix_style' AND B.status = 'open' 
 Group By  A.no_trx, C.id_style,  b.orc
 ORDER BY B.orc, F.urutan, jumlah_size desc, A.tanggal asc, A.jam asc";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing3($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx
  From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
     LEFT OUTER JOIN size F on C.size = F.size AND IFNULL(C.cup, '' ) = IFNULL(F.cup, '')
   
    WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'
  Group By  A.no_trx, C.id_style,  b.orc
  ORDER BY B.orc desc";
  
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing4($tgl, $orc, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal, A.jam, 
   $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok
  From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F on C.size = F.size AND IFNULL(C.cup, '' ) = IFNULL(F.cup, '')
   
    WHERE A.tanggal <= '$tgl' AND A.orc like '%$orc%' AND A.shipment = 'n'
    AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'
  Group By  A.no_trx, C.id_style,  b.orc
  ORDER BY B.orc, IF(A.kelompok = 'mix', A.no_trx, 0), F.urutan, jumlah_size desc, A.tanggal asc, A.jam asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing_mix_color($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx
  From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
   
    WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_color' AND B.status = 'open'
  Group By  A.no_trx, C.id_style
  ORDER BY B.orc desc";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing_mix_color2($tgl, $orc, $costomer, $no_po, $style, $no_trx2, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal, A.jam, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan, A.kelompok
    From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
    WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_color' AND A.no_trx = $no_trx2 AND B.status = 'open'
    Group By A.no_trx, A.orc
  ORDER BY A.orc, IF(A.kelompok = 'mix', A.no_trx, 0), F.urutan, jumlah_size desc, A.tanggal asc, A.jam asc
  ";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing_mix_style($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx
  From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
   
    WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_style' AND B.status = 'open'
  Group By  A.no_trx
  ORDER BY B.orc desc";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing_mix_style2($tgl, $orc, $costomer, $no_po, $style, $no_trx3, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal, A.jam, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan, A.kelompok
    From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
    WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_style' AND A.no_trx = $no_trx3 AND B.status = 'open'
    Group By A.no_trx, A.orc
  ORDER BY A.orc, IF(A.kelompok = 'mix', A.no_trx, 0), F.urutan, jumlah_size desc, A.tanggal asc, A.jam asc
  ";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_stok_packing_mix_style3($tgl, $costomer){
  global $koneksi;
  
  $query = "  SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx
  From transaksi_packing A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
     LEFT OUTER JOIN size F on C.size = F.size AND IFNULL(C.cup, '' ) = IFNULL(F.cup, '')
   
    WHERE A.tanggal <= '$tgl'  AND E.costomer LIKE '%$costomer%'
  AND  A.shipment = 'n' 
  AND A.kelompok = 'mix_style' AND B.status = 'open'
  Group By  A.no_trx
  ORDER BY B.orc desc";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function cek_jumlah_size_orc($tgl, $orc){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND A.shipment = 'n' 
  AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'
   ";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_orc2($tgl, $orc){
  global $koneksi;
   
  $query = "SELECT C.size, C.cup size
  FROM transaksi_packing A
 JOIN master_order B On A.orc = B.orc
 JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.tanggal <= '$tgl' AND A.orc = '$orc' AND A.shipment = 'n' 
  AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'
  GROUP BY C.size, C.cup
   ";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}
function get_size_orc($tgl, $orc): array {
    global $koneksi;

    $sizes = [];

    $query = "
        SELECT CONCAT('size_', LOWER(REPLACE(REPLACE(C.size,'-','_'),'/','_'))) as detail_size
        FROM transaksi_packing A
        JOIN master_order B ON A.orc = B.orc
        JOIN Barang C ON A.kode_barcode = C.kode_barcode
        WHERE A.tanggal <= '$tgl'
        AND A.orc = '$orc'
        AND A.shipment = 'n'
        AND A.kelompok NOT IN ('mix_color','mix_style')
        AND B.status = 'open'
        GROUP BY C.size, C.cup
    ";

    $result = mysqli_query($koneksi, $query);

    while($row = mysqli_fetch_assoc($result)){
        $sizes[] = $row['detail_size'];
    }

    return $sizes;
}

function cek_jumlah_size_packing_notmix($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'";
 
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_packing_notmix2($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
   
  $query = "SELECT C.size, C.cup
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok NOT IN ('mix_color','mix_style') AND B.status = 'open'
  group by C.size, C.cup";
 
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_packing_mix_color($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_color' AND B.status = 'open'";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_packing_mix_color2($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
   
  $query = "SELECT 
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_color' AND B.status = 'open'";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_packing_mix_style($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND B.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_style' AND B.status = 'open'";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}


function cek_jumlah_size_packing_mix_style2($tgl, $no_trx){
  global $koneksi;
   
  $query = "SELECT C.size, C.cup
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.no_trx LIKE '%$no_trx%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_style' AND B.status = 'open'
  GROUP BY C.size, C.cup";

  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function tampilkan_size_transaksi_packing_tarikpl_bundle($orc, $costomer, $no_po, $style){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(replace(C.size, '-', '_'), '/', '_'))), lower(TRIM(C.cup)))) as total_size, 
  CONCAT('SUM(IF(C.size=&#39;', TRIM(C.size), '&#39; AND C.cup=&#39;', TRIM(C.cup), '&#39;, A.qty,0)) as size_detail', 
  lower(trim(replace(replace(C.size, '-', '_'), '/', '_'))), lower(TRIM(C.cup))) AS sum_size FROM transaksi_packing_bundle A
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN style E on D.id_style = E.id_style
  join costomer F on D.id_costomer = F.id_costomer
LEFT OUTER JOIN size G ON C.size = G.size AND C.cup = G.cup
JOIN hd_transaksi_packing_bundle H ON A.no_trx = H.no_trx
  WHERE D.orc LIKE '%$orc%' AND D.id_costomer = $costomer
  AND D.no_po LIKE '%$no_po%' AND E.style LIKE '%$style%'
  AND D.status = 'open' AND H.status_trx = 'packing'
  ORDER BY G.urutan";
 

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing_tarikpl($orc, $costomer, $no_po, $style){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(B.size, '-', '_'))))) as total_size, 
  CONCAT('size_', lower(trim(replace(B.size, '-', '_')))) as size_detail, 
    CONCAT('SUM(IF(B.size=&#39;', B.size, '&#39;, A.qty,0)) as size_', lower(trim(replace(B.size, '-', '_')))) AS sum_size FROM transaksi_packing A
    JOIN barang B ON A.kode_barcode = B.kode_barcode
    JOIN master_order C ON A.orc = C.orc
    JOIN style D on B.id_style = D.id_style
    join costomer E on C.id_costomer = E.id_costomer
    JOIN size F ON B.size = F.size
  WHERE A.orc LIKE '%$orc%' AND C.id_costomer = $costomer
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND C.status = 'open'
  ORDER BY F.urutan";
  

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing_tarikpl2($orc, $costomer, $no_po, $style){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))))) as total_size,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as size_detail, 
    CONCAT('SUM(IF(B.size=&#39;', TRIM(B.size), '&#39; AND B.cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;, A.qty,0)) as size_', 
    lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) AS sum_size FROM transaksi_packing A
    JOIN barang B ON A.kode_barcode = B.kode_barcode
    JOIN master_order C ON A.orc = C.orc
    JOIN style D on B.id_style = D.id_style
    join costomer E on C.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.orc LIKE '%$orc%' AND C.id_costomer = $costomer
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND C.status = 'open'
  ORDER BY F.urutan";
  

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_kenzin_belum_shipment($orc, $id_costomer, $no_po, $style, $kelompok, $color, $checkstyle){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))))) as total_size,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as size_detail, 
    CONCAT('SUM(IF(B.size=&#39;', TRIM(B.size), '&#39; AND B.cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;, A.qty,0)) as size_', 
    lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) AS sum_size FROM transaksi_kenzin A
    JOIN barang B ON A.kode_barcode = B.kode_barcode
    JOIN master_order C ON A.orc = C.orc
    JOIN style D on B.id_style = D.id_style
    join costomer E on C.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
    LEFT OUTER JOIN transaksi_packing G ON A.no_trx = G.no_before AND A.orc = G.orc AND A.kode_barcode = G.kode_barcode";

  if($checkstyle == 'tidak'){
    if($kelompok != ''){
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND A.kelompok = '$kelompok' AND B.warna like '%$color%'";
    }else{
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND B.warna like '%$color%'";
    }
  }else{
    if($kelompok != ''){
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style = '$style' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND A.kelompok = '$kelompok' AND B.warna like '%$color%'";
    }else{
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style = '$style' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND B.warna like '%$color%'";
    }
    
  }
 
  $query .= " ORDER BY F.urutan";
  

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_kenzin_belum_shipment2($id_costomer, $orc, $style, $no_po, $kelompok, $color, $checkstyle){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_kenzin A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
     LEFT OUTER JOIN transaksi_packing G ON A.no_trx = G.no_before AND A.orc = G.orc AND A.kode_barcode = G.kode_barcode";
     if($checkstyle == 'tidak'){
    if($kelompok != ''){
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND A.kelompok = '$kelompok' AND B.warna like '%$color%'";
    }else{
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND B.warna like '%$color%'";
    }
  }else{
    if($kelompok != ''){
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style = '$style' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND A.kelompok = '$kelompok' AND B.warna like '%$color%'";
    }else{
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style = '$style' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND B.warna like '%$color%'";
    }
  }
  $query .= " GROUP BY B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function cek_jumlah_transaksi_kenzin_belum_shipment($id_costomer, $orc, $style, $no_po, $kelompok, $color, $checkstyle){
  global $koneksi; 

  $query = "SELECT B.size, B.cup FROM transaksi_kenzin A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
     LEFT OUTER JOIN transaksi_packing G ON A.no_trx = G.no_before AND A.orc = G.orc AND A.kode_barcode = G.kode_barcode";
     
  if($checkstyle == 'tidak'){
    if($kelompok != ''){
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND A.kelompok = '$kelompok' AND B.warna like '%$color%'";
    }else{
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND B.warna like '%$color%'";
    }
  }else{
    if($kelompok != ''){
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style = '$style' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND A.kelompok = '$kelompok' AND B.warna like '%$color%'";
    }else{
      $query .= " WHERE IFNULL(G.shipment, 'n') = 'n' and C.status = 'open' AND C.no_po LIKE '%$no_po%' AND D.style = '$style' 
      AND A.orc LIKE '%$orc%' AND C.id_costomer = $id_costomer  AND A.no_trx >= 10331 AND B.warna like '%$color%'";
    }
  }
  $query .= " GROUP BY B.size, B.cup";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function tampilkan_size_transaksi_kenzin_tarik_packing($costomer, $no_po, $style){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(B.size, '-', '_'))))) as total_size, 
  CONCAT('size_', lower(trim(replace(B.size, '-', '_')))) as size_detail, 
    CONCAT('SUM(IF(B.size=&#39;', B.size, '&#39;, A.qty,0)) as size_', lower(trim(replace(B.size, '-', '_')))) AS sum_size FROM transaksi_kenzin A
    JOIN barang B ON A.kode_barcode = B.kode_barcode
    JOIN master_order C ON A.orc = C.orc
    JOIN style D on B.id_style = D.id_style
    join costomer E on C.id_costomer = E.id_costomer
    JOIN size F ON B.size = F.size
  WHERE E.Costomer like '%$costomer%' AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.status_kenzin = 'kenzin'
  AND C.status = 'open'
  ORDER BY F.urutan";
  

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_to_packing($pl, $no_po, $style, $orc){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', 
  lower(trim(replace(B.size, '-', '_'))))) as total_size, 
  CONCAT('size_', lower(trim(replace(B.size, '-', '_')))) as size_detail, 
  CONCAT('SUM(IF(B.size=&#39;', B.size, '&#39;, A.qty,0)) as size_',
   lower(trim(replace(B.size, '-', '_')))) AS sum_size FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D on B.id_style = D.id_style
  JOIN size F ON B.size = F.size
  WHERE  A.id_shipment = $pl AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.orc LIKE '%$orc%'
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_to_packing2($pl, $no_po, $style, $orc){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))))) as total_size,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as size_detail, 
    CONCAT('SUM(IF(B.size=&#39;', TRIM(B.size), '&#39; AND B.cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;, A.qty,0)) as size_', 
    lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) AS sum_size FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D on B.id_style = D.id_style
	LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE  A.id_shipment = $pl AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.orc LIKE '%$orc%'
  GROUP BY B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(B.size, '-', '_'))))) as total_size, 
  CONCAT('SUM(IF(C.size=&#39;', B.size, '&#39;, A.qty,0)) as size_', lower(trim(replace(B.size, '-', '_')))) AS sum_size FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D on B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  JOIN size F ON B.size = F.size
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND C.status = 'open'
  ORDER BY F.urutan";
  

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing2($tgl, $orc, $costomer, $no_po, $style){
  global $koneksi; 

  $query = "SELECT CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size, 
  CONCAT('SUM(IF(C.size=&#39;', TRIM(B.size), '&#39; AND C.cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;, A.qty,0)) as size_', 
     lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) AS sum_size FROM transaksi_packing A
   JOIN barang B ON A.kode_barcode = B.kode_barcode
   JOIN master_order C ON A.orc = C.orc
   JOIN style D on B.id_style = D.id_style
   join costomer E on C.id_costomer = E.id_costomer
   JOIN size F ON B.size = F.size
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND C.status = 'open'
  GROUP BY B.size, B.cup
  ORDER BY F.urutan";
  

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing_mixstyle($tgl, $costomer){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(B.size, '-', '_'))))) as total_size, 
  CONCAT('SUM(IF(C.size=&#39;', B.size, '&#39;, A.qty,0)) as size_', lower(trim(replace(B.size, '-', '_')))) AS sum_size FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D on B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  JOIN size F ON B.size = F.size
  WHERE A.tanggal <= '$tgl' AND E.costomer LIKE '%$costomer%' AND A.shipment = 'n'
  AND A.kelompok = 'mix_style' AND C.status = 'open'
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing_mixstyle2($tgl, $costomer){
  global $koneksi; 

  $query = "SELECT CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size, 
  CONCAT('SUM(IF(C.size=&#39;', TRIM(B.size), '&#39; AND C.cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;, A.qty,0)) as size_', 
     lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) AS sum_size FROM transaksi_packing A
   JOIN barang B ON A.kode_barcode = B.kode_barcode
   JOIN master_order C ON A.orc = C.orc
   JOIN style D on B.id_style = D.id_style
   join costomer E on C.id_costomer = E.id_costomer
   LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '') 
  WHERE A.tanggal <= '$tgl' AND E.costomer LIKE '%$costomer%' AND A.shipment = 'n'
  AND A.kelompok = 'mix_style' AND C.status = 'open'
  GROUP BY B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function tampilkan_size_transaksi_packing_mixcolor($tgl, $orc, $costomer, $no_po, $style, $no_trx2){
  global $koneksi; 

  $query = "SELECT distinct(B.size) as ukuran,
  CONCAT('size_', lower(trim(B.size))) as detail_size,
  CONCAT('total_', lower(trim(B.size))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(B.size)),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D on B.id_style = D.id_style
  JOIN costomer E on C.id_costomer = E.id_costomer
  JOIN size F ON B.size = F.size
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND A.no_trx = $no_trx2 AND kelompok = 'mix_color' AND C.status = 'open'
  ORDER BY F.urutan";
  

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing_mixstyle_notrx($tgl, $orc, $costomer, $no_po, $style, $no_trx3){
  global $koneksi; 

  $query = "SELECT distinct(B.size) as ukuran,
  CONCAT('size_', lower(trim(B.size))) as detail_size,
  CONCAT('total_', lower(trim(B.size))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(B.size)),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D on B.id_style = D.id_style
  JOIN costomer E on C.id_costomer = E.id_costomer
  JOIN size F ON B.size = F.size
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND A.no_trx = $no_trx3 AND kelompok = 'mix_style' AND C.status = 'open'
  ORDER BY F.urutan";
 

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing_mixstyle_notrx2($tgl, $no_trx){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.tanggal <= '$tgl' AND A.no_trx = '$no_trx' AND A.shipment = 'n' AND
  A.kelompok = 'mix_style' AND C.status = 'open'
  group by B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function tampilkan_size_transaksi_packing_orc($tgl, $orc){
  global $koneksi; 

  $query = "SELECT distinct(B.size) as ukuran,
  CONCAT('size_', lower(trim(replace(B.size, '-', '_')))) as detail_size,
  CONCAT('total_', lower(trim(replace(B.size, '-', '_')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(B.size, '-', '_'))),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN size F ON B.size = F.size
  WHERE A.tanggal <= '$tgl' AND A.orc = '$orc' AND A.shipment = 'n' AND
  A.kelompok NOT IN ('mix_color','mix_style') AND C.status = 'open'
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_packing_orc2($tgl, $orc){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.tanggal <= '$tgl' AND A.orc = '$orc' AND A.shipment = 'n' AND
  A.kelompok NOT IN ('mix_color','mix_style') AND C.status = 'open'
  group by B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function tampilkan_size_transaksi_packing_orc_mix_style($tgl, $orc){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.tanggal <= '$tgl' AND A.orc = '$orc' AND A.shipment = 'n' AND
  A.kelompok = 'mix_style' AND C.status = 'open'
  group by B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment($id_shipment){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(B.size, '-', '_'))))) as total_size, 
  CONCAT('SUM(IF(C.size=&#39;', B.size, '&#39;, A.qty,0)) as size_', lower(trim(replace(B.size, '-', '_')))) AS sum_size  
  FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D on B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  JOIN size F ON B.size = F.size
  WHERE A.id_shipment = $id_shipment 
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment2($id_shipment){
  global $koneksi; 

  $query = "SELECT distinct(CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))))) as total_size,
  CONCAT('SUM(IF(C.size=&#39;', TRIM(B.size), '&#39; AND C.cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;, A.qty,0)) as size_', 
  lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) AS sum_size, 
  CONCAT('SUM(IF(C.size=&#39;', TRIM(B.size), '&#39; AND C.cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;, A.qty*(SELECT MAX(weight) FROM barang WHERE id_style = C.id_style AND size=&#39;', TRIM(B.size), '&#39; AND cup=&#39;', TRIM(ifnull(B.cup,'')), '&#39;) ,0))')
   AS weight_size
FROM transaksi_shipment A
JOIN barang B ON A.kode_barcode = B.kode_barcode
JOIN master_order C ON A.orc = C.orc
JOIN style D on B.id_style = D.id_style
join costomer E on C.id_costomer = E.id_costomer
LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.id_shipment = $id_shipment 
  group by B.size, B.cup
  ORDER BY F.urutan";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function tampilkan_laporan_packinglist_header($id_shipment){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx
  From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
   
    WHERE A.id_shipment = $id_shipment AND A.kelompok != 'mix_style'
  Group By A.no_trx, C.id_style,  b.orc
  ORDER BY B.no_po, D.style, B.color, B.orc desc";
  
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_packinglist_header2($id_shipment){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx
  From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
     LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
     WHERE A.id_shipment = $id_shipment AND A.kelompok != 'mix_style'
  Group By A.no_trx, C.id_style,  b.orc
  ORDER BY B.no_po, D.style, B.color, B.orc desc
  ";
 
  
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_packinglist_header_mixstyle($id_shipment){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.no_po, A.no_trx
  From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
   
    WHERE A.id_shipment = $id_shipment AND A.kelompok = 'mix_style'
  Group By A.no_trx
  ORDER BY B.orc desc";
  
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_packinglist_header_mixstyle2($id_shipment){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.no_po, A.no_trx
  From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
   JOIN Barang C On A.kode_barcode = C.kode_barcode
     JOIN Style D On C.id_style = D.id_style
     JOIN costomer E ON B.id_costomer = E.id_costomer
     LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
   
    WHERE A.id_shipment = $id_shipment AND A.kelompok = 'mix_style'
  Group By A.no_trx
  ORDER BY B.orc desc";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}


function cek_jumlah_size_invoice_not_mixstyle($id_shipment){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.kelompok != 'mix_style'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_invoice_not_mixstyle2($id_shipment){
  global $koneksi;
   
  $query = "SELECT C.size, C.cup
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.kelompok != 'mix_style'
  GROUP BY C.size, C.cup";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_transaksi_packing_mixstyle($tgl, $costomer){
  global $koneksi; 

  $query = "SELECT A.kode_barcode FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  join costomer E on C.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND E.costomer LIKE '%$costomer%' AND A.shipment = 'n'
  AND A.kelompok = 'mix_style' AND C.status = 'open'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}


function cek_jumlah_size_transaksi_packing_not_mixstyle($tgl, $costomer){
  global $koneksi; 

  $query = "SELECT A.kode_barcode FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  join costomer E on C.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND E.costomer LIKE '%$costomer%' AND A.shipment = 'n'
  AND A.kelompok != 'mix_style'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_size_transaksi_packing($tgl, $costomer){
  global $koneksi; 

  $query = "SELECT A.kode_barcode FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  join costomer E on C.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND E.costomer LIKE '%$costomer%' AND A.shipment = 'n' AND
  C.status = 'open'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_size_notrx_packing_mixcolor($tgl, $orc, $costomer, $no_po, $style, $no_trx2){
  global $koneksi; 

  $query = "SELECT A.kode_barcode FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  join style D on B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND A.no_trx = $no_trx2 AND A.kelompok = 'mix_color' AND C.status = 'open'";
 

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_size_notrx_packing_mixstyle($tgl, $orc, $costomer, $no_po, $style, $no_trx3){
  global $koneksi; 

  $query = "SELECT A.kode_barcode FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  join style D on B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tgl' AND A.orc LIKE '%$orc%' AND E.costomer LIKE '%$costomer%'
  AND C.no_po LIKE '%$no_po%' AND D.style LIKE '%$style%' AND A.shipment = 'n'
  AND A.no_trx = $no_trx3 AND A.kelompok = 'mix_style' AND C.status = 'open'";
 

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_size_invoice_mixstyle($id_shipment){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.kelompok = 'mix_style'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_invoice_mixstyle2($id_shipment){
  global $koneksi;
   
  $query = "SELECT C.size, C.cup
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.kelompok = 'mix_style'
  GROUP BY C.size, C.cup";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_orc_invoice($id_shipment, $orc){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND B.status = 'open'
  AND A.kelompok NOT IN ('mix_color','mix_style')";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_orc_invoice2($id_shipment, $orc){
  global $koneksi;
   
  $query = "SELECT C.size, C.cup
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND B.status = 'open'
  AND A.kelompok NOT IN ('mix_color','mix_style')
  GROUP BY C.size, C.cup";
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_notrx_invoice_mixstyle($id_shipment, $no_trx2){
  global $koneksi;
   
  $query = "SELECT distinct(C.size) size
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.no_trx = $no_trx2";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function cek_jumlah_size_notrx_invoice_mixstyle2($id_shipment, $no_trx2){
  global $koneksi;
   
  $query = "SELECT C.size, C.cup
   FROM transaksi_shipment A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  WHERE A.id_shipment = '$id_shipment' AND A.no_trx = $no_trx2
  GROUP BY C.size, C.cup";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
}
}

function tampilkan_size_transaksi_shipment_orc_invoice($id_shipment, $orc){
  global $koneksi; 

  $query = "SELECT distinct(B.size) as ukuran,
  CONCAT('size_', lower(trim(replace(B.size, '-', '_')))) as detail_size,
  CONCAT('total_', lower(trim(replace(B.size, '-', '_')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(B.size, '-', '_'))),'&#39;]') as pilih_size
    FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN size F ON B.size = F.size
  WHERE A.id_shipment = $id_shipment AND A.orc = '$orc' AND A.kelompok != 'mix_style'
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_orc_invoice2($id_shipment, $orc){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.id_shipment = $id_shipment AND A.orc = '$orc' AND A.kelompok != 'mix_style'
 GROUP BY B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_orc_invoice_mixstyle($id_shipment, $no_trx2){
  global $koneksi; 

  $query = "SELECT distinct(B.size) as ukuran,
  CONCAT('size_', lower(trim(B.size))) as detail_size,
  CONCAT('total_', lower(trim(B.size))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(B.size)),'&#39;]') as pilih_size
    FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN size F ON B.size = F.size
  WHERE A.id_shipment = $id_shipment AND A.no_trx = '$no_trx2'
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_orc_invoice_mixstyle2($id_shipment, $no_trx2){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.id_shipment = $id_shipment AND A.no_trx = '$no_trx2'
  GROUP BY B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_invoice_orc($id_shipment, $orc){
  global $koneksi; 

  $query = "SELECT distinct(B.size) as ukuran,
  CONCAT('size_', lower(trim(B.size))) as detail_size,
  CONCAT('total_', lower(trim(B.size))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(B.size)),'&#39;]') as pilih_size
    FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN size F ON B.size = F.size
  WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok != 'mix_style'
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}


function tampilkan_laporan_packinglist_orc($id_shipment, $orc, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT * FROM 
  (SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'full'
    Group By b.orc, C.id_style, B.color, C.size
  UNION
  SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'ecer'
    Group BY A.no_trx, b.orc
  UNION
  SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'mix'
    Group BY A.no_trx, b.orc  
  )A
  ORDER BY A.orc, IF(A.kelompok = 'mix', A.no_trx, 0), A.urutan, jumlah_size desc, A.tanggal_scan asc, A.jam_scan asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result; 
}

function tampilkan_laporan_packinglist_orc2($id_shipment, $orc, $var_sumsize, $var_weightsize){
  global $koneksi;
  
  $query = "SELECT * FROM 
  (SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, (sum(A.qty)*(select max(weight) from barang where id_style = C.id_style AND size = C.size and cup = IFNULL(C.cup, ''))) as nw 
    , A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'full'
    Group By b.orc, C.id_style, B.color, C.size, C.cup
  UNION
  SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, (sum(A.qty)*(select max(weight) from barang where id_style = C.id_style AND size = C.size and cup = IFNULL(C.cup, ''))) as nw, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'ecer'
    Group BY A.no_trx, b.orc
  UNION
  SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, ($var_weightsize) as nw, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'mix'
    Group BY A.no_trx, b.orc  
  )A
  ORDER BY A.orc, IF(A.kelompok = 'mix', A.no_trx, 0), A.urutan, jumlah_size desc, A.tanggal_scan asc, A.jam_scan asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}


function tampilkan_laporan_packinglist_orc3($id_shipment, $orc, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT * FROM 
  (SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'full'
    Group By b.orc, C.id_style, B.color, C.size, C.cup
  UNION
  SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'ecer'
    Group BY A.no_trx, b.orc
  UNION
  SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
    WHERE A.id_shipment = '$id_shipment' AND A.orc = '$orc' AND A.kelompok = 'mix'
    Group BY A.no_trx, b.orc  
  )A
  ORDER BY A.orc, IF(A.kelompok = 'mix', A.no_trx, 0), A.urutan, jumlah_size desc, A.tanggal_scan asc, A.jam_scan asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}


function tampilkan_item_no_weight($id_shipment){
  global $koneksi;
  
  $query = "SELECT A.kode_barcode, C.style, B.warna, B.size, B.cup, B.weight FROM transaksi_shipment A 
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN style C ON B.id_style = C.id_style
  WHERE A.id_shipment = $id_shipment AND B.weight = 0
  ORDER BY C.style, B.warna";
 
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_packinglist_invoice_mixstyle($id_shipment, $no_trx2, $var_sumsize){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size,  Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    JOIN size F on C.size = F.size
    WHERE A.id_shipment = '$id_shipment' AND A.no_trx = '$no_trx2'
    Group By A.no_trx, A.orc
  ORDER BY A.orc, IF(A.kelompok = 'mix', A.no_trx, 0), F.urutan, jumlah_size desc, A.tanggal_scan asc, A.jam_scan asc
  ";
 
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function tampilkan_laporan_packinglist_invoice_mixstyle2($id_shipment, $no_trx2, $var_sumsize, $var_weightsize){
  global $koneksi;
  
  $query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, D.description, C.warna, A.no_trx, A.tanggal_scan, A.jam_scan, 
    $var_sumsize, sum(A.qty)jumlah_size, ($var_weightsize) as nw, Count(Distinct A.no_trx) as karton, A.kelompok, F.urutan
    From transaksi_shipment A
    JOIN master_order B On A.orc = B.orc
    JOIN Barang C On A.kode_barcode = C.kode_barcode
    JOIN Style D On C.id_style = D.id_style
    JOIN costomer E ON B.id_costomer = E.id_costomer
    LEFT OUTER JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
    WHERE A.id_shipment = '$id_shipment' AND A.no_trx = '$no_trx2'
    Group By A.no_trx, A.orc
  ORDER BY A.orc, IF(A.kelompok = 'mix', A.no_trx, 0), F.urutan, jumlah_size desc, A.tanggal_scan asc, A.jam_scan asc
  ";


 
  
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 

return $result;
}

function cek_jumlah_transaksi_shipment_from_packing($id_costomer, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT distinct(B.size) size FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  WHERE C.id_costomer = $id_costomer AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%'
  AND C.no_po like '%$no_po%' AND A.shipment = 'n' AND C.status = 'open'";
 
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_transaksi_shipment_from_packing2($id_costomer, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT B.size, B.cup FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  join costomer E on C.id_costomer = E.id_costomer
  WHERE C.id_costomer = $id_costomer AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%'
  AND C.no_po like '%$no_po%' AND A.shipment = 'n' AND C.status = 'open'
  GROUP BY B.size, B.cup";
 
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_transaksi_shipment_from_packing_bundle($id_costomer, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT concat(trim(C.size), trim(C.cup)) ukuran FROM transaksi_packing_bundle A
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN style E ON D.id_style = E.id_style
  join costomer F on D.id_costomer = F.id_costomer
  JOIN hd_transaksi_packing_bundle G ON A.no_trx = G.no_trx
  WHERE D.id_costomer = $id_costomer AND D.orc LIKE '%$orc%' AND E.style LIKE '%$style%'
  AND D.no_po like '%$no_po%' AND G.status_trx = 'packing' AND D.status = 'open'
  GROUP BY C.size, C.cup";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_transaksi_shipment_to_packing($pl, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT distinct(B.size) size FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  WHERE A.id_shipment = $pl AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%'
  AND C.no_po like '%$no_po%'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_transaksi_shipment_to_packing2($pl, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT B.size, B.cup FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  WHERE A.id_shipment = $pl AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%'
  AND C.no_po like '%$no_po%'
  GROUP BY B.size, B.cup";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  
  if( $result = mysqli_query($koneksi, $query) ) {
    return mysqli_num_rows($result);
  }
}

function tampilkan_size_transaksi_shipment_from_packing($id_costomer, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT distinct(B.size) as ukuran,
  CONCAT('size_', lower(trim(replace(B.size, '-', '_')))) as detail_size,
  CONCAT('total_', lower(trim(replace(B.size, '-', '_')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(B.size, '-', '_'))),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  JOIN size F ON B.size = F.size
  WHERE C.id_costomer = $id_costomer AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%'
  AND C.no_po like '%$no_po%' AND A.shipment = 'n' AND C.status = 'open'
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_from_packing2($id_costomer, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE C.id_costomer = $id_costomer AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%'
  AND C.no_po like '%$no_po%' AND A.shipment = 'n' AND C.status = 'open'
  GROUP BY B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_from_packing_bundle($id_costomer, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT concat(trim(C.size), trim(C.cup)) ukuran,
  CONCAT('size_', lower(trim(replace(replace(C.size, '-', '_'), '/', '_'))), lower(TRIM(C.cup))) as detail_size,
  CONCAT('total_', lower(trim(replace(replace(C.size, '-', '_'), '/', '_'))), lower(TRIM(C.cup))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(C.size, '-', '_'), '/', '_'))), lower(TRIM(C.cup)),'&#39;]') as pilih_size
    FROM transaksi_packing_bundle A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN style E on D.id_style = E.id_style
  join costomer F on D.id_costomer = F.id_costomer
LEFT OUTER JOIN size G ON C.size = G.size AND C.cup = G.cup
JOIN hd_transaksi_packing_bundle H ON A.no_trx = H.no_trx
WHERE D.orc LIKE '%$orc%' AND D.id_costomer = $id_costomer
  AND D.no_po LIKE '%$no_po%' AND E.style LIKE '%$style%'
  AND D.status = 'open' AND H.status_trx = 'packing'
  GROUP BY C.size, C.cup
  ORDER BY G.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function tampilkan_size_transaksi_shipment_to_packing3($pl, $orc, $style, $no_po){
  global $koneksi; 

  $query = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size
    FROM transaksi_shipment A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  JOIN style D ON B.id_style = D.id_style
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.id_shipment = $pl AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%'
  AND C.no_po like '%$no_po%'
  GROUP BY B.size, B.cup
  ORDER BY F.urutan";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;
}

function transaksi_scan_packing_to_packinglist_bundle($id_costomer, $orc, $style, $no_po, $var_sumsize){
  global $koneksi;

  $query = "SELECT H.barcode_ctn, D.orc, D.no_po, E.style, D.color, A.no_trx, A.tanggal, A.jam, 
  A.no_trx, $var_sumsize, sum(A.qty) AS jumlah_size, H.kelompok
	FROM transaksi_packing_bundle A
	  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN style E on D.id_style = E.id_style
  join costomer F on D.id_costomer = F.id_costomer
LEFT OUTER JOIN size G ON C.size = G.size AND C.cup = G.cup
JOIN hd_transaksi_packing_bundle H ON A.no_trx = H.no_trx
 WHERE D.orc LIKE '%$orc%' AND D.id_costomer = $id_costomer
  AND D.no_po LIKE '%$no_po%' AND E.style LIKE '%$style%'
  AND D.status = 'open' AND H.status_trx = 'packing'
group by A.no_trx, D.orc
order BY A.no_trx desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}


function transaksi_scan_packing_to_packinglist($id_costomer, $orc, $style, $no_po, $var_sumsize){
  global $koneksi;

  $query = "SELECT C.orc, C.no_po, C.label, D.style, B.warna, A.no_trx, A.tanggal, A.jam, 
  group_concat(A.id_transaksi_packing) AS ids_to_delete,  
  A.no_trx, $var_sumsize,  
           sum(A.qty) AS jumlah_size,
           COUNT(DISTINCT A.no_trx) AS karton, A.kelompok
	FROM transaksi_packing A
	join barang B ON A.kode_barcode = B.kode_barcode
	JOIN master_order	C ON A.orc = C.orc 
	JOIN style D ON B.id_style = D.id_style
	JOIN costomer E ON C.id_costomer = E.id_costomer
	WHERE C.no_po LIKE '%$no_po%' AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%' AND C.id_costomer = $id_costomer 
  AND A.shipment = 'n' AND C.status = 'open'
group by A.no_trx, A.orc, D.style, B.warna
order BY A.no_trx desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}


function transaksi_scan_shipment_to_packing($pl, $orc, $style, $no_po, $var_sumsize){
  global $koneksi;

  $query = "SELECT C.orc, C.no_po, C.label, D.style, B.warna, A.no_trx, A.tanggal_scan, A.jam_scan,  
  A.no_trx, $var_sumsize,  
           sum(A.qty) AS jumlah_size,
           COUNT(DISTINCT A.no_trx) AS karton, A.kelompok
	FROM transaksi_shipment A
	join barang B ON A.kode_barcode = B.kode_barcode
	JOIN master_order	C ON A.orc = C.orc 
	JOIN style D ON B.id_style = D.id_style
	
	WHERE C.no_po LIKE '%$no_po%' AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%' AND A.id_shipment = $pl
group by A.no_trx, A.orc, D.style, B.warna
order BY A.no_trx desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

return $result;
}
?>
