@extends(config('pagebuilder.layout'))

@push(config('pagebuilder.style_var'))
<link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/feather-icons.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/pagebuilder/css/pages.css') }}">
@endpush

@section(config('pagebuilder.section'))
<div class="pb-preloader-outer">
    <img src="{{ asset('vendor/pagebuilder/images/lb-loader.png')}}" alt="#">
</div>

<div class="lb-bodywraper">
    <div class="lb-container">
        <div class="lb-row">
            <div class="lb-col-4" id="add_edit_section">
                @component('pagebuilder::components.update-page',['edit'=>$edit,'page'=>$page??null])@endcomponent
            </div>
            <div class="lb-col-8">
                <div class="tb-dhb-mainheading">
                    <h4> {{ __('pagebuilder::pagebuilder.pages') }}</h4>
                    <div class="tb-sortby">
                        <form class="tb-themeform tb-displistform">
                            <fieldset>
                                <div class="tb-themeform__wrap">
                                    <div class="form-group tb-actionselect">
                                        <div class="lb-select">
                                            <select class="form-control" id="filter_sort">
                                                <option value="asc">{{ __('pagebuilder::pagebuilder.asc') }}</option>
                                                <option value="desc">{{ __('pagebuilder::pagebuilder.desc') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group tb-actionselect">
                                        <div class="lb-select">
                                            <select class="form-control" id="filter_per_page">
                                                @foreach($per_page_opt as $opt ){
                                                <option value="{{$opt}}">{{$opt}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group tb-inputicon tb-inputheight">
                                        <i class="icon-search"></i>
                                        <input id="filter_search" type="text" class="form-control" autocomplete="off"
                                            placeholder="{{ __('pagebuilder::pagebuilder.search') }}">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="tb-disputetable tb-pagessetting" id="pages_list">
                    @component('pagebuilder::components.pages-skeleton')@endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
<div id="skeleton" class="pb-d-none">
    @component('pagebuilder::components.pages-skeleton')@endcomponent
</div>



@endsection
@push(config('pagebuilder.script_var'))
<script src="{{ asset('vendor/optionbuilder/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/optionbuilder/js/jquery-confirm.min.js') }}"></script>
<script>
    jQuery(window).on("load", function() {
        jQuery(".pb-preloader-outer").delay(100).fadeOut();
        getPages();
    });

    var status = 'draft';

    function showAlert(data) {

        let { title, message, type, autoclose, redirectUrl } = data;

        let alertIcon = 'ti-face-sad';
        let alertType = 'dark';

        if (type === 'success') {
            alertIcon = 'icon-check';
            alertType = 'green';
        } else if (type === 'error') {
            alertIcon = 'icon-x';
            alertType = 'red';
        }

        $.confirm({
            icon: alertIcon,
            closeIcon: function () {
                if (redirectUrl) {
                    return 'close';
                } else {
                    return true;
                }
            },
            theme: 'modern',
            animation: 'scale',
            type: alertType, //red, green, dark, orange
            title,
            content: message,
            autoClose: 'close|' + autoclose,
            buttons: {
                close: {
                    btnClass: 'tb-sticky-alert',
                    action: function () {
                        if (redirectUrl) {
                            location.href = redirectUrl;
                        }
                    },
                }
            }
        });
    }

    function getPages(page = 1){
        $.ajax({
        type:'GET',
        url:'{{route("pagebuilder")}}',
        data:{'page': page, 'sort':$('#filter_sort').val(), 'per_page': $('#filter_per_page').val(), 'search': $('#filter_search').val()},
        dataType:'json',
        success:function(data){
                if( data.success ){
                    $('#pages_list').html(data.html);
                }
            }
        });
    }

    function showAlert(data) {

        let { title, message, type, autoclose, redirectUrl } = data;

        let alertIcon = 'ti-face-sad';
        let alertType = 'dark';

        if (type === 'success') {
            alertIcon = 'icon-check';
            alertType = 'green';
        } else if (type === 'error') {
            alertIcon = 'icon-x';
            alertType = 'red';
        }

        $.confirm({
            icon: alertIcon,
            closeIcon: function () {
                if (redirectUrl) {
                    return 'close';
                } else {
                    return true;
                }
            },
            theme: 'modern',
            animation: 'scale',
            type: alertType, //red, green, dark, orange
            title,
            content: message,
            autoClose: 'close|' + autoclose,
            buttons: {
                close: {
                    btnClass: 'tb-sticky-alert',
                    action: function () {
                        if (redirectUrl) {
                            location.href = redirectUrl;
                        }
                    },
                }
            }
        });
    }

    function getPages(page = 1){
        $.ajax({
        type:'GET',
        url:'{{route("pagebuilder")}}',
        data:{'page': page, 'sort':$('#filter_sort').val(), 'per_page': $('#filter_per_page').val(), 'search': $('#filter_search').val()},
        dataType:'json',
        success:function(data){
                if( data.success ){
                    $('#pages_list').html(data.html);
                }
            }
        });
    }

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
    
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
    });

    $(document).on('click', '.goto-page',  function(){
        getPages($(this).data('page'));
    });

    $(document).on('change', '#filter_sort',  function(){
        getPages();
    });
    
    $(document).on('change', '#filter_per_page',  function(){
        getPages();
    });
    
    let keyupTimer;
    $("#filter_search").keyup(function () {
        clearTimeout(keyupTimer);
        keyupTimer = setTimeout(function () {
            getPages();
        }, 300);
    });
    
    $(document).on('click', '#page_edit_btn',  function(){
        var url = '{{route("page.edit", "page_id")}}';
        url = url.replace('page_id', $(this).data('page-id'))

        $.ajax({
            type:'GET',
            url:url,
            data:{},
            dataType:'json',
            success:function(data){
                    if( data.success ){
                        status = data.status;
                        $('#add_edit_section').html(data.html)
                    }
                }
        });
    });

    $(document).on('click', '.tb-checkaction', function(event){
        let _this = $(this);
        if(_this.is(':checked')){
            _this.parent().find('#tb-textdes').html("{{__('pagebuilder::pagebuilder.active')}}");
            status = 'published';
        } else {
            _this.parent().find('#tb-textdes').html( "{{__('pagebuilder::pagebuilder.deactive')}}");
            status = 'draft';
        }
    });

    $(document).on('submit', '#page_form', function(event){
            event.preventDefault();
            var update_text = '{{ __("pagebuilder::pagebuilder.updated_successfully") }}';
            if($('#id').val() === undefined)
            var update_text = '{{ __("pagebuilder::pagebuilder.added_successfully") }}';

            var data = $('#page_form').serializeArray();
            data.push({'name': 'status', 'value': status});
            $.ajax({
            type:'POST',
            url:'{{route("page.store")}}',
            data:{data: data},
            async:false,
            dataType:'json',
            success:function(data){
                if (data.success == 'demo'){
                    showAlert({
                        message     : '{{__("pagebuilder::pagebuilder.demosite_res_title")}}',
                        type        : 'error',
                        title       : '{{__("pagebuilder::pagebuilder.demosite_res_txt")}}' ,
                        autoclose   :  3000,
                    });
                    return;
                }
                
                if( data.success ){
                    getPages($('#current_page').val());
                    loadAddPage();
                    showAlert({
                        message     : update_text,
                        type        : 'success',
                        title       : '{{__("pagebuilder::pagebuilder.success")}}' ,
                        autoclose   :  3000,
                    });
                }else{
                    let message = '';
                    data.error.forEach(function(item){
                        message += item;
                    });
                    showAlert({
                        message     : message,
                        type        : 'error',
                        title       : '{{__("pagebuilder::pagebuilder.alert_error_title")}}' ,
                        autoclose   :  3000,
                    });
                }
            }
        });
    });

    $(document).on('click','.goBack',function(){
        loadAddPage();
    });

    $(document).on('click','.deletePage',function(){
        let pageId = $(this).data('page-id');
        $.confirm({
            title: '{{ __("pagebuilder::pagebuilder.confirm") }}',
            content: '{{ __("pagebuilder::pagebuilder.confirm_content") }}',
            type: 'red',
            icon: "icon-alert-circle",
            closeIcon: true,
            typeAnimated: false,
            buttons: {
                Yes: {
                    btnClass: "btn-danger",
                    action: function () {
                        deletePage(pageId);
                    },
                },
                No: function () {},
            },
        });
    });

    function deletePage(id){
        var url = '{{route("page.delete","pageId")}}';
        url = url.replace("pageId",id);
        $.ajax({
        type:'DELETE',
        url:url,
        dataType:'json',
        success:function(data){
                if (data.success == 'demo'){
                        showAlert({
                            message     : '{{__("pagebuilder::pagebuilder.demosite_res_title")}}',
                            type        : 'error',
                            title       : '{{__("pagebuilder::pagebuilder.demosite_res_txt")}}' ,
                            autoclose   :  3000,
                        });
                        return;
                    }
                if( data.success ){
                    showAlert({
                        message     : '{{__("pagebuilder::pagebuilder.deleted_successfully")}}',
                        type        : 'success',
                        title       : '{{__("pagebuilder::pagebuilder.success")}}' ,
                        autoclose   :  3000,
                    });
                    getPages($('#current_page').val());
                }
            }
        });
    }

    function loadAddPage(){
        $.ajax({
            type:'GET',
            url:'{{route("page.create")}}',
            dataType:'json',
            success:function(data){
                if( data.success ){
                    $('#add_edit_section').html(data.html)
                    status = 'draft';
                }
            }
        });
    }
</script>
@endpush