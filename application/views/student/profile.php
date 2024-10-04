<link href="<?php echo base_url() ?>assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
<style>
.btn-close {
    --bs-btn-close-color: #000;
    --bs-btn-close-bg: url(<?php echo base_url() ?>assets/images/cancle.svg);
    --bs-btn-close-opacity: 0.5;
    --bs-btn-close-hover-opacity: 0.75;
    --bs-btn-close-focus-shadow: 0 0 0 0.25rem rgba(254, 99, 78, 0.25);
    --bs-btn-close-focus-opacity: 1;
    --bs-btn-close-disabled-opacity: 0.25;
    --bs-btn-close-white-filter: invert(1) grayscale(100%) brightness(200%);
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: 0.25em 0.25em;
    color: var(--bs-btn-close-color);
    background: transparent var(--bs-btn-close-bg) center/1em auto no-repeat;
    border: 0;
    border-radius: 0.75rem;
    opacity: var(--bs-btn-close-opacity);
}
</style>

<section>
    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title mb-3">My Profile</h2>
                        <?php if($this->session->userdata('profile_completed') != 1){ ?>
                            <span class="text-gray">Complete your profile to continue</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-35">
    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="row">
            <div class="col-xl-12">
                <div class="card h-auto">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <div class="tab-content">
                                    <div id="profile-settings" class="tab-pane fade active show" role="tabpanel">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <!-- <h4 class="text-primary">My Profile</h4> -->
                                                <form class="mb-5" id="profile_form"
                                                    action="<?php echo base_url(); ?>user/profile" method="POST"
                                                    accept-charset="utf-8" enctype="multipart/form-data"
                                                    data-parsley-validate>
                                                    <?php foreach ($getUser as $key => $rowuser) { ?>
                                                    <input type="hidden" class="csrfToken"
                                                        name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label>First Name</label>
                                                            <input id="first_name" name="first_name" type="text"
                                                                placeholder="First Name" class="form-control"
                                                                value="<?php echo $rowuser->first_name ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Last Name</label>
                                                            <input id="last_name" name="last_name" type="text"
                                                                placeholder="Last Name" class="form-control"
                                                                value="<?php echo $rowuser->last_name ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Phone</label>
                                                            <input id="phone" name="phone" type="tel"
                                                                placeholder="Phone" class="form-control"
                                                                value="<?php echo $rowuser->phone ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input id="email" name="email" type="tel"
                                                                placeholder="Email" class="form-control"
                                                                value="<?php echo $rowuser->email ?>" readonly required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label>Country of citizenship</label>
                                                            <div>
                                                                <select id="citizenship_country"
                                                                    name="citizenship_country"
                                                                    class="form-control countries_data" required>
                                                                    <option value="">Choose...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Country of residence</label>
                                                            <div>
                                                                <select id="residence_country" name="residence_country"
                                                                    class="form-control countries_data"
                                                                    onChange="states()" required>
                                                                    <option value="">Choose...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>State</label>
                                                            <div>
                                                                <select name="residence_state"
                                                                    class="form-control states_data" required>
                                                                    <option value="">Choose...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label>Mother Tongue</label>
                                                            <div>
                                                                <select name="mother_tongue" class="form-control"
                                                                    required>
                                                                    <option value="">Choose...</option>
                                                                    <option value="English"
                                                                        <?php echo $rowuser->mother_tongue == 'English' ? 'selected' : ''?>>
                                                                        English</option>
                                                                    <option value="Hindi"
                                                                        <?php echo $rowuser->mother_tongue == 'Hindi' ? 'selected' : ''?>>
                                                                        Hindi</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Select Branch</label>
                                                            <div>
                                                                <select name="branch" class="form-control" required>
                                                                    <option value="">Not Applicable</option>
                                                                    <option value="Melbourne CBD"
                                                                        <?php echo $rowuser->branch == 'Melbourne CBD' ? 'selected' : ''?>>
                                                                        Melbourne CBD</option>
                                                                    <option value="Clayton"
                                                                        <?php echo $rowuser->branch == 'Clayton' ? 'selected' : ''?>>
                                                                        Clayton</option>
                                                                    <option value="Trugnina"
                                                                        <?php echo $rowuser->branch == 'Trugnina' ? 'selected' : ''?>>
                                                                        Trugnina</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Desired Band</label>
                                                            <div>
                                                                <select name="desired_band" class="form-control"
                                                                    required>
                                                                    <option value="">Select Desired Band</option>
                                                                    <option value="5"
                                                                        <?php echo $rowuser->desired_band == '5' ? 'selected' : ''?>>
                                                                        36+ (5 Bands)</option>
                                                                    <option value="5.5"
                                                                        <?php echo $rowuser->desired_band == '5.5' ? 'selected' : ''?>>
                                                                        42+ (5.5 Bands)</option>
                                                                    <option value="6"
                                                                        <?php echo $rowuser->desired_band == '6' ? 'selected' : ''?>>
                                                                        50+ (6 Bands)</option>
                                                                    <option value="6.5"
                                                                        <?php echo $rowuser->desired_band == '6.5' ? 'selected' : ''?>>
                                                                        58+ (6.5 Bands)</option>
                                                                    <option value="7"
                                                                        <?php echo $rowuser->desired_band == '7' ? 'selected' : ''?>>
                                                                        65+ (7 Bands)</option>
                                                                    <option value="7.5"
                                                                        <?php echo $rowuser->desired_band == '7.5' ? 'selected' : ''?>>
                                                                        73+ (7.5 Bands)</option>
                                                                    <option value="8"
                                                                        <?php echo $rowuser->desired_band == '8' ? 'selected' : ''?>>
                                                                        79+ (8 Bands)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Profile</label>
                                                                <input class="form-control" name="image" type="file"
                                                                    id="formFile">
                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="bootstrap-modal">
                                                                    <!-- Button trigger modal -->
                                                                    <button type="button" class="btn btn-primary mb-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#basicModal"
                                                                        id="basicmodalbtn">Choose from Avatar</button>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="basicModal">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Avatars</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"><span>×</span>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-md-6 text-center">
                                                                                            <img class="pb-2"
                                                                                                src="<?php echo base_url('assets/images/avatar1.png'); ?>"
                                                                                                data-img="assets/images/avatar1.png"
                                                                                                id="img-avatar1"
                                                                                                alt="Avtar1"
                                                                                                width="150px"
                                                                                                height="150px"><br>
                                                                                            <button type="button"
                                                                                                class="btn btn-primary"
                                                                                                style="padding: 9px 45p"
                                                                                                id="avatar1">Select</button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-6 text-center">
                                                                                            <img class="pb-2"
                                                                                                src="<?php echo base_url('assets/images/avatar2.png'); ?>"
                                                                                                data-img="assets/images/avatar2.png"
                                                                                                id="img-avatar2"
                                                                                                alt="Avtar2"
                                                                                                width="150px"
                                                                                                height="150px"><br>
                                                                                            <button type="button"
                                                                                                class="btn btn-primary"
                                                                                                style="padding: 9px 45p"
                                                                                                id="avatar2">Select</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer p-3">
                                                                                    <button type="button"
                                                                                        class="btn btn-danger light"
                                                                                        data-dismiss="modal">Cancel</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="button"
                                                        id="save-form">Save</button>
                                                    <?php } ?>
                                                </form>
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
    <script src="<?php echo base_url() ?>assets/vendor/global/global.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/custom.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/deznav-init.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script>
    $('#basicmodalbtn').click((e) => {
        $('#basicModal').modal('show');
    })
    </script>
    <script>
    function removeImage(studentId) {
        if (confirm("Are you sure you want to Delete this Image ?")) {
            location.href = "<?php echo base_url(); ?>user/deleteimg/" + studentId;
        }
    }
    </script>
    <script>
    const siteUrl = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        countries()
    });

    function countries() {
        var edit_data = <?php echo $getUser[0] ? json_encode($getUser[0]) : 0; ?>;
        fetch("../assets/json/countries.json")
            .then((res) => {
                return res.json();
            })
            .then((data) =>
                data.forEach(function(data) {
                    if (edit_data != 0) {
                        if (edit_data.citizenship_country == data.name) {
                            $("#citizenship_country").append('<option value="' + data.name + '" data-country-id="' +
                                data.id + '" selected>' + data.name + '</option>')
                            states();
                        } else {
                            $("#citizenship_country").append('<option value="' + data.name + '" data-country-id="' +
                                data.id + '">' + data.name + '</option>')
                        }
                        if (edit_data.residence_country == data.name) {
                            $("#residence_country").append('<option value="' + data.name + '" data-country-id="' +
                                data
                                .id + '" selected>' + data.name + '</option>')
                            states();
                        } else {
                            $("#residence_country").append('<option value="' + data.name + '" data-country-id="' +
                                data
                                .id + '">' + data.name + '</option>')
                        }
                    } else {
                        $(".countries_data").append('<option value="' + data.name + '" data-country-id="' + data
                            .id +
                            '">' + data.name + '</option>')
                    }
                })
            )
    }

    function states() {
        $(".states_data").html('');
        var country_selected = $('#residence_country option:selected').attr('data-country-id');
        fetch("../assets/json/states.json")
            .then((res) => {
                return res.json();
            })
            .then((data) =>
                data.forEach(function(data) {
                    if (country_selected == data.countryId) {
                        $(".states_data").append('<option value="' + data.statename + '" data-state-id="' + data
                            .id +
                            '">' + data.statename + '</option>')
                    }
                }))
    }

    function saveUser(saveimg = false) {
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash

        let data = "";
        let formdata = "";
        if (saveimg) {
            console.log($('#' + saveimg).attr('data-img'))
            formdata = new FormData();
            formdata.append('avatar', $('#img-' + saveimg).attr('data-img'));
            formdata.append('email', $("input[name=email]").val());
            formdata.append(csrfName, csrfHash);
        } else {
            formdata = new FormData($('#profile_form')[0]);
        }
        $.ajax({
            url: siteUrl + "user/saveprofile",
            type: "POST",
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formdata,
            success: function(data) {
                $('.csrfToken').val(data.token);
                location.href = siteUrl + "user/home";
            }
        })
    }

    $('#avatar1').click(function() {
        saveUser('avatar1');
    });
    $('#avatar2').click(function() {
        saveUser('avatar2');
    });
    $('#save-form').click(function() {
        saveUser();
    });
    </script>