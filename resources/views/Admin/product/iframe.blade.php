<html>	
<head>	
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" id="bootstrap-css">

	
	<style>
                    body {
    margin: 0;
    font-family: Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: .8125rem;
    font-weight: 400;
    line-height: 1.5385;
    color: #333;
    text-align: left;
    background-color: white;
}

.mt-50{

    margin-top: 50px;
}

.mb-50{

    margin-bottom: 50px;
}



.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    min-height: 415px;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .1875rem;
}

.card-img-actions {
    position: relative;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
    text-align: center;
}

.card-img{
    width: 200px;
    height:200px;
}

.star{
        color: red;
}

.bg-cart {
    background-color:orange;
    color:#fff;
}

.bg-cart:hover {
    
    color:#fff;
}

.bg-buy {
    background-color:green;
    color:#fff;
    padding-right: 29px;
}
.bg-buy:hover {
    
    color:#fff;
}

a{

    text-decoration: none !important;
}

	</style>
</head>	
<body>
    
<div class="container d-flex justify-content-center mt-50 mb-50"> 
    <div class="row">
    
    @if(($pending_auction->count() == 1))
        @foreach($pending_auction as $auction)
            <div class="col-md-12 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img-actions">
                            <img src="{{$auction->image1}}" class="card-img img-fluid" alt="">
                        </div>
                    </div>

                    <div class="card-body bg-light text-center">
                        <div class="mb-2">
                        <h5 class="mb-0 font-weight-semibold" data-countdown="{{$auction->auction_time}}"></h5><br>
                            <h6 class="font-weight-semibold">
                                <span class="text-default mb-2" data-abc="true">{{$auction->name}}</span>
                            </h6>
                        </div>
                        
                    </div>
                </div>             
            </div>
        @endforeach
    @endif

    @if(($pending_auction->count() == 2))
        @foreach($pending_auction as $auction)
            <div class="col-md-6 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img-actions">
                            <img src="{{$auction->image1}}" class="card-img img-fluid" alt="">
                        </div>
                    </div>

                    <div class="card-body bg-light text-center">
                        <div class="mb-2">
                        <h5 class="mb-0 font-weight-semibold" data-countdown="{{$auction->auction_time}}"></h5><br>
                            <h6 class="font-weight-semibold">
                                <span class="text-default mb-2" data-abc="true">{{$auction->name}}</span>
                            </h6>
                        </div>
                        
                    </div>
                </div>             
            </div>
        @endforeach
    @endif

    @if(($pending_auction->count() > 2))
        @foreach($pending_auction as $auction)
            <div class="col-md-3 col-sm-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img-actions">
                            <img src="{{$auction->image1}}" class="card-img img-fluid" alt="">
                        </div>
                    </div>

                    <div class="card-body bg-light text-center">
                        <div class="mb-2">
                        <h5 class="mb-0 font-weight-semibold" data-countdown="{{$auction->auction_time}}"></h5><br>
                            <h6 class="font-weight-semibold">
                                <span class="text-default mb-2" data-abc="true">{{$auction->name}}</span>
                            </h6>
                        </div>
                        
                    </div>
                </div>             
            </div>
        @endforeach
    @endif
    </div>
</div>
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script src="https://cdn.rawgit.com/hilios/jQuery.countdown/2.2.0/dist/jquery.countdown.min.js" type="application/javascript"></script>
    
<script>
	$('[data-countdown]').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%D Days %H:%M:%S'));
            });
        });
</script>
    
	
</body>
</html>