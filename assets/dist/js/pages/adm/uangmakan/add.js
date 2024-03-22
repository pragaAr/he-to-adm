$(document).ready(function () {
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

  $("button#tambah").on("click", function (e) {
    const id = $("#kryid").val();
    const nama = $("#namakry").val();
    const nominal = $("#nominal").val() === "" ? 0 : $("#nominal").val();

    const newRow = `
    <tr class="text-center row-cart">
      <td class="text-uppercase nama">
      ${nama}
      <input type="hidden" name="nama_hidden[]" value="${nama}">
      </td>
      ${id}
      <input type="hidden" name="id_hidden[]" value="${id}">
      <td class="text-right pr-4 nominal">
      ${nominal}
      <input type="hidden" name="nominal_hidden[]" value="${nominal}">
      </td>
      <td class="action">
        <button type="button" class="btn btn-danger border border-light btn-sm" id="tombol-hapus" data-nama="${nama}" data-id="${id}">
          Hapus
        </button>
      </td>
    </tr>
  `;

    $("#cart tbody").append(newRow);

    $(".select-karyawan").val(null).trigger("change");
    $("#tambah").prop("disabled", true);
    $("#total").html("<p class='mb-0'>" + total_um().toLocaleString() + "</p>");
    $("#total_hidden").val(total_um());
    $("tfoot").show();
  });

  $(document).on("click", "#tombol-hapus", function () {
    const idToRemove = $(this).data("id");

    // hapus cart array dengan key yang ditentukan
    cartUm = cartUm.filter((item) => parseInt(item.id) !== idToRemove);

    $(this).closest(".row-cart").remove();

    $("#total").html("<p>" + total_um().toLocaleString() + "</p>");
    $("#total_hidden").val(total_um());

    $(".select-karyawan").val(null).trigger("change");

    if ($("tbody").children().length == 0) $("tfoot").hide();
  });

  $('button[type="submit"]').on("click", function () {
    $("#tgl").prop("readonly", true);
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

  $(document).on("select2:open", () => {
    document
      .querySelector(".select2-container--open .select2-search__field")
      .focus();
  });
});
