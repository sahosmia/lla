<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use Modules\Courses\Http\Requests\CoursePromotionRequest;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use Modules\KuponDeal\Requests\CouponRequest;
use Modules\KuponDeal\Services\CouponService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CoursePromotions extends Component
{
    public $courseId;
    public $course;
    public $form = [
        'id' => null,
        'user_id' => '',
        'code' => '',
        'discount_type' => '',
        'discount_value' => '',
        'expiry_date' => '',
        'couponable_type' => '',
        'couponable_id' => '',
        'auto_apply' => 0,
        'color' => '',
        'status' => 1,
    ];

    public $isEdit = false;
    protected $couponService;
    public function boot() {
        $this->couponService = new CouponService();
    }

    public function mount()
    {
        $this->courseId         = request()->route('id');
        $this->course           = Course::select('id', 'title')->findOrFail($this->courseId);
    }

    #[Computed]
    public function promotions()
    {
        return $this->couponService->getAllCoupons(Auth::id(), $this->courseId, Course::class);
    }

    public function render()
    {
        $promotions = $this->promotions;
        return view('courses::livewire.tutor.course-creation.components.promotions.course-promotions', compact('promotions'));
    }

    public function loadData()
    {
        $this->dispatch('loadPageJs');
    }

    public function addCoupon()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $request = new CouponRequest();
        $this->form['couponable_id'] = $this->courseId;
        $this->form['couponable_type'] = Course::class;
        $this->form['user_id'] = Auth::id();
        $this->form['expiry_date'] = !empty($this->form['expiry_date']) ? Carbon::parse($this->form['expiry_date'])->format('Y-m-d') : null;
        $rules = $request->rules();
        $rules['form.code'] = ['required', 'string', 'max:50', 'min:3', 'regex:/^\S*$/', Rule::unique('coupons', 'code')->ignore($this->form['id'] ?? null)];
        $rules['form.discount_value'] = [
            'required',
            'numeric',
            'min:0',
            function ($attribute, $value, $fail) {
                if ($this->form['discount_type'] === 'percentage' && $value > 100) {
                    $fail(__('courses::courses.percentage_discount_error'));
                }
            },
        ];
        $this->validate($rules, $request->messages());

        $isAdded = $this->couponService->updateOrCreateCoupon($this->form);
        $this->resetForm();
      
        if ($isAdded) {
            $this->dispatch('showAlertMessage', 
                type: 'success', 
                title: $this->form['id'] ? __('kupondeal::kupondeal.coupon_updated') : __('kupondeal::kupondeal.coupon_added'), 
                message: $this->form['id'] ? __('kupondeal::kupondeal.coupon_updated_success') : __('kupondeal::kupondeal.coupon_added_success')
            );
            $this->dispatch('toggleModel', id: 'cr-create-coupon', action: 'hide');
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error'), message: __('courses::courses.noticeboard_delete_failed'));
        }
    }

    public function openModal()
    {
        $this->resetForm();
        $this->dispatch('createCoupon', color: '#000000');
        $this->dispatch('toggleModel', id: 'cr-create-coupon', action: 'show');

    }

    public function editCoupon($id)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->isEdit = true;
        $coupon = $this->couponService->getCoupon($id);
        $this->form = $coupon->toArray();
        $this->form['expiry_date'] = !empty($this->form['expiry_date']) ? Carbon::parse($this->form['expiry_date'])->format('Y-m-d') : null;
        
        $this->dispatch('onEditCoupon', 
            discount_type: $coupon->discount_type, 
            discount_value: $coupon->discount_value, 
            expiry_date: $coupon->expiry_date,
            couponable_id: $coupon->couponable_id,
            couponable_type: $coupon->couponable_type,
            color: $coupon->color
        );
    }

    #[On('delete-coupon')]
    public function deleteCoupon($params = [])
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $isDeleted = $this->couponService->deleteCoupon($params['id']);
        if($isDeleted) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('kupondeal::kupondeal.coupon_deleted'), message: __('kupondeal::kupondeal.coupon_deleted_success'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('kupondeal::kupondeal.coupon_delete_failed'), message: __('kupondeal::kupondeal.coupon_delete_failed_desc'));
        }
    }

    public function resetForm()
    {
        $this->reset('form');
        $this->resetErrorBag();
    }

    public function updateOrCratePromotion()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        try {
            $this->promotion['valid_from']     = !empty($this->promotion['valid_from']) ? Carbon::parse($this->promotion['valid_from'])->format('Y-m-d') : null;
            $this->promotion['valid_to']       = !empty($this->promotion['valid_to']) ? Carbon::parse($this->promotion['valid_to'])->format('Y-m-d') : null;

            $validatedData = $this->validate((new CoursePromotionRequest())->rules(), [], (new CoursePromotionRequest())->attributes());

            if (!empty($this->promotion['id'])) {
                $validatedData['promotion']['id'] = $this->promotion['id'];
                $this->course = (new CourseService())->updateCoursePromotion($this->course, $validatedData['promotion']);
                $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.promotion_updated'), message: __('courses::courses.promotion_updated_success'));
            } else {
                $validatedData['promotion']['color'] = $this->colors[array_rand($this->colors)];
                $this->course = (new CourseService())->addCoursePromotion($this->course, $validatedData['promotion']);
                $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.promotion_added'), message: __('courses::courses.promotion_added_success'));
            }

            $this->promotions = $this->course->promotions;

            $this->dispatch('toggleModel', id: 'create-promotion', action: 'hide');
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    public function editPromotion($promotionId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->resetErrorBag();
        $this->promotion = [];
        $this->promotion = (new CourseService())->getPromotionById($promotionId)->toArray();
        $this->dispatch('toggleModel', id: 'create-promotion', action: 'show');
    }

   
    public function deletePromotion($params = [])
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $deleted = (new CourseService())->deletePromotion($this->course, $params['id']);
        if ($deleted) {
            $this->promotions = $this->course->promotions()->get();
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.promotion_deleted'), message: __('courses::courses.promotion_deleted_success'));
            $this->dispatch('toggleModel', id: 'create-promotion', action: 'hide');
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error'), message: __('courses::courses.promotion_delete_failed'));
        }
    }

    public function save()
    {

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        DB::beginTransaction();

        try {
            (new CourseService())->updateOrCreateCourse($this->courseId, ['status' => 'under_review']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error'), message: __('courses::courses.course_promotion_failed'));
        }

        return redirect()->route('courses.tutor.edit-course', ['tab' => 'noticeboard', 'id' => $this->courseId]);
    }
}
