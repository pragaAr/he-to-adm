const userlogin = $(".userlogin").data("flashdata");

if (userlogin) {
  Swal.fire({
    icon: "success",
    title: "Login berhasil!",
    text: userlogin,
  });
}

const inserted = $(".inserted").data("flashdata");

if (inserted) {
  Swal.fire({
    icon: "success",
    title: "Success!",
    text: inserted,
  });
}

const updated = $(".updated").data("flashdata");

if (updated) {
  Swal.fire({
    icon: "success",
    title: "Updated!",
    text: updated,
  });
}

const deleted = $(".deleted").data("flashdata");

if (deleted) {
  Swal.fire({
    icon: "success",
    title: "Deleted!",
    text: deleted,
  });
}

$("#addArmada").on("shown.bs.modal", function () {
  $('input[name="platno"]').focus();
});

$("#addSopir").on("shown.bs.modal", function () {
  $('input[name="namasopir"]').focus();
});

$("#addKaryawan").on("shown.bs.modal", function () {
  $('input[name="nama"]').focus();
});

$("#addUser").on("shown.bs.modal", function () {
  $('input[name="namauser"]').focus();
});

$("#addOrder").on("shown.bs.modal", function () {
  $('input[name="namacust"]').focus();
  $('input[name="namacust"]').on("input", function () {
    const cust = $(this).val();
    $.ajax({
      url: "http://localhost/hira-to-adm/customer/getDataCustomer",
      type: "POST",
      dataType: "json",
      data: {
        nama: cust,
      },
      success: function (res) {
        if (res != null) {
          $('input[name="notelp"]').val(res.notelp);
          $('textarea[name="alamatasal"]').val(res.alamat);
          $('input[name="muatan"]').focus();
        } else {
          $('input[name="notelp"]').val("");
          $('textarea[name="alamatasal"]').val("");
        }
      },
    });
  });
});

$("#addRek").on("shown.bs.modal", function () {
  $('input[name="norek"]').focus();
});

$("#addPenjualan").on("shown.bs.modal", function () {
  $('input[name="kdpaket"]').focus();
});

$("#tambahan").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#nominal").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#nominal-order").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#harga").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#berat").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#tonase").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#borongan").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#edittonase").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#editborongan").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$("#nominaledit").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$(function () {
  $("#tambahan").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#nominal").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#nominaledit").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#nominal-order").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#harga").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#tonase").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#borongan").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#edittonase").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(function () {
  $("#editborongan").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});

$(".btn-delete").on("click", function (e) {
  e.preventDefault();
  const href = $(this).attr("href");

  Swal.fire({
    title: "Apakah anda yakin ?",
    text: "Data akan di hapus!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Batal",
    confirmButtonText: "Ya, Hapus !",
  }).then((result) => {
    if (result.value) {
      document.location.href = href;
    }
  });
});

$("#nextAddOrder").on("click", function (e) {
  e.preventDefault();
  $("#addOrder").modal("hide");
  $("#addSanguOrder").modal("show");
});

$("#backAddOrder").on("click", function (e) {
  e.preventDefault();
  $("#addOrder").modal("show");
  $("#addSanguOrder").modal("hide");
});

//  update karyawan
$(".btn-edit-karyawan").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/karyawan/getId",
    type: "POST",
    dataType: "json",
    data: {
      id_karyawan: id,
    },
    success: function (data) {
      $(".idkaryawan").val(data.id_karyawan);
      $(".nama").val(data.nama);
      $(".usia").val(data.usia);
      $(".alamat").val(data.alamat);
      $(".notelp").val(data.notelp);
      $(".status").val(data.status);
    },
  });

  $("#editKaryawan").modal("show");
});

//  update customer
$(".btn-edit-customer").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/customer/getId",
    type: "POST",
    dataType: "json",
    data: {
      id_customer: id,
    },
    success: function (data) {
      $(".idcustomer").val(data.id_customer);
      $(".nama").val(data.nama_customer);
      $(".notelp").val(data.notelp);
      $(".alamat").val(data.alamat);
    },
  });

  $("#editCustomer").modal("show");
});

//  update armada
$(".btn-edit-armada").on("click", function (e) {
  e.preventDefault();

  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/armada/getId",
    type: "POST",
    dataType: "json",
    data: {
      id_armada: id,
    },
    success: function (data) {
      $(".idarmada").val(data.id_armada);
      $(".platno").val(data.platno);
      $(".merk").val(data.merk);
      $(".keur").val(data.dateKeur);
    },
  });

  $("#editArmada").modal("show");
});

