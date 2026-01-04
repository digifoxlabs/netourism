<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>New Enquiry</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; color: #111827; }
    .container { max-width: 680px; margin: 0 auto; padding: 20px; }
    .card { border: 1px solid #e5e7eb; border-radius: 10px; padding: 18px; background: #fff; }
    .muted { color: #6b7280; font-size: 13px; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    td { padding: 8px 6px; vertical-align: top; border-bottom: 1px dashed #eef2f7; }
    th { text-align: left; padding-right: 8px; vertical-align: top; width: 180px; color: #374151; }
    ul { margin: 0; padding-left: 18px; }
  </style>
</head>
<body>
  <div class="container">
    <div style="display:flex;gap:12px;align-items:center;">
      <div>
        <h2 style="margin:0 0 4px 0">New Enquiry Received</h2>
        <div class="muted">Received: {{ $data['received_at'] ?? now()->toDateTimeString() }}</div>
      </div>
    </div>

    <div class="card" role="article" aria-labelledby="enquiry-subject" style="margin-top:12px;">
      <h3 id="enquiry-subject" style="margin:0 0 8px 0;font-size:16px;">Enquiry details</h3>

      <table>
        <tr>
          <th>Name</th>
          <td>{{ $data['name'] ?? '-' }}</td>
        </tr>

        <tr>
          <th>Contact</th>
          <td>{{ $data['contact'] ?? '-' }}</td>
        </tr>

        <tr>
          <th>Email</th>
          <td>{{ $data['email'] ?? '-' }}</td>
        </tr>

        <tr>
          <th>Trip Type</th>
          <td>
            {{ $data['trip_type'] ?? '-' }}
            @if(!empty($data['trip_type_other']))
              — {{ $data['trip_type_other'] }}
            @endif
          </td>
        </tr>

        <tr>
          <th>Destinations</th>
          <td>
            @if(!empty($data['destinations']) && is_array($data['destinations']))
              <ul>
                @foreach($data['destinations'] as $d)
                  <li>{{ $d }}</li>
                @endforeach
              </ul>
            @else
              {{ $data['destinations_raw'] ?? '-' }}
            @endif
          </td>
        </tr>

        <tr>
          <th>Travel Dates</th>
          <td>
            @if(!empty($data['dates']) && is_array($data['dates']))
              <ul>
                @foreach($data['dates'] as $dt)
                  <li>{{ $dt }}</li>
                @endforeach
              </ul>
            @else
              {{ $data['dates_raw'] ?? '-' }}
            @endif
          </td>
        </tr>

        <tr>
          <th>Travellers</th>
          <td>{{ $data['travellers'] ?? '-' }}</td>
        </tr>

        <tr>
          <th>Vehicle</th>
          <td>{{ $data['vehicle'] ?? '-' }}</td>
        </tr>

        <tr>
          <th>Self Drive</th>
          <td>{{ $data['self_drive'] ?? 'No' }}</td>
        </tr>

        <tr>
          <th>IP / User Agent</th>
          <td>
            <div class="muted">{{ $data['ip'] ?? '-' }}</div>
            <div class="muted" style="margin-top:6px;font-size:12px;">{{ $data['user_agent'] ?? '-' }}</div>
          </td>
        </tr>
      </table>

      @if(!empty($data['message']))
        <div style="margin-top:14px;">
          <h4 style="margin:0 0 6px 0;">Additional message</h4>
          <div style="white-space:pre-wrap;color:#111827;">{!! nl2br(e($data['message'])) !!}</div>
        </div>
      @endif

      <div style="margin-top:18px;font-size:13px;color:#6b7280;">
        This enquiry was sent from your website contact form.
      </div>
    </div>
  </div>
</body>
</html>
