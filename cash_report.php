    <?php
include 'db_connect.php';

$day = isset($_GET['day']) ? $_GET['day'] : date('Y-m-d');

?>

<div class="container-fluid" style="padding-top: 20px;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
            <div class="row justify-content-center pt-4">
                 <label for="" class="mt-2">Day</label>
                  <div class="col-sm-3">
                     <input type="date" name="day" id="day" value="<?php echo $day ?>" class="form-control">
                </div>
            </div>

                <hr>
                <div class="col-md-12">
                    <table class="table table-bordered" id='report-list'>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="">Date</th>
                                <th class="">Total Income</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total = 0;

                            $sales = $conn->query("SELECT * FROM orders WHERE amount_tendered > 0 AND DATE(date_created) = '$day' ORDER BY UNIX_TIMESTAMP(date_created) ASC");

                            if ($sales->num_rows > 0) {
                                while ($row = $sales->fetch_array()) {
                                    $total += $row['total_amount'];
                                }
                                ?>

                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td>
                                        <p><b><?php echo date("M d, Y", strtotime($day)) ?></b></p>
                                    </td>
                                    <td>
                                        <p class="text-right"><?php echo number_format($total, 2) ?> </p>
                                    </td>
                                </tr>

                            <?php
                            } else {
                            ?>
                                <tr>
                                    <th class="text-center" colspan="3">No Data.</th>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
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
            border-collapse: collapse
        }

        table#report-list td,
        table#report-list th {
            border: 1px solid
        }

        p {
            margin: unset;
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }
    </style>
</noscript>

<script>
    $('#day').change(function() {
        location.replace('index.php?page=cash_report&day=' + $(this).val())
    })

    $('#print').click(function() {
        var _c = $('#report-list').clone();
        var ns = $('noscript').clone();
        ns.append(_c)
        var nw = window.open('', '_blank', 'width=900,height=600')
        nw.document.write('<p class="text-center"><b>Order Report for <?php echo date("F d, Y", strtotime($day)) ?></b></p>')
        nw.document.write(ns.html())
        nw.document.close()
        nw.print()
        setTimeout(() => {
            nw.close()
        }, 500);
    })
</script>
