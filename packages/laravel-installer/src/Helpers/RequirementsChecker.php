<?php

namespace Froiden\LaravelInstaller\Helpers;

class RequirementsChecker
{

    private $_minPhpVersion = '7.1.0';

    /**
     * Check for the server requirements.
     *
     * @param array $requirements
     * @return array
     */
    public function check(array $requirements)
    {
        $results = [];

        foreach($requirements as $requirement)
        {
            $results['requirements'][$requirement] = true;

            if(!extension_loaded($requirement))
            {
                $results['requirements'][$requirement] = false;

                $results['errors'] = true;
            }
        }

        return $results;
    }

    public function checkPHPversion(string $minPhpVersion = null)
    {
        $minVersionPhp = $minPhpVersion;
        $currentPhpVersion = $this->getPhpVersionInfo();
        $supported = false;
        if ($minPhpVersion == null) {
            $minVersionPhp = $this->getMinPhpVersion();
        }
        if (version_compare($currentPhpVersion['version'], $minVersionPhp) >= 0) {
            $supported = true;
        }
        $phpStatus = [
            'full' => $currentPhpVersion['full'],
            'current' => $currentPhpVersion['version'],
            'minimum' => $minVersionPhp,
            'supported' => $supported
        ];
        return $phpStatus;
    }

    public function checkMaxExecutionTime(string $time)
    {
        $maxExecutionTime = ini_get('max_execution_time');
        $supported = false;
        if ($maxExecutionTime > $time || $maxExecutionTime == 0) {
            $supported = true;
        }
        return [
            'current'   => $maxExecutionTime,
            'minimum'   => 120,
            'supported' => $supported
        ];
    }

    public function checkAllowUrlFopen(string $time)
    {
        $allowUrlFopen = ini_get('allow_url_fopen');
        $supported = false;
        if ($allowUrlFopen == 1) {
            $supported = true;
        }
        return [
            'current'   => $allowUrlFopen,
            'supported' => $supported
        ];
    }

    public function checkMaxInputVars(string $time)
    {
        $maxInputVars = ini_get('max_input_vars');
        $supported = false;
        if ($maxInputVars > $time || $maxInputVars == 0) {
            $supported = true;
        }
        return [
            'current'   => $maxInputVars,
            'minimum'   => 1000,
            'supported' => $supported
        ];
    }

    /**
     * Check if a function is disabled
     *
     * @param string $function
     * @return bool
     */
    public function checkDisableFunctions(string $function)
    {
        return  !in_array($function, explode(',', ini_get('disable_functions')));
    }

    /**
     * Get current Php version information
     *
     * @return array
     */
    private static function getPhpVersionInfo()
    {
        $currentVersionFull = PHP_VERSION;
        preg_match("#^\d+(\.\d+)*#", $currentVersionFull, $filtered);
        $currentVersion = $filtered[0];
        return [
            'full' => $currentVersionFull,
            'version' => $currentVersion
        ];
    }
    /**
     * Get minimum PHP version ID.
     *
     * @return string _minPhpVersion
     */
    protected function getMinPhpVersion()
    {
        return $this->_minPhpVersion;
    }
}