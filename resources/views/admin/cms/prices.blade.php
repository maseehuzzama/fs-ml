@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">All Prices</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>All Prices</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#ID</a></th>
                                    <th><a href="#">Service Name</a></th>
                                    <th><a href="#">Service Type</a></th>
                                    <th><a href="#">Service Code</a></th>
                                    <th><a href="#">Price</a></th>
                                    <th>Actions</th>
                                </tr>
                                @foreach($prices as $item)
                                    <tr>
                                        <td>{{$item->id}}&nbsp;</td>
                                        <td>{{$item->service_name}}&nbsp;</td>
                                        <td>{{$item->service_type}}</td>
                                        <td>{{$item->service_code}}&nbsp;</td>
                                        <td>{{$item->price}}&nbsp;</td>
                                        <td class="actions">
                                            <a href="#" class="label label-success" data-toggle="modal" data-target="#editPriceModal{{$item->id}}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="2a">
                        <h2>Old Requests</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        @foreach($prices as $index)
        <div id="editPriceModal{{$index->id}}" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Price</h4>
                    </div>
                    <div class="modal-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{route('admin.cms.edit-price',[$index->id,App::getLocale()])}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="amount">Price</label>
                                <input type="text" id="price" name="price"  class="form-control" required="required" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /#page-wrapper -->
@endsection