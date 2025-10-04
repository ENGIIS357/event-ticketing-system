<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * التحقق إذا كان المستخدم يمكنه عرض أي حجز
     */
    public function viewAny(User $user): bool
    {
        return $user->isOrganizer() || $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه عرض حجز محدد
     */
    public function view(User $user, Booking $booking): bool
    {
        // المستخدم يمكنه رؤية حجوزه، المنظم يمكنه رؤية حجوزات فعالياته
        return $user->id === $booking->user_id || 
               $user->id === $booking->event->user_id ||
               $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه إنشاء حجز
     */
    public function create(User $user): bool
    {
        return true; // أي مستخدم مسجل يمكنه حجز تذاكر
    }

    /**
     * التحقق إذا كان المستخدم يمكنه تحديث الحجز
     */
    public function update(User $user, Booking $booking): bool
    {
        // فقط منظم الفعالية أو المدير يمكنهم تحديث الحجز (تغيير الحالة مثلاً)
        return $user->id === $booking->event->user_id || $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه حذف الحجز
     */
    public function delete(User $user, Booking $booking): bool
    {
        // المستخدم يمكنه حذف حجوزه، المنظم يمكنه حذف حجوزات فعالياته
        return $user->id === $booking->user_id || 
               $user->id === $booking->event->user_id ||
               $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه إدارة الحجوزات (لوحة تحكم المنظم)
     */
    public function manage(User $user, Booking $booking): bool
    {
        return $user->id === $booking->event->user_id;
    }

    /**
     * التحقق إذا كان المستخدم يمكنه تأكيد الحجز
     */
    public function confirm(User $user, Booking $booking): bool
    {
        return $user->id === $booking->event->user_id || $user->isAdmin();
    }

    /**
     * التحقق إذا كان المستخدم يمكنه إلغاء الحجز
     */
    public function cancel(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || 
               $user->id === $booking->event->user_id ||
               $user->isAdmin();
    }
}