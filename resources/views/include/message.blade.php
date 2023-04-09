@if(Session::has('success'))
    <div class="success-message">{{ Session::get('success') }}</div>
@endif

@if(Session::has('error'))
    <div class="error-message">{{Session::get('error')}}</div>
@endif
    
