@extends('layouts.admin')
@section('section_data')
<section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registration</p>

                                    <form class="mx-1 mx-md-4" action="{{route('user.update', $users->id )}}" method="post" enctype="multipart/form-data">
                                        @method('PUT')
                                       @csrf
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                        
                                                <label class="form-label" for="form3Example1c">Your Name</label>
                                                <input type="text" id="form3Example1c" class="form-control" name="name" value="{{ $users->name }}"/>
                                                <span class="text-danger">
                                                    @error('name')
                                                        {{$message}};
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example3c">Your Email</label>
                                                <input type="email" id="form3Example3c" class="form-control" name="email" value="{{$users->email}}"/>
                                                <span class="text-danger">
                                                @error('email')
                                                        {{$message}};
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c">Password</label>
                                                <input type="password" id="form3Example4c" class="form-control" name="password"/>
                                                <span class="text-danger">
                                                @error('password')
                                                        {{$message}};
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4cd">Roles</label>
                                                @foreach($roles as $_role)
                                                    <div>
                                                        <input type="checkbox" id="<?= $_role->name?>" name="roles[]" value="<?= $_role->name?>" {{($users->hasRole($_role->name))?'checked':''}}>
                                                        <label for="<?= $_role->name?>"><?= $_role->name?></label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4cd">Profile Image</label>
                                                <input type="file" id="profile_image" class="form-control" name="profile_image" value="">
                                                @error('profile_image')
                                                    <span class="text-danger">
                                                        {{$message}};
                                                    </span>
                                                @enderror
                                                <td><img src="{{ $users->getFirstMediaUrl('profile_image') }}" width="120px"></td>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4cd">Banner Image</label>
                                                <input type="file" id="banner_image" class="form-control" name="banner_image"/>
                                                @error('banner_image')
                                                    <span class="text-danger">
                                                        {{$message}};
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <input class="form-check-input me-2" type="checkbox" id="form2Example3c" />
                                            <label class="form-check-label" for="form2Example3">
                                            I agree all statements in <a href="#!">Terms of service</a>
                                            </label>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button class="btn btn-primary btn-lg">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" 
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@endsection


