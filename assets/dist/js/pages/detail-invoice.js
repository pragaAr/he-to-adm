$(".btn-detail-inv").on("click", function (e) {
  e.preventDefault();
  $("#detailInv").modal("show");

  const kd = $(this).data("id");
  const cust = $(this).data("cust");

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDetailDataInvoice",
    type: "POST",
    dataType: "json",
    data: {
      kd_inv: kd,
    },
    success: function (data) {
      console.log(data);
      $('input[name="kdinv"]').val(kd);

      $(".custname").text(cust);

      let detaildata = "";
      let no = 1;
      let hasil = 0;
      let d = new Date();

      $.each(data, function (key, value) {
        detaildata += "<tr class='text-center datadetailtr'>";

        detaildata += "<td class='text-uppercase'>" + no++ + "</td>";

        detaildata +=
          "<td class='text-uppercase'>" +
          d.getDate(value.dateAdd) +
          "/" +
          d.getMonth(value.dateAdd) +
          "/" +
          d.getFullYear(value.dateAdd) +
          "</td>";

        detaildata +=
          "<td class='text-uppercase'>" + value.surat_jalan + "</td>";

        detaildata += "<td class='text-uppercase'>" + value.platno + "</td>";

        detaildata += "<td class='text-uppercase'>" + value.no_order + "</td>";

        detaildata +=
          "<td class='text-uppercase'>" +
          value.kota_asal +
          " - " +
          value.kota_tujuan +
          "</td>";

        detaildata +=
          "<td class='text-uppercase'>" + format(value.berat) + "</td>";

        detaildata += "<td class='text-uppercase'>" + value.harga_kg + "</td>";

        detaildata +=
          "<td class='text-uppercase'>" + format(value.total_harga) + "</td>";

        detaildata += "</tr>";
        hasil += parseFloat(value.total_harga);
      });

      $("#total").html(format(hasil));

      $(".tbody-detail-inv").html(detaildata);
    },
  });

  $("#printinv").on("click", function () {
    $("#detailInv").modal("hide");
  });
});
