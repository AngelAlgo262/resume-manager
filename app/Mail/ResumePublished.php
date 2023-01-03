<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Resume;

class ResumePublished extends Mailable
{
    use Queueable, SerializesModels;

    public $resume;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Resume $resume)
    {
        $this->resume = $resume;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.resumes.published');
    }
}
