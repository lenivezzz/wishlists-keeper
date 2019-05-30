@if ($message = Session::has('success'))
    @include('layouts.components.alert', ['color' => 'success', 'message' => Session::get('success')])
@elseif ($message = Session::has('warning'))
    @include('layouts.components.alert', ['color' => 'warning', 'message' => Session::get('warning')])
@elseif ($message = Session::has('error'))
    @include('layouts.components.alert', ['color' => 'error', 'message' => Session::get('error')])
@endif
