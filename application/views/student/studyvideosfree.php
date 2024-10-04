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
.video-thumbnail.locked {
    opacity: 0.5; 
}

.lock-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 2em;
    color: #fff;
    background: rgba(0, 0, 0, 0.7);
    border-radius: 50%;
    padding: 10px;
}

.video-item {
    position: relative;
}

.video-container {
    position: relative;
}

.youtube-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size: 2em;
    color: #ff0000;
}

.youtube-icon {
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 48px; 
    color: red; 
    pointer-events: none; 
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
                                    <div class="card-body px-1">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" data-model="EN"
                                                    href="#EN">English</a>
                                            </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" data-model="PB"
                                                            href="#PB">Punjabi</a>
                                                    </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active studyvideos" id="EN" role="tabpanel">

                                                <?php
                                                $isFirstVideo = true;
                                                $categoryOrder = ['speaking', 'writing', 'reading', 'listening'];
                                                foreach ($categoryOrder as $category) {
                                                    if (!isset($videos['EN'][$category])) {
                                                        continue; 
                                                    }

                                                    $cat_videos = $videos['EN'][$category];
                                                    ?>
                                                    <h3 class="mt-4"><?php echo ucwords($category); ?></h3>
                                                    <div class="row chr">
                                                        <?php
                                                        foreach ($cat_videos as $key => $row_videos) {
                                                            if ($isFirstVideo) {
                                                                $isLocked = false; 
                                                                $isFirstVideo = false; 
                                                            } else {
                                                                $isLocked = true; 
                                                            }

                                                            $url = $row_videos->path;
                                                            $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
                                                            preg_match($regExp, $row_videos->path, $match);
                                                            $url = ($match && strlen($match[7]) == 11) ? $match[7] : false;
                                                            if ($url) {
                                                                $thumbnail_img = 'https://img.youtube.com/vi/' . $url . '/hqdefault.jpg';
                                                                ?>
                                                                <div class="col-lg-4 col-sm-4 video-item <?php echo $isLocked ? 'locked' : ''; ?>" data-video="<?php echo $isLocked ? '' : $url; ?>">
                                                                    <div class="card">
                                                                        <div class="card-body px-1" style="width: 100%;">
                                                                            <div class="video-container text-center">
                                                                                <img src="<?php echo !empty($row_videos->thumbnail) ? base_url($row_videos->thumbnail) : $thumbnail_img; ?>" alt="<?php echo $row_videos->label_name; ?>" class="img-thumbnail video-thumbnail <?php echo $isLocked ? 'locked' : ''; ?>">
                                                                                <?php if ($isLocked) { ?>
                                                                                    <i class="fas fa-lock lock-icon"></i>
                                                                                <?php } else { ?>
                                                                                    <i class="fab fa-youtube youtube-icon"></i>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                   
                                                    <div class="tab-pane fade" id="PB" role="tabpanel">
                                                        <?php
                                                        $isFirstVideo = true;
                                                        $categoryOrder = ['speaking', 'writing', 'reading', 'listening'];
                                                        foreach ($categoryOrder as $category) {
                                                            if (!isset($videos['PB'][$category])) {
                                                                continue; 
                                                            }
                                                            $cat_videos = $videos['PB'][$category];
                                                            ?>
                                                            <h3 class="mt-3"><?php echo ucwords($category); ?></h3>
                                                            <div class="row chr">
                                                                <?php
                                                                foreach ($cat_videos as $key => $row_videos) {
                                                                    if ($isFirstVideo) {
                                                                        $isLocked = false; 
                                                                        $isFirstVideo = false; 
                                                                    } else {
                                                                        $isLocked = true; 
                                                                    }

                                                                    $url = $row_videos->path;
                                                                    $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
                                                                    preg_match($regExp, $row_videos->path, $match);
                                                                    $url = ($match && strlen($match[7]) == 11) ? $match[7] : false;
                                                                    if ($url) {
                                                                        $thumbnail_img = 'https://img.youtube.com/vi/' . $url . '/hqdefault.jpg';
                                                                        ?>
                                                                        <div class="col-lg-4 col-sm-4 video-item <?php echo $isLocked ? 'locked' : ''; ?>" data-video="<?php echo $isLocked ? '' : $url; ?>">
                                                                            <div class="card">
                                                                                <div class="card-body  px-1" style="width: 100%;">
                                                                                    <div class="text-center video-container">
                                                                                        <img src="<?php echo !empty($row_videos->thumbnail) ? base_url($row_videos->thumbnail) : $thumbnail_img; ?>" alt="<?php echo $row_videos->label_name; ?>" class="img-thumbnail video-thumbnail <?php echo $isLocked ? 'locked' : ''; ?>">
                                                                                        <?php if ($isLocked) { ?>
                                                                                            <i class="fas fa-lock lock-icon"></i>
                                                                                        <?php } else { ?>
                                                                                            <i class="fab fa-youtube youtube-icon"></i>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                            
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
                                const videoItems = document.querySelectorAll('.video-item:not(.locked)');
                                const videoModal = document.getElementById('videoModal');
                                const videoIframe = document.getElementById('videoIframe');

                                videoItems.forEach(item => {
                                    item.addEventListener('click', function () {
                                        const videoUrl = this.dataset.video;
                                        if (videoUrl) {
                                            videoIframe.src = `https://www.youtube.com/embed/${videoUrl}`;
                                            $(videoModal).modal('show');
                                        }
                                    });
                                });

                                
                                const lockedVideoItems = document.querySelectorAll('.video-item.locked');
                                lockedVideoItems.forEach(item => {
                                    item.addEventListener('click', function () {
                                window.location.href="<?php echo base_url(); ?>user/package";
                                    });
                                });

                                $(videoModal).on('hide.bs.modal', function () {
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