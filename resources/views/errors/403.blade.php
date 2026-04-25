@extends('errors::minimal')

@section('title', __('general.403_title'))
@section('heading', __('general.403_heading'))
@section('code', '403')
@section('img', asset('images/error/403.png'))
@section('message', __($exception->getMessage() ?: 'Forbidden'))
