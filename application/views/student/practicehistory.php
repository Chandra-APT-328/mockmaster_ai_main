<style>
.record-card {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    color: rgba(0, 0, 0, .65);
    font-size: 14px;
    font-variant: tabular-nums;
    line-height: 1.5;
    list-style: none;
    font-feature-settings: "tnum";
    position: relative;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 2px;
    transition: all .3s;
}

.record-card-head {
    min-height: 48px;
    margin-bottom: -1px;
    padding: 0 24px;
    color: rgba(0, 0, 0, .85);
    font-weight: 500;
    font-size: 16px;
    border-bottom: 1px solid #e8e8e8;
}

.record-card-head-wrapper {
    display: flex;
    align-items: center;
}

.record-card-head-title {
    display: inline-block;
    flex: 1;
    padding: 16px 0;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.list-items {
    margin: 0;
    padding: 10px 0px;
    list-style: none;
}

.list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 24px;
    cursor: pointer;
}

.list-item:hover {
    background-color: #f9f9f9;
}

li {
    font-size: 16px;
    color: #333;
}

.list-item-title {
    margin-bottom: 4px;
    color: rgba(0, 0, 0, .65);
    font-size: 18px;
    line-height: 22px;
}

.icon-right {
    display: inline-block;
    color: inherit;
    font-style: normal;
    line-height: 0;
    text-align: center;
    text-transform: none;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    margin-left: 4px;
    transform: scale(0.8);
}


.form-control {
    color: #000000;
    background: #FFFFFF;
    border: 1px solid #EBEBEB;
    border-radius: 3px;
}

.toast-close {
    color: #000 !important;
}

.detail-title {
    font-size: 20px;
    margin-bottom: 4px;
    font-weight: bold;
}

.seperator:after {
    content: '';
    width: 1px;
    height: 32px;
    background-color: #ccc;
    position: absolute;
    top: calc(50% - 12px);
    margin-left: 69px;
}

.divider-horizontal {
    height: 1px;
    background: #e8e8e8;
}

.table-header {
    background-color: #fafafa;
    color: #999;
    height: 40px;
    line-height: 40px;
    font-weight: 400;
    padding: 0 20px
}


#pagination-container {
    margin: 0 0 20px;
    padding: 0;
    list-style: none;
    text-align: center;
}

#pagination-container a,
#pagination-container span,
#pagination-container .ellipse {
    display: inline-block;
    margin-right: 5px;
}

#pagination-container a,
#pagination-container span,
#pagination-container .ellipse {
    color: #666;
    padding: 5px 10px;
    text-decoration: none;
    border: 1px solid #EEE;
    border-radius: 4px !important;
    padding: 0.65rem 0.8rem;
    font-size: 14px;
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px #EEE;
}

#pagination-container .current {
    color: #FFF;
    background-color: #6777efad;
    border-color: #6777ef;
}

#pagination-container .prev.current,
#pagination-container .next.current {
    background: #6777ef;
    font-size: 14px;
}

a.showMore {
    display: block;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    margin-top: 20px;
    color: #0077C8;
    text-decoration: none;

    &::after {
        content: '+ VIEW MORE';
    }

    &.showLess::after {
        content: '- VIEW LESS';
    }
}
.row{
    margin-bottom: 18px;
}

@media only screen and (max-width: 600px) {
    .record-card-head, .list-item{
        padding: 0 10px;
    }

    .list-item-title {
    font-size: 16px;
    line-height: 20px;
}
}
</style>



