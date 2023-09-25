<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td style="padding: 20px 0; text-align: center;">
                <img src="#" alt="Logo" width="150" height="150" style="display: block; margin: 0 auto;">
            </td>
        </tr>
        <tr>
            <td style="background-color: #ffffff; padding: 20px;">
                <h2 style="color: #333; font-size: 24px; margin: 0;">Password Reset Request</h2>
                <p style="color: #666; font-size: 16px; margin: 20px 0;">You have requested to reset your password.
                    Click the button below to reset your password:</p>
                <div style="text-align: center;">
                    <a href="{{ route('password.reset.get', $token) }}"
                        style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; font-size: 16px; border-radius: 5px;">Reset
                        Password</a>
                </div>
                <p style="color: #666; font-size: 16px; margin: 20px 0;">If you did not request this password reset,
                    please ignore this email.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #333; padding: 20px; text-align: center; color: #fff; font-size: 14px;">
                &copy; 2023 Vehicle Rental System. All rights reserved.
            </td>
        </tr>
    </table>
</body>
