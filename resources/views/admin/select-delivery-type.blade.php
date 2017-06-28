@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <!--js-->
        <script type="text/javascript">

        </script>

        <div class="container-fluid">
            <div class="row">
                <h3>Order - #{{$order->id}} - Status: {{$order->status}}
                    <small>
                        <a href="#" class="btn btn-sm btn-danger" style="margin: -10px 0 0 25px;" onclick="goBack()">Back</a>
                    </small>
                </h3>
            </div>

            <div class="row">
                <h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">Select Delivery Type - {{trans('form.step2')}}</h3>
                <div class="col-xs-12 {{(App::getLocale() === 'ar') ? 'text-right':''}}" style="border: 1px solid #31708f; padding: 30px;">
                    <form  method="post" action="{{route('admin.select-delivery-type',array($order->ref_number,App::getLocale()))}}"  class="row">
                        {{csrf_field()}}
                        <div class="form-section">
                            <div class="form-group col-xs-12">
                                <div class="row">
                                    <label for="spl_req">Delivery Type</label><br>
                                    @if($order->s_city == 'Riyadh' and $order->r_city == 'Riyadh')
                                        <div class="col-sm-12 col-md-4">
                                            <input type="radio" name="delivery_type"  value="fd"><span>Fast Delivery(24 Hours)</span>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <input type="radio" name="delivery_type"  value="fed"><span>Fast Express Delivery(3 Hours)</span>
                                        </div>
                                    @else
                                        <div class="col-sm-12 col-md-4">
                                            <input type="radio" name="delivery_type" value="fs"><span>Fast Shipping(48 Hours)</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="{{trans('general.submit-order')}}">
                        <a href="{{route('admin.edit-order',array($order->id,App::getLocale()))}}" class="btn btn-default">{{trans('general.back')}}</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection