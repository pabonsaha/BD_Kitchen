@extends('user.layout.app')

@section('content')
    <section id="registerContent">
        <div id="mainContent">
            <div id="imagecontainer">
                <img src="{{ asset('assets/img/pages/loginPage.webp') }}" alt="">
            </div>
            <div id="formcontainer">
                <form action="{{ route('loginConfirm') }}" method="POST">
                    <h4>Login To Your Account</h4>
                    @csrf

                    <div class="form">
                        <label for="Name">Email</label>
                        <input class="inputForm" required type="email" name="email">

                    </div>
                    <div class="form">
                        <label for="Name">Password</label>
                        <input class="inputForm" required type="password" name="password">

                    </div>
                    @if (Session::has('message'))
                        <p class="text-danger">{{ Session::get('message') }}</p>
                    @endif

                    <div class="submit">
                        <p>Do not have account? <a href="{{ route('userRegister') }}">register</a></p>
                        <button type="submit">Login</button>
                    </div>

                </form>
            </div>
        </div>

    </section>
@endsection

@push('css')
    <style>
        #registerContent {
            font-family: "Inter", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-variation-settings: "slnt" 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 80vh;
        }

        #mainContent {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 70%;
            height: 90%;
            gap: 2
        }

        #imagecontainer {

            width: 50%;
            height: 100%;
            display: flex;
            justify-content: flex-end;
        }

        #imagecontainer img {
            width: 80%;
            height: inherit;

        }

        #formcontainer {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #formcontainer h4 {
            color: #E32938;
            font-size: 24px;
            font-weight: bold;
        }

        .form {
            display: flex;
            flex-direction: column;
            margin-bottom: 8px;
        }

        .form input {
            width: 300px;
            border: 1px solid rgb(168, 168, 168);
            border-radius: 3px;
            height: 30px;
            padding-left: 5px;
        }

        .form .error {
            font-size: 12px;
            color: #E32938;
        }

        .submit {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;

        }

        .submit p {
            font-size: 14px;
            align-self: flex-end;
            margin-bottom: 8px;
            margin-top: 0px;
        }

        .submit p a {
            color: #E32938;
            font-weight: bold;
        }

        .submit button {
            background-color: #E32938;
            color: white;
            font-weight: 400;
            font-size: 16px;
            padding: 5px 20px;
            border-radius: 5px;
        }

        .text-danger{
            color: #E32938;
            font-size: 16px;
        }
    </style>
@endpush
