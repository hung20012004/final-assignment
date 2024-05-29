<x-guest-layout>
    <x-validation-errors class="mb-4" />
    @if (session('password_mismatch'))
        <div class="alert alert-danger">
            {{ session('password_mismatch') }}
        </div>
    @endif
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <x-input id="name" class="form-control form-control-user" type="name" name="name"
                                required autofocus autocomplete="name" placeholder="Enter your name"/>
                            </div>
                            <div class="form-group">
                                <x-input id="email" class="form-control form-control-user" type="email" name="email" :value="old('email')"
                                required autofocus autocomplete="email" placeholder="Enter Email Address"/>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <x-input id="password" type="password" class="form-control form-control-user" name="password"
                                        required autocomplete="new-password" placeholder="Password" />
                                </div>
                                <div class="col-sm-6">
                                    <x-input id="password_confirmation" type="password" class="form-control form-control-user"
                                        name="password_confirmation" required autocomplete="new-password" placeholder="Repeat Password" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                            <hr>
                            <a href="index.html" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> Register with Google
                            </a>
                            <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                            </a>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
