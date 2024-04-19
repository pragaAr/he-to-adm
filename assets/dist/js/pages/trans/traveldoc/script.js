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

$("#sjTables").DataTable({
  ordering: true,
  initComplete: function () {
    var api = this.api();
    $("#sjTables_filter input")
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
    url: "http://localhost/hira-to-adm/traveldoc/getTraveldoc",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center align-middle",
    },
    {
      data: "nomor_surat",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "nama",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "jml_reccu",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data;
      },
    },
    {
      data: "jml_sj",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "dateAdd",
      searchable: false,
      className: "text-center align-middle",
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
      className: "text-center align-middle",
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

let cartSj = [];
let newData = [];

let noorder = [];
let rc = [];
let sj = [];
let ket = [];
let valberat = [];
let valretur = [];

$("#modalAdd").on("shown.bs.modal", function () {
  if ($("#tbody").children().length === 0) $("#tfoot").hide();

  $(document).keypress(function (e) {
    if (e.which == "13") {
      e.preventDefault();
    }
  });

  $(".select-pengirim")
    .select2({
      placeholder: "PILIH CUSTOMER",
      ajax: {
        url: "http://localhost/hira-to-adm/customer/getListCustomer",
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
      const data = e.params.data;

      $("#selectedCust").val(data.text);
      $("#selectedKodeCust").val(data.kode);

      $.ajax({
        url: "http://localhost/hira-to-adm/penjualan/getListCustomerReccu",
        type: "POST",
        dataType: "json",
        data: {
          cust: data.text,
        },
        success: function (data) {
          if (data.length === 0) {
            $("#reccu").empty();
            $(".select-reccu").val(null).trigger("change");
          } else {
            let html = "";
            for (let count = 0; count < data.length; count++) {
              html +=
                '<option value="' +
                data[count].reccu +
                '">' +
                data[count].reccu.toUpperCase() +
                "</option>";
            }
            $("#reccu").empty();

            $("#reccu").append(html);

            $(".select-reccu").val(null).trigger("change");

            resetOther();
          }
        },
      });
    });

  $(".select-reccu")
    .select2({
      placeholder: "PILIH RECCU",
    })
    .on("select2:select", function (e) {
      const selectedReccu = e.params.data.id;

      $.ajax({
        url: "http://localhost/hira-to-adm/penjualan/getListReccuForTravelDoc",
        type: "POST",
        dataType: "json",
        data: {
          reccu: selectedReccu,
        },
        success: function (data) {
          $("#selectedReccu").val(data.reccu);
          $("#selectedOrder").val(data.no_order);
          $("#jenis").val(data.jenis);
          $("#berat").val(data.berat);
          $("#penerima").val(data.penerima);
          $("#hrgkg").val(format(data.hrg_kg));
          $("#hrgbrg").val(format(data.hrg_borong));
          $("#tothrg").val(format(data.total_hrg));

          $("#ket").focus();
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
        },
      });
    });

  $("#reccu").on("change", function (e) {
    if ($(this).val() !== null && $("#suratjalan").val() !== "") {
      $("#tambah").prop("disabled", false);
    } else {
      $("#tambah").prop("disabled", true);
    }
  });

  $("#suratjalan").on("input", function (e) {
    if ($(this).val() !== "" && $("#reccu").val() !== null) {
      $("#tambah").prop("disabled", false);
    } else {
      $("#tambah").prop("disabled", true);
    }
  });

  $("button#tambah").on("click", function (e) {
    const ket = $("#ket").val();
    const sjval = $("#suratjalan").val();
    const trimmedSj = $.trim(sjval);
    const rc = $("#selectedReccu").val();
    const noorder = $("#selectedOrder").val();

    const valueBerat = $("#beratsj").val() ? $("#beratsj").val() : 0;
    const valueRetur = $("#retur").val() ? $("#retur").val() : 0;

    let dataSuratJalan = {
      id: trimmedSj,
      text: trimmedSj,
    };

    let dataNewData = {
      ket: ket,
      sj: trimmedSj,
      reccu: rc,
      noorder: noorder,
      valueBerat: valueBerat,
      valueRetur: valueRetur,
    };

    if (dataSuratJalan.id.trim() !== "" && dataNewData.sj.trim() !== "") {
      const isSuratJalanInCart = cartSj.some(
        (emp) => emp.id === dataSuratJalan.id
      );

      if (isSuratJalanInCart) {
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "Surat Jalan sudah ada di list!",
        });
      } else {
        cartSj.push(dataSuratJalan);
        newData.push(dataNewData);

        tampilkanDataBaru();

        $("#pengirim").prop("disabled", true);
        $("#suratjalan").val("");
        $("#beratsj").val("");
        $("#retur").val("");

        $("#suratjalan").focus();

        $("#tambah").prop("disabled", true);
      }
    } else {
      console.log("Surat jalan kosong, tidak ditambahkan ke cart baris baru");
    }
  });

  function tampilkanDataBaru() {
    $("#cart tbody").empty();

    newData.forEach(function (value) {
      if (value.sj.trim() === "") {
        return;
      }

      const newRow = `
          <tr class="cart text-center">
            <input type="hidden" name="ket_hidden[]" value="${value.ket}">
            <input type="hidden" name="noorder_hidden[]" value="${value.noorder}">
            <td class="text-uppercase rc">
                ${value.reccu}
                <input type="hidden" name="rc_hidden[]" value="${value.reccu}">
            </td>
            <td class="text-uppercase sj">
                ${value.sj}
                <input type="hidden" name="sj_hidden[]" value="${value.sj}">
            </td>
            <td class="text-uppercase valueBerat">
                ${value.valueBerat}
                <input type="hidden" name="valueBerat_hidden[]" value="${value.valueBerat}">
            </td>
            <td class="text-uppercase valueRetur">
                ${value.valueRetur}
                <input type="hidden" name="valueRetur_hidden[]" value="${value.valueRetur}">
            </td>
            <td class="aksi">
              <button type="button" class="btn btn-danger btn-sm border border-light" id="tombol-hapus" data-sj="${value.sj}" data-id="${value.sj}">
                Hapus
              </button>
            </td>
          </tr>
  	`;

      $("#cart tbody").append(newRow);
      $("#tfoot").show();
    });
  }

  $(document).on("click", "#tombol-hapus", function () {
    let idToRemove = $(this).data("id");

    if (typeof idToRemove !== "string") {
      idToRemove = idToRemove.toString();
    }

    cartSj = cartSj.filter((item) => item.id !== idToRemove);

    $(this).closest(".cart").remove();

    newData = newData.filter((item) => item.sj !== idToRemove);

    if ($("#tbody").children().length === 0) $("#tfoot").hide();
  });

  $("#form_add").on("submit", function (e) {
    e.preventDefault();

    const custid = $("#pengirim").val();
    const selectedCust = $("#selectedCust").val();
    const selectedKodeCust = $("#selectedKodeCust").val();

    $('input[name="noorder_hidden[]"]').each(function () {
      const noorder_hidden = $(this).val();
      noorder.push(noorder_hidden);
    });

    $('input[name="rc_hidden[]"]').each(function () {
      const rc_hidden = $(this).val();
      rc.push(rc_hidden);
    });

    $('input[name="sj_hidden[]"]').each(function () {
      const sj_hidden = $(this).val();
      sj.push(sj_hidden);
    });

    $('input[name="ket_hidden[]"]').each(function () {
      const ket_hidden = $(this).val();
      ket.push(ket_hidden);
    });

    $('input[name="valueBerat_hidden[]"]').each(function () {
      const valueBerat_hidden = $(this).val();
      valberat.push(valueBerat_hidden);
    });

    $('input[name="valueRetur_hidden[]"]').each(function () {
      const valueRetur_hidden = $(this).val();
      valretur.push(valueRetur_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/traveldoc/add",
      method: "POST",
      data: {
        pengirim: custid,
        noorder: noorder,
        rc: rc,
        sj: sj,
        valberat: valberat,
        valretur: valretur,
        selectedCust: selectedCust,
        selectedKodeCust: selectedKodeCust,
        ket: ket,
      },
      success: function (response) {
        const parsedRes = JSON.parse(response);

        const status = parsedRes.status;
        const title = parsedRes.title;
        const text = parsedRes.text;

        $("#modalAdd").modal("hide");

        Swal.fire({
          icon: status,
          title: title,
          text: text,
        });

        $("#sjTables").DataTable().ajax.reload(null, false);
      },
    });

    noorder = [];
    rc = [];
    sj = [];
    valberat = [];
    valretur = [];

    reset();
  });
});

function resetOther() {
  $(".select-reccu").val(null).trigger("change");
  $("#selectedReccu").val("");
  $("#selectedOrder").val("");
  $("#penerima").val("");
  $("#jenis").val("");
  $("#berat").val("");
  $("#hrgkg").val("");
  $("#hrgbrg").val("");
  $("#tothrg").val("");
  $("#ket").val("");
  $("#suratjalan").val("");
  $("#beratsj").val("");
  $("#retur").val("");
}

function reset() {
  cartSj = [];
  newData = [];

  $(".select-pengirim").val(null).trigger("change");
  $(".select-pengirim").prop("disabled", false);
  $(".select-reccu").val(null).trigger("change");
  $("#selectedReccu").val("");
  $("#selectedOrder").val("");
  $("#selectedCust").val("");
  $("#selectedKodeCust").val("");
  $("#penerima").val("");
  $("#jenis").val("");
  $("#berat").val("");
  $("#hrgkg").val("");
  $("#hrgbrg").val("");
  $("#tothrg").val("");
  $("#ket").val("");
  $("#suratjalan").val("");
  $("#beratsj").val("");
  $("#retur").val("");

  $("#cart tbody").empty();
  $("#tfoot").hide();
}

$("#sjTables").on("click", ".btn-print", function () {
  const nomor = $(this).data("nomor");

  $.ajax({
    url: "http://localhost/hira-to-adm/traveldoc/cekNomor",
    method: "POST",
    dataType: "JSON",
    data: {
      nomor: nomor,
    },
    success: function (data) {
      console.log(data);

      Swal.fire({
        title: "Cetak surat jalan ?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya, Cetak !",
      }).then((result) => {
        if (result.value) {
          window.open("http://localhost/hira-to-adm/traveldoc/print/" + data);
        }
      });

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#sjTables").on("click", ".btn-detail", function () {
  const nomor = $(this).data("nomor");

  $.ajax({
    url: "http://localhost/hira-to-adm/traveldoc/getDetailData",
    method: "POST",
    dataType: "JSON",
    data: {
      nomor: nomor,
    },
    success: function (data) {
      const tbodyDetail = $("#tbodyDetail");
      tbodyDetail.empty();

      let sumtotal = 0;

      const nosurat = $(".nosurat");
      nosurat.text("No. " + data.nomor.toUpperCase());

      const customer = $(".customer");
      customer.text(data.cust.toUpperCase());

      for (let i = 0; i < data.datasj.length; i++) {
        let totalSuratJalan = 0;

        const dateOrder = new Date(data.datasj[i].dateOrder);

        formatedTgl =
          ("0" + dateOrder.getDate()).slice(-2) +
          "/" +
          ("0" + (dateOrder.getMonth() + 1)).slice(-2) +
          "/" +
          dateOrder.getFullYear();

        const row = $("<tr>");

        row.append(
          "<td class='text-center align-middle'>" + (i + 1) + "." + "</td>"
        );
        row.append(
          "<td class='text-uppercase align-middle'>" + formatedTgl + "</td>"
        );
        row.append(
          "<td class='text-uppercase align-middle'>" +
            data.datasj[i].platno +
            "</td>"
        );

        for (let j = 0; j < data.detail.length; j++) {
          if (data.detail[j].reccu == data.datasj[i].reccu) {
            totalSuratJalan++;
          }
        }

        row.append(
          "<td class='text-uppercase align-middle'> Total Surat Jalan " +
            totalSuratJalan +
            "</td>"
        );

        row.append(
          "<td class='text-uppercase align-middle'>" +
            data.datasj[i].kota_asal +
            "-" +
            data.datasj[i].kota_tujuan +
            "</td>"
        );

        row.append(
          "<td class='text-capitalize align-middle'>" +
            data.datasj[i].berat +
            " Kg </td>"
        );

        row.append(
          "<td class='text-capitalize align-middle'> Rp. " +
            format(data.datasj[i].hrg_kg) +
            "</td>"
        );

        row.append(
          "<td class='text-capitalize align-middle'> Rp. " +
            format(data.datasj[i].total_hrg) +
            "</td>"
        );

        tbodyDetail.append(row);

        sumtotal += parseFloat(data.datasj[i].total_hrg);

        for (let j = 0; j < data.detail.length; j++) {
          const detailrow = $("<tr>");

          if (data.detail[j].reccu == data.datasj[i].reccu) {
            detailrow.append(
              "<td class='text-capitalize align-middle' style='background:#4e5357'></td>"
            );

            detailrow.append(
              "<td class='text-capitalize align-middle' style='background:#4e5357' colspan='2'>" +
                data.detail[j].ket +
                "</td>"
            );

            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#4e5357'>" +
                data.detail[j].surat_jalan +
                "</td>"
            );

            if (data.detail[j].retur == 0) {
              detailrow.append(
                "<td class='text-uppercase align-middle' style='background:#4e5357'></td>"
              );
            } else {
              detailrow.append(
                "<td class='text-capitalize align-middle' style='background:#4e5357'> Retur " +
                  data.detail[j].retur +
                  "</td>"
              );
            }

            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#4e5357'></td>"
            );
            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#4e5357'></td>"
            );
            detailrow.append(
              "<td class='text-uppercase align-middle' style='background:#4e5357'></td>"
            );

            tbodyDetail.append(detailrow);
          }
        }
      }

      const sumrow = $("<tr>");

      sumrow.append(
        "<td class='text-capitalize align-middle font-weight-bold' colspan='7'> Jumlah </td>"
      );

      sumrow.append(
        "<td class='text-capitalize align-middle font-weight-bold'> Rp. " +
          format(sumtotal) +
          " </td>"
      );

      tbodyDetail.append(sumrow);

      $("#modalDetail").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#sjTables").on("click", ".btn-delete", function () {
  const nomor = $(this).data("nomor");

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
        url: "http://localhost/hira-to-adm/traveldoc/delete",
        method: "POST",
        data: { nomor: nomor },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Surat Jalan dihapus!",
          });

          $("#sjTables").DataTable().ajax.reload(null, false);
        },
      });
    }
  });
});

