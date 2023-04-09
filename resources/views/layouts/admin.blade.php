<!DOCTYPE html>
<html lang="en">
    @include('include.head')
<body>
    @include('include.header')
    <div class="section">
        @include('include.nav')
        <div class="banner">
            @include('include.message')
            @yield('section_data')
        </div>
    </div>
</body>
</html>