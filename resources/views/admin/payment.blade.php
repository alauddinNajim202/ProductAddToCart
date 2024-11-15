

<!DOCTYPE html>
<html>
<head>
    <title>Admin Payments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Payment Management</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->customer_name }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($payment->status == 'pending') bg-warning text-dark
                                    @elseif($payment->status == 'success') bg-success
                                    @elseif($payment->status == 'rejected') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                @if($payment->status == 'pending')
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.payments.approve', $payment) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted bg-info p-2">Payment </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            
        </div>
    </div>
</div>

</body>
</html>
