@extends('layouts.dashboard_app')
@section('contact')
active
@endsection
@section('dashboard_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <span class="breadcrumb-item active">Contact</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Contact Page</h5>
        </div><!-- sl-page-title -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
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
                                        <th>Contact Name</th>
                                        <th>Contact email</th>
                                        <th>Contact subject</th>
                                        <th>Contact massage</th>
                                        <th>Contact attachment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ Str::title($contact->contact_name) }}</td>
                                        <td>{{ $contact->contact_email }}</td>
                                        <td>{{ $contact->contact_subject }}</td>
                                        <td>{{ $contact->contact_massage }}</td>
                                        <td>
                                        @if ($contact->contact_attachment)
                                          <a href="{{ asset('storage')  }}/{{ $contact->contact_attachment }}"><i class="fa fa-file"></i></a>
                                          <a href="{{ url('contact/download') }}/{{ $contact->id }}"><i class="fa fa-download"></i></a>
                                        @else
                                          <span>No file</span>
                                        @endif
                                         </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection
