<p>&nbsp;</p>

<table style="background-color:#00000;" width="100%; ">
    <tr>
        <td>
            <table style="border: 1px solid #f1f1f1; border-collapse: collapse;" border="0" max-width="600"
                align="center" bgcolor="#fff">
                <tbody>
                    <td style="background-color: #0D657E;padding: 20px 0; text-align: center; width:900px;">
                        <img class="" src="{{ asset(shopSetting()->logo) }}" alt="Logo" />
                        <h1 style="color:#f1f1f1;text-align: center">Congratulations! Welcome to House Brands</h1>
                    </td>
                    <tr>
                        <td
                            style="padding: 50px 10px 20px 10px; color: #000000; font-family: 'Quicksand', sans-serif; font-size: 16px; text-align: center; line-height: 26px;">
                            <h3>Hi {{ $user->name }},</h3>
                            <h1 style="margin-bottom: 10px">Your account created successfully. Now you can signin In
                                your account. <a href="{{ env('APP_URL') }}" target="_blank">House Brand Admin Panel</a>
                            </h1>
                            <p><strong>Your account Credentials. <span style="color: red"> Don't share with
                                        anyone.</span></strong></p>
                            {{-- <p>Email:<strong>{{ $user->email }}</strong></p>
                            <p>Password:<strong>12345678</strong></p>
                            <p>Change your default password.</p> --}}
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr style="font-family: 'Quicksand', sans-serif;">
                        <td
                            style="padding: 20px 20px 20px 20px; background-color: #0092bb; color:#ffffff; font-family: 'Quicksand', sans-serif; font-size: 16px; line-height: 20px; text-align: center; line-height: 26px;">
                            <p>© {{ date('Y') }} Housebrands. All rights reserved.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
