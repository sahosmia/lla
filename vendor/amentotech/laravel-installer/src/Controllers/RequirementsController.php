<?php

namespace Froiden\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Froiden\LaravelInstaller\Helpers\RequirementsChecker;

class RequirementsController extends Controller
{

    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $checker)
    {
        $this->requirements = $checker;
    }

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        $phpSupportInfo = $this->requirements->checkPHPversion(
            config('installer.core.minPhpVersion')
        );

        $maxExecutionTime = $this->requirements->checkMaxExecutionTime(
            config('installer.core.max_execution_time')
        );

        $allowUrlFopen = $this->requirements->checkAllowUrlFopen(
            config('installer.core.allow_url_fopen')
        );

        $maxInputVars = $this->requirements->checkMaxInputVars(
            config('installer.core.max_input_vars')
        );

        $symlinkEnabled         = $this->requirements->checkDisableFunctions('symlink');
        $execFunctionEnabled    = $this->requirements->checkDisableFunctions('exec');

        $requirements = $this->requirements->check(
            config('installer.requirements')
        );
        
        return view('vendor.installer.requirements', compact('requirements', 'phpSupportInfo', 'maxExecutionTime', 'symlinkEnabled', 'execFunctionEnabled' , 'maxInputVars', 'allowUrlFopen'));
    }
}
