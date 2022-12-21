$("#btn-update-invoice").on("click", function (e) {
  e.preventDefault();
  $("tfoot").show();

  $(document).keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

  const id = $(this).data("id");
  const cust = $(this).data("cust");
  const tgl = $(this).data("tgl");

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDetailDataInvoice",
    type: "POST",
    dataType: "json",
    data: {
      kd_inv: id,
    },
    success: function (data) {
      console.log(data);
      $(".editkd").val(id);
      $(".edittanggal").val(tgl);
      $('input[name="editnamacust"]').val(cust);

      getresi();

      $('input[name="editcust_hidden"]').val(cust);

      let datadetail = "";
      let hasil = 0;

      $.each(data, function (key, value) {
        datadetail += "<tr class='text-center tbdetail'>";
        datadetail +=
          "<td class='text-uppercase editorderno'>" +
          value.no_order +
          "<input type='hidden' class='form-control' name='noorder_hidden[]' value='" +
          value.no_order +
          "'readonly></td>";
        datadetail +=
          "<td class='text-uppercase editnosj'>" +
          value.surat_jalan +
          "<input type='hidden' class='form-control' name='sj_hidden[]' value='" +
          value.surat_jalan +
          "'readonly></td>";
        datadetail +=
          "<td class='text-uppercase edittagihan' data-val='" +
          value.total_harga +
          "'>" +
          format(value.total_harga) +
          "<input type='hidden' class='form-control' name='harga_hidden[]' value='" +
          value.total_harga +
          "'readonly></td>";
        datadetail +=
          "<td class='action'>" +
          "<button type='button' class='btn btn-danger btn-sm' id='btn-hapus-noorder' title='Hapus Resi'>" +
          "<i class='fas fa-times'></i>" +
          "</button>" +
          "</td>";
        datadetail += "</tr>";
        hasil += parseFloat(value.total_harga);
      });

      $("#edittotal").html(format(hasil));

      $('input[name="edittotal_hidden"]').val(hasil);
      $(".tbody-cart-inv").html(datadetail);

      $("#updateInvoice").modal("show");
    },
  });

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDetailDataCust",
    type: "GET",
    dataType: "json",
    success: function (dataCust) {
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

  function getresi() {
    customers = $(".editnamacust").val();

    $.ajax({
      url: "http://localhost/hira-to-adm/invoice/getOrderCust",
      type: "POST",
      dataType: "json",
      data: {
        pengirim: customers,
      },
      success: function (res) {
        // if ($(".tbdetail").length < 1) {
        //   $("#btnupdate").prop("disabled", true);
        //   $("tfoot").hide();
        // }

        // $('input[name="editcust_hidden"]').val(editnamacust);

        // $("#tambah-invoice-update").prop("disabled", true);

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
  }

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
        $(".edittagihanorder").attr("data-val", data.total_harga);
        $(".editnosj").val(data.surat_jalan);
        $("#tambah-invoice-update").prop("disabled", false);
      },
    });
  });

  $("button#tambah-invoice-update").on("click", function (e) {
    let adddatadetail = "";

    const datainv = {
      noorder: $('select[name="editorderno"]').val(),
      tagihan: $('input[name="edittagihanorder"]').val(),
      tagihanVal: $('input[name="edittagihanorder"]').attr("data-val"),
      nosj: $('input[name="editnosj"]').val(),
    };

    adddatadetail += "<tr class='text-center tbdetail'>";
    adddatadetail +=
      "<td class='text-uppercase editorderno'>" +
      datainv.noorder +
      "<input type='hidden' class='form-control' name='noorder_hidden[]' value='" +
      datainv.noorder +
      "'readonly></td>";
    adddatadetail +=
      "<td class='text-uppercase editnosj'>" +
      datainv.nosj +
      "<input type='hidden' class='form-control' name='sj_hidden[]' value='" +
      datainv.nosj +
      "'readonly></td>";
    adddatadetail +=
      "<td class='text-uppercase edittagihan' data-val='" +
      datainv.tagihanVal +
      "'>" +
      datainv.tagihan +
      "<input type='hidden' class='form-control' name='harga_hidden[]' value='" +
      datainv.tagihanVal +
      "'readonly></td>";
    adddatadetail +=
      "<td class='action'>" +
      "<button type='button' class='btn btn-danger btn-sm' id='btn-hapus-noorder' title='Hapus Resi'>" +
      "<i class='fas fa-times'></i>" +
      "</button>" +
      "</td>";
    adddatadetail += "</tr>";

    $(".tbody-cart-inv").append(adddatadetail);

    $("#edittotal").html(format(total_tagihan()));

    $('input[name="edittotal_hidden"]').val(total_tagihan());

    if ($(".tbdetail").length > 0) {
      $("#btnupdate").prop("disabled", false);
      $("tfoot").show();
    }

    reset();
  });

  $(document).on("click", "#btn-hapus-noorder", function () {
    $(this).closest(".tbdetail").remove();

    $("#edittotal").html(format(total_tagihan()));
    $('input[name="edittotal_hidden"]').val(total_tagihan());

    if ($(".tbdetail").length < 1) {
      $("#btnupdate").prop("disabled", true);
      $("tfoot").hide();
    }
  });

  $('button[type="submit"]').on("click", function () {
    $("#tambah-invoice-update").prop("disabled", true);
  });

  function total_tagihan() {
    let result = 0;

    $(".edittagihan").each(function () {
      let element = $(this);
      let harga = element.attr("data-val");
      result += parseFloat(harga);
    });

    return result;
  }

  function reset() {
    $('select[name="editorderno"]').val(null).trigger("change");
    $('input[name="editplatno"]').val("");
    $('input[name="editkotaasal"]').val("");
    $('input[name="editkotatujuan"]').val("");
    $('input[name="editberat"]').val("");
    $('input[name="edithargakg"]').val("");
    $('input[name="edittagihanorder"]').val("");
    $('input[name="editnosj"]').val("");

    $("#tambah-invoice-update").prop("disabled", true);
  }
});
