<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/js/parsley/parsley.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/select2/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="<?php echo base_url(); ?>public/js/plugins/ckeditor/ckeditor.js"></script>
<style>
    .dropzone {
        background: none repeat scroll 0 0 color-mix(in srgb, var(--primary) 20%, transparent);
        border: 2px dashed var(--primary);
        border-radius: 5px;
    }
</style>
<div class="block block-rounded mt-150">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center h-100" style="height:unset !important">
            <div class="col-lg-8 col-xl-12">
                <?php if ($this->session->userdata('error')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                        echo $this->session->userdata('error');
                        $this->session->unset_userdata('error');
                        ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->userdata('success')) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php
                        echo $this->session->userdata('success');
                        $this->session->unset_userdata('success');
                        ?>
                    </div>
                <?php } ?>

                <form action="<?php echo base_url("admin/material"); ?>" class="form-valide" id="materials-form" method="post" accept-charset="utf-8" data-parsley-validate name="materialsForm">
                    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="uploaded_file" id="uploaded_file" value="">
                    <div class="section-header">
                        <h3 class="" id="headingTitle">New Material</h3>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-validation">
                                            <div class="row">
                                                <div class="col-xl-8  ">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group mt-15 ">
                                                                    <label class="input-label" for="name">Name</label>
                                                                    <input type="text" name="label_name" id="name" placeholder="Label" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group mt-15 ">
                                                                <label class="col-form-label">PTE Type</label>
                                                                    <div>
                                                                        <select id="pteType" class="form-control col-form-label" name="pteType" required>
                                                                            <option value="" selected>Select PTE Type</option>
                                                                            </option>
                                                                            <option value="<?php echo PTEACADEMIC; ?>">PTE Academic</option>
                                                                            </option>
                                                                            <option value="<?php echo PTECORE; ?>">PTE Core</option>
                                                                            </option>
                                                                        </select>
                                                                        </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-1">
                                                                <div class="col-6 form-group ">
                                                                    <label class="input-label" for="doc_type">Type</label>
                                                                    <select name="doc_type" class="form-control " value="" required>
                                                                        <option value="document">Document</option>
                                                                        <option value="video">Video - Youtube</option>
                                                                        <option value="link">External Link</option>
                                                                        <option value="class_link">Class Links</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 form-group category-input d-none">
                                                                    <label class="input-label" for="category">Category</label>
                                                                    <select name="category" id="category" class="form-control " value="">
                                                                        <option value="">Select</option>
                                                                        <option value="reading">Reading</option>
                                                                        <option value="speaking">Speaking</option>
                                                                        <option value="listening">Listening</option>
                                                                        <option value="writing">Writing</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 form-group language-input d-none">
                                                                    <label class="input-label"
                                                                        for="language">Language</label>
                                                                    <select name="language" class="form-control">
                                                                        <option value="EN"
                                                                        <?php if($getpackage[0]->language == 'EN') {echo 'selected';} ?>>
                                                                        English</option>
                                                                        <option value="PB"
                                                                        <?php if($getpackage[0]->language == 'PB') {echo 'selected';} ?>>
                                                                        Punjabi</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 form-group ">
                                                                    <label class="input-label" for="status">Status</label>
                                                                    <select name="status" class="form-control " value="" required>
                                                                        <option value="0">Inactive</option>
                                                                        <option value="1">Active</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-1">
                                                                <div class="col-6 form-group link-input d-none">
                                                                    <label class="input-label" for="video_link">Path</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <button type="button" class="input-group-text">
                                                                                <i class="fa fa-link"></i>
                                                                            </button>
                                                                        </div>
                                                                        <input type="text" name="video_link" id="video_link" value="" class="form-control ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 form-group class-link-input d-none">
                                                                    <label class="input-label" for="class_link">Class Link</label>
                                                                    <textarea name="class_link" id="class_link" class="form-control" rows="6"></textarea>
                                                                </div>
                                                                <div class="col-12 form-group file-input-drop-zone">
                                                                    <div class="dropzone"></div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class=" col-xl-3">
                                                                    <div class="form-group"><input type="button" name="submit_btn" id="submit_btn" class="btn btn-primary" value="Submit">
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
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/select2/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="doc_type"]').trigger("change");
    });
    CKEDITOR.replace('class_link');
   //Disabling autoDiscover
    Dropzone.autoDiscover = false;
    var myDropzone = "";
    $(function() {
        //Dropzone class
         myDropzone = new Dropzone(".dropzone", {
            url: "<?php echo base_url('admin/upload'); ?>",
            paramName: "file",
            maxFilesize: 100,
            maxFiles: 1,
            addRemoveLinks: true,
            acceptedFiles: "application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            autoProcessQueue: false,
            success: function(file, response){
                response = JSON.parse(response);
                if(response.status){
                    $('#uploaded_file').val(response.result[0]);
                    $('#materials-form').submit();
                }else{
                    alert('Failed to upload the file! Try again reloading.');
                }
            }
        });
    });

    $('#submit_btn').click(function(e) {
        e.preventDefault();
        var form = $('#materials-form');

        form.parsley().validate();
        if (!form.parsley().isValid()) {
            return false;
        } else {
            if($('[name="doc_type"]').val() == "document" || $('[name="doc_type"]').val() == "video"){
                myDropzone.processQueue();
            }else{
                $('#materials-form').submit();
            }
        }
    });

    $('[name="doc_type"]').change(function(e){
       let _input = $('[name="doc_type"]');
       if(_input.val() == "document"){
            $(".category-input").addClass('d-none');
            $(".language-input").addClass('d-none');
            $(".link-input").addClass('d-none');
            $(".class-link-input").addClass('d-none');
            $(".file-input-drop-zone").removeClass('d-none');
            $("#video_link").attr('required',false);
            $("#category").attr('required',false);
            // $("#class_link").attr('required',false);
        }else if(_input.val() == "video"){
            $(".category-input").removeClass('d-none');
            $(".language-input").removeClass('d-none');
            $(".link-input").removeClass('d-none');
            $(".class-link-input").addClass('d-none');
            $(".file-input-drop-zone").removeClass('d-none');
            $("#video_link").attr('required',true); 
            $("#class_link").attr('required',false); 
            $("#category").attr('required',true); 
        }else if(_input.val() == "class_link"){
            $(".category-input").addClass('d-none');
            $(".language-input").addClass('d-none');
            $(".link-input").addClass('d-none');
            $(".class-link-input").removeClass('d-none');
            $(".file-input-drop-zone").addClass('d-none');
            $("#video_link").attr('required',false); 
            // $("#class_link").attr('required',true); 
            $("#category").attr('required',false); 
       }else{
            $(".category-input").addClass('d-none');
            $(".language-input").addClass('d-none');
            $(".link-input").removeClass('d-none');
            $(".class-link-input").addClass('d-none');
            $(".file-input-drop-zone").addClass('d-none');
            $("#video_link").attr('required',true);
            // $("#class_link").attr('required',false);
            $("#category").attr('required',false);
       }

       if(_input.val() == "document"){
            myDropzone.destroy();
            myDropzone = new Dropzone(".dropzone", {
                url: "<?php echo base_url('admin/upload'); ?>",
                paramName: "file",
                maxFilesize: 100,
                maxFiles: 1,
                addRemoveLinks: true,
                acceptedFiles: "application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                autoProcessQueue: false,
                success: function(file, response){
                    response = JSON.parse(response);
                    if(response.status){
                        $('#uploaded_file').val(response.result[0]);
                        $('#materials-form').submit();
                    }else{
                        alert('Failed to upload the file! Try again reloading.');
                    }
                }
            });
       }else if(_input.val() == "video"){
            myDropzone.destroy();
            myDropzone = new Dropzone(".dropzone", {
                url: "<?php echo base_url('admin/upload/thumbnail'); ?>",
                paramName: "file",
                maxFilesize: 100,
                maxFiles: 1,
                addRemoveLinks: true,
                acceptedFiles: "image/png,image/jpeg,image/jpg",
                autoProcessQueue: false,
                success: function(file, response){
                    response = JSON.parse(response);
                    if(response.status){
                        $('#uploaded_file').val(response.result[0]);
                        $('#materials-form').submit();
                    }else{
                        alert('Failed to upload the file! Try again reloading.');
                    }
                }
            });
       }
    });
</script>