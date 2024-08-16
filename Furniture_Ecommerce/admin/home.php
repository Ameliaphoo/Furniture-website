<?php 
    require_once "../assets/includes/navagationside.php";
    require_once "../assets/Database/Connection.php";

    $numProducts = 0;
    $numOrders = 0;
    $numUsers = 0;
    $numCategories = 0;

    $stmt = $pdo->query("SELECT COUNT(*) AS num FROM products");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $numProducts = $result['num'];

    $stmt = $pdo->query("SELECT COUNT(*) AS num FROM orders");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $numOrders = $result['num'];

    $stmt = $pdo->query("SELECT COUNT(*) AS num FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $numUsers = $result['num'];

    $stmt = $pdo->query("SELECT COUNT(*) AS num FROM category");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $numCategories = $result['num'];

	// Initialize arrays to store chart data
    $productChartData = [];
    $categoryChartData = [];
    $orderChartData = [];

    // Fetch data for product chart
    $stmt = $pdo->query("SELECT product_brand, COUNT(*) AS num_products FROM products GROUP BY product_brand");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productChartData[] = ['label' => $row['product_brand'], 'y' => intval($row['num_products'])];
    }

   // Fetch data for category chart
   $stmt = $pdo->query("SELECT category_name, COUNT(*) AS num_categories FROM products JOIN category ON products.category_id = category.category_id JOIN order_detail ON products.product_id = order_detail.product_id  GROUP BY category_name");
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $categoryChartData[] = ['label' => $row['category_name'], 'y' => intval($row['num_categories'])];
   }

     // Fetch data for order chart
     $stmt = $pdo->query("SELECT DATE(order_date) AS order_date, COUNT(*) AS num_orders FROM orders GROUP BY DATE(order_date)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $orderChartData[] = ['x' => strtotime($row['order_date']) * 1000, 'y' => intval($row['num_orders'])];
    }
    // die(var_dump($orderChartData)); 
?>

<div class="">
    <!-- Card Box -->
    <div class="cardBox">
        <div class="card transition">
            <div>
                <div class="numbers"><?php echo $numProducts; ?></div>
                <div class="cardName">Number of Products</div>
            </div>
            <div class="iconBx">
			<ion-icon name="albums-outline"></ion-icon>
            </div>
        </div>

        <div class="card transition">
            <div>
                <div class="numbers"><?php echo $numOrders; ?></div>
                <div class="cardName">Number of Orders</div>
            </div>
            <div class="iconBx">
                <ion-icon name="cart-outline"></ion-icon>
            </div>
        </div>

        <div class="card transition">
            <div>
                <div class="numbers"><?php echo $numUsers; ?></div>
                <div class="cardName">Number of Users</div>
            </div>
            <div class="iconBx">
				<ion-icon name="people-outline"></ion-icon>
            </div>
        </div>

        <div class="card transition">
            <div>
                <div class="numbers"><?php echo $numCategories; ?></div>
                <div class="cardName">Number of Categories</div>
            </div>
            <div class="iconBx">
			<ion-icon name="apps-outline"></ion-icon>
            </div>
        </div>
    </div>
    <!-- End Card Box -->

	<!-- Bar Chart -->
    <div id="productChartContainer" ></div>
    
    <div class="flex gap-x-5">
        <!-- Pie Chart -->
        <div id="categoryChartContainer"></div>

        <!-- Line Chart -->
        <div id="orderChartContainer" ></div>
    </div>
</div>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    // Bar Chart
    var productChart = new CanvasJS.Chart("productChartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: { text: "Product Distribution by Brand" },
        data: [{
            type: "column",
            dataPoints: <?php echo json_encode($productChartData, JSON_NUMERIC_CHECK); ?>
        }]
    });
    productChart.render();

    // Pie Chart
    var categoryChart = new CanvasJS.Chart("categoryChartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: { text: "Order By Category" },
        data: [{
            type: "pie",
            startAngle: 240,
            yValueFormatString: "##0\"\"",
            indexLabel: "{label} {y}",
            dataPoints: <?php echo json_encode($categoryChartData, JSON_NUMERIC_CHECK); ?>
        }]
    });
    categoryChart.render();

    // Line Chart
    var orderChart = new CanvasJS.Chart("orderChartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: { text: "Orders Over Time" },
        axisX: { title: "Date", valueFormatString: "YYYY-MM-DD" },
        axisY: { title: "Number of Orders" },
        data: [{
            type: "line",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($orderChartData, JSON_NUMERIC_CHECK); ?>
        }]
    });
    orderChart.render();

    <?php
        if (isset($_GET['success'])) {
            ?>
                toastr.success('Login Successfull', 'Welcome User : <?php echo $_SESSION['user']['uname'] ?>', {
                    closeButton: true,
                    progressBar: true
                });
            <?php
        }
    ?>
</script>