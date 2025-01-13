<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailNotifications extends Notification
{
    use Queueable;

    public $user;
    public $activityType;
    public $activityDetails;
    public $actionUrl;
    public $buttonText;
    public $content;

    // Constructor to accept dynamic data
    public function __construct($user, $activityType, $activityDetails)
    {
        $this->user = $user;
        $this->activityType = $activityType;
        $this->activityDetails = $activityDetails;

        // Set default values
        $this->actionUrl = '#';  // Default link, can be overridden based on activity
        $this->buttonText = 'Learn More';
        $this->content = '';

        // Customize content based on activity type
        $this->setContentAndUrls();
    }

    // Set content and URL based on the activity type
    protected function setContentAndUrls()
    {
        switch ($this->activityType) {
            case 'user_registered':
                $this->content = 'Thank you for registering on GambauKita!';
                $this->actionUrl = url('/users' . '/' . $this->user->id);
                $this->buttonText = 'Go to Dashboard';
                break;

            case 'Booking':
                $this->content = 'Your Booking has been placed successfully!';
                $this->actionUrl = url(route('bookings.show', $this->activityDetails['id']));
                $this->buttonText = 'View Booking';
                break;

            case 'update_account':
                $this->content = 'Your account details have been successfully updated!';
                $this->actionUrl = url('/users/' . $this->user->id . '/edit');
                $this->buttonText = 'View Account';
                break;

            case 'profile_picture_update':
                $this->content = 'Your profile picture has been successfully updated!';
                $this->actionUrl = url('/users/' . $this->user->id . '/edit');
                $this->buttonText = 'View Account';
                break;

            case 'update_booking':
                $this->content = 'Your booking has been successfully updated!';
                $this->actionUrl = url(route('bookings.show', $this->activityDetails['id']));
                $this->buttonText = 'View Updated Booking';
                break;

            case 'payment_succeeded':
                $this->content = 'Your payment has been successfully processed!';
                $this->actionUrl = url('/payments/' . $this->activityDetails['payment_id']);
                $this->buttonText = 'View Payment Details';
                break;

            case 'invoice_generated':
                $this->content = 'An invoice has been generated for your recent transaction.';
                $this->actionUrl = url('/invoices/' . $this->activityDetails['invoice_id']);
                $this->buttonText = 'View Invoice';
                break;

            case 'booking_completed':
                $this->content = 'Your booking has been completed successfully!';
                $this->actionUrl = url(route('bookings.show', $this->activityDetails['id']));
                $this->buttonText = 'View Completed Booking';
                break;

            case 'booking_scheduled':
                $this->content = 'Your booking has been scheduled for ' . $this->activityDetails['scheduled_date'];
                $this->actionUrl = url(route('bookings.show', $this->activityDetails['id']));
                $this->buttonText = 'View Scheduled Booking';
                break;


            default:
                $this->content = 'There was an activity on your account. Check it out!';
                $this->actionUrl = url('/');
                $this->buttonText = 'View';
                break;
        }
    }

    // Channels for the notification
    public function via($notifiable)
    {
        return ['mail']; // Send via email
    }

    // Format the email content
    public function toMail($notifiable)
    {


        // Return the email view and pass the dynamic content
        return (new MailMessage)
            ->subject('Updates from GambauKita')
            ->view('layout.mail', [
                'user' => $this->user,
                'content' => $this->content,
                'action_url' => $this->actionUrl,
                'button_text' => $this->buttonText,
                'website_url' => url('/')  // Optional, you can replace it with the actual website URL
            ]);
    }
}
