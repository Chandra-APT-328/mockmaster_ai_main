<style>
div.table-responsive>div.dataTables_wrapper>div.row {
    margin: 10px;
}

th.text-center.sorting_disabled {
    border: 0px !important;
    font-weight: 500 !important;
}

input[type="radio"] {
    display: none;
}

.check-radio {
    -webkit-user-select: none;
    padding: 10px 20px;
    display: inline-block;
    cursor: pointer;
    border-radius: 50px;
    cursor: pointer;
    color: #ccc;
    font-size: 14px;
    width: max-content;
    line-height: 10px;
    text-align: center;
    border-radius: 50px;
}

.check-radio:not(.checked):hover {
    outline: 1px solid color-mix(in srgb, var(--primary) 30%, transparent) !important;
}

.checked {
    cursor: pointer;
    color: #fff;
    background-color: var(--primary);
    font-size: 14px;
    width: max-content;
    line-height: 10px;
    text-align: center;
    border-radius: 50px;
    padding: 10px 20px;
}
</style>
</script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<!-- Datatable import buttons css and script -->
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>

<style>
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
    padding-top: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #c7c7c7;
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

<section>
    <div class="panel-section-card py-20 px-5 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                        <h2 class="section-title mb-3 px-10">My Mocktest</h2>
                        <div class="accordion__item d-block">
                            <div id="default_collapseTwo" class="accordion__body show" data-parent="#accordion-one"
                                style="">
                                <div class="accordion__body--text">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" data-model="full-test"
                                                        href="#full-test">Full Test</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" data-model="section-test"
                                                        href="#section-test">Section Test</a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" data-model="question-test"
                                                        href="#question-test">Question Test</a>
                                                </li> -->
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="full-test" role="tabpanel">
                                                    <div class="pt-4 table-responsive">
                                                        <table class="table text-center custom-table custom-question-table "
                                                            data-model="full-test" data-id="full-test">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th class="text-center">Question</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="section-test" role="tabpanel">
                                                    <div class="pt-4 table-responsive">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link sub-type active" data-sub-id=""
                                                                    data-toggle="tab" href="#">All</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link sub-type " data-sub-id="reading"
                                                                    data-toggle="tab" href="#">Reading</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link sub-type " data-sub-id="writing"
                                                                    data-toggle="tab" href="#">Writing</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link sub-type " data-sub-id="speaking"
                                                                    data-toggle="tab" href="#">Speaking</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link sub-type " data-sub-id="listening"
                                                                    data-toggle="tab" href="#">Listening</a>
                                                            </li>
                                                        </ul>
                                                        <table id="section-test-table"
                                                            class="table text-center custom-table custom-question-table"
                                                            data-model="section-test" data-id="section-test">
                                                            <thead>
                                                                <tr>
                                                                    <th class="align-middle">#</th>
                                                                    <th class="align-middle">Question</th>
                                                                    <th class="align-middle">Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- <div class="tab-pane fade" id="question-test" role="tabpanel">
                                                    <div class="col-md-12">
                                                        <div class="text-justify pt-30">
                                                            <input type="radio" id="all" name="target" value=""
                                                                <?php if(!$rowData->question_code){echo 'checked';} ?> />
                                                            <label
                                                                class="check-radio <?php if(!$rowData->question_code){echo 'checked';} ?>"
                                                                for="all">All</label>

                                                            <?php foreach ($getQuestionCategory as $data => $rowData) { ?>
                                                            <input type="radio"
                                                                id="<?php echo $rowData->question_code ?>" name="target"
                                                                value="<?php echo $rowData->question_code ?>" />
                                                            <?php $category = getCategoryDataByCode($rowData->question_code); ?>
                                                            <label class="check-radio"
                                                                for="<?php echo $rowData->question_code ?>"><?php echo $category['code_name']; ?></label>
                                                            <?php }?>

                                                        </div>
                                                    </div>
                                                    <div class="pt-4 table-responsive">
                                                        <table id="question-test-table"
                                                            class="table text-center custom-table custom-question-table"
                                                            data-model="question-test" data-id="question-test">
                                                            <thead>
                                                                <tr>
                                                                    <th class="align-middle">#</th>
                                                                    <th class="align-middle">Question</th>
                                                                    <th class="align-middle">Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
</section>

    <script>
        var siteUrl = '<?php echo base_url(); ?>';
        jQuery(document).ready(function($) {
    $('[name="target"]').change((evt) => {
        val = evt.target.value

        $("input[name='target'] + .check-radio").removeClass('checked');
        $('input[name="target"]:checked + .check-radio').addClass('checked');

        const current_category = 'question-test';
        const sub_category = val;
        $('#question-test-table').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            dataType: "json",
            paging: true,
            pagingType: "numbers",
            order: [],
            pageLength: 10,
            "ajax": {
                "url": url,
                // "type": "POST",
                "data": function(data) {
                    data.category = current_category;
                    data.sub_category = sub_category;
                },
            },
            "columnDefs": [{
                "targets": [0, 1, 2],
                "orderable": false
            }],
            // "initComplete":function( settings, json){
            //     $('#question_count').html(json.question_count); 
            // }
            "bInfo": false,
            searching: false,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
        });

    });

    let url = "<?php echo base_url('mock/getlist'); ?>";
    $(document).ready(function() {
        // console.log('test');
        $('.custom-question-table').each(function() {
            const current_category = $(this).attr('data-id');
            // console.log(current_category);

            $(this).DataTable({
                processing: true,
                serverSide: true,
                dataType: "json",
                paging: true,
                pagingType: "numbers",
                order: [],
                pageLength: 10,
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-12 d-flex justify-content-center'p>>",
                "ajax": {
                    "url": url,
                    // "type": "POST",
                    "data": function(data) {
                        data.category = current_category;
                        
                    },
                },
                "columnDefs": [{
                    "targets": [0, 1, 2],
                    "orderable": false
                }],
                // "initComplete":function( settings, json){
                //     $('#question_count').html(json.question_count); 
                // }
                "bInfo": false,
                searching: false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false
            });
        });
    });

    $('.sub-type').on('click', function() {
        const current_category = 'section-test';
        const sub_category = $(this).attr('data-sub-id');
        $('#section-test-table').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            dataType: "json",
            paging: true,
            pagingType: "numbers",
            order: [],
            pageLength: 10,
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-12 d-flex justify-content-center'p>>",
            "ajax": {
                "url": url,
                // "type": "POST",
                "data": function(data) {
                    data.category = current_category;
                    data.sub_category = sub_category;
                },
            },
            "columnDefs": [{
                "targets": [0, 1, 2],
                "orderable": false
            }],
            // "initComplete":function( settings, json){
            //     $('#question_count').html(json.question_count); 
            // }
            "bInfo": false,
            searching: false,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
        });
    });
});

function taketest(series){
    var csrfName = $('.csrfToken').attr('name');
    var csrfHash = $('.csrfToken').val(); // CSRF hash

    $.ajax({
        url: siteUrl + "mock/checkpurchaseattempt/" + series,
        type: "POST",
        crossDomain: true,
        dataType: 'json',
        cache: false,
        data: {[csrfName]: csrfHash},
        success: function (data) {
            $('.csrfToken').val(data.token);
            if(data.status != 0){
                Swal.fire("You've already reached your limit. Buy some package to continue to take test.");
            }else{
                location.href = siteUrl + "mock/test/" + series;
            }
        }
    });
}
    </script>