<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Verify Login
    </title>

</head>

<body>

<div class="container">

    <h2>
        Verify Your Login
    </h2>


    @if ($errors->any())

        <div class="alert alert-danger">

            {{ $errors->first() }}

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('admin.otp.verify') }}"
    >

        @csrf

        <div class="form-group">

            <label>
                OTP Code
            </label>

            <input
                type="text"
                name="code"
                maxlength="6"
                class="form-control"
                required
                autofocus
            >

        </div>


        <button
            type="submit"
            class="btn btn-primary"
        >
            Verify
        </button>

    </form>

</div>

</body>

</html>