<!DOCTYPE html>
<html lang="id" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <title>{{ config('app.name') }}</title>
  <style>
    /* Reset */
    *, *::before, *::after { box-sizing: border-box; }
    body, html { margin: 0; padding: 0; width: 100% !important; }
    body {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      background-color: #f4f4f5;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }
    img { border: 0; outline: none; max-width: 100%; }
    a  { color: inherit; }
    table { border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    td, th { padding: 0; }

    /* Wrapper */
    .email-wrapper {
      width: 100%;
      background-color: #f4f4f5;
      padding: 40px 16px;
    }
    .email-card {
      max-width: 560px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    }

    /* Header */
    .email-header {
      background-color: #111827;
      padding: 32px 40px 28px;
      text-align: left;
    }
    .email-header-logo {
      font-size: 20px;
      font-weight: 900;
      letter-spacing: -0.5px;
      color: #ffffff;
      text-decoration: none;
    }
    .email-header-logo span {
      color: #818cf8; /* indigo-400 */
    }

    /* Body */
    .email-body {
      padding: 40px 40px 32px;
    }
    .email-body p {
      font-size: 15px;
      line-height: 1.7;
      color: #374151;
      margin: 0 0 16px;
    }
    .email-body h1 {
      font-size: 24px;
      font-weight: 900;
      letter-spacing: -0.5px;
      color: #111827;
      margin: 0 0 20px;
      line-height: 1.2;
    }
    .email-body a {
      color: #4f46e5;
      text-decoration: underline;
    }

    /* Divider */
    .email-divider {
      height: 1px;
      background-color: #f3f4f6;
      margin: 28px 0;
    }

    /* Subcopy (teks kecil di bawah tombol) */
    .email-subcopy {
      padding: 0 40px 32px;
    }
    .email-subcopy p {
      font-size: 12px;
      line-height: 1.6;
      color: #9ca3af;
      margin: 0;
    }
    .email-subcopy a {
      color: #6b7280;
      word-break: break-all;
    }

    /* Footer */
    .email-footer {
      background-color: #111827;
      padding: 28px 40px;
      text-align: center;
    }
    .email-footer p {
      font-size: 12px;
      color: #6b7280;
      margin: 0 0 6px;
      line-height: 1.6;
    }
    .email-footer a {
      color: #818cf8;
      text-decoration: none;
    }
    .email-footer a:hover {
      text-decoration: underline;
    }
    .email-footer .footer-brand {
      font-size: 13px;
      font-weight: 700;
      color: #9ca3af;
      margin-bottom: 8px;
    }

    /* Tombol CTA sudah di button.blade.php */

    /* Responsive */
    @media only screen and (max-width: 600px) {
      .email-body    { padding: 28px 24px 24px !important; }
      .email-header  { padding: 24px 24px 20px !important; }
      .email-subcopy { padding: 0 24px 24px !important; }
      .email-footer  { padding: 24px 24px !important; }
    }
  </style>
</head>
<body>

<div class="email-wrapper">
  <div class="email-card">

    <!-- Header -->
    @include('vendor.mail.html.header')

    <!-- Body — konten dari masing-masing Mailable -->
    <div class="email-body">
      {{ Illuminate\Mail\Markdown::parse($slot) }}

      {{ $subcopy ?? '' }}
    </div>

    <!-- Subcopy (teks URL fallback untuk tombol) -->
    @isset($subcopy)
    <div class="email-subcopy">
      {{ Illuminate\Mail\Markdown::parse($subcopy) }}
    </div>
    @endisset

    <!-- Footer -->
    @include('vendor.mail.html.footer')

  </div>

  <!-- Fine print di bawah card -->
  <p style="text-align:center; font-size:11px; color:#9ca3af; margin-top:20px; line-height:1.5;">
    Email ini dikirim otomatis. Mohon tidak membalas email ini.<br>
    © {{ date('Y') }} PindahTangan. All rights reserved.
  </p>
</div>

</body>
</html>