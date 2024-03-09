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

      $("#reccu").val(reccu);

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

        tbodyDetail.append(row);
      }

      $("#modalDetail").modal("show");

      $('[data-toggle="tooltip"]').tooltip("hide");
    },
  });
});

const inserted = $(".inserted").data("flashdata");

if (inserted) {
  Swal.fire({
    icon: "success",
    title: "Success",
    text: inserted,
  });
}

$(document).on("select2:open", () => {
  document
    .querySelector(".select2-container--open .select2-search__field")
    .focus();
});
