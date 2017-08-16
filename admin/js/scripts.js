//DataTable
$(document).ready(function() {
  $('#example').DataTable();
} );

//DataTable
$(document).ready(function() {
  $('#tae').DataTable();
} );

$(document).ready(function() {
    $('#orderNo').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );

$(document).ready(function() {
    $('#orderNoC').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );

//disable enter key pages with form
$(window).load(function() {
  $('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });
});

//Show time
function ShowTime() {
    var dt = new Date();
        
        document.getElementById("lblTime").innerHTML = dt.toLocaleTimeString();
        window.setTimeout("ShowTime()", 1000); // Here 1000(milliseconds) means one 1 Sec  
}

//call showtime()
$(document).ready(function() {
    ShowTime();
});

//tooltip on table th actions
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});



//Confirmation Modal
$(document).ready(function(){
  $('#modal-confirm').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
});

//live updatestock on add_sales.php
function updateStock(obj, event) {
      var inputQty = obj.value;
      var inStock = $(obj).closest('tr').find('input[id^="qtyResult"]').val();
      var av = $(obj).closest('tr').find('input[id^="qtyResult"]').data('savedValue');
      if (av == undefined) {
        $(obj).closest('tr').find('input[id^="qtyResult"]').data('savedValue', inStock);
        av = inStock;
      }
      inStock = av;

      console.log(av + ' / ' + inStock + ' / ' + inputQty);
      
      $(obj).closest('tr').find('input[id^="qtyResult"]').val(inStock - inputQty);
      

    }

//edit valdiation message on cart qty on add_sales.php
document.addEventListener("DOMContentLoaded", function() {
  var elements = document.getElementById("input");
  for (var i = 0; i < elements.length; i++) {
    elements[i].oninvalid = function(e) {
      e.target.setCustomValidity("");
      if (!e.target.validity.valid) {
        e.target.setCustomValidity("Must be less than or equal to Stock Quantity");
      }
    };
    elements[i].oninput = function(e) {
      e.target.setCustomValidity("");
    };
  }
})



