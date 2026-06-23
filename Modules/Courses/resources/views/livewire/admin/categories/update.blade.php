<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5>
                 {{ $editMode ? __('category.update_category') : __('category.add_category') }}
            </h5>
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform tk-form-blogcategories">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label">{{ __('category.title') }}</label>
                            <input type="text" class="form-control @error('name') tk-invalid @enderror"   wire:model.defer="name" required placeholder="{{ __('category.title') }}">
                            @error('name')
                                <div class="tk-errormsg">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        {{-- @if(!empty($categories_tree)) --}}
                            <div class="form-group" wire:ignore>
                                <label class="tb-titleinput">{{ __('category.parent_category') }}</label>
                                <input class="from-control" type="text" id="category_dropdown-{{time()}}" placeholder="{{ __('category.parent_category') }}" autocomplete="off"/>
                            </div>
                        {{-- @endif --}}

                        <div class="form-group">
                            <label class="tb-label">{{ __('category.description') }}</label>
                            <textarea class="form-control" placeholder="{{ __('category.description') }}" wire:model.defer="description" id=""></textarea>
                        </div>
                        @if($editMode)
                            <div class="form-group">
                                <label class="tb-label">{{ __('general.status') }}:</label>
                                <div class="tb-email-status">
                                    <span> {{__('category.category_status')}} </span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes">{{ $status == 'active' ? __('general.active') : __('general.deactive') }}</span></label>
                                        <input wire:change="updateStatus($event.target.checked)" {{ $status == 'active' ? 'checked' : '' }} class="tb-checkaction" type="checkbox" id="tb-emailstatus">
                                    </div>
                                </div>
                                @error('status') 
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                {{ $editMode ? __('category.update_category') : __('category.add_category') }}
                            </a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.tb-themeselect .tb-select', function(event) {
                event.stopPropagation();
                $(document).find('.tb-categorytree-dropdown').addClass('tk-custom-scrollbar');
                $(this).next(".tb-themeselect_options").slideToggle();                
            });

            $(document).on('click', '.tb-themeselect_options li label', function(event) {
                let listText = jQuery(this).text();
                $('.tb-themeselect_value').text(listText);
                $('.tb-themeselect_value').addClass('tk-selected');
                $(this).parents(".tb-themeselect_options").slideUp();
                $('.tb-categorytree-dropdown').mCustomScrollbar('destroy');
            });

            $(document).on('click', '.tb-checkaction', function(event){
                let _this = $(this);
                let status = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("{{__('general.active')}}");
                    status = 'active';
                } else {
                    _this.parent().find('#tb-textdes').html( "{{__('general.deactive')}}");
                    status = 'deactive';
                }
                @this.set('status', status, true);
            });

        });
    </script>
@endpush