//  update rekening
$(".btn-edit-rek").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/rekening/getNo",
    type: "POST",
    dataType: "json",
    data: {
      no_rek: id,
    },
    success: function (data) {
      $(".norekold").val(data.no_rek);
      $(".norek").val(data.no_rek);
      $(".namarek").val(data.nama_rek);
      $(".jenisrek").val(data.jenis_rek);
    },
  });

  $("#editRek").modal("show");
});

//  update lain-lain
$(".btn-edit-lain").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/pengeluaran_lain/getId",
    type: "POST",
    dataType: "json",
    data: {
      id_lain: id,
    },
    success: function (data) {
      console.log(data);
      $(".idlain").val(data.id_lain);
      $(".karyawanedit").val(data.karyawan_id).trigger("change");
      $(".nominaledit").val(format(data.nominal));
      $(".keteranganedit").val(data.keterangan);
    },
  });

  $("#editLain").modal("show");
});

//  update order and sangu too
$(".btn-edit-order").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/order/getNoOrder",
    type: "POST",
    dataType: "json",
    data: {
      no_order: id,
    },
    success: function (data) {
      console.log(data);
      $(".noorder").val(data.no_order);
      $(".namacust").val(data.nama_cust);
      $(".notelp").val(data.notelp_cust);
      $(".muatan").val(data.jenis_muatan);
      $(".alamatasal").val(data.alamat_asal);
      $(".alamattujuan").val(data.alamat_tujuan);
      $(".platno").val(data.platno).trigger("change");
      $(".sopir").val(data.sopir_id).trigger("change");
      $(".kotaasal").val(data.kota_asal);
      $(".kotatujuan").val(data.kota_tujuan);
      $(".nominal").val(format(data.nominal));
    },
  });

  $("#editOrder").modal("show");

  $("#nextUpdateOrder").on("click", function (e) {
    e.preventDefault();
    $("#editOrder").modal("hide");
    $("#editSanguOrder").modal("show");
  });

  $("#backUpdateOrder").on("click", function (e) {
    e.preventDefault();
    $("#editOrder").modal("show");
    $("#editSanguOrder").modal("hide");
  });
});

//  update sangu
$(".btn-edit-sangu").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/sangu/getNoOrder",
    type: "POST",
    dataType: "json",
    data: {
      no_order: id,
    },
    success: function (data) {
      $(".noorder").val(data.no_order);
      $(".platno").val(data.platno).trigger("change");
      $(".sopir").val(data.sopir_id).trigger("change");
      $(".asal").val(data.kota_asal);
      $(".tujuan").val(data.kota_tujuan);
      $(".nominal").val(format(data.nominal));
      $(".tambahan").val(format(data.tambahan));
    },
  });

  $("#editSangu").modal("show");
});

//  update sopir
$(".btn-edit-sopir").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/sopir/getId",
    type: "POST",
    dataType: "json",
    data: {
      id_sopir: id,
    },
    success: function (data) {
      $(".idsopir").val(data.id_sopir);
      $(".namasopir").val(data.nama_sopir);
      $(".alamatsopir").val(data.alamat_sopir);
      $(".notelpsopir").val(data.notelp_sopir);
    },
  });

  $("#editSopir").modal("show");
});

//  update user
$(".btn-edit-user").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/user/getId",
    type: "POST",
    dataType: "json",
    data: {
      id_user: id,
    },
    success: function (data) {
      $(".iduser").val(data.id_user);
      $(".namauser").val(data.namauser);
      $(".username").val(data.username);
      $(".role").val(data.role);
    },
  });

  $("#editUser").modal("show");
});

