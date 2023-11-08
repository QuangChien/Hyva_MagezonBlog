<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

namespace Hyva\MagezonBlog\Plugin;
use Magento\Framework\Controller\Result\Redirect;
use Magezon\Blog\Controller\Comment\Post;
use Magento\Framework\Controller\Result\RedirectFactory;

class ChangeValueExecute
{
    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        RedirectFactory $resultRedirectFactory
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * @param Post $subject
     * @return Redirect
     */
    public function afterExecute(Post $subject)
    {
        $refererUrl = $subject->getRequest()->getServer('HTTP_REFERER');
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($refererUrl);
        return $resultRedirect;
    }
}
