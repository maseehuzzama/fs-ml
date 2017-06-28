@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>All Settings</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">Phone</a></th>
                                    <th><a href="#">Phone Another</a></th>
                                    <th><a href="#">Email</a></th>
                                    <th><a href="#">Logo</a></th>
                                    <th>Action</th>
                                </tr>

                                <tr>
                                    <td>{{$setting->phone}}&nbsp;</td>
                                    <td>{{$setting->phone_another}}&nbsp;</td>
                                    <td>{{$setting->email}}&nbsp;</td>
                                    <td>{{$setting->logo}}&nbsp;</td>
                                    <td class="actions">
                                        <a href="#" data-toggle="modal" data-target="#editModal" class="label label-danger">Edit</a>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Setting</h4>
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
                        <form method="post" action="{{route('admin.theme.edit-settings',[App::getLocale()])}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone"  class="form-control"  placeholder="Type" value="{{$setting->phone}}">
                            </div>
                            <div class="form-group">
                                <label for="phone_another">Phone Another</label>
                                <input type="text" id="phone_another" name="phone_another"  class="form-control"  placeholder="Type" value="{{$setting->phone_another}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{$setting->email}}" value="{{$setting->email}}">
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" id="logo" name="logo"  class="form-control">
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
    </div>
    <!-- /#page-wrapper -->
@endsection