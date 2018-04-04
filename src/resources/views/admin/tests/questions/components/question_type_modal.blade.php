<div class="modal fade" id="{{$modalId}}">
			<div class="modal-dialog">
			  <div class="modal-content">
		
		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">Select Question Type</h4>
		        <button type="button" class="close"
		                data-dismiss="modal">&times;</button>
		      </div>
		
		      <!-- Modal body -->
		      <div class="modal-body">
		        <a class="btn btn-primary"
		           href="{{route('tests.questions.create', [$test, "question_type"=>'multiple_choice'])}}"
		        >Multiple Choice</a>
		        <a class="btn btn-primary"
		           href="{{route('tests.questions.create', [$test, "question_type"=>'fill_in_the_blank'])}}">Fill in the blank</a>
		      </div>
		
		      <!-- Modal footer -->
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger"
		                data-dismiss="modal">Close</button>
		      </div>
		
		    </div>
			</div>
		</div>