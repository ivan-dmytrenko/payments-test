<?xml version="1.0"?>
<report>
    <username>{{ $user->name }}</username>
    <date-period-start>{{ $period_start }}</date-period-start>
    <date-period-end>{{ $period_end }}</date-period-end>
    <total-amount>
        <{{ $user->currency_code }}>{{ $user->totalTransactionsAmount }}</{{ $user->currency_code }}>
        <USD>{{ $user->totalUsdTransactionsAmount }}</USD>
    </total-amount>
    <transactions count="{{ $user->transactionsRaw->count() }}">
        @foreach($user->transactionsRaw as $transaction)
        <transaction type="{{ $transaction->type_code }}">
            <amount>
                <{{ $user->currency_code }}>{{ $transaction->amount_total }}</{{ $user->currency_code }}>
                <USD>{{ $transaction->amount_usd_total }}</USD>
            </amount>
            <date>
                {{ $transaction->created_at }}
            </date>
        </transaction>
        @endforeach
    </transactions>
</report>