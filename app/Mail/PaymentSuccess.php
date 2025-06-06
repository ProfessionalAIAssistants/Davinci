<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\InvoiceGeneratorTrait;
use App\Models\Payment;
use App\Models\Email;

class PaymentSuccess extends Mailable
{
    use Queueable, SerializesModels, InvoiceGeneratorTrait;

    public $order;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payment $order)
    {
        $current = Email::where('id', 2)->first();
        
        $this->email = $current;
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->email->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.order.success',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        try {

            $fileName = $this->invoiceAttachment($this->order->order_id);
            
            $invoicePath = Storage::disk('audio')->path("{$fileName}.pdf");
            
            if (Storage::disk('audio')->exists("{$fileName}.pdf")) {
                return [
                    Attachment::fromPath($invoicePath)
                        ->as("{$fileName}.pdf")
                        ->withMime('application/pdf')
                ];
            }
            
            return [];
        } catch (\Exception $e) {
            \Log::error('Failed to generate invoice attachment: ' . $e->getMessage());
            return [];
        
        }
    
    }
}
