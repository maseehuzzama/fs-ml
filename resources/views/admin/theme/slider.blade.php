@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">All Slides</a>
                    </li>

                    <li>
                        <a  href="#2a" data-toggle="tab">New Slide</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>All Slides</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#S.NO</a></th>
                                    <th><a href="#">Title</a></th>
                                    <th><a href="#">Tagline</a></th>
                                    <th><a href="#">Link Name</a></th>
                                    <th><a href="#">Image</a></th>
                                    <th>Actions</th>
                                </tr>
                                @foreach($slides as $item)
                                    <tr>
                                        <td>{{$item->slide_number}}&nbsp;</td>
                                        <td>{{$item->title}}&nbsp;</td>
                                        <td>{{$item->tagline}}&nbsp;</td>
                                        <td>{{$item->link_name}}&nbsp;</td>
                                        <td>{{$item->image}}&nbsp;</td>
                                        <td class="actions">
                                            <a href="{{route('admin.theme.delete-slide',[$item->id,App::getLocale()])}}" onclick="return confirm('Sure?')" class="label label-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="tab-pane fade" id="2a">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">New Slide</div>
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
                                    <form method="post" action="{{route('admin.theme.new-slide',App::getLocale())}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label for="amount">Slide Number</label>
                                            <input type="number" id="number" name="number"  class="form-control" value="{{old('number')}}" required="required">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Title</label>
                                            <input type="text" id="title" name="title"  class="form-control" value="{{old('title')}}" required="required">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Title Arabic</label>
                                            <input type="text" id="title_ar" name="title_ar" class="form-control" value="{{old('title_ar')}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="amount">Tagline</label>
                                            <input type="text" id="tagline" name="tagline"  class="form-control" value="{{old('tagline')}}" required="required" >
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Tagline Arabic</label>
                                            <input type="text" id="tagline_ar" name="tagline_ar" value="{{old('tagline_ar')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Link Name</label>
                                            <input type="text" id="link_name" name="link_name"  class="form-control" value="{{old('link_name')}}" required="required" >
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Link Name Arabic</label>
                                            <input type="text" id="link_name_ar" name="link_name_ar" value="{{old('link_name_ar')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="link">Link</label>
                                            <input type="text" id="link" name="link" value="{{old('link')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Keywords</label>
                                            <input type="text" id="keywords" name="keywords" value="{{old('keywords')}}" class="form-control" >
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