<?php include 'includes/admin_header.php'; ?>

<div class="row">


<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Activity Log</span>
       </strong>
    </div>

    <div class="panel-body">

      <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th class="text-left">Description</th>
            <th class="text-center">Date & Time</th>
          </tr>
        </thead>
      <tbody>
              
      <?php 

        $query = "SELECT * FROM {$prefix}activity_log ORDER BY date desc;";
        $exec = mysqli_query($connection, $query);
        $count = 0;

        while ($row = mysqli_fetch_array($exec)) {
          
          $description = $row['description'];
          $date = $row['date'];
          $count++;

       ?>


       <?php           
       if (strpos($description, 'deleted') == true) {
        ?>
        <tr class="text-danger">
            <td class="text-center"><?php echo $count; ?></td>
            <td class="text-left"><strong><?php echo $description; ?></strong></td>
            <td class="text-center"><?php echo $date; ?></td>
        </tr>

        <?php 
        }

        if (strpos($description, 'edited') == true) {
         ?>
        <tr class="text-info">
            <td class="text-center"><?php echo $count; ?></td>
            <td class="text-left"><strong><?php echo $description; ?></strong></td>
            <td class="text-center"><?php echo $date; ?></td>
        </tr>
        
        <?php }

        if (strpos($description, 'added') == true) {
        ?>
        <tr class="text-success">
            <td class="text-center"><?php echo $count; ?></td>
            <td class="text-left"><strong><?php echo $description; ?></strong></td>
            <td class="text-center"><?php echo $date; ?></td>
        </tr>

         <?php }

         if (strpos($description, 'registered') == true) {
          ?>
         <tr class="text-success">
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php }

         if (strpos($description, 'logged in') == true) {
          ?>
         <tr class="text-primary">
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php }

         if (strpos($description, 'logged out') == true) {
          ?>
         <tr>
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php }

         if (strpos($description, 'database') == true) {
          ?>
         <tr class="text-success">
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php }

         if (strpos($description, 'withdrawal') == true) {
          ?>
         <tr class="text-success">
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php }

         if (strpos($description, 'received') == true) {
          ?>
         <tr class="text-success">
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php } if (strpos($description, 'requested') == true) {
          ?>
         <tr class="text-warning">
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php }

         if (strpos($description, 'edited') == true) {
          ?>
         <tr>
             <td class="text-center"><?php echo $count; ?></td>
             <td class="text-left"><strong><?php echo $description; ?></strong></td>
             <td class="text-center"><?php echo $date; ?></td>
         </tr>
         
         <?php }

          } ?>

            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>


<?php include 'includes/admin_footer.php'; ?>