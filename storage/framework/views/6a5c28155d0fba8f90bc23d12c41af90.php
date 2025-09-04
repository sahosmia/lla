<div class="am-profile-setting" wire:init="loadData" wire:key="window.Livewire.find('<?php echo e($_instance->getId()); ?>')">
    <?php $__env->slot('title'); ?>
        <?php echo e(__('subject.subject_title')); ?>

    <?php $__env->endSlot(); ?>
    <?php echo $__env->make('livewire.pages.tutor.manage-sessions.tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div x-data="{search:'', sessionData: <?php if ((object) ('form') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'->value()); ?>')<?php echo e('form'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'); ?>')<?php endif; ?>}" class="am-userperinfo">
        <!--[if BLOCK]><![endif]--><?php if($isLoading): ?>
            <?php echo $__env->make('skeletons.manage-subject', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php if($subjectGroups->isNotEmpty()): ?>
                <div class="am-title_wrap">
                    <div class="am-title">
                        <h2><?php echo e(__('subject.subject_title')); ?></h2>
                        <p><?php echo e(__('subject.subject_title_desc')); ?></p>
                    </div>
                    <button class="am-btn am-btnsmall" @click="search = ''; $nextTick(() => $wire.call('addNewSubjectGroup'))" wire:target="addNewSubjectGroup">
                        <?php echo e(__('general.add_new')); ?>

                        <i class="am-icon-plus-02"></i>
                    </button>
                </div>
                <div id="subjectList" wire:sortable="updateSubjectGroupOrder" wire:sortable-group="updateSubjectOrder" class="am-subjectlist">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjectGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="am-subject" wire:sortable.item="<?php echo e($group?->id); ?>" wire:key="subject-group-<?php echo e($group?->id); ?>">
                            <div class="am-subject-heading">
                                <div class="am-sotingitem" wire:sortable.handle>
                                    <i class="am-icon-youtube-1"></i>
                                </div>
                                <div wire:ignore.self class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-subject-title', 'collapsed' => $index != 0]); ?>" id="heading-<?php echo e($group?->id); ?>" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($group?->id); ?>" aria-expanded="<?php echo e($index == 0 ? 'true': 'false'); ?>">
                                    <h3><?php echo e($group->group->name); ?></h3>
                                    <span class="am-subject-title-icon">
                                        <i class="am-icon-minus-02 am-subject-title-icon-open"></i>
                                        <i class="am-icon-plus-02 am-subject-title-icon-close"></i>
                                    </span>
                                </div>
                                <div class="am-itemdropdown">
                                    <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="am-icon-ellipsis-horizontal-02"></i>
                                    </a>
                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            <a href="javascript:void(0);" @click="search = ''; $nextTick(() => $wire.call('addNewSubjectGroup'))">
                                                <i class="am-icon-pencil-02"></i>
                                                <?php echo e(__('general.edit')); ?>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="am-del-btn" @click="$wire.dispatch('showConfirm', { groupId: <?php echo e($group?->id); ?>, action : 'delete-user-subject-group' })">
                                                <i class="am-icon-trash-02"></i>
                                                <?php echo e(__('general.delete')); ?>

                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div wire:ignore.self id="collapse-<?php echo e($group?->id); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['collapse', 'show' => $index == 0]); ?>" data-bs-parent="#subjectList">
                                <div class="am-subject-body">
                                    <!--[if BLOCK]><![endif]--><?php if($group?->subjects->count() > 0): ?>
                                        <ul class="am-subject-list" wire:sortable-group.item-group="<?php echo e($group?->id); ?>">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $group?->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li wire:key="subject-<?php echo e($subject?->pivot->id); ?>" wire:sortable-group.item="<?php echo e($subject?->pivot->id); ?>">
                                                    <div class="am-sotingitemtwo" wire:sortable-group.handle>
                                                        <i class="am-icon-youtube-1"></i>
                                                    </div>
                                                    <div class="am-subject-list_content">
                                                        <figure>
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($subject?->pivot?->image) && Storage::disk(getStorageDisk())->exists($subject?->pivot?->image)): ?>
                                                                <img src="<?php echo e(resizedImage($subject?->pivot?->image, 40, 40)); ?>" alt="<?php echo e($subject?->name); ?>">
                                                            <?php else: ?>
                                                                <img src="<?php echo e(resizedImage('placeholder.png', 40, 40)); ?>" alt="<?php echo e($subject?->name); ?>">
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </figure>
                                                        <div class="am-subject-info">
                                                            <div class="am-subject-info_content">
                                                                <div class="am-subject-detail">
                                                                    <div class="am-subject_content">
                                                                        <div class="am-subject_title">
                                                                            <h3><?php echo $subject?->name; ?></h3>
                                                                            <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                                                                <span><?php echo e(__('subject.hourly_rate')); ?> <em><?php echo e(formatAmount($subject?->pivot?->hour_rate ?? 0)); ?> </em></span>
                                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>
                                                                        <div class="am-itemdropdown">
                                                                            <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="am-icon-ellipsis-horizontal-02"></i>
                                                                            </a>
                                                                            <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                <li>
                                                                                    <a href="javascript:void(0);" @click="
                                                                                    sessionData.group_id    = <?php echo \Illuminate\Support\Js::from($group?->id)->toHtml() ?>;
                                                                                    sessionData.edit_id     = <?php echo \Illuminate\Support\Js::from($subject?->pivot?->id)->toHtml() ?>;
                                                                                    sessionData.subject_id  = <?php echo \Illuminate\Support\Js::from($subject?->pivot->subject_id)->toHtml() ?>;
                                                                                    sessionData.hour_rate   = <?php echo \Illuminate\Support\Js::from($subject?->pivot?->hour_rate)->toHtml() ?>;
                                                                                    sessionData.description = <?php echo \Illuminate\Support\Js::from($subject?->pivot?->description)->toHtml() ?>;
                                                                                    sessionData.sort_order  = <?php echo \Illuminate\Support\Js::from($subject?->pivot?->sort_order)->toHtml() ?>;
                                                                                    sessionData.image       = <?php echo \Illuminate\Support\Js::from($subject?->pivot?->image)->toHtml() ?>;
                                                                                    $wire.call('addNewSubject', <?php echo e($group?->id); ?>);
                                                                                    $nextTick(() => {
                                                                                        $wire.dispatch('initSummerNote', {target: '#subject_desc', wiremodel: 'form.description', conetent: <?php echo \Illuminate\Support\Js::from($subject?->pivot?->description)->toHtml() ?>, componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')});
                                                                                        $('.am-select2').prop('disabled', true);
                                                                                        clearFormErrors('#subject_modal form');
                                                                                    })
                                                                                    ">
                                                                                        <i class="am-icon-pencil-02"></i>
                                                                                        <?php echo e(__('general.edit')); ?>

                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:void(0);" class="am-del-btn" @click="$wire.dispatch('showConfirm', { groupId: <?php echo e($group?->id); ?>, subjectId : <?php echo e($subject?->pivot->id); ?>, action : 'delete-user-subject' })">
                                                                                        <i class="am-icon-trash-02"></i>
                                                                                        <?php echo e(__('general.delete')); ?>

                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($subject?->pivot?->description)): ?>
                                                                <p><?php echo $subject?->pivot?->description; ?></p>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </ul>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php if(!empty(array_diff_key($subjects, $this->getUserGroupSubject($group?->id)))): ?>
                                        <div class="am-addclasses-wrapper">
                                            <button
                                                class="am-add-class"
                                                @click="
                                                sessionData.edit_id = null;
                                                $wire.call('resetForm');
                                                $wire.call('addNewSubject', <?php echo e($group?->id); ?>);
                                                $nextTick(() => {
                                                    $wire.dispatch('initSummerNote', {target: '#subject_desc', wiremodel: 'form.description', componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')})
                                                    $('.am-select2').prop('disabled', false);
                                                    clearFormErrors('#subject_modal form');
                                                })"
                                            >
                                                <?php echo e(__('subject.add_new_subject')); ?>

                                                <i class="am-icon-plus-01"></i>
                                                <svg><rect width="100%" height="100%" rx="10"></rect></svg>
                                            </button>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/subjects.png'),'title' => __('general.no_record_title'),'description' => __('general.no_record_desc'),'btnText' => __('subject.add_new_subject'),'@click' => 'search = \'\'; $nextTick(() => $wire.call(\'addNewSubjectGroup\'))','wire:target' => 'addNewSubjectGroup']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/subjects.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_title')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_desc')),'btn_text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('subject.add_new_subject')),'@click' => 'search = \'\'; $nextTick(() => $wire.call(\'addNewSubjectGroup\'))','wire:target' => 'addNewSubjectGroup']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $attributes = $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $component = $__componentOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!-- Modals -->
        <div wire:ignore.self class="modal am-modal fade subject-group-modal" id="subject_group" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2><?php echo e(__('subject.add_subject_group')); ?></h2>
                        <span class="am-closepopup" data-bs-dismiss="modal">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform am-subject-form">
                            <fieldset>
                                <div class="form-group" x-data="{
                                    groups: <?php if ((object) ('groups') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('groups'->value()); ?>')<?php echo e('groups'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('groups'); ?>')<?php endif; ?>,
                                    selectedGroups: <?php if ((object) ('selected_groups') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('selected_groups'->value()); ?>')<?php echo e('selected_groups'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('selected_groups'); ?>')<?php endif; ?>,
                                    allSelected:false,
                                    updateSelectedGroups(evt) {
                                        this.allSelected = this.selectedGroups?.length == this.groups?.length;
                                    },
                                    toggleAll(isSelected) {
                                        this.selectedGroups = isSelected ? this.groups.map(group => group.id) : [];
                                    },
                                    removeGroup(id) {
                                        this.selectedGroups = this.selectedGroups.filter(item => item != id)
                                        this.allSelected = false;
                                    },
                                    get filteredGroups() {
                                        this.updateSelectedGroups();
                                        if(this.search){
                                            return this.groups.filter(group => group.name.toLowerCase().includes(this.search.toLowerCase()));
                                        } else {
                                            return this.groups;
                                        }
                                    }
                                }"
                                >
                                    <label class="am-label am-important">
                                        <?php echo e(__('subject.choose_subject_category')); ?>

                                    </label>
                                    <div class="am-select-days">
                                        <input type="text" class="form-control am-input-field" x-model="search" @input.debounce.300ms="$event.target.dispatchEvent(new Event('input'))" data-bs-auto-close="outside" placeholder="<?php echo e(__('calendar.select_from_list')); ?>" data-bs-toggle="dropdown">
                                        <div class="dropdown-menu">
                                            <template x-if="filteredGroups.length > 0">
                                                <div>
                                                    <div class="am-checkbox">
                                                        <input type="checkbox" x-model="allSelected" id="select-all" name="group" @change="toggleAll($event.target.checked)">
                                                        <label for="select-all"><?php echo e(__('subject.select_all_subject_groups')); ?></label>
                                                    </div>

                                                    <template x-for="group in filteredGroups" :key="group.id">
                                                        <div class="am-checkbox">
                                                            <input type="checkbox" :id="'group-' + group.id" :value="group.id" x-model="selectedGroups" @change="updateSelectedGroups" />
                                                            <label :for="'group-' + group.id" x-text="group.name"></label>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="filteredGroups.length === 0">
                                                <li><?php echo e(__('general.no_record_found')); ?></li>
                                            </template>
                                        </div>
                                    </div>
                                    <template x-if="selectedGroups.length > 0">
                                        <ul class="am-subject-tag-list">
                                            <template x-for="id in selectedGroups">
                                                <li>
                                                    <a href="javascript:void(0)" class="am-subject-tag" @click="removeGroup(id)">
                                                        <span x-text="groups.find(item => item.id == id)?.['name']"></span>
                                                        <i class="am-icon-multiply-02"></i>
                                                    </a>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'selected_groups']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'selected_groups']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                                <div class="form-group am-mt-10 am-form-btn-wrap">
                                    <button wire:click.prevent="seveSubjectGroups" wire:click.prevent="seveSubjectGroups" wire:target="seveSubjectGroups" wire:loading.class="am-btn_disable" class="am-btn"><?php echo e(__('general.save_update')); ?></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- education modal -->
        <div wire:ignore.self class="modal am-modal fade am-subject_modal" id="subject_modal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <template x-if="sessionData.edit_id">
                            <h2><?php echo e(__('subject.edit_subject')); ?></h2>
                        </template>
                        <template x-if="sessionData.edit_id == ''">
                            <h2><?php echo e(__('subject.add_subject')); ?></h2>
                        </template>
                        <span class="am-closepopup" wire:target="saveNewSubject" data-bs-dismiss="modal" wire:loading.attr="disabled">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform am-modal-form">
                            <fieldset>
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('form.subject_id')]); ?>">
                                    <label class="am-label am-important" for="subjects">
                                        <?php echo e(__('subject.choose_subject')); ?>

                                    </label>
                                    <span class="am-select" wire:ignore>
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent="#subject_modal" data-searchable="true" id="subjects" data-wiremodel="form.subject_id" data-placeholder="<?php echo e(__('subject.select_subject')); ?>"></select>
                                    </span>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.subject_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.subject_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('form.hour_rate')]); ?>">
                                        <label class="am-label am-important"><?php echo e(__('subject.session_price')); ?></label>
                                        <div class="am-inputfield">
                                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['wire:model' => 'form.hour_rate','placeholder' => ''.e(getCurrencySymbol().'0.00').'','type' => 'number']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'form.hour_rate','placeholder' => ''.e(getCurrencySymbol().'0.00').'','type' => 'number']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                            <span class="am-inputfield_icon"><?php echo e(getCurrencySymbol()); ?></span>
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.hour_rate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.hour_rate']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('form.description')]); ?>">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['class' => 'am-important','for' => 'introduction','value' => __('subject.breif_introduction')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'am-important','for' => 'introduction','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('subject.breif_introduction'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <div class="am-custom-editor" wire:ignore>
                                            <textarea id="subject_desc" class="form-control" placeholder="<?php echo e(__('subject.add_introduction')); ?>"><?php echo e($form->description); ?></textarea>
                                        <span class="characters-count"></span>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'Profile1','value' => __('general.upload_image')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'Profile1','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.upload_image'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-profile-<?php echo e(time()); ?>">
                                        <div class="tk-draganddrop"
                                            x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }"
                                            x-on:drop.prevent="isUploading = true; isDragging = false"
                                            wire:drop.prevent="$upload('form.image', $event.dataTransfer.files[0])">
                                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['name' => 'file','type' => 'file','id' => 'at_upload_cover_photo','xRef' => 'file_upload','accept' => ''.e(!empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*').'','xOn:change' => 'isUploading = true; $wire.upload(\'form.image\', $refs.file_upload.files[0])']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file','type' => 'file','id' => 'at_upload_cover_photo','x-ref' => 'file_upload','accept' => ''.e(!empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*').'','x-on:change' => 'isUploading = true; $wire.upload(\'form.image\', $refs.file_upload.files[0])']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>

                                            <label for="at_upload_cover_photo" class="am-uploadfile">
                                                <span class="am-dropfileshadow">
                                                    <svg class="am-border-svg "><rect width="100%" height="100%" rx="12"></rect></svg>
                                                    <i class="am-icon-plus-02"></i>
                                                    <span class="am-uploadiconanimation">
                                                        <i class="am-icon-upload-03"></i>
                                                    </span>
                                                    <?php echo e(__('general.drop_file_here')); ?>

                                                </span>
                                                <em>
                                                    <i class="am-icon-export-03"></i>
                                                </em>
                                                <span><?php echo e(__('general.drop_file')); ?> <i><?php echo e(__('general.click_here_file')); ?></i> <?php echo e(__('general.to_upload')); ?> <em><?php echo e(allowFileExt($allowImgFileExt)); ?> (<?php echo e(__('general.max') .$allowImageSize.'MB'); ?>)</em></span>
                                            </label>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($form->image)): ?>
                                            <div class="am-uploadedfile">
                                                <!--[if BLOCK]><![endif]--><?php if( !empty($form->image) && method_exists($form->image,'temporaryUrl')): ?>
                                                    <img src="<?php echo e($form->image->temporaryUrl()); ?>">
                                                <?php elseif(!empty($form->image) && Storage::disk(getStorageDisk())->exists($form->image)): ?>
                                                    <img src="<?php echo e(Storage::url($form->image)); ?>">
                                                <?php else: ?>    
                                                    <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form->image))); ?>">
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                <!--[if BLOCK]><![endif]--><?php if( !empty($form->image) && method_exists($form->image,'getClientOriginalName')): ?>
                                                    <span><?php echo e($form->image->getClientOriginalName()); ?></span>
                                                <?php else: ?>
                                                    <span><?php echo e(basename(parse_url(url(Storage::url($form->image)), PHP_URL_PATH))); ?></span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                <a href="#" wire:click.prevent="removeImage" class="am-delitem">
                                                    <i class="am-icon-trash-02"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.image']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.image']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group am-mt-10 am-form-btn-wrap">
                                    <button class="am-btn" wire:click.prevent="saveNewSubject" wire:target="saveNewSubject" wire:loading.class="am-btn_disable"><?php echo e(__('general.save_update')); ?></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/summernote/summernote-lite.min.css',
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/livewire-sortable.js')); ?>"></script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/tutor/manage-sessions/manage-subjects.blade.php ENDPATH**/ ?>