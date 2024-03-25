$(document).ready(function () {
  $("#tfoot").hide();

  $(document).keypress(function (event) {
    if (event.which == "13") {
      event.preventDefault();
    }
  });

  $(".select-reccu")
    .select2({
      placeholder: "PILIH RECCU",
      ajax: {
        url: "http://localhost/hira-to-adm/penjualan/getListReccuForTravelDoc",
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

      $("#selectedReccu").val(data.text);
      $("#selectedOrder").val(data.orderno);
      $("#selectedCust").val(data.custid);
      $("#jenis").val(data.jenis);
      $("#berat").val(data.berat);
      $("#pengirim").val(data.pengirim);
      $("#penerima").val(data.penerima);
      $("#hrgkg").val(format(data.hrgkg));
      $("#hrgbrg").val(format(data.hrgbrg));
      $("#tothrg").val(format(data.totalhrg));

      $("#suratjalan").focus();
    });

  $("#suratjalan").on("keydown keyup click change blur input", function (e) {
    if ($(this).val() !== "") {
      $("#tambah").prop("disabled", false);
    } else {
      $("#tambah").prop("disabled", true);
    }
  });

  let cartSj = [];

  $(document).on("click", "#tambah", function (e) {
    const sj = $("#suratjalan").val();

    const dataCart = {
      id: sj,
      text: sj,
    };

    const isInCart = cartSj.some((emp) => emp.id === dataCart.id);

    if (isInCart) {
      Swal.fire({
        icon: "warning",
        title: "Oops!",
        text: "Surat Jalan sudah ada di list!",
      });
    } else {
      cartSj.push(dataCart);

      const valueBerat = $("#beratsj").val() ? $("#beratsj").val() : 0;
      const valueRetur = $("#retur").val() ? $("#retur").val() : 0;

      const newRow = `
    <tr class="cart text-center">

      <td class="text-uppercase sj">
      ${sj}
      <input type="hidden" name="sj_hidden[]" value="${sj}">
      </td>

      <td class="text-uppercase valueBerat">
      ${valueBerat}
      <input type="hidden" name="valueBerat_hidden[]" value="${valueBerat}">
      </td>

      <td class="text-uppercase valueRetur">
      ${valueRetur}
      <input type="hidden" name="valueRetur_hidden[]" value="${valueRetur}">
      </td>

      <td class="aksi">
        <button type="button" class="btn btn-danger btn-sm border border-light" id="tombol-hapus" data-sj="${sj}" data-id="${sj}">
          Hapus
        </button>
      </td>
    </tr>
  	`;

      $("#cart tbody").append(newRow);

      $("#suratjalan").val("");
      $("#beratsj").val("");
      $("#retur").val("");

      $("#suratjalan").focus();

      $("#tambah").prop("disabled", true);

      $("tfoot").show();
    }
  });

  $(document).on("click", "#tombol-hapus", function () {
    const idToRemove = $(this).data("id");

    cartSj = cartSj.filter((item) => item.id !== idToRemove);

    $(this).closest(".cart").remove();

    if ($("tbody").children().length == 0) $("tfoot").hide();
  });
});
