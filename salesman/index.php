<?php include 'includes/salesman_header.php'; ?>
<script type="text/javascript" src="js/loader.js"></script>
<?php 

  if ($isSalesmanWithdrawal == 1) {

 ?>
<div class="col-lg-6 col-md-6">
  <div class="panel panel-green">
    <div class="panel-heading">
      <div class="row">
        <div class="col-xs-3">
          <i class="fa fa-list fa-5x"></i>
        </div>
        <div class="col-xs-9 text-right">

          <div class="huge"></div>

          <div>Salesman Withdrawal</div>
        </div>
      </div>
    </div>
    <a href="/final/salesman/add_sales.php">
      <div class="panel-footer">
        <span class="pull-left">Salesman Withdrawal</span>
        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>        

        <span class="clearfix"></span>
      </div>
    </a>
  </div>
</div>
<?php } ?>

</div>
<?php include 'includes/salesman_footer.php'; ?>