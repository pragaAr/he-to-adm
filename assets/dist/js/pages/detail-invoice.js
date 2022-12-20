$(".btn-detail-inv").on("click", function () {
  const kd = $(this).data("id");

  $.ajax({
    url: "http://localhost/hira-to-adm/invoice/getDetailDataInvoice",
    type: "POST",
    dataType: "json",
    data: {
      kd_inv: id,
    },
    success: function (data) {
      console.log(data);
      // $(".editkd").val(id);
      // $(".edittanggal").val(tgl);
      // $(".editnamacust").val(namaCust);
      // getresi();
      // $('input[name="editcust_hidden"]').val(namaCust);

      // let datadetail = "";
      // let hasil = 0;

      // $.each(data, function (key, value) {
      //   datadetail += "<tr class='text-center tbdetail'>";
      //   datadetail +=
      //     "<td class='text-uppercase editorderno'>" +
      //     value.no_order +
      //     "<input type='hidden' class='form-control' name='noorder_hidden[]' value='" +
      //     value.no_order +
      //     "'readonly></td>";
      //   datadetail +=
      //     "<td class='text-uppercase editnosj'>" +
      //     value.surat_jalan +
      //     "<input type='hidden' class='form-control' name='sj_hidden[]' value='" +
      //     value.surat_jalan +
      //     "'readonly></td>";
      //   datadetail +=
      //     "<td class='text-uppercase edittagihan' data-val='" +
      //     value.total_harga +
      //     "'>" +
      //     format(value.total_harga) +
      //     "<input type='hidden' class='form-control' name='harga_hidden[]' value='" +
      //     value.total_harga +
      //     "'readonly></td>";
      //   datadetail +=
      //     "<td class='action'>" +
      //     "<button type='button' class='btn btn-danger btn-sm' id='btn-hapus-noorder' title='Hapus Resi'>" +
      //     "<i class='fas fa-times'></i>" +
      //     "</button>" +
      //     "</td>";
      //   datadetail += "</tr>";
      //   hasil += parseFloat(value.total_harga);
      // });

      // $("#edittotal").html(format(hasil));

      // $('input[name="edittotal_hidden"]').val(hasil);
      // $(".tbody-cart-inv").html(datadetail);
    },
  });
});
