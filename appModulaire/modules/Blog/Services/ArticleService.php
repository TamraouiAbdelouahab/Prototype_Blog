<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Article;
use Modules\Core\Service\BaseService;

class ArticleService extends BaseService
{
    public function __construct(Article $article)
    {
        parent::__construct($article);
    }
}


