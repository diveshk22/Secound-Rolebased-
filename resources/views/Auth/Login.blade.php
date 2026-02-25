<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- Responsive Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <style>
        /* ================= GLOBAL RESET ================= */
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI', sans-serif;
        }

        /* ================= BODY STYLING ================= */
        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#ffffff,#ffecec);
        }

        /* ================= LOGIN CARD CONTAINER ================= */
        .login-container{
            background:white;
            width:100%;
            max-width:420px;
            padding:40px 30px;
            border-radius:10px;
            box-shadow:0 15px 30px rgba(0,0,0,0.08);
        }

        /* ================= HEADING ================= */
        h2{
            text-align:center;
            margin-bottom:25px;
            color:#111827;
        }

        /* ================= HOME LINK ================= */
        .home-link{
            text-align:center;
            margin-bottom:15px;
        }

        .home-link a{
            text-decoration:none;
            color:#ff2d20;
            font-size:14px;
        }

        /* ================= ERROR MESSAGE ================= */
        .error{
            background:#ffe5e5;
            color:#b91c1c;
            padding:10px;
            border-radius:6px;
            margin-bottom:15px;
            font-size:14px;
        }

        /* ================= FORM GROUP ================= */
        .form-group{
            margin-bottom:18px;
        }

        label{
            display:block;
            margin-bottom:6px;
            font-size:14px;
            color:#374151;
        }

        input{
            width:100%;
            padding:10px;
            border:1px solid #d1d5db;
            border-radius:6px;
            font-size:14px;
        }

        input:focus{
            outline:none;
            border-color:#ff2d20;
        }

        /* ================= LOGIN BUTTON ================= */
        button{
            width:100%;
            padding:12px;
            background:#ff2d20;
            color:white;
            border:none;
            border-radius:6px;
            font-size:15px;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#e02417;
        }
    </style>
</head>
<body>

<!-- ================= LOGIN CARD ================= -->
<div class="login-container">

    <!-- Page Heading -->
    <h2>Login to Your Account</h2>

    <!-- Link to Home Page -->
    <div class="home-link">
        <a href="{{ url('/') }}">← Go To Home</a>
    </div>

    <!-- Error Message (if login fails) -->
    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <!-- Email Field -->
        <div class="form-group">
            <label>Email</label>
            <input id="email" type="email" name="email" required autofocus>
        </div>

        <!-- Password Field -->
        <div class="form-group">
            <label>Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <!-- Submit Button -->
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
