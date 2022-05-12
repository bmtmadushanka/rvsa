<?php

namespace App\Traits;

trait NotificationTrait
{
    public function get_tab_data($tab, $user)
    {
        switch ($tab) {
            case 'payments': {
                return $user->payments->where('status', '!=', 'pending')->sortByDesc('updated_at');
                break;
            }
            case 'downloads': {
                return $user->downloads->sortByDesc('downloaded_at');
                break;
            }
            case 'account': {
                return $user->approvals->sortByDesc('created_at');
                break;
            }
            case 'updates': {
                return $user->versionChanges->sortByDesc('created_at');
                break;
            }
            case 'activities': {
                return $user->activities->sortByDesc('created_at');
                break;
            }
            default : {
                return [];
                break;
            }
        }
    }

    public function get_tabs($user)
    {
        return [
            'updates' => [
                'name' => 'updates',
                'icon' => 'monitor',
                'group' => 1,
                'badge_color' => 'danger',
                'unread_count' => 0
            ],
            'payments' => [
                'name' => 'payments',
                'icon' => 'cc-paypal',
                'group' => 2
            ],
            'downloads' => [
                'name' => 'downloads',
                'icon' => 'download',
                'group' => 2
            ],
            'account' => [
                'name' => 'account',
                'icon' => 'user-check',
                'group' => 3,
                'badge_color' => 'dim',
                'unread_count' => $user->approvals->whereNotNull('reviewed_at', 1)->where('is_read_user', 0)->count()
            ],
            'activities' => [
                'name' => 'activities',
                'icon' => 'history',
                'group' => 4,
                'badge_color' => 'dim'
            ]
        ];
    }
}
