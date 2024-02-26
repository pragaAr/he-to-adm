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
      data: "penerima",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "jenis_muatan",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "pembayaran",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "total_hrg",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return "Rp. " + format(data);
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

$("#addPenjualan").on("click", function () {
  $("#modalAddPenjualan").modal("show");
});

$("#modalAddPenjualan").on("shown.bs.modal", function () {
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
      placeholder: "Pilih No Order",
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
      $("#tglorder").val(data.tgl);
      $("#pengirim").val(data.cust);
      $("#asal").val(data.asal);
      $("#tujuan").val(data.tujuan);
      $("#muatan").val(data.muatan);

      $("#alamatasal").focus();
    });

  $(".select-jenis").select2({
    placeholder: "Pilih Jenis Penjualan",
  });

  $(".select-pembayaran").select2({
    placeholder: "Pilih Pembayaran",
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
      $("#borong").prop("readonly", false).focus();
    } else {
      $("#berat-tonase").css("display", "flex");
      $("#harga-borong").css("display", "none");
      $("#total-harga").removeClass("col-md-4");
      $("#total-harga").addClass("col-md-8");
      $("#borong").val("");
      $("#biaya").val("");
      $("#borong").prop("readonly", true);
      $("#berat").prop("readonly", false).focus();
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
    let beratTon = $("#berat").val();
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

$("#form_add").on("submit", function (e) {
  e.preventDefault();

  const noorder = $("#noorder").val();
  const pengirim = $("#pengirim").val();
  const asal = $("#asal").val();
  const tujuan = $("#tujuan").val();
  const muatan = $("#muatan").val();
  const alamatasal = $("#alamatasal").val();
  const alamattujuan = $("#alamattujuan").val();
  const nosj = $("#nosj").val();
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
      noorder: noorder,
      pengirim: pengirim,
      asal: asal,
      tujuan: tujuan,
      muatan: muatan,
      alamatasal: alamatasal,
      alamattujuan: alamattujuan,
      nosj: nosj,
      penerima: penerima,
      jenis: jenis,
      berat: berat,
      tonase: tonase,
      borong: borong,
      biaya: biaya,
      pembayaran: pembayaran,
    },
    success: function (data) {
      $("#noorder").val(null).trigger("change");
      $("#tglorder").val("");
      $("#pengirim").val("");
      $("#asal").val("");
      $("#tujuan").val("");
      $("#muatan").val("");
      $("#alamatasal").val("");
      $("#alamattujuan").val("");
      $("#nosj").val("");
      $("#penerima").val("");
      $("#jenis").val(null).trigger("change");
      $("#berat").val("");
      $("#tonase").val("");
      $("#borong").val("");
      $("#biaya").val("");
      $("#pembayaran").val(null).trigger("change");

      $("#modalAddPenjualan").modal("hide");

      Swal.fire({
        icon: "success",
        title: "Success!",
        text: "Data Penjualan ditambahkan!",
      });

      $("#salesTables").DataTable().ajax.reload(null, false);
    },
  });

  return false;
});

$("#modalUpdateOrder").on("shown.bs.modal", function () {
  $("#custidedit").focus();

  $(".select-custedit")
    .select2({
      placeholder: "Pilih Customer",
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
      $("#namecustedit").val(data.text);
      $("#notelpedit").val(data.telp);

      $("#muatan").focus();
    });

  $("#nextStepUpdateOrder").on("click", function () {
    $("#modalUpdateOrder").modal("hide");
    $("#modalEditSanguOrder").modal("show");
  });

  // addNewCustModal
  $("#addNewCustEdit").on("click", function () {
    $("#modalUpdateOrder").css("z-index", 1040);
    $("#modalAddNewCust").modal("show");
  });

  $("#modalAddNewCust").on("hidden.bs.modal", function () {
    $("#modalUpdateOrder").css("z-index", 1050);
  });

  $("#modalAddNewCust").on("shown.bs.modal", function () {
    $("#namacust").focus();
  });

  $("#btn_submitNewCust").on("click", function (e) {
    e.preventDefault();

    const namacust = $("#namacust").val();
    const notelpcust = $("#notelpcust").val();
    const alamatcust = $("#alamatcust").val();

    $.ajax({
      url: "http://localhost/hira-to-adm/customer/addNewSelect",
      method: "POST",
      data: {
        nama: namacust,
        notelp: notelpcust,
        alamat: alamatcust,
      },
      success: function (response) {
        $("#namacust").val("");
        $("#notelpcust").val("");
        $("#alamatcust").val("");

        $("#modalAddNewCust").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Customer Baru ditambahkan!",
        });

        const dataparse = JSON.parse(response);
        const newOption = new Option(dataparse.text, dataparse.id, true, true);

        $("#custidedit").append(newOption).trigger("change");

        $("#namecustedit").val(dataparse.text);
        $("#notelpedit").val(dataparse.telp);
      },
    });
  });
  // addNewCustModal
});

$("#modalEditSanguOrder").on("shown.bs.modal", function () {
  $("#platedit").focus();

  $(".select-truckedit")
    .select2({
      placeholder: "Pilih Truck",
      ajax: {
        url: "http://localhost/hira-to-adm/armada/getListArmada",
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
      $("#platnoedit").val(data.text);
    });

  $(".select-sopiredit")
    .select2({
      placeholder: "Pilih Sopir",
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
      const data = e.params.data;
      $("#namasopiredit").val(data.text);
    });

  $("#nominaledit").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominaledit").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#backEditOrder").on("click", function () {
    $("#modalEditSanguOrder").modal("hide");
    $("#modalUpdateOrder").modal("show");
  });
});

