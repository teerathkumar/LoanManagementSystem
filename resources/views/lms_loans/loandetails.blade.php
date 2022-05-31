@extends('layouts.master')
@section('page_title', 'Manage Financing Details')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Process Financing Scheduling</h6>
        {!! Qs::getPanelOptions() !!}
        
        
    </div>

    <div class="card-body">
        <div class="tab-content">

            
            
            <div class="tab-pane fade show active" >                         
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Group</th>
                            <th>Office</th>
                            <th>Principle</th>
                            <th>Profit</th>
                            <th>Disb.Date</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tt_records as $mc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mc->loan_borrower->fname }}</td>
                            <td>{{ $mc->loan_group->name }}</td>
                            <td>{{ $mc->loan_office->name }}</td>
                            <td>{{ number_format($mc->total_amount_pr,0) }}</td>
                            <td>{{ number_format($mc->total_amount_mu,0) }}</td>
                            <td>{{ date("d M Y",strtotime($mc->disb_date)) }}</td>
                            <td><?php echo app('App\Http\Controllers\LoansController')->getStatus($mc->loan_status_id, $mc->loan_status->title) ?></td>
                            <td class="text-center">
                                
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            {{--View--}}
                                            <a href="{{ route('ttr.showloan', $mc->id) }}" class="dropdown-item"><i class="icon-eye"></i> View Profile</a>
                                            <a href="{{ route('ttr.show_schedule', $mc->id) }}" class="dropdown-item"><i class="icon-eye"></i> View Schedule</a>
                                            <a href="{{ route('ttr.loanstep', $mc->id) }}" class="dropdown-item"><i class="icon-eye"></i> Generate Schedule</a>
                                            <a href="{{ route('loans.pay', $mc->id) }}" class="dropdown-item"><i class="icon-cash"></i> Pay Installment</a>
                                            <a data-target="#exampleModalLong" data-toggle="modal"  class="dropdown-item"><i class="icon-cash"></i> Pay</a>

                                            @if(Qs::userIsTeamSA())
                                            {{--Manage--}}
                                            {{--Edit--}}
                                            
                                            @endif

                                            {{--Delete--}}
                                            @if(Qs::userIsSuperAdmin())
                                            
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            

        </div>
    </div>
    
    
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    
</div>

{{--TimeTable Ends--}}

@endsection
