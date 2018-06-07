@extends('layouts.app')

@section('title')
    Transaction Report
@endsection

@section('content')

<div class="col-12 mt-3">

    <form class="form-inline" action="{{ route('report.index') }}" method="get">

        <input type="text" class="form-control mb-2 mr-sm-2" id="username" name="username" placeholder="Jane Doe" value="{{ request('username') }}" required>

        <input type="date" class="form-control mb-2 mr-sm-2" id="period_start" name="period_start" value="{{ request('period_start') }}">

        <input type="date" class="form-control mb-2 mr-sm-2" id="period_end" name="period_end" value="{{ request('period_end') }}">

        <button type="submit" class="btn btn-primary mb-2">Submit</button>

    </form>

</div>

@if ($errors->any())
    <div class="col-12 alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(!$errors->any() && isset($user) && $user->transactionsRaw && $user->transactionsRaw->count())

<div class="col-12 mt-3">
    <form action="{{ route('report.export_csv') }}" method="post" target="_blank">
        {{ csrf_field() }}

        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Amount {{ $user->currency_code }}</th>
                    <th scope="col">Created</th>
                </tr>
            </thead>

            <tbody>
            @foreach($user->transactionsRaw as $transaction)

                <tr>
                    <td>
                        {{ $transaction->type_code }}
                    </td>

                    <td>
                        {{ $transaction->amount }}
                    </td>

                    <td>
                        {{ $transaction->created_at }}
                    </td>
                </tr>

            @endforeach

            </tbody>

            <tfoot>

                <tr class="table-borderless">
                    <th colspan="3">Total amount</th>
                </tr>

                <tr>
                    <td colspan="3">{{ $user->totalTransactionsAmount }} {{ $user->currency_code }}</td>
                </tr>

                <tr>
                    <td colspan="3">{{ $user->totalUsdTransactionsAmount}} USD</td>
                </tr>

                <tr>
                    <td colspan="3">
                        <input type="submit" name="submit" value="Export csv" class="btn btn-info">
                    </td>
                </tr>

            </tfoot>
        </table>

        <input type="hidden" name="period_start" value="{{ request('period_start') }}">
        <input type="hidden" name="period_end" value="{{ request('period_end') }}">
        <input type="hidden" name="username" value="{{ $user->name }}">

    </form>
</div>

@else

    <div class="col alert alert-warning">
        No transactions found
    </div>

@endif

@endsection