$("#salesTables").on("click", ".btn-edit", function (e) {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getDataKd",
    type: "POST",
    data: {
      kd: kd,
    },
    success: function (data) {
      const parsedata = JSON.parse(data);

      const custid = parsedata.customer_id;
      const truckid = parsedata.truck_id;
      const sopirid = parsedata.sopir_id;

      $("#ordernumberedit").val(parsedata.no_order);
      $("#notelpedit").val(parsedata.kontak_order);
      $("#muatanedit").val(parsedata.jenis_muatan);
      $("#asaledit").val(parsedata.asal_order);
      $("#tujuanedit").val(parsedata.tujuan_order);
      $("#keteranganedit").val(parsedata.keterangan);
      $("#nominaledit").val(format(parsedata.nominal));

      $.ajax({
        url: "http://localhost/hira-to-adm/customer/getListCustomer",
        type: "GET",
        dataType: "json",
        success: function (custData) {
          const custedit = $(".select-custedit").select2({
            placeholder: "Pilih Customer",
            data: custData,
          });

          $.each(custData, function (i, cust) {
            if (cust.id === custid) {
              custedit.val(cust.id).trigger("change");
              return false;
            }
          });
        },
      });

      $.ajax({
        url: "http://localhost/hira-to-adm/armada/getListArmada",
        type: "GET",
        dataType: "json",
        success: function (truckData) {
          const truckedit = $(".select-truckedit").select2({
            placeholder: "Pilih Truck",
            data: truckData,
          });

          $.each(truckData, function (i, truck) {
            if (truck.id === truckid) {
              truckedit.val(truck.id).trigger("change");
              return false;
            }
          });
        },
      });

      $.ajax({
        url: "http://localhost/hira-to-adm/sopir/getListSopir",
        type: "GET",
        dataType: "json",
        success: function (sopirData) {
          const sopiredit = $(".select-sopiredit").select2({
            placeholder: "Pilih Sopir",
            data: sopirData,
          });

          $.each(sopirData, function (i, sopir) {
            if (sopir.id === sopirid) {
              sopiredit.val(sopir.id).trigger("change");
              return false;
            }
          });
        },
      });

      $("#modalUpdateOrder").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#form_updateOrder").on("submit", function (e) {
  e.preventDefault();

  const ordernumber = $("#ordernumberedit").val();
  const custid = $("#custidedit").val();
  const namecust = $("#namecustedit").val();
  const notelp = $("#notelpedit").val();
  const muatan = $("#muatanedit").val();
  const asal = $("#asaledit").val();
  const tujuan = $("#tujuanedit").val();
  const keterangan = $("#keteranganedit").val();

  const plat = $("#platedit").val();
  const platno = $("#platnoedit").val();
  const sopir = $("#sopiredit").val();
  const namasopir = $("#namasopiredit").val();
  const nominal = $("#nominaledit").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/order/update",
    type: "POST",
    data: {
      ordernumber: ordernumber,
      custid: custid,
      namecust: namecust,
      notelp: notelp,
      muatan: muatan,
      asal: asal,
      tujuan: tujuan,
      keterangan: keterangan,

      plat: plat,
      platno: platno,
      sopir: sopir,
      namasopir: namasopir,
      nominal: nominal,
    },
    success: function (data) {
      $("#ordernumberedit").val("");
      $("#custidedit").val(null).trigger("change");
      $("#namecustedit").val("");
      $("#notelpedit").val("");
      $("#muatanedit").val("");
      $("#asaledit").val("");
      $("#tujuanedit").val("");

      $("#platedit").val(null).trigger("change");
      $("#platnoedit").val("");
      $("#sopiredit").val(null).trigger("change");
      $("#namasopiredit").val("");
      $("#nominaledit").val("");

      $("#modalEditSanguOrder").modal("hide");

      Swal.fire({
        icon: "success",
        title: "Success!",
        text: "Data Order diubah!",
      });

      $("#salesTables").DataTable().ajax.reload(null, false);
    },
  });

  return false;
});

$("#salesTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getDetail",
    type: "POST",
    dataType: "json",
    data: {
      kd: kd,
    },
    success: function (data) {
      console.log(data);
      $("#btnDetail").attr(
        "href",
        "http://localhost/hira-to-adm/order/print/" + data.no_order
      );

      $(".noorder").text(data.no_order);
      $(".muatan").text(data.jenis_muatan);
      $(".cust").text(data.nama_customer);
      $(".kontak").text(data.kontak_order);
      $(".asal").text(data.asal_order);
      $(".tujuan").text(data.tujuan_order);
      $(".tgl").text(data.dateAdd);

      $(".truck").text(data.platno);
      $(".supir").text(data.nama_sopir);
      $(".nominal").text("Rp. " + format(data.nominal));

      $("#modalDetailOrder").modal("show");
    },
  });
});

$("#salesTables").on("click", ".btn-delete", function () {
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
        url: "http://localhost/hira-to-adm/order/delete",
        method: "POST",
        data: { kd: kd },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Order dihapus!",
          });

          $("#salesTables").DataTable().ajax.reload(null, false);
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
