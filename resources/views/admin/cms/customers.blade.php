@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">All Customers</a>
                    </li>
                    <li>
                        <a  href="#2a" data-toggle="tab">New</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>All Customers</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#ID</a></th>
                                    <th><a href="#">Name</a></th>
                                    <th><a href="#">Arabic Name</a></th>
                                    <th><a href="#">Website Link</a></th>
                                    <th><a href="#">Logo</a></th>
                                    <th>Actions</th>
                                </tr>
                                @foreach($customers as $item)
                                    <tr>
                                        <td>{{$item->id}}&nbsp;</td>
                                        <td>{{$item->name}}&nbsp;</td>
                                        <td>{{$item->name_ar}}&nbsp;</td>
                                        <td>{{$item->link}}&nbsp;</td>
                                        <td><img src="{{url('img/customers/'.$item->logo)}}" style="height: 50px; width: 100px;"/></td>
                                        <td class="actions">
                                            <a href="{{route('admin.cms.delete-customer',[$item->id,App::getLocale()])}}" onclick="return confirm('Sure');" class="label label-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="2a">
                        <h2>New Customer</h2>
                        <p>
                        <form method="post" action="{{route('admin.cms.new-customer',App::getLocale())}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name"  class="form-control" required="required" placeholder="Customer Name">
                            </div>

                            <div class="form-group">
                                <label for="name">Name Arabic</label>
                                <input type="text" id="name_ar" name="name_ar"  class="form-control"  placeholder="Customer Name">
                            </div>

                            <div class="form-group">
                                <label for="name">Website Link</label>
                                <input type="text" id="link" name="link"  class="form-control"  placeholder="Website Link">
                            </div>

                            <div class="form-group">
                                <label for="name">Logo Image</label>
                                <input type="file" id="logo" name="logo"  required="required" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>

                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection