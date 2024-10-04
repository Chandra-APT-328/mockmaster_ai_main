<style>
.package_tab_section {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
}

.package_tab {
    background-color: #e0e8ff;
    border-radius: 10px;
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

.package_header {
    padding: 30px 20px;
    height: 160px;
    text-align: center;
    border-bottom: 3px solid #fff;
}

.package_tab.active {
    background: linear-gradient(12deg, rgba(255, 78, 184, 1) 10.970295%, rgba(78, 149, 255, 1) 154.591286%, rgba(98, 95, 235, 1) 80.04699%);
    color: #fff;
}

.package_tab h3 {
    margin: 0;
    font-size: 18px;
    font-weight: bold;
}

.package_tab.active h3 {
    color: #fff;
}

.package_tab ul {
    padding: 20px;
    list-style: none;
    margin: 15px 0 0 0;
    text-align: left;
}

.package_tab ul li {
    margin-bottom: 10px;
    font-size: 16px;
    color: #000;
    font-weight: 600;
}

.package_tab.active ul li {
    color: #fff;
}

.package_tab ul li span.vip-icon {
    background-color: #333;
    color: white;
    font-weight: bold;
    padding: 2px 8px;
    border: 2px solid #fff;
    border-radius: 5px;
    margin-left: 5px;
    font-size: 12px;
}

.best-seller {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: #8280FD;
    color: #fff;
    border: 2px solid #fff;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: bold;
}

.purchase_button {
    padding: 7px 40px;
    color: #fff;
    font-size: 20px;
    text-decoration: none;
    font-weight: 700;
    letter-spacing: 1px;
    border: 3px solid #fff;
    display: inline-block;
    vertical-align: top;
    width: auto;
    position: relative;
    top: 40px;
    border-radius: 12px;
    text-transform: uppercase;
}

.badge {
    position: absolute;
    top: 0px;
    right: 27px;
    padding: 5px 10px;
    font-size: 12px;
    border: 3px solid #fff;
    border-top: 0;
    font-weight: bold;
    border-radius: 5px;
}

.best-seller-badge {
    background: linear-gradient(12deg, rgba(255, 78, 184, 1) 10.970295%, rgba(78, 149, 255, 1) 154.591286%, rgba(98, 95, 235, 1) 80.04699%);
    color: #fff;
}

.savings-badge {
    background: linear-gradient(12deg, rgba(255, 78, 184, 1) 10.970295%, rgba(78, 149, 255, 1) 154.591286%, rgba(98, 95, 235, 1) 80.04699%);
    color: #fff;
}

@media only screen and (max-width: 600px) {
    .package_tab_section {
        flex-wrap: wrap;
    }

    .package_header {
        height: 190px;
    }



}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3"></script>

<section>
    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"
        value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="mb-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h2 class="section-title mb-3">
                            <?php echo $active_bar == "subscriptions" ? "My Subcriptions" : "Buy Now!"; ?></h2>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" data-model="EN" href="#EN">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" data-model="PB" href="#PB">Punjabi</a>
                            </li>
                        </ul>
                        <div class="position-relative subscribes-container pe-none user-select-none">
                            <div class="tab-content">
                                <section class="container px-0 tab-pane fade show active" id="EN" role="tabpanel">
                                    <div class="position-relative mt-30">


                                        <div class="container px-0">
                                            <div class="package_tab_section">
                                                <!-- Silver Tab -->
                                                <div id="practice-pro-tab" class="package_tab active"
                                                    data-usage-type="practice pro">
                                                    <div class="package_header">
                                                        <i class="fas fa-chalkboard-teacher font-30  mb-2"></i>
                                                        <h3>PTE Practice Pro: Interactive AI PTE Portal </h3>
                                                        <h3 class="my-2">(practice portal)</h3>

                                                    </div>
                                                    <ul>
                                                        <li>✔ Unlimited Speaking Scorings</li>
                                                        <li>✔ Unlimited Writing Scorings</li>
                                                        <li>✔ Unlimited AI Scoring</li>
                                                        <?php if($rowData->attempt_limit == 0){ ?>
                                                        <li class="">✔ Unlimited Mock Test Attempts</li>
                                                        <?php } ?>
                                                        <li>✘</li>
                                                    </ul>
                                                </div>
                                                <!-- Gold Tab -->
                                                <div id="sucess-bundle-tab" class="package_tab sucess-bundle-core-punjabi"
                                                    data-usage-type="success bundle">
                                                    <div class="package_header">
                                                        <i class="fas fa-laptop-code font-30 mb-2"></i>
                                                        <h3>PTE Success Bundle: <br> Comprehensive AI Portal & Video
                                                            Course </h3>
                                                        <h3 class="my-2">(practice portal + video course combo)</h3>

                                                    </div>
                                                    <ul>
                                                        <li>✔ Unlimited Speaking Scorings</li>
                                                        <li>✔ Unlimited Writing Scorings</li>
                                                        <li>✔ Unlimited AI Scoring</li>
                                                        <?php if($rowData->attempt_limit == 0){ ?>
                                                        <li class="">✔ Unlimited Mock Test Attempts</li>
                                                        <?php } ?>
                                                        <li>✔ Full Video Course <span class="vip-icon">PREMIUM</span>
                                                        </li>
                                                    </ul>
                                                    <span class="best-seller">BEST SELLER</span>
                                                </div>
                                            </div>

                                            <div id="pricing-options" class="row">
                                                <?php 
                                                        $colors = ["#8280FD", "#09D1DE", "#C491FF"];
                                                        $counter = 0;
                                                        $color_count = count($colors);

                                                        $enlistpackage = array_filter($listpackage, function ($v){
                                                            if(strlen($v->addon_language) == 0){
                                                                    return $v;
                                                            } 
                                                        });

                                                        foreach ($enlistpackage as $data => $rowData) {
                                                            $bgColor = $colors[$counter % $color_count];
                                                            $counter++;
                                                    ?>
                                                <div class="col-sm-4 mb-20 package"
                                                    data-usage-type="<?php echo $rowData->usage_type; ?>"
                                                    counter="<?php echo $counter; ?>">
                                                    <div class="price-box mb-30">
                                                        <div class="price-header radius-7 p-15"
                                                            style="background-color: <?php echo $bgColor; ?>;">
                                                            <div class="p-10">
                                                                <h3 class="text-white ">
                                                                    <?php echo ($rowData->duration.' '.$rowData->duration_type); ?>
                                                                </h3>
                                                                <hr>

                                                                <?php if ($rowData->duration == 3 || $rowData->duration == 6) { ?>
                                                                <p class="font-24 font-weight-500 text-white"><span
                                                                        class="text-decoration-line-through text-white">$<?php echo (($rowData->cost) * 2); ?></span>
                                                                    <span class="text-white">50% OFF</span></p>
                                                                <?php } else{ ?>
                                                                <p class="font-24 font-weight-500 text-white">-</p>
                                                                <?php } ?>
                                                                <h2 class="py-2 text-white">
                                                                    $<?php echo $rowData->cost; ?> <span
                                                                        class="font-20 font-weight-light text-white">
                                                                        (
                                                                        <?php echo ($rowData->duration.' '.$rowData->duration_type); ?>)</span>
                                                                </h2>

                                                                <h4 class="text-white" style="line-height: 1.3;"><?php echo ucwords(strtolower($rowData->description)); ?></h4>
                                                                <!-- <h4 class="text-white"><?php echo ucwords(strtolower($rowData->description)); ?></h4> -->

                                                                <!-- Adding the Badge -->
                                                                <?php if ($rowData->duration == 3) { ?>
                                                                <div class="badge best-seller-badge">Most Popular</div>
                                                                <?php } elseif ($rowData->duration == 6) { ?>
                                                                <div class="badge savings-badge">Maximum Savings</div>
                                                                <?php } ?>

                                                                <div class="text-center">
                                                                    <?php if (!($user_packages[$rowData->packageid] && $user_packages[$rowData->packageid] >= date('Y-m-d h:i:s'))) { ?>
                                                                    <button
                                                                        class="btn btn-primary btn-buy btn-block purchase_button"
                                                                        style="background-color: <?php echo $bgColor; ?>;"
                                                                        onclick="checkout(<?php echo $rowData->packageid; ?>,this);">Buy
                                                                        Now</button>
                                                                    <?php } else { 
                                            $expire_on = new DateTime($user_packages[$rowData->packageid]);
                                        ?>
                                                                    <button
                                                                        class="btn btn-primary btn-buy btn-block purchase_button"
                                                                        style="cursor:not-allowed; background-color: <?php echo $bgColor; ?>;"
                                                                        disabled>Expires on:
                                                                        <?php echo $expire_on->format("M d, Y"); ?></button>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>


                                        </div>
                                </section>
                                <section class="container tab-pane fade" id="PB" role="tabpanel">
                                    <div class="position-relative mt-30">
                                    <div class="container">
                                            <div class="package_tab_section">
                                                <!-- Silver Tab -->
                                                <div id="practice-pro-Punabi-tab" class="package_tab active"
                                                    data-usage-type="practice pro">
                                                    <div class="package_header">
                                                        <i class="fas fa-chalkboard-teacher font-30  mb-2"></i>
                                                        <h3>PTE Practice Pro: Interactive AI PTE Portal </h3>
                                                        <h3 class="my-2">(practice portal)</h3>

                                                    </div>
                                                    <ul>
                                                        <li>✔ Unlimited Speaking Scorings</li>
                                                        <li>✔ Unlimited Writing Scorings</li>
                                                        <li>✔ Unlimited AI Scoring</li>
                                                        <?php if($rowData->attempt_limit == 0){ ?>
                                                        <li class="">✔ Unlimited Mock Test Attempts</li>
                                                        <?php } ?>
                                                        <li>✘</li>
                                                    </ul>
                                                </div>
                                                <!-- Gold Tab -->
                                                <div id="sucess-bundle-punjabi-tab" class="package_tab sucess-bundle-core"
                                                    data-usage-type="success bundle">
                                                    <div class="package_header">
                                                        <i class="fas fa-laptop-code font-30 mb-2"></i>
                                                        <h3>PTE Success Bundle: <br> Comprehensive AI Portal & Video
                                                            Course </h3>
                                                        <h3 class="my-2">(practice portal + video course combo)</h3>

                                                    </div>
                                                    <ul>
                                                        <li>✔ Unlimited Speaking Scorings</li>
                                                        <li>✔ Unlimited Writing Scorings</li>
                                                        <li>✔ Unlimited AI Scoring</li>
                                                        <?php if($rowData->attempt_limit == 0){ ?>
                                                        <li class="">✔ Unlimited Mock Test Attempts</li>
                                                        <?php } ?>
                                                        <li>✔ Full Video Course <span class="vip-icon">PREMIUM</span>
                                                        </li>
                                                    </ul>
                                                    <span class="best-seller">BEST SELLER</span>
                                                </div>
                                            </div>

                                            <div id="pricing-options" class="row">
                                                <?php 
                                                        $colors = ["#8280FD", "#09D1DE", "#C491FF"];
                                                        $counter = 0;
                                                        $color_count = count($colors);

                                                        $pnblistpackage = array_filter($listpackage, function ($v){
                                                            if(strlen($v->addon_language) != 0){ $addon_languages = explode(',', $v->addon_language);
                                                                if(in_array('PB',$addon_languages)){
                                                                    return $v;
                                                                }
                                                            } 
                                                        });

                                                        foreach ($pnblistpackage as $data => $rowData) {
                                                            $bgColor = $colors[$counter % $color_count];
                                                            $counter++;
                                                    ?>
                                                <div class="col-sm-4 mb-20 package"
                                                    data-usage-type="<?php echo $rowData->usage_type; ?>"
                                                    counter="<?php echo $counter; ?>">
                                                    <div class="price-box mb-30">
                                                        <div class="price-header radius-7 p-15"
                                                            style="background-color: <?php echo $bgColor; ?>;">
                                                            <div class="p-10">
                                                                <h3 class="text-white ">
                                                                    <?php echo ($rowData->duration.' '.$rowData->duration_type); ?>
                                                                </h3>
                                                                <hr>

                                                                <?php if ($rowData->duration == 3 || $rowData->duration == 6) { ?>
                                                                <p class="font-24 font-weight-500 text-white"><span
                                                                        class="text-decoration-line-through text-white">$<?php echo (($rowData->cost) * 2); ?></span>
                                                                    <span class="text-white">50% OFF</span></p>
                                                                <?php } else{ ?>
                                                                <p class="font-24 font-weight-500 text-white">-</p>
                                                                <?php } ?>
                                                                <h2 class="py-2 text-white">
                                                                    $<?php echo $rowData->cost; ?> <span
                                                                        class="font-20 font-weight-light text-white">
                                                                        (
                                                                        <?php echo ($rowData->duration.' '.$rowData->duration_type); ?>)</span>
                                                                </h2>

                                                                <h4 class="text-white" style="line-height: 1.3;"><?php echo ucwords(strtolower($rowData->description)); ?></h4>
                                                                <!-- <h4 class="text-white"><?php echo ucwords(strtolower($rowData->description)); ?></h4> -->

                                                                <!-- Adding the Badge -->
                                                                <?php if ($rowData->duration == 3) { ?>
                                                                <div class="badge best-seller-badge">Most Popular</div>
                                                                <?php } elseif ($rowData->duration == 6) { ?>
                                                                <div class="badge savings-badge">Maximum Savings</div>
                                                                <?php } ?>

                                                                <div class="text-center">
                                                                    <?php if (!($user_packages[$rowData->packageid] && $user_packages[$rowData->packageid] >= date('Y-m-d h:i:s'))) { ?>
                                                                    <button
                                                                        class="btn btn-primary btn-buy btn-block purchase_button"
                                                                        style="background-color: <?php echo $bgColor; ?>;"
                                                                        onclick="checkout(<?php echo $rowData->packageid; ?>,this);">Buy
                                                                        Now</button>
                                                                    <?php } else { 
                                            $expire_on = new DateTime($user_packages[$rowData->packageid]);
                                        ?>
                                                                    <button
                                                                        class="btn btn-primary btn-buy btn-block purchase_button"
                                                                        style="cursor:not-allowed; background-color: <?php echo $bgColor; ?>;"
                                                                        disabled>Expires on:
                                                                        <?php echo $expire_on->format("M d, Y"); ?></button>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>



                                    </div>
                                </section>
                            </div>
                        </div>
                        <!-- pricing end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const primaryTabs = document.querySelectorAll('.nav-link');
    const secondaryTabs = document.querySelectorAll('.package_tab');
    const packages = document.querySelectorAll('.package');

    // Function to show/hide packages based on the selected usage type
    function updatePackages(selectedUsageType) {
        packages.forEach(pkg => {
            if (pkg.getAttribute('data-usage-type') === selectedUsageType) {
                pkg.style.display = 'block';
            } else {
                pkg.style.display = 'none';
            }
        });
    }

    // Function to activate the secondary tab
    function activateSecondaryTab(tabId) {
        const tabToActivate = document.querySelector(`#${tabId}`);
        if (tabToActivate) {
            tabToActivate.click(); // Simulate a click to activate the tab
        }
    }

    // Function to handle primary tab clicks
    function handlePrimaryTabClick() {
        primaryTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                primaryTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const targetId = this.getAttribute('href').substring(1);
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });
                document.getElementById(targetId).classList.add('show', 'active');

                // Activate the default or previously active secondary tab
                const activePackageTab = document.querySelector(`#${targetId} .package_tab.active`);
                if (activePackageTab) {
                    activateSecondaryTab(activePackageTab.id);
                } else {
                    // Default to the first secondary tab if no tab is active
                    const defaultTab = document.querySelector(`#${targetId} .package_tab`);
                    if (defaultTab) {
                        activateSecondaryTab(defaultTab.id);
                    }
                }
            });
        });
    }

    // Function to handle secondary tab clicks
    function handleSecondaryTabClick() {
        secondaryTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                secondaryTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const selectedUsageType = this.getAttribute('data-usage-type');
                updatePackages(selectedUsageType);
            });
        });
    }

    // Initialize tab handlers
    handlePrimaryTabClick();
    handleSecondaryTabClick();

    // Activate the correct secondary tab based on the active primary tab on page load
    const activePrimaryTab = document.querySelector('.nav-link.active');
    if (activePrimaryTab) {
        const targetId = activePrimaryTab.getAttribute('href').substring(1);
        const activePackageTab = document.querySelector(`#${targetId} .package_tab.active`);
        if (activePackageTab) {
            activateSecondaryTab(activePackageTab.id);
        } else {
            // Default to the first secondary tab if none are active
            const defaultTab = document.querySelector(`#${targetId} .package_tab`);
            if (defaultTab) {
                activateSecondaryTab(defaultTab.id);
            }
        }
    }

    const corepart = document.querySelector('.core');
    const bundlecore = document.querySelector('.sucess-bundle-core');
    const bundlecorepunjabi = document.querySelector('.sucess-bundle-core-punjabi');
    if(corepart){
        bundlecore.style.display = 'none';
        bundlecorepunjabi.style.display = 'none';
    }
    
});
</script>


