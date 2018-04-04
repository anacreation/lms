<?php

namespace Anacreation\Lms\Models\LessonUnits;

use Anacreation\Lms\Contracts\LessonContentInterface;
use Anacreation\Lms\traits\LessonContent;
use Illuminate\Database\Eloquent\Model;

class TextContent extends Model implements LessonContentInterface
{
    use LessonContent;

    protected $table = "lesson_text_contents";

    protected $fillable = [
        'content'
    ];

    public function show() {
        return $this->content;
    }
}