// $("#btn_cetak").on("click", function () {
//   $("#modalTandaTerimaInvoice").modal("show");
// });

// $("#modalTandaTerimaInvoice").on("shown.bs.modal", function () {
//   $(".select-ttcust")
//     .select2({
//       placeholder: "PILIH CUSTOMER",
//       ajax: {
//         url: "http://localhost/hira-to-adm/customer/getListCustomer",
//         dataType: "json",
//         data: function (params) {
//           return {
//             q: params.term,
//           };
//         },
//         processResults: function (data) {
//           return {
//             results: data,
//           };
//         },
//       },
//     })
//     .on("select2:select", function (e) {
//       const data = e.params.data;

//       $("#ttcustname").val(data.text);

//       $.ajax({
//         url: "http://localhost/hira-to-adm/traveldoc/getReccuByCust",
//         type: "POST",
//         dataType: "json",
//         data: {
//           cust: $("#ttcust").val(),
//         },
//         success: function (data) {
//           if (data.length == 0) {
//             $("#ttreccu").empty();
//             $(".select-ttreccu").val(null).trigger("change");
//             $("#btn_check").prop("disabled", true);
//           } else {
//             let html = "";
//             for (let count = 0; count < data.length; count++) {
//               html +=
//                 '<option value="' +
//                 data[count].reccu +
//                 '">' +
//                 data[count].reccu.toUpperCase() +
//                 "</option>";
//             }
//             $("#ttreccu").empty();

//             $("#ttreccu").append(html);

//             $(".select-ttreccu").val(null).trigger("change");

//             $("#btn_check").prop("disabled", false);
//           }
//         },
//       });
//     });

//   $(".select-ttreccu").select2({
//     placeholder: "PILIH RECCU",
//   });

//   $(".form-check-jenis").on("input", function () {
//     const value = $(this).val();

//     if (value === "tanda-terima-surat-jalan") {
//       $("#dpp").prop("disabled", true);
//     } else if (value === "invoice") {
//       $("#dpp").prop("disabled", false);
//     }
//   });
// });

// $(".select-ttcust").on("change", function () {
//   $(".select-ttreccu").val(null).trigger("change");
// });

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});
