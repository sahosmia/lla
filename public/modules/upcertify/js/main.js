'use strict';
let colorPicker;
window.allFonts = [];
var filteredFonts = [];
jQuery(window).on('load', function () {
    let customClass = '';
    const breakPoints = [
        {
            maxWidth: 420,
            className:
                'uc-upcertify420 uc-upcertify480 uc-upcertify575 uc-upcertify640 uc-upcertify991',
        },
        {
            maxWidth: 480,
            className:
                'uc-upcertify480 uc-upcertify575 uc-upcertify640 uc-upcertify991',
        },
        {
            maxWidth: 575,
            className: 'uc-upcertify575 uc-upcertify640 uc-upcertify991',
        },
        { maxWidth: 480, className: 'uc-upcertify480' },
        { maxWidth: 640, className: 'uc-upcertify640 uc-upcertify991' },
        { maxWidth: 767, className: 'uc-upcertify767' },
        { maxWidth: 991, className: 'uc-upcertify991' },
        { maxWidth: 1080, className: 'uc-upcertify1080' },
        { maxWidth: 1199, className: 'uc-upcertify1199' },
        { maxWidth: 1360, className: 'uc-upcertify1360' },
        { maxWidth: 1440, className: 'uc-upcertify1440' },
        { maxWidth: 1536, className: 'uc-upcertify1536' },
        { maxWidth: 1680, className: 'uc-upcertify1680' },
    ];

    const mainWrapWidth = jQuery('.uc-main-wrap')?.innerWidth() || 0;
    if (mainWrapWidth > 0) {
        for (let i = 0; i < breakPoints.length; i++) {
            if (breakPoints[i].maxWidth >= mainWrapWidth) {
                customClass = breakPoints
                    .slice(i, breakPoints.length)
                    .map((bp) => bp.className)
                    .join(' ');
                break;
            }
        }
    }

    if (customClass) {
        jQuery('.uc-main-wrap').addClass(customClass);
    }

    setTimeout(() => {
        addedFonts();
        initializeCanvasElements();
        if (jQuery('.uc-colorPicker').length) {
            colorPicker = jQuery('.uc-colorPicker').colorPickerByGiro({
                preview: '.uc-colorPicker-preview',
                showPicker: false,
                format: 'hex',
                options: {
                    defaultColor: '#754FFE',
                },
                text: {
                    close: 'Confirm',
                    none: 'None',
                },
            });
        }
        if (jQuery('#font-size-slider').length) {
            jQuery('#font-size-slider').slider({
                min: 8,
                step: 1,
                max: 80,
                value: 16,
                slide: function (event, ui) {
                    jQuery('#uc-course_font-size').text(ui.value + 'px');
                    jQuery('.uc-wildcard_edit').css(
                        'font-size',
                        ui.value + 'px'
                    );
                    jQuery('.uc-wildcard_edit').attr(
                        'data-font-size',
                        ui.value
                    );
                },
            });
        }
    }, 100);

    jQuery(document).on('click', 'body', function (e) {
        jQuery('.cp-cont')
            .find('.cpBG')
            .removeClass('in')
            .css('display', 'none');
    });

    jQuery(document).on('click', '.uc-font-size-dropdown', function (e) {
        e.preventDefault();
        jQuery('.uc-font-size-slider').toggleClass('uc-none');
    });

    jQuery(document).on('click', '.cp-cont', function (e) {
        e.stopPropagation();
    });

    jQuery(document).on(
        'click',
        '.colorPicker input, .colorPicker--preview',
        function (evt) {
            let _this = $(this);
            jQuery('.cp-cont')
                .find('.cpBG')
                .not(_this.parents('.cp-cont').find('.cpBG'))
                .removeClass('in')
                .css('display', 'none');
        }
    );

    jQuery(document).on('contextmenu', '.colorPicker input', function (evt) {
        let _this = $(this);
        jQuery('.cp-cont')
            .find('.cpBG')
            .not(_this.parents('.cp-cont').find('.cpBG'))
            .removeClass('in')
            .css('display', 'none');
    });

    jQuery(document).on('change', '.uc-course_color', function () {    
        let getcolor = jQuery(this).val();
        let setcolor = jQuery('.colorPicker--preview');
        jQuery('.uc-wildcard_edit').css('color', getcolor);
        jQuery(setcolor).css('background-color', getcolor);
    });
    
    jQuery(document).on('change', '.uc-shape_color', function () {    
        const selectedColor = jQuery(this).val(); 
        const selectedShape = jQuery('.uc-element-wildcard.uc-wildcard_edit .uc-wildcard_content svg');        
        if (selectedShape.length) {
            selectedShape.find('path, rect, circle, polygon').attr('fill', selectedColor);
        }
    });
    

    jQuery(document).on('click', '.uc-background_option', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        let type = _this.data('type');
        let url = _this.data('url');       
        if(type == 'background') {
            jQuery('[data-type="frame"]').remove();
        } 
        if (url == '') {
            jQuery('#uc-canvas-boundry').css('background-image', 'none');
        } else {            
            jQuery('#uc-canvas-boundry').css('background-image', `url(${url})`);          
            jQuery('#uc-canvas-boundry').css('background-color', '');
            jQuery('#uc-canvas-boundry').css('background-position', 'center');
            jQuery('#uc-canvas-boundry').css('background-size', '100% 100%');
            jQuery('#uc-canvas-boundry').css('background-repeat', 'no-repeat');
            if(type == 'background') {
                jQuery('#uc-canvas-boundry').attr('data-type', type);
            } else {
                jQuery('#uc-canvas-boundry').attr('data-type', '');
            }
        }
    });


    jQuery(document).on('click', '.uc-background_pattern', function (e) {        
        e.preventDefault();
        var _this = jQuery(this);
        let url = _this.data('url');
        console.log(url);
        
        if (url == '') {
    
            jQuery('#uc-canvas-boundry').css({
                'background-repeat': 'no-repeat',
            });
        } else {
            jQuery('#uc-canvas-boundry').css({
                'background-image': `url(${url})`,
                'background-repeat': 'repeat',
                'background-color': '',
                'background-position': '',
                'background-size':'',
            });
        }
    });
    // Handle color picker changes
    jQuery(document).on('input', '.uc-colorpicker input[type="color"]', function (e) {
        let selectedColor = jQuery(this).val(); // Get the selected color
        jQuery('#uc-canvas-boundry').css({
            'background-image': 'none',
            'background-repeat': 'no-repeat',
        });
        jQuery('#uc-canvas-boundry').css('background-color', selectedColor);
    });

    jQuery(document).on('click', '.uc-attachment-item', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        let url = _this.data('url');
        let svgContent = _this.data('svg');
        let color = _this.data('color'); 
        let type = _this.data('type'); 
        let isBadge = _this.hasClass('badge-item'); 
        let tag = '';  
        if(type == "svg-frame"){
            if (jQuery('#uc-canvas-boundry').attr('data-type') === "background") {
                jQuery('#uc-canvas-boundry').css({
                    'background-image': '',
                    'background-color': '',
                    'background-position': '',
                    'background-size': '',
                    'background-repeat': ''
                });
            }
        }
        if (['separation_horizontal', 'separation_vertical'].includes(type)) {
            tag = elements(type);
        } else if (type === 'svg') {
            if (isBadge) {
                tag = `<div class="uc-element-wildcard" data-type="badge" data-actions="delete, copy" data-handles="ne, se, sw, nw" data-wildcard_name="attachment">
                            <div class="uc-wildcard_content">
                                ${svgContent}
                            </div>
                        </div>`;
            } else {               
                tag = `<div class="uc-element-wildcard" data-actions="delete, copy, colorPicker" data-handles="ne, se, sw, nw" data-wildcard_name="attachment"> 
                            <div class="uc-wildcard_content">
                                ${svgContent.replace(/fill="[^"]*"/g, `fill="${color}"`)}
                            </div>
                        </div>`;
            }
        }else if (type === 'color') {
            jQuery('#uc-canvas-boundry').css('background-image', 'none');
            jQuery('#uc-canvas-boundry').css('background-color', color);
        } 
        else if (type === 'svg-frame') {
            tag = `<div data-handles="ne, se, sw, nw" data-type="frame" data-wildcard_name="attachment"> 
                <div class="uc-wildcard_content uc-bgframe">
                    ${svgContent}
                </div>
            </div>`;
            jQuery('[data-type="frame"]').remove();
        } 
        else {
            tag = `<div class="uc-element-wildcard" data-actions="delete, copy" data-handles="ne, se, sw, nw" data-wildcard_name="attachment"> 
                    <div class="uc-wildcard_content">
                        <img src="${url}" alt="image">
                    </div>
                </div>`;
        }
        jQuery('#uc-canvas-boundry').prepend(tag);
        makeDraggable(jQuery('.uc-element-wildcard'));
    });
    



    jQuery(document).on('click', '.uc-copy-wildcard', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        let element = _this.closest('.uc-element-wildcard');
        let clone = element.clone(false);
        clone
            .removeClass(
                'ui-draggable ui-draggable-handle ui-resizable uc-wildcard_edit'
            )
            .find('.ui-resizable-handle')
            .remove();
        clone.find('.uc-wildcard_option').remove();
        clone.css({
            top: '20px',
            left: '30px',
        });
        jQuery('#uc-canvas-boundry').prepend(clone);
        makeDraggable(clone);
    });

    jQuery(document).on('keyup', '.uc-fontoption-search', function (e) {
        e.preventDefault();
        let _this = jQuery(this);
        let searchTerm = _this.val()?.trim()?.toLowerCase();
        let allFonts = window.allFonts;
        filteredFonts = allFonts.filter((font) =>
            font.family.toLowerCase().includes(searchTerm)
        );

        let html = '';

        jQuery(
            '.uc-fontoptions li:not(.uc-fonts-search, .uc-fonts-showmore)'
        ).remove();

        if (filteredFonts.length > 0) {
            const displayFonts = filteredFonts.slice(0, 10);
            displayFonts.forEach((font, key) => {
                html += `<li id="font-${key}" class="uc-fontoption">
                    <a href="javascript:void(0);" class="uc-fontoption-item" data-font="${font.family}">
                        ${font.family}
                    </a>
                </li>`;
            });

            if (filteredFonts.length > 10) {
                jQuery('.uc-fontoptions .uc-fonts-showmore').removeClass(
                    'uc-none'
                );
            } else {
                jQuery('.uc-fontoptions .uc-fonts-showmore').addClass(
                    'uc-none'
                );
            }
        } else {
            html = `<li>
                <a href="javascript:void(0);" class="uc-fontoption-item">
                    No record found
                </a>
            </li>`;
            jQuery('.uc-fontoptions .uc-fonts-showmore').addClass('uc-none');
        }

        jQuery('.uc-fontoptions .uc-fonts-search').after(html);
    });

    jQuery(document).on('click', '.uc-select-title', function (e) {
        e.preventDefault();
        let _this = jQuery(this);
        let allFonts = window.allFonts;
        let showMoreText = _this.data('showmore_text');
        let placeholderText = _this.data('placeholder_text');
        let html = `<li class="uc-fonts-search"><input type="text" class="uc-fontoption-search" placeholder="${placeholderText}"></li>`;
        allFonts.slice(0, 10).forEach((font, key) => {
            html += `<li id="font-${key}" class="uc-fontoption">
                <a href="javascript:void(0);" class="uc-fontoption-item" data-font="${font.family}">
                    ${font.family}
                </a>
            </li>`;
        });

        if (allFonts.length > 10) {
            html += `<li class="uc-fonts-showmore">
                <a href="javascript:void(0);">
                    ${showMoreText}
                </a>
            </li>`;
        }

        jQuery('.uc-fontoptions').html(html);
        jQuery('.uc-select').addClass('uc-showoptions');
    });

    jQuery(document).on('click', '.uc-fontoption-item', function (e) {
        const _this = jQuery(this);
        const selectedFont = _this.data('font');

        let html = `<span class="uc-select-title">${selectedFont}</span>`;

        if (!jQuery('.uc-select-title').length) {
            jQuery('.uc-select').prepend(html);
        } else {
            jQuery('.uc-select-title').text(selectedFont);
        }
        addedFonts(selectedFont);
        jQuery('.uc-wildcard_edit')
            .attr('data-font', selectedFont)
            .css('font-family', selectedFont);
        jQuery('.uc-select').removeClass('uc-showoptions');
    });

    jQuery(document).on('click', '.uc-fonts-showmore', function (e) {
        e.preventDefault();
        let count = jQuery('.uc-fontoption').length;
        let allFonts = filteredFonts?.length ? filteredFonts : window.allFonts;
        let nextFonts = allFonts.slice(count, count + 10);
        let html = '';
        for (let i = 0; i < nextFonts.length; i++) {
            let font = nextFonts[i];
            html += `<li id="font-${i}"><a href="javascript:void(0);" class="uc-fontoption-item" data-font="${font.family}">${font.family}</a></li>`;
        }
        jQuery('.uc-fontoptions .uc-fonts-showmore').before(html);
    });

    jQuery(document).on('click', '.uc-element-drag', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var id = _this.data('name');
        let element = elements(id);
        let wildcard = jQuery(element).css('color', '#000000');

        jQuery('#uc-canvas-boundry').prepend(wildcard);
        makeDraggable(jQuery('.uc-element-wildcard'));
    });

    jQuery(document).on('click', '.uc-element-wildcard', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        let actions = _this.data('actions');
        let wildcardName = _this.data('wildcard_name');
        let actionsArray = actions.split(',').map((action) => action.trim());  
        let defaultShapeColor = _this.find('svg path, svg rect, svg circle, svg polygon').attr('fill') || '#D9D9D9';     
        let button = actionButtons(actionsArray,defaultShapeColor);
        jQuery('.uc-element-wildcard').removeClass('uc-wildcard_edit');
        _this.addClass('uc-wildcard_edit');
        let classList = _this.attr('class').split(/\s+/);
        let inlineColor = _this.css('color');

        if (inlineColor) {
            jQuery('.uc-colorPicker')
                .data('colorPickerByGiro_data')
                .setValue(inlineColor);
        }

        if (
            [
                'attachment',
                'separation_horizontal',
                'separation_vertical',
            ].includes(wildcardName)
        ) {
            hideEditBar();
        } else {
            activeEditBar(classList);
        }

        if (!_this.find('.uc-wildcard_option').length) {
            removeActions();
            _this.prepend(button);
        }

        let font = _this.attr('data-font');

        if (font) {
            let html = `<span class="uc-select-title">${font}</span>`;

            if (!jQuery('.uc-select-title').length) {
                jQuery('.uc-select').prepend(html);
            } else {
                jQuery('.uc-select-title').text(font);
            }
        }
        resetFontOptions();
        jQuery('#uc-course_font-size').text(_this.css('font-size'));
        $('#font-size-slider').slider(
            'value',
            parseInt(_this.css('font-size'))
        );
        jQuery('.uc-font-size-slider').addClass('uc-none');
    });

    // Changing font styles
    jQuery(document).on('click', '.uc-course_editbar a', function (e) {
        e.preventDefault();
        let _this = jQuery(this);
        let actionClass = _this.data('action_class');
        if (
            [
                'uc-alignment-left',
                'uc-alignment-center',
                'uc-alignment-right',
            ].includes(actionClass)
        ) {
            jQuery('.uc-wildcard_edit')
                .removeClass(
                    'uc-alignment-left uc-alignment-center uc-alignment-right'
                )
                .addClass(actionClass);
            jQuery('.uc-course_options_align a').removeClass('uc-active');
            _this.addClass('uc-active');
        }

        if (
            ['uc-text-bold', 'uc-text-italic', 'uc-text-underline'].includes(
                actionClass
            )
        ) {
            _this.toggleClass('uc-active');
            jQuery('.uc-wildcard_edit').toggleClass(actionClass);
        }
    });

    jQuery(document).on('click', function (e) {
        if (
            !jQuery(e.target).closest(
                '.uc-element-wildcard, .uc-wildcard_option, .uc-course_options, .uc-fontoptions'
            ).length
        ) {
            hideEditBar();
            removeActions();
            jQuery('.uc-element-wildcard').removeClass('uc-wildcard_edit');
        }

        if (!jQuery(e.target).closest('.uc-select').length) {
            resetFontOptions();
        }

        if (!jQuery(e.target).closest('.uc-course_options_font-size').length) {
            jQuery('.uc-font-size-slider').addClass('uc-none');
        }

        if (!jQuery(e.target).closest('.uc-certificates_item_actions').length) {
            jQuery('.uc-certificates_item_actions').removeClass('active');
            jQuery('.uc-certificates_item_actions_dropdown').slideUp();
        }
    });

    jQuery(document).on('click', '.uc-edit-wildcard', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var content = _this
            .parents('.uc-element-wildcard')
            .find('.uc-wildcard_content');

        content.attr('contenteditable', 'true').focus();

        // Use setTimeout to ensure the element is focusable before trying to select its content
        setTimeout(function () {
            var range = document.createRange();
            range.selectNodeContents(content[0]);
            var selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
        }, 0);

        _this
            .closest('.uc-element-wildcard')
            .css('cursor', 'text')
            .draggable('disable');
    });

    //Delete wildcard
    jQuery(document).on('click', '.uc-delete-wildcard', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        openModal('#uc-deletepopup');
        var confirmDeleteBtn = document.querySelector('.uc-confirm-yes');
        const deleteHandler = function () {
            closeModal('#uc-deletepopup');
            _this.closest('.uc-element-wildcard').remove();
            confirmDeleteBtn.removeEventListener('click', deleteHandler);
        };
        confirmDeleteBtn.addEventListener('click', deleteHandler);
    });

    jQuery(document).on('input', '.uc-search-wildcard', function () {
        let _this = jQuery(this);
        var searchTerm = _this.val()?.trim()?.toLowerCase();
        let noMatch = true;
        jQuery('.uc-element-drag[data-name]').each(function () {
            let item = jQuery(this);
            var text = item.find('span').text().toLowerCase();
            if (text.indexOf(searchTerm) > -1) {
                noMatch = false;
            }
            item.toggle(text.indexOf(searchTerm) > -1);
        });
        if (noMatch) {
            jQuery('.uc-no-found').show();
        } else {
            jQuery('.uc-no-found').hide();
        }
    });

    jQuery(document).on('click', '.uc-accordion-header', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        const accordionContentId = _this.data('accordion');
        toggleAccordion(accordionContentId);
    });

    // Remove class when hide button is clicked
    jQuery(document).on('click', '.uc-sidebar-hidebtn', function () {
        jQuery('.uc-main-wrap').removeClass('uc-sidebar_show');
    });

    // Add class when navigation link is clicked
    jQuery(document).on('click', '.uc-navigation nav ul li a', function () {
        jQuery('.uc-main-wrap').addClass('uc-sidebar_show');
    });

    // Certificate option toggle
    jQuery(document).on(
        'click',
        '.uc-certificates_item_actions_btn',
        function () {
            jQuery('.uc-certificates_item_actions')
                .not(jQuery(this).parent())
                .removeClass('active');

            jQuery('.uc-certificates_item_actions_dropdown')
                .not(
                    jQuery(this)
                        .parent()
                        .children('.uc-certificates_item_actions_dropdown')
                )
                .slideUp();
            jQuery(this)
                .parent()
                .children('.uc-certificates_item_actions_dropdown')
                .slideToggle();

            jQuery(this)
                .parent('.uc-certificates_item_actions')
                .toggleClass('active');
        }
    );

    // user mennu toggle
    jQuery(document).on('click', '.uc-usermenu > a', function () {
        jQuery(this).parent().children('.uc-usermenu_list').slideToggle();
        jQuery(this).parent('.uc-usermenu').toggleClass('active');
    });
});

