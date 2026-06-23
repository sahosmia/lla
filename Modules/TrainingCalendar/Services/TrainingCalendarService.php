<?php

namespace Modules\TrainingCalendar\Services;

use App\Facades\Cart;
use App\Jobs\CompleteFreePurchaseJob;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\TrainingCalendar\Models\TrainingCalendar;
use Modules\TrainingCalendar\Models\TrainingNotice;
use Modules\TrainingCalendar\Models\TrainingRegistration;

class TrainingCalendarService
{
    public function getTraining(int|string $id, array $relations = []): ?TrainingCalendar
    {
        $query = TrainingCalendar::query();

        if (!empty($relations)) {
            $query->with($relations);
        }

        if (is_numeric($id)) {
            return $query->find($id);
        }

        return $query->where('slug', $id)->first();
    }

    public function getTutorTrainings(int $tutorId, array $filters = []): LengthAwarePaginator
    {
        $query = TrainingCalendar::query()
            ->where('tutor_id', $tutorId)
            ->withCount('paidRegistrations')
            ->latest();

        if (!empty($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    public function getPublishedTrainings(array $filters = []): LengthAwarePaginator
    {
        $query = TrainingCalendar::query()
            ->where('status', TrainingCalendar::STATUS_PUBLISHED)
            ->with('tutor.profile')
            ->withCount('paidRegistrations')
            ->latest('event_datetime');

        if (!empty($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        return $query->paginate($filters['per_page'] ?? 12);
    }

    public function getAdminTrainings(array $filters = []): LengthAwarePaginator
    {
        $query = TrainingCalendar::query()
            ->with('tutor.profile')
            ->withCount('paidRegistrations')
            ->latest();

        if (!empty($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    public function getStudentRegistrations(int $userId): LengthAwarePaginator
    {
        return TrainingRegistration::query()
            ->where('user_id', $userId)
            ->where('payment_status', TrainingRegistration::PAYMENT_PAID)
            ->with(['training.tutor.profile', 'training.notices' => fn ($q) => $q->latest()])
            ->latest()
            ->paginate(10);
    }

    public function getTrainingRegistrations(int $trainingId): LengthAwarePaginator
    {
        return TrainingRegistration::query()
            ->where('training_calendar_id', $trainingId)
            ->where('payment_status', TrainingRegistration::PAYMENT_PAID)
            ->with('user.profile')
            ->latest()
            ->paginate(10);
    }

    public function createTraining(array $data, int $tutorId): TrainingCalendar
    {
        $data['tutor_id'] = $tutorId;
        $data['slug'] = $this->generateSlug($data['title']);

        if (trainingCalendarSetting('enable_seat_limit', 'yes') === 'yes' && empty($data['max_seats'])) {
            $data['max_seats'] = (int) trainingCalendarSetting('default_max_seats', 50);
        }

        return TrainingCalendar::create($data);
    }

    public function updateTraining(TrainingCalendar $training, array $data): TrainingCalendar
    {
        if (!empty($data['title']) && $data['title'] !== $training->title) {
            $data['slug'] = $this->generateSlug($data['title'], $training->id);
        }

        $training->update($data);

        return $training->fresh();
    }

    public function deleteTraining(TrainingCalendar $training): void
    {
        $training->delete();
    }

    public function userAlreadyRegistered(int $trainingId, int $userId): bool
    {
        return TrainingRegistration::query()
            ->where('training_calendar_id', $trainingId)
            ->where('user_id', $userId)
            ->where('payment_status', TrainingRegistration::PAYMENT_PAID)
            ->exists();
    }

    public function registerFree(TrainingCalendar $training, array $registrationData, User $user): array
    {
        if (trainingCalendarSetting('allow_free_training', 'yes') !== 'yes' && $training->isFree()) {
            return ['success' => false, 'message' => __('trainingcalendar::trainingcalendar.free_registration_disabled')];
        }

        if (!$training->isRegistrationOpen()) {
            return ['success' => false, 'message' => __('trainingcalendar::trainingcalendar.registration_closed')];
        }

        if ($this->userAlreadyRegistered($training->id, $user->id)) {
            return ['success' => false, 'message' => __('trainingcalendar::trainingcalendar.already_registered')];
        }

        try {
            DB::beginTransaction();

            $orderService = new OrderService();
            $order = $orderService->createOrder([
                'user_id' => $user->id,
                'first_name' => $registrationData['name'],
                'last_name' => '',
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'amount' => 0,
                'currency' => setting('_general.currency') ?? 'BDT',
                'payment_method' => 'free',
                'status' => 'complete',
                'company' => '',
                'country' => '',
                'state' => '',
                'postal_code' => '',
                'city' => '',
            ]);

            $orderService->storeOrderItems($order->id, [[
                'order_id' => $order->id,
                'title' => $training->title,
                'quantity' => 1,
                'options' => array_merge($registrationData, [
                    'training_id' => $training->id,
                    'tutor_id' => $training->tutor_id,
                ]),
                'price' => 0,
                'total' => 0,
                'orderable_id' => $training->id,
                'orderable_type' => TrainingCalendar::class,
            ]]);

            $this->createRegistration($training, $user, $registrationData, $order->id);

            DB::commit();

            dispatch(new CompleteFreePurchaseJob($order));

            return [
                'success' => true,
                'message' => __('trainingcalendar::trainingcalendar.registration_success'),
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return ['success' => false, 'message' => __('general.went_wrong')];
        }
    }

    public function addToCart(TrainingCalendar $training, array $registrationData, User $user): array
    {
        if (!$training->isRegistrationOpen()) {
            return ['success' => false, 'message' => __('trainingcalendar::trainingcalendar.registration_closed')];
        }

        if ($this->userAlreadyRegistered($training->id, $user->id)) {
            return ['success' => false, 'message' => __('trainingcalendar::trainingcalendar.already_registered')];
        }

        Cart::add(
            cartableId: $training->id,
            cartableType: TrainingCalendar::class,
            name: $training->title,
            qty: 1,
            price: $training->price,
            options: array_merge($registrationData, [
                'training_id' => $training->id,
                'tutor_id' => $training->tutor_id,
                'type' => $training->type,
                'slug' => $training->slug,
                'price' => $training->price,
                'event_datetime' => $training->event_datetime?->format('Y-m-d H:i'),
            ])
        );

        return ['success' => true, 'message' => __('trainingcalendar::trainingcalendar.added_to_cart')];
    }

    public function createRegistration(TrainingCalendar $training, User $user, array $data, ?int $orderId = null, string $paymentStatus = TrainingRegistration::PAYMENT_PAID): TrainingRegistration
    {
        return TrainingRegistration::create([
            'training_calendar_id' => $training->id,
            'user_id' => $user->id,
            'order_id' => $orderId,
            'name' => $data['name'] ?? $user->profile?->full_name ?? $user->email,
            'email' => $data['email'] ?? $user->email,
            'phone' => $data['phone'] ?? '',
            'profession' => $data['profession'] ?? '',
            'payment_status' => $paymentStatus,
        ]);
    }

    public function completePaidRegistration(Order $order, TrainingCalendar $training, array $options): void
    {
        $user = User::find($order->user_id);

        if (empty($user)) {
            return;
        }

        if ($this->userAlreadyRegistered($training->id, $user->id)) {
            return;
        }

        $this->createRegistration($training, $user, $options, $order->id);
    }

    public function sendNotice(TrainingCalendar $training, User $sender, array $data): array
    {
        if ($sender->id !== $training->tutor_id) {
            return ['success' => false, 'message' => __('trainingcalendar::trainingcalendar.only_tutor_can_send')];
        }

        $registrations = $training->paidRegistrations()->get();

        if ($registrations->isEmpty()) {
            return ['success' => false, 'message' => __('trainingcalendar::trainingcalendar.no_registrations')];
        }

        $notice = TrainingNotice::create([
            'training_calendar_id' => $training->id,
            'sent_by' => $sender->id,
            'subject' => $data['subject'],
            'message' => $data['message'] ?? '',
            'zoom_link' => $data['zoom_link'] ?? null,
            'meet_link' => $data['meet_link'] ?? null,
            'location' => $data['location'] ?? null,
            'sent_at' => now(),
        ]);

        foreach ($registrations as $registration) {
            \Illuminate\Support\Facades\Mail::to($registration->email)->send(
                new \Modules\TrainingCalendar\Mail\TrainingNoticeMail($training, $notice, $registration)
            );
        }

        return [
            'success' => true,
            'message' => __('trainingcalendar::trainingcalendar.notice_sent', ['count' => $registrations->count()]),
        ];
    }

    protected function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (
            TrainingCalendar::query()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
