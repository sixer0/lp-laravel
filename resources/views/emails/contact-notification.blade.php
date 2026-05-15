@component('mail::message')

# New Contact Form Submission

You have received a new message from your portfolio website.

## Contact Details

**Name:** {{ $submission->name }}  
**Email:** {{ $submission->email }}  
**Phone:** {{ $submission->phone }}  
**Company:** {{ $submission->company }}

## Message

{{ $submission->message }}

---

**Submission ID:** #{{ $submission->id }}  
**Date:** {{ $submission->created_at->format('Y-m-d H:i:s') }}  
**IP Address:** {{ $submission->ip }}  
**User Agent:** {{ $submission->user_agent_short }}

---

<p style="color: #666; font-size: 0.9em;">
    You can manage submissions at: <a href="{{ url('/admin/submissions') }}">Admin Panel</a>
</p>

@endcomponent
