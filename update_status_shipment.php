<?php
require_once 'core/init.php';

// Handle AJAX update
if (isset($_POST['action']) && $_POST['action'] == 'update_shipment') {
    $id_order = $_POST['id_order'];
    $tanggal = date('Y-m-d H:i:s'); // current timestamp
    $query = "UPDATE transaksi_carton TC
              JOIN master_order MO ON TC.orc = MO.orc
              SET TC.shipment_status = 'yes', TC.shipment_status_date = '$tanggal', TC.qty = 0
              WHERE MO.id_order = '$id_order'";
    
    $result = mysqli_query($koneksi, $query);
    
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Status berhasil diupdate']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
    }
    exit;
}

// Render isi modal
if (isset($_POST['rowedit'])) {
    $id_order = $_POST['rowedit'];
?>

<div style="text-align: center; margin-bottom: 1.25rem;">
  <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-background-warning, #FAEEDA); 
              display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
    <i class="glyphicon glyphicon-export" style="color: #BA7517; font-size: 20px;"></i>
  </div>
  <h5 style="margin: 0 0 4px; font-weight: 600;">Konfirmasi Shipment</h5>
  <small class="text-muted">Tindakan ini tidak dapat dibatalkan</small>
</div>

<div style="background: #f9f9f9; border-left: 3px solid #f0ad4e; border-radius: 4px; 
            padding: 10px 14px; margin-bottom: 1rem;">
  <small class="text-muted">Order ID</small>
  <p style="margin: 0; font-weight: 600; font-size: 15px;"><?= $id_order ?></p>
</div>

<p class="text-muted" style="font-size: 13px; margin-bottom: 1.5rem;">
  Apakah Anda yakin ingin menandai order ini sebagai 
  <strong>SHIPPED</strong>? Status pengiriman akan diperbarui dan tidak dapat diubah kembali.
</p>

<div style="display: flex; gap: 8px;">
  <button id="btnNoShipment" class="btn btn-default" style="flex: 1;">
    Batal
  </button>
  <button id="btnYesShipment" class="btn btn-success" 
          style="flex: 1;" data-id="<?= $id_order ?>">
    <i class="glyphicon glyphicon-ok"></i> Ya, Konfirmasi
  </button>
</div>
<script>
    $('#btnNoShipment').click(function() {
        $('#myEdit').modal('hide'); // Bootstrap modal hide
    });

    $('#btnYesShipment').click(function() {
        let id_order = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'update_status_shipment.php',
            data: {
                action: 'update_shipment',
                id_order: id_order
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Status shipment berhasil diupdate!');
                    $('#myEdit').modal('hide');
                    $('#example').DataTable().ajax.reload(); // refresh tabel
                } else {
                    alert('Gagal: ' + response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan pada server.');
            }
        });
    });
</script>

<?php } ?>