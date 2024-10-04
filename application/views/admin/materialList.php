<style>
table.dataTable {
    width: 100% !important;
}

.status-switch{
	height: 0;
	width: 0;
	visibility: hidden;
}

.toggle-label {
	cursor: pointer;
	text-indent: -9999px;
	width: 40px;
	height: 20px;
	background: grey;
	display: block;
	border-radius: 100px;
	position: relative;
}

.toggle-label:after {
	content: '';
	position: absolute;
	top: 1px;
	left: 1px;
	width: 20px;
	height: 18px;
	background: #fff;
	border-radius: 90px;
	transition: 0.3s;
}

input:checked + .toggle-label {
	background: var(--primary);
}

input:checked + .toggle-label:after {
	left: calc(100% - 1px);
	transform: translateX(-100%);
}

.toggle-label:active:after {
	width: 26px;
}
</style>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">



<div class="block">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-8 col-xl-12">
                <form
                    action="<?php echo base_url() ?>admin/createmocktest/<?php echo $mock_test_type?>/<?php if(isset($getMockTest) && strlen($getMockTest[0]->id) > 0){ echo $getMockTest[0]->id;} ?>"
                    class="form-valide" id="mock-test-form" method="post" accept-charset="utf-8" data-parsley-validate>
                    
                        <input type="hidden" class="csrfToken"
                            name="<?php echo $this->security->get_csrf_token_name(); ?>"
                            value="<?php echo $this->security->get_csrf_hash(); ?>">
                

                        <div class="section-header">
                            <div class="col-12 row">
                                <div class="col-6">
                                    <h3 class="" id="headingTitle">Materials list</h3>
                                </div>
                            </div>

                        </div>

                        <!-- form error notification -->
                        <?php if($this->session->userdata('error')){ ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->userdata('error'); 
                        $this->session->unset_userdata('error');?>
                        </div>
                        <?php } ?>
                        <?php if($this->session->userdata('success')){ ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->userdata('success'); 
                        $this->session->unset_userdata('success');?>
                        </div>
                        <?php } ?>

                        <div class="section-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Nav tabs -->
                                            <div class="custom-tab-1">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link active" data-toggle="tab"
                                                            data-model="document" href="#document">Documents</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link" data-toggle="tab"
                                                            data-model="video" href="#video">Videos</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link" data-toggle="tab"
                                                            data-model="link" href="#link">Links</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link" data-toggle="tab"
                                                            data-model="class_link" href="#class-link">Class Links</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="document" role="tabpanel">
                                                        <div class="pt-4 table-responsive">
                                                            <table id="documents-table"
                                                                class="materials-table display min-w850"
                                                                data-model="document">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">File</th>
                                                                        <th class="align-middle" width="50%">Label</th>
                                                                        <th width="10%">Status</th>
                                                                        <th>Created On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">File</th>
                                                                        <th class="align-middle" width="50%">Label</th>
                                                                        <th width="10%">Status</th>
                                                                        <th>Created On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="video" role="tabpanel">
                                                        <div class="pt-4 table-responsive">
                                                            <table id="videos-table"
                                                                class="materials-table display min-w850"
                                                                data-model="video">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Path</th>
                                                                        <th class="align-middle" width="40%">Label</th>
                                                                        <th class="align-middle">Category</th>
                                                                        <th class="align-middle">Language</th>
                                                                        <th width="10%">Status</th>
                                                                        <th class="align-middle">Added On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Path</th>
                                                                        <th class="align-middle" width="40%">Label</th>
                                                                        <th class="align-middle">Category</th>
                                                                        <th class="align-middle">Language</th>
                                                                        <th width="10%">Status</th>
                                                                        <th class="align-middle">Added On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="link" role="tabpanel">
                                                        <div class="pt-4 table-responsive">
                                                            <table id="links-table"
                                                                class="materials-table display min-w850"
                                                                data-model="link">
                                                                <thead>
                                                                    <tr>
                                                                    <th class="align-middle">#</th>
                                                                        <th class="align-middle">Link</th>
                                                                        <th class="align-middle" width="45%">Label</th>
                                                                        <th width="10%">Status</th>
                                                                        <th>Added On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                    <th class="align-middle">#</th>
                                                                        <th class="align-middle">Link</th>
                                                                        <th class="align-middle" width="45%">Label</th>
                                                                        <th width="10%">Status</th>
                                                                        <th>Added On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="class-link" role="tabpanel">
                                                        <div class="pt-4 table-responsive">
                                                            <table id="class-links-table"
                                                                class="materials-table display min-w850"
                                                                data-model="class_link">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Label</th>
                                                                        <th class="align-middle" width="45%">Link</th>
                                                                        <th width="10%">Status</th>
                                                                        <th>Added On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Label</th>
                                                                        <th class="align-middle" width="45%">Link</th>
                                                                        <th width="10%">Status</th>
                                                                        <th>Added On</th>
                                                                        <th class="align-middle">Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                </form>

            </div>
        </div>
    </div>
</div>


<!-- Required vendors -->
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/poper/popper.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/bootstrap/bootstrap.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>



<script type="text/javascript">

let url = "<?php echo base_url('admin/getmaterialslist'); ?>";

$(document).ready(function() {
    $('.materials-table').each(function() {
        const current_type = $(this).attr('data-model');
        let colDef = [];
        if(current_type == "document"){
            colDef = [
                { targets:[0,1,3,5], orderable: false }
            ];
        }else if(current_type == "video"){
            colDef = [
                { targets:[0,1,5,7], orderable: false }
            ];
        }else if(current_type == "class_link"){
            colDef = [
                { targets:[0,1,2,3,5], orderable: false },
                { targets:[2], className: 'text-left'}
            ];
        }else{
            colDef = [
                { targets:[0,1,3,5], orderable: false }
            ];
        }
        $(this).DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            dataType: "json",
            paging: true,
            pagingType: "simple_numbers",
            order: [],
            pageLength: 50,
            "ajax": {
                "url": url,
                "data": function(data) {
                    data.type = current_type;
                },
                "complete": function(data) {
                }
            },
            "columnDefs": colDef,
            "initComplete": function(settings, json) {
                // $('#question_count').html(json.question_count);
            }
        });
    });
});

function deletematerial(id) {
    if (confirm('Do you really want to delete this material? You won\'t be able to recover it later.')) {
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash

        $.ajax({
            url: "<?php echo base_url( "admin/deletematerial"); ?>",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                material: id,
            },
            success: function(data) {
                $('.csrfToken').val(data.token);
                $('.materials-table').DataTable().ajax.reload();
            }
        });
    } else {
        return false;
    }
}

function changestatus(id,e){
    var csrfName = $('.csrfToken').attr('name');
    var csrfHash = $('.csrfToken').val();
    $.ajax({
        url: "<?php echo base_url() ?>admin/changematerialstatus", 
        type: "POST",  
        crossDomain: true,
        dataType: 'json',
        cache: false,
        data:{
            [csrfName]: csrfHash,
            material : id,
            status : e.checked ? 1 : 0,
        },  
        success:function(data){
            $('.csrfToken').val(data.token);
        }  
    });  
}

</script>
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/js/scripts.js"></script>