<!doctype html>
<html>
<body style="margin:0;padding:24px;background:#f3f5f9;font-family:Arial,Helvetica,sans-serif;color:#13213a">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:8px;overflow:hidden">
    <tr><td style="background:#042755;padding:20px 28px;color:#ffffff;font-size:18px;font-weight:bold">New enquiry from onyxial.com</td></tr>
    <tr><td style="padding:24px 28px;font-size:15px;line-height:1.6">
        <p style="margin:0 0 16px"><strong>{{ $enquiry->name }}</strong> sent a message{{ $enquiry->source ? ' from the '.$enquiry->source.' page' : '' }}.</p>
        <table cellpadding="6" cellspacing="0" style="font-size:14px;margin-bottom:16px">
            <tr><td style="color:#5b6a82">Email</td><td><a href="mailto:{{ $enquiry->email }}" style="color:#042755">{{ $enquiry->email }}</a></td></tr>
            @if($enquiry->phone)<tr><td style="color:#5b6a82">Phone</td><td>{{ $enquiry->phone }}</td></tr>@endif
            @if($enquiry->organisation)<tr><td style="color:#5b6a82">Organisation</td><td>{{ $enquiry->organisation }}</td></tr>@endif
            @if($enquiry->subject)<tr><td style="color:#5b6a82">Subject</td><td>{{ $enquiry->subject }}</td></tr>@endif
        </table>
        <div style="padding:16px;background:#f3f5f9;border-radius:6px;white-space:pre-line">{{ $enquiry->message }}</div>
        <p style="margin:20px 0 0"><a href="{{ route('admin.messages.show', $enquiry) }}" style="color:#042755">Open in the admin dashboard</a></p>
    </td></tr>
</table>
</body>
</html>
