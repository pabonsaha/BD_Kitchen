<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;


class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdf;
    public $messageContent;
    public $subject;

    public function __construct($order, $pdf, $messageContent, $subject)
    {
        $this->order = $order;
        $this->pdf = $pdf;
        $this->messageContent = $messageContent;
        $this->subject = $subject;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'email.invoice',
            with: [
                'order' => $this->order,
                'message' => $this->messageContent,
            ],
        );
    }


    public function attachments(): array
    {
        return [
            Attachment::fromData(fn() => $this->pdf, 'invoice-' . $this->order->code . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
