@extends('layouts.master')
@section('page_title', 'Financing Borrower')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Financing Borrower') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('loan-borrowers.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Fname</th>
										<th>Mname</th>
										<th>Lname</th>
										<th>Gender</th>
										<th>Dob</th>
										<th>Caste</th>
										<th>Cnic</th>
										<th>Mobile</th>
										<th>Address</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loanBorrowers as $loanBorrower)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $loanBorrower->fname }}</td>
											<td>{{ $loanBorrower->mname }}</td>
											<td>{{ $loanBorrower->lname }}</td>
											<td>{{ $loanBorrower->gender }}</td>
											<td>{{ $loanBorrower->dob }}</td>
											<td>{{ $loanBorrower->caste }}</td>
											<td>{{ $loanBorrower->cnic }}</td>
											<td>{{ $loanBorrower->mobile }}</td>
											<td>{{ $loanBorrower->address }}</td>

                                            <td>
                                                <form action="{{ route('loan-borrowers.destroy',$loanBorrower->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('loan-borrowers.show',$loanBorrower->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('loan-borrowers.edit',$loanBorrower->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
