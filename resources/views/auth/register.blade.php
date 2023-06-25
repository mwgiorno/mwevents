<x-guest-layout>
    <div class="card">
        <div class="card-body register-card-body">
          <p class="login-box-msg">Register a new membership</p>
    
          <form x-data="init()">

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
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" x-model="firstname" class="form-control" placeholder="Firstname">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-pen"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="text" x-model="lastname" class="form-control" placeholder="Lastname">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-pen"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="date" x-model="birthdate" class="form-control" placeholder="Birthdate">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-cake-candles"></span>
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
            <div class="input-group mb-3">
              <input type="password" x-model="password_confirmation" class="form-control" placeholder="Retype password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button @click.prevent="register" type="submit" class="btn btn-primary btn-block">Register</button>
              </div>
            </div>
          </form>
    
          <p class="mt-2">
            <a href="{{ route('login') }}" class="text-center">I already have an account</a>
          </p>
        </div>
      </div>

      <script>
        function init() {
            return {
                username: '',
                firstname: '',
                lastname: '',
                birthdate: '',
                password: '',
                password_confirmation: '',
                errors: null,
                register() {
                    axios.post('/register', {
                        username: this.username,
                        firstname: this.firstname,
                        lastname: this.lastname,
                        birthdate: this.birthdate,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    }).then((response) => {
                        window.location.href = '/';
                    }).catch((error) => {
                        this.errors = error.response.data.errors;
                        console.log(error);
                    });
                }
            };
        }
    </script>
</x-guest-layout>