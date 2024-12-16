<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" v-model="form.username" required>
                                    <span v-if="errors.username" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.username[0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="form.password" required>
                                    <span v-if="errors.password" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.password[0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="form.remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                    <a class="btn btn-link" :href="passwordResetRoute">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                username: '',
                password: '',
                remember: false,
            },
            errors: {},
            passwordResetRoute: '{{ route("password.request") }}'
        };
    },
    methods: {
        login() {
            axios.post('/login', this.form)
                .then(response => {
                    window.location = response.data.redirect || '/';
                })
                .catch(error => {
                    console.log(error.response.data); // Log the error response
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        }
    }
};
</script>
