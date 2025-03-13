<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Tag;

class TagService extends BaseService
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }
}


