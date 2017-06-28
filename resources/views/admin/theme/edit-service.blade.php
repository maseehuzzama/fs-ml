@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="tab-content clearfix">

                    <div class="tab-pane fade active in" id="2a">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">Edit Service</div>
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
                                    <form method="post" action="{{route('admin.theme.edit-service',[$service->id,App::getLocale()])}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="input-info">
                                            <h3>Enter Fields</h3>
                                        </div>


                                        <label for="service_name">Service Name: (required)&nbsp;<span class="at-required-highlight">*</span></label>
                                        <div class="form-group{{ $errors->has('service_name') ? ' has-error' : '' }}">
                                            <input type="text" name="service_name" id="service_name" required="true" class="form-control" value="{{old('service_name') ? old('service_name') : $service->service_name}}">
                                            @if ($errors->has('service_name'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('service_name') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        <label for="service_name_ar">Service Name Arabic: (required) &nbsp; <span class="at-required-highlight">*</span></label>
                                        <div class="form-group{{ $errors->has('service_name_ar') ? ' has-error' : '' }}">
                                            <input type="text" name="service_name_ar" id="service_name_ar" class="form-control" value="{{old('service_name_ar') ? old('service_name_ar') : $service->service_name_ar}}">
                                            @if ($errors->has('service_name_ar'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('service_name_ar') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        <label for="service_description">Service Description: (required) &nbsp; <span class="at-required-highlight">*</span></label>
                                        <div class="form-group{{ $errors->has('service_description') ? ' has-error' : '' }}">
                                            <textarea name="service_description" id="service_description" class="form-control" rows="5">{{old('service_description') ? old('service_description') : $service->service_description}}</textarea>
                                            @if ($errors->has('service_description'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('service_description') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        <label for="service_description_ar">Service Description Arabic: (required) &nbsp; <span class="at-required-highlight">*</span></label>
                                        <div class="form-group{{ $errors->has('service_description_ar') ? ' has-error' : '' }}">
                                            <textarea name="service_description_ar" id="service_description_ar" class="form-control" rows="5">{{old('service_description_ar') ? old('service_description_ar') : $service->service_description_ar}}</textarea>
                                            @if ($errors->has('service_description_ar'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('service_description_ar') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        <label for="service_number">Service Number: (required)&nbsp;<span class="at-required-highlight">*</span></label>
                                        <div class="form-group{{ $errors->has('service_number') ? ' has-error' : '' }}">
                                            <input type="number" name="service_number" id="service_number"   class="form-control" value="{{old('service_number') ? old('service_number') : $service->service_number}}">
                                            @if ($errors->has('service_number'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('service_number') }}</strong>
                                        </span>
                                            @endif
                                        </div>


                                        <label for="keywords">Keywords: (recommended)</label>
                                        <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
                                            <input type="text" name="keywords" id="keywords" class="form-control" value="{{old('keywords') ? old('keywords') : $service->keywords}}">
                                            @if ($errors->has('keywords'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('keywords') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                        <label for="service_icon">Service Icon: Fa Icon</label>
                                        <div class="form-group{{ $errors->has('service_icon') ? ' has-error' : '' }}">
                                            <input type="text" name="service_icon" id="service_icon" class="form-control" value="{{$service->service_icon}}" required>
                                            @if ($errors->has('service_icon'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('service_icon') }}</strong>
                                        </span>
                                            @endif
                                        </div>


                                        <label for="service_image">Service Image: (required)&nbsp;<span class="at-required-highlight">*</span></label>
                                        <div class="form-group{{ $errors->has('service_image') ? ' has-error' : '' }}">
                                            <input type="file" name="service_image" id="service_image"  class="form-control">
                                            @if ($errors->has('service_image'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('service_image') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <hr>
                                        <p>
                                            <input type="submit" name="sub-1" value="Submit" class="btn btn-primary">
                                            <input type="reset" name="res-1" id="res-1" value="Reset" class="btn btn-danger">
                                        </p>
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