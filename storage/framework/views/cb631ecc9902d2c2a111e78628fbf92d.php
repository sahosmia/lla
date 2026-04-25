<main class="tb-main tb-forum-main tb-addblogcategory" wire:init="loadData">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-4">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('blogs.add_blog')); ?></h4>
                </div>
                <div class="tb-dbholder tb-packege-setting">
                <div class="tb-dbbox">
                    
                    <div class="tk-themeform tk-themeform-blogs">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="tb-themeform-tags">
                                    <div class="form-group">
                                        <label class="tb-label tb-label-star"><?php echo e(__('general.title')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="title" placeholder="<?php echo e(__('blogs.add_title')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($blog)): ?>
                                        <div class="form-group">
                                            <label class="tb-label tb-label-star"><?php echo e(__('blogs.slug')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="slug" placeholder="<?php echo e(__('blogs.add_slug')); ?>">
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="tk-errormsg">
                                                <span><?php echo e($message); ?></span>
                                            </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                </div>
                                <div class="tb-themeform-tags">
                                    <div class="form-group <?php $__errorArgs = ['category_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <div class="form-group fw-forms-group" wire:ignore>
                                            <label class="tb-label tb-label-star"><?php echo e(__('blogs.categories')); ?></label>
                                            <select data-placeholder='Select category' data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-disable_onchange="true" class="categories form-control tk-select2 tk-select2_disable" data-searchable="true" id="category_ids" multiple>
                                                <option value="" disabled ><?php echo e(__('Select category')); ?></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($id); ?>" <?php if( in_array( $id, $selectedCategories) ): ?> selected <?php endif; ?>><?php echo e($category); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                            <div class="categoryList">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($blog->categories)): ?>
                                                <div class="tb-form-tag">
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $blog->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="tb-tag">
                                                            <span><?php echo e($category->name); ?></span>
                                                            <i class="icon-x removeSelectedCategory" data-id="<?php echo e($category->id); ?>"></i>
                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['category_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div x-data="tagInput()" class="form-group">
                                        <label class="tb-label"><?php echo e(__('blogs.tags')); ?></label>
                                        <input type="text" class="form-control" x-model="newTag" @keydown.enter.prevent="addTag" placeholder="<?php echo e(__('blogs.add_tags')); ?>">
                                        <div class="tb-form-tag">
                                            <template x-for="(tag, index) in tags" :key="index">
                                                <span class="tb-tag" data-has-alpine-state="true">
                                                    <span x-text="tag"></span>
                                                    <i class="icon-x" @click="removeTag(index)"></i>
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="tk-blog-content">
                                        <h6 class="tb-label tb-label-star"><?php echo e(__('blogs.blog_content')); ?></h6>
                                        <div <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="tk-invalid tk-blog-form" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                            <div class="form-group am-custom-editor" wire:ignore>
                                                <textarea id="blog_desc" class="form-control summernote" ><?php echo e($description); ?></textarea>
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="tk-errormsg">
                                                    <span><?php echo e($message); ?></span>
                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group-wrap">
                                        <div class="form-group-half tb-group-wrap ">
                                            <div class="form-group fw-form-group-image">
                                                <label class="tb-label tb-label-star"><?php echo e(__('blogs.blog_image')); ?></label>
                                                <div class="form-group-half">
                                                    <div class="op-textcontent">
                                                        <ul class="op-upload-img">
                                                            <li class="op-upload-img-info">
                                                                <div class="op-uploads-img-data">
                                                                    <label> <em><i class="icon-plus"></i></em>
                                                                        <input type="file" id="image" wire:model="image" class="form-control">
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li id="image-loader" class="op-upload-img-info img-loader d-none">
                                                            </li>
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($image) && !$errors->has('image')): ?>
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="<?php echo e($image->temporaryUrl()); ?>" alt="<?php echo e($title); ?>" width="100"> 
                                                                        </figure>
                                                                        <div wire:click="removeImage" class="op-overlay-icon op-remove-file">
                                                                            <i class="icon-trash-2"></i>
                                                                        </div>
                                                                        <input type="hidden">
                                                                    </div>
                                                                </li>    
                                                            <?php elseif(!empty($blog->image)): ?>
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="<?php echo e(url(Storage::url($blog->image))); ?>" alt="<?php echo e($title); ?>" width="100"> 
                                                                        </figure>
                                                                        <div wire:click="removeImage" class="op-overlay-icon op-remove-file">
                                                                            <i class="icon-trash-2"></i>
                                                                        </div>
                                                                        <input type="hidden">
                                                                    </div>
                                                                </li>   
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            
                                                        </ul>
                                                        <span><?php echo e(__('blogs.blog_image_validation', ['extensions' => str_replace(',', ', ', $imageFileExt), 'size' => $imageFileSize])); ?>. <?php echo e(__('blogs.blog_image_recommended')); ?></span>            
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="tk-errormsg">
                                                            <span><?php echo e($message); ?></span>
                                                        </div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="form-group fw-form-group-image">
                                                <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                                                <div class="tb-email-status">
                                                    <span><?php echo e(__('blogs.blog_status')); ?></span>
                                                    <div class="tb-switchbtn">
                                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($status == 'published' ? __('blogs.published') : __('blogs.published')); ?></span></label>
                                                        <input wire:change="updateStatus($event.target.checked)" class="tb-checkaction" type="checkbox" id="status" <?php echo e($status == 'published' ? 'checked' : ''); ?>>
                                                    </div>
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="tk-errormsg">
                                                    <span><?php echo e($message); ?></span>
                                                </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-wraps">
                                    <div class="form-group">
                                        <label class="tb-label tb-label-star"><?php echo e(__('blogs.meta_title')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="meta_title" placeholder="<?php echo e(__('blogs.add_meta_title')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <div class="form-group">
                                <div class="tk-blog-content">
                                    <h6 class="tb-label tb-label-star"><?php echo e(__('blogs.meta_description')); ?></h6>
                                        <div class="form-group <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="tk-invalid tk-blog-form" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:ignore>
                                            <textarea wire:model="meta_description" class="form-control" placeholder="<?php echo e(__('blogs.add_meta_description')); ?>"><?php echo e($meta_description); ?></textarea>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="tk-errormsg">
                                                <span><?php echo e($message); ?></span>
                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group tb-dbtnarea">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($blog)): ?>  
                                        <button wire:click.prevent="update" class="tb-btn">
                                            <?php echo e(__('blogs.update_blog')); ?>

                                        </button>
                                    <?php else: ?>
                                        <button wire:click="store" class="tb-btn">
                                            <?php echo e(__('blogs.add_blog')); ?>

                                        </button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
    </div>
    </div>
</main>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')([
'public/summernote/summernote-lite.min.css',
]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>

<script type="text/javascript" data-navigate-once>
        document.addEventListener('livewire:navigated', function() {
            component = window.Livewire.find('<?php echo e($_instance->getId()); ?>');

            document.addEventListener('loadPageJs', (event) => {
                jQuery('#blog_desc').summernote(summernoteConfigs('#blog_desc','.characters-count'));
            
                setTimeout(function() {
                    jQuery('.categories').removeClass('tk-select2_disable');
                }, 500);
            });

            jQuery('#blog_desc').on('summernote.paste', function(we, e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                document.execCommand('insertText', false, bufferText);
            });

            jQuery('#blog_desc').on('summernote.change', function(we, contents, $editable) {
                component.set("description", contents, false);
            });

            $(document).on("change", ".categories", function(e){
                var previousCategories = component.get('selectedCategories');
                var newCategories = $(this).select2("val");
                var updatedCategories = previousCategories.concat(newCategories.filter(item => !previousCategories.includes(item)));
                component.set('selectedCategories', updatedCategories);
                populateCategoryList();
            });

            function populateCategoryList(){
                let categories = $('.categories').select2('data');
                var category_html = '<div class="tb-form-tag">';
                jQuery.each(categories,function(index,elem){
                    category_html += `<span class="tb-tag">
                                        <span>${elem.text}</span>
                                        <i class="icon-x removeSelectedCategory" data-id="${elem.id}"></i>
                                    </span>`;
                });
                category_html += '</div>';
                jQuery('.categoryList').html(category_html);
            }

            jQuery(document).delegate( ".removeSelectedCategory", "click", function() {
                let id = jQuery(this).attr('data-id');
                var newArray = [];
                jQuery.grep($('.categories').select2('data'), function (value) {
                    if(value['id'] !== id)
                        newArray.push(value['id']);
                });
                jQuery('.categories').val(newArray).trigger('change');
                component.set('category_ids', newArray);
                populateCategoryList();
            });

            jQuery(document).on('change', '#category_ids', function(e) {
                var selectedCategoryIds = $(this).val();
                setTimeout(function() {
                    jQuery('.categories').removeClass('tk-select2_disable');
                }, 500);
                component.set('category_ids', selectedCategoryIds);
            });

            document.addEventListener('livewire:initialized', function() {
            
                jQuery('#status').on('change', function(e) {
                    var status = $(this).val();
                });
            });
    });

    $(document).ready(function() {
        const imageInput = $('#image');
        const loader = $('#image-loader');

        imageInput.on('change', function() {
            if (this.files.length > 0) {
                loader.removeClass('d-none');
                jQuery('.uploaded-img').addClass('d-none');
            }
        });
    })
    
    function tagInput() {
        return {
            newTag: '',
            tags: <?php echo json_encode($tags ?? [], 15, 512) ?>,
            errorMessage: '', // Add a property to store error messages
            addTag() {
                if (this.newTag.trim() !== '') {
                    if (!this.tags.includes(this.newTag)) {
                        this.tags.push(this.newTag.trim());
                        component.set('tags', this.tags);
                        this.newTag = '';
                        this.errorMessage = '';
                    } else {
                        component.dispatch('showAlertMessage', { type: 'error', message: <?php echo json_encode(__('blogs.tag_already_added'), 15, 512) ?> });
                    }
                }
            },
            removeTag(index) {
                this.tags.splice(index, 1);
                component.set('tags', this.tags);
            },
            checkDuplicateTags() {
                let uniqueTags = [...new Set(this.tags)];
                if (uniqueTags.length !== this.tags.length) {
                    this.tags = uniqueTags;
                    component.set('tags', this.tags);
                }
            }
        }
    }

        
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/create-blog.blade.php ENDPATH**/ ?>