<?php
namespace App\Traits;

trait HasRoles
{
    public function isOrganizer()
    {
        return $this->role === 'organizer';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function assignOrganizerRole()
    {
        $this->update(['role' => 'organizer']);
    }

    public function assignAdminRole()
    {
        $this->update(['role' => 'admin']);
    }

    public function assignUserRole()
    {
        $this->update(['role' => 'user']);
    }
}