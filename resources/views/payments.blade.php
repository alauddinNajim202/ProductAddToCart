<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
        @endsession

        @session('error')
        <div class="alert alert-danger" role="alert">
            {{ $value }}
        </div>
        @endsession
        <h2>Payment Form</h2>
        @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
        @endsession

        @session('error')
        <div class="alert alert-danger" role="alert">
            {{ $value }}
        </div>
        @endsession
        <div class="col-lg-6 bg-info p-4">
            <form action="{{ route('process.payment') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="cardOwner" class="form-label">Card Owner Name</label>
                    <input type="text" id="cardOwner" name="card_owner" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cardNumber" class="form-label">Card Number</label>
                    <input type="text" id="cardNumber" name="card_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cvc" class="form-label">CVC</label>
                    <input type="text" id="cvc" name="cvc" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expiryMonth" class="form-label">Expiry Month</label>
                            <select id="expiryMonth" name="expiry_month" class="form-select" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expiryYear" class="form-label">Expiry Year</label>
                            <select id="expiryYear" name="expiry_year" class="form-select" required>
                                @for($i = now()->year; $i <= now()->year + 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Pay</button>
            </form>
        </div>
    </div>
</body>

</html>