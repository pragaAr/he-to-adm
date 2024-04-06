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
