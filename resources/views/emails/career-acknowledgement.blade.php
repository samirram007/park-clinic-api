<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received — Park Clinic</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Roboto', 'Helvetica Neue', Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    <!-- Preview Text -->
    <p style="display:none;max-height:0;overflow:hidden;mso-hide:all;">Thank you for applying for the {{ $careerApplication->position }} position at Park Clinic. We've received your application.</p>
    <!-- Wrapper -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9;">
        <tr>
            <td align="center" style="padding: 40px 16px;">
                <!-- Email Card -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 580px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">

                    <!-- Header Banner -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 32px 40px; text-align: center;">
                            <!-- Logo Text -->
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td style="padding-right: 12px; vertical-align: middle;">
                                        <div style="width: 40px; height: 40px; background-color: #2a9d9d; border-radius: 10px; text-align: center; line-height: 40px;">
                                            <span style="color: #ffffff; font-family: 'Montserrat', Arial, sans-serif; font-size: 18px; font-weight: 800;">P</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-family: 'Montserrat', Arial, sans-serif; font-size: 20px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px;">PARK CLINIC</span><br>
                                        <span style="font-family: 'Roboto', Arial, sans-serif; font-size: 11px; color: #2a9d9d; letter-spacing: 1.5px; text-transform: uppercase;">NABH Certified · Sonoscan Supported</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Success Icon -->
                    <tr>
                        <td align="center" style="padding: 32px 40px 0;">
                            <div style="width: 64px; height: 64px; background-color: #22c55e; border-radius: 50%; text-align: center; line-height: 64px; margin: 0 auto;">
                                <span style="font-size: 28px; color: #ffffff; font-family: 'Segoe UI Symbol', 'Apple Color Emoji', Arial, sans-serif;">&#10003;</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 24px 40px 0;">
                            <h1 style="margin: 0 0 8px; font-family: 'Montserrat', Arial, sans-serif; font-size: 22px; font-weight: 700; color: #1a1a2e; text-align: center;">
                                Application Received
                            </h1>
                            <p style="margin: 0; font-family: 'Roboto', Arial, sans-serif; font-size: 15px; color: #64748b; text-align: center; line-height: 1.6;">
                                Thank you, <strong style="color: #1a1a2e;">{{ $careerApplication->full_name }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Application Details Card -->
                    <tr>
                        <td style="padding: 28px 40px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                                <!-- Position Row -->
                                <tr>
                                    <td style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0;">
                                        <span style="font-family: 'Roboto', Arial, sans-serif; font-size: 12px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px;">Position Applied</span><br>
                                        <span style="font-family: 'Montserrat', Arial, sans-serif; font-size: 15px; font-weight: 600; color: #1a1a2e;">{{ $careerApplication->position }}</span>
                                    </td>
                                </tr>
                                <!-- Message Preview -->
                                @if($careerApplication->message)
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <span style="font-family: 'Roboto', Arial, sans-serif; font-size: 12px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px;">Your Cover Note</span><br>
                                        <span style="font-family: 'Roboto', Arial, sans-serif; font-size: 14px; color: #475569; line-height: 1.5; font-style: italic;">"{{ \Illuminate\Support\Str::limit($careerApplication->message, 150) }}"</span>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- What Happens Next -->
                    <tr>
                        <td style="padding: 28px 40px 0;">
                            <h2 style="margin: 0 0 16px; font-family: 'Montserrat', Arial, sans-serif; font-size: 15px; font-weight: 700; color: #1a1a2e;">
                                What Happens Next?
                            </h2>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 0 0 12px; vertical-align: top; width: 32px;">
                                        <div style="width: 26px; height: 26px; background-color: #e0f2fe; border-radius: 50%; text-align: center; line-height: 26px;">
                                            <span style="font-size: 13px; color: #2a9d9d; font-weight: 700;">1</span>
                                        </div>
                                    </td>
                                    <td style="padding: 2px 0 0 12px;">
                                        <span style="font-family: 'Roboto', Arial, sans-serif; font-size: 14px; color: #334155; line-height: 1.5;">Our recruitment team will review your application and resume.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 0 12px; vertical-align: top; width: 32px;">
                                        <div style="width: 26px; height: 26px; background-color: #e0f2fe; border-radius: 50%; text-align: center; line-height: 26px;">
                                            <span style="font-size: 13px; color: #2a9d9d; font-weight: 700;">2</span>
                                        </div>
                                    </td>
                                    <td style="padding: 2px 0 0 12px;">
                                        <span style="font-family: 'Roboto', Arial, sans-serif; font-size: 14px; color: #334155; line-height: 1.5;">If your qualifications align, we will reach out for the next steps.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0; vertical-align: top; width: 32px;">
                                        <div style="width: 26px; height: 26px; background-color: #e0f2fe; border-radius: 50%; text-align: center; line-height: 26px;">
                                            <span style="font-size: 13px; color: #2a9d9d; font-weight: 700;">3</span>
                                        </div>
                                    </td>
                                    <td style="padding: 2px 0 0 12px;">
                                        <span style="font-family: 'Roboto', Arial, sans-serif; font-size: 14px; color: #334155; line-height: 1.5;">Keep an eye on your inbox and phone for any updates.</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding: 28px 40px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="border-top: 1px solid #e2e8f0; font-size: 0; line-height: 0;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td align="center" style="padding: 24px 40px 0;">
                            <a href="https://parkclinickolkata.in/careers" target="_blank" style="display: inline-block; padding: 12px 32px; background-color: #2a9d9d; color: #ffffff; font-family: 'Montserrat', Arial, sans-serif; font-size: 14px; font-weight: 600; text-decoration: none; border-radius: 8px; letter-spacing: 0.3px;">
                                View Open Positions →
                            </a>
                        </td>
                    </tr>

                    <!-- Sign-off -->
                    <tr>
                        <td style="padding: 28px 40px 0; text-align: center;">
                            <p style="margin: 0 0 4px; font-family: 'Roboto', Arial, sans-serif; font-size: 14px; color: #475569;">
                                Best regards,
                            </p>
                            <p style="margin: 0; font-family: 'Montserrat', Arial, sans-serif; font-size: 15px; font-weight: 700; color: #1a1a2e;">
                                The Park Clinic Team
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 32px 40px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                                <tr>
                                    <td style="padding: 24px 20px; text-align: center;">
                                        <p style="margin: 0 0 8px; font-family: 'Montserrat', Arial, sans-serif; font-size: 12px; font-weight: 600; color: #1a1a2e; letter-spacing: 0.3px;">
                                            PARK SONOSCAN CLINIC
                                        </p>
                                        <p style="margin: 0 0 4px; font-family: 'Roboto', Arial, sans-serif; font-size: 12px; color: #64748b; line-height: 1.5;">
                                            4, Gorky Terrace, Minto Park, Kolkata – 700017
                                        </p>
                                        <p style="margin: 0 0 12px; font-family: 'Roboto', Arial, sans-serif; font-size: 12px; color: #64748b;">
                                            <a href="tel:+919775992022" style="color: #2a9d9d; text-decoration: none;">+91 9775992022</a> · <a href="mailto:info@parkclinickolkata.com" style="color: #2a9d9d; text-decoration: none;">info@parkclinickolkata.com</a>
                                        </p>
                                        <p style="margin: 0; font-family: 'Roboto', Arial, sans-serif; font-size: 11px; color: #94a3b8;">
                                            This is an automated response. There is no need to reply to this email.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Bottom Spacing -->
                    <tr>
                        <td style="padding: 0 0 32px;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
