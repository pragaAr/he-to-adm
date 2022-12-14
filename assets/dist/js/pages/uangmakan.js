$(document).ready(function () {
  $("#tfoot").hide();

  $(document).keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

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

        $("#tambah").prop("disabled", false);
      },
    });
  });

  $("button#tambah").on("click", function (e) {
    const cartUm = {
      idkaryawan: $('select[name="karyawan"]').val(),
      nama: $('input[name="namakaryawan"]').val(),
      nominal: $('input[name="nominal"]').val(),
    };

    $.ajax({
      url: "http://localhost/hira-to-adm/uangmakan/cart",
      type: "POST",
      data: cartUm,
      success: function (data) {
        if ($('select[name="karyawan"]').val() == cartUm.idkaryawan) reset();

        $("#tambah").prop("disabled", true);

        $("table#cart tbody").append(data);
        $("#total").html("<p>" + total_um().toLocaleString() + "</p>");
        $('input[name="total_hidden"]').val(total_um());

        $("tfoot").show();
        $('[data-toggle="tooltip"]').tooltip();
      },
    });
    reset();
  });

  $(document).on("click", "#tombol-hapus", function () {
    $(this).closest(".row-cart").remove();

    if ($("tbody").children().length == 0) $("tfoot").hide();
  });

  $('button[type="submit"]').on("click", function () {
    $('select[name="karyawan"]').prop("disabled", true);
    $('input[name="namakaryawan"]').prop("disabled", true);
  });

  function total_um() {
    let hasil = 0;
    $(".nominal").each(function () {
      hasil += parseFloat(
        $(this)
          .text()
          .replace(/[^\d.]/g, "")
      );
    });
    return hasil;
  }

  function reset() {
    $("#karyawan").val(null).trigger("change");
    $('input[name="namakaryawan"]').val("");
  }
});

$("#nominal").on("keypress", function (key) {
  if (key.charCode < 48 || key.charCode > 57) return false;
});

$(function () {
  $("#nominal").on("keydown keyup click change blur input", function (e) {
    $(this).val(format($(this).val()));
  });
});
