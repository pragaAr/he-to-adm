$(document).ready(function () {
  $("#tfoot").hide();

  $(document).keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

  $("#namacust").on("change", function () {
    const namacust = $(this).val();
    $.ajax({
      url: "http://localhost/hira-to-adm/invoice/getOrderCust",
      type: "POST",
      dataType: "json",
      data: {
        pengirim: namacust,
      },
      success: function (res) {
        $('input[name="nosj"]').prop("readonly", true);

        // Remove options
        $(".orderno").val(res.orderno).trigger("change");

        reset();

        $("#orderno").find("option").not(":first").remove();

        // Add options
        $.each(res, function (index, response) {
          $("#orderno").append(
            '<option value="' +
              response["no_order"] +
              '">' +
              response["no_order"] +
              "</option>"
          );
        });
      },
    });
  });

  $("#orderno").on("input", function () {
    const order = $(this).val();
    $.ajax({
      url: "http://localhost/hira-to-adm/invoice/getDataOrderCust",
      type: "POST",
      dataType: "json",
      data: {
        no_order: order,
      },
      success: function (data) {
        $(".platno").val(data.platno);
        $(".kotaasal").val(data.kota_asal);
        $(".kotatujuan").val(data.kota_tujuan);
        $(".berat").val(format(data.berat));
        $(".hargakg").val(format(data.harga_kg));
        $(".tagihanorder").val(format(data.total_harga));
        $(".nosj").val(data.surat_jalan);
        $("#tambah-invoice").prop("disabled", false);
      },
    });
  });

  $("button#tambah-invoice").on("click", function (e) {
    const cartInv = {
      noorder: $('select[name="orderno"]').val(),
      platno: $('input[name="platno"]').val(),
      kotaasal: $('input[name="kotaasal"]').val(),
      kotatujuan: $('input[name="kotatujuan"]').val(),
      berat: $('input[name="berat"]').val(),
      hargakg: $('input[name="hargakg"]').val(),
      tagihan: $('input[name="tagihanorder"]').val(),
      nosj: $('input[name="nosj"]').val(),
    };
    console.log(cartInv);

    $.ajax({
      url: "http://localhost/hira-to-adm/invoice/cart",
      type: "POST",
      data: cartInv,
      success: function (data) {
        if ($('select[name="orderno"]').val() == cartInv.noorder) reset();

        $("#tambah-invoice").prop("disabled", true);

        $("table#cart tbody").append(data);
        $("#total").html("<p>" + total_tagihan().toLocaleString() + "</p>");
        $('input[name="total_hidden"]').val(total_tagihan());

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
    $('select[name="namacust"]').prop("disabled", true);
    $('select[name="orderno"]').prop("disabled", true);
  });

  function total_tagihan() {
    let hasil = 0;
    $(".tagihan").each(function () {
      hasil += parseFloat(
        $(this)
          .text()
          .replace(/[^\d.]/g, "")
      );
    });
    return hasil;
  }

  function reset() {
    $('select[name="orderno"]').val("");
    $('input[name="platno"]').val("");
    $('input[name="kotaasal"]').val("");
    $('input[name="kotatujuan"]').val("");
    $('input[name="berat"]').val("");
    $('input[name="hargakg"]').val("");
    $('input[name="tagihanorder"]').val("");
    $('input[name="nosj"]').val("");
  }
});