//  update penjualan
$(".btn-edit-penjualan").on("click", function (e) {
  e.preventDefault();
  const id = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/penjualan/getNoOrderPenjualan",
    type: "POST",
    dataType: "json",
    data: {
      no_order: id,
    },
    success: function (data) {
      console.log(data);
      $(".editnoorder").val(data.no_order);
      $(".edittglorder").val(data.dateAdd);
      $(".editpengirim").val(data.pengirim);
      $(".editkotaasal").val(data.kota_asal);
      $(".editalamatpengirim").val(data.alamat_asal);
      $(".editpenerima").val(data.penerima);
      $(".editnosj").val(data.surat_jalan);
      $(".editkotatujuan").val(data.kota_tujuan);
      $('input[name="editpenerima"]').focus();
      $(".editalamatpenerima").val(data.alamat_tujuan);
      $(".editmuatan").val(data.muatan);
      $(".editjenispenjualan").val(data.jenis_penjualan);
      $(".edittotalbiaya").val(format(data.total_harga));
      $(".editpembayaran").val(data.pembayaran);

      if ($('select[name="editjenispenjualan"]').val() == "borong") {
        $("#edit-berat-tonase").css("display", "none");
        $("#edit-harga-borong").css("display", "block");
        $("#edit-total-harga").removeClass("col-md-8");
        $("#edit-total-harga").addClass("col-md-4");
        $(".editborongan").val(format(data.harga_borong));
        $('input[name="editborongan"]').prop("readonly", false);
      } else {
        $("#edit-berat-tonase").css("display", "flex");
        $("#edit-harga-borong").css("display", "none");
        $("#edit-total-harga").removeClass("col-md-4");
        $("#edit-total-harga").addClass("col-md-8");
        $('input[name="editberat"]').prop("readonly", false);
        $('input[name="edittonase"]').prop("readonly", false);
        $(".editberat").val(data.berat);
        $(".edittonase").val(format(data.harga_kg));
        $('input[name="editborongan"]').prop("readonly", false);
      }
    },
  });

  $("#editPenjualan").modal("show");

  $("#editjenispenjualan").on("change", function () {
    if ($('select[name="editjenispenjualan"]').val() == "borong") {
      $("#edit-berat-tonase").css("display", "none");
      $("#edit-harga-borong").css("display", "block");
      $("#edit-total-harga").removeClass("col-md-8");
      $("#edit-total-harga").addClass("col-md-4");
      $('input[name="editberat"]').prop("readonly", true);
      $('input[name="edittonase"]').prop("readonly", true);
      $('input[name="editberat"]').val("");
      $('input[name="edittonase"]').val("");
      $('input[name="edittotalbiaya"]').val("");
      $('input[name="editborongan"]').prop("readonly", false).focus();
    } else {
      $("#edit-berat-tonase").css("display", "flex");
      $("#edit-harga-borong").css("display", "none");
      $("#edit-total-harga").removeClass("col-md-4");
      $("#edit-total-harga").addClass("col-md-8");
      $('input[name="editborongan"]').val("");
      $('input[name="edittotalbiaya"]').val("");
      $('input[name="editborongan"]').prop("readonly", true);
      $('input[name="editberat"]').prop("readonly", false).focus();
      $('input[name="edittonase"]').prop("readonly", false);
    }
  });
});

$("#editPenjualan").on("show.bs.modal", function () {
  $('input[name="editberat"]').on("input keyup change", function () {
    $('input[name="edittotalbiaya"]').val(editBiayaTonase());
  });

  $('input[name="edittonase"]').on("input keyup change", function () {
    $('input[name="edittotalbiaya"]').val(editBiayaTonase());
  });

  $('input[name="editborongan"]').on("input keyup change", function () {
    $('input[name="edittotalbiaya"]').val(editBiayaBorong());
  });

  function editBiayaTonase() {
    let beratTonEdit = $('input[name="editberat"]').val();
    let biayaTonEdit = $('input[name="edittonase"]')
      .val()
      .replace(/[^\d.]/g, "");
    let totTonEdit = biayaTonEdit * beratTonEdit;
    return format(totTonEdit);
  }

  function editBiayaBorong() {
    let biayaEdit = $('input[name="editborongan"]')
      .val()
      .replace(/[^\d.]/g, "");

    let totEdit = biayaEdit;
    return format(totEdit);
  }
});

//  detail um
$(".btn-detail-um").on("click", function (e) {
  e.preventDefault();
  const kd = $(this).data("id");
  const tgl = $(this).data("tgl");
  $.ajax({
    url: "http://localhost/hira-to-adm/uangmakan/getDetailkd",
    type: "POST",
    dataType: "json",
    data: {
      kd_um: kd,
    },
    success: function (data) {
      console.log(data);
      $(".kd_um").val(kd);
      $(".kd_um").html("no um : " + kd);
      $(".tgl_um").html("tanggal : " + tgl);

      $("#detailUm").modal("show");

      let datadetail = "";
      let no = 1;
      $.each(data, function (key, value) {
        datadetail +=
          "<tr style='border-bottom-color: rgb(145, 143, 143) !important;'>";
        datadetail +=
          "<td style='border-color:rgb(145, 143, 143) !important' class='text-capitalize'>" +
          no++ +
          "</td>";
        datadetail +=
          "<td style='border-color:rgb(145, 143, 143) !important' class='text-capitalize'>" +
          value.nama +
          "</td>";
        datadetail +=
          "<td style='border-color:rgb(145, 143, 143) !important' class='text-capitalize'>" +
          "Rp. " +
          format(value.nominal_um) +
          "</td>";
        datadetail += "</tr>";
      });

      $(".tbody-detail-um").html(datadetail);
    },
  });
});

