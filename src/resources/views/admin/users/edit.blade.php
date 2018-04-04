@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
        <div class="card">
            <div class="card-body">
	            <user-form :user="{{json_encode($user)}}" inline-template>
                <form method="POST" action="{{ route('users.update', $user) }}"
                      @submit.prevent="submit">
                        {{method_field('put')}}
	                {{csrf_field()}}
	                <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name"
                                       value="{{ old('name')??$user->name }}"
                                       required autofocus>
	                            @if ($errors->has('name'))
		                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
	                            @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email"
                                       value="{{ old('email')??$user->email }}"
                                       required>
	
	                            @if ($errors->has('email'))
		                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
	                            @endif
                            </div>
                        </div>
	                 <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">Supervisor</label>

                            <div class="col-md-6">
                                <vue-select
		                                name="supervisor_id"
		                                label="name"
		                                v-model="supervisor_id"
		                                :options="{{json_encode(App\User::select('name','id')->excludeMe($user)->get())}}"></vue-select>
	
	                            @if ($errors->has('supervisor_id'))
		                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('supervisor_id') }}</strong>
                                    </span>
	                            @endif
                            </div>
                        </div>
                     <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">User Role</label>

                            <div class="col-md-6">
                                <vue-select
		                                multiple
		                                label="label"
		                                v-model="role_ids"
		                                :options="{{json_encode(Anacreation\Lms\Models\Role::get(['label','id']))}}"></vue-select>
	                            @if ($errors->has('role_ids'))
		                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('role_ids') }}</strong>
                                    </span>
	                            @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Update
                                </button>
                                <a href="{{route("users.index")}}"
                                   class="btn btn-info">
                                    Back
                                </a>
                            </div>
                        </div>
                    </form>
	            </user-form>
            </div>
        </div>
        
	</div>
@endsection

