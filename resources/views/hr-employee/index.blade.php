@extends('layouts.master')
@section('page_title', 'Hr Employee')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Hr Employee') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('hr-employees.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
										<th>Lname</th>
										<th>Fathers Name</th>
										<th>Dob</th>
										<th>Address</th>
										<th>Bank Account Number</th>
										<th>Mobile</th>
										<th>Cnic</th>
										<th>Created Date</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($hrEmployees as $hrEmployee)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $hrEmployee->fname }}</td>
											<td>{{ $hrEmployee->lname }}</td>
											<td>{{ $hrEmployee->fathers_name }}</td>
											<td>{{ $hrEmployee->dob }}</td>
											<td>{{ $hrEmployee->address }}</td>
											<td>{{ $hrEmployee->bank_account_number }}</td>
											<td>{{ $hrEmployee->mobile }}</td>
											<td>{{ $hrEmployee->cnic }}</td>
											<td>{{ $hrEmployee->created_date }}</td>

                                            <td>
                                                <form action="{{ route('hr-employees.destroy',$hrEmployee->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('hr-employees.show',$hrEmployee->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('hr-employees.edit',$hrEmployee->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
