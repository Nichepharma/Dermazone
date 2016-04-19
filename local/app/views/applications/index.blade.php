@extends('layout.main')

@section('content')
    <div class="container-fluid page-content1">

        <div class="col-sm-11 contentpart">
            <h2>Applications </h2>


            <table class="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Version</th>
                    <th>Install</th>
                </tr>
                </thead>
                <tbody>

                <tr class="warning">
                    <th scope="row" width="50%"><img src="http://www.tacitapp.com/chiesi/apps/plan/images/Icon.png" border="0" alt="" class="media-middle"> Tacitplanchiesi</th>
                    <td>603.4 KB</td>
                    <td>1.0</td>
                    <td><a href="itms-services://?action=download-manifest&amp;url=https://www.tacitapp.com/chiesi/apps/plan/TacitPlanChiesi.plist">Install</a></td>
                </tr>
                </tbody>
            </table>
            <div class="col-md-2 col-xs-6">
                <!--<button onclick="window.location.href='otherApps.php'" class="buttonallsite3">Other Products</button></div>-->
                <table class="table">


                </table>
            </div>
        </div>

    </div>
@stop
