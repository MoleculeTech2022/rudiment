<?php
include "dbcon.php";
include "sidebar.html";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Year Wise Revenue Report</title>

    <!-- // Charts CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
   <div class="academic_year_wise_revenue_cards" style="margin-top:-20px;">
     <!-- // academic year php loop -->
     <?php
    $select_academic_year = "SELECT DISTINCT acdyear FROM acdyear";
    $select_academic_year_run = mysqli_query($con,$select_academic_year);
    if(mysqli_num_rows($select_academic_year_run)>0){
        while($rows = mysqli_fetch_assoc($select_academic_year_run)){
            // taking acdyear in variable
            $acdyear = $rows['acdyear'];           

            ?>
    <div class="year_wise_revenue_details_card"
        style="width:950px;height:280px;border-radius:5px;background-color:#fff;border-color:#000 #000 #000 #000; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.25);margin-left:280px;margin-top:20px;overflow: auto;">
        
        <div class="academic_year_span" style="margin-top: 10px;margin-left:10px;position:absolute;width:950px;">
                        <h4>Academic Year : <?php echo $acdyear; ?></h4>
                    </div>

<div class="total_revenue" style="margin-top:60px;display:flex;margin-left:20px;">
<!-- // sum of total fees ph script -->

<div class="sum_of_total_fees_div">
<?php

$select_sum_of_total_fees = "SELECT SUM(total_fees) AS total_fees_year FROM acdyear WHERE acdyear.acdyear = '$acdyear'";
$sum_of_total_fees_run = mysqli_query($con,$select_sum_of_total_fees);
if(mysqli_num_rows($sum_of_total_fees_run)>0){
    while($rows = mysqli_fetch_assoc($sum_of_total_fees_run)){

        // taking in variable
$total_fees = $rows['total_fees_year'];

        ?>
        
<h2>
    <?= $total_fees; ?>
</h2>
<span>Total Amt</span>

</div>

<!-- .sum_of_total_paid_fees -->
<div class="sum_of_total_paid_fees" style="margin-left:40px;">

<?php

$select_sum_of_paid_fees = "SELECT SUM(payamt) AS paid_fees_year FROM payment WHERE payment.acdyear = '$acdyear'";
$sum_of_paid_fees_run = mysqli_query($con,$select_sum_of_paid_fees);
if(mysqli_num_rows($sum_of_paid_fees_run)>0){
    while($rows = mysqli_fetch_assoc($sum_of_paid_fees_run)){

        // taking in variable
$paid_fees = $rows['paid_fees_year'];

        ?>
        
<h2>
    <?= $paid_fees; ?>
</h2>
<span>Paid Amt</span>


</div>

<!-- // total_due_amount_div -->
<div class="total_due_amount_div" style="margin-left:40px;">

<h2>

    <?php
     $due_amt = $total_fees - $paid_fees;
     echo $due_amt; 
     ?>
</h2>
<span>Due Amt</span>

</div>

<div style="margin-top:-55px;width:270px;height:270px;margin-left:230px;">

    <canvas id="myChart_<?= $acdyear; ?>"></canvas>
                          
    </div>

     <script>
    var ctx = document.getElementById('myChart_<?= $acdyear; ?>');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Paid Amt', 'Due Amt'], // Placeholder  labels, replace with your data
            datasets: [{
                label: 'RS',
                data: [
                    <?= $paid_fees; ?>,
                    <?= $due_amt; ?>], // Placeholder data, replace with your data
                borderWidth: 3
            }]
        },
        options: {
           
        }
    });
</script>


<!-- // academic year php loop brackets closing --> 
</div>
</div>

<?php
       }   }
    }
    ?>

<!-- // sum of total fees brackets closing -->

  
<?php
    }
}

?>
   
   


<!-- // sum of total fees brackets closing -->
<?php
    }


?>
   
   </div>
   </div>
   </div>

  

</body>

</html> 