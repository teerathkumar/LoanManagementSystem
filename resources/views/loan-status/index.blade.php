@extends('layouts.master')
@section('page_title', 'Loan Status')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Loan Status') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('loan-statuses.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatable-button-html5-columns">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Title</th>
										<th>Status</th>
										<th>Created Date</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loanStatuses as $loanStatus)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $loanStatus->title }}</td>
											<td>{{ $loanStatus->status }}</td>
											<td>{{ $loanStatus->created_date }}</td>

                                            <td>
                                                <form action="{{ route('loan-statuses.destroy',$loanStatus->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('loan-statuses.show',$loanStatus->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('loan-statuses.edit',$loanStatus->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                

@endsection
