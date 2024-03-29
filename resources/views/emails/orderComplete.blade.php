<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td style="padding: 20px 0; text-align: center;">
                <img src="{{ asset('Logo/ORVS.png') }}" alt="Logo" width="150" height="150"
                    style="display: block; margin: 0 auto;">
            </td>
        </tr>
        <tr>
            <td style="background-color: #ffffff; padding: 20px;">
                <h2 style="color: #333; font-size: 24px; margin: 0;">Thank You for Your Purchase</h2>
                <p style="color: #666; font-size: 16px; margin: 20px 0;">
                    We are excited to inform you that your order has been successfully processed. Your rental request
                    has been accepted by the Rental Agency, and your order is delivered. We look forward to
                    serving you with our high-quality vehicles and services. Don't forget to leave a review!
                </p>
                <div style="text-align: center;">
                    <a href="{{ route('homepage') }}"
                        style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; font-size: 16px; border-radius: 5px;">Continue
                        Browsing</a>
                </div>
                <p style="color: #666; font-size: 16px; margin: 20px 0;">If you have any questions or need further
                    assistance, please do not hesitate to contact us at:
                    <a href="mailto:hello@example.com">hello@example.com</a>
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #333; padding: 20px; text-align: center; color: #fff; font-size: 14px;">
                &copy; {{ date('Y') }} Vehicle Rental System. All rights reserved.
            </td>
        </tr>
    </table>
</body>
