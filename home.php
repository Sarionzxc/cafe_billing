<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Analytics</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z8SgqAmRr5gCGJf3eKZZFSF8Rv+qriibK6PmO+" crossorigin="anonymous">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-color: #fff;"> <!-- Set background color to white -->
  <style>
    span.float-right.summary_icon {
      font-size: 3rem;
      position: absolute;
      right: 1rem;
      top: 0;
    }
    .imgs {
      margin: .5em;
      max-width: calc(100%);
      max-height: calc(100%);
    }
    .imgs img {
      max-width: calc(100%);
      max-height: calc(100%);
      cursor: pointer;
    }
    #imagesCarousel, #imagesCarousel .carousel-inner, #imagesCarousel .carousel-item {
      height: 60vh !important;
      background: black;
    }
    #imagesCarousel .carousel-item.active {
      display: flex !important;
    }
    #imagesCarousel .carousel-item-next {
      display: flex !important;
    }
    #imagesCarousel .carousel-item img {
      margin: auto;
    }
    #imagesCarousel img {
      width: auto!important;
      height: auto!important;
      max-height: calc(100%)!important;
      max-width: calc(100%)!important;
    }
    .container {
    background-color: white; 
      width: 70%;
    }
  </style>

  <div class="container">
    <div class="row mt-3 ml-3 mr-3">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h2 style="text-align: center;"><?php echo "Welcome back ". $_SESSION['login_name']."!"  ?></h2>
            <hr>
          </div>
        </div>                  
      </div>
    </div>
  </div>

  <div class="container">
    <h1>Sales Analytics</h1>
    <canvas id="salesChart" width="800" height="400"></canvas>
  </div>

  <?php
    // Connect to database
    $mysqli = new mysqli('localhost','root','','cafe_billing_db');

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to retrieve total sales for each month
    $sql = "SELECT MONTH(date_created) AS month, YEAR(date_created) AS year, SUM(total_amount) AS total_sales
            FROM orders
            GROUP BY YEAR(date_created), MONTH(date_created)
            ORDER BY YEAR(date_created), MONTH(date_created)";

    $result = $mysqli->query($sql);

    // Process data for chart
    $months = [];
    $salesData = [];
    while ($row = $result->fetch_assoc()) {
        $months[] = date("M Y", strtotime($row['year'] . '-' . $row['month'] . '-01'));
        $salesData[] = $row['total_sales'];
    }
  ?>

  <script>
    // Chart.js
    var ctx = document.getElementById('salesChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
          label: 'Total Sales',
          data: <?php echo json_encode($salesData); ?>,
          backgroundColor: 'rgba(139, 69, 19, 0.5)', /* Brown color */
          borderColor: 'rgba(139, 69, 19, 1)',          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

  <script>
    $('#manage-records').submit(function(e){
      e.preventDefault()
      start_load()
      $.ajax({
        url:'ajax.php?action=save_track',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success:function(resp){
          resp=JSON.parse(resp)
          if(resp.status==1){
            alert_toast("Data successfully saved",'success')
            setTimeout(function(){
              location.reload()
            },800)
          }
        }
      })
    })

    $('#tracking_id').on('keypress',function(e){
      if(e.which == 13){
        get_person()
      }
    })

    $('#check').on('click',function(e){
      get_person()
    })

    function get_person(){
      start_load()
      $.ajax({
        url:'ajax.php?action=get_pdetails',
        method:"POST",
        data:{tracking_id : $('#tracking_id').val()},
        success:function(resp){
          if(resp){
            resp = JSON.parse(resp)
            if(resp.status == 1){
              $('#name').html(resp.name)
              $('#address').html(resp.address)
              $('[name="person_id"]').val(resp.id)
              $('#details').show()
              end_load()
            }else if(resp.status == 2){
              alert_toast("Unknown tracking id.",'danger');
              end_load();
            }
          }
        }
      })
    }
  </script>
</body>
</html>
