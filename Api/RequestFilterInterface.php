<?php
/**
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     WebapiLogging
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\WebapiLogging\Api;

use Magento\Framework\Webapi\Request;

interface RequestFilterInterface
{
    public function accept(Request $request): bool;
}