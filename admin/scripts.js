$("button").click(function() {
    $('html,body').animate({
        scrollTop: $(".second").offset().top},
        'slow');
});

$(document).ready(function(){
  $("#saleQty").keyup(function() {
    /* Act on the event */
  
    var prodValue = +$('#unitPrice').val();
    var prodQty = +$('#saleQty').val();

  $("#totalSale").val(prodValue * prodQty);
  });
});


  
$(document).ready(function() {
    $('#example').DataTable();
} );