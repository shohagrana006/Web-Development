@extends('layouts.dashboard_app')
@section('home')
active
@endsection
@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <span class="breadcrumb-item active">Home</span>
    </nav>
    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Home Page</h5>
        </div><!-- sl-page-title -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="card">
                         @if (session('send_status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('send_status') }}
                            </div>
                        @endif
                        <div class="m-4">
                            <a href="{{ url('user/newsletter') }}" class="btn btn-info">Send Newsletter to {{ $totalUsers }} User</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="m-4">
                            <h2>Total users: {{ $totalUsers }}</h2>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th>SL no.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $loop->index }}</td>
                                        <td>{{ Str::title($user->name) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <li>{{ $user->created_at->format('d/m/Y') }}</li>
                                            <li>{{ $user->created_at->format('h:i:s a') }}</li>
                                            <li>{{ $user->created_at->diffForHumans() }}</li>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection

@section('footer_script')
  <script>
      var ctx = document.getElementById('myChart1').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'doughnut',

            // The data for our dataset
            data: {
                labels: ['Paid', 'Unpaid', 'Cencal'],
                datasets: [{
                    label: 'Transition Graph',
                    backgroundColor: [
                        '#36A2EB',
                        '#F7B217',
                        '#E82B2C',
                        ],
                    borderColor: '#f1f1f1',
                    data: [ {{$paidStatus}}, {{$unpaidStatus}}, {{$cencalStatus}} ]
                }]
            },

            // Configuration options go here
            options: {}
        });

        var ctx = document.getElementById('myChart2').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: ['Total ammount($)', 'Total sale($)', ''],
                datasets: [{
                    label: 'Total products ammount vs Total sale',
                    backgroundColor: ['rgb(255, 99, 132)', 'green'],
                    borderColor: 'rgb(255, 99, 132)',
                    data: [ {{$totalStockPrice}},{{$totalSale}}, 0 ]
                }]
            },

            // Configuration options go here
            options: {}
        });
  </script>
@endsection
