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

$("#sopirTables").DataTable({
  ordering: true,
  initComplete: function () {
    var api = this.api();
    $("#sopirTables_filter input")
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
    url: "http://localhost/hira-to-adm/sopir/getSopir",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center",
    },
    {
      data: "nama",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "alamat",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "notelp",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "status_sopir",
      className: "text-center",
      render: function (data, type, row) {
        return data === "1" ? "Terima Order" : "Available";
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

$("#btn_add").on("click", function () {
  $("#modalAdd").modal("show");
});

$("#modalAdd").on("shown.bs.modal", function () {
  $("#nama").focus();
});

$("#form_add").on("submit", function () {
  const nama = $("#nama").val();
  const alamat = $("#alamat").val();
  const notelp = $("#notelp").val();

  $.ajax({
    url: "http://localhost/hira-to-adm/sopir/add",
    type: "POST",
    data: {
      nama: nama,
      alamat: alamat,
      notelp: notelp,
    },
    success: function (data) {
      if (data === "true") {
        $("#nama").val("");
        $("#alamat").val("");
        $("#notelp").val("");

        $("#modalAdd").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Data Sopir ditambahkan!",
        });

        $("#sopirTables").DataTable().ajax.reload(null, false);
      }
    },
  });

  return false;
});

$("#modalEdit").on("shown.bs.modal", function () {
  $("#namaedit").focus();
});

$("#sopirTables").on("click", ".btn-edit", function (e) {
  const id = $(this).data("id");

  $.ajax({
    url: "http://localhost/hira-to-adm/sopir/getId",
    type: "POST",
    data: {
      id: id,
    },
    success: function (data) {
      const parsedata = JSON.parse(data);

      $("#id").val(parsedata.id);
      $("#namaedit").val(parsedata.nama);
      $("#alamatedit").val(parsedata.alamat);
      $("#notelpedit").val(parsedata.notelp);

      $("#modalEdit").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

$("#form_edit").on("submit", function () {
  const id = $("#id").val();
  const nama = $("#namaedit").val();
  const alamat = $("#alamatedit").val();
  const notelp = $("#notelpedit").val();

  $.ajax({
    type: "POST",
    url: "http://localhost/hira-to-adm/sopir/update",
    data: {
      id: id,
      nama: nama,
      alamat: alamat,
      notelp: notelp,
    },
    success: function (data) {
      if (data === "true") {
        $("#id").val("");
        $("#namaedit").val("");
        $("#alamatedit").val("");
        $("#notelpedit").val("");

        $("#modalEdit").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Data Sopir diubah!",
        });

        $("#sopirTables").DataTable().ajax.reload(null, false);
      }
    },
  });

  return false;
});

$("#sopirTables").on("click", ".btn-delete", function () {
  const id = $(this).data("id");

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
        url: "http://localhost/hira-to-adm/sopir/delete",
        method: "POST",
        data: { id: id },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Sopir dihapus!",
          });

          $("#sopirTables").DataTable().ajax.reload(null, false);
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
