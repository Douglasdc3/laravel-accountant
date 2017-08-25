@extends('accountant::app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @Foreach($charges as $charge)
                        <tr class="clickable" data-href="{{ url('accountant/charge', $charge->id) }}">
                            <th scope="row">
                                @if($charge->refunded)
                                    <span class="label label-default">Refunded</span>
                                @elseif(!$charge->paid)
                                    <span class="label label-danger">Failed</span>
                                @else
                                    <span class="label label-success">Paid</span>
                                @endif
                            </th>
                            <td>${{ number_format($charge->amount / 100, 2) }}</td>
                            <td>{{ $charge->id }}</td>
                            <td>{{ Carbon\Carbon::createFromTimestamp($charge->created)->format('Y/m/d h:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{ $charges->links() }}
            </div>
        </div>
    </div>
@endsection