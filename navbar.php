<?php include('db_connect.php');?>

<style>
    .collapse a {
        text-indent: 10px;
    }

    nav#sidebar {
        /*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
    }

    .bg-coffee {
        background-color: #6f4e37; /* Replace with your preferred shade of brown */
    }
</style>

<nav id="sidebar" class='mx-lt-5 bg-coffee'>
    <div class="sidebar-list">
        <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
        <a href="index.php?page=orders" class="nav-item nav-orders"><span class='icon-field'><i class="fa fa-clipboard-list "></i></span> Orders</a>
        <a href="billing/index.php" class="nav-item nav-takeorders"><span class='icon-field'><i class="fa fa-list-ol "></i></span> Take Orders</a>
        <?php if($_SESSION['login_type'] == 1): ?>
            <div class="mx-2 text-white">Master List</div>
            <a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list-alt "></i></span> Categories</a>
            <a href="index.php?page=products" class="nav-item nav-products"><span class='icon-field'><i class="fa fa-th-list "></i></span> Products</a>
            <div class="mx-2 text-white">Inventory</div>
            <a href="index.php?page=supplier_management" class="nav-item nav-supplier_management"><span class='iconn-field'><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></span> Supplier Information</a>
            <a href="index.php?page=batch_and_lot" class="nav-item nav-batch_and_lot"><span class='iconn-field'><i class="fa fa-th" aria-hidden="true"></i></span> Batch and Lot
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 <?php
                    function getquantityCount() {
                     global $conn;
                        $quantityCount = 0;
                        $result = $conn->query("SELECT COUNT(quantity) AS count FROM batch_lot WHERE quantity < 5");
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $quantityCount = $row['count'];
                             }
                                return $quantityCount;
                            }

                            $quantityCount = getquantityCount();

                            if ($quantityCount > 0): ?>
                                 <span class="badge badge-danger"><?php echo $quantityCount; ?></span>
                            <?php endif; ?>
                </a>
                <div class="mx-2 text-white">Backup And Recovery</div>
                <a href="index.php?page=backup_recovery" class="nav-item nav-backup_recovery"><span class='icon-field'><i class="fa fa-database" aria-hidden="true"></i></span> Backup Data</a>
                <div class="mx-2 text-white">Forecasting</div>
                <a href="index.php?page=inventory_track" class="nav-item nav-inventory_tracking"><span class='icon-field'><i class="fa fa-search" aria-hidden="true"></i></span> Inventory Tracking</a>
                <a href="index.php?page=sales_trend" class="nav-item nav-sales_trend"><span class='icon-field'><i class="fa fa-line-chart" aria-hidden="true"></i></span> Sale's Trend</a>
         <?php endif; ?>

        <div class="mx-2 text-white">Report</div>
        <a href="index.php?page=sales_report" class="nav-item nav-sales_report"><span class='icon-field'><i class="fa fa-th-list"></i></span> Sales Report</a>
        <a href="index.php?page=cash_report" class="nav-item nav-cash_report"><span class='iconn-field'><i class="fas fa-comment-dollar"></i></span> Cash Report</a>

        <?php if($_SESSION['login_type'] == 1): ?>
            <div class="mx-2 text-white">Systems</div>
            <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Users</a>
            <!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a> -->
        <?php endif; ?>
    </div>
</nav>
