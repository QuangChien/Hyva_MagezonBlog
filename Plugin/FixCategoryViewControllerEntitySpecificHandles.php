<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\MagezonBlog\Plugin;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\View\EntitySpecificHandlesList;
use Magezon\Blog\Controller\Category\View as CategoryViewAction;

class FixCategoryViewControllerEntitySpecificHandles
{
    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @var EntitySpecificHandlesList
     */
    private $entitySpecificHandlesList;

    public function __construct(HttpRequest $httpRequest, EntitySpecificHandlesList $entitySpecificHandlesList)
    {
        $this->httpRequest               = $httpRequest;
        $this->entitySpecificHandlesList = $entitySpecificHandlesList;
    }

    /**
     * Exclude the blog_category_view layout handle from being loaded on ESI requests.
     *
     * If the FPC is turned on and varnish is used, the top menu rendering throws an exception because
     * blog_category_view expects a current_category to be set in the registry.
     *
     * @param CategoryViewAction $subject
     */
    public function beforeExecute(CategoryViewAction $subject)
    {
        $handle = $this->httpRequest->getFullActionName();
        $this->entitySpecificHandlesList->addHandle($handle);
        $this->entitySpecificHandlesList->addHandle('hyva_' . $handle);
    }
}
