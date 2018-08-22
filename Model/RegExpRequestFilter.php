<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Model;

use Guidance\WebapiLogging\Api\RequestFilterInterface;
use Magento\Framework\Webapi\Request;

class RegExpRequestFilter implements RequestFilterInterface
{
    const MODE_BLACKLIST = 'blacklist';
    const MODE_WHITELIST = 'whitelist';

    protected $whitelist = [];
    protected $blacklist = [];

    public function __construct($mode, array $filterRegExps = [])
    {
        switch ($mode) {
            case self::MODE_BLACKLIST:
                $this->blacklist = $filterRegExps;
                break;

            case self::MODE_WHITELIST:
                $this->whitelist = $filterRegExps;
                break;

            default:
                throw new \InvalidArgumentException('Invalid mode; should be blacklist or whitelist');
        }
    }

    public function accept(Request $request): bool
    {
        $subject = (string)$request;

        if (!empty($this->whitelist)) {
            foreach ($this->whitelist as $filter) {
                if (preg_match($filter, $subject)) {
                    return true;
                }
            }
            return false;
        }
        if (!empty($this->blacklist)) {
            foreach ($this->whitelist as $filter) {
                if (preg_match($filter, $subject)) {
                    return false;
                }
            }
            return true;
        }
        return true;
    }
}
