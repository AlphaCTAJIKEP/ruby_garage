<?php $this->view('containers/header'); ?>

<main>
    <div class="container">
        <ul class="nav nav-tabs" id="LoginTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="logIn-tab" data-toggle="tab" href="#logIn" role="tab" aria-controls="logIn" aria-selected="true">LogIn</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Registration</a>
            </li>
        </ul>
        <div class="tab-content" id="LoginTabContent">
            <div class="tab-pane fade show active" id="logIn" role="tabpanel" aria-labelledby="logIn-tab">
                <form id="sign-form" class="form-signin">
                    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                    <label for="signLogin" class="sr-only">Login</label>
                    <input type="text" id="signLogin" class="form-control" placeholder="Login" required="" autofocus="">
                    <p class="error sign-login__error"></p>
                    <label for="signPassword" class="sr-only">Password</label>
                    <input type="password" id="signPassword" class="form-control" placeholder="Password" required="">
                    <p class="error sign-password__error"></p>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <form id="register-form" class="form-signin">
                    <h1 class="h3 mb-3 font-weight-normal">Please register</h1>
                    <label for="regLogin" class="sr-only">Login</label>
                    <input type="text" id="regLogin" class="form-control" placeholder="Type login" required="" autofocus="">
                    <p class="error reg-login__error"></p>
                    <label for="regPassword" class="sr-only">Password</label>
                    <input type="password" id="regPassword" class="form-control" placeholder="Type password" required="">
                    <p class="error reg-password__error"></p>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
</main>



<?php $this->view('containers/footer'); ?>