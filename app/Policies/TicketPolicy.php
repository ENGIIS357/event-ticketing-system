<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * التحقق إذا كان المستخدم يمكنه عرض أي تذكرة
     */
    public function viewAny(User $user): bool
    {
        return true; // الجميع يمكنهم رؤية التذاكر المتاحة
    }

    /**
     * التحقق إذا كان المستخدم يمكنه عرض تذكرة محددة
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return true; // الجميع يمكنهم رؤية تفاصيل التذكرة
    }

    /**
     * التحقق إذا كان المستخدم يمكنه إنشاء تذكرة
     */
    public function create(User $user): bool
    {
        return $user->isOrganizer() || $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه تحديث التذكرة
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->event->user_id || $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه حذف التذكرة
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->event->user_id || $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه إدارة التذاكر
     */
    public function manage(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->event->user_id;
    }

    /**
     * التحقق إذا كان المستخدم يمكنه شراء التذكرة
     */
    public function purchase(User $user, Ticket $ticket): bool
    {
        return $ticket->isAvailable() && $user->isUser();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه رؤية إحصائيات التذكرة
     */
    public function viewStatistics(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->event->user_id || $user->isAdmin();
    }
}