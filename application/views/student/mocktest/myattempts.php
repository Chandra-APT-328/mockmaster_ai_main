<style>
    div.table-responsive>div.dataTables_wrapper>div.row {
        margin: 10px;
    }

    input[type="radio"] {
        display: none;
    }

    .check-radio {
        padding: 4px;
        display: inline-block;
        cursor: pointer;
        border-radius: 50px;
        cursor: pointer;
        color: #ccc;
        background-color: #;
        font-size: 16px;
        width: 180px;
        line-height: 40px;
        text-align: center;
        border-radius: 50px;
    }

    .checked {
        cursor: pointer;
        color: #fff;
        background-color: #6777ef;
        font-size: 16px;
        width: 180px;
        line-height: 40px;
        text-align: center;
        border-radius: 50px;
    }

    .edit {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .delete {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .edit:hover,
    .delete:hover {
        opacity: 0.7;
        color: #fff;
    }

    .card:hover {
        box-shadow: none;
    }

    .responsive {
        display: block;
        width: 100%;
        overflow-x: hidden;
    }

    .mock-table {
        padding-top: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e0e0e0;
    }

    .mock-table:last-child {
        border-bottom: none;
        padding-bottom: 0px;
    }

    .mock-table:first-child {
        padding-top: 0px;
    }

    .delete-attempt {
        padding: 10px;
        border-radius: 50px;
        background: #ff6767;
        color: #ffffff;
        cursor: pointer;
    }
</style>

<link href="<?php echo base_url('assets/vendor/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<section>
    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h2 class="section-title mb-3">My Mock test</h2>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <div class="col-12 "> -->
                                        <div class="accordion__item">
                                            <div id="default_collapseOne" class="accordion__body "
                                                data-parent="#accordion-one" style="">
                                                <div class="accordion__body--text">
                                                    <!-- <div class="card">
                                                            <div class="card-body"> -->
                                                    <?php
                                                    // $getMockTestAnswers = [];
                                                    foreach ($getMockTestAnswers as $data => $rowData) {
                                                        foreach ($getMockTest as $test => $rowtest) {
                                                            if ($rowData->mock_series == $rowtest->id) {
                                                                ?>
                                                                <div class="row mock-table"
                                                                    id="<?php echo $rowData->mock_test_id; ?>">
                                                                    <div class="col-md-8">
                                                                        <div class="d-flex flex-column justify-content-end pt-10">
                                                                            <?php
                                                                            $save_label = "Submitted on:";
                                                                            $status_badge = "";
                                                                            if($rowData->status == 3){
                                                                                $save_label = "Last saved:";
                                                                                $status_badge = '<span class="badge badge-info">Saved</span>';
                                                                            }
                                                                            if($rowData->status == 1){
                                                                                $status_badge = '<span class="badge badge-success">Completed</span>';
                                                                            }
                                                                            if($rowData->status == 2){
                                                                                $status_badge = '<span class="badge badge-warning">Pending</span>';
                                                                            }
                                                                            ?>
                                                                            <p class="font-16 font-weight-500">
                                                                                <?php echo $rowtest->title; ?>
                                                                            </p>
                                                                            <span class="font-14 text-gray"><?php echo $save_label; ?>
                                                                                <?php
                                                                                $last_updated = new DateTime($rowData->update_date);
                                                                                echo $last_updated->format("M d, Y g:i A");
                                                                                ?>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="p-2 d-flex justify-content-end">
                                                                            <!-- <div class="col-md-6 text-right"> -->
                                                                            <!-- <span
                                                                                    onclick="deleteattempt('<?php echo $rowData->mock_test_id; ?>');"><i
                                                                                        class="fa fa-trash delete-attempt"></i></span> -->
                                                                            <!-- </div> -->
                                                                            <!-- <div class="col-md-6 text-right"> -->
                                                                            <?php if ($rowData->status == 3) { ?>
                                                                                <input type="button"
                                                                                    class="btn btn-sm btn-primary float-right"
                                                                                    id="<?php echo $rowData->mock_test_id; ?>"
                                                                                    value="Resume"
                                                                                    onclick="continuetest('<?php echo $rowData->mock_series; ?>','<?php echo $rowData->mock_test_id; ?>');" />
                                                                            <?php } ?>
                                                                            <?php if ($rowData->status == 2) { ?>
                                                                                <input type="button"
                                                                                    class="btn btn-sm btn-success float-right"
                                                                                    id="<?php echo $rowData->mock_test_id; ?>"
                                                                                    onclick="generateresult(<?php echo $rowData->mock_series; ?>,this);"
                                                                                    value="Calculate Scores" />
                                                                            <?php } ?>
                                                                            <?php if ($rowData->status == 1) { ?>
                                                                                <input type="button"
                                                                                    class="btn btn-sm btn-secondary float-right"
                                                                                    id="<?php echo $rowData->mock_test_id; ?>"
                                                                                    value="View Scores"
                                                                                    onclick="viewresult('<?php echo $rowData->mock_test_id; ?>');" />
                                                                            <?php } ?>
                                                                            <!-- </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        }
                                                    } ?>
                                                </div>
                                                <input type="hidden" class="csrfToken"
                                                    name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                    value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Required vendors -->
<script src="<?php echo base_url('assets/vendor/sweetalert2/sweetalert2.min.js'); ?>"></script>

<script>
    var siteUrl = '<?php echo base_url(); ?>';

    function viewresult(id) {
        location.href = siteUrl + 'mock/mocktestresult/' + id;
    }

    function generateresult(series, e) {
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash
        var mockTestId = e.id;
        e.value = 'Please wait...';

        $.ajax({
            url: siteUrl + "mock/getresult",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                mockTestId: mockTestId,
                series: series
            },
            success: function (data) {
                $('.csrfToken').val(data.token);
                // console.log('success')
                e.value = 'View Scores';
                $(e).attr('onclick', 'viewresult("' + e.id + '")');
                $(e).removeClass('btn-success');
                $(e).addClass('btn-secondary');
            },
            error: function (err) {
                e.value = 'Try again later';
                $(e).removeClass('btn-success');
                $(e).addClass('btn-danger');
            }
        })
    }

    function deleteattempt(id) {

        if (!confirm('Are you sure to delete this test record? It will be unrecoverable after deletion.')) {
            return false;
        };

        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash

        $.ajax({
            url: siteUrl + "mock/deleteattempt",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                mocktestid: id
            },
            success: function (data) {
                $('.csrfToken').val(data.token);
                $('#' + id).remove();
            }
        })
    }

    function continuetest(series, testid) {
        location.href = siteUrl + "mock/test/" + series + "/" + testid;
    }
</script>