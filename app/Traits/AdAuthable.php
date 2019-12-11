<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait AdAuthable
{

    private $adConnection;

    private $adUser;

    private $adPass;

    protected $adCn;

    public function adAttempt()
    {
        if (in_array($this->adUser, config('ad.adauthtrait.local_bypass', []))) {
            return false;
        }

        if (!$this->ldapPing()) {
            return false;
        }

        try {
            if ($this->adConnect()) {
                if (!$this->adSetOptions()) {
                    return false;
                }

                if ($this->adBind()) {
                    $this->adCn = $this->adInfo();
                    $this->adClose();
                    return true;
                }
            }
        } catch (\Exception $e) {
            session()->flash('warning', __('AD login attempt failed'));
            return false;
        }
        return false;
    }

    public function adInfo()
    {
        $filter = '(samaccountname=' . $this->adUser . ')';
        $result = ldap_search($this->adConnection, config('ad.adauthtrait.dn', ''), $filter);
        $info = ldap_get_entries($this->adConnection, $result);
        if ((isset($info['count'])) and ($info['count'] > 0) and (isset($info[0]['cn'][0]))) {
            // Groups: dd($info[0]['memberof']);
            return $info[0]['cn'][0];
        }
        return false;
    }

    private function ldapPing()
    {
        try {
            $op = fsockopen(
                config('ad.adauthtrait.server', ''),
                config('ad.adauthtrait.port', 389),
                $err, $errstr, config('ad.adauthtrait.socket_timeout', 4)
            );
        } catch (\Exception $e) {
            session()->flash('warning', __('AD server connection timeout'));
            return false;
        }
        fclose($op);
        return true;
    }

    private function adConnect()
    {
        $server = config('ad.adauthtrait.server', '');
        try {
            $this->adConnection = ldap_connect($server);
        } catch (\Exception $e) {
            session()->flash('warning', __('AD server conection failed'));
            return false;
        }
        return true;
    }

    private function adBind()
    {
        try {
            $bind = ldap_bind($this->adConnection, $this->adUser . config('ad.adauthtrait.domain', '') , $this->adPass);
        } catch (\Exception $e) {
            session()->flash('warning', __('AD bind failed'));
            return false;
        }
        return $bind;
    }

    private function adSetOptions()
    {
        try {
            ldap_set_option($this->adConnection, LDAP_OPT_REFERRALS, config('ad.adauthtrait.options.referrals', 0));
            ldap_set_option($this->adConnection, LDAP_OPT_PROTOCOL_VERSION, config('ad.adauthtrait.options.protocol_version', 3));
            ldap_set_option($this->adConnection, LDAP_OPT_TIMEOUT, config('ad.adauthtrait.options.timeout', 4));
        } catch (\Exception $e) {
            session()->flash('warning', __('AD set options failed'));
            return false;
        }
        return true;
    }

    private function adClose()
    {
        ldap_unbind($this->adConnection);
        return true;
    }
}
