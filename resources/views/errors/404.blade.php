@extends('errors::minimal')

@section('title', __('general.404_title'))
@section('heading', __('general.went_wrong'))
@section('code', '404')
@section('img', asset('images/error/404.png'))
@section('message', __('general.went_wrong_dec'))
