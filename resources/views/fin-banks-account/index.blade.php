@extends('layouts.master')
@section('page_title', 'Fin Banks Account')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Fin Banks Account') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('fin-banks-accounts.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>Bank Name</th>
										<th>Bank Account</th>
										<th>Trans Amount</th>
										<th>Slip Date</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($finBanksAccounts as $finBanksAccount)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $finBanksAccount->bank_name }}</td>
											<td>{{ $finBanksAccount->bank_account }}</td>
											<td>{{ $finBanksAccount->trans_amount }}</td>
											<td>{{ $finBanksAccount->slip_date }}</td>

                                            <td>
                                                <form action="{{ route('fin-banks-accounts.destroy',$finBanksAccount->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('fin-banks-accounts.show',$finBanksAccount->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('fin-banks-accounts.edit',$finBanksAccount->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
