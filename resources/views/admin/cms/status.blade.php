@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">All Status</a>
                    </li>
                    <li>
                        <a  href="#2a" data-toggle="tab">New</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>All Status</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#ID</a></th>
                                    <th><a href="#">Status Name</a></th>
                                    <th><a href="#">Status Description</a></th>
                                    <th><a href="#">Status Description Arabic</a></th>
                                    <th><a href="#">Status By</a></th>
                                    <th>Actions</th>
                                </tr>
                                @foreach($statuses as $item)
                                    <tr>
                                        <td>{{$item->id}}&nbsp;</td>
                                        <td>{{$item->name}}&nbsp;</td>
                                        <td>{{$item->description}}&nbsp;</td>
                                        <td>{{$item->description_ar}}&nbsp;</td>
                                        <td>{{$item->status_by}}</td>
                                        <td class="actions">
                                            <a href="#" class="label label-success" data-toggle="modal" data-target="#editModal{{$item->id}}">Edit</a>
                                            <a href="{{route('admin.cms.delete-status',[$item->id,App::getLocale()])}}" onclick="return confirm('Sure');" class="label label-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="2a">
                        <h2>New</h2>
                        <p>
                        <form method="post" action="{{route('admin.cms.new-status',App::getLocale())}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="type">Status By</label>
                                <select class="form-control" name="status_by">
                                    <option value="">--select-one--</option>
                                    <option value="admin">Admin</option>
                                    <option value="pick_agent">Pick Agent</option>
                                    <option value="delivery_agent">Delivery Agent</option>
                                    <option value="app">App</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name"  class="form-control" required="required" placeholder="Status Name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" id="description" name="description"  class="form-control" required="required" placeholder="Status Name">
                            </div><div class="form-group">
                                <label for="description_ar">Description Arabic</label>
                                <input type="text" id="description_ar" name="description_ar"  class="form-control" placeholder="Status Name">
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
        @foreach($statuses as $index)
        <div id="editModal{{$index->id}}" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Status</h4>
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
                        <form method="post" action="{{route('admin.cms.edit-status',[$index->id,App::getLocale()])}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="type">Status By</label>
                                <select class="form-control" name="status_by">
                                    <option value="{{$index->status_by}}">{{$index->status_by}}</option>
                                    <option value="admin">Admin</option>
                                    <option value="pick_agent">Pick Agent</option>
                                    <option value="delivery_agent">Delivery Agent</option>
                                    <option value="app">App</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name"  class="form-control" required="required"  value="{{$index->name}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" id="description" name="description"  class="form-control" required="required" value="{{$index->description}}">
                            </div><div class="form-group">
                                <label for="description_ar">Description Arabic</label>
                                <input type="text" id="description_ar" name="description_ar"  class="form-control" value="{{$index->description_ar}}"s placeholder="Status Name">
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