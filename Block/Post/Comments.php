<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\MagezonBlog\Block\Post;

use Magezon\Blog\Model\Comment;

/**
 * This class is overwritten to fix child comments not loading.
 * In method getComments
 * $collection->addFieldToFilter('post_d', ['nin' => $ids]);
 * was changed to
 * $collection->addFieldToFilter('comment_id', ['nin' => $ids]);
 *
 * Additionally, getCommentHtml() is overwritten to load a phtml file
 * for each comment, instead of having getCommentHtml() compile the html
 */
class Comments extends \Magezon\Blog\Block\Post\Comments
{
    /**
     * @return array
     */
    public function getComments()
    {
        if ($this->_comments === NULL) {
            $comments = [];
            $ids = [];
            foreach ($this->getCollection() as $_comment) {
                if (!$_comment->getParentId()) {
                    $comments[] = $_comment;
                    $ids[] = $_comment->getId();
                }
            }
            $post = $this->getCurrentPost();
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('post_id', $post->getId());
            // corrected from 'post_id' to 'comment_id'
            $collection->addFieldToFilter('comment_id', ['nin' => $ids]);
            $collection->addFieldToFilter('status', Comment::STATUS_APPROVED);
            $collection->addPostInformation();
            $collection->addCustomerInformation();
            $this->_items = $collection->getItems();
            foreach ($comments as &$_comment) {
                $children = $this->prepareList($_comment);
                if ($children) $_comment->setChildren($children);
            }
            $this->_comments = $comments;
        }
        return $this->_comments;
    }

    /**
     * @param  Comment $comment
     * @return array
     */
    private function prepareList($comment)
    {
        $childrens = [];
        foreach ($this->_items as $k => $_comment) {
            if ($_comment->getParentId() == $comment->getId()) {
                $hasChildren = false;
                $children = $_comment;
                foreach ($this->_items as $_comment2) {
                    if ($_comment2->getParentId() == $_comment->getId()) {
                        $hasChildren = true;
                        break;
                    }
                }
                if ($hasChildren && ($_children = $this->prepareList($children))) {
                    $children->setChildren($_children);
                }
                $childrens[] = $children;
            }
        }
        return $childrens;
    }

    /**
     * @param  \Magezon\Blog\Model\Comment $comment
     * @return string
     */
    public function getCommentHtml($comment)
    {
        $block = $this->getLayout()->createBlock(Comments::class);
        $block->setTemplate('Hyva_MagezonBlog::post/view/comments/comment.phtml');
        $block->setComment($comment);
        return $block->toHtml();
    }
}
