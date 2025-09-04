<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css" />
    <section class="am-blogdetail">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-blogdetail_content">
                        <figure class="am-blogdetail_banner am-blogdetail-img">
                            <img src="<?php echo e(url(Storage::url($blog->image))); ?>" alt="<?php echo e($blog->title); ?>" />
                        </figure>
                        <div class="am-titlebox">
                            <!--[if BLOCK]><![endif]--><?php if(!empty($blog->categories)): ?>
                            <ul>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $blog->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('blogs', ['category' => $category->slug])); ?>"><?php echo e($category->name); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </ul>  
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <h2><?php echo e($blog->title); ?></h2>
                            <div class="am-calender">
                                <span><i class="am-icon-calender"></i><?php echo e($blog->updated_at->format('M d, Y')); ?></span>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($blog->views_count)): ?>
                                
                                    <span><i class="am-icon-eye-open-01"></i><?php echo e(number_format($blog->views_count)); ?> <?php echo e($blog->views_count == 1 ?  __('blogs.view') : __('blogs.views')); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <div class="am-blogdetail_description am-description-content">
                            <?php echo $blog->description; ?>

                        </div>
                       <!--[if BLOCK]><![endif]--><?php if(!empty($blog->tags)): ?>
                        <div class="am-meta-tags">
                            <h4><?php echo e(__('blogs.tags')); ?>:</h4>
                            <ul>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <span><?php echo e($tag->name); ?></span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </ul>
                        </div>

                       <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                       <!--[if BLOCK]><![endif]--><?php if(!empty($blog->author?->profile)): ?>
                            <div class="am-author">
                                <div class="am-title-box">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($blog->author->profile->image)): ?>
                                    <figure>
                                        <img src="<?php echo e(url(Storage::url($blog->author->profile->image))); ?>" alt="<?php echo e($blog->author?->profile?->full_name); ?>" />
                                    </figure>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($blog->author?->profile?->short_name)): ?>
                                    <div class="am-title">
                                        <span><?php echo e(__('blogs.author')); ?></span>
                                            <h4><?php echo e($blog->author?->profile->short_name); ?></h4>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($relatedBlogs) && $relatedBlogs->isNotEmpty()): ?>
                        <div class="am-articles-area">
                            <h2><?php echo e(__('blogs.explore_related_articles')); ?></h2>
                            <div class="row gy-4">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $relatedBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedBlog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                                        <div class="am-article">
                                            <figure class="am-article-img">
                                                <img src="<?php echo e(url(Storage::url($relatedBlog->image))); ?>" alt="<?php echo e($blog->title); ?>">
                                            </figure>
                                            <div class="am-article-content">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($relatedBlog->categories)): ?>
                                                    <div class="am-categorie-name">
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $relatedBlog->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a href="<?php echo e(route('blogs', ['category' => $category->slug])); ?>"><span><?php echo e($category->name); ?><?php echo e(!$loop->last ? ',' : ''); ?></span></a>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($relatedBlog->title)): ?>
                                                    <a href="<?php echo e(route('blog-details', $relatedBlog->slug)); ?>"><h3><?php echo e($relatedBlog->title); ?></h3></a>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($relatedBlog->description)): ?>
                                                    <p><?php echo e(Str::limit(strip_tags($relatedBlog->description), 100)); ?></p>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <div class="am-userand-date">
                                                    <div class="am-user-box">
                                                        <figure>
                                                            <img src="<?php echo e(url(Storage::url($relatedBlog->author?->profile?->image))); ?>" alt="<?php echo e($relatedBlog->author?->profile?->full_name); ?>">
                                                        </figure>
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($relatedBlog->author?->profile?->short_name)): ?>
                                                        <h4><?php echo e($relatedBlog->author?->profile->short_name); ?></h4>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <em><?php echo e($relatedBlog->updated_at->format('M d, Y')); ?></em>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </section>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/blog-details.blade.php ENDPATH**/ ?>