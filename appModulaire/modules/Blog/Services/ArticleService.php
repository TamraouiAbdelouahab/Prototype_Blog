<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Article;

class ArticleService extends BaseService
{
    public function __construct(Article $article)
    {
        parent::__construct($article);
    }
}