function resetFontOptions() {
    jQuery('.uc-select').removeClass('uc-showoptions');

    let allFonts = window.allFonts;
    let nextFonts = allFonts.slice(0, 10);
    let html = '';
    for (let i = 0; i < nextFonts.length; i++) {
        let font = nextFonts[i];
        html += `<li id="font-${i}"><a href="javascript:void(0);" class="uc-fontoption-item" data-font="${font.family}">${font.family}</a></li>`;
    }
    // Remove all li elements except the one with class 'uc-fonts-showmore'
    jQuery('.uc-fontoptions li:not(.uc-fonts-showmore)').remove();

    // Append the new font options
    jQuery('.uc-fontoptions').prepend(html);
    // jQuery('.uc-fontoptions .uc-fonts-showmore').before(html);
}

function addedFonts(font = '') {
    const wildcards = jQuery('.uc-element-wildcard');
    const fontSet = new Set();
    if (font) {
        fontSet.add(font);
    }
    wildcards.each(function () {
        const inlineStyle = jQuery(this).attr('style');
        if (inlineStyle) {
            const fontFamilyMatch = inlineStyle.match(
                /font-family:\s*([^;]+)/i
            );
            if (fontFamilyMatch) {
                const inlineFont = fontFamilyMatch[1]
                    .trim()
                    .replace(/['"]/g, '');
                fontSet.add(inlineFont);
            }
        }
    });
    const families = Array.from(fontSet)
        .map(
            (font) =>
                `family=${font}:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900`
        )
        .join('&');

    const uid = Math.random().toString(36).substring(2, 15);
    const linkHref = `https://fonts.googleapis.com/css2?${families}&display=swap`;
    const linkTag = `<link id="uc-custom-font-${uid}" type="text/css" rel="stylesheet" href="${linkHref}">`;

    const existingFontLinks = jQuery('[id^="uc-custom-font-"]');
    if (existingFontLinks.length) {
        existingFontLinks.remove();
    }
    jQuery('head').append(linkTag);
}

function makeDraggable(elements) {
    elements.each(function () {
        let _this = jQuery(this);
        let wildcardName = _this.data('wildcard_name');
        let handles = _this.data('handles') ?? 'e, w';
        console.log(wildcardName);
        
        _this
            .draggable({
                smartGuides: true,
                snapTolerance: 10,
                containment: jQuery('#uc-canvas-boundry'), // Restrict dragging within certificate
                cursor: 'move',
            })
            .resizable({
                containment: jQuery('#uc-canvas-boundry'), // Restrict resizing within certificate
                aspectRatio: wildcardName == 'attachment' ? true : false, // Maintain aspect ratio
                handles: handles, // Allow resizing from all sides
                // handles: wildcardName == 'attachment' ? 'ne, se, sw, nw' : 'e, w', // Allow resizing from all sides
                minWidth: 50, // Set minimum width
                minHeight: 50, // Set minimum height
                resize: function (event, ui) {
                    const svgElement = _this.find('svg');
                    const imgElement = _this.find('img');
                    if (svgElement.length > 0) {
                        const width = ui.size.width;
                        const height = ui.size.height;
                        svgElement.attr('width', width).attr('height', height);
                    }
                    if (imgElement.length > 0) {
                        imgElement.css({
                            width: ui.size.width + 'px',
                            height: ui.size.height + 'px',
                        });
                    }
                },
            })
            .css({
                position: 'absolute',
                cursor: 'move',
            });

        if (
            !['separation_horizontal', 'separation_vertical'].includes(
                wildcardName
            )
        ) {
 
            _this.rotatable({
                wheelRotate: false,
            });
        }
    });
}

function initializeCanvasElements() {
    jQuery('.uc-element-wildcard').each(function () {
        makeDraggable(jQuery(this));
    });
}

function removeActions() {
    let otpions = jQuery('.uc-wildcard_option.uc-active');
    if (otpions.length) {
        otpions
            .closest('.uc-element-wildcard')
            .css('cursor', 'move')
            .draggable('enable');
        jQuery('.uc-wildcard_option.uc-active').remove();
    }
}

function activeEditBar(classList) {
    jQuery('.uc-course_editbar a').removeClass('uc-active');
    if (classList.includes('uc-alignment-left')) {
        jQuery('.uc-alignleft').addClass('uc-active');
    }
    if (classList.includes('uc-alignment-center')) {
        jQuery('.uc-aligncenter').addClass('uc-active');
    }
    if (classList.includes('uc-alignment-right')) {
        jQuery('.uc-alignright').addClass('uc-active');
    }
    if (classList.includes('uc-text-bold')) {
        jQuery('.uc-bold').addClass('uc-active');
    }
    if (classList.includes('uc-text-italic')) {
        jQuery('.uc-italic').addClass('uc-active');
    }
    if (classList.includes('uc-text-underline')) {
        jQuery('.uc-underline').addClass('uc-active');
    }
    jQuery('.uc-course_editbar').css({
        opacity: '1',
        visibility: 'visible',
    });
}

function hideEditBar() {
    jQuery('.uc-course_editbar').css({
        opacity: '0',
        visibility: 'hidden',
    });
}

function actionButtons(actions,shapeColor = '#D9D9D9') {
    let html = `<div class="uc-course_options uc-wildcard_option uc-active">`;
    if (actions.includes('edit')) {
        html += `<a href="javascript:void(0);" class="uc-edit-wildcard"><i><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_11173_25708)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1109 0.642133C13.9661 -0.213063 15.3526 -0.213048 16.2078 0.642181L17.3586 1.79298C18.2138 2.64821 18.2138 4.03482 17.3586 4.89006L15.0571 7.19105L6.43789 15.8105C5.98625 16.2622 5.4285 16.5933 4.81574 16.7735L0.721237 17.9778C0.523758 18.0359 0.310324 17.9815 0.16477 17.8359C0.019215 17.6904 -0.035211 17.4769 0.0228696 17.2795L1.22713 13.1848C1.40736 12.5721 1.73845 12.0143 2.19009 11.5627L13.1109 0.642133C13.1109 0.642117 13.1108 0.642149 13.1109 0.642133ZM14.6594 5.99785L16.5631 4.09457C16.5631 4.09456 16.5631 4.09459 16.5631 4.09457C16.9789 3.67867 16.979 3.00434 16.5631 2.58846L15.4123 1.43766C14.9965 1.02178 14.3222 1.02178 13.9063 1.43767L12.0026 3.34096L14.6594 5.99785ZM11.2071 4.13642L2.9856 12.3581C2.66706 12.6767 2.43354 13.0701 2.30642 13.5023L1.39313 16.6075L4.49829 15.6942C4.93047 15.5671 5.32384 15.3336 5.64238 15.015L13.8639 6.7933L11.2071 4.13642Z" fill="#585858"/> </g> <defs> <clipPath id="clip0_11173_25708"> <rect width="18" height="18" fill="white"/> </clipPath> </defs> </svg></i><span class="uc-tooltip-text">Edit</span></a>`;
    }
    if (actions.includes('delete')) {
        html += `<a href="javascript:void(0);" class="uc-delete-wildcard"><i class=""><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_11173_25700)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.66759 2.38797C2.86718 0.878651 4.72827 1.52588e-05 6.6943 1.52588e-05H11.3154C13.2795 1.52588e-05 15.1384 0.879887 16.3336 2.39029C16.7519 2.919 16.3174 3.59538 15.7404 3.59538H2.26037C1.68208 3.59538 1.24723 2.91688 1.66759 2.38797ZM3.13022 2.47038H14.8712C13.9204 1.61584 12.6523 1.12502 11.3154 1.12502H6.6943C5.35503 1.12502 4.0843 1.61564 3.13022 2.47038ZM4.4032 6.47166C3.39391 6.47166 2.68319 7.32415 2.83224 8.20317L3.91297 14.5768C4.13449 15.8832 5.32499 16.875 6.75899 16.875H11.2327C12.6659 16.875 13.856 15.8842 14.0784 14.5786L15.164 8.20418C15.3138 7.32488 14.603 6.47166 13.5932 6.47166H4.4032ZM1.72397 8.39139C1.4484 6.76623 2.75952 5.34666 4.4032 5.34666H13.5932C15.2377 5.34666 16.549 6.76747 16.2721 8.39321L15.1865 14.7677C14.866 16.6496 13.1768 18 11.2327 18H6.75899C4.81384 18 3.12402 16.6482 2.8047 14.765L1.72397 8.39139ZM5.45388 8.6488C5.7597 8.59554 6.05077 8.80047 6.10399 9.10653L6.96513 14.0584C7.01835 14.3645 6.81358 14.6558 6.50777 14.7091C6.20195 14.7623 5.91089 14.5574 5.85766 14.2513L4.99652 9.29942C4.9433 8.99336 5.14807 8.70207 5.45388 8.6488ZM12.5357 8.6488C12.8416 8.70207 13.0463 8.99336 12.9931 9.29942L12.132 14.2513C12.0787 14.5574 11.7877 14.7623 11.4819 14.7091C11.176 14.6558 10.9713 14.3645 11.0245 14.0584L11.8856 9.10653C11.9389 8.80047 12.2299 8.59554 12.5357 8.6488ZM8.99482 8.64047C9.30523 8.64047 9.55687 8.89231 9.55687 9.20297V14.1549C9.55687 14.4656 9.30523 14.7174 8.99482 14.7174C8.6844 14.7174 8.43276 14.4656 8.43276 14.1549V9.20297C8.43276 8.89231 8.6844 8.64047 8.99482 8.64047Z" fill="#585858"/> </g> <defs> <clipPath id="clip0_11173_25700"> <rect width="18" height="18" fill="white"/> </clipPath> </defs> </svg></i><span class="uc-tooltip-text">Delete</span></a>`;
    }
    if (actions.includes('copy')) {
        html += `<a href="javascript:void(0);" class="uc-copy-wildcard"><i><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1742_210)"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.898438 5.75C0.898438 3.26472 2.91316 1.25 5.39844 1.25H13.8359C15.8035 1.25 17.3984 2.84499 17.3984 4.8125C17.3984 5.22671 17.0627 5.5625 16.6484 5.5625C16.2342 5.5625 15.8984 5.22671 15.8984 4.8125C15.8984 3.67341 14.975 2.75 13.8359 2.75H5.39844C3.74158 2.75 2.39844 4.09315 2.39844 5.75V13.25C2.39844 14.9069 3.74158 16.25 5.39844 16.25H5.71094C6.12515 16.25 6.46094 16.5858 6.46094 17C6.46094 17.4142 6.12515 17.75 5.71094 17.75H5.39844C2.91316 17.75 0.898438 15.7353 0.898438 13.25V5.75ZM8.64844 11.8223C8.64844 9.33698 10.6632 7.32227 13.1484 7.32227H20.3984C22.8837 7.32227 24.8984 9.33698 24.8984 11.8223V18.25C24.8984 20.7353 22.8837 22.75 20.3984 22.75H13.1484C10.6632 22.75 8.64844 20.7353 8.64844 18.25V11.8223ZM13.1484 8.82227C11.4916 8.82227 10.1484 10.1654 10.1484 11.8223V18.25C10.1484 19.9069 11.4916 21.25 13.1484 21.25H20.3984C22.0553 21.25 23.3984 19.9069 23.3984 18.25V11.8223C23.3984 10.1654 22.0553 8.82227 20.3984 8.82227H13.1484Z" fill="#585858"/></g><defs><clipPath id="clip0_1742_210"><rect width="24" height="24" fill="white" transform="translate(0.898438)"/></clipPath></defs></svg></i> <span class="uc-tooltip-text">Copy</span></a>`;
    }
    if (actions.includes('colorPicker')) {
        html += `<div class="uc-course_options_color uc-shape_colorPicker">
                    <input type="text" name="uc-course_color" class="uc-shape_color" value="${shapeColor}">
                    <span class="uc-shape_colorPicker-preview" style="background-color: ${shapeColor}"></span>
                </div>`;                
                setTimeout(() => {
                    jQuery('.uc-shape_colorPicker').each(function () {
                        if (!jQuery(this).data('colorPickerByGiro_initialized')) {
                            jQuery(this).colorPickerByGiro({
                                preview: '.uc-shape_colorPicker-preview',
                                showPicker: false,
                                format: 'hex',
                                options: {
                                    defaultColor: shapeColor,
                                },
                                text: {
                                    close: 'Confirm',
                                    none: 'None',
                                },
                            });
                            jQuery(this).data('colorPickerByGiro_initialized', true);
                        }
                    });
                }, 100); // Slight delay to ensure DOM update
    }

    
    html += `</div>`;
    return html;
}

function toggleAccordion(accordionContentId, isDown = false) {
    const accordionContent = jQuery('#' + accordionContentId);

    if (isDown) {
        accordionContent.slideDown();
    } else {
        accordionContent.slideToggle();
    }

    jQuery('.uc-accordion-content')
        .not(accordionContent)
        .removeClass('active')
        .slideUp();
}

function openModal(dt, desc = '', icon = 'delete') {
    jQuery(dt).addClass('uc-modalopen');
    let deleteIcon = `<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.78578 4.1243C5.7955 4.12456 5.80522 4.12456 5.81491 4.1243H12.1924C12.202 4.12456 12.2118 4.12456 12.2215 4.1243H15.3255C15.6338 4.1243 15.8837 3.87441 15.8837 3.56616C15.8837 3.25791 15.6338 3.00802 15.3255 3.00802H12.5426C11.8345 1.80197 10.5062 1 9.00363 1C7.49346 1 6.17135 1.80244 5.46452 3.00802H2.67435C2.3661 3.00802 2.11621 3.25791 2.11621 3.56616C2.11621 3.87441 2.3661 4.1243 2.67435 4.1243H5.78578ZM6.85973 3.00802H11.1461C10.606 2.45901 9.84469 2.11628 9.00363 2.11628C8.15755 2.11628 7.39828 2.45881 6.85973 3.00802ZM4.47232 6.47073C3.86374 6.47073 3.42054 7.00281 3.514 7.56741L4.54995 13.8259C4.74524 15.0057 5.78472 15.8837 7.01723 15.8837H10.9884C12.2216 15.8837 13.2614 15.0048 13.456 13.8242L14.4872 7.56677C14.5803 7.00235 14.1371 6.47073 13.5288 6.47073H4.47232ZM2.41271 7.7497C2.20319 6.48395 3.19602 5.35446 4.47232 5.35446H13.5288C14.8045 5.35446 15.7972 6.48297 15.5887 7.74828L14.5574 14.0058C14.2719 15.7384 12.7549 17 10.9884 17H7.01723C5.25173 17 3.73527 15.7397 3.44866 14.0082L2.41271 7.7497ZM7.41524 8.42548C7.72349 8.42548 7.97338 8.67537 7.97338 8.98362V13.3683C7.97338 13.6766 7.72349 13.9264 7.41524 13.9264C7.10699 13.9264 6.8571 13.6766 6.8571 13.3683V8.98362C6.8571 8.67537 7.10699 8.42548 7.41524 8.42548ZM10.5846 8.42548C10.8929 8.42548 11.1428 8.67537 11.1428 8.98362V11.9996C11.1428 12.3079 10.8929 12.5578 10.5846 12.5578C10.2764 12.5578 10.0265 12.3079 10.0265 11.9996V8.98362C10.0265 8.67537 10.2764 8.42548 10.5846 8.42548Z" fill="#585858"/></svg>`;
    let warningIcon = `<svg class="uc-warning-icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
    <path d="M15 16.25V11.25M15.625 20.625C15.625 20.9702 15.3452 21.25 15 21.25C14.6548 21.25 14.375 20.9702 14.375 20.625M15.625 20.625C15.625 20.2798 15.3452 20 15 20C14.6548 20 14.375 20.2798 14.375 20.625M15.625 20.625H14.375M24.1638 12.614L23.7251 11.8305C20.8734 6.73829 19.4476 4.19221 17.572 3.34531C15.9368 2.60698 14.0632 2.60698 12.428 3.34531C10.5524 4.19221 9.12655 6.7383 6.27494 11.8305L5.83618 12.614C3.09507 17.5088 1.72452 19.9562 1.95377 21.9603C2.15378 23.7088 3.08169 25.2919 4.50953 26.3208C6.14611 27.5 8.95115 27.5 14.5612 27.5H15.4388C21.0488 27.5 23.8539 27.5 25.4905 26.3208C26.9183 25.2919 27.8462 23.7088 28.0462 21.9603C28.2755 19.9562 26.9049 17.5088 24.1638 12.614Z" stroke="#F04438" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>`;

    jQuery(dt)
        .find('.uc-deletepopup_icon span')
        .html(icon == 'delete' ? deleteIcon : warningIcon);
    if (desc) {
        jQuery(dt).find('.uc-deletepopup_title p').text(desc);
    }
    setTimeout(function () {
        jQuery(dt).addClass('uc-fadin');
        jQuery('.uc-overlaymodal').addClass('uc-fadin');
    }, 1);
    jQuery('body').css('overflow', 'hidden');
    jQuery('body').append("<div class='uc-overlaymodal'></div>");
}

function openWarningModal(dt) {
    jQuery(dt).addClass('uc-modalopen');
    setTimeout(function () {
        jQuery(dt).addClass('uc-fadin');
        jQuery('.uc-overlaymodal').addClass('uc-fadin');
    }, 1);
    jQuery('body').css('overflow', 'hidden');
    jQuery('body').append("<div class='uc-overlaymodal'></div>");
}

function closeModal() {
    jQuery('.uc-modal').removeClass('uc-fadin');
    jQuery('.uc-overlaymodal').removeClass('uc-fadin');
    setTimeout(function () {
        jQuery('.uc-modal').removeClass('uc-modalopen');
        jQuery('.uc-overlaymodal').remove();
    }, 300);
    jQuery('body').css({ overflow: '' });
}

function showToast(type, message) {
    // Create a new div element for the toast
    let toastDiv = document.createElement('div');
    toastDiv.className = `uc-toastr uc-toastr-show uc-toastr-${
        type === 'success' ? 'success' : 'alert'
    }`;

    // Create the icon SVG based on the type
    let icon =
        type === 'success'
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.200195 13C0.200195 5.93071 5.93095 0.199951 13.0002 0.199951C20.0694 0.199951 25.8002 5.93071 25.8002 13C25.8002 20.0692 20.0694 25.8 13.0002 25.8C5.93095 25.8 0.200195 20.0692 0.200195 13ZM13.0002 1.79995C6.81461 1.79995 1.8002 6.81436 1.8002 13C1.8002 19.1855 6.81461 24.2 13.0002 24.2C19.1858 24.2 24.2002 19.1855 24.2002 13C24.2002 6.81436 19.1858 1.79995 13.0002 1.79995ZM19.6179 8.4572C19.93 8.76995 19.9294 9.27648 19.6167 9.58857L11.6452 17.5429C11.3327 17.8547 10.8266 17.8544 10.5145 17.5422L7.4497 14.4775C7.13728 14.1651 7.13728 13.6585 7.4497 13.3461C7.76212 13.0337 8.26865 13.0337 8.58107 13.3461L11.0808 15.8458L18.4865 8.45598C18.7993 8.1439 19.3058 8.14444 19.6179 8.4572Z" fill="#17B26A"/></svg>'
            : '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 16C1 7.71573 7.71573 1 16 1C24.2843 1 31 7.71573 31 16C31 24.2843 24.2843 31 16 31C7.71573 31 1 24.2843 1 16Z" stroke="#F04438" stroke-width="2"/><path fill-rule="evenodd" clip-rule="evenodd" d="M9.41475 9.41475C9.63442 9.19508 9.99058 9.19508 10.2102 9.41475L16 15.2045L21.7898 9.41475C22.0094 9.19508 22.3656 9.19508 22.5852 9.41475C22.8049 9.63442 22.8049 9.99058 22.5852 10.2102L16.7955 16L22.5852 21.7898C22.8049 22.0094 22.8049 22.3656 22.5852 22.5852C22.3656 22.8049 22.0094 22.8049 21.7898 22.5852L16 16.7955L10.2102 22.5852C9.99058 22.8049 9.63442 22.8049 9.41475 22.5852C9.19508 22.3656 9.19508 22.0094 9.41475 21.7898L15.2045 16L9.41475 10.2102C9.19508 9.99058 9.19508 9.63442 9.41475 9.41475Z" fill="#F04438" stroke="#F04438" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    // Set the inner HTML of the toast div
    toastDiv.innerHTML = `
        <i class="uc-toastr_icon">${icon}</i>
        <span class="uc-toastr_content">${message}</span>
    `;

    // Append the toast div to the body
    document.body.appendChild(toastDiv);

    // Remove the toast after 3 seconds
    setTimeout(function () {
        document.body.removeChild(toastDiv);
    }, 3000);
}

window.addEventListener('closeModal', function () {
    closeModal();
});

window.addEventListener('showToast', function (event) {
    let message = event.detail.message;
    let type = event.detail.type;
    showToast(type, message);
});

document.addEventListener("DOMContentLoaded", (event) => {
    jQuery(document).on('click', '.uc-sidebar_toggler', function() {
       jQuery('.uc-sidebar_wrap').toggleClass('us-togglesidebar');
    });
    jQuery(document).on('click', '.uc-sidebar_toggler', function() {
       jQuery('.uc-main-content').toggleClass('uc-main-content_fullwidth');
    });
});