//  detail order
$(".btn-detail-order").on("click", function (e) {
  e.preventDefault();
  const kd = $(this).data("id");
  $.ajax({
    url: "http://localhost/hira-to-adm/order/getNoOrder",
    type: "POST",
    dataType: "json",
    data: {
      no_order: kd,
    },
    success: function (data) {
      $(".noorderprint").val(data.no_order);
      $(".noorder").text(data.no_order);
      $(".muatan").text(data.nama_cust);
      $(".namacust").text(data.nama_cust);
      $(".alamatasal").text(data.alamat_asal);
      $(".alamattujuan").text(data.alamat_tujuan);
      $(".tanggal").text(data.dateAdd);

      $(".truck").text(data.platno);
      $(".supir").text(data.nama_sopir);
      $(".kotaasal").text(data.kota_asal);
      $(".kotatujuan").text(data.kota_tujuan);
      $(".nominalsangu").text("Rp. " + format(data.nominal));

      $("#detailOrder").modal("show");
    },
  });
});

// penjualan
$("#addPenjualan").on("show.bs.modal", function () {
  $("#noorderpenjualan").on("change", function () {
    $.ajax({
      url: "http://localhost/hira-to-adm/penjualan/getOrderNo",
      type: "POST",
      dataType: "json",
      data: {
        no_order: $(this).val(),
      },
      success: function (data) {
        console.log(data);
        $(".tglorder").val(data.dateAdd);
        $(".muatan").val(data.jenis_muatan);
        $(".pengirim").val(data.nama_cust);
        $(".alamatpengirim").val(data.alamat_asal);
        $(".alamatpenerima").val(data.alamat_tujuan);
        $('input[name="penerima"]').focus();
      },
    });
  });

  $("#jenispenjualan").on("change", function () {
    if ($('select[name="jenispenjualan"]').val() == "borong") {
      $("#berat-tonase").css("display", "none");
      $("#harga-borong").css("display", "block");
      $("#total-harga").removeClass("col-md-8");
      $("#total-harga").addClass("col-md-4");
      $('input[name="berat"]').prop("readonly", true);
      $('input[name="tonase"]').prop("readonly", true);
      $('input[name="berat"]').val("");
      $('input[name="tonase"]').val("");
      $('input[name="totalbiaya"]').val("");
      $('input[name="borongan"]').prop("readonly", false).focus();
    } else {
      $("#berat-tonase").css("display", "flex");
      $("#harga-borong").css("display", "none");
      $("#total-harga").removeClass("col-md-4");
      $("#total-harga").addClass("col-md-8");
      $('input[name="borongan"]').val("");
      $('input[name="totalbiaya"]').val("");
      $('input[name="borongan"]').prop("readonly", true);
      $('input[name="berat"]').prop("readonly", false).focus();
      $('input[name="tonase"]').prop("readonly", false);
    }
  });

  $('input[name="berat"]').on("input keyup change", function () {
    $('input[name="totalbiaya"]').val(biayaTonase());
  });

  $('input[name="tonase"]').on("input keyup change", function () {
    $('input[name="totalbiaya"]').val(biayaTonase());
  });

  $('input[name="borongan"]').on("input keyup change", function () {
    $('input[name="totalbiaya"]').val(biayaBorong());
  });

  function biayaTonase() {
    let beratTon = $('input[name="berat"]').val();
    let biayaTon = $('input[name="tonase"]')
      .val()
      .replace(/[^\d.]/g, "");
    let totTon = biayaTon * beratTon;
    return format(totTon);
  }

  function biayaBorong() {
    let biaya = $('input[name="borongan"]')
      .val()
      .replace(/[^\d.]/g, "");

    let tot = biaya;
    return format(tot);
  }
});
