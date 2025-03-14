<?php

namespace Modules\Blog\app\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class ArticleImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'title'  => $row['title'],
            'content' => $row['content'],
            'category' => $row['category']
        ]);
    }
}
