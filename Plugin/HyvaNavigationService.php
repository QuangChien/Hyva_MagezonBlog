<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\MagezonBlog\Plugin;

use Hyva\Theme\Service\Navigation;
use Magento\Framework\Data\Tree\Node;
use Magezon\Blog\Plugin\Block\TopMenu;

class HyvaNavigationService extends TopMenu
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param Navigation $subject
     * @param Node $result
     * @param int $maxLevel
     */
    public function afterGetMenuTree(
        Navigation $subject,
        Node $result,
        $maxLevel = 0
    ) {
        if ($this->dataHelper->getConfig('top_navigation/enabled')) {
            $this->_menu = $result;
            $title = $this->dataHelper->getConfig('top_navigation/title');
            $blog  = $this->nodeFactory->create(
                [
                    'data'    => [
                        'name' => $title,
                        'id'   => 'blog-note',
                        'url'  => $this->dataHelper->getBLogUrl(),
                    ],
                    'idField' => 'id',
                    'tree'    => $result->getTree()
                ]
            );
            if ($this->dataHelper->getConfig('top_navigation/include_categories')) {
                $this->prepareMenu($blog);
            }
            $result->addChild($blog);
        }
        return $result;
    }
}
