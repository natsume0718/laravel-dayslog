@if (session('success'))
<div class="row message-area">
    <div class="col-lg-4 col-md-12 col-xs-12"></div>
    <div class="col-lg-4 col-md-12 col-xs-12">
        <div class="show-box">
            <div class="alert alert-success text-center py-3 my-0">
                {{ session('success') }}
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-xs-12"></div>
</div>
@elseif (session('error'))
<div class="row message-area">
    <div class="col-lg-4 col-md-12 col-xs-12"></div>
    <div class="col-lg-4 col-md-12 col-xs-12">
        <div class="show-box">
            <div class="alert alert-danger text-center py-3 my-0">
                {{ session('error') }}
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-xs-12"></div>
</div>
@endif