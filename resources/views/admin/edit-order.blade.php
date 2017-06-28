@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <!--js-->
        <script type="text/javascript">
            $(function () {
                $("#cod_pay").change(function () {
                    if($(this).is(":checked")) {
                        $("#cod_amount").removeAttr("disabled");
                        $("#cod_amount").focus();
                    } else {
                        $("#cod_amount").attr("disabled", "disabled");
                        $("#cod_amount").val('');
                    }
                });
            });

            $(function () {
                $("#is_packing").change(function () {
                    if($(this).is(":checked")) {
                        $("#packing").removeAttr("disabled");
                        $("#packing").focus();
                        $("#packing_color").removeAttr("disabled");
                    } else  {
                        $("#packing").attr("disabled","disabled");
                        $("#packing_color").attr("disabled","disabled");
                    }
                });
            });

            $(function () {
                $("#s_city").change(function () {
                    if($(this).val() == 'Riyadh' && $("#r_city").val() == 'Riyadh') {
                        $("#payment_mode_cod").removeClass("hidden");
                        $("#cod_pay").removeAttr("disabled");
                        $("#cod_amount").removeAttr("disabled");
                    } else if($(this).val() != 'Riyadh' || $("#r_city").val() != 'Riyadh') {
                        $("#payment_mode_cod").addClass("hidden");
                        $("#cod_pay").attr("disabled","disabled");
                        $("#cod_amount").attr("disabled","disabled");
                    }
                });

                $("#r_city").change(function () {
                    if($(this).val() == 'Riyadh' && $("#s_city").val() == 'Riyadh') {
                        $("#payment_mode_cod").removeClass("hidden");
                        $("#cod_pay").removeAttr("disabled");
                        $("#cod_amount").removeAttr("disabled");
                    } else if($(this).val() != 'Riyadh' || $("#r_city").val() != 'Riyadh') {
                        $("#payment_mode_cod").addClass("hidden");
                        $("#cod_pay").attr("disabled","disabled");
                        $("#cod_amount").attr("disabled","disabled");
                    }
                });
            });


        </script>

        <div class="container-fluid">
            <div class="row">
                <h3>{{trans('general.order-number')}} - #{{$order->id}} - {{trans('general.status')}}: {{$order->status}}
                    <small>
                        <a href="#" class="btn btn-sm btn-danger" style="margin: -10px 0 0 25px;" onclick="goBack()">{{trans('general.back')}}</a>
                    </small>
                </h3>
            </div>

            <div class="row">
                <h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('client.edit-order-form-title')}}  - {{trans('form.step1')}}</h3>
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
                    <form method="post" action="{{route('client.edit-order',array(App::getLocale(),$order->id))}}"  class="row">
                        {{csrf_field()}}
                        <div class="form-section">
                            <div class="col-sm-12">
                                <h3>{{trans('general.shipment-place')}}</h3>
                                <!--store-selection-->
                                @if(count(@$stores)>=1)
                                    <div class="form-group store-sec col-sm-6">
                                        <select id="store" name="store" class="form-control">
                                            <option value="">--{{trans('form.select-store')}}--</option>
                                            @foreach(@$stores as $store)
                                                <option value="{{@$store->id}}">{{@$store->name}}-{{@$store->street}}-{{@$store->city}}</option>
                                            @endforeach
                                            <option value="other">{{trans('form.other-place')}}</option>

                                        </select>
                                    </div>
                                    <div class="form-group store-address col-sm-6">
                                        <select id="store-address" name="store_address" class="form-control">
                                            <option value="">--Select Shipment Address--</option>
                                            <option value="same">{{trans('general.same-store')}}</option>
                                            <option value="other">{{trans('general.other-place')}}</option>
                                        </select>
                                    </div>
                                    @endif
                                            <!--actual-form-start-->
                            </div>
                            <div id="other_store" class="col-sm-12">
                                <div id="hd" class="">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="s_name">{{trans('general.store-name')}}</label>
                                        <input type="text" id="s_name" name="store_name" value="{{$order->store_name}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="s_country">{{trans('form.country')}}</label>
                                        <select id="s_country" class="form-control country" name="store_country" required>
                                            <OPTION value="SA">Saudi Arabia</OPTION>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="s_city">{{trans('form.city')}}</label>
                                    <select id="s_city" class="form-control city" name="store_city" required>
                                        <OPTION value="{{$order->s_city}}">{{$order->s_city}}</OPTION>
                                        @foreach(@$cities as $city)
                                            <option value="{{@$city->name}}">{{@$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="s_neighbor">{{trans('general.neighbour')}}</label>
                                    <select id="s_neighbor" class="form-control s_region" name="store_neighbour" required>
                                        <OPTION value="{{$order->s_neighbor_id}}">{{$order->s_neighbor}}</OPTION>
                                        @foreach($neighbors as $neighbor)
                                            <option value="{{$neighbor->id}}">{{$neighbor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="s_other_neighbor">Other Neighbourhood</label>
                                    <input id="s_other_neighbor" name="s_other_neighbor" type="text" class="form-control" placeholder="" value="{{@$order->s_other_neighbor}}" {{($order->s_neighbor == 0)?$order->s_other_neighbor:'disabled="disabled"'}}>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="s_street">{{trans('general.street')}}</label>
                                    <input id="s_street" name="store_street" type="text" class="form-control"  value="{{$order->s_street}}" required>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="s_phone">{{trans('form.phone')}}</label>
                                    <input id="s_phone" name="store_phone" type="text" class="form-control"  value="{{(@$order->s_phone)?$order->s_phone:Auth::user()->phone}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="pick_date">{{trans('general.pick-date')}}</label>
                                    <input id="pick_date" name="pick_date" type="date" value="{{@$order->pick_date}}"  class="form-control" min="{{Carbon\Carbon::today()->format('Y-m-d')}}" placeholder="mm/dd/YYYY">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="pick_date">{{trans('general.pick-date')}}</label>
                                    <select class="form-control" name="pick_time">
                                        <option value="{{@$order->pick_time}}">{{@$order->pick_time}}</option>
                                        <option value="9AM-11AM">9AM-11AM</option>
                                        <option value="11AM-01PM">11AM-01PM</option>
                                        <option value="01PM-03PM">01PM-03PM</option>
                                        <option value="03PM-05PM">03PM-05PM</option>
                                        <option value="05PM-07PM">05PM-07PM</option>
                                        <option value="07PM-09PM">07PM-09PM</option>
                                        <option value="09PM-11PM">09PM-11PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-section col-xs-12"><h3>{{trans('client.rcvr-info')}}</h3>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="r_name">{{trans('form.name')}}</label>
                                <input id="r_name" name="receiver_name" type="text" value="{{@$order->r_name}}" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="r_country">{{trans('genral.country')}}</label>
                                <select id="r_country" class="form-control country" name="receiver_country" required>
                                    <option value="SA">Saudi Arabia</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <label for="r_city">{{trans('form.city')}}</label>
                                <select  id="r_city" class="form-control city" name="receiver_city" required>
                                    <option value="{{$order->r_city}}">{{$order->r_city}}</option>
                                    @foreach($r_cities as $city)
                                        <option value="{{$city->name}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <label for="r_neighbor">{{trans('general.neighbour')}}</label>
                                <select id="r_neighbor" class="form-control r_neighbor" name="receiver_neighbour" required>
                                    <option  value="{{@$order->r_neighbor_id}}">{{@$order->r_neighbor}}</option>
                                    <option  value="0">Other</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <label for="r_other_neighbor">Other Neighbor</label>
                                <input id="r_other_neighbor" name="r_other_neighbor" type="text" class="form-control" placeholder="" value="{{@$order->r_other_neighbor}}" {{$order->r_neighbor == 0?$order->r_other_neighbor:'disabled="disabled"'}}>
                            </div>

                            <div class="form-group col-sm-12 col-md-6">
                                <label for="r_street">{{trans('general.street')}}</label>
                                <input id="r_street" name="receiver_street" type="text"  value="{{@$order->r_street}}" class="form-control" placeholder="">
                            </div>


                            <div class="form-group col-sm-12 col-md-6">
                                <label for="r_phone">{{trans('form.mobile')}}</label>
                                <div class="form-inline">
                                    <select class="form-control"><option value="00966">+966</option></select><input id="r_phone" name="receiver_phone" type="text" max="9" min="9" class="form-control" value="{{$order->r_phone}}" placeholder="" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-section col-xs-12"><h3>{{trans('general.shipment-details')}}</h3>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-12">
                                    <label for="contains">{{trans('general.shipment-contains')}}</label>
                                    <textarea id="contains" name="contains"  class="form-control" style="max-width: 100%"  placeholder="Enter What Shipment Contains" required>{{@$order->contains}}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="number">{{trans('client.number-it')}}</label>
                                    <input id="quantity" name="quantity" type="number" class="form-control" placeholder="Total Number of Items" value="{{@$order->quantity}}" required>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label for="weight">{{trans('client.est-weight')}}</label>
                                    <select class="form-control" id="weight" name="weight" required>
                                        <option value="{{@$order->weight}}">{{@$order->weight}}</option>
                                        <optgroup label="Less Than 16Kg">
                                            <option value="1-to-5">0-to-15Kg</option>
                                        </optgroup>
                                        <optgroup label="More Than 15Kg">
                                            @for($i=16;$i <= 100; $i++)
                                                <option value="{{$i}}">{{$i}} Kg</option>
                                            @endfor
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <h3>Other Services (Optional)</h3>
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-3  form-inline">
                                    <label><input id="is_packing" type="checkbox" name="is_packing" value="1" {{(@$order->is_packing == 1)?'checked':''}}>&nbsp;Packaging</label>
                                </div>
                                <div class="form-group col-xs-12 col-sm-5">
                                    <label for="packing">{{trans('client.packaging')}}</label>
                                    <select class="form-control" id="packing" name="packing" {{(@$order->is_packing == 1)? '':'disabled="disabled"'}}>
                                        <option value="{{@$order->packing_id}}">{{@$order->packings->packing_type}}-{{@$order->packings->packing_size}}-{{@$order->packings->packing_lwh}}</option>
                                        @foreach($packings as $packing)
                                            <option value="{{$packing->id}}">{{$packing->packing_type}}-{{$packing->packing_size}}-{{$packing->packing_lwh}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label for="packing_color">Packing Color</label>
                                    <select class="form-control" id="packing_color" name="packing_color" {{(@$order->is_packing == 1)? '':'disabled="disabled"'}}>
                                        <option value="{{$order->packing_color}}">{{$order->packing_color}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <label for="spl_req">{{trans('general.spl-req')}}</label>
                                    <textarea name="spl_req" id="spl_req" class="form-control" {{$order->spl_req}} style="max-width: 100%" placeholder="Any Special Requirement? Please write here."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <input type="submit" value="{{trans('general.next')}}" class="btn btn-primary">
                        </div>
                    </form>
                        <script>
                            $('#packing').on('change',function(e){
                                console.log(e);
                                var packing_id = e.target.value;

                                $.get('../../../ajax-packing-color?packing_id=' + packing_id, function(data){
                                    $('#packing_color').empty();
                                    $.each(data, function(index, obj){
                                        $('#packing_color').append('<option value="'+obj.color+'">'+obj.color+'</option>');
                                    })
                                });
                            });


                            $(function(){
                                $(".city").change(function(){
                                    var el = $(this) ;
                                    if(el.val() !== "Riyadh") {
                                        $("#cod_pay").attr("disabled","disabled");
                                    }
                                    else{
                                        $("#cod_pay").removeAttr("disabled");
                                    }
                                });
                            });


                            $('#shipment_amount').on('change',function(e){
                                console.log(e);
                                var shipment_amount = e.target.value;
                                if(shipment_amount > 500){
                                    $.get('../../../insurance-calc?shipment_amount=' + shipment_amount, function(data){
                                        $('#insurance_amount').removeAttr('type','hidden');
                                        $('#insurance_amount').empty();
                                        $("#insurance_amount").val(data);
                                        $('#insurance_label').removeAttr('hidden');
                                    });
                                }
                                else{
                                    $('#insurance_amount').attr('type','hidden');
                                    $('#insurance_amount').empty();
                                    $("#insurance_amount").val(0);
                                    $('#insurance_label').attr('hidden','true');
                                    $('#insurance_apply').removeClass('show');
                                }
                            });

                            $('#store').on('change',function(e){
                                console.log(e);
                                var store_id = e.target.value;
                                $('#s_region').val('');

                                if(store_id == 'other'){
                                    $('#other_store').removeClass('hidden');
                                    $('#store-address').attr("disabled","disabled");
                                    $('#hd').removeClass('hidden');
                                    $('#s_name').removeAttr("disabled");
                                    $('#s_city').removeAttr("disabled");
                                    $('#s_region').removeAttr("disabled");
                                    $('#s_neighbor').removeAttr("disabled");
                                    $('#s_street').removeAttr("disabled");
                                    $('#s_phone').removeAttr("disabled");
                                }
                                else{
                                    $('#other_store').addClass('hidden');
                                    $('#store-address').removeAttr("disabled");
                                    $('#s_name').attr("disabled","disabled");
                                    $('#s_city').attr("disabled","disabled");
                                    $('#s_region').attr("disabled","disabled");
                                    $('#s_neighbor').attr("disabled","disabled");
                                    $('#s_street').attr("disabled","disabled");
                                    $('#s_phone').attr("disabled","disabled");
                                }
                            });

                            $('#store-address').on('change',function(e){
                                console.log(e);
                                var store_id = e.target.value;

                                if(store_id == 'other'){
                                    $('#other_store').removeClass('hidden');
                                    $('#hd').addClass('hidden');
                                    $('#hd').addClass('hidden');
                                    $('#s_name').attr("disabled","disabled");
                                    $('#s_city').removeAttr("disabled");
                                    $('#s_region').removeAttr("disabled");
                                    $('#s_neighbor').removeAttr("disabled");
                                    $('#s_street').removeAttr("disabled");
                                    $('#s_phone').removeAttr("disabled");

                                }
                                else{
                                    $('#other_store').addClass('hidden');
                                    $('#s_city').attr("disabled","disabled");
                                    $('#s_region').attr("disabled","disabled");
                                    $('#s_neighbor').attr("disabled","disabled");
                                    $('#s_street').attr("disabled","disabled");
                                    $('#s_phone').attr("disabled","disabled");

                                }
                            });

                            $('#s_city').on('change',function(e){
                                console.log(e);
                                var city = e.target.value;
                                $.get('../../../ajax-get-neighbors?city='+city, function(data){
                                    $('#s_neighbor').empty();
                                    $('#s_neighbor').append('<option value="">--Select--</option>');
                                    if(data == ""){
                                        $('#s_neighbor').append('<option value="0">Other</option>');
                                    }
                                    else{
                                        $.each(data, function(index, neighborObj){
                                            $('#s_neighbor').append('<option value="'+neighborObj.id+'">'+neighborObj.name+'</option>');
                                        });
                                        $('#s_neighbor').append('<option value="0">Other</option>');
                                    }
                                });
                            });

                            $('#s_neighbor').on('change',function(e){
                                console.log(e);
                                var nr = e.target.value;
                                if(nr == 0){
                                    $("#s_other_neighbor").removeAttr("disabled");
                                    $("#s_other_neighbor").focus();

                                }
                                else{
                                    $("#s_other_neighbor").attr("disabled","disabled");
                                    $("#s_other_neighbor").val('');

                                }

                            });


                            $('#r_city').on('change',function(e){
                                console.log(e);
                                var city = e.target.value;
                                $.get('../../../ajax-get-neighbors?city=' +city, function(data){
                                    $('#r_neighbor').empty();
                                    $('#r_neighbor').append('<option value="">--Select--</option>');

                                    if(data == ""){
                                        $('#r_neighbor').append('<option value="0">Other</option>');
                                    }
                                    else{
                                        $.each(data, function(index, neighborObj){
                                            $('#r_neighbor').append('<option value="'+neighborObj.id+'">'+neighborObj.name+'</option>');
                                        });
                                        $('#r_neighbor').append('<option value="0">Other</option>');
                                    }
                                });
                            });

                            $('#r_neighbor').on('change',function(e){
                                console.log(e);
                                var nr = e.target.value;
                                if(nr == 0){
                                    $("#r_other_neighbor").removeAttr("disabled");
                                    $("#r_other_neighbor").focus();

                                }
                                else{
                                    $("#r_other_neighbor").attr("disabled","diabled");
                                    $("#r_other_neighbor").val('');

                                }


                            });

                            $("#r_phone").change(function() {
                                if($(this).val().length == 9) {
                                    $("#submit").removeAttr("disabled");
                                } else {
                                    alert("Receiver phone digit length must be equal to 9");
                                    $(this).focus();
                                    $("#submit").attr("disabled","disabled");
                                }
                            });
                        </script>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection