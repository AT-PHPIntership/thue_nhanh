<?php

namespace App\Listeners;

use App\Events\UserConfigured;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repositories\Eloquent\UserRoleRepositoryEloquent as UserRole;

class UserConfiguredListener
{
    protected $userRole;

    /**
     * Create the event listener.
     *
     * @param Vote    $vote    the vote repository eloquent
     *
     * @return void
     */
    public function __construct(UserRole $userRole)
    {
        $this->userRole = $userRole;
    }

    /**
     * Handle the event.
     *
     * @param PostDeleted $event post deleted event
     *
     * @return void
     */
    public function handle(UserConfigured $event)
    {
        $id = $event->id;
        $userRoles = $this->userRole->findByField('user_id', $id);
        foreach ($userRoles as $role) {
            if ($role->role_id == \Config::get('common.ROLE_MEM_VAL')) {
                continue;
            }
            $role->delete();
        }
    }
}
