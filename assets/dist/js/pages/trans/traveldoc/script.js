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

$("#modalAdd").on("shown.bs.modal", function () {
  $("#tfoot").hide();

  $(document).keypress(function (e) {
    if (e.which == "13") {
      e.preventDefault();
    }
  });

  let cartSj = [];
  let newData = [];

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
          console.log(data);

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
    const sjval = $("#suratjalan").val();
    const trimmedSj = $.trim(sjval);
    const rc = $("#selectedReccu").val();

    const dataSuratJalan = {
      id: trimmedSj,
      text: trimmedSj,
    };

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

      const valueBerat = $("#beratsj").val() ? $("#beratsj").val() : 0;
      const valueRetur = $("#retur").val() ? $("#retur").val() : 0;

      newData.push({
        sj: trimmedSj,
        reccu: rc,
        valueBerat: valueBerat,
        valueRetur: valueRetur,
      });

      tampilkanDataBaru();

      $("#pengirim").prop("disabled", true);
      $("#suratjalan").val("");
      $("#beratsj").val("");
      $("#retur").val("");

      $("#suratjalan").focus();

      $("#tambah").prop("disabled", true);
    }
  });

  function tampilkanDataBaru() {
    $("#cart tbody").empty();

    newData.forEach(function (data) {
      const newRow = `
          <tr class="cart text-center">
            <td class="text-uppercase rc">
                ${data.reccu}
                <input type="hidden" name="rc_hidden[]" value="${data.reccu}">
            </td>
            <td class="text-uppercase sj">
                ${data.sj}
                <input type="hidden" name="sj_hidden[]" value="${data.sj}">
            </td>
            <td class="text-uppercase valueBerat">
                ${data.valueBerat}
                <input type="hidden" name="valueBerat_hidden[]" value="${data.valueBerat}">
            </td>
            <td class="text-uppercase valueRetur">
                ${data.valueRetur}
                <input type="hidden" name="valueRetur_hidden[]" value="${data.valueRetur}">
            </td>
            <td class="aksi">
              <button type="button" class="btn btn-danger btn-sm border border-light" id="tombol-hapus" data-sj="${data.sj}" data-id="${data.sj}">
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

    if ($("#tbody").children().length == 0) $("#tfoot").hide();

    console.log(idToRemove, cartSj);
  });

  $("#form_add").on("submit", function (e) {
    e.preventDefault();

    let rc = [];
    let sj = [];
    let valberat = [];
    let valretur = [];

    const custid = $("#pengirim").val();
    const selectedCust = $("#selectedCust").val();
    const ket = $("#ket").val();

    $('input[name="rc_hidden[]"]').each(function () {
      const rc_hidden = $(this).val();
      rc.push(rc_hidden);
    });

    $('input[name="sj_hidden[]"]').each(function () {
      const sj_hidden = $(this).val();
      sj.push(sj_hidden);
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
        rc: rc,
        sj: sj,
        valberat: valberat,
        valretur: valretur,
        selectedCust: selectedCust,
        ket: ket,
      },
      success: function (response) {
        const parsedRes = JSON.parse(response);

        console.log(parsedRes);

        const status = parsedRes.status;
        const title = parsedRes.title;
        const text = parsedRes.text;

        // $("#modalAdd").modal("hide");

        Swal.fire({
          icon: status,
          title: title,
          text: text,
        });

        $("#sjTables").DataTable().ajax.reload(null, false);
      },
    });

    rc = [];
    sj = [];
    valberat = [];
    valretur = [];

    reset();
  });

  function reset() {
    $(".select-pengirim").val(null).trigger("change");
    $(".select-pengirim").prop("disabled", false);
    $(".select-reccu").val(null).trigger("change");
    $("#selectedReccu").val("");
    $("#selectedOrder").val("");
    $("#selectedCust").val("");
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

    cartSj = [];
    newData = [];
  }
});

$("#sjTables").on("click", ".btn-detail", function () {
  const reccu = $(this).data("reccu");

  $.ajax({
    url: "http://localhost/hira-to-adm/traveldoc/getDetailData",
    method: "POST",
    dataType: "JSON",
    data: {
      reccu: reccu,
    },
    success: function (data) {
      const tbodyDetail = $("#tbodyDetail");
      tbodyDetail.empty();

      const reccutgl = $(".reccutgl");

      const formatedTgl = new Date(data.data.dateAdd);

      reccutgl.text(
        "Reccu " +
          reccu +
          " - Tgl " +
          formatedTgl.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
          })
      );

      const jmlsj = $(".jmlsj");
      jmlsj.text("Total " + format(data.data.jml_sj) + " Surat Jalan");

      const detail = data.detail;

      for (let i = 0; i < detail.length; i++) {
        const row = $("<tr>");
        row.append("<td class='text-center'>" + (i + 1) + "." + "</td>");

        row.append("<td class='text-uppercase'>" + detail[i].reccu + "</td>");
        row.append(
          "<td class='text-uppercase'>" + detail[i].surat_jalan + "</td>"
        );
        row.append(
          "<td class='text-right pr-4'>" +
            format(detail[i].berat) +
            " Kg" +
            "</td>"
        );
        row.append(
          "<td class='text-right pr-4'>" + format(detail[i].retur) + "</td>"
        );

        tbodyDetail.append(row);
      }

      $("#modalDetail").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#sjTables").on("click", ".btn-delete", function () {
  const reccu = $(this).data("reccu");

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
        data: { reccu: reccu },
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

$("#btn_cetak").on("click", function () {
  $("#modalTandaTerimaInvoice").modal("show");
});

$("#modalTandaTerimaInvoice").on("shown.bs.modal", function () {
  $(".select-ttcust")
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

      $("#ttcustname").val(data.text);

      $.ajax({
        url: "http://localhost/hira-to-adm/traveldoc/getReccuByCust",
        type: "POST",
        dataType: "json",
        data: {
          cust: $("#ttcust").val(),
        },
        success: function (data) {
          if (data.length == 0) {
            $("#ttreccu").empty();
            $(".select-ttreccu").val(null).trigger("change");
            $("#btn_check").prop("disabled", true);
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
            $("#ttreccu").empty();

            $("#ttreccu").append(html);

            $(".select-ttreccu").val(null).trigger("change");

            $("#btn_check").prop("disabled", false);
          }
        },
      });
    });

  $(".select-ttreccu").select2({
    placeholder: "PILIH RECCU",
  });

  $(".form-check-jenis").on("input", function () {
    const value = $(this).val();

    if (value === "tanda-terima-surat-jalan") {
      $("#dpp").prop("disabled", true);
    } else if (value === "invoice") {
      $("#dpp").prop("disabled", false);
    }
  });
});

$(".select-ttcust").on("change", function () {
  $(".select-ttreccu").val(null).trigger("change");
});

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});
