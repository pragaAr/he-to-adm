$(document).ready(function () {
  $("#tfoot").hide();

  $(document).keypress(function (e) {
    if (e.which == "13") {
      e.preventDefault();
    }
  });

  $(document).on("select2:open", () => {
    document
      .querySelector(".select2-container--open .select2-search__field")
      .focus();
  });

  let cartInvoice = [];

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

          $("#suratjalan").focus();
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
    const reccu = $("#selectedReccu").val();
    const noorder = $("#selectedOrder").val();

    const valueBerat = $("#beratsj").val() ? $("#beratsj").val() : 0;

    let dataCart = {
      id: trimmedSj,
      text: trimmedSj,
    };

    const isInCart = cartInvoice.some((emp) => emp.id === dataCart.id);

    if (isInCart) {
      Swal.fire({
        icon: "warning",
        title: "Oops!",
        text: "Surat Jalan sudah ada di list!",
      });
    } else {
      cartInvoice.push(dataCart);

      const newRow = `
          <tr class="cart text-center">
            <input type="hidden" name="noorder_hidden[]" value="${noorder}">
            <td class="text-uppercase rc">
                ${reccu}
                <input type="hidden" name="rc_hidden[]" value="${reccu}">
            </td>
            <td class="text-uppercase sj">
                ${trimmedSj}
                <input type="hidden" name="sj_hidden[]" value="${trimmedSj}">
            </td>
            <td class="text-uppercase valueBerat">
                ${valueBerat}
                <input type="hidden" name="valueBerat_hidden[]" value="${valueBerat}">
            </td>
            <td class="aksi">
              <button type="button" class="btn btn-danger btn-sm border border-light" id="tombol-hapus" data-sj="${trimmedSj}" data-id="${trimmedSj}">
                Hapus
              </button>
            </td>
          </tr>
  	`;

      $("#cart tbody").append(newRow);
      $("#tfoot").show();

      $("#pengirim").prop("disabled", true);
      $("#suratjalan").val("");
      $("#beratsj").val("");

      $("#suratjalan").focus();

      $("#tambah").prop("disabled", true);
    }
  });

  $(document).on("click", "#tombol-hapus", function () {
    let idToRemove = $(this).data("id");

    if (typeof idToRemove !== "string") {
      idToRemove = idToRemove.toString();
    }

    cartInvoice = cartInvoice.filter((item) => item.id !== idToRemove);

    $(this).closest(".cart").remove();

    if ($("#tbody").children().length === 0) $("#tfoot").hide();
  });

  // =================form on submit=================
  $("#formSubmit").on("submit", function (e) {
    e.preventDefault();

    let noorderInvoice = [];
    let rcInvoice = [];
    let sjInvoice = [];
    let valberatInvoice = [];

    const custid = $("#pengirim").val();
    const selectedCust = $("#selectedCust").val();
    const selectedKodeCust = $("#selectedKodeCust").val();

    $('input[name="noorder_hidden[]"]').each(function () {
      const noorder_hidden = $(this).val();
      noorderInvoice.push(noorder_hidden);
    });

    $('input[name="rc_hidden[]"]').each(function () {
      const rc_hidden = $(this).val();
      rcInvoice.push(rc_hidden);
    });

    $('input[name="sj_hidden[]"]').each(function () {
      const sj_hidden = $(this).val();
      sjInvoice.push(sj_hidden);
    });

    $('input[name="valueBerat_hidden[]"]').each(function () {
      const valueBerat_hidden = $(this).val();
      valberatInvoice.push(valueBerat_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/invoice/proses",
      method: "POST",
      data: {
        pengirim: custid,
        noorder: noorderInvoice,
        rc: rcInvoice,
        sj: sjInvoice,
        valberat: valberatInvoice,
        selectedCust: selectedCust,
        selectedKodeCust: selectedKodeCust,
      },
      success: function (response) {
        const parsedRes = JSON.parse(response);

        const text = parsedRes.text;
        const no = parsedRes.nomorinv;

        Swal.fire({
          title: text,
          text: "Cetak Invoice ?",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Cetak tanpa PPN",
          showDenyButton: true,
          denyButtonText: "Cetak dengan PPN",
          denyButtonColor: "#3085d6",
        }).then((result) => {
          if (result.isConfirmed || result.isDenied) {
            const ppn = result.isConfirmed ? "false" : "true";
            const url =
              "http://localhost/hira-to-adm/invoice/print" +
              "?invoice=" +
              no +
              "&ppn=" +
              ppn;
            window.open(url);
          }
          window.location.href = "http://localhost/hira-to-adm/invoice";
        });
      },
    });

    cartInvoice = [];
    noorderInvoice = [];
    rcInvoice = [];
    sjInvoice = [];
    valberatInvoice = [];

    reset();
  });
  // =================form on submit=================

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
    $("#suratjalan").val("");
    $("#beratsj").val("");
  }

  function reset() {
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
    $("#suratjalan").val("");
    $("#beratsj").val("");

    $("#cart tbody").empty();
    $("#tfoot").hide();
  }
});
