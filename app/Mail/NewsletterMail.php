<?php

namespace App\Mail;

use App\Models\Admin\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $row = Setting::where('type', config('admin.setting.type'))->first();
        $options = isset($row->options) ? json_decode($row->options) : [];
        $fromMail = isset($options) ? $options->email : 'no_reply@gmail.com';
        $nameCompany = isset($row) ? $row->title : 'Name company';
        return new Envelope(
            from: new Address($fromMail, $nameCompany),
            subject: !empty($this->data->subject) ? $this->data->subject : 'Thư đăng ký nhận tin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.newsletter',
            with: $this->data,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $d = $this->data;
        return [Attachment::fromPath(asset('upload/file_attach/' . $d['file_attach']))];
    }
}
