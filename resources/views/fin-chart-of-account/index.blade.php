@extends('layouts.master')
@section('page_title', 'Fin Chart Of Account')
@section('content')

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
                {{ __('Fin Chart Of Account') }}
            </span>

            <div class="float-right">
                <a href="{{ route('fin-chart-of-accounts.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                        <th>Code</th>
                        <th>Level</th>
                        <th>Parent Code</th>
                        <th>Created Date</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($finChartOfAccounts as $finChartOfAccount)
                    <tr>
                        <td>{{ ++$i }}</td>

                        <td>{{ $finChartOfAccount->title }}</td>
                        <td>{{ $finChartOfAccount->code }}</td>
                        <td>{{ $finChartOfAccount->level }}</td>
                        <td>{{ $finChartOfAccount->parent_code ? $finChartOfAccount->parent_code : "-" }}</td>
                        <td>{{ date("j M Y H:i A", strtotime($finChartOfAccount->created_at))  }}</td>

                        <td>
                            <form action="{{ route('fin-chart-of-accounts.destroy',$finChartOfAccount->id) }}" method="POST">
                                <a class="btn btn-sm btn-primary " href="{{ route('fin-chart-of-accounts.show',$finChartOfAccount->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                <a class="btn btn-sm btn-success" href="{{ route('fin-chart-of-accounts.edit',$finChartOfAccount->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
