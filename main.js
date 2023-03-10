//exporte les données sélectionnées
var $table = $('#table');
$(function () {
  $('#toolbar').find('select').change(function () {
    $table.bootstrapTable('refreshOptions', {
      exportDataType: $(this).val()
    });
  });
})

var trBoldBlue = $("table");

$(trBoldBlue).on("click", "tr", function () {
  $(this).toggleClass("bold-blue");
});



$('#data_submit_parselizer').click(function (e) {
  e.preventDefault();
  const url_product = $('#parser').val();
  // if (!url_product) {
  //   $(".form-input-error").css('display', 'block').html("Input field is empty...Enter URL");
  //   exit();
  // } else {
  //   $(".form-input-error").fadeOut();
  // }
  $("#data_submit_parselizer .spinner-border").fadeIn();
  $("#data_submit_parselizer").attr('disabled', 'disabled').css('opacity', '.65');;
  $("#data_submit_parselizer .loading-button").html("Loading...");
  $.post("./category_parser_template.php",
      {
          parser_data: url_product
      },
      function(data) {
          if (!data) {
            // window.location.replace("admin.php");
            alert("No data return");
            $("#table tbody tr").fadeOut().remove();
            $("#table caption").fadeIn().html('Table is empty...');
            $("#data_submit_parselizer .loading-button").html("Create table");
            $("#data_submit_parselizer").css('opacity', '1');
            $("#data_submit_parselizer").removeAttr('disabled');
            $("#data_submit_parselizer .spinner-border").fadeOut();
          } else {
            // $("#table caption").fadeOut().remove();
            $("#table tbody").append("");
            $("#table tbody").append(data);
            $("#data_submit_parselizer .spinner-border").fadeOut();
            $("#data_submit_parselizer .loading-button").html("Finish");
          }
      }
  );
});

$(document).ready(function(){
  $(".delete-table").click(function(){
    $("#table tbody tr").fadeOut().remove();
    // $("#table caption").fadeIn().html('Table is empty...');
    $("#data_submit_parselizer .loading-button").html("Create table");
    $("#data_submit_parselizer").css('opacity', '1');
    $("#data_submit_parselizer").removeAttr('disabled');
  });
});



$(document).ready(function () {
  $('.sort-table-product').DataTable({
    "asSorting": [],
    "scrollY": "100%",
    "scrollX": false,

    "scrollCollapse": true,
    "paging": false
  });
  // $('.dataTables_length').addClass('bs-select');
});
