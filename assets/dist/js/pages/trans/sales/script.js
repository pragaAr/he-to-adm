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

$("#salesTables").DataTable({
  ordering: true,
  order: [[0, "desc"]],

  initComplete: function () {
    var api = this.api();
    $("#salesTables_filter input")
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
    url: "http://localhost/hira-to-adm/penjualan/getPenjualan",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center align-middle",
    },
    {
      data: "reccu",
      className: "text-center align-middle",
      render: function (data, type, row) {
        if (data === "") {
          return "-";
        } else {
          return data.toUpperCase();
        }
      },
    },
    {
      data: "no_order",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "jenis",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "pengirim",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "muatan",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "total_hrg",
      className: "text-center align-middle",
      render: function (data, type, row) {
        if (row.pembayaran == "tempo") {
          return "<span class='text-warning'> Rp. " + format(data) + "</span>";
        } else {
          return "<span class='text-success'> Rp. " + format(data) + "</span>";
        }
      },
    },
    {
      data: "tgl_order",
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

$("#addPenjualan").on("click", function () {
  $("#modalAddPenjualan").modal("show");
});

$("#modalAddPenjualan").on("shown.bs.modal", function () {
  $.ajax({
    url: "http://localhost/hira-to-adm/penjualan/getReccu",
    type: "GET",
    success: function (data) {
      const parsedata = JSON.parse(data);

      $("#reccu").val(parsedata);
    },
  });

  $("#berat").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#berat").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#tonase").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#tonase").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#borong").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#borong").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#biaya").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#biaya").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $(".select-noorder")
    .select2({
      placeholder: "PILIH NO ORDER",
      ajax: {
        url: "http://localhost/hira-to-adm/order/getListOrder",
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

      $("#textnoorder").val(data.text);
      $("#tglorder").val(data.tgl);
      $("#tglreccu").val(data.tgl);
      $("#pengirim").val(data.cust);
      $("#asal").val(data.asal);
      $("#tujuan").val(data.tujuan);
      $("#muatan").val(data.muatan);

      $("#tglreccu").focus();
    });

  $(".select-jenis")
    .select2({
      placeholder: "PILIH JENIS PENJUALAN",
    })
    .on("select2:select", function (e) {
      let selected = e.params.data.id;

      if (selected === "borong") {
        $("#borong").focus();
      } else if (selected === "tonase") {
        $("#berat").focus();
      }
    });

  $(".select-pembayaran").select2({
    placeholder: "PILIH PEMBAYARAN",
  });

  $("#jenis").on("change", function () {
    if ($("#jenis").val() == "borong") {
      $("#berat-tonase").css("display", "none");
      $("#harga-borong").css("display", "block");
      $("#total-harga").removeClass("col-md-8");
      $("#total-harga").addClass("col-md-4");
      $("#berat").prop("readonly", true);
      $("#tonase").prop("readonly", true);
      $("#berat").val("");
      $("#tonase").val("");
      $("#biaya").val("");
      $("#borong").prop("readonly", false);
    } else {
      $("#berat-tonase").css("display", "flex");
      $("#harga-borong").css("display", "none");
      $("#total-harga").removeClass("col-md-4");
      $("#total-harga").addClass("col-md-8");
      $("#borong").val("");
      $("#biaya").val("");
      $("#borong").prop("readonly", true);
      $("#berat").prop("readonly", false);
      $("#tonase").prop("readonly", false);
    }
  });

  $("#berat").on("input keyup change", function () {
    $("#biaya").val(biayaTonase());
  });

  $('input[name="tonase"]').on("input keyup change", function () {
    $("#biaya").val(biayaTonase());
  });

  $("#borong").on("input keyup change", function () {
    $("#biaya").val(biayaBorong());
  });

  function biayaTonase() {
    let beratTon = $("#berat")
      .val()
      .replace(/[^\d.]/g, "");
    let biayaTon = $("#tonase")
      .val()
      .replace(/[^\d.]/g, "");
    let totTon = biayaTon * beratTon;
    return format(totTon);
  }

  function biayaBorong() {
    let biaya = $("#borong")
      .val()
      .replace(/[^\d.]/g, "");

    let tot = biaya;
    return format(tot);
  }
});

$("#form_add").on("submit", function () {
  const reccu = $("#reccu").val();
  const noorder = $("#noorder").val();
  const tglreccu = $("#tglreccu").val();
  const textnoorder = $("#textnoorder").val();
  const pengirim = $("#pengirim").val();
  const asal = $("#asal").val();
  const tujuan = $("#tujuan").val();
  const muatan = $("#muatan").val();
  const alamatasal = $("#alamatasal").val();
  const alamattujuan = $("#alamattujuan").val();
  const penerima = $("#penerima").val();
  const jenis = $("#jenis").val();
  const berat = $("#berat").val();
  const tonase = $("#tonase").val();
  const borong = $("#borong").val();
  const biaya = $("#biaya").val();
  const pembayaran = $("#pembayaran").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/penjualan/add",
    type: "POST",
    data: {
      reccu: reccu,
      noorder: noorder,
      tglreccu: tglreccu,
      textnoorder: textnoorder,
      pengirim: pengirim,
      asal: asal,
      tujuan: tujuan,
      muatan: muatan,
      alamatasal: alamatasal,
      alamattujuan: alamattujuan,
      penerima: penerima,
      jenis: jenis,
      berat: berat,
      tonase: tonase,
      borong: borong,
      biaya: biaya,
      pembayaran: pembayaran,
    },
    success: function (data) {
      $("#reccu").val("");
      $("#noorder").val(null).trigger("change");
      $("#textnoorder").val("");
      $("#tglorder").val("");
      $("#tglreccu").val("");
      $("#pengirim").val("");
      $("#asal").val("");
      $("#tujuan").val("");
      $("#muatan").val("");
      $("#alamatasal").val("");
      $("#alamattujuan").val("");
      $("#penerima").val("");
      $("#jenis").val(null).trigger("change");
      $("#berat").val("");
      $("#tonase").val("");
      $("#borong").val("");
      $("#biaya").val("");
      $("#pembayaran").val(null).trigger("change");

      $("#modalAddPenjualan").modal("hide");

      const parsedData = JSON.parse(data);

      Swal.fire({
        title: "Data Penjualan ditambahkan!",
        text: "Cetak reccu ??",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Ya, Cetak !",
      }).then((result) => {
        if (result.isConfirmed) {
          const url =
            "http://localhost/hira-to-adm/penjualan/print" +
            "?reccu=" +
            parsedData;

          window.open(url);
        }
      });

      $("#salesTables").DataTable().ajax.reload(null, false);
    },
  });

  return false;
});

// ---------------------
$("#modalUpdatePenjualan").on("shown.bs.modal", function () {
  $("#tglreccuedit").focus();

  $("#beratedit").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#beratedit").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#tonaseedit").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#tonaseedit").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#borongedit").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#borongedit").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#biayaedit").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#biayaedit").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $(".select-jenisedit")
    .select2({
      placeholder: "PILIH JENIS PENJUALAN",
    })
    .on("select2:select", function (e) {
      let selected = e.params.data.id;

      if (selected === "borong") {
        $("#borongedit").focus();
      } else if (selected === "tonase") {
        $("#beratedit").focus();
      }
    });

  $(".select-pembayaranedit").select2({
    placeholder: "PILIH PEMBAYARAN",
  });

  $("#jenisedit").on("change", function () {
    let selected = $(this).val();

    if (selected == "borong") {
      $("#berat-tonaseedit").css("display", "none");
      $("#harga-borongedit").css("display", "block");
      $("#total-hargaedit").removeClass("col-md-8");
      $("#total-hargaedit").addClass("col-md-4");
      $("#beratedit").prop("readonly", true);
      $("#tonaseedit").prop("readonly", true);
      $("#borongedit").prop("readonly", false);
    } else if (selected == "tonase") {
      $("#berat-tonaseedit").css("display", "flex");
      $("#harga-borongedit").css("display", "none");
      $("#total-hargaedit").removeClass("col-md-4");
      $("#total-hargaedit").addClass("col-md-8");
      $("#borongedit").prop("readonly", true);
      $("#beratedit").prop("readonly", false);
      $("#tonaseedit").prop("readonly", false);
    }
  });

  $("#beratedit").on("input keyup change", function () {
    $("#biayaedit").val(biayaTonaseEdit());
  });

  $("#tonaseedit").on("input keyup change", function () {
    $("#biayaedit").val(biayaTonaseEdit());
  });

  $("#borongedit").on("input keyup change", function () {
    $("#biayaedit").val(biayaBorongEdit());
  });

  function biayaTonaseEdit() {
    let beratTonEdit = $("#beratedit")
      .val()
      .replace(/[^\d.]/g, "");
    let biayaTonEdit = $("#tonaseedit")
      .val()
      .replace(/[^\d.]/g, "");
    let totTonEdit = biayaTonEdit * beratTonEdit;
    return format(totTonEdit);
  }

  function biayaBorongEdit() {
    let biayaEdit = $("#borongedit")
      .val()
      .replace(/[^\d.]/g, "");

    let totEdit = biayaEdit;
    return format(totEdit);
  }
});
// ---------------------

$("#salesTables").on("click", ".btn-edit", function (e) {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/penjualan/getDataKd",
    type: "POST",
    data: {
      kd: kd,
    },
    success: function (data) {
      const parsedata = JSON.parse(data);
      console.log(parsedata);
      const formatedDate = new Date(parsedata.dateorder);

      $("#tglorderedit").val(parsedata.dateorder);

      $("#penjualanid").val(parsedata.id);
      $("#reccuedit").val(parsedata.reccu);
      $("#tglreccuedit").val(parsedata.dateAdd);
      $("#noorderedit").val(parsedata.no_order);
      $("#pengirimedit").val(parsedata.pengirim);
      $("#asaledit").val(parsedata.kota_asal);
      $("#tujuanedit").val(parsedata.kota_tujuan);
      $("#muatanedit").val(parsedata.muatan);
      $("#alamatasaledit").val(parsedata.alamat_asal);
      $("#alamattujuanedit").val(parsedata.alamat_tujuan);
      $("#penerimaedit").val(parsedata.penerima);
      $("#jenisedit").val(parsedata.jenis).trigger("change");
      $("#beratedit").val(parsedata.berat);
      $("#tonaseedit").val(format(parsedata.hrg_kg));
      $("#borongedit").val(format(parsedata.hrg_borong));
      $("#biayaedit").val(format(parsedata.total_hrg));
      $("#pembayaranedit").val(parsedata.pembayaran).trigger("change");
      $("#oldpayment").val(parsedata.pembayaran);
      $("#datepelunasan").val(parsedata.datePelunasan);

      if ($("#jenisedit").val() == "borong") {
        $("#berat-tonaseedit").css("display", "none");
        $("#harga-borongedit").css("display", "block");
        $("#total-hargaedit").removeClass("col-md-8");
        $("#total-hargaedit").addClass("col-md-4");
        $("#beratedit").prop("readonly", true);
        $("#tonaseedit").prop("readonly", true);

        $("#borongedit").prop("readonly", false);
      } else if ($("#jenisedit").val() == "tonase") {
        $("#berat-tonaseedit").css("display", "flex");
        $("#harga-borongedit").css("display", "none");
        $("#total-hargaedit").removeClass("col-md-4");
        $("#total-hargaedit").addClass("col-md-8");

        $("#borongedit").prop("readonly", true);
        $("#beratedit").prop("readonly", false);
        $("#tonaseedit").prop("readonly", false);
      }

      $("#modalUpdatePenjualan").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#form_update").on("submit", function (e) {
  e.preventDefault();

  const penjualanid = $("#penjualanid").val();
  const reccu = $("#reccuedit").val();
  const tglreccu = $("#tglreccuedit").val();
  const noorder = $("#noorderedit").val();
  const alamatasal = $("#alamatasaledit").val();
  const alamattujuan = $("#alamattujuanedit").val();
  const penerima = $("#penerimaedit").val();
  const jenis = $("#jenisedit").val();
  const berat = $("#beratedit").val();
  const tonase = $("#tonaseedit").val();
  const borong = $("#borongedit").val();
  const biaya = $("#biayaedit").val();
  const pembayaran = $("#pembayaranedit").val();
  const oldpayment = $("#oldpayment").val();
  const datepelunasan = $("#datepelunasan").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/penjualan/update",
    type: "POST",
    data: {
      penjualanid: penjualanid,
      reccu: reccu,
      tglreccu: tglreccu,
      noorder: noorder,
      alamatasal: alamatasal,
      alamattujuan: alamattujuan,
      penerima: penerima,
      jenis: jenis,
      berat: berat,
      tonase: tonase,
      borong: borong,
      biaya: biaya,
      pembayaran: pembayaran,
      oldpayment: oldpayment,
      datepelunasan: datepelunasan,
    },
    success: function (data) {
      $("#penjualanid").val("");
      $("#reccuedit").val("");
      $("#noorderedit").val("");
      $("#tglorderedit").val("");
      $("#tglreccuedit").val("");
      $("#pengirimedit").val("");
      $("#asaledit").val("");
      $("#tujuanedit").val("");
      $("#muatanedit").val("");
      $("#alamatasaledit").val("");
      $("#alamattujuanedit").val("");
      $("#penerimaedit").val("");
      $("#jenisedit").val(null).trigger("change");
      $("#beratedit").val("");
      $("#tonaseedit").val("");
      $("#borongedit").val("");
      $("#biayaedit").val("");
      $("#pembayaranedit").val(null).trigger("change");
      $("#oldpayment").val("");
      $("#datepelunasan").val("");

      $("#modalUpdatePenjualan").modal("hide");

      Swal.fire({
        icon: "success",
        title: "Success!",
        text: "Data Penjualan diubah!",
      });

      $("#salesTables").DataTable().ajax.reload(null, false);
    },
  });

  return false;
});

$("#salesTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");
  console.log(kd);
  $.ajax({
    url: "http://localhost/hira-to-adm/penjualan/getDataKd",
    type: "POST",
    dataType: "json",
    data: {
      kd: kd,
    },
    success: function (data) {
      const dateOrder = new Date(data.dateorder);
      const dateReccu = new Date(data.dateAdd);

      $("#dtTanggal").text(
        dateOrder.toLocaleDateString("id-ID", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
        })
      );

      $("#dtTglReccu").text(
        dateReccu.toLocaleDateString("id-ID", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
        })
      );
      $("#dtReccu").text(data.reccu);
      $("#dtNoOrder").text(data.no_order);
      $("#dtMuatan").text(data.muatan);
      $("#dtCustOrder").text(data.pengirim);
      $("#dtAsal").text(data.kota_asal);
      $("#dtTujuan").text(data.kota_tujuan);

      $("#dtJenis").text(data.jenis);
      $("#dtBerat").text(data.berat);
      $("#dtHrgKg").text("Rp. " + format(data.hrg_kg));
      $("#dtHrgBorong").text("Rp. " + format(data.hrg_borong));
      $("#dtAlamatAsal").text(data.alamat_asal);
      $("#dtAlamatTujuan").text(data.alamat_tujuan);
      $("#dtPenerima").text(data.penerima);
      $("#dtBiaya").text("Rp. " + format(data.total_hrg));
      $("#dtStatusBayar").text(data.pembayaran);

      $("#modalDetailPenjualan").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#salesTables").on("click", ".btn-delete", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getId",
    method: "POST",
    data: { kd: kd },
    success: function (data) {
      const parsedData = JSON.parse(data);

      const id = parsedData.order_id;
      const no = parsedData.no_order;

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
        if (result.isConfirmed) {
          $.ajax({
            url: "http://localhost/hira-to-adm/penjualan/delete",
            method: "POST",
            data: {
              id: id,
              no: no,
            },
            success: function (data) {
              Swal.fire({
                icon: "success",
                title: "Success!",
                text: "Data Penjualan dihapus!",
              });

              $("#salesTables").DataTable().ajax.reload(null, false);
            },
          });
        }
      });
    },
  });
});

$("#salesTables").on("click", ".btn-print", function () {
  const reccu = $(this).data("reccu");

  $.ajax({
    url: "http://localhost/hira-to-adm/penjualan/cek",
    method: "POST",
    data: { reccu: reccu },
    success: function (data) {
      if (data !== "null") {
        const parsedData = JSON.parse(data);
        const reccu = parsedData.reccu;

        Swal.fire({
          title: "Cetak Reccu ?",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak !",
        }).then((result) => {
          if (result.isConfirmed) {
            const url =
              "http://localhost/hira-to-adm/penjualan/print" +
              "?reccu=" +
              reccu;

            window.open(url);
          }
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: "Reccu tidak ditemukan!",
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);

      Swal.fire({
        icon: "error",
        title: "Error!",
        text: "Permintaan tidak dapat diproses!",
      });
    },
  });
});

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});

document.getElementById("tglreccu").addEventListener("click", function (event) {
  this.showPicker ? this.showPicker() : this.click();
});

document
  .getElementById("tglreccuedit")
  .addEventListener("click", function (event) {
    this.showPicker ? this.showPicker() : this.click();
  });
