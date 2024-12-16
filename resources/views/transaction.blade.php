@extends('layouts.main')

@section('title', 'Initiate Payment')

@section('content')
<!-- Display success and error messages -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Initiate Payment Form -->
<div class="form-container">
    <div id="schedule-form">
        @if($pendingJadwal && $pendingJadwal->status == 'pending')
            <p>There is a pending payment schedule for {{ $pendingJadwal->selected_date }}.</p>
            <form action="{{ route('jadwal.cancel', $pendingJadwal->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Cancel Pending Payment Schedule</button>
            </form>
        @else
            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="accountName">Payment Source Account</label>
                        <div class="btn-group w-100">
                            <select id="sourceAccount" name="payment_account" class="form-select btn btn-primary dropdown-toggle">
                                <option value="">Select an account</option>
                                @foreach ($sumberdana as $account)
                                    <option value="{{ $account->id }}">{{ $account->accountname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="paymentDate">Payment Date and Time</label>
                        <input type="datetime-local" id="paymentDate" name="payment_date" class="form-control" required />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Payment Schedule</button>
            </form>
        @endif
    </div>
</div>

<hr />

<div class="countdown-container">
    @if($pendingJadwal && $pendingJadwal->status == 'pending')
        <h3>Next Payment Schedule: {{ $pendingJadwal->selected_date }}</h3>
        <div id="countdown"></div>
    @endif
</div>

<hr />

<div>
    <h3>Current Console Time: <span id="console-time"></span></h3>
</div>

<!-- Form to trigger transaction processing -->
<div class="transaction-trigger-form">
    <form id="transactionForm" action="{{ route('transaction.process') }}" method="POST">
        @csrf
        <div class="row mb-2">
            <div class="col-md-4">
                <label for="companyId">Company</label>
                <select id="companyId" name="company_id" class="form-control" required>
                    <option value="" disabled selected>Select a company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->nama_perusahaan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" id="triggerButton" class="btn btn-primary">Trigger Transaction</button>
    </form>
</div>


<h3>Transaction History</h3>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Target Account</th>
                <th>Name</th>
                <th>Source Account</th>
                <th>Date</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->pekerja->rekening_pekerja ?? 'N/A' }}</td>
                    <td>{{ $transaction->pekerja->nama_pekerja ?? 'N/A' }}</td>
                    <td>{{ $transaction->sumberDana->no_rekening ?? 'N/A' }}</td>
                    <td>{{ $transaction->tgl_byr }}</td>
                    <td>Rp {{ number_format($transaction->nominal, 2) }}</td>
                    <td>
                        <span class="badge {{ $transaction->status == 'completed' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
function updateConsoleTime() {
    var now = new Date();
    document.getElementById("console-time").innerHTML = now.toLocaleString();
}

setInterval(updateConsoleTime, 1000); // Update the time every second

@if($pendingJadwal && $pendingJadwal->status == 'pending')
    var countDownDate = new Date("{{ $pendingJadwal->selected_date }}").getTime();
    var countdownfunction = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        if (distance < 0) {
            clearInterval(countdownfunction);
            document.getElementById("countdown").innerHTML = "Countdown Complete!";
            // Allow new schedules to be created once the countdown is complete and update status
            fetch('{{ route('update.status.process.payments', $pendingJadwal->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("schedule-form").innerHTML = `
                        <form action="{{ route('jadwal.store') }}" method="POST">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label for="accountName">Payment Source Account</label>
                                    <div class="btn-group w-100">
                                        <select id="sourceAccount" name="payment_account" class="form-select btn btn-primary dropdown-toggle">
                                            <option value="">Select an account</option>
                                            @foreach ($sumberdana as $account)
                                                <option value="{{ $account->id }}">{{ $account->accountname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="paymentDate">Payment Date and Time</label>
                                    <input type="datetime-local" id="paymentDate" name="payment_date" class="form-control" required />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Payment Schedule</button>
                        </form>
                    `;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }, 1000);
@endif

document.getElementById("triggerButton").addEventListener("click", function() {
    if (document.getElementById("transactionForm")) {
        document.getElementById("transactionForm").submit(); // Submit the form
    }
});
</script>

@endsection
