<?php

namespace Modules\Courses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;


class Faq extends Model
{
    use HasFactory;

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = (config('courses.db_prefix') ?? 'courses_') . 'faqs';
    }

    protected $fillable = ['question', 'answer'];
}
