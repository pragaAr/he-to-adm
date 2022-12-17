$("#btn-update-invoice").on("click", function (e) {
  e.preventDefault();

  $(document).keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

  const id = $(this).data("id");
  const namaCust = $(this).data("nama");
  const jmlResi = $(this).data("resi");
  const jmlTot = $(this).data("total");
  const tgl = $(this).data("tgl");

  $("#updateInvoice").modal("show");

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDetailDataInvoice",
    type: "POST",
    dataType: "json",
    data: {
      kd_inv: id,
    },
    success: function (data) {
      console.log(data);
    },
  });

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDetailDataCust",
    type: "GET",
    dataType: "json",
    success: function (dataCust) {
      console.log(dataCust);

      // Remove options
      $(".editnamacust").val(dataCust.pengirim).trigger("change");

      // reset();

      $("#editnamacust").find("option").not(":first").remove();

      // Add options
      $.each(dataCust, function (index, response) {
        $("#editnamacust").append(
          '<option value="' +
            response["pengirim"] +
            '">' +
            response["pengirim"].toUpperCase() +
            "</option>"
        );
      });
    },
  });
});

$("#editnamacust").on("input", function () {
  const editnamacust = $(this).val();
  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getOrderCust",
    type: "POST",
    dataType: "json",
    data: {
      pengirim: editnamacust,
    },
    success: function (res) {
      console.log(res);

      $("#tambah-invoice-update").prop("disabled", true);

      $('input[name="editnosj"]').prop("readonly", true);

      // Remove options
      $(".editorderno").val(res.no_order).trigger("change");

      reset();

      $("#editorderno").find("option").not(":first").remove();

      // Add options
      $.each(res, function (index, response) {
        $("#editorderno").append(
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

$("#editorderno").on("input", function () {
  const order = $(this).val();
  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDataOrderCust",
    type: "POST",
    dataType: "json",
    data: {
      no_order: order,
    },
    success: function (data) {
      $(".editplatno").val(data.platno);
      $(".editkotaasal").val(data.kota_asal);
      $(".editkotatujuan").val(data.kota_tujuan);
      $(".editberat").val(format(data.berat));
      $(".edithargakg").val(format(data.harga_kg));
      $(".edittagihanorder").val(format(data.total_harga));
      $(".editnosj").val(data.surat_jalan);
      $("#tambah-invoice-update").prop("disabled", false);
    },
  });
});

$("button#tambah-invoice-update").on("click", function (e) {
  const cartInv = {
    editorderno: $('select[name="editorderno"]').val(),
    editplatno: $('input[name="editplatno"]').val(),
    editkotaasal: $('input[name="editkotaasal"]').val(),
    editkotatujuan: $('input[name="editkotatujuan"]').val(),
    editberat: $('input[name="editberat"]').val(),
    edithargakg: $('input[name="edithargakg"]').val(),
    edittagihanorder: $('input[name="edittagihanorder"]').val(),
    editnosj: $('input[name="editnosj"]').val(),
  };
  console.log(cartInv);

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/cartUpdate",
    type: "POST",
    data: cartInv,
    success: function (data) {
      if ($('select[name="editorderno"]').val() == cartInv.editorderno) reset();

      $("#tambah-invoice-update").prop("disabled", true);

      $("table#cart tbody").append(data);
      $("#edittotal").html("<p>" + total_tagihan().toLocaleString() + "</p>");
      $('input[name="edittotal_hidden"]').val(total_tagihan());

      $("tfoot").show();
    },
  });
});

$(document).on("click", "#btn-hapus-noorder", function () {
  $(this).closest(".tbdetail").remove();

  $("#edittotal").html("<p>" + total_tagihan().toLocaleString() + "</p>");
  $('input[name="edittotal_hidden"]').val(total_tagihan());
});

$('button[type="submit"]').on("click", function () {
  $('input[name="edittanggal"]').prop("disabled", true);
  $('select[name="editorderno"]').prop("disabled", true);
});

function total_tagihan() {
  let hasil = 0;
  $(".edittagihanorder").each(function () {
    // if ($(".edittagihanorder").length == "") {
    // } else {
    // }
    hasil += parseFloat(
      $(this)
        .text()
        .replace(/[^\d.]/g, "")
    );
  });
  return hasil;
}

function reset() {
  $('select[name="editorderno"]').val("");
  $('input[name="editplatno"]').val("");
  $('input[name="editkotaasal"]').val("");
  $('input[name="editkotatujuan"]').val("");
  $('input[name="editberat"]').val("");
  $('input[name="edithargakg"]').val("");
  $('input[name="edittagihanorder"]').val("");
  $('input[name="editnosj"]').val("");
}
