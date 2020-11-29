<?php

namespace mabw\Validate;

class Ip
{
    public function getIpInfo($ipAddress)
    {
        $type = "-";
        $domain = "-";

        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $result = "Ip-adressen är giltig.";
            $type = "ip6";

            if (gethostbyaddr($ipAddress) != $ipAddress) {
                $domain = gethostbyaddr($ipAddress);
            }
        } else if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $result = "Ip-adressen är giltig.";
            $type = "ip4";

            if (gethostbyaddr($ipAddress) != $ipAddress) {
                $domain = gethostbyaddr($ipAddress);
            }
        } else {
            $result = "Ip-adressen är inte giltig.";
        }

        return [$result, $type, $domain];
    }
}
