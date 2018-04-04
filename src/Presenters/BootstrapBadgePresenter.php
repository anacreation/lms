<?php
/**
 * Author: Xavier Au
 * Date: 27/3/2018
 * Time: 5:10 PM
 */

namespace Anacreation\Lms\Presenters;


use Anacreation\Lms\Contracts\PresenterInterface;

class BootstrapBadgePresenter implements PresenterInterface
{

    public function render(string $content, ...$options): string {
        $class = "badge-default";
        if (count($options)) {
            $type = $options[0];
            switch (strtolower($type)) {
                case 'success':
                    $class = "badge-success";
                    break;
                case 'primary':
                    $class = "badge-primary";
                    break;
                case 'warning':
                    $class = "badge-warning";
                    break;
                case 'danger':
                    $class = "badge-danger";
                    break;
                case 'info':
                    $class = "badge-info";
                    break;
                case 'secondary':
                    $class = "badge-secondary";
                    break;
                default:
                    $class = "badge-default";
            }
        }

        return "<h5><span class=\"badge {$class}\">{$content}</span></h5> ";
    }
}