$(document).ready(function () {
  $("#tfoot").hide();

  $(document).keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

  $("#sopir").on("input", function () {
    const sopir = $(this).val();
    $.ajax({
      url: "http://localhost/hira-to-adm/persensopir/getOrderSopir",
      type: "POST",
      dataType: "json",
      data: {
        sopir_id: sopir,
      },
      success: function (res) {
        $(".sopirid").val(sopir);
        // Remove options
        $(".noorder").val(res.no_order).trigger("change");

        $("#noorder").find("option").not(":first").remove();

        reset();

        // Add options
        $.each(res, function (index, response) {
          $("#noorder").append(
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

  $("#noorder").on("input", function () {
    const order = $(this).val();
    $.ajax({
      url: "http://localhost/hira-to-adm/persensopir/getDataOrderSopir",
      type: "POST",
      dataType: "json",
      data: {
        no_order: order,
      },
      success: function (data) {
        console.log(data);
        $(".asaltujuan").val(data.kota_asal + " - " + data.kota_tujuan);
        $(".muatan").val(data.muatan);
        $(".pengirim").val(data.pengirim);
        $(".totalharga").val(format(data.total_harga));

        const nominalpersen = parseFloat(
          data.total_harga * (90 / 100) * (52 / 100)
        );
        $(".jumlahpersen").val(format(nominalpersen));
        $(".sangu").val(format(data.nominal));
        $(".tambahan").val(format(data.tambahan));

        const jmlsangu = parseFloat(data.nominal) + parseFloat(data.tambahan);

        $(".jumlahsangu").val(format(jmlsangu));

        const jmlterima = parseFloat(nominalpersen) - parseFloat(jmlsangu);

        $(".jumlahterima").val(format(jmlterima));
        $("#btn-persen").prop("disabled", false);
      },
    });
  });

  $("button#btn-persen").on("click", function (e) {
    const cartPersen = {
      sopir: $('select[name="sopir"]').val(),
      noorder: $('select[name="noorder"]').val(),
      jmlpersen: $('input[name="jumlahpersen"]').val(),
      jmlsangu: $('input[name="jumlahsangu"]').val(),
      nominalterima: $('input[name="jumlahterima"]').val(),
    };

    $.ajax({
      url: "http://localhost/hira-to-adm/persensopir/cart",
      type: "POST",
      data: cartPersen,
      success: function (data) {
        $("select[name=sopir]").prop("disabled", true);

        reset();

        $("#btn-persen").prop("disabled", true);

        $("table#cart tbody").append(data);
        $("#total").html("<p>" + total_diterima().toLocaleString() + "</p>");
        $('input[name="total_hidden"]').val(total_diterima());

        $("tfoot").show();
        $('[data-toggle="tooltip"]').tooltip();
      },
    });

    reset();
  });

  $(document).on("click", "#tombol-hapus", function () {
    $(this).closest(".row-cart").remove();

    $("#total").html("<p>" + total_diterima().toLocaleString() + "</p>");
    $('input[name="total_hidden"]').val(total_diterima());

    if ($("tbody").children().length == 0) $("tfoot").hide();
  });

  $('button[type="submit"]').on("click", function () {
    $('input[name="tanggal"]').prop("disabled", true);
  });

  function total_diterima() {
    let hasil = 0;
    $(".nominalterima").each(function () {
      hasil += parseFloat(
        $(this)
          .text()
          .replace(/[^\d.]/g, "")
      );
    });
    return hasil;
  }

  function reset() {
    $('input[name="asaltujuan"]').val("");
    $('input[name="muatan"]').val("");
    $('input[name="pengirim"]').val("");
    $('input[name="totalharga"]').val("");
    $('input[name="jumlahpersen"]').val("");
    $('input[name="sangu"]').val("");
    $('input[name="tambahan"]').val("");
    $('input[name="jumlahsangu"]').val("");
    $('input[name="jumlahterima"]').val("");
    $("#noorder").val(null).trigger("change");
  }
});