<!-- <script src="<?php echo base_url('assets/newlayout/assets/default/vendors/parallax/parallax.min.js'); ?>"></script> -->
<!-- <script src="<?php echo base_url('assets/newlayout/assets/default/vendors/swiper/swiper-bundle.min.js'); ?>"></script> -->
<!-- <script src="<?php echo base_url('assets/newlayout/assets/default/vendors/owl-carousel2/owl.carousel.min.js'); ?>"></script> -->
<!-- <script src="<?php echo base_url('assets/newlayout/assets/default/js/parts/home.min.js'); ?>"></script> -->
<script>
const siteUrl = '<?php echo base_url(); ?>';

$(document).ready(function() {
    <?php if ($this->session->userdata('success')) { ?>
    setTimeout(Swal.fire("<?php echo $this->session->userdata('success'); ?>", "", "success"), 1000);
    <?php $this->session->unset_userdata('success');
        } ?>
    <?php if ($this->session->userdata('error')) { ?>
    setTimeout(Swal.fire("<?php echo $this->session->userdata('error'); ?>", "", "error"), 1000);
    <?php $this->session->unset_userdata('error');
        } ?>
});

function checkout(packageid, e) {
    e.disabled = true;
    e.style.cursor = "not-allowed";
    var stripe = Stripe('<?php echo STRIPE_API_KEY; ?>');
    var csrfName = $('.csrfToken').attr('name');
    var csrfHash = $('.csrfToken').val();
    var createCheckoutSession = function(stripe) {
        return fetch(siteUrl + "package/purchase/" + packageid, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            }

        }).then(function(result) {
            return result.json();
        });
    };

    createCheckoutSession().then(function(data) {
        stripe.redirectToCheckout({
            sessionId: data.result
        }).then(handleResult);
    });
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var hash = window.location.hash;
    if (hash === "") {
        hash = "#EN";
    }
    var tab = document.querySelector('a[href="' + hash + '"]');
    if (tab) {
        document.querySelectorAll('.nav-link').forEach(function(link) {
            link.classList.remove('active');
        });
        document.querySelectorAll('.tab-pane').forEach(function(pane) {
            pane.classList.remove('show', 'active');
        });

        tab.classList.add('active');
        var targetPane = document.querySelector(hash);
        if (targetPane) {
            targetPane.classList.add('show', 'active');
        }
    } else {
        var firstTab = document.querySelector('.nav-link');
        if (firstTab) {
            firstTab.classList.add('active');
            var firstPane = document.querySelector(firstTab.getAttribute('href'));
            if (firstPane) {
                firstPane.classList.add('show', 'active');
            }
        }
    }
});
</script>