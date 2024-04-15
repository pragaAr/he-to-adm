$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
  return {
    iStart: oSettings._iDisplayStart,
    iEnd: oSettings.fnDisplayEnd(),
    iLength: oSettings._iDisplayLength,
    iTotal: oSettings.fnRecordsTotal(),
    iFilteredTotal: oSettings.fnRecordsDisplay(),
    iPage: Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
    iTotalPages: Math.ceil(
      oSettings.fnRecordsDisplay() / oSettings._iDisplayLength
    ),
  };
};

$("#persenTables").DataTable({
  ordering: true,
  initComplete: function () {
    var api = this.api();
    $("#persenTables_filter input")
      .off(".DT")
      .on("input.DT", function () {
        api.search(this.value).draw();
      });
  },
  lengthChange: false,
  autoWidth: false,
  processing: true,
  serverSide: true,
  ajax: {
    url: "http://localhost/hira-to-adm/persensopir/getPersenSopir",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center",
    },
    {
      data: "kd",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "nama",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "jml_order",
      className: "text-center",
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: "total_diterima",
      className: "text-center",
      render: function (data, type, row) {
        var value = parseFloat(data);
        return (
          "Rp. " + value.toLocaleString("id-ID", { minimumFractionDigits: 0 })
        );
      },
    },
    {
      data: "dateAdd",
      className: "text-center",
      render: function (data, type, row) {
        var date = new Date(data);
        return date.toLocaleDateString("id-ID", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
        });
      },
    },
    {
      data: "view",
      className: "text-center",
    },
  ],

  fnDrawCallback: function (oSettings) {
    $('[data-toggle="tooltip"]').tooltip();
  },

  rowCallback: function (row, data, iDisplayIndex) {
    var info = this.fnPagingInfo();
    var page = info.iPage;
    var length = info.iLength;
    var index = page * length + (iDisplayIndex + 1);
    $("td:eq(0)", row).html(index + ".");
  },
});

$("#btn_tambah").on("click", function () {
  $("#modalAdd").modal("show");
});

