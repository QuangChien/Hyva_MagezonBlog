<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\MagezonBlog\ViewModel;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magezon\Blog\Api\Data\CategoryInterface;
use Magezon\Blog\Api\Data\PostInterface;

class BlogFullPageCacheTags implements IdentityInterface, ArgumentInterface
{
    private $cacheTags = [];

    /**
     * @param IdentityInterface $entity
     */
    public function register(IdentityInterface $entity): void
    {
        $this->cacheTags = array_unique(array_merge($this->cacheTags, $entity->getIdentities() ?? []));
    }

    public function getIdentities()
    {
        return $this->cacheTags;
    }
}
