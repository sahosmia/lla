@extends('layouts.frontend-app')
@section('content')
<div class="tb-translator">
    <form class="tb-themeform">
        <fieldset>
            <div class="form-group-wrap">
                <div class="form-group">
                    <label class="tb-label">Language</label>
                    <select class="form-control">
                        <option value="english">English</option>
                        <option value="arabic">Arabic</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="op-textcontent">
                        <div class="op-switchbtn">
                            <input type="checkbox" id="translate" class="op-input-field  ">
                            <label for="translate" class="op-textdes">
                                <span>Translate specific files</span>
                            </label>
                        </div>
                        <span>Enable translation</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="tb-checkbox">
                        <input id="page-1" value="1" type="checkbox">
                        <label for="page-1">password</label>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
@endsection