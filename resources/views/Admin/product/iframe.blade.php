<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Product Slider Template | PrepBootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="{{ asset('iframe/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('iframe/font-awesome/css/font-awesome.min.css') }}" />

    <script type="text/javascript" src="{{ asset('iframe/js/jquery-1.10.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iframe/bootstrap/js/bootstrap.min.js') }}"></script>
    <style>
        /* .name{
            box-shadow: 0px 5px 50px 0px rgb(0 0 0 / 10%);
            text-align: center;
            margin:0px 0px 0px 0px;
        } */
        /* .col-md-3{
            box-shadow: 0px 5px 50px 0px rgb(0 0 0 / 10%);
        } */

        .col-item
        {
            background: #FFF;
            box-shadow: 0px 5px 15px 0px rgb(0 0 0 / 10%);
            border: 1px solid rgb(243, 241, 241);
        }
        .col-item .photo img
        {
            margin: 0 auto;
            width: 100%;
            width:300px;height:250px; 
        }
        
        .col-item .info
        {
            padding: 10px;
            border-radius: 0 0 5px 5px;
            margin-top: 1px;
        }
        /* .col-item:hover .info {
            background-color: rgba(215, 215, 244, 0.5); 
        } */
        .col-item .price
        {
            /*width: 50%;*/
            float: left;
            margin-top: 5px;
        }
        
        .col-item .price h5
        {
            line-height: 20px;
            margin: 0;
        }
        
        
        .col-item .btn-details
        {
            width: 50%;
            float: left;
            padding-left: 10px;
        }
        .controls
        {
            margin-top: 20px;
        }
        [data-slide="prev"]
        {
            margin-right: 10px;
        }
        h4 {
            color: black;
            text-align: center;
        }
        .clock{
            font-size: 25px;
            color: black;
            padding-left: 40px;
        }
        
    </style>
</head>
<body>
   

<div class="container">

<!-- Product Slider - START -->


<div class="container">
    <div class="row">
        <div class="row">
            <div class="col-md-9">
               
            </div>
            <div class="col-md-3">
                <!-- Controls -->
                <div class="controls pull-right">
                    <a class="left fa fa-chevron-left btn btn" href="#carousel-example"
                        data-slide="prev"></a><a class="right fa fa-chevron-right btn" href="#carousel-example"
                            data-slide="next"></a>
                </div>
            </div>
        </div>
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="row" style="margin-bottom: 20px;">
                        @foreach($data['auctionList'] as $activeAuction)
                        <input type="hidden" name="hidden_date" value="{{$activeAuction->auction_time}}">
                        <div class="col-sm-3">
                            <div class="col-item">
                                <div class="info">
                                    <span class="clock" data-countdown="{{$activeAuction->auction_time}}"></span>
                                </div>
                                <div class="photo">
                                    <img src="{{$activeAuction->image1}}" class="img-responsive" alt="a"/>
                                </div>
                                <div class="info">
                                    <h4 class="name">
                                        {{$activeAuction->name}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="item">
                    <div class="row" style="margin-bottom: 20px;">
                        @foreach($data['secondList'] as $listItem)
                        <input type="hidden" name="hidden_date" value="{{$listItem->auction_time}}">
                        <div class="col-sm-3">
                            <div class="col-item">
                                <div class="info">
                                    <span class="clock" data-countdown="{{$listItem->auction_time}}"></span>
                                </div>
                                <div class="photo">
                                    <img src="{{$listItem->image1}}" class="img-responsive" alt="a" style="width:300px;height:250px; " />
                                </div>
                                <div class="info">
                                    <h4 class="name">
                                        {{$listItem->name}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Slider - END -->

</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>  
<script src="https://cdn.rawgit.com/hilios/jQuery.countdown/2.2.0/dist/jquery.countdown.min.js" type="application/javascript"></script>

    
<script>

    $('[data-countdown]').each(function() {
        var $this = $(this), finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('%D days %H:%M:%S'));
        });
    });
</script>

</body>
</html>