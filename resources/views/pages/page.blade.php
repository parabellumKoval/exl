@extends('layouts.app')

@section('meta_title', $page->seo['meta_title'] ?? null)
@section('meta_description', $page->seo['meta_description'] ?? null)

@section('content')
  {!! $page->content !!}
@endsection