<?php

namespace App\Jobs;

use App\Models\CampaignEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCampaignEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emails;
    protected $data;

    public function __construct(array $emails, array $data)
    {
        $this->emails = $emails;
        $this->data = $data;
    }

    public function handle(): void
    {
        foreach ($this->emails as $email) {

            $subject = $this->data['subject'];
            $campaign_name = $this->data['subject'];
            $Campmessages = $this->data['message'];
            $attachment = $this->data['attachment'];

            Mail::send('email.email-campaign-mail', compact('subject', 'Campmessages', 'attachment'), function ($message) use ($email, $subject, $attachment) {
                $message->to($email);
                $message->subject($subject);
                if (!empty($attachment)) {
                    $attachmentPath = storage_path('app/' . $attachment);
                    if (file_exists($attachmentPath)) {
                        $message->attach($attachmentPath);
                    } else {
                        Log::error('Attachment file not found: ' . $attachmentPath);
                    }
                }
            });

            CampaignEmailLog::create([
                'campaign_id' => $this->data['campaign_id'],
                'email' => $email,
                'sent_at' => now(),
                'status' => 1,
                'created_by' => $this->data['created_by'],
                'updated_by' => $this->data['created_by']
            ]);
        }
    }
}
