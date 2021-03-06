@extends('admin.layouts.default')

@section('title', 'Admin')

@section('title-page', 'Pages')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pages</h2>
                    <div class="clearfix"></div>
                    @if( session('success') )
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <textarea name="content" id="" cols="30" rows="10">{{ $page->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>

                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
@endsection                                                                    