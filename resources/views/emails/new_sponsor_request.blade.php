{{-- @extends('layout.layout')
@section('title', 'New Sponsor Request')
@section('content') --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>New Sponsor Request — PlayMKR</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&display=swap" rel="stylesheet" />
<style>

  *, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif;
    background-color: #f2f2f2;
    -webkit-font-smoothing: antialiased;
    padding: 48px 16px;
  }

  .email-wrap {
    max-width: 580px;
    width: 100%;
    margin: 0 auto;
  }

  .email-header {
    background: #111111;
    border-radius: 16px 16px 0 0;
    padding: 28px 40px;
    border-bottom: 3px solid #e8001c;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .logo {
    font-size: 24px;
    font-weight: 900;
    letter-spacing: -0.5px;
    text-decoration: none;
  }

  .logo-white { color: #ffffff; }
  .logo-red   { color: #e8001c; }

  .header-badge {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #e8001c;
    background: rgba(232, 0, 28, 0.1);
    border: 1px solid rgba(232, 0, 28, 0.25);
    border-radius: 100px;
    padding: 5px 14px;
  }

  .email-body {
    background: #ffffff;
    padding: 44px 40px 36px;
  }

  .email-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #e8001c;
    margin-bottom: 10px;
  }

  .email-title {
    font-size: 28px;
    font-weight: 900;
    color: #111111;
    line-height: 1.15;
    letter-spacing: -0.3px;
    margin-bottom: 12px;
  }

  .email-desc {
    font-size: 13px;
    color: #888888;
    line-height: 1.7;
    margin-bottom: 32px;
  }

  .details-card {
    background: #f8f8f8;
    border: 1px solid #ebebeb;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 32px;
  }

  .details-card-header {
    padding: 14px 22px;
    border-bottom: 1px solid #ebebeb;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #e8001c;
    background: #fff;
  }

  .detail-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 11px 16px;
    border-bottom: 1px solid #ebebeb;
  }

  .detail-row:last-child {
    border-bottom: none;
  }

  /* .detail-icon {
    width: 38px;
    height: 38px;
    background: #ffffff;
    border: 1px solid #e8e8e8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  } */

  .detail-icon svg {
    width: 17px;
    height: 17px;
    stroke: #aaaaaa;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .detail-meta {
    display: flex;
    flex-direction: column;
    gap: 3px;
  }

  .detail-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #aaaaaa;
    margin: 10px 5px;
  }

  .detail-value {
    font-size: 14px;
    /* font-weight: 600; */
    /* color: #111111; */
    margin: 7px 5px;
  }

  .notice-box {
    background: #fffbf0;
    border: 1px solid #f5e0a0;
    border-left: 3px solid #f5a623;
    border-radius: 8px;
    padding: 14px 18px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 28px;
  }

  .notice-icon {
    width: 18px;
    height: 18px;
    stroke: #f5a623;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
    margin-top: 1px;
  }

  .notice-text {
    font-size: 12px;
    color: #7a6030;
    line-height: 1.6;
  }

  .notice-text strong {
    color: #5a4010;
    font-weight: 600;
  }

  .cta-btn {
    display: inline-block;
    background: #e8001c;
    color: #ffffff;
    text-decoration: none;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 15px 32px;
    border-radius: 8px;
  }

  .email-footer {
    background: #f8f8f8;
    border-top: 1px solid #ebebeb;
    border-radius: 0 0 16px 16px;
    padding: 22px 40px;
  }

  .footer-text {
    font-size: 11px;
    color: #aaaaaa;
    line-height: 1.7;
  }

</style>
</head>
<body>

<div class="email-wrap">

  <div class="email-header">
    <span class="logo">
      <span class="logo-white">PLAY</span><span class="logo-red">MKR</span>
  </div>

  <div class="email-body">

    <p class="email-eyebrow">Admin Notification</p>
    <h1 class="email-title">New Sponsor Request</h1>
    <p class="email-desc">A new sponsor request has been submitted. Please review the details below and take action from the admin panel.</p>

    <div class="details-card">
      <div class="details-card-header">Sponsor Details</div>

      <div class="detail-row">
        <div class="detail-meta">
          <span class="detail-label">Name: </span>
          <span class="detail-value">{{ $sponsorData['name'] ?? 'N/A' }}</span>
        </div>
      </div>

      <div class="detail-row">
        <div class="detail-meta">
          <span class="detail-label">Email: </span>
          <span class="detail-value">{{ $sponsorData['email'] ?? 'N/A' }}</span>
        </div>
      </div>

      <div class="detail-row">
        <div class="detail-meta">
          <span class="detail-label">Contact Number: </span>
          <span class="detail-value">{{ $sponsorData['contact_number'] ?? 'N/A' }}</span>
        </div>
      </div>

      <div class="detail-row">
        <div class="detail-meta">
          <span class="detail-label">Company Name: </span>
          <span class="detail-value">{{ $sponsorData['company_name'] ?? 'N/A' }}</span>
        </div>
      </div>

      <div class="detail-row">
        <div class="detail-meta">
          <span class="detail-label">Website url: </span>
          <span class="detail-value">{{ $sponsorData['website_url'] ?? 'N/A' }}</span>
        </div>
      </div>

      <div class="detail-row">
        <div class="detail-meta">
          <span class="detail-label">Industry: </span>
          <span class="detail-value">{{ $sponsorData['industry'] ?? 'N/A' }}</span>
        </div>
      </div>

      <div class="detail-row">
        <div class="detail-meta">
          <span class="detail-label">Address: </span>
          <span class="detail-value">{{ $sponsorData['address'] ?? 'N/A' }}</span>
        </div>
      </div>
    </div>

    <div class="notice-box">
      <svg class="notice-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <p class="notice-text"><strong>Action required.</strong> Please review it in the admin panel and approve or reject the request.</p>
    </div>

    {{-- <a href="#" class="cta-btn">Review in Admin Panel →</a> --}}

  </div>

  <div class="email-footer">
    <p class="footer-text">
      This is an automated admin notification from PlayMKR. Only administrators receive this message.<br />
      &copy; {{ date('Y') }} PlayMKR. All rights reserved.
    </p>
  </div>

</div>

</body>
</html>
{{-- @endsection --}}