$("#modalAdd").on("shown.bs.modal", function () {
  $.ajax({
    url: "http://localhost/hira-to-adm/persensopir/getGenerateKd",
    type: "GET",
    success: function (data) {
      const parsedata = JSON.parse(data);

      $("#kd").val(parsedata);
    },
  });

  $("#tfoot").hide();

  $(document).keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

  $("#persen1").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $("#persen2").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  let cartPersen = [];

  $(".select-sopir")
    .select2({
      placeholder: "PILIH SOPIR",
      ajax: {
        url: "http://localhost/hira-to-adm/sopir/getListSopir",
        dataType: "json",
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
      },
    })
    .on("select2:select", function (e) {
      reset();

      const data = e.params.data;

      $("#namasopir").val(data.text);

      $.ajax({
        url: "http://localhost/hira-to-adm/order/getOrderBySopir",
        type: "POST",
        dataType: "json",
        data: {
          sopir: data.id,
        },
        success: function (data) {
          if (data.length === 0) {
            $("#noorder").empty();
            $(".select-noorder").val(null).trigger("change");
          } else {
            let html = "";
            for (let count = 0; count < data.length; count++) {
              html +=
                '<option value="' +
                data[count].no_order +
                '">' +
                data[count].no_order.toUpperCase() +
                "</option>";
            }
            $("#noorder").empty();

            $("#noorder").append(html);

            $(".select-noorder").val(null).trigger("change");
          }
        },
      });
    });

  $(".select-noorder")
    .select2({
      placeholder: "PILIH NO ORDER",
    })
    .on("select2:select", function (e) {
      const selectedNoOrder = e.params.data.id;

      const isInCart = cartPersen.some((emp) => emp.id === selectedNoOrder);

      if (isInCart) {
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "No Order sudah ada di list!",
        });

        $(".select-noorder").val(null).trigger("change");
      } else {
        $.ajax({
          url: "http://localhost/hira-to-adm/order/getOrderPenjualanDetail",
          type: "POST",
          dataType: "json",
          data: {
            noorder: selectedNoOrder,
          },
          success: function (data) {
            $("#platno").val(data.platno);
            $("#pengirim").val(data.pengirim);
            $("#penerima").val(data.penerima);
            $("#muatan").val(data.muatan);
            $("#asaltujuan").val(data.kota_asal + "-" + data.kota_tujuan);
            $("#totharga").val(format(data.total_hrg));
            $("#sangu").val(format(data.sangu));
            $("#tambahan").val(format(data.tambahan));
            const s = parseFloat(data.sangu);
            const t = parseFloat(data.tambahan);
            $("#totsangu").val(format(s + t));

            $("#persen1").focus();
          },
          error: function (xhr, status, error) {
            console.error("Error:", error);
          },
        });
      }
    });

  function hitungDiterima() {
    let valTotHarga = $("#totharga")
      .val()
      .replace(/[^\d.]/g, "");
    let valPersen1 = $("#persen1")
      .val()
      .replace(/[^\d.]/g, "");
    let valPersen2 = $("#persen2")
      .val()
      .replace(/[^\d.]/g, "");

    let persen1 = parseFloat(valPersen1 / 100);
    let persen2 = parseFloat(valPersen2 / 100);
    let biaya = parseFloat(valTotHarga);

    if (persen1 === 0 && persen2 === 0) {
      let biayaXpersen = parseFloat(biaya);
      $("#tambah").prop("disabled", false);

      return format(biayaXpersen);
    } else if (persen1 !== 0 && persen2 === 0) {
      let biayaXpersen = parseFloat(biaya * persen1);
      $("#tambah").prop("disabled", false);

      return format(biayaXpersen);
    } else if (persen1 === 0 && persen2 !== 0) {
      let biayaXpersen = parseFloat(biaya * persen2);
      $("#tambah").prop("disabled", false);

      return format(biayaXpersen);
    } else if (persen1 !== 0 && persen2 !== 0) {
      let biayaXpersen = parseFloat(biaya * persen1 * persen2);
      $("#tambah").prop("disabled", false);

      return format(biayaXpersen);
    }
  }

  $("#persen1").on("input keyup change", function () {
    $("#biayaxpersen").val(hitungDiterima());
  });

  $("#persen2").on("input keyup change", function () {
    $("#biayaxpersen").val(hitungDiterima());
  });

  let newData = [];

  $("button#tambah").on("click", function (e) {
    const noorder = $("#noorder").val();
    const platno = $("#platno").val();

    const dataCart = {
      id: noorder,
      text: noorder,
    };

    const isInCart = cartPersen.some((emp) => emp.id === dataCart.id);

    if (isInCart) {
      Swal.fire({
        icon: "warning",
        title: "Oops!",
        text: "No Order sudah ada di list!",
      });

      $(".select-noorder").val(null).trigger("change");
    } else {
      cartPersen.push(dataCart);

      const totharga = $("#totharga")
        .val()
        .replace(/[^\d.]/g, "");
      const persen1 = $("#persen1").val() === "" ? 0 : $("#persen1").val();
      const persen2 = $("#persen2").val() === "" ? 0 : $("#persen2").val();
      const totsangu = $("#totsangu")
        .val()
        .replace(/[^\d.]/g, "");

      const biayaxpersen = $("#biayaxpersen")
        .val()
        .replace(/[^\d.]/g, "");

      const diterima = parseFloat(biayaxpersen) - parseFloat(totsangu);

      const formatedTotHarga = format(totharga);
      const formatedTotSangu = format(totsangu);
      const formatedDiterima = format(diterima);

      newData.push({
        noorder: noorder,
        platno: platno,
        formatedTotHarga: formatedTotHarga,
        totharga: totharga,
        persen1: persen1,
        persen2: persen2,
        formatedTotSangu: formatedTotSangu,
        totsangu: totsangu,
        formatedDiterima: formatedDiterima,
        diterima: diterima,
      });

      tampilkanDataBaru();

      $(".select-noorder").val(null).trigger("change");
      $("#tambah").prop("disabled", true);
      $("#total").html(
        "<span>" + total_diterima().toLocaleString() + "</span>"
      );
      $("#total_hidden").val(total_diterima());
      $("#tfoot").show();

      reset();
    }
  });

  function tampilkanDataBaru() {
    $("#cart tbody").empty();

    newData.forEach(function (data) {
      const newRow = `
        <tr class="text-center row-cart">
          <td class="text-uppercase noorder">
            ${data.noorder}
            <input type="hidden" name="noorder_hidden[]" value="${data.noorder}">
            <input type="hidden" name="platno_hidden[]" value="${data.platno}">
          </td>
          <td class="text-right pr-4 totharga">
            ${data.formatedTotHarga}
            <input type="hidden" name="totharga_hidden[]" value="${data.totharga}">
          </td>
          <td class="persen1">
            ${data.persen1}
            <input type="hidden" name="persen1_hidden[]" value="${data.persen1}">
          </td>
          <td class="persen2">
            ${data.persen2}
            <input type="hidden" name="persen2_hidden[]" value="${data.persen2}">
          </td>
          <td class="text-right pr-4 totsangu">
            ${data.formatedTotSangu}
            <input type="hidden" name="totsangu_hidden[]" value="${data.totsangu}">
          </td>
          <td class="text-right pr-4 diterima">
            ${data.formatedDiterima}
            <input type="hidden" name="diterima_hidden[]" value="${data.diterima}">
          </td>
          <td class="action">
            <button type="button" class="btn btn-danger border border-light btn-sm" id="tombol-hapus" data-noorder="${data.noorder}">
              Hapus
            </button>
          </td>
        </tr>
      `;

      $("#cart tbody").append(newRow);
    });
  }

  $(document).on("click", "#tombol-hapus", function () {
    const noOrderToRemove = $(this).data("noorder");

    cartPersen = cartPersen.filter((item) => item.id !== noOrderToRemove);

    $(this).closest(".row-cart").remove();

    newData = newData.filter((item) => item.noorder !== noOrderToRemove);

    $(".select-noorder").val(null).trigger("change");
    $("#tambah").prop("disabled", true);
    $("#total").html("<span>" + total_diterima().toLocaleString() + "</span>");
    $("#total_hidden").val(total_diterima());

    if ($("#tbody").children().length === 0) $("#tfoot").hide();
  });

  function total_diterima() {
    let hasil = 0;
    $(".diterima").each(function () {
      hasil += parseFloat(
        $(this)
          .text()
          .replace(/[^\d.]/g, "")
      );
    });

    return hasil;
  }

  $("#form_add").on("submit", function (e) {
    e.preventDefault();

    let arrNoOrder = [];
    let arrPlatNo = [];
    let arrTotHarga = [];
    let arrPersen1 = [];
    let arrPersen2 = [];
    let arrTotSangu = [];
    let arrDiterima = [];

    const kd = $("#kd").val();
    const sopirId = $("#sopirid").val();
    const total = $("#total_hidden").val();

    $('input[name="noorder_hidden[]"]').each(function () {
      const noorder_hidden = $(this).val();
      arrNoOrder.push(noorder_hidden);
    });

    $('input[name="platno_hidden[]"]').each(function () {
      const platno_hidden = $(this).val();
      arrPlatNo.push(platno_hidden);
    });

    $('input[name="totharga_hidden[]"]').each(function () {
      const totharga_hidden = $(this).val();
      arrTotHarga.push(totharga_hidden);
    });

    $('input[name="persen1_hidden[]"]').each(function () {
      const persen1_hidden = $(this).val();
      arrPersen1.push(persen1_hidden);
    });

    $('input[name="persen2_hidden[]"]').each(function () {
      const persen2_hidden = $(this).val();
      arrPersen2.push(persen2_hidden);
    });

    $('input[name="totsangu_hidden[]"]').each(function () {
      const totsangu_hidden = $(this).val();
      arrTotSangu.push(totsangu_hidden);
    });

    $('input[name="diterima_hidden[]"]').each(function () {
      const diterima_hidden = $(this).val();
      arrDiterima.push(diterima_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/persensopir/add",
      method: "POST",
      data: {
        noorder: arrNoOrder,
        platno: arrPlatNo,
        totharga: arrTotHarga,
        persen1: arrPersen1,
        persen2: arrPersen2,
        totsangu: arrTotSangu,
        diterima: arrDiterima,
        kd: kd,
        sopirid: sopirId,
        total: total,
      },
      success: function (response) {
        $("#modalAdd").modal("hide");

        const parsedRes = JSON.parse(response);

        const resCode = parsedRes.kd;
        const resText = parsedRes.text;

        Swal.fire({
          title: resText,
          text: "Cetak pengeluaran kas ?",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak !",
        }).then((result) => {
          if (result.value) {
            window.open(
              "http://localhost/hira-to-adm/persensopir/printDataPersen/" +
                resCode
            );
          }
        });

        $("#persenTables").DataTable().ajax.reload(null, false);
      },
    });
  });

  function reset() {
    $("#platno").val("");
    $("#pengirim").val("");
    $("#penerima").val("");
    $("#muatan").val("");
    $("#asaltujuan").val("");
    $("#totharga").val("");
    $("#sangu").val("");
    $("#tambahan").val("");
    $("#totsangu").val("");
    $("#persen1").val("");
    $("#persen2").val("");
    $("#biayaxpersen").val("");
  }
});

