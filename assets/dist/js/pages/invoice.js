$(document).ready(function () {
  $("#cust").on("change", function () {
    const namacust = $(this).val();
    $.ajax({
      url: "http://localhost/hira-to-adm/invoice/getOrderCust",
      type: "POST",
      dataType: "json",
      data: {
        pengirim: namacust,
      },
      success: function (res) {
        console.log(res);

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
        console.log(data);
        $(".platno").val(data.platno);
        $(".kotaasal").val(data.kota_asal);
        $(".kotatujuan").val(data.kota_tujuan);
        $(".berat").val(format(data.berat));
        $(".hargakg").val(format(data.harga_kg));
        $(".tagihan").val(format(data.total_harga));
      },
    });
  });

  function reset() {
    $('input[name="platno"]').val("");
    $('input[name="kotaasal"]').val("");
    $('input[name="kotatujuan"]').val("");
    $('input[name="berat"]').val("");
    $('input[name="hargakg"]').val("");
    $('input[name="tagihan"]').val("");
  }
});
