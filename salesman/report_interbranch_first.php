<?php include 'includes/salesman_header.php'; ?>
<div class="row">
  <div class="col-md-12">
    <h1> Interbranch Report by Date
      <hr>
    </h1>
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-body">
        <form action="report_interbranch_date.php" method="POST">

          <div>
            <div class="col-md-6">
              <label for="">From</label>
              <input type="date" name="dateFrom" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
            </div>
          </div>

          <div class="col-md-6">
            <label for="">To</label>
            <input type="date" name="dateTo" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
          </div>

          <div class="col-md-12">
            <br>
            <input type="submit" name="submit" class="btn btn-info" value="Confirm"/>
            <hr>
          </div>
        </form>
        </div>
      </div>

        </div>

      </div>

    </div>

  </div>

  <?php include 'includes/salesman_footer.php'; ?>