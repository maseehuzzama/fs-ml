@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">All Packaging</a>
                    </li>
                    <li>
                        <a  href="#2a" data-toggle="tab">New</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>All Packings</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#ID</a></th>
                                    <th><a href="#">Packing Type</a></th>
                                    <th><a href="#">Packing Size</a></th>
                                    <th><a href="#">Packing Price</a></th>
                                    <th><a href="#">Realted Colors</a></th>
                                    <th>Actions</th>
                                </tr>
                                @foreach($packings as $item)
                                    <tr>
                                        <td>{{$item->id}}&nbsp;</td>
                                        <td>{{$item->packing_type}}&nbsp;</td>
                                        <td>{{$item->packing_size}}-{{$item->packing_lwh}}</td>
                                        <td>{{$item->packing_price}}&nbsp;</td>
                                        <td>
                                            @foreach($item->colors as $color)
                                              {{ $color->color }},
                                            @endforeach
                                        </td>
                                        <td class="actions">
                                            <a href="#" class="label label-success" data-toggle="modal" data-target="#editModal{{$item->id}}">Edit</a>
                                            <a href="{{route('admin.cms.delete-packing',[$item->id,App::getLocale()])}}" onclick="return confirm('Sure');" class="label label-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="2a">
                        <h2>New</h2>
                        <p>
                        <form method="post" action="{{route('admin.cms.new-packing',App::getLocale())}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="amount">Type</label>
                                <input type="text" id="type" name="type"  class="form-control" required="required" placeholder="Type">
                            </div>
                            <div class="form-group">
                                <label for="amount">Size</label>
                                <select id="size" name="size" class="form-control">
                                    <option value="">Select Size</option>
                                    <option value="Small">Small</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Large">Large</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="amount">LxWxH</label>
                                <input type="text" name="lwh" class="form-control" placeholder="LxWxH in Centimeter">
                            </div>


                            <div class="form-group">
                                <label for="amount">Price</label>
                                <input type="text" id="price" name="price"  class="form-control" required="required" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <label for="color">Color</label>
                                <select id="color" name="color[]" class="form-control" multiple="multiple">
                                    @foreach($colors as $color)
                                        <option value="{{$color->id}}">{{$color->color}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </form>

                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        @foreach($packings as $index)
        <div id="editModal{{$index->id}}" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Packing</h4>
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
                        <form method="post" action="{{route('admin.cms.edit-packing',[$index->id,App::getLocale()])}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="amount">Type</label>
                                <input type="text" id="type" name="type"  class="form-control" required="required" placeholder="Type" value="{{$index->packing_type}}">
                            </div>
                            <div class="form-group">
                                <label for="amount">Size</label>
                                <select id="size" name="size" class="form-control">
                                    <option value="{{$index->packing_size}}">{{$index->packing_size}}</option>
                                    <option value="Small">Small</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Large">Large</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">WxHxD</label>
                                <input type="text" name="lwh" class="form-control" value="{{$index->packing_lwh}}" placeholder="WxDxH in Centimeter">
                            </div>
                            <div class="form-group">
                                <label for="amount">Price</label>
                                <input type="text" id="price" name="price"  class="form-control" required="required" placeholder="Price" value="{{$index->packing_price}}">
                            </div>

                            <div class="form-group">
                                <label for="color">Color</label>
                                <select id="color" name="color[]" class="form-control" multiple="multiple">
                                    @foreach($colors as $color)
                                        <option value="{{$color->id}}">{{$color->color}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Update">
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