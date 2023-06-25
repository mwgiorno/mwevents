<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
    
          <form x-data="init()" action="{{ route('login') }}" method="post">
            
            <template x-if="errors">
                <div class="text-danger my-1 text-xs" role="alert">
                    <ul class="pl-4" >
                        <template x-for="error in errors">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>
            </template>

            <div class="input-group mb-3">
              <input type="text" x-model="username" class="form-control" placeholder="Username">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" x-model="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12">
                <button @click.prevent="login" type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mt-2">
            <a href="{{ route('register') }}" class="text-center">Do not have an account? Register</a>
          </p>
        </div>
        <!-- /.login-card-body -->
    </div>

    <script>
        function init() {
            return {
                username: '',
                password: '',
                errors: null,
                login() {
                    axios.post('/login', {
                        username: this.username,
                        password: this.password
                    }).then((response) => {
                        window.location.href = '/';
                    }).catch((error) => {
                        this.errors = error.response.data.errors;
                        console.log(error.response.data.errors);
                    });
                }
            };
        }
    </script>
</x-guest-layout>