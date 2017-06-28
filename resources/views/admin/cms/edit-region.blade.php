@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">Edi Region</div>
                                    <div class="panel-body">
                                        <form method="post" action="{{route('admin.cms.edit-region',[$region->id,App::getLocale()])}}">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="amount">Name</label>
                                                <input type="text" id="name" name="name"  class="form-control" required="required" value="{{$region->name}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="region">City</label>
                                                <select id="city" name="city" class="form-control" required>
                                                    <option value="{{$region->city}}">{{$region->city}}</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->name}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" name="country" value="SA">
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