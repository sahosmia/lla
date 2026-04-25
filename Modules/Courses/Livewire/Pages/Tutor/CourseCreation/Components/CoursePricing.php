<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use Illuminate\Support\Facades\Log;
use Modules\Courses\Http\Requests\CoursePriceRequest;
use Modules\Courses\Models\Course;
use Livewire\Component;
use Modules\Courses\Services\CourseService;

class CoursePricing extends Component {

    public $courseId;
    public $course;

    public $price = null;
    public $discount = 0;
    public $final_price = null;

    public $isCustomDiscount = false;
    public $customDiscount = null;
    public $discounts = [10, 20, 30, 40, 50];

    public $isFree              = false;
    public $discountAllowed     = true;

    public function mount() {
        $this->courseId     = request()->route('id');
        $this->course       = Course::with('pricing')->findOrFail($this->courseId);

        if (!empty($this->course->pricing)) {
            $this->price            = $this->course?->pricing?->price;
            $this->discount         = $this->course?->pricing?->discount ?? 0;
            $this->final_price       = $this->course?->pricing?->final_price;
            
            if ($this->course->pricing->price == 0 || $this->course->pricing->price === null) {
                $this->isFree = true;
            }

            if (empty($this->course->pricing->discount)) {
                $this->discountAllowed = false;
            }

            if (!in_array($this->course->pricing->discount, $this->discounts)) {
                $this->customDiscount = $this->course->pricing->discount;
            }
        }
    }

    public function render() {
        return view('courses::livewire.tutor.course-creation.components.course-pricing');
    }

    public function loadData() {
    }

    public function toggleIsFree() {
        $this->price        = null;
        $this->discount     = 0;
        $this->final_price   = null;
    }

    public function toggleDiscountAllowed() {
        $this->discount     = 0;
        $this->final_price   = $this->price;
    }

    public function calculatefinal_price() {
        $this->final_price = (float)$this->price * (1 - ((float)$this->discount / 100));
    }

    public function updatedPrice() {
        $this->calculatefinal_price();
    }

    public function updateDiscount($discount) {
        $this->isCustomDiscount = false;
        $this->discount = $discount;
        $this->calculatefinal_price();
    }

    public function updateCustomDiscount() {
        $this->discount = $this->customDiscount;
        $this->isCustomDiscount = true;
        $this->calculatefinal_price();
    }

    public function updatedCustomDiscount() {
        if ($this->customDiscount < 0) {
            $this->customDiscount = 0;
        }

        if ($this->customDiscount > 100) {
            $this->customDiscount = 100;
        }

        if (!$this->isCustomDiscount) {
            return;
        }

        $this->discount  = $this->customDiscount;

        $this->calculatefinal_price();
    }

    public function savePricing() {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $validatedData = $this->validate((new CoursePriceRequest())->rules(), (new CoursePriceRequest())->messages(), (new CoursePriceRequest())->attributes());
        try {
            $data = [
                "price" => !empty($validatedData['price']) ? $validatedData['price'] : 0,
                "discount" => !empty($validatedData['discount']) ? $validatedData['discount'] : null,
                "final_price" => !empty($validatedData['final_price']) ? number_format($validatedData['final_price'], 2, '.', '') : 0
            ];
            (new CourseService())->updateCoursePricing($this->course, $data);
            return redirect()->route('courses.tutor.edit-course', ['tab' => 'content', 'id' => $this->courseId]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }
}
