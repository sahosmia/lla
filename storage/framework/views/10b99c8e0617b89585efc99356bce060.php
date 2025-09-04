<div class="pb-advanced">
    <div class="accordion pb-advanceaccordion" id="pb-advanceaccordion">
        <div class="op-accordion-item">
            <div class="pb-advancedtitle" data-bs-toggle="collapse" data-bs-target="#content-width-accord"
                aria-expanded="false">
                <h2><?php echo e(__('pagebuilder::pagebuilder.content_width')); ?></h2>
                <span><?php echo e(__('pagebuilder::pagebuilder.content_width_description')); ?></span>
            </div>
            <div id="content-width-accord" class="accordion-collapse collapse" data-bs-parent="#pb-advanceaccordion">

                <div class="pb-advancedtitle">
                    <div class="pb-layout-input  pb-select">
                        <select data-minimum-results-for-search="Infinity" id="content_width" name="content_width"
                            class="form-select op-input-field op-selectoption"
                            aria-label="<?php echo e(__('pagebuilder::pagebuilder.select')); ?>">
                            <option value=''><?php echo e(__('pagebuilder::pagebuilder.select')); ?></option>
                            <option value="boxed" <?php echo e(($styles['content_width']??'')=='boxed' ?'selected':''); ?>>
                                <?php echo e(__('pagebuilder::pagebuilder.boxed')); ?></option>
                            <option value="full_width" <?php echo e(($styles['content_width']??'')=='full_width' ?'selected':''); ?>>
                                <?php echo e(__('pagebuilder::pagebuilder.full_width')); ?></option>
                        </select>
                    </div>
                </div>

                <div
                    class="pb-rangslider boxed_slider <?php echo e(empty($styles['content_width']) || $styles['content_width'] == 'full_width' ? 'd-none':''); ?>">
                    <div class="slider-styled" id="boxed_slider"></div>
                    <div class="pb-layout-input">
                        <input type="number" value="<?php echo e(($styles['boxed_slider_input']??'')); ?>" class="form-control"
                            name="boxed_slider_input" id="boxed_slider_input" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="op-accordion-item">
            <div class="pb-advancedtitle" data-bs-toggle="collapse" data-bs-target="#widths-accord"
                aria-expanded="false">
                <h2><?php echo e(__('pagebuilder::pagebuilder.section_width_height')); ?></h2>
                <span><?php echo e(__('pagebuilder::pagebuilder.section_width_height_description')); ?></span>
            </div>
            <div id="widths-accord" class="accordion-collapse collapse" data-bs-parent="#pb-advanceaccordion">

                <div class="pb-radio-wrap pb-layoutinfo pb-background-nav">
                    <div class="pb-radiobtn">
                        <input type="radio" id="wh-px" <?php echo e(($styles['width-height-type'] ?? '' )=='px'
                            ?'checked':(empty($styles['width-height-type'])?'checked':'')); ?> name="width-height-type"
                            value="px">
                        <label for="wh-px"><?php echo e(__('pagebuilder::pagebuilder.px')); ?></label>
                    </div>
                    <div class="pb-radiobtn">
                        <input type="radio" id="wh-em" <?php echo e(($styles['width-height-type'] ?? '' )=='em' ?'checked':''); ?>

                            name="width-height-type" value="em">
                        <label for="wh-em"><?php echo e(__('pagebuilder::pagebuilder.em')); ?></label>
                    </div>
                    <div class="pb-radiobtn">
                        <input type="radio" id="wh-%" <?php echo e(($styles['width-height-type'] ?? '' )=='%' ?'checked':''); ?>

                            name="width-height-type" value="%">
                        <label for="wh-%"><?php echo e(__('pagebuilder::pagebuilder.%')); ?></label>
                    </div>
                    <div class="pb-radiobtn">
                        <input type="radio" id="wh-rem" <?php echo e(($styles['width-height-type'] ?? '' )=='rem' ?'checked':''); ?>

                            name="width-height-type" value="rem">
                        <label for="wh-rem"><?php echo e(__('pagebuilder::pagebuilder.rem')); ?></label>
                    </div>
                </div>

                <ul class="pb-themeform__wrap pb-section-wh">
                    <li class="pb-form-group-wrap">
                        <div class="pb-form-group-half">
                            <input type="number" name="width" value="<?php echo e($styles['width']??''); ?>" class="form-control"
                                placeholder="<?php echo e(__('pagebuilder::pagebuilder.width')); ?>">
                        </div>
                        <div class="pb-form-group-half">
                            <input type="number" name="height" value="<?php echo e($styles['height']??''); ?>" class="form-control"
                                placeholder="<?php echo e(__('pagebuilder::pagebuilder.height')); ?>">
                        </div>
                    </li>
                    <li class="pb-form-group-wrap">
                        <div class="pb-form-group-half">
                            <input type="number" name="min-width" value="<?php echo e($styles['min-width']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.min_width')); ?>">
                        </div>
                        <div class="pb-form-group-half">
                            <input type="number" name="max-width" value="<?php echo e($styles['max-width']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.max_width')); ?>">
                        </div>
                    </li>
                    <li class="pb-form-group-wrap">
                        <div class="pb-form-group-half">
                            <input type="number" name="min-height" value="<?php echo e($styles['min-height']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.min_height')); ?>">
                        </div>
                        <div class="pb-form-group-half">
                            <input type="number" name="max-height" value="<?php echo e($styles['max-height']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.max_height')); ?>">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="op-accordion-item">
            <div class="pb-advancedtitle" data-bs-toggle="collapse" data-bs-target="#margins-accord"
                aria-expanded="false">
                <h2><?php echo e(__('pagebuilder::pagebuilder.section_margins')); ?></h2>
                <span><?php echo e(__('pagebuilder::pagebuilder.section_margins_description')); ?></span>
            </div>
            <div id="margins-accord" class="accordion-collapse collapse" data-bs-parent="#pb-advanceaccordion">

                <div class="pb-radio-wrap pb-layoutinfo pb-background-nav">
                    <div class="pb-radiobtn">
                        <input type="radio" id="m-px" <?php echo e(($styles['margin-type'] ?? '' )=='px'
                            ?'checked':(empty($styles['margin-type'])?'checked':'')); ?> name="margin-type" value="px">
                        <label for="m-px"><?php echo e(__('pagebuilder::pagebuilder.px')); ?></label>
                    </div>
                    <div class="pb-radiobtn">
                        <input type="radio" id="m-em" <?php echo e(($styles['margin-type'] ?? '' )=='em' ?'checked':''); ?>

                            name="margin-type" value="em">
                        <label for="m-em"><?php echo e(__('pagebuilder::pagebuilder.em')); ?></label>
                    </div>
                    <div class="pb-radiobtn">
                        <input type="radio" id="m-%" <?php echo e(($styles['margin-type'] ?? '' )=='%' ?'checked':''); ?>

                            name="margin-type" value="%">
                        <label for="m-%"><?php echo e(__('pagebuilder::pagebuilder.%')); ?></label>
                    </div>
                    <div class="pb-radiobtn">
                        <input type="radio" id="m-rem" <?php echo e(($styles['margin-type'] ?? '' )=='rem' ?'checked':''); ?>

                            name="margin-type" value="rem">
                        <label for="m-rem"><?php echo e(__('pagebuilder::pagebuilder.rem')); ?></label>
                    </div>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active">
                        <div class="lb-spaceing">
                            <span class="pb-addvalue"><i class="icon-plus"></i>
                                <div class=" pb-value pb-top-value">
                                    <input type="number" name="margin-top" class="form-control"
                                        value="<?php echo e($styles['margin-top']??''); ?>"
                                        placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                                </div>
                                <div class="pb-value pb-right-value">
                                    <input type="number" name="margin-right" class="form-control"
                                        value="<?php echo e($styles['margin-right']??''); ?>"
                                        placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                                </div>
                                <div class="pb-value pb-bottom-value">
                                    <input type="number" name="margin-bottom" class="form-control"
                                        value="<?php echo e($styles['margin-bottom']??''); ?>"
                                        placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                                </div>
                                <div class="pb-value pb-left-value">
                                    <input type="number" name="margin-left" class="form-control"
                                        value="<?php echo e($styles['margin-left']??''); ?>"
                                        placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="op-accordion-item">
            <div class="pb-advancedtitle" data-bs-toggle="collapse" data-bs-target="#paddings-accord"
                aria-expanded="false">
                <h2><?php echo e(__('pagebuilder::pagebuilder.section_paddings')); ?></h2>
                <span><?php echo e(__('pagebuilder::pagebuilder.section_paddings_description')); ?></span>
            </div>
            <div id="paddings-accord" class="accordion-collapse collapse" data-bs-parent="#pb-advanceaccordion">

                <nav class="pb-background-nav">
                    <div class="pb-radio-wrap pb-layoutinfo ">
                        <div class="pb-radiobtn">
                            <input type="radio" id="p-px" <?php echo e(($styles['padding-type'] ?? '' )=='px'
                                ?'checked':(empty($styles['padding-type'])?'checked':'')); ?> name="padding-type"
                                value="px">
                            <label for="p-px"><?php echo e(__('pagebuilder::pagebuilder.px')); ?></label>
                        </div>
                        <div class="pb-radiobtn">
                            <input type="radio" id="p-em" <?php echo e(($styles['padding-type'] ?? '' )=='em' ?'checked':''); ?>

                                name="padding-type" value="em">
                            <label for="p-em"><?php echo e(__('pagebuilder::pagebuilder.em')); ?></label>
                        </div>
                        <div class="pb-radiobtn">
                            <input type="radio" id="p-%" <?php echo e(($styles['padding-type'] ?? '' )=='%' ?'checked':''); ?>

                                name="padding-type" value="%">
                            <label for="p-%"><?php echo e(__('pagebuilder::pagebuilder.%')); ?></label>
                        </div>
                        <div class="pb-radiobtn">
                            <input type="radio" id="p-rem" <?php echo e(($styles['padding-type'] ?? '' )=='rem' ?'checked':''); ?>

                                name="padding-type" value="rem">
                            <label for="p-rem"><?php echo e(__('pagebuilder::pagebuilder.rem')); ?></label>
                        </div>
                    </div>
                </nav>

                <div class="lb-spaceing">
                    <span class="pb-addvalue"><i class="icon-plus"></i>
                        <div class=" pb-value pb-top-value">
                            <input type="number" name="padding-top" value="<?php echo e($styles['padding-top']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                        </div>
                        <div class="pb-value pb-right-value">
                            <input type="number" name="padding-right" value="<?php echo e($styles['padding-right']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                        </div>
                        <div class="pb-value pb-bottom-value">
                            <input type="number" name="padding-bottom" value="<?php echo e($styles['padding-bottom']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                        </div>
                        <div class="pb-value pb-left-value">
                            <input type="number" name="padding-left" value="<?php echo e($styles['padding-left']??''); ?>"
                                class="form-control" placeholder="<?php echo e(__('pagebuilder::pagebuilder.value')); ?>" />
                        </div>
                    </span>
                </div>
            </div>
        </div>
        <div class="op-accordion-item">
            <div class="pb-advancedtitle" data-bs-toggle="collapse" data-bs-target="#others-accord"
                aria-expanded="false">
                <h2><?php echo e(__('pagebuilder::pagebuilder.advanced_settings')); ?></h2>
                <span><?php echo e(__('pagebuilder::pagebuilder.advanced_settings_description')); ?></span>
            </div>
            <div id="others-accord" class="op-others-accord accordion-collapse collapse"
                data-bs-parent="#pb-advanceaccordion">

                <div class="pb-advancedtitle">
                    <h2><?php echo e(__('pagebuilder::pagebuilder.z-index')); ?></h2>
                    <span><?php echo e(__('pagebuilder::pagebuilder.z-index_description')); ?></span>
                    <div class="pb-layout-input">
                        <input type="number" value="<?php echo e($styles['z-index']??''); ?>" class="form-control" name="z-index"
                            placeholder="<?php echo e(__('pagebuilder::pagebuilder.z-index_placeholder')); ?>">
                    </div>
                </div>
                <div class="pb-advancedtitle">
                    <h2><?php echo e(__('pagebuilder::pagebuilder.css_classes')); ?></h2>
                    <span><?php echo e(__('pagebuilder::pagebuilder.css_classes_description')); ?></span>
                    <div class="pb-layout-input">
                        <input type="text" value="<?php echo e($styles['classes']??''); ?>" name="classes" class="form-control"
                            placeholder="<?php echo e(__('pagebuilder::pagebuilder.css_classes_placeholder')); ?>">
                    </div>
                    <div class="pb-advancedtitle">
                        <h2><?php echo e(__('pagebuilder::pagebuilder.custom_attributes')); ?></h2>
                        <span><?php echo e(__('pagebuilder::pagebuilder.custom_attributes_description')); ?></span>
                        <div class="pb-layout-input">
                            <input type="text" value="<?php echo e($styles['custom_attributes']??''); ?>" name="custom_attributes" class="form-control"
                                placeholder="<?php echo e(__('pagebuilder::pagebuilder.custom_attributes_placeholder')); ?>">
                        </div>
                    </div>
                    <div class="pb-advancedtitle">
                        <h2><?php echo e(__('pagebuilder::pagebuilder.background_image')); ?></h2>
                        <span><?php echo e(__('pagebuilder::pagebuilder.background_image_description')); ?></span>
                        <div class="pb-layout-input">
                            <div class="op-textcontent">
                                <ul class="op-upload-img" id="background_image">
                                    <li class="op-upload-img-info">
                                        <div class="op-uploads-img-data">
                                            <label> <em><i class="icon-plus"></i></em>
                                                <input type="file" data-id="image" data-max_size="3" data-ext="jpg,png"
                                                    accept=".jpg,.png" data-multi_items="false">
                                            </label>
                                        </div>
                                    </li>
                                    <li class="op-upload-img-info op-img-thumbnail d-none">
                                        <div class="op-upload-data">
                                            <figure>
                                                <img src="#">
                                            </figure>
                                            <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                                            <input type="hidden">
                                        </div>
                                    </li>
                                    <?php if( !empty($styles['image'][0]) ): ?>
                                    <?php
                                    $bg = json_decode($styles['image'][0],true);
                                    ?>
                                    <li class="op-upload-img-info op-img-thumbnail">
                                        <div class="op-upload-data">
                                            <figure>
                                                <?php
                                                $path = url(Storage::url($bg['path']));
                                                if($bg['type'] == 'file'){
                                                $path = asset('vendor/optionbuilder/images/file-preview.png');
                                                }
                                                ?>
                                                <img src="<?php echo e($path); ?>">
                                            </figure>
                                            <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                                            <input type="hidden" name="image[]" value="<?php echo e(json_encode($bg)); ?>" />
                                        </div>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                                <span
                                    class="pb-bgimg-info"><?php echo e(__('pagebuilder::pagebuilder.background_image_notice')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="pb-advancedtitle">
                        <h2><?php echo e(__('pagebuilder::pagebuilder.background_image_size')); ?></h2>
                        <span><?php echo e(__('pagebuilder::pagebuilder.background_image_size_description')); ?></span>
                        <div class="pb-layout-input  pb-select">
                            <select data-minimum-results-for-search="Infinity" name="background-size"
                                class="form-select op-input-field op-selectoption"
                                aria-label="<?php echo e(__('pagebuilder::pagebuilder.select')); ?>">
                                <option value='' selected><?php echo e(__('pagebuilder::pagebuilder.select')); ?></option>
                                <option value="default" <?php echo e($styles['background-size']??''=='default' ?'selected':''); ?>><?php echo e(__('pagebuilder::pagebuilder.default')); ?></option>
                                <option value="auto" <?php echo e($styles['background-size']??''=='auto' ?'selected':''); ?>><?php echo e(__('pagebuilder::pagebuilder.auto')); ?></option>
                                <option value="cover" <?php echo e($styles['background-size']??''=='cover' ?'selected':''); ?>><?php echo e(__('pagebuilder::pagebuilder.cover')); ?></option>
                                <option value="contain" <?php echo e($styles['background-size']??''=='contain' ?'selected':''); ?>><?php echo e(__('pagebuilder::pagebuilder.contain')); ?>

                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="pb-advancedtitle">
                        <h2><?php echo e(__('pagebuilder::pagebuilder.background_image_position')); ?></h2>
                        <span><?php echo e(__('pagebuilder::pagebuilder.background_image_position_description')); ?></span>
                        <div class="pb-layout-input pb-select">
                            <select name="background-position" data-minimum-results-for-search="Infinity"
                                class="form-select op-input-field form-control op-selectoption"
                                aria-label="<?php echo e(__('pagebuilder::pagebuilder.select')); ?>">
                                <option value=''><?php echo e(__('pagebuilder::pagebuilder.select')); ?></option>
                                <option value='left top' <?php echo e($styles['background-position']??''=='left top' ?'selected':''); ?>><?php echo e(__('pagebuilder::pagebuilder.left_top')); ?>

                                </option>
                                <option value='left center' <?php echo e($styles['background-position']??''=='left center'
                                    ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.left_center')); ?>

                                </option>
                                <option value='left bottom' <?php echo e($styles['background-position']??''=='left bottom'
                                    ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.left_bottom')); ?>

                                </option>
                                <option value='right top' <?php echo e($styles['background-position']??''=='right top' ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.right_top')); ?>

                                </option>
                                <option value='right center' <?php echo e($styles['background-position']??''=='right center'
                                    ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.right_center')); ?>

                                </option>
                                <option value='right bottom' <?php echo e($styles['background-position']??''=='right bottom'
                                    ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.right_bottom')); ?>

                                </option>
                                <option value='center top' <?php echo e($styles['background-position']??''=='center top'
                                    ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.center_top')); ?>

                                </option>
                                <option value='center center' <?php echo e($styles['background-position']??''=='center center'
                                    ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.center_center')); ?>

                                </option>
                                <option value='center bottom' <?php echo e($styles['background-position']??''=='center bottom'
                                    ?'selected':''); ?>>
                                    <?php echo e(__('pagebuilder::pagebuilder.center_bottom')); ?>

                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="pb-advancedtitle">
                        <h2><?php echo e(__('pagebuilder::pagebuilder.background_color')); ?></h2>
                        <span><?php echo e(__('pagebuilder::pagebuilder.background_color_description')); ?></span>
                        <div class="op-colorpicker">
                            <div class="op-inputbtn-wrapper colorPicker pb-colorpicker">
                                <input type="text" data-id="colorpicker"
                                    data-value="<?php echo e($styles['background-color'] ?? ''); ?>" name="background-color"
                                    value="<?php echo e($styles['background-color'] ?? ''); ?>"
                                    class="op-input-field form-control getcolor">
                                <span class="pb-inputbtn"><span class="colorPicker--preview"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="pb-advancedtitle">
                        <h2><?php echo e(__('pagebuilder::pagebuilder.background_overlay_color')); ?></h2>
                        <span><?php echo e(__('pagebuilder::pagebuilder.background_overlay_color_description')); ?></span>
                        <div class="op-colorpicker">
                            <div class="op-inputbtn-wrapper colorPicker pb-colorpicker">
                                <input type="text" data-id="colorpicker"
                                    data-value="<?php echo e($styles['background-overlay-color'] ?? ''); ?>"
                                    name="background-overlay-color" value="<?php echo e($styles['background-overlay-color'] ?? ''); ?>"
                                    class="op-input-field form-control getcolor">
                                <span class="pb-inputbtn"><span class="colorPicker--preview"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var boxed_slider = document.getElementById('boxed_slider');

    noUiSlider.create(boxed_slider, {
        start: [<?php echo e((empty($styles['boxed_slider_input'])?'1320':$styles['boxed_slider_input'])); ?>],
        range: {
            'min': [0],
            'max': [<?php echo e((empty($styles['boxed_slider_input'])?'1320':$styles['boxed_slider_input'])); ?>]
        }
    });

    boxed_slider.noUiSlider.on('update', function (value, handle) {
        $('#boxed_slider_input').val(Math.round(value));
        if($('#content_width').val() == 'boxed'){
            setTimeout(() => {
                manageContentWidth('boxed', Math.round(value));
                setPageSettings();
            }, 300);
        }
	});

    $(document).on('change', '#content_width', function(event){
       let content_width = $(this).val();
       if(content_width == 'boxed'){
        $('.boxed_slider').removeClass('d-none');
       }
       else{
        $('.boxed_slider').addClass('d-none');
       }
    });

</script><?php /**PATH D:\Sahos\Laravel\lla\vendor\larabuild\pagebuilder\src/../resources/views/components/styles.blade.php ENDPATH**/ ?>