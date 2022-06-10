@extends('layouts.master')
@section('page_title', 'Takaful Schedule')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <span class="card-title">Takaful Schedule</span>
    </div>
    <div class="card-body">
        <table>
            <td>            <table border="1" cellpadding="3">
                    <tr>
                        <th>Sr#</th>
                        <th>Type</th>
                        <th>Issue Date</th>
                        <th>Policy Number</th>
                        <th>Covered Amount</th>
                        <th>Expiry Date</th>
                        <th>Renewal Date</th>
                    </tr>
                    @foreach($property as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>Property</td>
                        <td>{{ $row->start_date }}</td>
                        <td>{{ $row->policy_number }}</td>
                        <td>{{ number_format($row->covered_amount,0) }}</td>
                        <td>{{ $row->end_date }}</td>
                        <td>{{ $row->renewal_date }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
            <td>            <table border="1" cellpadding="3">
                    <tr>
                        <th>Sr#</th>
                        <th>Type</th>
                        <th>Issue Date</th>
                        <th>Policy Number</th>
                        <th>Covered Amount</th>
                        <th>Expiry Date</th>
                        <th>Renewal Date</th>
                    </tr>
                    @foreach($property as $row)
                    <tr>
                        <td>{{ $j++ }}</td>
                        <td>Life</td>
                        <td>{{ $row->start_date }}</td>
                        <td>{{ $row->policy_number }}</td>
                        <td>{{ number_format($row->covered_amount,0) }}</td>
                        <td>{{ $row->end_date }}</td>
                        <td>{{ $row->renewal_date }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </table>
    </div>
</div>

@endsection
