@extends('layouts.admin')

@section('content')
    <script>

    </script>

    <div id="page-wrapper">
        <!--js-->
        <div class="container-fluid">
            <div class="row">
                <h3>Order - #{{$order->id}} - Status: {{$order->status}}
                    <small>
                        <a href="#" class="btn btn-sm btn-danger" style="margin: -10px 0 0 25px;" onclick="goBack()">Back</a>
                    </small>
                </h3>
            </div>

            <div class="row">
                <div class="form-div col-xs-12">
                    <h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">Edit Order</h3>
                    <div class="col-xs-12 {{(App::getLocale() === 'ar') ? 'text-right':''}}" style="border: 1px solid #31708f; padding: 30px;">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{route('admin.edit-other-order',array($order->id,App::getLocale()))}}"  class="row">
                            {{csrf_field()}}
                            <div class="form-section">
                                <div class="col-sm-12">
                                    <h3>Price Details</h3>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="number">Photography Price</label>
                                        <input id="photo_price" name="photo_price" type="text" class="form-control" placeholder="Price for Photography" {{($order->is_photo == true)?'':'disabled="disabled"'}}>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="number">Storage Price</label>
                                        <input id="storage_price" name="storage_price" type="text" class="form-control" placeholder="Price for Storage" {{(@$order->is_photo == true)?'':'disabled="disabled"'}}>
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection