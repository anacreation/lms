<?php

namespace Anacreation\Lms\Models;

use Anacreation\Lms\Contracts\PresenterInterface;
use Anacreation\Lms\Enums\UserLessonStatus as Status;
use Anacreation\Lms\Presenters\BootstrapBadgePresenter;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class UserLessonStatus extends Model
{
    protected $table = 'lesson_user';
    protected $fillable = ['user_id', 'lesson_id', 'status'];
    /**
     * @var \Anacreation\Lms\Contracts\PresenterInterface
     */
    private $displayPresenter;

    /**
     * UserLessonStatus constructor.
     * @param $displayPresenter
     */
    public function __construct(
        array $attributes = [], PresenterInterface $displayPresenter = null
    ) {
        parent::__construct($attributes);
        $this->displayPresenter = $displayPresenter ?? new BootstrapBadgePresenter();
    }


    public function user(): Relation {
        return $this->belongsTo(User::class);
    }

    public function lesson(): Relation {
        return $this->belongsTo(Lesson::class);
    }

    public function displayStatus(): string {
        $status = array_flip(Status::getStatus());
        if ($this->displayPresenter) {
            switch ($this->status) {
                case Status::COMPLETED:
                    return $this->displayPresenter->render(ucfirst(strtolower($status[$this->status])),
                        'success');
                case Status::ENROLLED:
                case Status::RETAKE:
                case Status::START:
                    return $this->displayPresenter->render(ucfirst(strtolower($status[$this->status])),
                        'primary');
                case Status::FAILED:
                    return $this->displayPresenter->render(ucfirst(strtolower($status[$this->status])),
                        'danger');
                default:
                    return $this->displayPresenter->render(ucfirst(strtolower($status[$this->status])));
            }
        }

    }

    /**
     * @param mixed $displayPresenter
     */
    public function setDisplayPresenter(PresenterInterface $displayPresenter
    ): void {
        $this->displayPresenter = $displayPresenter;
    }
}
