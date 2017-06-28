@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <h2>Subscribers</h2>
                <div class="table-responsive">

                    <table class="table table-hover">
                        <tr>
                            <th><a href="#">S-Id</a></th>
                            <th><a href="#">Created</a></th>
                            <th><a href="#">Email</a></th>
                            <th class="actions">Actions</th>
                        </tr>
                        <tr>
                            <td>018&nbsp;</td>
                            <td>2017-04-17&nbsp;</td>
                            <td>thisuser@yahoo.com</td>
                            <td class="actions">
                                <a href="#" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Edit"><span class="label label-success">Send Message</span></a>
                                <a href="#" title="Delete" onclick="return confirm('Are you Sure to Delete?')"><span class="label label-danger">Delete</span></a>
                            </td>
                        </tr>
                        <tr>
                            <td>017&nbsp;</td>
                            <td>2017-04-17&nbsp;</td>
                            <td>thisuser@yahoo.com</td>
                            <td class="actions">
                                <a href="#" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Edit"><span class="label label-success">Send Message</span></a>
                                <a href="#" title="Delete" onclick="return confirm('Are you Sure to Delete?')"><span class="label label-danger">Delete</span></a>
                            </td>
                        </tr>
                        <tr>
                            <td>016&nbsp;</td>
                            <td>2017-04-17&nbsp;</td>
                            <td>thisuser@yahoo.com</td>
                            <td class="actions">
                                <a href="#" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Edit"><span class="label label-success">Send Message</span></a>
                                <a href="#" title="Delete" onclick="return confirm('Are you Sure to Delete?')"><span class="label label-danger">Delete</span></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

@endsection