$("#modalAdd").on("hide.bs.modal", function () {
  $(".select-sopir").val(null).trigger("change");
});

$("#persenTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/persensopir/getDetailData",
    method: "POST",
    dataType: "JSON",
    data: {
      kd: kd,
    },
    success: function (data) {
      const tbodyDetail = $("#tbodyDetail");
      tbodyDetail.empty();

      $("#kdum").val(kd);

      const kdtgl = $(".kdtgl");

      const formatedTgl = new Date(data.data.dateAdd);

      kdtgl.text(
        "KD " +
          kd +
          " - Tgl " +
          formatedTgl.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
          })
      );

      const total = $(".total");
      total.text(
        "Total Rp. " +
          format(data.data.jml_nominal) +
          " - " +
          data.data.jml_penerima +
          " Orang"
      );

      const detail = data.detail;

      for (let i = 0; i < detail.length; i++) {
        const row = $("<tr>");
        row.append("<td class='text-center'>" + (i + 1) + "." + "</td>");

        row.append("<td class='text-uppercase'>" + detail[i].nama + "</td>");
        row.append(
          "<td class='text-uppercase text-right pr-4'>" +
            format(detail[i].nominal) +
            "</td>"
        );

        tbodyDetail.append(row);
      }

      $("#modalDetail").modal("show");
      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#persenTables").on("click", ".btn-delete", function () {
  const kd = $(this).data("kd");

  Swal.fire({
    title: "Apakah anda yakin ?",
    text: "Data akan di hapus !!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Batal",
    confirmButtonText: "Ya, Hapus !",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "http://localhost/hira-to-adm/persensopir/delete",
        method: "POST",
        data: { kd: kd },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Persen Sopir dihapus!",
          });

          $("#persenTables").DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});
