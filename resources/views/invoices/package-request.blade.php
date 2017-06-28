@extends('layouts.master')
@section('meta-title')
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Package Request | Fast Star for Delivery</title>
@endsection
@section('custom-css')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print, #print * {
                visibility: visible;
            }
         }
    </style>
@endsection
@section('custom-js')
@endsection
@section('content')
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="text-center">

                @if (session('success'))

                        <div id="print" class="row" style="width: 80%; border: 1px solid #cccccc; padding: 20px; margin: 0 auto 0 auto;">
                            Dated: {{$p_r->created_at}}<br>
                            <img src="{{url('img/banner.png')}}" style="width: 70%; margin-left: auto; margin-right: auto;"/>
                            <hr>
                            <h3 class="text-success"><i class="fa fa-check-circle-o"></i> {!! session('success') !!}</h3>
                            <p class="lead">Your Package request has been submitted successfully. Please transfer the payment by your selected payment mode and after payment submit a ticket to our support team to activate your package with reference number</p>
                            <p><span><b>Customer Name:</b> {{$account->fullname}}</span><br>
                            <p><span><b>Customer Email:</b> {{Auth::user()->email}}</span><br>
                            </p>
                            <div class="table-responsive text-center">
                                <table class="table-bordered text-center"  style="width:80%; margin-left: auto; margin-right: auto;">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Ref #</th>
                                        <th  class="text-center">Package Code</th>
                                        <th  class="text-center">Package Type</th>
                                        <th  class="text-center">Rates</th>
                                        <th  class="text-center">Package Quantity</th>
                                    </tr>

                                    <tr class="text-center">
                                        <td>{{$p_r->ref_number}}</td>
                                        <td>{{$p_r->package_code}}</td>
                                        <td class="text-capitalize">{{$package->type}} Riyadh</td>
                                        <td>{{$package->rates}}SAR/Order</td>
                                        <td>{{$package->quantity}} Orders</td>
                                    </tr>

                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="lead"><b>Total Cost: {{$package->rates*$package->quantity}}</b></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <a class="btn btn-primary btn-sm" onclick="window.print();">Print</a>
                    @endif
                @if (session('unsuccess'))
                    <h3 class="text-danger">{!! session('unsuccess') !!}</h3>
                @endif
                </div>
            </div>
        </div>
    </section>
@endsection