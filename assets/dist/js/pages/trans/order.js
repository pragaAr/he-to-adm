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

$("#orderTables").DataTable({
  ordering: true,
  initComplete: function () {
    var api = this.api();
    $("#orderTables_filter input")
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
    url: "http://localhost/hira-to-adm/order/getOrder",
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
      data: "nama",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "asal_order",
      className: "text-center align-middle",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "tujuan_order",
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
      data: "kontak_order",
      className: "text-center text-capitalize align-middle",
      render: function (data, type, row) {
        return data == "" ? "-" : data;
      },
    },
    {
      data: "keterangan",
      className: "text-center text-capitalize align-middle",
      render: function (data, type, row) {
        return data == "" ? "-" : data;
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

$("#addOrder").on("click", function () {
  $("#modalAddOrder").modal("show");
});

$("#modalAddOrder").on("shown.bs.modal", function () {
  $("#custid").focus();

  $(".select-cust")
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
      $("#namecust").val(data.text);
      $("#notelp").val(data.telp);

      $("#muatan").focus();
    });

  $("#nextStepOrder").on("click", function () {
    $("#modalAddOrder").modal("hide");
    $("#modalAddSanguOrder").modal("show");
  });

  $.ajax({
    url: "http://localhost/hira-to-adm/order/getKdOrder",
    type: "GET",
    dataType: "json",
    success: function (data) {
      $("#ordernumber").val(data);
    },
  });

  // addNewCustModal
  $("#addNewCust").on("click", function () {
    $("#modalAddOrder").css("z-index", 1040);
    $("#modalAddNewCust").modal("show");
  });

  $("#modalAddNewCust").on("hidden.bs.modal", function () {
    $("#modalAddOrder").css("z-index", 1050);
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

        $("#custid").append(newOption).trigger("change");

        $("#namecust").val(dataparse.text);
        $("#notelp").val(dataparse.telp);

        $("#muatan").focus();
      },
    });
  });
  // addNewCustModal
});

$("#modalAddSanguOrder").on("shown.bs.modal", function () {
  $("#plat").focus();

  $(".select-truck")
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
      $("#platno").val(data.text);
    });

  $(".select-sopir")
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
      $("#namasopir").val(data.text);
    });

  $("#nominal").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominal").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  $("#backAddOrder").on("click", function () {
    $("#modalAddSanguOrder").modal("hide");
    $("#modalAddOrder").modal("show");
  });
});

$("#form_addOrder").on("submit", function (e) {
  e.preventDefault();

  const ordernumber = $("#ordernumber").val();
  const custid = $("#custid").val();
  const namecust = $("#namecust").val();
  const notelp = $("#notelp").val();
  const muatan = $("#muatan").val();
  const asal = $("#asal").val();
  const tujuan = $("#tujuan").val();
  const keterangan = $("#keterangan").val();

  const plat = $("#plat").val();
  const platno = $("#platno").val();
  const sopir = $("#sopir").val();
  const namasopir = $("#namasopir").val();
  const nominal = $("#nominal").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/order/add",
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
      $("#ordernumber").val("");
      $("#custid").val(null).trigger("change");
      $("#namecust").val("");
      $("#notelp").val("");
      $("#muatan").val("");
      $("#asal").val("");
      $("#tujuan").val("");

      $("#plat").val(null).trigger("change");
      $("#platno").val("");
      $("#sopir").val(null).trigger("change");
      $("#namasopir").val("");
      $("#nominal").val("");

      $("#modalAddSanguOrder").modal("hide");

      Swal.fire({
        icon: "success",
        title: "Success!",
        text: "Data Order ditambahkan!",
      });

      $("#orderTables").DataTable().ajax.reload(null, false);
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

$("#orderTables").on("click", ".btn-edit", function (e) {
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

      $("#orderTables").DataTable().ajax.reload(null, false);
    },
  });

  return false;
});

$("#orderTables").on("click", ".btn-delete", function () {
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

          $("#orderTables").DataTable().ajax.reload(null, false);
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
