<style>
    table.dataTable {
        width: 100% !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

<!-- Datatable import buttons css and script -->
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>

<section>
    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h2 class="section-title mb-3">Study Materials</h2>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" data-model="document" href="#document">Documents</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" data-model="link" href="#link">Links</a>
                            </li> -->
                            <?php if($this->session->userdata('show_class_links')){ ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" data-model="class_link" href="#class-link">Class Links</a>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="document" role="tabpanel">
                                <div class="pt-4 table-responsive">
                                    <table class="table text-center custom-table" data-model="document" data-id="document">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="tab-pane fade" id="link" role="tabpanel">
                                <div class="pt-4 table-responsive">
                                    <table class="table text-center custom-table" data-model="link" data-id="link">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div> -->
                            <?php if($this->session->userdata('show_class_links')){ ?>
                            <div class="tab-pane fade" id="class-link" role="tabpanel">
                                <div class="pt-4 table-responsive">
                                    <table class="table text-center custom-table" data-model="class_link" data-id="class-link">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
</section>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="viewer-js-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="viewer-js-content">
            </div>
        </div>
    </div>
</div>

<script>
    let url = "<?php echo base_url('user/getmaterialslist'); ?>";
    let viewerPath = "<?php echo base_url('assets/ViewerJS/index.html#../../'); ?>";

    $('.custom-table').each(function() {
        const current_category = $(this).attr('data-model');
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
                "data": function(data) {
                    data.type = current_category;
                },
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }, {
                "targets": [0],
                "className": 'text-left'
            }]
        });
    });
    // <embed src="<?php echo base_url('uploads/materials/659b8e47bf7c1.pdf') ?>" type="application/pdf" width="100%" height="600px" />
    function getPDFFile(e){
        $("#viewer-js-content").html("");
        let modalContent = document.getElementById("viewer-js-content");
        var newFrame = document.createElement("iframe");
        newFrame.src = viewerPath + $(e).data("viewersrc");
        newFrame.id = "viewerjsframe";
        newFrame.type = "application/pdf";
        newFrame.width = "100%";
        newFrame.height = "600px";
        console.log(newFrame)
        modalContent.appendChild(newFrame);
        $("viewerjsframe").attr("src",viewerPath + $(e).data("viewersrc"));
        $("#viewer-js-modal").modal("show");
    }
</script>