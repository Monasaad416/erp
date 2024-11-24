@if(session()->has('success'))
<div class="container">
    <div class="row alert alert-success">
        {{session('success')}}
    </div>
</div>    
@endif

@if(session()->has('update'))
    <div class="container">
        <div class="row alert alert-info">
            {{session('update')}}
        </div>
    </div>
@endif


@if(session()->has('delete'))
    <div class="container">
        <div class="row alert alert-danger">
            {{session('delete')}}
        </div>
    </div>
@endif


x
