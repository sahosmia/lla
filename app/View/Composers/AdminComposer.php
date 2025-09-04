<?php


namespace App\View\Composers;

use App\Repositories\UserRepository;
use Illuminate\View\View;

class AdminComposer
{
    protected $perPageOptions = [10, 20, 30, 50, 100, 200 ];

    /**
     * Create a new profile composer.
     */
    public function __construct() {

    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('perPageOptions', $this->perPageOptions);
    }
}
