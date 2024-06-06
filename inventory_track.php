<div class="container" style="max-width: 1200px; margin-top: 60px;">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <div class="card">
                <div class="card-header" style="font-size: 24px; font-weight: bold;">
                    Forecasting Inventory Needs
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $batch_lot = $conn->query("SELECT * FROM batch_lot ORDER BY id ASC");
                            while($row = $batch_lot->fetch_assoc()):
                                // Determine the status based on your criteria (e.g., quantity)
                                $status = '';
                                if ($row['quantity'] <= 0) {
                                    $status = 'NO STOCK';
                                } elseif ($row['quantity'] <= 10) {
                                    $status = 'LOW STOCK';
                                } else {
                                    $status = 'STABLE';
                                }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $row['item_name'] ?></td>
                                <td class="text-center"><?php echo $status ?></td> <!-- Display Status -->
                                <td class="text-center">
                                    <?php if ($status == 'LOW STOCK' || $status == 'NO STOCK'): ?>
                                    <!-- Your logic for low or no stock handling here -->
                                    <?php endif; ?>
                                </td> 
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
