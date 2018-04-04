@extends("lms::layouts.app")

@section("content")
	<div class="container justify-content-center">
		{!! Breadcrumbs::render('units', $lesson) !!}
		<div class="row">
			<div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
				<div class="card">
		            <div class="card-header bg-primary text-white">
		                Units in Lesson: {{$lesson->title}}
		                <a class="btn btn-sm btn-success pull-right"
		                   href="{{route("lessons.units.create", $lesson)}}">Create new unit</a>
		                </div>
					
					<div class="card-body">
						<order-list inline-template>
							<div class="row">
								<ul class="list-unstyled list-inline col-sm-12">
									<li class="row">
										<div class="col-sm-1"><strong>Order</strong></div>
										<div class="col-sm-7"><strong>Title</strong></div>
										<div class="col-sm-2"><strong>Is Active</strong></div>
										<div class="col-sm-2"><strong>Actions</strong></div>
									</li>
								</ul>
								<ol class="list-unstyled list-inline col-sm-12 units"
								    ref="sotableList">
									@foreach($lesson->getOrderedChildren() as $index=>$unit)
										<li class="row mb-2 p-2 border border-light rounded"
										    data-id="{{$unit->id}}">
											<div class="col-sm-1">{{$index+1}}</div>
												<div class="col-sm-7">{{$unit->getName()}}</div>
												<div class="col-sm-2">
														 @if($unit->is_active)
														<span class="badge badge-success">Active</span>
													@else
														<span class="badge badge-warning">No</span>
													@endif
													</div>
												<div class="col-sm-2">
												<div class="btn-group btn-group-sm"
												     role="group"
												     aria-label="Basic example">
												  <a href="{{route('lessons.units.index', $unit)}}"
												     class="btn btn-primary text-light">Units</a>
												  <a href="{{route('lessons.units.edit', [$lesson, $unit])}}"
												     class="btn btn-info text-light">Edit</a>
												  <button @click.prevent="deleteItem('{{route('lessons.units.destroy', [$lesson, $unit])}}')"
												          class="btn btn-danger text-light">Delete</button>
												</div>
											</div>
										</li>
									@endforeach
								</ol>
								<div class="col-12">
									<button class="btn btn-info btn-block"
									        @click.prevent="updateOrder('{{route('lessons.units.order',$lesson)}}')">Update Order</button>
								</div>
							</div>
						</order-list>
					</div>
		        </div>
		    </div>
		</div>
		
	</div>
@endsection