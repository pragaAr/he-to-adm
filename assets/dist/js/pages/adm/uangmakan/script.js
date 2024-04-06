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

$("#umTables").DataTable({
  ordering: true,
  initComplete: function () {
    var api = this.api();
    $("#umTables_filter input")
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
    url: "http://localhost/hira-to-adm/uangmakan/getUangMakan",
    type: "POST",
    dataType: "json",
  },
  columns: [
    {
      data: "id",
      className: "text-center",
    },
    {
      data: "kd_um",
      className: "text-center",
      render: function (data, type, row) {
        return data.toUpperCase();
      },
    },
    {
      data: "jml_penerima",
      className: "text-center",
      render: function (data, type, row) {
        return data + " Orang";
      },
    },
    {
      data: "jml_nominal",
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

$("#btn_tambahData").on("click", function () {
  $("#modalAdd").modal("show");
});

$("#modalAdd").on("shown.bs.modal", function () {
  $.ajax({
    url: "http://localhost/hira-to-adm/uangmakan/getGenerateKd",
    type: "GET",
    success: function (data) {
      const parsedata = JSON.parse(data);

      $("#kd").val(parsedata);

      $("#nominal").focus();
    },
  });

  $("#tfoot").hide();

  $("#nominal").on("keypress", function (key) {
    if (key.charCode < 48 || key.charCode > 57) return false;
  });

  $(function () {
    $("#nominal").on("keydown keyup click change blur input", function (e) {
      $(this).val(format($(this).val()));
    });
  });

  let cartUm = [];

  $(".select-karyawan")
    .select2({
      placeholder: "Pilih Karyawan",
      selectOnClose: false,
      allowClear: true,
      ajax: {
        url: "http://localhost/hira-to-adm/karyawan/getKaryawanList",
        dataType: "JSON",
        delay: 250,
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          $.each(data, function (index, value) {
            value.text = value.text.toUpperCase();
          });
          return {
            results: data,
          };
        },
        cache: false,
      },
    })
    .on("select2:select", function (e) {
      const data = e.params.data;

      // Cek apakah ada data karyawan di cart
      const isInCart = cartUm.some((emp) => emp.id === data.id);

      if (isInCart) {
        // true
        Swal.fire({
          icon: "warning",
          title: "Oops!",
          text: "Penerima sudah ada di list!",
        });

        $(".select-karyawan").val(null).trigger("change");
      } else {
        // false
        // Masukkan ke cart
        cartUm.push(data);

        $("#namakry").val(data.text);

        $("#tambah").prop("disabled", false);
      }
    });

  let newData = [];

  $("button#tambah").on("click", function (e) {
    const id = $("#kryid").val();
    const nama = $("#namakry").val();
    const nominal = $("#nominal").val() === "" ? 0 : $("#nominal").val();

    newData.push({
      id: id,
      nama: nama,
      nominal: nominal,
    });

    tampilkanDataBaru();

    $(".select-karyawan").val(null).trigger("change");
    $("#tambah").prop("disabled", true);
    $("#total").html("<p class='mb-0'>" + total_um().toLocaleString() + "</p>");
    $("#total_hidden").val(total_um());
    $("#tfoot").show();
  });

  function tampilkanDataBaru() {
    $("#cart tbody").empty();

    newData.forEach(function (data) {
      const newRow = `
            <tr class="text-center row-cart">
                <td class="text-uppercase nama">
                    ${data.nama}
                    <input type="hidden" name="nama_hidden[]" value="${data.nama}">
                </td>
                ${data.id}
                <input type="hidden" name="id_hidden[]" value="${data.id}">
                <td class="text-right pr-4 nominal">
                    ${data.nominal}
                    <input type="hidden" name="nominal_hidden[]" value="${data.nominal}">
                </td>
                <td class="action">
                    <button type="button" class="btn btn-danger border border-light btn-sm" id="tombol-hapus" data-nama="${data.nama}" data-id="${data.id}">
                        Hapus
                    </button>
                </td>
            </tr>
        `;

      $("#cart tbody").append(newRow);
    });
  }

  $(document).on("click", "#tombol-hapus", function () {
    const idToRemove = $(this).data("id");

    cartUm = cartUm.filter((item) => parseInt(item.id) !== idToRemove);

    $(this).closest(".row-cart").remove();

    newData = newData.filter((item) => parseInt(item.id) !== idToRemove);

    $("#total").html("<p>" + total_um().toLocaleString() + "</p>");
    $("#total_hidden").val(total_um());

    $(".select-karyawan").val(null).trigger("change");

    if ($("#tbody").children().length === 0) $("#tfoot").hide();
  });

  function total_um() {
    let hasil = 0;
    $(".nominal").each(function () {
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

    let id = [];
    let nama = [];
    let nominal = [];

    const kd = $("#kd").val();
    const total = $("#total_hidden").val();

    $('input[name="id_hidden[]"]').each(function () {
      const id_hidden = $(this).val();
      id.push(id_hidden);
    });

    $('input[name="nama_hidden[]"]').each(function () {
      const nama_hidden = $(this).val();
      nama.push(nama_hidden);
    });

    $('input[name="nominal_hidden[]"]').each(function () {
      const nominal_hidden = $(this).val();
      nominal.push(nominal_hidden);
    });

    $.ajax({
      url: "http://localhost/hira-to-adm/uangmakan/add",
      method: "POST",
      data: {
        id: id,
        nama: nama,
        nominal: nominal,
        total: total,
        kd: kd,
      },
      success: function (response) {
        $("#modalAdd").modal("hide");

        const parsedRes = JSON.parse(response);
        const resCode = parsedRes.kd_um;
        const resText = parsedRes.text;

        Swal.fire({
          title: resText,
          text: "Cetak List Uangmakan ??",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Batal",
          confirmButtonText: "Ya, Cetak !",
        }).then((result) => {
          if (result.value) {
            window.open(
              "http://localhost/hira-to-adm/uangmakan/print/" + resCode
            );
          }
        });

        $("#umTables").DataTable().ajax.reload(null, false);
      },
    });

    cartUm = [];
    id = [];
    nama = [];
    nominal = [];
    newData = [];

    $("#nominal").val("");
    $(".select-karyawan").val(null).trigger("change");

    $("#cart tbody").empty();
    $("#tfoot").hide();
  });
});

$("#umTables").on("click", ".btn-detail", function () {
  const kd = $(this).data("kd");

  $.ajax({
    url: "http://localhost/hira-to-adm/uangmakan/getDetailData",
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

$("#umTables").on("click", ".btn-delete", function () {
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
        url: "http://localhost/hira-to-adm/uangmakan/delete",
        method: "POST",
        data: { kd: kd },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data Uangmakan dihapus!",
          });

          $("#umTables").DataTable().ajax.reload(null, false);
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
