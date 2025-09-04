<div class="am-reviews_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-reviews_section_wrap">
                        <div class="am-reviews_title">
                            <h3><?php echo e(__('tutor.student_reviews')); ?></h3>
                        </div>
                        <div class="am-reviews_wrap">
                            <div class="am-reviews_sidebar">
                                <div class="am-reviews_sidebar_head">
                                    <strong><?php echo e(number_format($tutorAvgRatings , 1)); ?></strong>
                                    <div class="am-reviews_sidebar_stars">
                                        <span>
                                            <?php
                                            $fullStars = floor($tutorAvgRatings);
                                            $halfStars = ($tutorAvgRatings - $fullStars >= 0.5) ? 1 : 0;
                                            $emptyStars = 5 - $fullStars - $halfStars;
                                            ?>

                                            <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < $fullStars; $i++): ?>
                                                <i class="am-icon-star-filled"></i>
                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]--><?php if($halfStars): ?>
                                                <i class="am-icon-star-filled am-icon-start-empty"></i>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < $emptyStars; $i++): ?>
                                                <i class="am-icon-star-filled am-icon-start-empty"></i>
                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                        </span>
                                        <em><?php echo e(__('tutor.based_on')); ?> <em><?php echo e($tutorReviewCount); ?></em> <?php echo e($tutorReviewCount == 1 ? __('tutor.rating') : __('tutor.ratings')); ?></em>
                                    </div>
                                </div>
                                <ul class="am-reviews_ratio">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tutorRatingsCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <div class="am-reviews_ratio_title">
                                                <span><?php echo e($rating); ?>.0</span>
                                                <em><?php echo e($count); ?></em>
                                            </div>
                                            <div class="am-progressbar">
                                                <?php
                                                    $progressWidth = ($tutorReviewCount > 0) ? ($count / $tutorReviewCount) * 100 : 0;
                                                ?>
                                                <span style="width: <?php echo e($progressWidth); ?>%;"></span>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </ul>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($allTutorRatings->count() > 0): ?>
                                <div class="am-comments">
                                    <ul class="am-comments_list">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allTutorRatings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <div class="am-comments_user">
                                                    <figure class="am-comments_img">

                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($review?->profile?->image) && Storage::disk(getStorageDisk())->exists($review?->profile?->image)): ?>
                                                        <img src="<?php echo e(resizedImage($review->profile?->image,42,42)); ?>" alt="<?php echo e($review->profile?->image); ?>" />
                                                        <?php else: ?> 
                                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 42, 42)); ?>" alt="<?php echo e($review->profile?->image); ?>" />
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </figure>
                                                    <div class="am-comments_user_name">
                                                        <h4><?php echo e($review?->profile?->short_name); ?>

                                                            <!--[if BLOCK]><![endif]--><?php if($review?->profile?->user?->address?->country?->short_code): ?>
                                                                <span class="flag flag-<?php echo e(strtolower($review->profile->user?->address?->country?->short_code)); ?>"></span>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </h4>
                                                        <span><?php echo e($review?->created_at?->format('M d, Y')); ?></span>
                                                    </div>
                                                </div>
                                                <div class="am-comment">
                                                    <div class="am-comment_rate">
                                                        <div class="am-comment_rate_stars">
                                                            <div class="am-comment_rate_stars">
                                                                <?php
                                                                    $fullStars = floor($review?->rating);
                                                                    $halfStars = ($review?->rating - $fullStars >= 0.5) ? 1 : 0;
                                                                    $emptyStars = 5 - $fullStars - $halfStars;
                                                                ?>

                                                                <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < $fullStars; $i++): ?>
                                                                    <i class="am-icon-star-filled"></i>
                                                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->

                                                                <!--[if BLOCK]><![endif]--><?php if($halfStars): ?>
                                                                    <i class="am-icon-star-filled am-icon-start-empty"></i>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                                <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < $emptyStars; $i++): ?>
                                                                    <i class="am-icon-star-filled am-icon-start-empty"></i>
                                                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </div>
                                                        </div>
                                                        <span><em><?php echo e(number_format($review?->rating, 1)); ?></em>/5.0</span>
                                                    </div>
                                                    <?php
                                                        $comment = strip_tags($review?->comment);
                                                        $shortComment = Str::limit($comment, 180, preserveWords: true);
                                                    ?>
                                                    <div class="am-addmore" x-data="{ showMore: false }">
                                                        <!--[if BLOCK]><![endif]--><?php if(Str::length($comment) > 180): ?>
                                                            <p x-show="!showMore">
                                                                <?php echo e($shortComment); ?>

                                                                    <a href="javascript:void(0);" @click="showMore = true"><?php echo e(__('general.show_more')); ?></a>
                                                            </p>
                                                            <p x-show="showMore" x-cloak>
                                                                <?php echo e($comment); ?>

                                                                <a href="javascript:void(0);" @click="showMore = false"><?php echo e(__('general.show_less')); ?></a>
                                                            </p>
                                                        <?php else: ?>
                                                            <div class="full-description">
                                                                <?php echo $comment; ?>

                                                            </div>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </ul>
                                    <!--[if BLOCK]><![endif]--><?php if($allTutorRatings->total() > 1): ?>
                                        <div class="am-pagination am-pagination_two">
                                            <?php echo e($allTutorRatings->links('pagination.pagination', ['scrollTo' => '.am-reviews_section'])); ?>

                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php else: ?>
                                <div class="am-norecord">
                                    <div class="am-norecord_content">
                                        <figure><img src="<?php echo e(asset('images/no-review.png')); ?>" alt="no record"></figure>
                                        <h5><?php echo e(__('general.no_reviews_yet')); ?></h5>
                                        <span><?php echo e(__('general.no_records')); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/components/students-reviews.blade.php ENDPATH**/ ?>