<!-- row -->
<div id="records">

    <?php if(count($records) > 0 && strlen($search_qcode) == 0){ ?>

    <div class="section-header">
        <div class="row ">
            <h3 class="fs-20 text-black mb-2 ml-4">History Record </h3>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body px-15">
                        <?php foreach($records as $row => $rowrecord){ ?>

                        <div class="row" id="record">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="record-card">
                                        <div class="record-card-head">
                                            <div class="record-card-head-wrapper">
                                                <div class="record-card-head-title">
                                                    <div style="display: flex;justify-content: space-between;">
                                                        <div><?php echo $row; ?></div>
                                                        <div>Total Practiced:
                                                            <?php echo count($records) > 0 ? array_sum(array_map("count", $rowrecord)) : 0; ?>
                                                            Qs</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <?php 
                                foreach($rowrecord as $key => $record){
                            ?>
                                            <ul class="list-items ">
                                                <a
                                                    href="<?php echo base_url().'user/practicehistory/'.$row.'/'.$record[0]->question_type; ?>">
                                                    <li class="list-item">
                                                        <h4 class="list-item-title">
                                                            <?php echo $categories[$record[0]->question_type]; ?></h4>
                                                        <span>
                                                            Practiced <?php echo count($record); ?> Qs
                                                            <i aria-label="icon: right" class="icon-right">
                                                                <svg viewBox="64 64 896 896" class="" data-icon="right"
                                                                    width="1em" height="1em" fill="currentColor"
                                                                    aria-hidden="true" focusable="false">
                                                                    <path
                                                                        d="M765.7 486.8L314.9 134.7A7.97 7.97 0 0 0 302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 0 0 0-50.4z">
                                                                    </path>
                                                                </svg>
                                                            </i>
                                                        </span>
                                                    </li>
                                                </a>
                                            </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }}elseif(strlen($search_qcode) > 0){ ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card p-5" style="border-radius: 8px;">
                                    <div class="" style="padding: 20px 0px;">

                                        <div class="col-xl-9">
                                            <div class="detail-title"><?php echo $categories[$search_qcode]; ?></div>
                                            <div style="font-size: 14px;">Date: <?php echo $search_date; ?></div>
                                        </div>

                                        <?php
                                $sortbyQuestionTypes = array();
                                foreach($records[$search_date][$search_qcode] as $key){
                                    $sortbyQuestionTypes[$key->question_id][] = $key;
                                };
                            ?>
                                        <div class="col-xl-3">
                                            <div class="d-flex mt-3" style="text-align: center;">
                                                <div style="padding-left: 38px; padding-right: 38px;">
                                                    <span>Prac. Qs</span>
                                                    <span style="font-size: 32px;"
                                                        class="seperator"><?php echo count($sortbyQuestionTypes); ?></span>
                                                </div>
                                                <div style="padding-left: 38px; padding-right: 38px;">
                                                    <span>Ans. Count</span>
                                                    <span
                                                        style="font-size: 32px;"><?php echo array_sum(array_map("count", $sortbyQuestionTypes)); ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="divider-horizontal" role="separator"></div>

                                    <div class="" style="padding: 20px 0px;">
                                        <div class="d-flex p-1 table-header">
                                            <div class="col-xl-10">
                                                <span>Questions</span>
                                            </div>
                                            <div class="col-xl-2">
                                                <span style="float:right;">Ans. Count</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 p-0">
                                            <ul class="list-items">
                                                <?php foreach($sortbyQuestionTypes as $key){ 
                                        $question = $this->Iifl_info->getdata($key[0]->category . '_questions', array('id' => $key[0]->question_id)); 
                                    ?>
                                                <a
                                                    href="<?php echo base_url().'user/'.$key[0]->question_type.'/'.$key[0]->question_id; ?>">
                                                    <li class="list-item">
                                                        <span
                                                            class="list-item-title"><?php echo '#' . $question[0]->id . ' ' . $question[0]->title; ?></span>
                                                        <span><?php echo count($key); ?></span>
                                                    </li>
                                                </a>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php }else{ ?>
                        <div class="row">
                            <h3 class="fs-20 text-black mb-2 ml-4">History Record </h3>
                        </div>

                        <div style="padding:24px 24px; text-align:center;">No record found</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
    <div class="row">
        <div class="col-xl-12" id="pagination-container"></div>
    </div>
        </div>
    </div>

</div>

<script src="<?php echo base_url() ?>assets/vendor/global/global.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/custom.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/deznav-init.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendor/canvas/canvas.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/flot/jquery.flot.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/parsley/parsley.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.4/jquery.simplePagination.min.js"
    integrity="sha512-J4OD+6Nca5l8HwpKlxiZZ5iF79e9sgRGSf0GxLsL1W55HHdg48AEiKCXqvQCNtA1NOMOVrw15DXnVuPpBm2mPg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
const siteUrl = '<?php echo base_url(); ?>';

function toast(message) {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "#fff",
            color: "#000"
        }
    }).showToast();
}

var items = $("#records #record");
var numItems = items.length;
var perPage = 4;

items.slice(perPage).hide();

$('#pagination-container').pagination({
    items: numItems,
    itemsOnPage: perPage,
    prevText: "&laquo;",
    nextText: "&raquo;",
    onPageClick: function(pageNumber) {
        var showFrom = perPage * (pageNumber - 1);
        var showTo = showFrom + perPage;
        items.hide().slice(showFrom, showTo).show();
    }
});

jQuery(document).ready(function() {
    var records = $(this).find('.record-card');
    $(records).each(function() {
        var items = $(this).find('.list-items');
        if (items.length > 4) {
            $(this).append(
                '<div class="list-item" style="display:block;"><a href="javascript:(0);" class="showMore"></a></div>'
                );
        }

        var showmore = $(this).find('.showMore');
        // If more than 2 Education items, hide the remaining
        $(items).slice(0, 3).addClass('shown');
        $(items).not('.shown').hide();
        $(showmore).click(function(e) {
            $(items).not('.shown').toggle(300);
            $(showmore).toggleClass('showLess');
        });
    });

});
</script>