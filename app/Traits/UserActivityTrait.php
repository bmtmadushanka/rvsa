<?php

namespace App\Traits;

trait UserActivityTrait
{
    /* NEVER EVER CHANGE THIS IDS */
    private $activities = [
        1 => [
            'title' => 'Profile Created',
            'icon' => 'user-add',
            'description' => "You\'ve just accessed your web portal using IP: "
        ],
        2 => [
            'title' => 'Logged in Successfully',
            'icon' => 'account-setting',
        ],
        3 => [
            'title' => 'Payment Succeeded',
            'icon' => 'cc-paypal',
        ],
        4 => [
            'title' => 'Payment Failed',
            'icon' => 'cross-circle',
        ],
        5 => [
            'title' => 'Model Report Downloaded',
            'icon' => 'download',
        ],
        6 => [
            'title' => 'Profile Updated',
            'icon' => 'check-circle',
        ],
        7 => [
            'title' => 'Profile Change Requested',
            'icon' => 'alert',
        ],
        8 => [
            'title' => 'Profile Change Approved',
            'icon' => 'check-circle',
        ],
        9 => [
            'title' => 'Profile Change Rejected',
            'icon' => 'cross-circle',
        ],
        10 => [
            'title' => 'Profile Changed by Admin',
            'icon' => 'cross-circle',
        ],
        11 => [
            'title' => 'Password Changed',
            'icon' => 'check-circle',
        ],
        12 => [
            'title' => 'Password Reset by Admin',
            'icon' => 'alert',
        ],
        13 => [
            'title' => 'Discussion Started',
            'icon' => 'chat-circle-fill',
        ],
        14 => [
            'title' => 'Discussion Replied',
            'icon' => 'chat-circle',
        ],
        15 => [
            'title' => 'Discussion Started by Admin',
            'icon' => 'chat-circle-fill',
        ],
        16 => [
            'title' => 'Discussion Replied by Admin',
            'icon' => 'chat-circle',
        ],
        17 => [
            'title' => 'Mobile Number verified',
            'icon' => 'check-circle',
        ],
        18 => [
            'title' => 'Consumer Note Downloaded',
            'icon' => 'download',
        ],
    ];

    public function getActivities()
    {
        return $this->activities;
    }

}
