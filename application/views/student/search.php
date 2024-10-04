<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<section class="mt-15">
    <h2 class="section-title">Filter Question</h2>

    <div class="panel-section-card py-20 px-25 mt-20">
        <form action="<?php echo base_url('user/search'); ?>" method="get" class="row" id="search-form">
            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label class="input-label">Search</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="input-group-text">
                                        <i class="fa fa-search text-white"></i>
                                    </button>
                                </div>
                                <input type="text" name="text" autocomplete="off" class="form-control" value="<?php echo $this->input->get('text'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="input-label">Type</label>
                            <?php 
                                $previous_category = "";
                                $categories = [];
                            ?>
                            <select name="type" class="form-control select2">
                                <option value="">-</option>
                                <?php 
                                    for ($i=0; $i < count($types); $i++) { 
                                        if($previous_category != $types[$i]->question_category){ ?>
                                            <optgroup label="<?php echo $types[$i]->question_category; ?>">
                                        <?php $previous_category = $types[$i]->question_category; }
                                ?>
                                <?php $selected = ""; if($this->input->get('type') == $types[$i]->question_code){$selected = "selected";} ?>
                                <option value="<?php echo $types[$i]->question_code; ?>" <?php echo $selected; ?>><?php echo $types[$i]->type_name; ?></option>
                                <?php 
                                    if($previous_category != $types[$i]->question_category){ ?>
                                        </optgroup>
                                        <?php 
                                    }
                                    } 
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <label class="input-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All</option>
                                <option value="attempted">Attempted</option>
                                <option value="not-attempted">Not Attempted</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="input-label">Order</label>
                            <select class="form-control" id="order" name="order">
                                <option value="new">Newest First</option>
                                <option value="old">Oldest First</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-2 d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-sm btn-primary w-100 mt-2">Show Results</button>
            </div>
        </form>
    </div>
</section>

<!-- <section class="mt-35">
    <h2 class="section-title">My comments</h2>

    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="row">
            <div class="col-12 ">
                <div class="table-responsive">
                    <table class="table custom-table text-center ">
                        <thead>
                            <tr>
                                <th class="text-left text-gray">Course</th>
                                <th class="text-gray text-center">Comment</th>
                                <th class="text-gray text-center">Status</th>
                                <th class="text-gray text-center">Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left align-middle" width="35%">
                                    <a class="text-dark-blue font-weight-500"
                                        href="https://lms.rocket-soft.org/course/Become-a-Product-Manager"
                                        target="_blank">Become a Product Manager</a>
                                </td>
                                <td class="align-middle">
                                    <button type="button" data-comment-id="53"
                                        class="js-view-comment btn btn-sm btn-gray200">View</button>
                                </td>

                                <td class="align-middle">
                                    <span class="text-primary text-dark-blue font-weight-500">Published</span>
                                </td>

                                <td class="text-dark-blue font-weight-500 align-middle">14 Jul 2021 | 01:21</td>
                                <td class="align-middle text-right">
                                    <input type="hidden" id="commentDescription53"
                                        value="Course files are not complete !!!">
                                    <div class="btn-group dropdown table-actions">
                                        <button type="button" class="btn-transparent dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button" data-comment-id="53"
                                                class="js-edit-comment btn-transparent">Edit</button>
                                            <a href="/panel/webinars/comments/53/delete"
                                                class="delete-action btn-transparent d-block mt-10">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left align-middle" width="35%">
                                    <a class="text-dark-blue font-weight-500"
                                        href="https://lms.rocket-soft.org/course/The-Future-of-Energy"
                                        target="_blank">The Future of Energy</a>
                                </td>
                                <td class="align-middle">
                                    <button type="button" data-comment-id="51"
                                        class="js-view-comment btn btn-sm btn-gray200">View</button>
                                </td>

                                <td class="align-middle">
                                    <span class="text-primary text-dark-blue font-weight-500">Published</span>
                                </td>

                                <td class="text-dark-blue font-weight-500 align-middle">9 Jul 2021 | 17:02</td>
                                <td class="align-middle text-right">
                                    <input type="hidden" id="commentDescription51"
                                        value="Will we receive a certificate at the end of this course?">
                                    <div class="btn-group dropdown table-actions">
                                        <button type="button" class="btn-transparent dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button" data-comment-id="51"
                                                class="js-edit-comment btn-transparent">Edit</button>
                                            <a href="/panel/webinars/comments/51/delete"
                                                class="delete-action btn-transparent d-block mt-10">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="mt-35">
    <h2 class="section-title">Search Results</h2>

    <div class="panel-section-card py-20 px-0 mt-20">
        <div class="row">
            <div class="col-12 ">
                <div class="table-responsive">
                    <table class="table custom-table text-center ">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var siteUrl = '<?php echo base_url(); ?>';
    let searchText = document.getElementsByName('text')[0];
    let category = document.getElementsByName('type')[0];
    // let status = document.getElementsByName('status')[0];
    let order = document.getElementsByName('order')[0];
    var dataTable = $('.custom-table').DataTable({
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
            // "url": siteUrl + "user/searchlist?text="+searchText.value+"&type="+category.value+"&status="+status.value+"&order="+order.value,
            "url": siteUrl + "user/searchlist?text="+searchText.value+"&type="+category.value+"&order="+order.value,
        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false
        },
        {
            "targets": [0],
            "className": 'text-left'
        }],
        // "initComplete":function( settings, json){
        //     $('#question_count').html(json.question_count); 
        // }
        // "bInfo": false,
        // searching: false,
        // "bPaginate": false,
        // "bLengthChange": false,
        // "bFilter": true,
        // "bInfo": false,
        // "bAutoWidth": false
    });

    $('#search-form').submit(function(e){
        e.preventDefault();
        // dataTable.ajax.url(siteUrl + "user/searchlist?text="+searchText.value+"&type="+category.value+"&status="+status.value+"&order="+order.value);
        dataTable.ajax.url(siteUrl + "user/searchlist?text="+searchText.value+"&type="+category.value+"&order="+order.value);
        dataTable.ajax.reload();
    });
</script>