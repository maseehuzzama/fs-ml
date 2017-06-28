@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">All Neighbours</a>
                    </li>
                    <li>
                        <a  href="#2a" data-toggle="tab">New</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>All Neighbours</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#ID</a></th>
                                    <th><a href="#">Name</a></th>
                                    <th><a href="#">Region</a></th>
                                    <th><a href="#">City</a></th>
                                    <th><a href="#">Edit</a></th>
                                </tr>
                                @foreach($neighbors as $item)
                                    <tr>
                                        <td>{{$item->id}}&nbsp;</td>
                                        <td>{{$item->name}}&nbsp;</td>
                                        <td>{{@$item->regions->name}}</td>
                                        <td>{{$item->city}}&nbsp;</td>
                                        <td><a href="{{route('admin.cms.edit-neighbor',[$item->id,App::getLocale()])}}">Edit</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="tab-pane" id="2a">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">New Neighbour</div>
                                    <div class="panel-body">
                                        <form method="post" action="{{route('admin.cms.new-neighbor',App::getLocale())}}">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="amount">Name</label>
                                                <input type="text" id="name" name="name"  class="form-control" required="required" placeholder="Name">
                                            </div>

                                            <div class="form-group">
                                                <label for="region">City</label>
                                                <select id="city" name="city" class="form-control">
                                                    <option value="">Select City</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->name}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <script>
                                                $('#city').on('change',function(e){
                                                    console.log(e);
                                                    var city = e.target.value;
                                                    $.get('../../../ajax-get-regions?city=' +city, function(data){
                                                        $('#region').empty();
                                                        $.each(data, function(index, obj){
                                                            $('#region').append('<option value="'+obj.id+'">'+obj.name+'</option>');
                                                        })
                                                    });
                                                });
                                            </script>

                                            <div class="form-group">
                                                <label for="region">Region</label>
                                                <select id="region" name="region" class="form-control">
                                                    <option value="">Select Region</option>
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