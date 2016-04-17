<?php
$module = '';
if (isset($data['modules']) && !empty($data['modules']))
    $module = $data['modules'];
?>
<nav class="mainmenubg" role="navigation">
    <div class="mainmenu">
        <div class="menu_mob_btn"></div>
        <ul class="menu" id="menu">
            <li class="@if($module=='') current @endif"><a href="{{url('/')}}">Home</a></li>
            <li class="insights @if($module=='insights') current @endif"><a href="{{url('insights/products')}}">INSIGNTS</a></li>
            <li class="plan @if($module=='plan') current @endif"><a href="{{url('plan')}}">PLAN</a></li>
            <li class="kpi @if($module=='kpi') current @endif"><a href="{{url('kpi')}}">KPI</a></li>
            <li class="customers @if($module=='customers') current @endif"><a href="{{url('customers')}}">CUSTOMERS</a></li>
            <li class="applications @if($module=='applications') current @endif"><a href="{{url('applications')}}">APPS</a></li>
            @if($data['user']->is('admin'))
                <li class="users @if($module=='users') current @endif"><a href="{{url('users')}}">users</a></li>
            @endif
        </ul>

        <script type="text/javascript">
            var dropdown = new TINY.dropdown.init("dropdown", {id: 'menu', active: 'menuhover'});
        </script>
    </div>
</nav>

{{--@if(@$data['cur_mod']=='activities'--}}

{{-- @if($data['user']->can('accounts.index')) --}}