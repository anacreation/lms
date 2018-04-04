@if (session('status'))
    <?php
    $status = session('status');
    if (is_array($status)) {
        if (!isset($status['type']) or !isset($status['message'])) {
            throw new InvalidArgumentException("Invalid status Structure!");
        }
        switch ($status['type']) {
            case Anacreation\Lms\Enums\AlertTypes::Warning:
                $class = "alert-warning";
                break;
            case Anacreation\Lms\Enums\AlertTypes::Danger:
                $class = "alert-danger";
                break;
            case Anacreation\Lms\Enums\AlertTypes::Info:
                $class = "alert-info";
                break;
            case Anacreation\Lms\Enums\AlertTypes::Primary:
                $class = "alert-primary";
                break;
            default:
                $class = "alert-success";
        }
        $msg = $status['message'];
    } else {
        $class = "alert-success";
        $msg = $status;
    }
    ?>
	<div class="alert {{$class}}">
        {{ $msg }}
		<button type="button" class="close" data-dismiss="alert"
		        aria-label="Close">
				    <span aria-hidden="true">&times;</span>
		  </button>
    </div>
@endif