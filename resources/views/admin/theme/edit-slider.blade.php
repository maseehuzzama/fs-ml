@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="tab-content clearfix">

                    <div class="tab-pane fade active in" id="2a">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">Edit Slider</div>
                                <div class="panel-body">
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form method="post" action="{{route('admin.theme.edit-slide',[$slide->id,App::getLocale()])}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="input-info">
                                            <h3>Enter Fields</h3>
                                        </div>


                                        <div class="form-group">
                                            <label for="amount">Slide Number</label>
                                            <input type="number" id="number" name="number"  class="form-control" value="{{$slide->slide_number}}" required="required">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Title</label>
                                            <input type="text" id="title" name="title"  class="form-control" value="{{$slide->title}}" required="required">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Title Arabic</label>
                                            <input type="text" id="title_ar" name="title_ar" class="form-control" value="{{$slide->title_ar}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="amount">Tagline</label>
                                            <input type="text" id="tagline" name="tagline"  class="form-control" value="{{$slide->tagline}}" required="required" >
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Tagline Arabic</label>
                                            <input type="text" id="tagline_ar" name="tagline_ar" value="{{$slide->tagline_ar}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Link Name</label>
                                            <input type="text" id="link_name" name="link_name"  class="form-control" value="{{$slide->link_name}}" required="required" >
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Link Name Arabic</label>
                                            <input type="text" id="link_name_ar" name="link_name_ar" value="{{$slide->link_name_ar}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="link">Link</label>
                                            <input type="text" id="link" name="link" value="{{$slide->link}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Keywords</label>
                                            <input type="text" id="keywords" name="keywords" value="{{$slide->keywords}}" class="form-control" >
                                        </div>

                                        <div class="form-group">
                                            <label for="amount">Slider Image</label>
                                            <input type="file" id="image" name="image" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection