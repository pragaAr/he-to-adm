// edit reccu delivcab

$("#karyawan").on("input", function () {
  $.ajax({
    url: "http://localhost/hira-to-adm/karyawan/getId",
    type: "POST",
    dataType: "json",
    data: {
      id_karyawan: $("#karyawan").val(),
    },
    success: function (data) {
      $('input[name="namakaryawan"]').val(data.nama);

      $("#tambah-um").prop("disabled", false);
    },
  });
});

$(document).on("click", "#tambah-um", function (e) {
  const cart_update_um = {
    idkaryawan: $('select[name="karyawan"]').val(),
    nama: $('input[name="namakaryawan"]').val(),
    nominal: $('input[name="nominal"]').val(),
  };

  $.ajax({
    url: "http://localhost/hira-to-adm/uangmakan/cartupdate",
    type: "POST",
    data: cart_update_um,
    success: function (data) {
      $(".karyawan").val(data.id_karyawan).trigger("change");

      $("#tambah-um").prop("disabled", true);

      $("table#cart tbody").append(data);

      if ($(".tbdetail").length > 0) {
        $(".um-update").prop("disabled", false);
      }
      $('[data-toggle="tooltip"]').tooltip();
    },
  });
  reset();
});

$(document).on("click", "#btn-hapus-um", function () {
  $(this).closest(".tbdetail").remove();

  if ($(".tbdetail").length < 1) {
    $(".um-update").prop("disabled", true);
  }
});

function reset() {
  $("#karyawan").val(null).trigger("change");
  $('input[name="namakaryawan"]').val("");
}

$("#nominal").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$(function () {
  $("#nominal").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});
