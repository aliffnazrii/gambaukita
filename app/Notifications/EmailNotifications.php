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
                $this->content = 'Thank you for registering GambauKita!';
                $this->actionUrl = url('/users' . '/' . $this->user->id);
                $this->buttonText = 'Go to Dashboard';
                break;

            case 'create_Booking_client':
                $this->content = 'Your Booking at ' . $this->activityDetails['event_date'] . 'has been placed successfully. Click the link below to view your booking details.';
                $this->actionUrl = url('bookings/' .  $this->activityDetails['id']);
                $this->buttonText = 'View Booking';
                break;

            case 'create_Booking_owner':
                $this->content = 'A Booking at ' . $this->activityDetails['event_date'] . 'has been placed successfully. Click the link below to view the recent made booking details.';
                $this->actionUrl = url(route('bookings.show', $this->activityDetails['id']));
                $this->buttonText = 'View Booking';
                break;

            case 'pay_balance':
                $this->content = 'A Booking has been fully paid. Click the link below to view the paid booking details.';
                $this->actionUrl = url('bookings/' .  $this->activityDetails['id']);
                $this->buttonText = 'View Booking';
                break;

            case 'update_account':
                $this->content = 'Your account details have been successfully updated!';
                $this->actionUrl = url('/users/' . $this->user->id . '/edit');
                $this->buttonText = 'View Account';
                break;

            case 'update_password':
                $this->content = 'Your password has been successfully updated!';
                $this->actionUrl = url('/users/' . $this->user->id . '/edit');
                $this->buttonText = 'View Account';
                break;

            case 'create_schedule':
                $this->content = 'Schedule has been added !';
                $this->actionUrl = url('/owner/schedule');
                $this->buttonText = 'View Schedule';
                break;

            case 'update_schedule':
                $this->content = 'Schedule has been updated !';
                $this->actionUrl = url('/owner/schedule');
                $this->buttonText = 'View Schedule';
                break;

            case 'profile_picture_update':
                $this->content = 'Your profile picture has been successfully updated!';
                $this->actionUrl = url('/users/' . $this->user->id);
                $this->buttonText = 'View Account';
                break;

            case 'update_booking':
                $this->content = 'Your booking status has been updated!';
                $this->actionUrl = url('/bookings/' . $this->activityDetails['booking_id']);
                $this->buttonText = 'View Booking';
                break;

            case 'booking_completed':
                $this->content = 'Your booking has been completed successfully!';
                $this->actionUrl = url('/bookings/' . $this->activityDetails->id);
                $this->buttonText = 'View Completed Booking';
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
                'website_url' => url('gambaukita.com/')  // Optional, you can replace it with the actual website URL
            ]);
    }
}
