<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link href="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/select2/select2.min.css" rel="stylesheet" />

<div class="block block-rounded mt-150">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center h-100" style="height:unset !important">
            <div class="col-lg-8 col-xl-12">
                <?php if($this->session->userdata('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $this->session->userdata('error');
	                    $this->session->unset_userdata('error');
	                ?>
                </div>
                <?php } ?>
                <?php if($this->session->userdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $this->session->userdata('success');
                        $this->session->unset_userdata('success');
	                ?>
                </div>
                <?php } ?>

                <form action="<?php echo base_url() ?>package/storePackage" class="form-valide" id="package-form" method="post" accept-charset="utf-8" data-parsley-validate name="packageForm">
                    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="writing_questions" value="">
                    <input type="hidden" name="reading_questions" value="">
                    <input type="hidden" name="listening_questions" value="">
                    <input type="hidden" name="speaking_questions" value="">
                    <input type="hidden" name="packageid" value="<?php echo $getpackage[0]->packageid; ?>">
                    <div class="section-header">
                        <h3 class="" id="headingTitle">Create Package</h3>
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
                                                                    <input type="text" name="package_name" id="name"
                                                                        value="<?php echo $getpackage[0]->package_name; ?>"
                                                                        placeholder="NAME" class="form-control"
                                                                        required onkeydown="return /[a-zA-Z0-9\s]/i.test(event.key)">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-6 form-group mt-15 ">
                                                                <label class="col-form-label">PTE Type</label>
                                                                    <div>
                                                                        <select id="pteType" class="form-control col-form-label" name="pteType" required>
                                                                            <option value="">Select PTE Type</option>
                                                                            </option>
                                                                            <option value="<?php echo PTEACADEMIC; ?>" <?php if($getpackage[0]->pte_type == 'academic') {echo 'selected';} ?>>PTE Academic</option>
                                                                            </option>
                                                                            <option value="<?php echo PTECORE; ?>" <?php if($getpackage[0]->pte_type == 'core') {echo 'selected';} ?>>PTE Core</option>
                                                                            </option>
                                                                        </select>
                                                                        </div>
                                                                </div>
                                                                <div class="col-6 form-group mt-15 ">
                                                                <label class="col-form-label">Category</label>
                                                                    <div>
                                                                        <select id="usage_type" class="form-control col-form-label" name="usage_type" required>
                                                                            <?php 
                                                                                $usage_options = ["Regular" => PACKAGE_REGULAR, "Free" => PACKAGE_FREE, "Applykart" => PACKAGE_APPLYKART, "Practice Pro" => PACKAGE_PRACTICE_PRO, "Success Bundle" => PACKAGE_SUCCESS_BUNDLE];
                                                                                foreach ($usage_options as $label => $value) {
                                                                            ?>
                                                                                <option value="<?php echo $value ?>" <?php if( $getpackage[0]->usage_type == $value) {echo 'selected';} ?>><?php echo $label; ?></option>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label" for="price">Cost ($)</label>
                                                                    <input type="number" name="cost" id="price"
                                                                        value="<?php echo $getpackage[0]->cost; ?>"
                                                                        placeholder="PRICE" class="form-control"
                                                                        min="0"
                                                                        required>
                                                                </div>
                                                            </div>



                                                            <div class="row mb-1">
                                                                <div class="col-6 form-group ">
                                                                    <label class="input-label"
                                                                        for="duration">Duration</label>
                                                                    <input type="number" name="duration" id="duration"
                                                                        value="<?php echo $getpackage[0]->duration; ?>"
                                                                        placeholder="DURATION" class="form-control"
                                                                        min="0"
                                                                        required>
                                                                </div>
                                                                <div class="col-6 form-group ">
                                                                    <label class="input-label"
                                                                        for="duration_type">Duration Type</label>
                                                                    <select name="duration_type" class="form-control "
                                                                        value="<?php echo $getpackage[0]->duration_type; ?>"
                                                                        required>
                                                                        <option value="day"
                                                                            <?php if($getpackage[0]->duration_type == 'day') {echo 'selected';} ?>>
                                                                            Day</option>
                                                                        <option value="month"
                                                                            <?php if($getpackage[0]->duration_type == 'month') {echo 'selected';} ?>>
                                                                            Month</option>
                                                                        <option value="year"
                                                                            <?php if($getpackage[0]->duration_type == 'year') {echo 'selected';} ?>>
                                                                            Year</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label" for="limit">Limit Attempt's</label>
                                                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Leave it as 0 for unlimited"></i>
                                                                    <input type="number" name="attempt_limit" id="limit" value="<?php echo $getpackage[0]->attempt_limit ? $getpackage[0]->attempt_limit : 0; ?>" min="0" class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label"
                                                                        for="desc">Description</label>
                                                                    <input type="text" name="desc" id="desc"
                                                                        value="<?php echo $getpackage[0]->description; ?>"
                                                                        placeholder="DESCRIPTION" class="form-control"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label" for="select_test">Test Category</label>
                                                                    <select name="package_category[]" id="select_test" class="form-control select2" required onchange="test_select()" multiple="multiple">
                                                                        <!-- <option value="">Select test</option> -->
                                                                        <?php $package_categories = explode(",",$getpackage[0]->package_category); ?>
                                                                        <option value="full-test"
                                                                            <?php if(in_array('full-test', $package_categories)) {echo 'selected';} ?>>
                                                                            Full Test </option>
                                                                        <option value="section-test"
                                                                            <?php if(in_array('section-test', $package_categories)) {echo 'selected';} ?>>
                                                                            Section Test</option>
                                                                        <option value="question-test"
                                                                            <?php if(in_array('question-test', $package_categories)) {echo 'selected';} ?>>
                                                                            Question Test</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label">Test list</label>
                                                                    <select name="category_type_ids[]" id="category-select" class="form-control category-select select2" multiple="multiple" required>
                                                                        <?php foreach($result as $test){ ?>
                                                                        <option value="<?php echo $test[0]->id; ?>">
                                                                            <?php echo $test[0]->title; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label"
                                                                        for="is_purchaseable">Purchaseable ?</label>
                                                                    <select name="is_purchaseable" class="form-control"
                                                                        required>
                                                                        <option value="1"
                                                                            <?php if($getpackage[0]->is_purchaseable == '1') {echo 'selected';} ?>>
                                                                            Yes</option>
                                                                        <option value="0"
                                                                            <?php if($getpackage[0]->is_purchaseable == '0') {echo 'selected';} ?>>
                                                                            No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row mb-1">
                                                                <div class="col-6 form-group ">
                                                                    <label class="input-label"
                                                                        for="show_videos">Show Videos</label>
                                                                    <select name="show_videos" class="form-control"
                                                                        required>
                                                                        <option value="0"
                                                                        <?php if($getpackage[0]->show_videos == '0') {echo 'selected';} ?>>
                                                                        No</option>
                                                                        <option value="1"
                                                                        <?php if($getpackage[0]->show_videos == '1') {echo 'selected';} ?>>
                                                                        Yes</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 form-group ">
                                                                    <label class="input-label"
                                                                        for="addon_language">Video Language Addons</label>
                                                                    <select name="addon_language" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option value="PB"
                                                                        <?php if($getpackage[0]->addon_language == 'PB') {echo 'selected';} ?>>
                                                                        Punjabi</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label"
                                                                        for="show_materials">Show Materials</label>
                                                                    <select name="show_materials" class="form-control"
                                                                        required>
                                                                        <option value="0"
                                                                        <?php if($getpackage[0]->show_materials == '0') {echo 'selected';} ?>>
                                                                        No</option>
                                                                        <option value="1"
                                                                        <?php if($getpackage[0]->show_materials == '1') {echo 'selected';} ?>>
                                                                        Yes</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row mb-1">
                                                                <div class="col-12 form-group ">
                                                                    <label class="input-label"
                                                                        for="show_class_links">Show Class Links</label>
                                                                    <select name="show_class_links" class="form-control"
                                                                        required>
                                                                        <option value="0"
                                                                        <?php if($getpackage[0]->show_class_links == '0') {echo 'selected';} ?>>
                                                                        No</option>
                                                                        <option value="1"
                                                                        <?php if($getpackage[0]->show_class_links == '1') {echo 'selected';} ?>>
                                                                        Yes</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class=" col-xl-3">
                                                                    <div class="form-group"><input type="submit"
                                                                            name="submit_btn" id="submit_btn"
                                                                            class="btn btn-primary" value="Submit">
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
</div>
</div>
<div style="overflow:auto;">
    <div style="text-align:center;margin-top:40px;"><span class="step"></span>
    </div>
    </form>
</div>
</div>
</div>
</div>
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/select2/select2.min.js"></script>
<script type="text/javascript">
    var selected_tests;
    const addSelectAll = matches => {
        if (matches.length > 0) {
        // Insert a special "Select all matches" item at the start of the 
        // list of matched items.
        return [
            {id: 'selectAll', text: 'Select all', matchIds: matches.map(match => match.id)},
            {id: 'clearAll', text: 'Clear all', matchIds: null},
            ...matches
        ];
        }
    };

    const handleSelection = event => {
        if (event.params.data.id === 'selectAll') {
            $('#category-select').val(event.params.data.matchIds);
            $('#category-select').trigger('change');
        };
        if (event.params.data.id === 'clearAll') {
            $('#category-select').val(event.params.data.matchIds);
            $('#category-select').trigger('change');
        };
    };
    
    $(document).ready(function() {
        // $('#category-select').select2();
        $('#category-select').select2({
            sorter: addSelectAll,
        });
        var package_id = '<?php echo $getpackage[0]->packageid ? $getpackage[0]->packageid : '' ?>';
        if(package_id){
            test_select();
            selected_tests = '<?php echo $getpackage[0]->category_type_ids ?>';
        }

        $('#category-select').on('select2:select', handleSelection);
    });

    $('#submit_btn').click(function() {
        var form = $('#package-form');

        form.parsley().validate();
        if (!form.parsley().isValid()) {
            return false;
        } else {
            $("[name='reading_questions'").val(Array.from(selected_questions[0]['reading']).join(','));
            $("[name='writing_questions'").val(Array.from(selected_questions[0]['writing']).join(','));
            $("[name='listening_questions'").val(Array.from(selected_questions[0]['listening']).join(','));
            $("[name='speaking_questions'").val(Array.from(selected_questions[0]['speaking']).join(','));
            $('#mock-test-form').submit();
        }
    });

    function test_select() {

        // $('#category-select').select2('destroy');
        var selectedValue = $('#select_test').val();
        // selectedValue =  JSON.stringify(selectedValue);
        // console.log(selectedValue);
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash
        $.ajax({
            url: "<?php echo base_url() ?>package/getmocktests",
            method: "POST",
            data: {
                [csrfName]: csrfHash,
                selectedValue: selectedValue
            },
            success: function(data) {
            
                var data = JSON.parse(data);
                $('.csrfToken').val(data.token);
                $("#category-select").html('');
                // $('.select2-container').remove();
                data.result.forEach((mocktest) => {
                    var selected = '';
                    if(selected_tests && selected_tests.includes(mocktest.id)){
                        selected = 'selected';
                    }
                    $('.category-select').append('<option value="' + mocktest.id + '"' + selected + '>' + mocktest.title + '</option>');
                })
                $('#category-select').select2({ sorter: addSelectAll, });
            }
        });
    };
</script>