<style>
    .chr:not(:last-child) {
        border-bottom: 1px solid #d3d3d3;
        padding: 1rem 0;
    }
    .studyvideos .card-body {
    padding: 1rem 0;
    }
    .video-thumbnail{
        cursor: pointer;
    }
    .video-container {
    position: relative;
    display: inline-block;
}

.youtube-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 48px; /* Adjust the size as needed */
    color: red; /* Change the color to match your preference */
    pointer-events: none; /* Ensure the icon does not interfere with clicks */
}
    @media only screen and (max-width: 600px) {
      .studymodal .modal-body{
            padding: 5px;
      }
      .studymodal .modal-body .embed-responsive{
        height: 300px;
      }
    }
</style>
<section>
    <div class="panel-section-card py-20 px-5 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h2 class="section-title text-black text-center mb-3 mt-3">
                            <span>MockMaster PTE Video Course</span>
                            <br>
                            <span>(All 20 PTE Tasks explained in detail with example videos)</span>
                        </h2>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body  px-1">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" data-model="EN"
                                                    href="#EN">English</a>
                                            </li>
                                            <?php if ($addon_languages) { ?>
                                                <?php if (in_array('PB', $addon_languages)) { ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" data-model="PB"
                                                            href="#PB">Punjabi</a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active studyvideos" id="EN" role="tabpanel">
                                                <?php foreach ($videos['EN'] as $category => $cat_videos) { ?>
                                                    <h3 class="mt-4 "><?php echo ucwords($category); ?></h3>
                                                    <div class="row chr">
                                                        <?php
                                                        foreach ($cat_videos as $key => $row_videos) {
                                                            $url = $row_videos->path;
                                                            $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
                                                            preg_match($regExp, $row_videos->path, $match);
                                                            $url = ($match && strlen($match[7]) == 11) ? $match[7] : false;
                                                            if ($url) {
                                                                $thumbnail_img = 'https://img.youtube.com/vi/' . $url . '/hqdefault.jpg';
                                                                ?>
                                                                <div class="col-lg-4 col-sm-4" id="video">
                                                                    <div class="card">
                                                                        <div class="card-body  px-1" style="width: 100%;">
                                                                        <div class="video-container text-center">
                                                                            <img src="<?php echo !empty($row_videos->thumbnail) ? base_url($row_videos->thumbnail) : $thumbnail_img; ?>"  alt="<?php echo $row_videos->label_name; ?>" class="img-thumbnail video-thumbnail" data-video="<?php echo $row_videos->path; ?>">
                                                                            <i class="fab fa-youtube youtube-icon"></i>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php if ($addon_languages) { ?>
                                                <?php if (in_array('PB', $addon_languages)) { ?>
                                                    <div class="tab-pane fade" id="PB" role="tabpanel">
                                                        <?php
                                                        foreach ($videos['PB'] as $category => $cat_videos) {
                                                            ?>
                                                            <h3 class="mt-3"><?php echo ucwords($category); ?></h3>
                                                            <div class="row chr">
                                                                <?php
                                                                foreach ($cat_videos as $key => $row_videos) {
                                                                    $url = $row_videos->path;
                                                                    $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
                                                                    preg_match($regExp, $row_videos->path, $match);
                                                                    $url = ($match && strlen($match[7]) == 11) ? $match[7] : false;
                                                                    if ($url) {
                                                                        $thumbnail_img = 'https://img.youtube.com/vi/' . $url . '/hqdefault.jpg';
                                                                        ?>
                                                                        <div class="col-lg-4 col-sm-4" id="video">
                                                                            <div class="card">
                                                                                <div class="card-body px-1" style="width: 100%;">
                                                                                    <div class="text-center video-container">
                                                                                    <img src="<?php echo !empty($row_videos->thumbnail) ? base_url($row_videos->thumbnail) : $thumbnail_img; ?>"  alt="<?php echo $row_videos->label_name; ?>" class="img-thumbnail video-thumbnail" data-video="<?php echo $row_videos->path; ?>">
                                                                                    <i class="fab fa-youtube youtube-icon"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade studymodal" id="videoModal" tabindex="-1" role="dialog"
                            aria-labelledby="videoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="videoModalLabel">Video</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" id="videoIframe" src=""
                                                allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const thumbnails = document.querySelectorAll('.video-thumbnail');
                                const videoModal = document.getElementById('videoModal');
                                const videoIframe = document.getElementById('videoIframe');

                                thumbnails.forEach(thumbnail => {
                                    thumbnail.addEventListener('click', function () {
                                        const videoUrl = this.dataset.video;
                                        videoIframe.src = videoUrl;
                                        $('#videoModal').modal('show');
                                    });
                                });

                                $('#videoModal').on('hide.bs.modal', function () {
                                    videoIframe.src = '';
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>