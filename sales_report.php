<?php
include 'db_connect.php';
$period = isset($_GET['period']) ? $_GET['period'] : 'month';
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');

if ($period === 'week') {
    $startOfWeek = date('Y-m-d', strtotime('last Monday', strtotime($date)));
    $endOfWeek = date('Y-m-d', strtotime('next Sunday', strtotime($date)));
    $title = 'Weekly';
} elseif ($period === 'month') {
    $startOfMonth = date('Y-m-01', strtotime($date));
    $endOfMonth = date('Y-m-t', strtotime($date));
    $title = 'Monthly';
} elseif ($period === 'year') {
    $startOfYear = date('Y-01-01', strtotime($date));
    $endOfYear = date('Y-12-31', strtotime($date));
    $title = 'Yearly';
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
                <div class="row justify-content-center pt-4">
                    <label for="" class="mt-2"><?php echo ucfirst($title); ?></label>
                    <div class="col-sm-3">
                        <?php if ($period === 'week') : ?>
                            <input type="week" name="date" id="date" value="<?php echo $date ?>" class="form-control">
                        <?php elseif ($period === 'month') : ?>
                            <input type="month" name="date" id="date" value="<?php echo $date ?>" class="form-control">
                        <?php elseif ($period === 'year') : ?>
                            <input type="number" name="date" id="date" value="<?php echo $date ?>" class="form-control" min="1900" max="2100">
                        <?php endif; ?>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <table class="table table-bordered" id='report-list'>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="">Date</th>
                                <th class="">Invoice</th>
                                <th class="">Order Number</th>
                                <th class="">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total = 0;
                            $query = '';
                            if ($period === 'week') {
                                $query = "SELECT * FROM orders WHERE amount_tendered > 0 AND DATE(date_created) >= '$startOfWeek' AND DATE(date_created) <= '$endOfWeek' ORDER BY UNIX_TIMESTAMP(date_created) ASC";
                            } elseif ($period === 'month') {
                                $query = "SELECT * FROM orders WHERE amount_tendered > 0 AND DATE(date_created) >= '$startOfMonth' AND DATE(date_created) <= '$endOfMonth' ORDER BY UNIX_TIMESTAMP(date_created) ASC";
                            } elseif ($period === 'year') {
                                $query = "SELECT * FROM orders WHERE amount_tendered > 0 AND DATE(date_created) >= '$startOfYear' AND DATE(date_created) <= '$endOfYear' ORDER BY UNIX_TIMESTAMP(date_created) ASC";
                            }

                            $sales = $conn->query($query);

                            if ($sales->num_rows > 0) {
                                while ($row = $sales->fetch_array()) {
                                    $total += $row['total_amount'];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td>
                                            <p><b><?php echo date("M d, Y", strtotime($row['date_created'])) ?></b></p>
                                        </td>
                                        <td>
                                            <p><b><?php echo $row['amount_tendered'] > 0 ? $row['ref_no'] : 'N/A' ?></b></p>
                                        </td>
                                        <td>
                                            <p><b><?php echo $row['order_number'] ?></b></p>
                                        </td>
                                        <td>
                                            <p class="text-right"><b><?php echo number_format($row['total_amount'], 2) ?></b></p>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <th class="text-center" colspan="5">No Data.</th>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th class="text-right"><?php echo number_format($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                    <div class="col-md-12 mb-4">
                        <center>
                            <button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript>
    <style>
        table#report-list {
            width: 100%;
            border-collapse: collapse;
        }

        table#report-list td,
        table#report-list th {
            border: 1px solid;
        }

        p {
            margin: unset;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</noscript>
<script>
    $('#date').change(function() {
        var period = '<?php echo $period ?>';
        var date = $(this).val();
        if (period === 'week') {
            var year = date.split('-')[0];
            var week = date.split('-')[1].replace('W', '');
            location.replace('index.php?page=sales_report&period=' + period + '&date=' + year + '-' + week);
        } else if (period === 'month') {
            location.replace('index.php?page=sales_report&period=' + period + '&date=' + date);
        } else if (period === 'year') {
            location.replace('index.php?page=sales_report&period=' + period + '&date=' + date);
        }
    });

    $('#print').click(function() {
        var _c = $('#report-list').clone();
        var ns = $('noscript').clone();
        ns.append(_c);
        var nw = window.open('', '_blank', 'width=900,height=600');
        nw.document.write('<p class="text-center"><b><?php echo $title ?> Sales Report as of <?php echo $period === "week" ? "Week " + date("W, Y", strtotime($date)) : ($period === "month" ? date("F, Y", strtotime($date)) : date("Y", strtotime($date))) ?></b></p>');
        nw.document.write(ns.html());
        nw.document.close();
        nw.print();
        setTimeout(() => {
            nw.close();
        }, 500);
    });
</script>
