@extends('layouts.master')
@section('page_title', 'Aml Blacklist')
@section('content')

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('AML Blacklist') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('aml-blacklists.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Cnic</th>
                                        <th>Name</th>
                                        <th>Guardian</th>
                                        <th>District</th>
                                        <th>Province</th>
                                        <th>Status</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($amlBlacklists as $amlBlacklist)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $amlBlacklist->cnic }}</td>
                                            <td>{{ $amlBlacklist->name }}</td>
                                            <td>{{ $amlBlacklist->guardian }}</td>
                                            <td>{{ $amlBlacklist->district }}</td>
                                            <td>{{ $amlBlacklist->province }}</td>
                                            <td>{{ $amlBlacklist->status }}</td>
                                            <td>
                                                <form action="{{ route('aml-blacklists.destroy',$amlBlacklist->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('aml-blacklists.show',$amlBlacklist->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('aml-blacklists.edit',$amlBlacklist->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
