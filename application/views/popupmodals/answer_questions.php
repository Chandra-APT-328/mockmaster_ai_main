<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="resultModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Score</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Component</th>
                                <th>Score</th>
                                <?php if($suggestion){ ?>
                                    <th>Suggestion</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Content 
                                    <!-- <i aria-label="icon: info-circle" tabindex="-1" class="anticon anticon-info-circle AIScoreCom__InfoIcon-sc-1yzm0aw-0 gXpbBC info" onclick="toogleTips('content');"><svg viewBox="64 64 896 896" class="" data-icon="info-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z"></path><path d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z"></path></svg></i> -->
                                </td>
                                <td><span class="content"><?php echo $component_score->content; ?></span><?php echo '/'.$max_score; ?></td>
                                <?php if($suggestion){ ?>
                                    <td><span class="suggestion"><?php echo $suggestion; ?></span></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td colspan="3">Max Score：<?php echo $max_score; ?>,  Your Score：<span class="myScore"><?php echo $score; ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p class="text-gray font-14">
                                        Note: Your scores have been computed using different parameters like your content accuracy, oral fluency, pronunciation and stress on words. These scores can be used for skill improvement, but they are not directly related to the PTE-Academic scores. The scores may differ with the usage of a proper headset with a mic compared to directly recording yourself on a laptop without using a headset.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php if($answer_transcript){ ?>
                    <div class="p-2" style="color:black;">
                        <span>Your answer: </span><span class="answer-transcript"><?php echo $answer_transcript; ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>