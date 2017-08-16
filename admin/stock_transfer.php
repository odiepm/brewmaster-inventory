<?php include 'includes/admin_header.php'; ?>

<div class="row">
  <div class="col-md-12">
    <h1> Select Type of Transfer </h1>
    <hr>
    <div class="panel panel-default">
      <div class="panel-body">



        <section class="col-md-4" style="padding-right:20px; border-right: 1px solid #ccc;">
          <h3>Request Stock Transfer</h3>
          <p class="text-muted">Request Stock Transfer to another branch</p><br>
          <a href="stock_select.php?branch=" class="btn btn-primary btn-block">Request Stock Transfer</a>
        </section>
        

        <section class="col-md-4" style="padding-right:20px; border-right: 1px solid #ccc;">
          <h3>View/Receive Stock Transfers</h3>
          <p class="text-muted">View/Receive stock transfer from other branches</p>
          <a href="stock_manage.php" class="btn btn-warning btn-block">View Stock Transfer </a>
        </section>
        
        <section class="col-md-4" style="padding-left:20px;">
          <h3>Manage Stock Requests</h3>
          <p class="text-muted">View/Receive stock transfer from other branches</p><br>
          <a href="stock_manage_requests.php" class="btn btn-success btn-block">View/Receive Stock Transfer </a>
        </section>

      </div>
    </div>
  </div>

</div>


<script>
  //disable enter key
  $('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });
</script>

<?php include 'includes/admin_footer.php'; ?>